<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class DentistAppointmentController extends Controller
{
    public function index()
    {
        // same session style you use
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }

        $today = Carbon::today()->toDateString();

        // Fetch all appointments with patient info
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Upcoming appointments (today and future) + statuses you consider upcoming
        $upcomingAppointments = $appointments->filter(function ($a) use ($today) {
            return in_array($a->status, ['pending', 'confirmed', 'rescheduled'], true)
                && $a->appointment_date >= $today;
        })->values();

        // Past appointments (completed/cancelled OR date already passed)
        $pastAppointments = $appointments->filter(function ($a) use ($today) {
            return in_array($a->status, ['completed', 'cancelled'], true)
                || $a->appointment_date < $today;
        })->values();

        $notifications = collect($notifications ?? []);

        return view('dentist-appointments', compact(
            'appointments',
            'upcomingAppointments',
            'pastAppointments',
            'today',
            'notifications'
        ));
    }
}