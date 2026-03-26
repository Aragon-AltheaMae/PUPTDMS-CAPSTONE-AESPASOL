<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class OIDCController extends Controller
{
    public function redirect(Request $request)
    {
        $loginUrl     = config('services.idp.login_url');
        $authorizeUrl = config('services.oidc.authorize_url');
        $clientId     = config('services.oidc.client_id');
        $redirectUri  = config('services.oidc.redirect');
        $scope        = config('services.oidc.scope', 'openid profile email');

        if (!$clientId || !$redirectUri) {
            return redirect()->route('login')
                ->with('error', 'OIDC provider is not configured properly.');
        }

        $state = Str::random(40);

        session([
            'oidc_state' => $state,
        ]);
        session()->save();

        $query = http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => $scope,
            'state'         => $state,
            'prompt'        => 'login',
        ]);

        if ($loginUrl) {
            $separator = str_contains($loginUrl, '?') ? '&' : '?';
            $fullUrl = $loginUrl . $separator . $query;
        } else {
            $fullUrl = $authorizeUrl . '?' . $query;
        }

        Log::info('OIDC redirect URL', ['url' => $fullUrl]);

        return redirect()->away($fullUrl);
    }

    public function callback(Request $request)
    {
        Log::info('OIDC Callback Debug', [
            'incoming_state' => $request->get('state'),
            'session_state'  => session('oidc_state'),
            'session_id'     => session()->getId(),
            'full_url'       => $request->fullUrl(),
            'all_params'     => $request->all(),
        ]);

        if ($request->has('error')) {
            return redirect()->route('login')->with(
                'error',
                'SSO failed: ' . $request->get('error') . ' - ' . $request->get('error_description', 'Authorization failed.')
            );
        }

        $savedState    = session('oidc_state');
        $incomingState = $request->get('state');

        if (!$savedState) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please try again.');
        }

        if ($incomingState && !hash_equals($savedState, $incomingState)) {
            session()->forget('oidc_state');

            return redirect()->route('login')
                ->with('error', 'Invalid OIDC state. Possible CSRF attack.');
        }

        session()->forget('oidc_state');

        $rawQuery = $request->server('QUERY_STRING');
        parse_str($rawQuery, $rawParams);
        $code = $rawParams['code'] ?? $request->get('code');

        Log::info('OIDC code comparison', [
            'raw_code'     => $rawParams['code'] ?? 'not found',
            'request_code' => $request->get('code'),
            'match'        => ($rawParams['code'] ?? '') === $request->get('code'),
        ]);

        if (!$code) {
            return redirect()->route('login')
                ->with('error', 'Authorization code missing.');
        }

        $tokenResponse = Http::acceptJson()
            ->contentType('application/json')
            ->post(config('services.oidc.token_url'), [
                'client_id'     => config('services.oidc.client_id'),
                'client_secret' => config('services.oidc.client_secret'),
                'code'          => $code,
            ]);

        Log::info('OIDC token request', [
            'token_url' => config('services.oidc.token_url'),
            'payload'   => [
                'client_id'         => config('services.oidc.client_id'),
                'code'              => $code,
                'has_client_secret' => !empty(config('services.oidc.client_secret')),
            ],
            'response_status' => $tokenResponse->status(),
            'response_body'   => $tokenResponse->body(),
        ]);

        if (!$tokenResponse->successful()) {
            $tokenError = $tokenResponse->json();

            return redirect()->route('login')->with(
                'error',
                'Token exchange failed: ' . (
                    $tokenError['error_description']
                    ?? $tokenError['error']
                    ?? $tokenResponse->body()
                    ?? 'Unknown error'
                )
            );
        }

        $tokenData = $tokenResponse->json();

        $accessToken  = $tokenData['access_token'] ?? null;
        $refreshToken = $tokenData['refresh_token'] ?? null;

        if (!$accessToken) {
            return redirect()->route('login')
                ->with('error', 'Access token missing from token response.');
        }

        /** @var Response $profileResponse */
        $profileResponse = Http::withToken($accessToken)
            ->acceptJson()
            ->get(config('services.oidc.me_url'));

        Log::info('OIDC profile response', [
            'status' => $profileResponse->status(),
            'body'   => $profileResponse->body(),
        ]);

        if (!$profileResponse->successful()) {
            $profileError = $profileResponse->json();

            return redirect()->route('login')->with(
                'error',
                'Failed to fetch user profile: ' . (
                    $profileError['error_description']
                    ?? $profileError['error']
                    ?? $profileResponse->body()
                    ?? 'Unknown error'
                )
            );
        }

        $profile = $profileResponse->json();

        $ssoUserId = $profile['id'] ?? $profile['sub'] ?? null;
        $email     = $profile['email'] ?? null;
        $name      = $profile['name'] ?? trim(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? ''));

        Log::info('OIDC PROFILE DEBUG', [
            'profile'    => $profile,
            'ssoUserId'  => $ssoUserId,
            'email'      => $email,
            'name'       => $name,
        ]);

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Email not returned by identity provider.');
        }

        $user = User::where('email', $email)
            ->when($ssoUserId, function ($query) use ($ssoUserId) {
                $query->orWhere('sso_user_id', $ssoUserId);
            })
            ->first();

        if (!$user) {
            $roleName = strtolower($profile['roles'][0] ?? '');

            if (str_contains($roleName, 'admin')) {
                $roleId = Role::where('slug', 'admin')->value('id');
            } elseif (str_contains($roleName, 'dentist')) {
                $roleId = Role::where('slug', 'dentist')->value('id');
            } else {
                $roleId = Role::where('slug', 'patient')->value('id');
            }

            Log::info('ROLE MAPPING DEBUG', [
                'incoming_role'  => $roleName,
                'mapped_role_id' => $roleId,
                'all_roles'      => $profile['roles'] ?? [],
            ]);

            if (!$roleId) {
                return redirect()->route('login')
                    ->with('error', 'No matching local role found for this SSO account.');
            }

            $user = User::create([
                'name'          => $name ?: $email,
                'email'         => $email,
                'role_id'       => $roleId,
                'status'        => 'active',
                'sso_user_id'   => $ssoUserId,
                'last_login_at' => now(),
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken,
            ]);

            Log::info('OIDC user created', [
                'user_id' => $user?->id,
                'email'   => $user?->email,
                'role_id' => $user?->role_id,
            ]);
        }

        $user = User::where('email', $email)
            ->when($ssoUserId, function ($query) use ($ssoUserId) {
                $query->orWhere('sso_user_id', $ssoUserId);
            })
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User creation failed.');
        }

        $patient = Patient::where('email', $email)->first();

        if ($patient && !$patient->user_id) {
            $patient->user_id = $user->id;
            $patient->save();

            Log::info('Patient linked to user', [
                'patient_id' => $patient->id,
                'user_id'    => $user->id,
                'email'      => $email,
            ]);
        }

        $user->name          = $name ?: $user->name;
        $user->email         = $email;
        $user->sso_user_id   = $ssoUserId ?: $user->sso_user_id;
        $user->access_token  = $accessToken;
        $user->refresh_token = $refreshToken;
        $user->last_login_at = now();
        $user->save();

        $jwt = JWTAuth::fromUser($user);

        Cookie::queue(
            Cookie::make(
                'jwt_token',
                $jwt,
                60,
                '/',
                null,
                request()->isSecure(),
                true,
                false,
                'Lax'
            )
        );

        Auth::login($user);

        $roleSlug = optional($user->role)->slug;

        if ($roleSlug === 'patient') {
            $patient = $patient ?: Patient::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if (!$patient) {
                $patient = Patient::create([
                    'user_id'   => $user->id,
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'phone'     => '',
                    'birthdate' => now()->subYears(18)->toDateString(),
                    'gender'    => 'Male',
                    'password'  => Hash::make(Str::random(16)),
                ]);
            }

            session([
                'role'       => 'patient',
                'patient_id' => $patient->id,
                'email'      => $patient->email,
            ]);

            session()->save();

            AuditLogger::log('login', 'authentication', 'Patient logged in via OIDC');

            return redirect()->route('patient.dashboard')
                ->with('login_as', $patient->name)
                ->with('show_terms_modal', true);
        }

        if (in_array($roleSlug, ['admin', 'super_admin'], true)) {
            session([
                'admin_logged_in' => true,
                'role'            => $roleSlug,
                'admin_id'        => $user->id,
                'admin_email'     => $user->email,
            ]);

            AuditLogger::log('login', 'authentication', 'Admin logged in via OIDC');

            return redirect()->route('admin.admin.dashboard')
                ->with('login_as', $user->name)
                ->with('show_terms_modal', true);
        }

        if ($roleSlug === 'dentist') {
            session([
                'role'          => 'dentist',
                'dentist_email' => $user->email,
            ]);

            AuditLogger::log('login', 'authentication', 'Dentist logged in via OIDC');

            return redirect()->route('dentist.dentist.dashboard')
                ->with('login_as', $user->name)
                ->with('show_terms_modal', true);
        }

        Auth::logout();

        return redirect()->route('login')
            ->with('error', 'Your account role is not allowed to log in.');
    }
}