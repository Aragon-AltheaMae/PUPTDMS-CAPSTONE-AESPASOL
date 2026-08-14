<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Support\BrowserDetection;

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

        $deviceDetails = BrowserDetection::deviceDetailsFromRequest(
            Request::instance()
        );

        AuditLog::create([
            'actor_id' => $user?->id,
            'actor_name' => $actorName,
            'actor_role' => $actorRole,
            'actor_identifier' => $actorIdentifier,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'browser_name' => self::supportsBrowserNameColumn()
                ? $deviceDetails['browser_name']
                : null,

            'device_type' => self::supportsDeviceColumns()
                ? $deviceDetails['device_type']
                : null,

            'device_name' => self::supportsDeviceColumns()
                ? $deviceDetails['device_name']
                : null,

            'os_name' => self::supportsDeviceColumns()
                ? $deviceDetails['os_name']
                : null,
        ]);
    }

    private static function supportsBrowserNameColumn(): bool
    {
        static $supportsColumn;

        if ($supportsColumn === null) {
            $supportsColumn = Schema::hasColumn('audit_logs', 'browser_name');
        }

        return $supportsColumn;
    }

    private static function supportsDeviceColumns(): bool
    {
        static $supportsColumns;

        if ($supportsColumns === null) {
            $supportsColumns = Schema::hasColumns('audit_logs', [
                'device_type',
                'device_name',
                'os_name',
            ]);
        }

        return $supportsColumns;
    }
}
