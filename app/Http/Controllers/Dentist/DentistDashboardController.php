<?php

namespace App\Http\Controllers\Dentist;

use App\Helpers\PhilippineHolidays;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BlockedDate;
use App\Models\ClinicSchedule;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DentistDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        $todayAppointments = Appointment::with('patient')
            ->whereDate('appointment_date', $today)
            ->whereIn('status', ['upcoming', 'rescheduled', 'pending', 'confirmed'])
            ->orderBy('appointment_time', 'asc')
            ->get();

        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        $calendarAppointments = Appointment::with('patient')
            ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', [
                'pending',
                'confirmed',
                'upcoming',
                'rescheduled',
                'completed',
            ])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $appointmentCountsPerDay = $calendarAppointments
            ->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();

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

                        'patientProfileUrl' => $appointment->patient_id
                            ? route('dentist.dentist.patient.profile', $appointment->patient_id)
                            : '#',

                        'rescheduleUrl' => route(
                            'dentist.dentist.appointments.reschedule.update',
                            $appointment->id
                        ),

                        'cancelUrl' => route(
                            'dentist.dentist.appointments.cancel',
                            $appointment->id
                        ),
                    ];
                })->values()->toArray();
            })
            ->toArray();

        $dashboardAppointmentWindow = Appointment::with('patient')
            ->whereBetween('appointment_date', [
                Carbon::today()->subDays(90)->toDateString(),
                Carbon::today()->addDays(90)->toDateString(),
            ])
            ->whereIn('status', [
                'upcoming',
                'rescheduled',
                'completed',
                'cancelled',
            ])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $dashboardAppointmentDetails = $dashboardAppointmentWindow
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
                        'status' => $appointment->status ?? 'upcoming',
                        'date' => Carbon::parse($appointment->appointment_date)->format('Y-m-d'),

                        'patientPhotoUrl' =>
                        optional($appointment->patient)->profile_photo_url
                            ?? optional($appointment->patient)->profile_picture_url
                            ?? optional($appointment->patient)->avatar_url
                            ?? optional($appointment->patient)->photo_url
                            ?? '',

                        'patientProfileUrl' => $appointment->patient_id
                            ? route('dentist.dentist.patient.profile', $appointment->patient_id)
                            : '#',

                        'rescheduleUrl' => route(
                            'dentist.dentist.appointments.reschedule.update',
                            $appointment->id
                        ),

                        'cancelUrl' => route(
                            'dentist.dentist.appointments.cancel',
                            $appointment->id
                        ),
                    ];
                })->values()->toArray();
            })
            ->toArray();

        $dentalCasesThisMonth = Appointment::whereYear('appointment_date', $now->year)
            ->whereMonth('appointment_date', $now->month)
            ->where('status', 'completed')
            ->count();

        $lastMonth = $now->copy()->subMonth();

        $dentalCasesLastMonth = Appointment::whereYear(
            'appointment_date',
            $lastMonth->year
        )
            ->whereMonth('appointment_date', $lastMonth->month)
            ->where('status', 'completed')
            ->count();

        $dentalCasesDelta = $dentalCasesLastMonth > 0
            ? round(
                (($dentalCasesThisMonth - $dentalCasesLastMonth)
                    / $dentalCasesLastMonth) * 100
            )
            : null;

        $totalApptsThisMonth = Appointment::whereYear(
            'appointment_date',
            $now->year
        )
            ->whereMonth('appointment_date', $now->month)
            ->whereIn('status', [
                'upcoming',
                'rescheduled',
                'completed',
                'cancelled',
                'pending',
                'confirmed',
            ])
            ->count();

        $totalApptsLastMonth = Appointment::whereYear(
            'appointment_date',
            $lastMonth->year
        )
            ->whereMonth('appointment_date', $lastMonth->month)
            ->whereIn('status', [
                'pending',
                'confirmed',
                'upcoming',
                'rescheduled',
                'completed',
                'cancelled',
            ])
            ->count();

        $totalApptsDelta = $totalApptsLastMonth > 0
            ? round(
                (($totalApptsThisMonth - $totalApptsLastMonth)
                    / $totalApptsLastMonth) * 100
            )
            : null;

        $medicalSupplies = DB::table('inventory_items')
            ->where('category', 'Supplies')
            ->orderByRaw('(qty - used) ASC')
            ->limit(3)
            ->get();

        $medicineSupplies = DB::table('inventory_items')
            ->where('category', 'Medicine')
            ->orderByRaw('(qty - used) ASC')
            ->limit(3)
            ->get();

        $gadRaw = DB::table('daily_treatment_records')
            ->whereYear('treatment_date', $now->year)
            ->whereMonth('treatment_date', $now->month)
            ->select(
                'office_type',
                'gender',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('office_type', 'gender')
            ->get();

        $gadLabels = [
            'Student',
            'Administrative',
            'Faculty',
            'Dependent',
        ];

        $gadFemale = [];
        $gadMale = [];

        foreach ($gadLabels as $label) {
            $key = $label === 'Student'
                ? null
                : $label;

            $gadFemale[] = (int) $gadRaw
                ->where('office_type', $key)
                ->where('gender', 'Female')
                ->sum('total');

            $gadMale[] = (int) $gadRaw
                ->where('office_type', $key)
                ->where('gender', 'Male')
                ->sum('total');
        }

        $blockedDates = BlockedDate::pluck('date')
            ->map(
                fn($date) =>
                Carbon::parse($date)->toDateString()
            )
            ->toArray();

        $philippineHolidays = PhilippineHolidays::range(
            yearsBefore: 1,
            yearsAfter: 5
        );

        $schedules = ClinicSchedule::active()
            ->orderBy('id')
            ->get()
            ->map(function ($schedule) {
                $schedule->days = is_string($schedule->days)
                    ? json_decode($schedule->days, true)
                    : $schedule->days;

                return $schedule;
            })
            ->toArray();

        $clinicStatus = strtolower(
            (string) SystemSetting::getSetting(
                'clinic_status',
                'in'
            )
        );

        $notifications = collect([]);

        return view('dentist.dentist-dashboard', compact(
            'todayAppointments',
            'appointmentCountsPerDay',
            'calendarAppointmentDetails',
            'dashboardAppointmentDetails',
            'blockedDates',
            'philippineHolidays',
            'schedules',
            'notifications',

            'dentalCasesThisMonth',
            'dentalCasesDelta',
            'totalApptsThisMonth',
            'totalApptsDelta',

            'medicalSupplies',
            'medicineSupplies',

            'gadLabels',
            'gadFemale',
            'gadMale',

            'clinicStatus'
        ));
    }
    public function updateClinicStatus(Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:in,out'],
        ]);

        $oldStatus = SystemSetting::getSetting('clinic_status', 'in');
        $newStatus = strtolower($request->status);

        SystemSetting::setSetting(
            'clinic_status',
            $newStatus,
            'clinic'
        );

        if ($oldStatus !== 'out' && $newStatus === 'out') {
            SystemSetting::setSetting(
                'clinic_status_out_at',
                Carbon::now()->toDateTimeString(),
                'clinic'
            );
        }

        if ($oldStatus === 'out' && $newStatus === 'in') {
            SystemSetting::setSetting(
                'clinic_status_in_at',
                Carbon::now()->toDateTimeString(),
                'clinic'
            );
        }

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => $newStatus === 'out'
                ? 'Clinic marked as closed.'
                : 'Clinic marked as open.',
        ]);
    }

    private function resolvePatientUser($patient): ?User
    {
        if (isset($patient->user) && $patient->user instanceof User) {
            return $patient->user;
        }

        if (!empty($patient->user_id)) {
            return User::find($patient->user_id);
        }

        if (!empty($patient->email)) {
            return User::where('email', $patient->email)->first();
        }

        return User::where('patient_id', $patient->id)->first();
    }
}
