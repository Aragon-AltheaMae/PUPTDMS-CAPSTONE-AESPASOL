<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class SystemLogController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $logs = AuditLog::latest()->paginate(20);

        return view('admin.system-logs', compact('logs'));
    }
}