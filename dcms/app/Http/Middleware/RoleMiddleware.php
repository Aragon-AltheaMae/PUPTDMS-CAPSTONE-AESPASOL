<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Patient;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        // If admin is impersonating, use that role for route checks
        $userRole = session('impersonated_role') ?: session('role');

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        // If viewing as patient, make sure patient data exists
        if ($userRole === 'patient') {

            $patientId = session('impersonated_patient_id') ?: session('patient_id');

            if (!$patientId) {
                // If this is an impersonation session, don't destroy admin login
                if (session()->has('impersonator_role')) {
                    return redirect()->route('admin.admin.dashboard')
                        ->with('error', 'No patient selected for impersonation.');
                }

                session()->forget(['role', 'patient_id']);
                return redirect('/login');
            }

            $patient = Patient::find($patientId);

            if (!$patient) {
                if (session()->has('impersonator_role')) {
                    return redirect()->route('admin.admin.dashboard')
                        ->with('error', 'Impersonated patient was not found.');
                }

                session()->forget(['role', 'patient_id']);
                return redirect('/login');
            }

            view()->share('patient', $patient);
        }

        return $next($request);
    }
}