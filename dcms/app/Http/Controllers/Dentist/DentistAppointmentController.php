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
            ->whereDate('appointment_date', '>=', $today)  
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

    public function patientProfile(Appointment $appointment)
    {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }

        $appointment->load('patient');

        $patient = $appointment->patient;

        if (!$patient) {
            return redirect()->route('dentist.appointments')
                ->with('error', 'Patient not found for this appointment.');
        }

        $today = Carbon::today()->toDateString();

        $futureVisits = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', '>=', $today)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $pastVisits = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', '<', $today)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $notifications = collect([]);

        return view('dentist-patientprofile', compact(
            'patient',
            'appointment',
            'futureVisits',
            'pastVisits',
            'notifications'
        ));
    }
}
