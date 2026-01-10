<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\DentalHistory;
use App\Models\MedicalHistory;
use App\Models\Patient;


class AppointmentController extends Controller
{
    // Show all appointments
    public function index()
{
    $patientId = session('patient_id');
    if (!$patientId) {
        return redirect()->route('login')->with('error', 'Please login first!');
    }

    $patient = Patient::findOrFail($patientId);

    $appointments = Appointment::with(['service', 'dentalHistory', 'medicalHistory'])
        ->where('patient_id', $patient->id)   // ✅ only this patient’s appointments
        ->get();

    return view('appointment', compact('appointments', 'patient'));
}
    // Show booking form
    public function create()
    {
        return view('book-appointment');
    }

    // Store appointment
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'service_type' => 'required',

            'emergency_person' => 'required|max:50',
            'emergency_number' => 'required|max:15',
            'emergency_relation' => 'required|max:30',

            'patient_signature' => 'required|image|max:2048',
        ]);

          // dd($request->all());

        /* ================= SIGNATURE UPLOAD ================= */
        if ($request->hasFile('patient_signature')) {
            $signaturePath = $request->file('patient_signature')
                                    ->store('signatures', 'public');
        } else {
            $signaturePath = null;
        }

        /* ================= APPOINTMENT ================= */
        $appointment = Appointment::create([
            'patient_id' => session('patient_id'), // optional but recommended
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
        ]);

        /* ================= SERVICE ================= */
        AppointmentService::create([
            'appointment_id' => $appointment->id,
            'service_type' => $request->service_type,
            'patient_signature' => $signaturePath, // save path here
        ]);

        /* ================= DENTAL HISTORY ================= */
        DentalHistory::create([
        'appointment_id' => $appointment->id,

        'bleeding_gums' => $request->bleeding_gums,
        'sensitive_temp' => $request->sensitive_temp,
        'sensitive_taste' => $request->sensitive_taste,
        'tooth_pain' => $request->tooth_pain,
        'sores' => $request->sores,
        'injuries' => $request->injuries,

        'clicking' => $request->clicking,
        'joint_pain' => $request->joint_pain,
        'difficulty_moving' => $request->difficulty_moving,
        'difficulty_chewing' => $request->difficulty_chewing,
        'headaches' => $request->headaches,
        'clench_grind' => $request->clench_grind,
        'biting' => $request->biting,
        'teeth_loosening' => $request->teeth_loosening,
        'food_teeth' => $request->food_teeth,
        'med_reaction' => $request->med_reaction,

        'periodontal' => $request->periodontal,
        'difficult_extraction' => $request->difficult_extraction,
        'prolonged_bleeding' => $request->prolonged_bleeding,
        'dentures' => $request->dentures,
        'ortho_treatment' => $request->ortho_treatment,

        'additional_concerns' => $request->additional_concerns,
    ]);

        /* ================= MEDICAL HISTORY ================= */
        MedicalHistory::create([
            'appointment_id' => $appointment->id,

            'hypertension' => $request->hypertension,
            'diabetes' => $request->diabetes,
            'heart_condition' => $request->heart_condition,
            'allergy' => $request->allergy,

            'pregnant' => $request->pregnant,
            'nursing' => $request->nursing,
            'birth_control' => $request->birth_control,

            'emergency_person' => $request->emergency_person,
            'emergency_number' => $request->emergency_number,
            'emergency_relation' => $request->emergency_relation,
            'patient_signature' => $signaturePath,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Appointment booked successfully!');
    }
}
