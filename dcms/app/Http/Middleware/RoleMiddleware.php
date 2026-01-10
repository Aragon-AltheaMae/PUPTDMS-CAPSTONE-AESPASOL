<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Patient;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // 1) Check role
        if (!session()->has('role') || session('role') !== $role) {
            return redirect('/login');
        }

        // 2) If patient role, load patient & share to all views
        if ($role === 'patient') {
            $patientId = session('patient_id');

            if (!$patientId) {
                session()->forget('role');
                return redirect('/login');
            }

            $patient = Patient::find($patientId);

            if (!$patient) {
                session()->forget('patient_id');
                session()->forget('role');
                return redirect('/login');
            }

            view()->share('patient', $patient);
        }

        // 3) Continue request
        return $next($request);
    }
}
