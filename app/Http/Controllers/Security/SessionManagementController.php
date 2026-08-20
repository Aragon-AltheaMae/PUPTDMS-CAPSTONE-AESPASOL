<?php

namespace App\Http\Controllers\Security;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ConcurrentSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class SessionManagementController extends Controller
{
    public function __construct(
        private readonly ConcurrentSessionService $concurrentSessionService
    ) {}

    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $currentSessionId = $request->session()->getId();
        $sessions = $this->concurrentSessionService->sessionsForDisplay($user, $currentSessionId);
        $history = $this->concurrentSessionService->recentSessionHistoryForUser($user);
        $role = $this->normalizeRole((string) (session('impersonated_role') ?: optional($user->role)->slug ?: session('role')));

        return view('shared.sessions', [
            'role' => $role,
            'sessions' => $sessions,
            'history' => $history,
            'currentSessionCount' => $sessions->where('is_current', true)->count(),
            'otherSessionsCount' => $sessions->where('is_current', false)->count(),
            'sessionLimit' => $this->concurrentSessionService->getSessionLimitForUser($user),
            'notifications' => collect(),
        ]);
    }

    public function activity(
        Request $request
    ): JsonResponse {
        if (
            (bool) $request->session()->get(
                'session_idle_locked',
                false
            )
        ) {
            return response()->json([
                'expired' => true,
            ], 401);
        }

        $request->session()->put(
            'last_activity_at',
            now()->getTimestamp()
        );

        return response()->json([
            'active' => true,
        ]);
    }

    public function expire(
        Request $request
    ): JsonResponse {
        $this->logoutCurrentSession(
            $request,
            $request->user(),
            false,
            'idle'
        );

        return response()->json([
            'expired' => true,
        ]);
    }

    public function destroy(Request $request, string $reference): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user, 401);

        $revoked = $this->concurrentSessionService->revokeSessionByReference(
            $user,
            $reference,
            $request->session()->getId()
        );

        return back()->with(
            $revoked ? 'success' : 'error',
            $revoked
                ? 'The selected session has been logged out.'
                : 'That session could not be removed. It may already be inactive or belong to another device state.'
        );
    }

    public function destroyOthers(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user, 401);

        $revoked = $this->concurrentSessionService->revokeOtherSessions(
            $user,
            $request->session()->getId(),
            'user_requested_other_session_logout'
        );

        return back()->with(
            $revoked > 0 ? 'success' : 'error',
            $revoked > 0
                ? 'All other active sessions were logged out.'
                : 'No other active sessions were found.'
        );
    }

    public function destroyCurrent(Request $request): RedirectResponse
    {
        $this->logoutCurrentSession($request, $request->user(), false, 'manual');

        return redirect()->route('login', [
            'logged_out' => 1,
            'reason' => 'manual',
        ])->with('success', 'This session has been logged out.');
    }

    public function destroyAll(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user, 401);

        $this->concurrentSessionService->revokeAllSessions($user, null, 'user_requested_global_logout');
        $this->logoutCurrentSession($request, $user, true, 'manual');

        return redirect()->route('login', [
            'logged_out' => 1,
            'reason' => 'manual',
        ])->with('success', 'All devices have been logged out.');
    }

    private function normalizeRole(string $role): string
    {
        return $role === 'super_admin' ? 'admin' : ($role !== '' ? $role : 'patient');
    }

    private function logoutCurrentSession(
        Request $request,
        ?User $user,
        bool $alreadyRevokedAll,
        string $reason
    ): void
    {
        if ($user && !$alreadyRevokedAll) {
            $this->concurrentSessionService->revokeAllSessions(
                $user,
                $request->session()->getId(),
                'user_requested_current_session_logout'
            );
        }

        if ($user) {
            AuditLogger::log(
                'logout',
                'authentication',
                $reason === 'idle'
                    ? 'User was signed out due to inactivity.'
                    : 'User signed out from session management.'
            );
        }

        Cookie::queue(Cookie::forget('jwt_token', '/'));

        Auth::guard('patient')->logout();
        Auth::guard('web')->logout();
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
            'session_idle_locked',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
