<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasSession()) {
            return $next($request);
        }

        $timeoutSeconds = (int) env('SESSION_IDLE_TIMEOUT_SECONDS', 600);

        if ($timeoutSeconds <= 0) {
            return $next($request);
        }

        if (!Auth::check()) {
            $request->session()->forget('last_activity_at');

            return $next($request);
        }

        $now = now()->getTimestamp();
        $lastActivityAt = (int) $request->session()->get('last_activity_at', $now);

        if (!$request->routeIs('logout') && ($now - $lastActivityAt) >= $timeoutSeconds) {
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

            return redirect()->route('login', [
                'logged_out' => 1,
                'reason' => 'idle',
            ]);
        }

        $request->session()->put('last_activity_at', $now);

        return $next($request);
    }
}
