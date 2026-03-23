<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Helpers\AuditLogger;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $perPage = in_array($request->input('per_page'), [10, 20, 50, 100])
            ? (int) $request->input('per_page') : 20;
        $role    = $request->input('role', 'all');
        $search  = $request->input('search');

        // Only log view on normal page loads, not every AJAX poll
        if (!$request->ajax()) {
            AuditLogger::log('view', 'system_logs', 'Admin viewed system logs');
        }

        $query = AuditLog::latest();

        if ($role === 'login') {
            $query->where('action', 'like', '%login%');
        } elseif (in_array($role, ['admin', 'dentist', 'patient'])) {
            $query->where('actor_role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('actor_identifier', 'like', "%{$search}%")
                    ->orWhere('action',          'like', "%{$search}%")
                    ->orWhere('module',           'like', "%{$search}%")
                    ->orWhere('description',      'like', "%{$search}%")
                    ->orWhere('actor_role',       'like', "%{$search}%");
            });
        }

        $logs = $query->paginate($perPage)->withQueryString();

        $totalCount   = AuditLog::count();
        $adminCount   = AuditLog::where('actor_role', 'admin')->count();
        $dentistCount = AuditLog::where('actor_role', 'dentist')->count();
        $patientCount = AuditLog::where('actor_role', 'patient')->count();
        $loginCount   = AuditLog::where('action', 'like', '%login%')->count();

        // ── AJAX response ──────────────────────────────────
        if ($request->ajax()) {
            return response()->json([
                'logs' => $logs->map(function ($log) {
                    return [
                        'id'               => $log->id,
                        'actor_role'       => strtolower($log->actor_role ?? 'other'),
                        'actor_identifier' => $log->actor_identifier ?? '—',
                        'action'           => $log->action ?? '',
                        'module'           => $log->module ?? '',
                        'description'      => $log->description ?? 'No description provided.',
                        'created_at_day'   => optional($log->created_at)->format('M j, Y'),
                        'created_at_time'  => optional($log->created_at)->format('h:i:s A'),
                    ];
                }),
                'pagination' => [
                    'total'        => $logs->total(),
                    'from'         => $logs->firstItem() ?? 0,
                    'to'           => $logs->lastItem()  ?? 0,
                    'current_page' => $logs->currentPage(),
                    'last_page'    => $logs->lastPage(),
                    'per_page'     => $logs->perPage(),
                ],
                'counts' => [
                    'total'   => $totalCount,
                    'admin'   => $adminCount,
                    'dentist' => $dentistCount,
                    'patient' => $patientCount,
                    'login'   => $loginCount,
                ],
            ]);
        }

        return view('admin.system-logs', compact(
            'logs',
            'perPage',
            'role',
            'search',
            'totalCount',
            'adminCount',
            'dentistCount',
            'patientCount',
            'loginCount'
        ));
    }

    public function fetchLatest(Request $request)
    {
        $perPage = in_array($request->input('per_page'), [10, 20, 50, 100])
            ? (int) $request->input('per_page')
            : 20;

        $logs = AuditLog::latest()->take($perPage)->get();

        return response()->json([
            'logs' => $logs->map(function ($log) {
                return [
                    'id'               => $log->id,
                    'actor_role'       => strtolower($log->actor_role ?? 'other'),
                    'actor_identifier' => $log->actor_identifier ?? '—',
                    'action'           => strtolower($log->action ?? ''),
                    'module'           => $log->module ?? '',
                    'description'      => $log->description ?? 'No description provided.',
                    'created_at_day'   => optional($log->created_at)->format('M j, Y'),
                    'created_at_time'  => optional($log->created_at)->format('h:i:s A'),
                ];
            }),
        ]);
    }

    public function checkLatest()
    {
        $latest = AuditLog::latest()->first();

        return response()->json([
            'latest_id' => $latest?->id ?? 0,
            'total'     => AuditLog::count(),
        ]);
    }
}
