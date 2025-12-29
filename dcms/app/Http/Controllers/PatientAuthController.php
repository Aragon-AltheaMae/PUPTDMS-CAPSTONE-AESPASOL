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

    // SAVE ACCOUNT
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:patients',
            'phone' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Account created successfully!');
    }

    // SHOW LOGIN FORM
    public function showLogin()
    {
        return view('auth.login');
    }

    // LOGIN PROCESS
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $patient = Patient::where('email', $credentials['email'])->first();

        if ($patient && Hash::check($credentials['password'], $patient->password)) {
            session(['patient_id' => $patient->id]);
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // LOGOUT
    public function logout()
    {
        session()->forget('patient_id');
        return redirect('/login');
    }
}
