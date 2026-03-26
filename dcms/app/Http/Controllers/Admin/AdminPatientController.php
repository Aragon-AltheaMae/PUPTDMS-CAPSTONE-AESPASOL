<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminPatientController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $appointments = Appointment::with('patient')
            ->whereHas('patient')
            ->orderByRaw("
                CASE
                    WHEN appointment_date = ? THEN 0
                    WHEN appointment_date > ? THEN 1
                    ELSE 2
                END
            ", [$today, $today])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $todayCount = $appointments->filter(function ($appt) use ($today) {
            $status = strtolower($appt->status ?? '');
            return $appt->appointment_date === $today
                && $status !== 'cancelled'
                && $status !== 'completed';
        })->count();

        $upcomingCount = $appointments->filter(function ($appt) use ($today) {
            $status = strtolower($appt->status ?? '');
            return $appt->appointment_date > $today
                && in_array($status, ['upcoming', 'rescheduled', 'pending', 'confirmed'], true);
        })->count();

        $rescheduledCount = $appointments->filter(function ($appt) {
            return strtolower($appt->status ?? '') === 'rescheduled';
        })->count();

        $cancelledCount = $appointments->filter(function ($appt) {
            return strtolower($appt->status ?? '') === 'cancelled';
        })->count();

        $completedCount = $appointments->filter(function ($appt) {
            return strtolower($appt->status ?? '') === 'completed';
        })->count();

        $allCount = $appointments->count();

        $notifications = []; // palitan later if meron kang notifications query

        return view('admin.admin-patient', compact(
            'appointments',
            'todayCount',
            'upcomingCount',
            'rescheduledCount',
            'cancelledCount',
            'completedCount',
            'allCount',
            'notifications'
        ));
    }

    public function show($patientId)
    {
        $appointments = Appointment::with('patient')
            ->where('patient_id', $patientId)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $patient = optional($appointments->first())->patient;

        if (!$patient) {
            abort(404, 'Patient not found.');
        }

        return view('admin.patient-profile', compact('patient', 'appointments'));
    }
}