<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Helpers\AuditLogger;

class SystemLogController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        AuditLogger::log(
            'view',
            'system_logs',
            'Admin viewed system logs'
        );

        $logs = AuditLog::latest()->paginate(20);

        return view('admin.system-logs', compact('logs'));
    }

    public function fetchLatest()
    {
        $logs = AuditLog::latest()->take(50)->get();

        return response()->json([
            'logs' => $logs->map(function ($log) {
                return [
                    'id' => $log->id,
                    'actor_role' => strtolower($log->actor_role ?? 'other'),
                    'actor_identifier' => $log->actor_identifier ?? '—',
                    'action' => strtolower($log->action ?? ''),
                    'module' => $log->module ?? '',
                    'description' => $log->description ?? 'No description provided.',
                    'created_at_day' => optional($log->created_at)->format('M j, Y'),
                    'created_at_time' => optional($log->created_at)->format('h:i:s A'),
                ];
            }),
        ]);
    }
}
