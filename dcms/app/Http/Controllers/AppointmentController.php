<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Appointment;
use App\Models\DentalHistory;
use App\Models\DentalHistoryCondition;
use App\Models\DentalHistoryAnswer;
use App\Models\DentalHistoryConditionDate;
use App\Models\DentalHistoryConcern;

use App\Models\MedicalHistory;
use App\Models\MedicalHistoryQuestion;
use App\Models\MedicalHistoryAnswer;
use App\Models\Disease;
use App\Models\MedicalHistoryDiseaseAnswer;

use App\Models\Patient;

class AppointmentController extends Controller
{
    const MAX_APPOINTMENTS_PER_DAY = 5;

    /* =======================
       SHOW PATIENT APPOINTMENTS
       - Provides:
         $appointments   (for calendar dots)
         $futureVisits   (for Future Visits tab)
         $pastVisits     (for Past Visits tab)
    ======================= */
    public function index()
    {
        $patientId = session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        // Use server time
        $now = now();
        $today = $now->toDateString();
        $nowTime = $now->format('H:i:s');

        // For calendar: show ALL of this patient's appointments
        $appointments = Appointment::where('patient_id', $patientId)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // ✅ FUTURE VISITS:
        // pending/confirmed AND (date > today OR (date == today AND time >= now))
        $futureVisits = Appointment::where('patient_id', $patientId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($today, $nowTime) {
                $q->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($q2) use ($today, $nowTime) {
                        $q2->whereDate('appointment_date', '=', $today)
                            ->whereTime('appointment_time', '>=', $nowTime);
                    });
            })
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // ✅ PAST VISITS:
        // completed/cancelled OR already passed datetime (even if still pending)
        $pastVisits = Appointment::where('patient_id', $patientId)
            ->where(function ($q) use ($today, $nowTime) {
                $q->whereIn('status', ['completed', 'cancelled'])
                    ->orWhereDate('appointment_date', '<', $today)
                    ->orWhere(function ($q2) use ($today, $nowTime) {
                        $q2->whereDate('appointment_date', '=', $today)
                            ->whereTime('appointment_time', '<', $nowTime);
                    });
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Patient-based histories (since you save by patient_id)
        $patient->load([
            'dentalHistory',
            'dentalHistoryDates',
            'dentalHistoryConcerns',
            'dentalHistoryAnswers.condition',
            'medicalHistory',
            'medicalHistory.answers.question',
            'medicalHistory.diseaseAnswers.disease',
        ]);

        // ✅ IMPORTANT:
        // Availability should only count pending/confirmed
        $appointmentCountsPerDay = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $unavailableDates = [];

        // Holidays (5 years)
        $currentYear = now()->year;
        $philippineHolidays = [];
        for ($year = $currentYear; $year <= $currentYear + 4; $year++) {
            $philippineHolidays = array_merge($philippineHolidays, $this->getPhilippineHolidays($year));
        }

        $notifications = [];

        return view('appointment', compact(
            'appointments',
            'futureVisits',
            'pastVisits',
            'patient',
            'appointmentCountsPerDay',
            'unavailableDates',
            'philippineHolidays',
            'notifications'
        ));
    }

    /* =======================
       SHOW BOOKING FORM
    ======================= */
    public function create()
    {
        $patientId = session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        // ✅ counts should only include pending/confirmed
        $appointmentCountsPerDay = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        // ✅ counts per slot should only include pending/confirmed
        $appointmentCountsPerSlot = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('appointment_date, appointment_time, COUNT(*) as count')
            ->groupBy('appointment_date', 'appointment_time')
            ->get()
            ->groupBy('appointment_date')
            ->map(function ($rows) {
                return $rows->pluck('count', 'appointment_time');
            })
            ->toArray();

        $unavailableDates = [];

        $currentYear = now()->year;
        $philippineHolidays = array_merge(
            $this->getPhilippineHolidays($currentYear),
            $this->getPhilippineHolidays($currentYear + 1)
        );

        $diseases = Disease::orderBy('sort_order')->get();

        return view('book-appointment', compact(
            'patient',
            'appointmentCountsPerDay',
            'appointmentCountsPerSlot',
            'unavailableDates',
            'philippineHolidays',
            'diseases'
        ));
    }

    /* =======================
       STORE APPOINTMENT
    ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date'     => 'required|date',
            'appointment_time'     => 'required|string', // "1:00 PM"
            'service_type'         => 'required|string|max:50',
            'service_others_text'  => 'required_if:service_type,Others|nullable|string|max:100',

            'emergency_person'     => 'required|string|max:50',
            'emergency_number'     => 'required|string|max:15',
            'emergency_relation'   => 'required|string',

            'patient_signature'    => 'required|mimes:jpg,jpeg,png,pdf|max:5120',

            'diseases'   => 'array',
            'diseases.*' => 'string|exists:diseases,code',
        ]);

        $patientId = session('patient_id');
        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        // Convert UI "1:00 PM" -> DB TIME "13:00:00"
        try {
            $mysqlTime = $this->toMysqlTime($request->appointment_time);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid time format. Please pick a valid time slot.');
        }

        // Full day check (only pending/confirmed should block)
        $appointmentCount = Appointment::where('appointment_date', $request->appointment_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($appointmentCount >= self::MAX_APPOINTMENTS_PER_DAY) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, this date is fully booked. Please select another date.');
        }

        // Slot check (only pending/confirmed should block)
        $timeTaken = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $mysqlTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($timeTaken) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, that time slot was already taken. Please choose another time.');
        }

        $signaturePath = $request->file('patient_signature')->store('signatures', 'public');

        DB::transaction(function () use ($request, $signaturePath, $mysqlTime, $patientId) {

            // 1) APPOINTMENT
            Appointment::create([
                'patient_id'       => $patientId,
                'service_type'     => $request->service_type,
                'other_services'   => $request->service_type === 'Others'
                    ? trim($request->service_others_text ?? '')
                    : null,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $mysqlTime,
                'status'           => 'pending',
            ]);

            // 2) DENTAL HISTORY (patient-based)
            DentalHistory::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'last_dental_visit' => $request->last_dental_visit,
                    'previous_dentist'  => $request->previous_dentist,
                ]
            );

            DentalHistoryConditionDate::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'extraction_date' => $request->extraction_date,
                    'dentures_date'   => $request->dentures_date,
                    'ortho_date'      => $request->ortho_date,
                ]
            );

            DentalHistoryConcern::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'additional_concerns' => $request->additional_concerns,
                ]
            );

            // YES/NO answers (dental_history_answers)
            $dentalAnswerMap = [
                'bleeding_gums'      => $request->bleeding_gums,
                'sensitive_temp'     => $request->sensitive_temp,
                'sensitive_taste'    => $request->sensitive_taste,
                'tooth_pain'         => $request->tooth_pain,
                'sores'              => $request->sores,
                'injuries'           => $request->injuries,

                'clicking'           => $request->clicking,
                'joint_pain'         => $request->joint_pain,
                'difficulty_moving'  => $request->difficulty_moving,
                'difficulty_chewing' => $request->difficulty_chewing,
                'jaw_headaches'      => $request->jaw_headaches,
                'clench_grind'       => $request->clench_grind,
                'biting'             => $request->biting,
                'teeth_loosening'    => $request->teeth_loosening,
                'food_teeth'         => $request->food_teeth,
                'med_reaction'       => $request->med_reaction,

                'periodontal'          => $request->periodontal,
                'difficult_extraction' => $request->difficult_extraction,
                'prolonged_bleeding'   => $request->prolonged_bleeding,
                'dentures'             => $request->dentures,
                'ortho_treatment'      => $request->ortho_treatment,
            ];

            $conditionIdsByCode = DentalHistoryCondition::whereIn('code', array_keys($dentalAnswerMap))
                ->pluck('id', 'code');

            foreach ($dentalAnswerMap as $code => $rawValue) {
                $conditionId = $conditionIdsByCode[$code] ?? null;
                if (!$conditionId) continue;

                DentalHistoryAnswer::updateOrCreate(
                    [
                        'patient_id'   => $patientId,
                        'condition_id' => $conditionId,
                    ],
                    [
                        'answer' => ($this->yesNoValue($rawValue) === 'YES'),
                    ]
                );
            }

            // 3) MEDICAL HISTORY (patient-based)
            $medicalHistory = MedicalHistory::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'emergency_person'   => $request->emergency_person,
                    'emergency_number'   => $request->emergency_number,
                    'emergency_relation' => $request->emergency_relation,
                    'patient_signature'  => $signaturePath,
                ]
            );

            // Medical answers map
            $medicalAnswerMap = [
                // bool
                'good_health'       => $request->good_health,
                'had_medical_exam'  => $request->had_medical_exam,
                'under_treatment'   => $request->under_treatment,
                'hospitalized'      => $request->hospitalized,
                'allergy_medicine'  => $request->allergy_medicine,
                'allergy_food'      => $request->allergy_food,
                'medication'        => $request->medication,
                'pregnant'          => $request->pregnant,
                'nursing'           => $request->nursing,
                'birth_control'     => $request->birth_control,
                'tobacco_use'       => $request->tobacco_use,
                'headaches'         => $request->headaches,
                'earaches'          => $request->earaches,
                'neck_aches'        => $request->neck_aches,

                // text
                'good_health_details' => $request->good_health_details,
                'treatment_details'   => $request->treatment_details,
                'hospital_details'    => $request->hospital_details,
                'allergy_others'      => $request->allergy_others,
                'medication_details'  => $request->medication_details,
                'tobacco_per_day'     => $request->tobacco_per_day,
                'tobacco_per_week'    => $request->tobacco_per_week,

                // date
                'medical_exam_date'   => $request->medical_exam_date,
            ];

            $questions = MedicalHistoryQuestion::whereIn('code', array_keys($medicalAnswerMap))
                ->get()
                ->keyBy('code');

            foreach ($medicalAnswerMap as $code => $rawValue) {
                $q = $questions->get($code);
                if (!$q) continue;

                // Normalize by type
                if ($q->type === 'bool') {
                    $bool = ($this->yesNoValue($rawValue) === 'YES');

                    MedicalHistoryAnswer::updateOrCreate(
                        [
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ],
                        [
                            'answer_bool' => $bool,
                            'answer_text' => null,
                            'answer_date' => null,
                        ]
                    );

                    continue;
                }

                if ($q->type === 'text') {
                    $text = ($rawValue === null) ? '' : trim((string) $rawValue);

                    // remove row if empty text 
                    if ($text === '') {
                        MedicalHistoryAnswer::where([
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ])->delete();
                        continue;
                    }

                    MedicalHistoryAnswer::updateOrCreate(
                        [
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ],
                        [
                            'answer_bool' => null,
                            'answer_text' => $text,
                            'answer_date' => null,
                        ]
                    );

                    continue;
                }

                if ($q->type === 'date') {
                    $date = $rawValue ? trim((string) $rawValue) : '';

                    // remove row if empty date
                    if ($date === '') {
                        MedicalHistoryAnswer::where([
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ])->delete();
                        continue;
                    }

                    MedicalHistoryAnswer::updateOrCreate(
                        [
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ],
                        [
                            'answer_bool' => null,
                            'answer_text' => null,
                            'answer_date' => $date,
                        ]
                    );

                    continue;
                }
            }

            MedicalHistoryAnswer::where('patient_id', $patientId)
                ->where('medical_history_id', $medicalHistory->id)
                ->whereNull('answer_bool')
                ->whereNull('answer_date')
                ->where(function ($q) {
                    $q->whereNull('answer_text')
                        ->orWhereRaw("TRIM(answer_text) = ''");
                })
                ->delete();

            // 4) DISEASES (selected codes from form)
            $selectedDiseaseCodes = $request->input('diseases', []);
            $selectedDiseaseIds = Disease::whereIn('code', $selectedDiseaseCodes)
                ->pluck('id')
                ->all();

            MedicalHistoryDiseaseAnswer::where('medical_history_id', $medicalHistory->id)->delete();

            foreach ($selectedDiseaseIds as $diseaseId) {
                MedicalHistoryDiseaseAnswer::create([
                    'patient_id'         => $patientId,
                    'medical_history_id' => $medicalHistory->id,
                    'disease_id'         => $diseaseId,
                    'has_disease'        => true,
                ]);
            }
        });

        return redirect()->route('homepage')->with('success', 'Appointment booked successfully!');
    }

    /* =======================
       HELPERS
    ======================= */
    private function toMysqlTime(string $time12h): string
    {
        return Carbon::createFromFormat('g:i A', trim($time12h))->format('H:i:s');
    }

    private function yesNoValue($value): string
    {
        if ($value === null) return 'NO';
        if (is_bool($value)) return $value ? 'YES' : 'NO';

        $v = strtoupper(trim((string) $value));
        if (in_array($v, ['YES', 'Y', 'TRUE', '1', 'ON'], true)) return 'YES';

        return 'NO';
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

    public function reschedule($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);

        $appointmentCountsPerDay = Appointment::where('status', '!=', 'cancelled')
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $appointmentCountsPerSlot = Appointment::where('status', '!=', 'cancelled')
            ->selectRaw('DATE(appointment_date) as date, appointment_time, COUNT(*) as count')
            ->groupBy('date', 'appointment_time')
            ->get()
            ->groupBy(function ($item) {
                return $item->date;
            })
            ->map(function ($group) {
                return $group->pluck('count', 'appointment_time')->toArray();
            })
            ->toArray();

        $unavailableDates = [];

        $philippineHolidays = [
            '2026-01-01' => 'New Year\'s Day',
            '2026-02-25' => 'EDSA Revolution',
            '2026-04-09' => 'Araw ng Kagitingan',
            '2026-05-01' => 'Labor Day',
            '2026-06-12' => 'Independence Day',
            '2026-08-31' => 'National Heroes Day',
            '2026-11-30' => 'Bonifacio Day',
            '2026-12-25' => 'Christmas Day',
            '2026-12-30' => 'Rizal Day',
        ];

        return view('dentist-reschedule', compact(
            'appointment',
            'appointmentCountsPerDay',
            'appointmentCountsPerSlot',
            'unavailableDates',
            'philippineHolidays'
        ));
    }

    /**
     * Update the rescheduled appointment
     */
    public function updateReschedule(Request $request, $id)
    {
        $request->validate([
            'new_appointment_date' => 'required|date|after_or_equal:today',
            'new_appointment_time' => 'required',
            'service_type' => 'required|string',
            'reschedule_reason' => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::findOrFail($id);

        try {
            $mysqlTime = $this->toMysqlTime($request->new_appointment_time);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid time format. Please pick a valid time slot.');
        }

        $slotTaken = Appointment::where('appointment_date', $request->new_appointment_date)
            ->where('appointment_time', $mysqlTime)
            ->where('id', '!=', $id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($slotTaken) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, that time slot is already taken. Please choose another time.');
        }

        $appointment->update([
            'appointment_date' => $request->new_appointment_date,
            'appointment_time' => $mysqlTime,
            'service_type' => $request->service_type,
            'reschedule_reason' => $request->reschedule_reason,
        ]);

        return response()->json(['success' => true]);
    }
}
