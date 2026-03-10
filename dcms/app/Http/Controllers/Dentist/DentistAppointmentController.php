<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            return in_array($a->status, ['upcoming', 'rescheduled'], true)
                && $a->appointment_date >= $today;
        })->values();

        // Past appointments (completed/cancelled OR date already passed)
        $pastAppointments = Appointment::with('patient')
            ->where(function ($q) use ($today) {
                $q->whereIn('status', ['completed', 'cancelled'])
                    ->orWhereDate('appointment_date', '<', $today);
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $notifications = collect($notifications ?? []);

        return view('dentist.dentist-appointments', compact(
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

    $lastVisit = $pastVisits->first();
    $nextAppointment = $futureVisits->first();
    $totalVisits = $pastVisits->count() + $futureVisits->count();

    $notifications = collect([]);

        return view('dentist.dentist-patientprofile', compact(
            'patient',
            'appointment',
            'futureVisits',
            'pastVisits',
            'notifications'
        ));
    }
    return view('dentist-patientprofile', compact(
        'patient',
        'appointment',
        'futureVisits',
        'pastVisits',
        'lastVisit',
        'nextAppointment',
        'totalVisits',
        'notifications'
    ));
}

    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if (!in_array($appointment->status, ['upcoming', 'rescheduled', 'pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'This appointment cannot be cancelled.',
            ], 422);
        }

        $appointment->update(['status' => 'cancelled']);

        return response()->json(['success' => true]);
    }
}
