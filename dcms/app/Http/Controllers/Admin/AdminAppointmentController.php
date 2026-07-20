<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class AdminAppointmentController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $appointments = Appointment::with(['patient'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $todayCount = $appointments->filter(function ($appt) use ($today) {
            $status = strtolower($appt->status ?? '');
            return $appt->appointment_date === $today
                && !in_array($status, ['cancelled', 'completed'], true);
        })->count();

        $upcomingCount = $appointments->filter(function ($appt) use ($today) {
            $status = strtolower($appt->status ?? '');
            return $appt->appointment_date > $today
                && in_array($status, ['upcoming', 'pending', 'confirmed', 'rescheduled'], true);
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

        $upcomingAppointments = $appointments->filter(function ($appt) use ($today) {
            $status = strtolower($appt->status ?? '');
            return $appt->appointment_date >= $today
                && !in_array($status, ['cancelled', 'completed'], true);
        });

        $pastAppointments = $appointments->filter(function ($appt) use ($today) {
            $status = strtolower($appt->status ?? '');
            return $appt->appointment_date < $today
                || in_array($status, ['completed', 'cancelled'], true);
        });

        return view('shared.appointments', [
            'layoutRole' => 'admin',
            'pageTitle' => 'Appointment Management',
            'pageShellClass' => 'admin-page-shell',

            'isDentistView' => false,

            'canStartProcedure' => false,
            'canRescheduleAppointment' => false,
            'canCancelAppointment' => false,
            'canViewTreatmentRecord' => false,
            'canScheduleFollowUp' => false,

            'patientProfileRouteName' => 'admin.admin.patient.profile',

            'appointments' => $appointments,
            'upcomingAppointments' => $upcomingAppointments,
            'pastAppointments' => $pastAppointments,

            'today' => $today,

            'todayCount' => $todayCount,
            'upcomingCount' => $upcomingCount,
            'rescheduledCount' => $rescheduledCount,
            'cancelledCount' => $cancelledCount,
            'completedCount' => $completedCount,
            'allCount' => $allCount,

            'appointmentCountsPerDay' => [],
            'appointmentCountsPerSlot' => [],
            'calendarAppointmentDetails' => [],
            'schedules' => collect(),
            'blockedDates' => [],
            'philippineHolidays' => [],
            'defaultServiceTypes' => collect(),
            'notifications' => collect(),
        ]);
    }
}
