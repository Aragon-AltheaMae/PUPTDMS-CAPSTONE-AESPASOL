<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log($action, $module, $description = null)
    {
        $user = Auth::user();

        $actorName = 'Unknown User';
        $actorRole = session('role') ?? 'guest';
        $actorIdentifier = null;

        if ($user) {
            $actorName = $user->name ?? 'Unknown User';
            $actorIdentifier = $user->id;
        }

        if ($actorRole === 'patient') {
            $actorName = session('patient_name') ?? ($user->name ?? 'Unknown Patient');
            $actorIdentifier = session('patient_id') ?? ($user->id ?? null);
        } elseif ($actorRole === 'dentist') {
            $actorName = session('dentist_name') ?? ($user->name ?? 'Unknown Dentist');
            $actorIdentifier = session('dentist_id') ?? ($user->id ?? null);
        } elseif ($actorRole === 'admin' || $actorRole === 'super_admin') {
            $actorName = session('admin_name') ?? ($user->name ?? 'Unknown Admin');
            $actorIdentifier = session('admin_id') ?? ($user->id ?? null);
        }

        AuditLog::create([
            'actor_name' => $actorName,
            'actor_role' => $actorRole,
            'actor_identifier' => $actorIdentifier,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}