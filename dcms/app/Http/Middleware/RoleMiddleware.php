<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // role we want to check
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!session()->has('role') || session('role') !== $role) {
            return redirect('/login');
        }

        return $next($request);
    }
}
