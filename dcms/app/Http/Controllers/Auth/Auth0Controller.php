<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth0Controller extends Controller
{
    public function redirect()
    {
        return Socialite::driver('auth0')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $auth0User = Socialite::driver('auth0')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication failed: ' . $e->getMessage());
        }

        $email = $auth0User->getEmail() ?? $auth0User->getNickname();
        if (!$email) {
            return redirect()->route('login')->with('error', 'Email not provided by Auth0.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $patientRole = Role::where('slug', 'patient')->first();

            $user = User::create([
                'name' => $auth0User->getName() ?? $auth0User->getNickname() ?? 'Unknown',
                'email' => $email,
                'password' => bcrypt(str()->random(32)),
                'role_id' => $patientRole?->id,
                'status' => 'active',
                'sso_user_id' => $auth0User->getId(),
                'access_token' => $auth0User->token,
                'refresh_token' => $auth0User->refreshToken ?? null,
                'last_login_at' => now(),
            ]);
        }

        $user->name = $auth0User->getName() ?? $user->name;
        $user->sso_user_id = $auth0User->getId() ?? $user->sso_user_id;
        $user->access_token = $auth0User->token;
        $user->refresh_token = $auth0User->refreshToken ?? $user->refresh_token;
        $user->last_login_at = now();
        $user->save();

        $jwt = JWTAuth::fromUser($user);

        Cookie::queue(
            Cookie::make('jwt_token', $jwt, 60, '/', null, true, true, false, 'Strict')
        );

        Auth::login($user);


        $roleSlug = optional($user->role)->slug ?? 'patient';

        if (in_array($roleSlug, ['admin', 'super_admin'], true)) {
            AuditLogger::log('login', 'authentication', 'Admin logged in via Auth0');
            return redirect()->route('admin.admin.dashboard')->with('show_terms_modal', true);
        }

        if ($roleSlug === 'dentist') {
            AuditLogger::log('login', 'authentication', 'Dentist logged in via Auth0');
            return redirect()->route('dentist.dentist.dashboard')->with('show_terms_modal', true);
        }

        if ($roleSlug === 'patient') {
            AuditLogger::log('login', 'authentication', 'Patient logged in via Auth0');
            return redirect()->route('homepage')->with('show_terms_modal', true);
        }

        Auth::logout();

        return redirect()->route('login')->with('error', 'Your account role is not permitted via Auth0 login.');
    }
}
