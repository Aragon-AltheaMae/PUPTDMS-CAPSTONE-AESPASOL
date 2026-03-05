<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;

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

        // All appointments for this patient (calendar)
        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Upcoming appointment (nearest from today onwards)
        $nowDate = now()->toDateString();
        $nowTime = now()->format('H:i:s');

        $upcomingAppointment = Appointment::where('patient_id', $patient->id)
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

        // Philippine holidays for current year to +4 years
        $currentYear = now()->year;
        $philippineHolidays = [];
        for ($year = $currentYear; $year <= $currentYear + 4; $year++) {
            $philippineHolidays = array_merge($philippineHolidays, $this->getPhilippineHolidays($year));
        }

        // ✅ IMPORTANT: Make homepage records EXACTLY SAME as record page
        $records = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Notifications
        $notifications = [];

        return view('index', compact(
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

    private function getPhilippineHolidays(int $year): array
    {
        $holidays = [
            "$year-01-01" => "New Year's Day",
            "$year-04-09" => "Day of Valor",
            "$year-05-01" => "Labor Day",
            "$year-06-12" => "Independence Day",
            "$year-11-30" => "Bonifacio Day",
            "$year-12-25" => "Christmas Day",
            "$year-12-30" => "Rizal Day",

            "$year-02-25" => "EDSA People Power Anniversary",
            "$year-08-21" => "Ninoy Aquino Day",
            "$year-11-01" => "All Saints' Day",
            "$year-11-02" => "All Souls' Day",
            "$year-12-08" => "Feast of the Immaculate Conception",
            "$year-12-24" => "Christmas Eve",
            "$year-12-31" => "New Year's Eve",
        ];

        $easter = Carbon::createFromTimestamp(easter_date($year));
        $holidays[$easter->copy()->subDays(4)->format('Y-m-d')] = 'Holy Wednesday';
        $holidays[$easter->copy()->subDays(3)->format('Y-m-d')] = 'Maundy Thursday';
        $holidays[$easter->copy()->subDays(2)->format('Y-m-d')] = 'Good Friday';
        $holidays[$easter->copy()->subDays(1)->format('Y-m-d')] = 'Black Saturday';

        $lastMondayAug = Carbon::create($year, 8, 31)->modify('last monday');
        $holidays[$lastMondayAug->format('Y-m-d')] = 'National Heroes Day';

        return $holidays;
    }
}