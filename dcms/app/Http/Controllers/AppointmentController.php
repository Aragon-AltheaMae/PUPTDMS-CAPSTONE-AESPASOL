<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Appointment;
use App\Models\DentalHistory;
use App\Models\MedicalHistory;
use App\Models\MedicalHistoryCondition;
use App\Models\Patient;

class AppointmentController extends Controller
{
    const MAX_APPOINTMENTS_PER_DAY = 5;

    /* =======================
       SHOW PATIENT APPOINTMENTS
    ======================= */
    public function index()
    {
        $patientId = session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        $appointments = Appointment::with([
                'dentalHistory',
                'medicalHistory',
                'medicalHistory.conditions'
            ])
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $appointmentCountsPerDay = Appointment::selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $unavailableDates = [];

        $currentYear = now()->year;
        $philippineHolidays = [];
        for ($year = $currentYear; $year <= $currentYear + 4; $year++) {
            $philippineHolidays = array_merge($philippineHolidays, $this->getPhilippineHolidays($year));
        }

        $notifications = [];

        return view('appointment', compact(
            'appointments',
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

        $appointmentCountsPerDay = Appointment::selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $appointmentCountsPerSlot = Appointment::selectRaw('appointment_date, appointment_time, COUNT(*) as count')
            ->groupBy('appointment_date', 'appointment_time')
            ->get()
            ->groupBy('appointment_date')
            ->map(function ($rows) {
                // keys are "H:i:s" because DB is TIME
                return $rows->pluck('count', 'appointment_time');
            })
            ->toArray();

        $unavailableDates = [];

        $currentYear = now()->year;
        $philippineHolidays = array_merge(
            $this->getPhilippineHolidays($currentYear),
            $this->getPhilippineHolidays($currentYear + 1)
        );

        return view('book-appointment', compact(
            'patient',
            'appointmentCountsPerDay',
            'appointmentCountsPerSlot',
            'unavailableDates',
            'philippineHolidays'
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

        // Full day check
        $appointmentCount = Appointment::where('appointment_date', $request->appointment_date)->count();
        if ($appointmentCount >= self::MAX_APPOINTMENTS_PER_DAY) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, this date is fully booked. Please select another date.');
        }

        // Slot check (must match DB TIME)
        $timeTaken = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $mysqlTime)
            ->exists();

        if ($timeTaken) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, that time slot was already taken. Please choose another time.');
        }

        $signaturePath = $request->file('patient_signature')->store('signatures', 'public');

        DB::transaction(function () use ($request, $signaturePath, $mysqlTime, $patientId) {

            $appointment = Appointment::create([
                'patient_id'       => $patientId,
                'service_type'     => $request->service_type,
                'other_services'   => $request->service_type === 'Others'
                    ? trim($request->service_others_text ?? '')
                    : null,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $mysqlTime,
                'status'           => 'pending',
            ]);

            // DENTAL HISTORY: store ENUM 'YES'/'NO'
            DentalHistory::create([
                'appointment_id' => $appointment->id,

                'last_dental_visit' => $request->last_dental_visit,
                'previous_dentist'  => $request->previous_dentist,

                'bleeding_gums'      => $this->yesNoValue($request->bleeding_gums),
                'sensitive_temp'     => $this->yesNoValue($request->sensitive_temp),
                'sensitive_taste'    => $this->yesNoValue($request->sensitive_taste),
                'tooth_pain'         => $this->yesNoValue($request->tooth_pain),
                'sores'              => $this->yesNoValue($request->sores),
                'injuries'           => $this->yesNoValue($request->injuries),

                'clicking'           => $this->yesNoValue($request->clicking),
                'joint_pain'         => $this->yesNoValue($request->joint_pain),
                'difficulty_moving'  => $this->yesNoValue($request->difficulty_moving),
                'difficulty_chewing' => $this->yesNoValue($request->difficulty_chewing),
                'jaw_headaches'      => $this->yesNoValue($request->jaw_headaches),
                'clench_grind'       => $this->yesNoValue($request->clench_grind),
                'biting'             => $this->yesNoValue($request->biting),
                'teeth_loosening'    => $this->yesNoValue($request->teeth_loosening),
                'food_teeth'         => $this->yesNoValue($request->food_teeth),
                'med_reaction'       => $this->yesNoValue($request->med_reaction),

                'periodontal'          => $this->yesNoValue($request->periodontal),
                'difficult_extraction' => $this->yesNoValue($request->difficult_extraction),
                'prolonged_bleeding'   => $this->yesNoValue($request->prolonged_bleeding),
                'dentures'             => $this->yesNoValue($request->dentures),
                'ortho_treatment'      => $this->yesNoValue($request->ortho_treatment),

                'extraction_date'    => $request->extraction_date,
                'dentures_date'      => $request->dentures_date,
                'ortho_date'         => $request->ortho_date,

                'additional_concerns' => $request->additional_concerns,
            ]);

            // MEDICAL HISTORY: store ENUM 'YES'/'NO'
            $medicalHistory = MedicalHistory::create([
                'appointment_id' => $appointment->id,

                'good_health'         => $this->yesNoValue($request->good_health),
                'good_health_details' => $request->good_health_details,
                'medical_exam_date'   => $request->medical_exam_date,

                'under_treatment'     => $this->yesNoValue($request->under_treatment),
                'treatment_details'   => $request->treatment_details,

                'hospitalized'        => $this->yesNoValue($request->hospitalized),
                'hospital_details'    => $request->hospital_details,

                'allergy_medicine'    => $this->yesNoValue($request->allergy_medicine),
                'allergy_food'        => $this->yesNoValue($request->allergy_food),
                'allergy_others'      => $request->allergy_others,

                'medication'          => $this->yesNoValue($request->medication),
                'medication_details'  => $request->medication_details,

                'pregnant'            => $this->yesNoValue($request->pregnant),
                'nursing'             => $this->yesNoValue($request->nursing),
                'birth_control'       => $this->yesNoValue($request->birth_control),

                'tobacco_use'         => $this->yesNoValue($request->tobacco_use),
                'tobacco_per_day'     => $request->tobacco_per_day,
                'tobacco_per_week'    => $request->tobacco_per_week,

                'headaches'           => $this->yesNoValue($request->headaches),
                'earaches'            => $this->yesNoValue($request->earaches),
                'neck_aches'          => $this->yesNoValue($request->neck_aches),

                'emergency_person'    => $request->emergency_person,
                'emergency_number'    => $request->emergency_number,
                'emergency_relation'  => $request->emergency_relation,

                'patient_signature'   => $signaturePath,
            ]);

            // MEDICAL CONDITIONS (booleans are fine)
            $conditions = $request->input('conditions', []);

            MedicalHistoryCondition::create([
                'medical_history_id' => $medicalHistory->id,

                'aids_hiv'           => in_array('AIDS/HIV', $conditions, true),
                'fainting'           => in_array('Fainting/Dizzy Spells', $conditions, true),
                'alcohol_dependency' => in_array('Alcohol or Chemical Dependency', $conditions, true),
                'high_low_bp'        => in_array('High/Low Blood Pressure', $conditions, true),
                'arthritis'          => in_array('Arthritis/Rheumatism', $conditions, true),
                'hyper_hypoglycemia' => in_array('Hyper/Hypoglycemia', $conditions, true),
                'artificial_joints'  => in_array('Artificial Joints or Valves', $conditions, true),
                'kidney_disease'     => in_array('Kidney Disease', $conditions, true),
                'asthma'             => in_array('Asthma', $conditions, true),
                'liver_disease'      => in_array('Liver Disease', $conditions, true),
                'blood_transfusion'  => in_array('Blood Transfusion', $conditions, true),
                'mental_disorder'    => in_array('Mental/Nervous Disorder', $conditions, true),
                'cancer'             => in_array('Cancer/Radiotherapy/Chemotherapy', $conditions, true),
                'stomach_ulcers'     => in_array('Stomach Ulcers', $conditions, true),
                'diabetes'           => in_array('Diabetes', $conditions, true),
                'stroke'             => in_array('Stroke', $conditions, true),
                'eating_disorders'   => in_array('Eating Disorders', $conditions, true),
                'tuberculosis'       => in_array('Tuberculosis', $conditions, true),
                'epilepsy'           => in_array('Epilepsy/Seizures', $conditions, true),
                'venereal_disease'   => in_array('Venereal/Communicable Disease', $conditions, true),
            ]);
        });

        return redirect()->route('homepage')->with('success', 'Appointment booked successfully!');
    }

    /* =======================
       HELPERS
    ======================= */

    private function toMysqlTime(string $time12h): string
    {
        // "1:00 PM" -> "13:00:00"
        return Carbon::createFromFormat('g:i A', trim($time12h))->format('H:i:s');
    }

    /**
     * Converts any "truthy" value to ENUM strings 'YES'/'NO' (uppercase).
     * Works with: "YES"/"NO", "Yes"/"No", "on"/null, true/false, "1"/"0"
     */
    private function yesNoValue($value): string
    {
        if ($value === null) return 'NO';

        if (is_bool($value)) return $value ? 'YES' : 'NO';

        $v = strtoupper(trim((string) $value));

        // when checkbox is checked in HTML, it often becomes "on"
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
}