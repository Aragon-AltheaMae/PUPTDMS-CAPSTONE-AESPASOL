<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientAuthController extends Controller
{
    // SHOW REGISTER FORM
    public function showRegister()
    {
        return view('auth.register');
    }

    // REGISTER PATIENT
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

        Patient::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'birthdate' => $validated['birthdate'],
            'gender' => $validated['gender'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    // SHOW LOGIN FORM
    public function showLogin()
    {
        return view('auth.login');
    }

    // ✅ LOGIN USING AUTH:PATIENT
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

        return redirect()->route('dashboard');
    }

    // ✅ LOGOUT USING AUTH:PATIENT
    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    // DASHBOARD
    public function dashboard()
    {
        $patient = Auth::guard('patient')->user();

        return view('dashboard', compact('patient'));
    }
}
