<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class DentistDashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $calendarAppointments = Appointment::with('patient')
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // COUNT PER DAY
        $appointmentCountsPerDay = $calendarAppointments
            ->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();

        // FULL DETAILS PER DAY
        $calendarAppointmentDetails = $calendarAppointments
            ->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->map(function ($appointment) {
                    $name = $appointment->patient->name ?? 'Unknown Patient';

                    $time = !empty($appointment->appointment_time)
                        ? Carbon::parse($appointment->appointment_time)->format('h:i A')
                        : '—';

                    $service = $appointment->service_type === 'others'
                        ? ($appointment->other_services ?? 'Other Service')
                        : ($appointment->service_type ?? 'General Service');

                    return [
                        'id' => $appointment->id,
                        'name' => $name,
                        'time' => $time,
                        'service' => ucwords($service),
                        'status' => $appointment->status ?? 'pending',
                        'date' => Carbon::parse($appointment->appointment_date)->format('Y-m-d'),
                    ];
                })->values()->toArray();
            })
            ->toArray();

        return view('dentist.dentist-dashboard', compact(
            'appointmentCountsPerDay',
            'calendarAppointmentDetails'
        ));
    }
}
