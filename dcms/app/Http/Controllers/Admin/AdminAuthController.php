<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogger;


class AdminAuthController extends Controller
{
    // Show admin login page
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

    // Handle admin login
    // public function login(Request $request)
    // {
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     // Hardcoded admin credentials
    //     if ($email === 'admin' && $password === 'admin123') {

    //         session([
    //             'admin_logged_in' => true,
    //             'role' => 'super_admin',
    //             'admin_id' => 1,
    //             'admin_email' => $email,
    //         ]);

    //         AuditLogger::log(
    //             'login',
    //             'authentication',
    //             'Admin logged into the system'
    //         );

    //         return redirect()->route('admin.admin.dashboard');
    //     }

    //     return back()->with('error', 'Invalid admin credentials');
    // }

    // Logout
//     public function logout(Request $request)
//     {
//         $baseLogoutUrl = config('services.oidc.logout_url');
//         $clientId      = config('services.oidc.client_id');
//         $returnTo      = route('admin.login');
//         $idToken       = session('oidc_id_token');

//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         if (!$baseLogoutUrl) {
//             return redirect()->route('admin.login');
//         }

//         $params = [
//             'post_logout_redirect_uri' => $returnTo,
//             'client_id' => $clientId,
//         ];

//         if (!empty($idToken)) {
//             $params['id_token_hint'] = $idToken;
//         }

//         return redirect()->away($baseLogoutUrl . '?' . http_build_query($params));
//     }
// }
