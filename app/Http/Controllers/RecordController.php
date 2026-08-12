<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Helpers\AuditLogger;
use App\Models\DocumentRequest;

class RecordController extends Controller
{
    public function index()
    {
        $patientId = session('impersonated_patient_id') ?: session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        $perPage = (int) request('per_page', 10);

        if (!in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $records = Appointment::with(['procedure', 'dentist'])
            ->where('patient_id', $patient->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate($perPage, ['*'], 'records_page')
            ->withQueryString();

        $documentRequests = DocumentRequest::query()
            ->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->get();

        $upcomingAppointment = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();

        AuditLogger::log(
            'view',
            'records',
            "Patient viewed dental records"
        );

        return view('patient.record', compact(
            'patient',
            'records',
            'documentRequests',
            'upcomingAppointment'
        ));
    }
}
