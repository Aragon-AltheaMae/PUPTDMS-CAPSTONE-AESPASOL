<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use App\Services\ConcurrentSessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\AuditLogger;

class PatientAuthController extends Controller
{
    public function __construct(
        private readonly ConcurrentSessionService $concurrentSessionService
    ) {}

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email|unique:users,email',
            'phone' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            $hashedPassword = Hash::make($validated['password']);
            $patientRole = Role::where('slug', 'patient')->first();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $hashedPassword,
                'role_id' => $patientRole?->id,
                'status' => 'active',
            ]);

            Patient::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'birthdate' => $validated['birthdate'],
                'gender' => $validated['gender'],
                // Keep patient password synced for compatibility, but users.password is the source of truth.
                'password' => $hashedPassword,
            ]);
        });

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

        $user = User::with(['role', 'patient'])
            ->where('email', $credentials['email'])
            ->first();

        if (!$user || !$user->hasRole('patient')) {
            return back()
                ->withErrors(['email' => 'Invalid credentials'])
                ->withInput();
        }

        if (($user->status ?? 'inactive') !== 'active') {
            return back()
                ->withErrors(['email' => 'Your account is inactive.'])
                ->withInput();
        }

        if (!filled($user->password) || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials'])
                ->withInput();
        }

        $patient = $user->patient ?: Patient::where('email', $user->email)->first();

        if (!$patient) {
            return back()
                ->withErrors(['email' => 'Patient record not found for this account.'])
                ->withInput();
        }

        if ($patient->password !== $user->password) {
            $patient->forceFill([
                'password' => $user->password,
            ])->save();
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        session([
            'patient_id' => $patient->id,
            'role' => 'patient',
        ]);

        $sessionResult = $this->concurrentSessionService->enforceLimitForCurrentSession(
            $user,
            $request->session()->getId()
        );

        AuditLogger::log(
            'login',
            'patient_auth',
            "Patient logged in"
        );

        session()->flash('show_terms_modal', true);

        $redirect = redirect()->route('patient.dashboard');

        if (($sessionResult['terminated_sessions'] ?? 0) > 0) {
            $redirect->with(
                'success',
                'Logged in successfully. Older active session(s) were closed for your account.'
            );
        }

        return $redirect;
    }

    public function logout(Request $request)
    {
        $patient = Auth::user()?->patient;

        if ($patient) {
            AuditLogger::log(
                'logout',
                'patient_auth',
                "Patient logged out"
            );
        }

        Auth::guard('patient')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function dashboard()
    {
        $patient = Auth::user()?->patient;

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
