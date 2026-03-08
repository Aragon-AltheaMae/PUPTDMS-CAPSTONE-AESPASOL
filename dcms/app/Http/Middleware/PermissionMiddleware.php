<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // 1. Check if logged in via session
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $roleSlug = session('role');

        // 2. Find role from roles table
        $role = Role::with('permissions')->where('slug', $roleSlug)->first();

        if (!$role) {
            abort(403, 'No valid role assigned.');
        }

        // 3. Check if role has the required permission
        $hasPermission = $role->permissions->contains('slug', $permission);

        if (!$hasPermission) {
            abort(403, 'Unauthorized.');
        }

        // 4. Continue request
        return $next($request);
    }
}