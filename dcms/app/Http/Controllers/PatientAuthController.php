<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientAuthController extends Controller
{
    // SHOW REGISTER FORM
    public function showRegister()
    {
        return view('auth.register'); // ✅ keep views consistent
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

    // LOGIN PROCESS
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $patient = Patient::where('email', $request->email)->first();

        if (!$patient || !Hash::check($request->password, $patient->password)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials'])
                ->withInput();
        }

        session()->regenerate(); // ✅ prevent session fixation
        session(['patient_id' => $patient->id]);

        return redirect('/dashboard');
    }

    // LOGOUT
    public function logout()
    {
        session()->forget('patient_id');
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function dashboard()
{
    // Check if patient is logged in
    $patientId = session('patient_id');
    if (!$patientId) {
        return redirect()->route('login')->with('error', 'Please login first!');
    }

    // Fetch patient from DB
    $patient = Patient::find($patientId);

    return view('dashboard', compact('patient'));
}
}
