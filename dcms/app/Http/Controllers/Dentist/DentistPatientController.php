<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DentistPatientController extends Controller
{
    public function index()
    {
        // simple session check (same style you used)
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }

        $today = Carbon::today()->toDateString();

        // Fetch upcoming + today appointments, include patient info
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Optional counts for your tabs
        $todayCount = $appointments->where('appointment_date', $today)->count();

        // you don't have "rescheduled" status in DB, so we'll treat pending future as "upcoming"
        // (you can change this later if you add a rescheduled column/status)
        $rescheduledCount = $appointments
            ->where('status', 'pending')
            ->where('appointment_date', '>', $today)
            ->count();

        $allCount = $appointments->count();

        $notifications = []; // keep as-is for now

        $upcomingAppointments = $appointments->filter(function ($a) use ($today) {
            return in_array($a->status, ['pending', 'confirmed', 'rescheduled'], true)
                && $a->appointment_date >= $today;
        });

        $pastAppointments = $appointments->filter(function ($a) use ($today) {
            return in_array($a->status, ['completed', 'cancelled'], true)
                || $a->appointment_date < $today;
        });

        return view('dentist-patient', compact(
            'appointments',
            'todayCount',
            'rescheduledCount',
            'allCount',
            'notifications'
        ));
    }

    public function profile(Patient $patient)
    {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }

        $today = Carbon::today()->toDateString();

        $futureVisits = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', '>=', $today)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $pastVisits = Appointment::where('patient_id', $patient->id)
            ->where(function ($query) use ($today) {
                $query->whereDate('appointment_date', '<', $today)
                    ->orWhere('status', 'completed');
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $totalVisits = $pastVisits->count();
        $lastVisit = $pastVisits->first();
        $nextAppointment = $futureVisits->first();

        $notifications = collect([]);

        return view('dentist-patientprofile', compact(
            'patient',
            'futureVisits',
            'pastVisits',
            'totalVisits',
            'lastVisit',
            'nextAppointment',
            'notifications'
        ));
    }
}
