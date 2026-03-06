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

    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'This appointment cannot be cancelled.',
            ], 422);
        }

        $appointment->update(['status' => 'cancelled']);

        return response()->json(['success' => true]);
    }
}
