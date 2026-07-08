<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\AcademicPeriod;
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
        
        $notifications = [];

        $recentLogs = AuditLog::latest()->take(5)->get()->map(function ($log) {
            return $log;
        });

        $logThisMonth = AuditLog::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $logInfo = AuditLog::where('action', 'view')->count();

        $logWarnings = AuditLog::where('action', 'login')->count();

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
            'logErrors',
            'activePeriod',
            'holidays',
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
