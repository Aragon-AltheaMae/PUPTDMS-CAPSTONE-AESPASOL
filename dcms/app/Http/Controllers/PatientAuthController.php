<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogger;

class PatientAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $patient = Patient::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'birthdate' => $validated['birthdate'],
            'gender' => $validated['gender'],
            'password' => Hash::make($validated['password']),
        ]);

        AuditLogger::log(
            'register',
            'patient_auth',
            "Patient registered an account"
        );

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::guard('patient')->attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials'])
                ->withInput();
        }

        $request->session()->regenerate();

        $patient = Auth::guard('patient')->user();

        if ($patient) {
            session([
                'patient_id' => $patient->id,
                'role' => 'patient',
            ]);

            AuditLogger::log(
                'login',
                'patient_auth',
                "Patient logged in"
            );
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $patient = Auth::guard('patient')->user();

        if ($patient) {
            AuditLogger::log(
                'logout',
                'patient_auth',
                "Patient logged out"
            );
        }

        Auth::guard('patient')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function dashboard()
    {
        $patient = Auth::guard('patient')->user();

        if ($patient) {
            AuditLogger::log(
                'view',
                'patient_dashboard',
                "Patient viewed dashboard"
            );
        }

        return view('dashboard', compact('patient'));
    }
}
