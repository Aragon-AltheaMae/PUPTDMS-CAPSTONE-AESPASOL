<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Helpers\AuditLogger;

class AdminDashboardController extends Controller
{
    public function index()
    {
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

        return view('admin.admin-dashboard', compact(
            'totalPatients',
            'appointmentsThisMonth',
            'documentsThisMonth',
            'notifications'
        ));
    }
}
