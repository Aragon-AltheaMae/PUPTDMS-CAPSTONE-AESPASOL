<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Patient;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage example in routes:
     * ->middleware('role:super_admin')
     * ->middleware('role:dentist')
     * ->middleware('role:patient')
     * ->middleware('role:super_admin,dentist')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if user has role session
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $userRole = session('role');

        // 2. Check if role is allowed
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        /**
         * 3. If patient role, automatically load patient
         * and share to all views
         */
        if ($userRole === 'patient') {

            $patientId = session('patient_id');

            if (!$patientId) {
                session()->forget(['role', 'patient_id']);
                return redirect('/login');
            }

            $patient = Patient::find($patientId);

            if (!$patient) {
                session()->forget(['role', 'patient_id']);
                return redirect('/login');
            }

            // share patient data globally to blade
            view()->share('patient', $patient);
        }

        /**
         * 4. Continue request
         */
        return $next($request);
    }
}