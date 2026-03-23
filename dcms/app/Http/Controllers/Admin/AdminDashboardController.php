<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\AuditLog;
use App\Helpers\AuditLogger;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        AuditLogger::log(
            'view',
            'admin_dashboard',
            'Admin viewed the dashboard'
        );
        
        $now = Carbon::now();

        $totalPatients = Patient::count();

        $appointmentsThisMonth = Appointment::whereYear('appointment_date', $now->year)
            ->whereMonth('appointment_date', $now->month)
            ->count();

        $documentsThisMonth = \App\Models\DocumentRequest::whereYear('request_date', $now->year)
            ->whereMonth('request_date', $now->month)
            ->where('status', 'approved')
            ->count();

        $notifications = [];

        $recentLogs = AuditLog::latest()->take(5)->get()->map(function ($log) {
            return $log;
        });

        $logThisMonth = AuditLog::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $logInfo = AuditLog::where('action', 'view')->count();

        $logWarnings = AuditLog::where('action', 'login')->count();

        $logBackups = AuditLog::where('action', 'backup')->count();

        $logErrors = AuditLog::where('action', 'error')->count();

        return view('admin.admin-dashboard', compact(
            'totalPatients',
            'appointmentsThisMonth',
            'documentsThisMonth',
            'notifications',
            'recentLogs',
            'logThisMonth',
            'logInfo',
            'logWarnings',
            'logBackups',
            'logErrors'
        ));
    }
}
