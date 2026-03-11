<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use App\Helpers\PhilippineHolidays;
use App\Helpers\AuditLogger;

class HomepageController extends Controller
{
    const MAX_APPOINTMENTS_PER_DAY = 5;

    public function index()
    {
        $patientId = session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        AuditLogger::log(
            'view',
            'patient_dashboard',
            "Patient viewed homepage"
        );
        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Upcoming appointment (nearest from today onwards)
        $nowDate = now()->toDateString();
        $nowTime = now()->format('H:i:s');

        $upcomingAppointment = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->where(function ($q) use ($nowDate, $nowTime) {
                $q->where('appointment_date', '>', $nowDate)
                    ->orWhere(function ($q2) use ($nowDate, $nowTime) {
                        $q2->where('appointment_date', '=', $nowDate)
                            ->where('appointment_time', '>=', $nowTime);
                    });
            })
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->first();

        // Count appointments per day for the calendar
        $appointmentCountsPerDay = Appointment::selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        // Unavailable dates
        $unavailableDates = [];

        $philippineHolidays = PhilippineHolidays::range(0, 4);

        $records = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Notifications
        $notifications = [];

        return view('patient.index', compact(
            'patient',
            'appointments',
            'upcomingAppointment',
            'appointmentCountsPerDay',
            'unavailableDates',
            'philippineHolidays',
            'records',
            'notifications'
        ));
    }
}
