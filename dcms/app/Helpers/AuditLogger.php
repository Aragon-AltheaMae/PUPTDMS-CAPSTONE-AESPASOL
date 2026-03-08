<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    public static function log($action, $module, $description = null)
    {
        $role = session('role');

        if (session('admin_logged_in')) {
            $role = 'admin';
        }

        $identifier = null;

        if ($role === 'patient') {
            $identifier = session('patient_id');
        }

        if ($role === 'dentist') {
            $identifier = session('dentist_email');
        }

        if ($role === 'admin') {
            $identifier = 'admin';
        }

        AuditLog::create([
            'actor_role' => $role ?? 'guest',
            'actor_identifier' => $identifier,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}