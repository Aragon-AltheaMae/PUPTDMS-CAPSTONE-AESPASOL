<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;

class HomepageController extends Controller
{
    // Max appointments per day before marking as "Full Schedule"
    const MAX_APPOINTMENTS_PER_DAY = 10;

    public function index()
    {
        $patientId = session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        // Latest completed dental records
        $records = Appointment::where('patient_id', $patientId)
            ->whereIn('status', ['completed', 'Completed'])
            ->latest('appointment_date')
            ->take(5)
            ->get();

        // Next upcoming appointment
        $upcomingAppointment = Appointment::where('patient_id', $patientId)
            ->whereIn('status', ['pending', 'Pending', 'confirmed', 'Confirmed'])
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->first();

        // Patient's own appointments for the year (for calendar dots)
        $appointments = Appointment::where('patient_id', $patientId)
            ->whereYear('appointment_date', now()->year)
            ->get();

        // Count ALL appointments per day clinic-wide (for full schedule detection)
        $appointmentCountsPerDay = Appointment::whereYear('appointment_date', now()->year)
            ->whereNotIn('status', ['cancelled', 'Cancelled', 'rejected', 'Rejected'])
            ->selectRaw('appointment_date, COUNT(*) as total')
            ->groupBy('appointment_date')
            ->pluck('total', 'appointment_date')
            ->toArray();

        // Dates marked as unavailable by admin
        // Replace with a DB query later if you create an unavailable_dates table
        $unavailableDates = [
            // e.g. '2026-03-15', '2026-04-10'
        ];

        // Philippine Public Holidays for current year
        $year = now()->year;
        $philippineHolidays = $this->getPhilippineHolidays($year);

        // Notifications — confirmed upcoming appointments
        $notifications = Appointment::where('patient_id', $patientId)
            ->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['confirmed', 'Confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->get()
            ->map(function ($appt) {
                return [
                    'title'   => 'Appointment Confirmed',
                    'message' => $appt->service_type . ' on ' .
                                 Carbon::parse($appt->appointment_date)->format('M d, Y') .
                                 ' at ' . $appt->appointment_time,
                    'time'    => Carbon::parse($appt->appointment_date)->diffForHumans(),
                    'url'     => route('appointment.index'),
                ];
            });

        return view('homepage', compact(
            'patient',
            'records',
            'upcomingAppointment',
            'appointments',
            'appointmentCountsPerDay',
            'unavailableDates',
            'philippineHolidays',
            'notifications'
        ));
    }

    /**
     * Returns Philippine public holidays for a given year.
     */
    private function getPhilippineHolidays(int $year): array
    {
        $holidays = [
            // Regular Holidays
            "$year-01-01" => "New Year's Day",
            "$year-04-09" => "Araw ng Kagitingan",
            "$year-05-01" => "Labor Day",
            "$year-06-12" => "Independence Day",
            "$year-11-30" => "Bonifacio Day",
            "$year-12-25" => "Christmas Day",
            "$year-12-30" => "Rizal Day",

            // Special Non-Working Holidays
            "$year-02-25" => "EDSA People Power Anniversary",
            "$year-08-21" => "Ninoy Aquino Day",
            "$year-11-01" => "All Saints' Day",
            "$year-11-02" => "All Souls' Day",
            "$year-12-08" => "Feast of the Immaculate Conception",
            "$year-12-24" => "Christmas Eve",
            "$year-12-31" => "New Year's Eve",
        ];

        // Holy Week — computed dynamically from Easter
        $easter    = Carbon::createFromTimestamp(easter_date($year));
        $holidays[$easter->copy()->subDays(4)->format('Y-m-d')] = 'Holy Wednesday';
        $holidays[$easter->copy()->subDays(3)->format('Y-m-d')] = 'Maundy Thursday';
        $holidays[$easter->copy()->subDays(2)->format('Y-m-d')] = 'Good Friday';
        $holidays[$easter->copy()->subDays(1)->format('Y-m-d')] = 'Black Saturday';

        // National Heroes Day = last Monday of August
        $lastMondayAug = Carbon::create($year, 8, 31)->modify('last monday');
        $holidays[$lastMondayAug->format('Y-m-d')] = 'National Heroes Day';

        return $holidays;
    }
}