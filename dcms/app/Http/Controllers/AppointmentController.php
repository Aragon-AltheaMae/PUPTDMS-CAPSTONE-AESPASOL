<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Appointment;
use App\Models\DentalHistory;
use App\Models\MedicalHistory;
use App\Models\MedicalHistoryCondition;
use App\Models\Patient;

class AppointmentController extends Controller
{
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
            ->get();

        return view('appointment', compact('appointments', 'patient'));
    }

    /* =======================
       SHOW BOOKING FORM
    ======================= */
    public function create()
    {
        return view('book-appointment');
    }

    /* =======================
       STORE APPOINTMENT
    ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date'   => 'required|date',
            'appointment_time'   => 'required',
            'service_type'       => 'required',

            'emergency_person'   => 'required|max:50',
            'emergency_number'   => 'required|max:15',
            'emergency_relation' => 'required',

            'patient_signature'  => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $signaturePath = $request->file('patient_signature')
            ->store('signatures', 'public');

        /* ---------- DATABASE TRANSACTION ---------- */
        DB::transaction(function () use ($request, $signaturePath) {

            /* =======================
               APPOINTMENT
            ======================= */
            $appointment = Appointment::create([
                'patient_id'       => session('patient_id'),
                'service_type'     => $request->service_type,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status'           => 'pending',
            ]);

            /* =======================
               DENTAL HISTORY (ENUM YES/NO)
            ======================= */
            DentalHistory::create([
                'appointment_id' => $appointment->id,

                'last_dental_visit' => $request->last_dental_visit,
                'previous_dentist'  => $request->previous_dentist,

                'bleeding_gums'      => strtoupper($request->bleeding_gums),
                'sensitive_temp'     => strtoupper($request->sensitive_temp),
                'sensitive_taste'    => strtoupper($request->sensitive_taste),
                'tooth_pain'         => strtoupper($request->tooth_pain),
                'sores'              => strtoupper($request->sores),
                'injuries'           => strtoupper($request->injuries),

                'clicking'           => strtoupper($request->clicking),
                'joint_pain'         => strtoupper($request->joint_pain),
                'difficulty_moving'  => strtoupper($request->difficulty_moving),
                'difficulty_chewing' => strtoupper($request->difficulty_chewing),
                'jaw_headaches'      => strtoupper($request->jaw_headaches),
                'clench_grind'       => strtoupper($request->clench_grind),
                'biting'             => strtoupper($request->biting),
                'teeth_loosening'    => strtoupper($request->teeth_loosening),
                'food_teeth'         => strtoupper($request->food_teeth),
                'med_reaction'       => strtoupper($request->med_reaction),

                'periodontal'        => strtoupper($request->periodontal),
                'difficult_extraction'=> strtoupper($request->difficult_extraction),
                'prolonged_bleeding' => strtoupper($request->prolonged_bleeding),
                'dentures'           => strtoupper($request->dentures),
                'ortho_treatment'    => strtoupper($request->ortho_treatment),

                'extraction_date'    => $request->extraction_date,
                'dentures_date'      => $request->dentures_date,
                'ortho_date'         => $request->ortho_date,

                'additional_concerns'=> $request->additional_concerns,
            ]);

            /* =======================
               MEDICAL HISTORY (ENUM YES/NO)
            ======================= */
            $medicalHistory = MedicalHistory::create([
                'appointment_id' => $appointment->id,

                'good_health' => strtoupper($request->good_health),
                'good_health_details' => $request->good_health_details,
                'medical_exam_date' => $request->medical_exam_date,

                'under_treatment' => strtoupper($request->under_treatment),
                'treatment_details' => $request->treatment_details,

                'hospitalized' => strtoupper($request->hospitalized),
                'hospital_details' => $request->hospital_details,

                'allergy_medicine' => strtoupper($request->allergy_medicine),
                'allergy_food' => strtoupper($request->allergy_food),
                'allergy_others' => $request->allergy_others,

                'medication' => strtoupper($request->medication),
                'medication_details' => $request->medication_details,

                'pregnant' => strtoupper($request->pregnant),
                'nursing' => strtoupper($request->nursing),
                'birth_control' => strtoupper($request->birth_control),

                'tobacco_use' => strtoupper($request->tobacco_use),
                'tobacco_per_day' => $request->tobacco_per_day,
                'tobacco_per_week' => $request->tobacco_per_week,

                'headaches' => strtoupper($request->headaches),
                'earaches' => strtoupper($request->earaches),
                'neck_aches' => strtoupper($request->neck_aches),

                'emergency_person' => $request->emergency_person,
                'emergency_number' => $request->emergency_number,
                'emergency_relation' => $request->emergency_relation,

                'patient_signature' => $signaturePath,
            ]);

            /* =======================
               MEDICAL CONDITIONS (BOOLEAN)
            ======================= */
            $conditions = $request->conditions ?? [];

            MedicalHistoryCondition::create([
                'medical_history_id' => $medicalHistory->id,

                'aids_hiv' => in_array('AIDS/HIV', $conditions),
                'fainting' => in_array('Fainting/Dizzy Spells', $conditions),
                'alcohol_dependency' => in_array('Alcohol or Chemical Dependency', $conditions),
                'high_low_bp' => in_array('High/Low Blood Pressure', $conditions),
                'arthritis' => in_array('Arthritis/Rheumatism', $conditions),
                'hyper_hypoglycemia' => in_array('Hyper/Hypoglycemia', $conditions),
                'artificial_joints' => in_array('Artificial Joints or Valves', $conditions),
                'kidney_disease' => in_array('Kidney Disease', $conditions),
                'asthma' => in_array('Asthma', $conditions),
                'liver_disease' => in_array('Liver Disease', $conditions),
                'blood_transfusion' => in_array('Blood Transfusion', $conditions),
                'mental_disorder' => in_array('Mental/Nervous Disorder', $conditions),
                'cancer' => in_array('Cancer/Radiotherapy/Chemotherapy', $conditions),
                'stomach_ulcers' => in_array('Stomach Ulcers', $conditions),
                'diabetes' => in_array('Diabetes', $conditions),
                'stroke' => in_array('Stroke', $conditions),
                'eating_disorders' => in_array('Eating Disorders', $conditions),
                'tuberculosis' => in_array('Tuberculosis', $conditions),
                'epilepsy' => in_array('Epilepsy/Seizures', $conditions),
                'venereal_disease' => in_array('Venereal/Communicable Disease', $conditions),
            ]);
        });

        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }
}
