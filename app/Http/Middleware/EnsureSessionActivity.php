<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionActivity
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (!$request->hasSession()) {
            return $next($request);
        }

        $timeoutSeconds = max(
            0,
            (int) config(
                'session.idle_timeout_seconds',
                600
            )
        );

        if ($timeoutSeconds <= 0) {
            return $next($request);
        }

        if (!Auth::check()) {
            $request->session()->forget([
                'last_activity_at',
                'session_idle_locked',
            ]);

            return $next($request);
        }

        if ($this->isExemptFromIdleTimeout($request)) {
            $request->session()->forget([
                'last_activity_at',
                'session_idle_locked',
            ]);

            return $next($request);
        }

        if (
            $request->routeIs([
                'logout',
                'session.expire',
            ])
        ) {
            return $next($request);
        }

        if (
            $request->routeIs([
                'login',
                'backup.login',
                'oidc.redirect',
                'oidc.callback',
            ])
        ) {
            return $next($request);
        }

        $now = now()->getTimestamp();

        if (
            !$request->session()->has(
                'last_activity_at'
            )
        ) {
            $request->session()->put(
                'last_activity_at',
                $now
            );
        }

        $lastActivityAt = (int) $request
            ->session()
            ->get(
                'last_activity_at',
                $now
            );

        $alreadyLocked = (bool) $request
            ->session()
            ->get(
                'session_idle_locked',
                false
            );

        $hasTimedOut =
            ($now - $lastActivityAt) >=
            $timeoutSeconds;

        if ($alreadyLocked || $hasTimedOut) {
            $request->session()->put(
                'session_idle_locked',
                true
            );

            if (
                $request->expectsJson() ||
                $request->ajax()
            ) {
                return response()->json([
                    'expired' => true,
                    'message' =>
                    'Your session has expired due to inactivity.',
                ], 401);
            }

            if ($request->isMethod('GET')) {
                $request->attributes->set(
                    'session_idle_expired',
                    true
                );

                return $next($request);
            }

            return response()->json([
                'expired' => true,
                'message' =>
                'Your session has expired due to inactivity.',
            ], 401);
        }

        return $next($request);
    }

    private function isExemptFromIdleTimeout(Request $request): bool
    {
        $activeRole = strtolower(trim((string) (
            $request->session()->get('impersonated_role')
                ?: $request->session()->get('role')
                ?: optional($request->user()?->role)->slug
        )));

        $exemptRoles = array_map(
            static fn (mixed $role): string => strtolower(trim((string) $role)),
            (array) config('session.idle_timeout_exempt_roles', [])
        );

        return in_array($activeRole, $exemptRoles, true);
    }
}
