<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ConcurrentSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackupLoginController extends Controller
{
    public function __construct(
        private readonly ConcurrentSessionService $concurrentSessionService
    ) {}

    public function show()
    {
        return view('auth.backup-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::with('role')
            ->where('email', $credentials['email'])
            ->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'No local account associated with this email.');
        }

        if (($user->status ?? 'inactive') !== 'active') {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Your local account is inactive. Please contact the administrator.');
        }

        $roleSlug = optional($user->role)->slug;

        if ($roleSlug !== 'admin') {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Local login is restricted to admin accounts only. Patients and dentists must sign in through the IdP.');
        }

        if (!filled($user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'No local backup password is set for this admin account yet.');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password for backup login.');
        }

        Auth::guard('web')->login($user);

        $request->session()->regenerate();
        $request->session()->put('role', $roleSlug);
        $request->session()->forget(['patient_id', 'dentist_id', 'dentist_email']);
        $request->session()->put('admin_id', $user->id);
        $request->session()->put('admin_email', $user->email);

        $sessionResult = $this->concurrentSessionService->enforceLimitForCurrentSession(
            $user,
            $request->session()->getId()
        );

        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        AuditLogger::log(
            'login',
            'authentication',
            'Admin logged in via backup login'
        );

        $redirect = redirect()->route('admin.admin.dashboard')
            ->with('login_as', $user->name ?: $user->email);

        if (($sessionResult['terminated_sessions'] ?? 0) > 0) {
            $redirect->with(
                'success',
                'Logged in successfully. Older active session(s) were closed for your account.'
            );
        }

        return $redirect;
    }
}
