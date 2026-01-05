<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\DentalHistory;
use App\Models\MedicalHistory;

class AppointmentController extends Controller
{
    // Show all appointments
    public function index()
    {
        $appointments = Appointment::with(['service', 'dentalHistory', 'medicalHistory'])->get();
        return view('appointment', compact('appointments'));
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

        /* ================= SIGNATURE UPLOAD ================= */
        $filename = null;
        if ($request->hasFile('patient_signature')) {
            $file = $request->file('patient_signature');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/signatures', $filename);
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
        ]);

        /* ================= DENTAL HISTORY ================= */
        DentalHistory::create([
            'appointment_id' => $appointment->id,

            'bleeding_gums' => $request->bleeding_gums,
            'sensitive_temp' => $request->sensitive_temp,
            'tooth_pain' => $request->tooth_pain,
            'sores' => $request->sores,
            'injuries' => $request->injuries,
            'clench_grind' => $request->clench_grind,
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
            'patient_signature' => $filename,
        ]);

        return redirect()
            ->route('appointment.create')
            ->with('success', 'Appointment booked successfully!');
    }
}
