<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (Auth::check() && (Auth::user()?->status ?? 'inactive') !== 'active') {
            Auth::guard('patient')->logout();
            Auth::guard('web')->logout();
            Auth::logout();

            $request->session()->forget([
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

            abort(403, 'You no longer have access.');
        }

        if (!session()->has('role')) {
            return redirect('/login');
        }

        $originalRoleSlug = session('role');
        $activeRoleSlug = session('impersonated_role') ?: $originalRoleSlug;

        if ($originalRoleSlug === 'super_admin') {
            return $next($request);
        }

        $role = Role::with('permissions')->where('slug', $activeRoleSlug)->first();

        if (!$role) {
            abort(403, 'No valid role assigned.');
        }

        $hasPermission = $role->permissions->contains('slug', $permission);

        if (!$hasPermission) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
