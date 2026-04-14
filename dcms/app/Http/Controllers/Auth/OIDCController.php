<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\ExternalAdminAccess;
use App\Models\Faculty;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class OIDCController extends Controller
{
    public function redirect(Request $request)
    {
        $loginUrl     = config('services.idp.login_url');
        $authorizeUrl = config('services.oidc.authorize_url');
        $clientId     = config('services.oidc.client_id');
        $redirectUri  = config('services.oidc.redirect');
        $scope        = config('services.oidc.scope', 'openid profile email');

        if (!$clientId || !$redirectUri) {
            return redirect()->route('login')
                ->with('error', 'OIDC provider is not configured properly.');
        }

        $state = Str::random(40);

        session([
            'oidc_state' => $state,
        ]);
        session()->save();

        $query = http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => $scope,
            'state'         => $state,
            'prompt'        => 'login',
        ]);

        if ($loginUrl) {
            $separator = str_contains($loginUrl, '?') ? '&' : '?';
            $fullUrl = $loginUrl . $separator . $query;
        } else {
            $fullUrl = $authorizeUrl . '?' . $query;
        }

        Log::info('OIDC redirect URL', ['url' => $fullUrl]);

        return redirect()->away($fullUrl);
    }

    public function callback(Request $request)
    {
        Log::info('OIDC Callback Debug', [
            'incoming_state' => $request->get('state'),
            'session_state'  => session('oidc_state'),
            'session_id'     => session()->getId(),
            'full_url'       => $request->fullUrl(),
            'all_params'     => $request->all(),
        ]);

        if ($request->has('error')) {
            return redirect()->route('login')->with(
                'error',
                'SSO failed: ' . $request->get('error') . ' - ' . $request->get('error_description', 'Authorization failed.')
            );
        }

        $savedState    = session('oidc_state');
        $incomingState = $request->get('state');

        if (!$savedState) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please try again.');
        }

        if ($incomingState && !hash_equals($savedState, $incomingState)) {
            session()->forget('oidc_state');

            return redirect()->route('login')
                ->with('error', 'Invalid OIDC state. Possible CSRF attack.');
        }

        session()->forget('oidc_state');

        $rawQuery = $request->server('QUERY_STRING');
        parse_str($rawQuery, $rawParams);
        $code = $rawParams['code'] ?? $request->get('code');

        Log::info('OIDC code comparison', [
            'raw_code'     => $rawParams['code'] ?? 'not found',
            'request_code' => $request->get('code'),
            'match'        => ($rawParams['code'] ?? '') === $request->get('code'),
        ]);

        if (!$code) {
            return redirect()->route('login')
                ->with('error', 'Authorization code missing.');
        }

        /** @var Response $tokenResponse */
        $tokenResponse = Http::acceptJson()
            ->contentType('application/json')
            ->post(config('services.oidc.token_url'), [
                'client_id'     => config('services.oidc.client_id'),
                'client_secret' => config('services.oidc.client_secret'),
                'code'          => $code,
            ]);

        Log::info('OIDC token request', [
            'token_url' => config('services.oidc.token_url'),
            'payload'   => [
                'client_id'         => config('services.oidc.client_id'),
                'code'              => $code,
                'has_client_secret' => !empty(config('services.oidc.client_secret')),
            ],
            'response_status' => $tokenResponse->status(),
            'response_body'   => $tokenResponse->body(),
        ]);

        if (!$tokenResponse->successful()) {
            $tokenError = $tokenResponse->json();

            return redirect()->route('login')->with(
                'error',
                'Token exchange failed: ' . (
                    $tokenError['error_description']
                    ?? $tokenError['error']
                    ?? $tokenResponse->body()
                    ?? 'Unknown error'
                )
            );
        }

        $tokenData = $tokenResponse->json();

        $accessToken  = $tokenData['access_token'] ?? null;
        $refreshToken = $tokenData['refresh_token'] ?? null;

        if (!$accessToken) {
            return redirect()->route('login')
                ->with('error', 'Access token missing from token response.');
        }

        /** @var Response $profileResponse */
        $profileResponse = Http::withToken($accessToken)
            ->acceptJson()
            ->get(config('services.oidc.me_url'));

        Log::info('OIDC profile response', [
            'status' => $profileResponse->status(),
            'body'   => $profileResponse->body(),
        ]);

        if (!$profileResponse->successful()) {
            $profileError = $profileResponse->json();

            return redirect()->route('login')->with(
                'error',
                'Failed to fetch user profile: ' . (
                    $profileError['error_description']
                    ?? $profileError['error']
                    ?? $profileResponse->body()
                    ?? 'Unknown error'
                )
            );
        }

        $profile = $profileResponse->json();

        $ssoUserId  = $profile['id'] ?? $profile['sub'] ?? null;
        $email      = $profile['email'] ?? null;
        $firstName  = trim((string) ($profile['first_name'] ?? ''));
        $middleName = trim((string) ($profile['middle_name'] ?? ''));
        $lastName   = trim((string) ($profile['last_name'] ?? ''));
        $suffixName = trim((string) ($profile['name_suffix'] ?? ''));

        $nameParts = array_filter([$firstName, $middleName, $lastName, $suffixName], fn ($value) => $value !== '');
        $fullName  = trim(implode(' ', $nameParts));
        $name      = $profile['name'] ?? ($fullName !== '' ? $fullName : $email);

        Log::info('OIDC PROFILE DEBUG', [
            'profile'      => $profile,
            'ssoUserId'    => $ssoUserId,
            'email'        => $email,
            'name'         => $name,
            'first_name'   => $firstName,
            'middle_name'  => $middleName,
            'last_name'    => $lastName,
            'suffix_name'  => $suffixName,
        ]);

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Email not returned by identity provider.');
        }

        $user = User::where('email', $email)
            ->when($ssoUserId, function ($query) use ($ssoUserId) {
                $query->orWhere('sso_user_id', $ssoUserId);
            })
            ->first();

        $incomingRoles = $profile['roles'] ?? [];

        if (is_string($incomingRoles)) {
            $incomingRoles = $incomingRoles ? [$incomingRoles] : [];
        }

        $roleSlug = null;

        foreach ($incomingRoles as $incomingRole) {
            $incomingRole = strtolower((string) $incomingRole);

            if (str_contains($incomingRole, 'dentist')) {
                $roleSlug = 'dentist';
                break;
            }

            if (str_contains($incomingRole, 'admin')) {
                $roleSlug = 'admin';
            }
        }

        if (!$roleSlug) {
            $roleSlug = 'patient';
        }

        $assignedAccess = ExternalAdminAccess::where('email', $email)
            ->orWhere('external_admin_id', (string) $ssoUserId)
            ->first();

        $facultyAccess = Faculty::with(['user.role'])
            ->whereHas('user', function ($query) use ($email, $ssoUserId) {
                $query->where('email', $email);

                if ($ssoUserId) {
                    $query->orWhere('sso_user_id', $ssoUserId);
                }
            })
            ->first();

        if ($assignedAccess) {
            if (($assignedAccess->cms_status ?? 'inactive') !== 'active') {
                return redirect()->route('login')
                    ->with('error', 'Your CMS access is inactive. Contact administrator.');
            }

            if (!empty($assignedAccess->cms_role)) {
                $roleSlug = $assignedAccess->cms_role;
            }
        } elseif ($facultyAccess && $facultyAccess->user) {
            if (($facultyAccess->user->status ?? 'inactive') !== 'active') {
                return redirect()->route('login')
                    ->with('error', 'Your CMS access is inactive. Contact administrator.');
            }

            if (!empty($facultyAccess->user->role?->slug)) {
                $roleSlug = $facultyAccess->user->role->slug;
            }
        }

        $roleId = Role::where('slug', $roleSlug)->value('id');

        Log::info('ROLE MAPPING DEBUG', [
            'incoming_roles'        => $incomingRoles,
            'mapped_role'           => $roleSlug,
            'mapped_role_id'        => $roleId,
            'assigned_access_id'    => $assignedAccess?->id,
            'assigned_cms_role'     => $assignedAccess?->cms_role,
            'assigned_cms_status'   => $assignedAccess?->cms_status,
            'faculty_access_id'     => $facultyAccess?->id,
            'faculty_user_id'       => $facultyAccess?->user?->id,
            'faculty_user_role'     => $facultyAccess?->user?->role?->slug,
            'faculty_user_status'   => $facultyAccess?->user?->status,
        ]);

        if (!$roleId) {
            return redirect()->route('login')
                ->with('error', 'No matching local role found for this SSO account.');
        }

        if (!$user) {
            $user = User::create([
                'name'          => $name ?: $email,
                'first_name'    => $firstName !== '' ? $firstName : null,
                'middle_name'   => $middleName !== '' ? $middleName : null,
                'last_name'     => $lastName !== '' ? $lastName : null,
                'suffix_name'   => $suffixName !== '' ? $suffixName : null,
                'email'         => $email,
                'role_id'       => $roleId,
                'status'        => 'active',
                'sso_user_id'   => $ssoUserId,
                'last_login_at' => now(),
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken,
            ]);

            Log::info('OIDC user created', [
                'user_id' => $user?->id,
                'email'   => $user?->email,
                'role_id' => $user?->role_id,
            ]);
        }

        $user = User::where('email', $email)
            ->when($ssoUserId, function ($query) use ($ssoUserId) {
                $query->orWhere('sso_user_id', $ssoUserId);
            })
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User creation failed.');
        }

        $patient = Patient::where('email', $email)->first();

        if ($patient && !$patient->user_id) {
            $patient->user_id = $user->id;
            $patient->save();

            Log::info('Patient linked to user', [
                'patient_id' => $patient->id,
                'user_id'    => $user->id,
                'email'      => $email,
            ]);
        }

        $user->name          = $name ?: $user->name ?: $email;
        $user->first_name    = $firstName !== '' ? $firstName : $user->first_name;
        $user->middle_name   = $middleName !== '' ? $middleName : $user->middle_name;
        $user->last_name     = $lastName !== '' ? $lastName : $user->last_name;
        $user->suffix_name   = $suffixName !== '' ? $suffixName : $user->suffix_name;
        $user->email         = $email;
        $user->role_id       = $roleId;
        $user->sso_user_id   = $ssoUserId ?: $user->sso_user_id;
        $user->access_token  = $accessToken;
        $user->refresh_token = $refreshToken;
        $user->last_login_at = now();
        $user->status        = 'active';
        $user->save();

        $jwt = JWTAuth::fromUser($user);

        Cookie::queue(
            Cookie::make(
                'jwt_token',
                $jwt,
                60,
                '/',
                null,
                request()->isSecure(),
                true,
                false,
                'Lax'
            )
        );

        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        session()->save();

        $roleSlug = optional($user->role)->slug;

        if ($roleSlug === 'patient') {
            $patient = $patient ?: Patient::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if (!$patient) {
                $patient = Patient::create([
                    'user_id'   => $user->id,
                    'name'      => $user->name ?: $name ?: $email,
                    'email'     => $user->email,
                    'phone'     => '',
                    'birthdate' => now()->subYears(18)->toDateString(),
                    'gender'    => 'Male',
                    'password'  => Hash::make(Str::random(16)),
                ]);
            }

            session([
                'role'         => 'patient',
                'patient_id'   => $patient->id,
                'patient_name' => $patient->name,
                'email'        => $patient->email,
            ]);

            session()->save();

            AuditLogger::log('login', 'authentication', 'Patient logged in via OIDC');

            return redirect()->route('homepage')
                ->with('login_as', $patient->name)
                ->with('show_terms_modal', true);
        }

        if (in_array($roleSlug, ['admin', 'super_admin'], true)) {
            session([
                'admin_logged_in' => true,
                'role'            => $roleSlug,
                'admin_id'        => $user->id,
                'admin_name'      => $user->name ?: $name ?: $email,
                'admin_email'     => $user->email,
            ]);

            session()->save();

            AuditLogger::log('login', 'authentication', 'Admin logged in via OIDC');

            return redirect()->route('admin.admin.dashboard')
                ->with('login_as', $user->name ?: $name ?: $email)
                ->with('show_terms_modal', true);
        }

        if ($roleSlug === 'dentist') {
            session([
                'role'          => 'dentist',
                'dentist_id'    => $user->id,
                'dentist_name'  => $user->name ?: $name ?: $email,
                'dentist_email' => $user->email,
            ]);

            session()->save();

            AuditLogger::log('login', 'authentication', 'Dentist logged in via OIDC');

            return redirect()->route('dentist.dentist.dashboard')
                ->with('login_as', $user->name ?: $name ?: $email)
                ->with('show_terms_modal', true);
        }

        Auth::logout();

        return redirect()->route('login')
            ->with('error', 'Your account role is not allowed to log in.');
    }
}