<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplySystemModes
{
    public function handle(Request $request, Closure $next): Response
    {
        $debugMode = SystemSetting::getSetting('debug_mode', '0') === '1';
        config(['app.debug' => $debugMode]);

        $maintenanceMode = SystemSetting::getSetting('maintenance_mode', '0') === '1';

        if ($maintenanceMode && !$this->shouldBypassMaintenance($request)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The system is currently under maintenance. Please try again later.',
                ], 503);
            }

            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }

    private function shouldBypassMaintenance(Request $request): bool
    {
        return $request->is('admin')
            || $request->is('admin/*')
            || $request->is('login')
            || $request->is('register')
            || $request->is('logout')
            || $request->is('debug-session')
            || $request->is('auth/oidc/*');
    }
}