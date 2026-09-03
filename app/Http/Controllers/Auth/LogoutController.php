<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ConcurrentSessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    public function __construct(
        private readonly ConcurrentSessionService $concurrentSessionService
    ) {}

    public function logout(Request $request)
    {
        $user = Auth::user();
        $idToken = (string) $request->session()->get('oidc_id_token', '');
        $reason = $request->input('reason') === 'idle' ? 'idle' : 'manual';

        if (!$user) {
            if (session('admin_id')) {
                $user = User::find(session('admin_id'));
            } elseif (session('email')) {
                $user = User::where('email', session('email'))->first();
            }
        }

        $idpLogoutUrl = config('services.oidc.logout_url');
        $idpLoginUrl = config('services.idp.login_url');
        $clientId = config('services.oidc.client_id');
        $postLogoutRedirect = route('login', [
            'logged_out' => 1,
            'reason' => $reason,
        ]);

        if ($user) {
            $user->access_token = null;
            $user->refresh_token = null;
            $user->save();
        }

        Cookie::queue(Cookie::forget('jwt_token', '/'));

        if ($user) {
            $this->concurrentSessionService->recordLogoutActivity($user, $reason);
        } else {
            AuditLogger::log(
                'logout',
                'authentication',
                $reason === 'idle'
                    ? 'User was signed out due to inactivity.'
                    : 'User logged out of the system (global logout)'
            );
        }

        Auth::guard('patient')->logout();
        Auth::logout();
        $request->session()->forget([
            'oidc_id_token',
            'oidc_state',
            'role',
            'patient_id',
            'patient_name',
            'email',
            'admin_logged_in',
            'admin_id',
            'admin_name',
            'admin_email',
            'dentist_id',
            'dentist_name',
            'dentist_email',
            'impersonated_role',
            'impersonated_patient_id',
            'impersonator_role',
            'impersonator_admin_id',
            'impersonator_admin_email',
            'last_activity_at',
        ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($idpLogoutUrl && $clientId) {
            $logoutTargets = $this->buildLogoutTargets(
                $idpLogoutUrl,
                $idpLoginUrl,
                $clientId,
                $postLogoutRedirect,
                $idToken
            );

            return view('auth.oidc-logout', [
                'logoutTargets' => $logoutTargets,
                'redirectUrl' => $postLogoutRedirect,
                'loginRedirectUrl' => $postLogoutRedirect,
            ]);
        }

        return redirect()->to($postLogoutRedirect);
    }

    protected function buildLogoutTargets(
        string $idpLogoutUrl,
        ?string $idpLoginUrl,
        string $clientId,
        string $postLogoutRedirect,
        string $idToken
    ): array {
        $params = [
            'client_id' => $clientId,
            'post_logout_redirect_uri' => $postLogoutRedirect,
            'redirect_uri' => $postLogoutRedirect,
        ];

        if ($idToken !== '') {
            $params['id_token_hint'] = $idToken;
        }

        $targets = [];

        $targets[] = $this->appendQuery($idpLogoutUrl, $params);

        if ($idpLoginUrl) {
            $origin = parse_url($idpLoginUrl, PHP_URL_SCHEME) . '://' . parse_url($idpLoginUrl, PHP_URL_HOST);

            if ($origin && !str_contains($origin, '://')) {
                $origin = null;
            }

            if ($origin) {
                $targets[] = $this->appendQuery($origin . '/logout', $params);
            }
        }

        return array_values(array_unique(array_filter($targets)));
    }

    protected function appendQuery(string $url, array $params): string
    {
        $separator = str_contains($url, '?') ? '&' : '?';

        return $url . $separator . http_build_query(array_filter($params, static fn($value) => $value !== null));
    }
}
