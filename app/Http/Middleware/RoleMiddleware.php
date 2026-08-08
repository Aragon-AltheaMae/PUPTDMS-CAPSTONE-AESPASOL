<?php

namespace App\Http\Middleware;

use App\Models\Patient;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (($user?->status ?? 'inactive') !== 'active') {
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

        // If admin is impersonating, use impersonated role first
        $userRole = session('impersonated_role') ?: optional($user->role)->slug;

        if ($userRole === 'super_admin' && in_array('admin', $roles, true)) {
            return $next($request);
        }

        if (!$userRole || !in_array($userRole, $roles, true)) {
            abort(403, 'Unauthorized access.');
        }

        // If viewing as patient, make sure patient data exists
        if ($userRole === 'patient') {
            $patientId = session('impersonated_patient_id') ?: session('patient_id');

            if (!$patientId) {
                if (session()->has('impersonator_role')) {
                    return redirect()->route('admin.admin.dashboard')
                        ->with('error', 'No patient selected for impersonation.');
                }

                Auth::logout();
                session()->forget(['role', 'patient_id']);
                return redirect('/login');
            }

            $patient = Patient::find($patientId);

            if (!$patient) {
                if (session()->has('impersonator_role')) {
                    return redirect()->route('admin.admin.dashboard')
                        ->with('error', 'Impersonated patient was not found.');
                }

                Auth::logout();
                session()->forget(['role', 'patient_id']);
                return redirect('/login');
            }

            view()->share('patient', $patient);
        }

        return $next($request);
    }
}
