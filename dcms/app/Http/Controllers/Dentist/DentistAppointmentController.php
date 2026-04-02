<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\AuditLogger;
use App\Models\BlockedDate;
use App\Models\ClinicSchedule;
use App\Helpers\PhilippineHolidays;

class DentistAppointmentController extends Controller
{
    public function index()
    {
        // same session style you use

        $activeRole = session('impersonated_role') ?: session('role');

        if ($activeRole !== 'dentist') {
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

        AuditLogger::log(
            'view',
            'dentist_appointments',
            "Dentist viewed appointments page"
        );

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
        $activeRole = session('impersonated_role') ?: session('role');

        if ($activeRole !== 'dentist') {
            return redirect('/login');
        }

        $appointment->load('patient');
        $patient = $appointment->patient;

        $patient = $appointment->patient;

        if (!$patient) {
            return redirect()->route('dentist.dentist.appointments')
                ->with('error', 'Patient not found for this appointment.');
        }

        AuditLogger::log(
            'view',
            'dentist_patients',
            "Dentist viewed patient profile"
        );

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
            'lastVisit',
            'nextAppointment',
            'totalVisits',
            'notifications'
        ));
    }

    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if (!in_array($appointment->status, ['upcoming', 'rescheduled'])) {
            return response()->json([
                'success' => false,
                'message' => 'This appointment cannot be cancelled.',
            ], 422);
        }

        $appointment->update(['status' => 'cancelled']);

        AuditLogger::log(
            'update',
            'dentist_appointments',
            "Dentist cancelled an appointment"
        );

        return response()->json(['success' => true]);
    }

    public function reschedule($id)
    {
        $activeRole = session('impersonated_role') ?: session('role');

        if ($activeRole !== 'dentist') {
            return redirect('/login');
        }

        $appointment = Appointment::with('patient')->findOrFail($id);

        $appointmentCountsPerDay = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $appointmentCountsPerSlot = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_date, appointment_time, COUNT(*) as count')
            ->groupBy('appointment_date', 'appointment_time')
            ->get()
            ->groupBy('appointment_date')
            ->map(function ($rows) {
                return $rows->pluck('count', 'appointment_time')->toArray();
            })
            ->toArray();

        $schedules = ClinicSchedule::active()->orderBy('id')->get()
        ->map(function ($s) {
            $s->days = is_string($s->days) ? json_decode($s->days, true) : $s->days;
            return $s;
        });

        $blockedDates = BlockedDate::pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        $philippineHolidays = PhilippineHolidays::range(0, 1);

        $notifications = collect([]);

        AuditLogger::log(
            'view',
            'dentist_appointments',
            "Dentist opened reschedule appointment page"
        );

        return view('dentist.dentist-reschedule', compact(
            'appointment',
            'appointmentCountsPerDay',
            'appointmentCountsPerSlot',
            'schedules',
            'blockedDates',
            'philippineHolidays',
            'notifications'
        ));
    }

    public function updateReschedule(Request $request, $id)
    {
        $request->validate([
            'new_appointment_date' => 'required|date|after:today',
            'new_appointment_time' => 'required',
            'service_type' => 'required|string',
        ]);

        if (Carbon::parse($request->new_appointment_date)->isToday()) {
            return response()->json([
                'success' => false,
                'message' => 'Same-day rescheduling is not allowed. Please choose a future date.',
            ], 422);
        }

        $appointment = Appointment::findOrFail($id);

        $mysqlTime = Carbon::createFromFormat('g:i A', trim($request->new_appointment_time))->format('H:i:s');

        $slotTaken = Appointment::where('appointment_date', $request->new_appointment_date)
            ->where('appointment_time', $mysqlTime)
            ->where('id', '!=', $id)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->exists();

        if ($slotTaken) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, that time slot is already taken. Please choose another time.',
            ], 422);
        }

        $appointment->update([
            'appointment_date' => $request->new_appointment_date,
            'appointment_time' => $mysqlTime,
            'service_type' => $request->service_type,
            'status' => 'rescheduled',
        ]);

        AuditLogger::log(
            'update',
            'dentist_appointments',
            "Dentist rescheduled an appointment"
        );

        return response()->json(['success' => true]);
    }
}
