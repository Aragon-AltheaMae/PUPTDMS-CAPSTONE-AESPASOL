<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Patient;

class ExistingRecordController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user:id,name,first_name,middle_name,last_name,suffix_name,email')
            ->select('id', 'user_id', 'name', 'email', 'phone', 'gender', 'birthdate', 'student_no', 'course_name', 'year_level', 'section', 'faculty_code')
            ->orderBy('name', 'asc')
            ->get();

        $patients->each(function (Patient $patient) {
            $resolvedName = $this->resolvePatientName($patient);

            if ($resolvedName !== '') {
                $patient->name = $resolvedName;
            }
        });

        return view('dentist.add-existing-record', compact('patients'));
    }

    private function resolvePatientName(Patient $patient): string
    {
        $patientName = trim((string) ($patient->name ?? ''));
        $user = $patient->user;

        $userFullName = trim(collect([
            $user?->first_name,
            $user?->middle_name,
            $user?->last_name,
            $user?->suffix_name,
        ])->filter(fn ($value) => filled($value))->implode(' '));

        $userName = trim((string) ($user?->name ?? ''));

        foreach ([$userFullName, $userName, $patientName] as $candidate) {
            if ($candidate !== '' && ! $this->isFallbackPatientName($candidate)) {
                return $candidate;
            }
        }

        return $patientName !== '' ? $patientName : 'Patient';
    }

    private function isFallbackPatientName(string $name): bool
    {
        return in_array(strtolower(trim($name)), [
            'faculty member',
            'administrative patient',
            'unknown patient',
            'patient',
        ], true);
    }
}
