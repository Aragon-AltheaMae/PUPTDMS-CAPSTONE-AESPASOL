<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\AcademicPeriod;
use App\Models\Backup;
use App\Models\SystemSetting;
use App\Models\Inventory;
use Carbon\Carbon;
use App\Models\AuditLog;
use App\Helpers\AuditLogger;
use App\Helpers\PhilippineHolidays;

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

        $inventoryItems = Inventory::get();

            $inventoryTotal = $inventoryItems->count();
            $inventoryMedicine = $inventoryItems->where('category', 'Medicine')->count();
            $inventorySupplies = $inventoryItems->where('category', 'Supplies')->count();
            $inventoryLowStock = $inventoryItems->filter(fn($item) => $item->balance > 0 && $item->balance <= 5)->count();
            $inventoryOutOfStock = $inventoryItems->filter(fn($item) => $item->balance <= 0)->count();
            $inventoryInStock = $inventoryItems->filter(fn($item) => $item->balance > 5)->count();

            $inventoryCriticalItems = $inventoryItems
                ->filter(fn($item) => $item->balance <= 5)
                ->sortBy('balance')
                ->take(5)
                ->values();
        
        $lastBackup = Backup::where('status', 'completed')
            ->latest('created_at')
            ->first();

        $totalBackups = Backup::count();

        $autoBackupEnabled = filter_var(
            SystemSetting::getSetting('auto_backup_enabled', '1'),
            FILTER_VALIDATE_BOOLEAN
        );

        $dailyEnabled = filter_var(
            SystemSetting::getSetting('backup_schedule_daily_enabled', '1'),
            FILTER_VALIDATE_BOOLEAN
        );

        $dailyTime = SystemSetting::getSetting('backup_schedule_daily_time', '02:00');

        $weeklyEnabled = filter_var(
            SystemSetting::getSetting('backup_schedule_weekly_enabled', '1'),
            FILTER_VALIDATE_BOOLEAN
        );

        $weeklyTime = SystemSetting::getSetting('backup_schedule_weekly_time', '00:00');

        $monthlyEnabled = filter_var(
            SystemSetting::getSetting('backup_schedule_monthly_enabled', '0'),
            FILTER_VALIDATE_BOOLEAN
        );

        $monthlyTime = SystemSetting::getSetting('backup_schedule_monthly_time', '00:00');

        $nextBackupDate = null;

        if ($autoBackupEnabled) {
            $candidates = [];

            if ($dailyEnabled) {
                $dailyCandidate = Carbon::today()->setTimeFromTimeString($dailyTime);
                if ($dailyCandidate->lte($now)) {
                    $dailyCandidate->addDay();
                }
                $candidates[] = $dailyCandidate;
            }

            if ($weeklyEnabled) {
                $weeklyCandidate = Carbon::now()->startOfDay()->next(Carbon::SUNDAY)->setTimeFromTimeString($weeklyTime);

                if ($now->isSunday()) {
                    $todayWeekly = Carbon::today()->setTimeFromTimeString($weeklyTime);
                    $weeklyCandidate = $todayWeekly->gt($now)
                        ? $todayWeekly
                        : Carbon::today()->next(Carbon::SUNDAY)->setTimeFromTimeString($weeklyTime);
                }

                $candidates[] = $weeklyCandidate;
            }

            if ($monthlyEnabled) {
                $monthlyCandidate = Carbon::create(
                    $now->year,
                    $now->month,
                    1,
                    (int) substr($monthlyTime, 0, 2),
                    (int) substr($monthlyTime, 3, 2),
                    0
                );

                if ($monthlyCandidate->lte($now)) {
                    $monthlyCandidate->addMonth()->day(1);
                }

                $candidates[] = $monthlyCandidate;
            }

            if (!empty($candidates)) {
                $nextBackupDate = collect($candidates)->sort()->first();
            }
        }

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

        $activePeriod = AcademicPeriod::where('is_active', true)
            ->orderByDesc('start_date')
            ->first();

        $holidays = PhilippineHolidays::range(1, 1);

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
            'logErrors',
            'activePeriod',
            'holidays',
            'lastBackup',
            'totalBackups',
            'autoBackupEnabled',
            'nextBackupDate',
            'inventoryTotal',
            'inventoryMedicine',
            'inventorySupplies',
            'inventoryLowStock',
            'inventoryOutOfStock',
            'inventoryInStock',
            'inventoryCriticalItems'
        ));
    }
}
