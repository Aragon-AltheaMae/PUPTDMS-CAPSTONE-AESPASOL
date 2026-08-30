<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $appointments = Appointment::with([
            'patient',
            'procedure',
            'followUpAppointments',
        ])
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

        if ($request->expectsJson()) {
            $appointments = $upcomingAppointments
                ->merge($pastAppointments)
                ->map(fn($appointment) => [
                    'id' => $appointment->id,
                    'updated_at' => optional($appointment->updated_at)->toISOString(),
                ])
                ->values();

            return response()->json([
                'appointments' => $appointments,
            ]);
        }

        return view('shared.appointments', [
            'layoutRole' => 'admin',
            'pageTitle' => 'Appointment Management',
            'pageShellClass' => 'app-page-shell',

            'isDentistView' => false,

            'canStartProcedure' => false,
            'canRescheduleAppointment' => $user?->hasPermission('reschedule_appointments') ?? false,
            'canCancelAppointment' => $user?->hasPermission('cancel_appointments') ?? false,
            'canViewTreatmentRecord' => $user?->hasPermission('view_dental_records') ?? false,
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
