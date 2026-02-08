<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;

class RecordController extends Controller
{
    public function index()
    {
        if (!session()->has('patient_id')) {
            return redirect('/login');
        }

        $patient = Patient::find(session('patient_id'));

        $records = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['completed', 'booked', 'pending'])
            ->orderBy('appointment_date', 'desc') // ✅ FIX
            ->get();

        return view('record', compact('records', 'patient'));
    }
}
