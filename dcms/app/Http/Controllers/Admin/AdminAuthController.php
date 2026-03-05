<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Show admin login page
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    // Handle admin login
    public function login(Request $request)
{
    $email = $request->input('email');
    $password = $request->input('password');

    // Hardcoded admin credentials
    if ($email === 'admin' && $password === 'admin123') {

        // store admin session
        session(['admin_logged_in' => true]);

        return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Invalid admin credentials');
}

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}