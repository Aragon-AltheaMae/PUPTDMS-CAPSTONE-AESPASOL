<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Cookie::queue(Cookie::forget('jwt_token', '/'));

        AuditLogger::log(
            'logout',
            'authentication',
            'User logged out of the system'
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
// use this for idp logout 
//     public function logout(Request $request)
//     {
//         $idpLogoutUrl = config('services.oidc.logout_url');
//         $clientId     = config('services.oidc.client_id');
//         $returnTo     = route('admin.login');
//         $idToken      = session('oidc_id_token');

//         Cookie::queue(Cookie::forget('jwt_token', '/'));

//         AuditLogger::log(
//             'logout',
//             'authentication',
//             'User logged out of the system'
//         );

//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         if (!$idpLogoutUrl) {
//             return redirect()->route('admin.login');
//         }

//         $params = [
//             'post_logout_redirect_uri' => $returnTo,
//             'client_id' => $clientId,
//         ];

//         if (!empty($idToken)) {
//             $params['id_token_hint'] = $idToken;
//         }

//         return redirect()->away($idpLogoutUrl . '?' . http_build_query($params));
//     }
// }