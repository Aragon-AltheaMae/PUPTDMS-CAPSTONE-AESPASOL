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

        // If admin is impersonating, use impersonated role first
        $userRole = session('impersonated_role') ?: optional($user->role)->slug;

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