<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Services\FacultyApiService;
use Illuminate\Support\Collection;

class ExistingRecordController extends Controller
{
    public function index(FacultyApiService $facultyApiService)
    {
        $patients = Patient::with('user:id,name,first_name,middle_name,last_name,suffix_name,email')
            ->select('id', 'user_id', 'name', 'email', 'phone', 'gender', 'birthdate', 'student_no', 'course_name', 'year_level', 'section', 'faculty_code')
            ->orderBy('name', 'asc')
            ->get();

        $faculties = collect($facultyApiService->getFaculties());
        $facultiesByEmail = $faculties
            ->filter(fn (array $faculty) => filled($faculty['email'] ?? null))
            ->keyBy(fn (array $faculty) => strtolower((string) $faculty['email']));
        $facultiesByCode = $faculties
            ->filter(fn (array $faculty) => filled($faculty['faculty_code'] ?? null))
            ->keyBy(fn (array $faculty) => strtolower((string) $faculty['faculty_code']));

        $patients->each(function (Patient $patient) use ($facultiesByEmail, $facultiesByCode) {
            $resolvedName = $this->resolvePatientName($patient, $facultiesByEmail, $facultiesByCode);

            if ($resolvedName === '') {
                return;
            }

            $patient->name = $resolvedName;

            if ($patient->user && $this->shouldReplaceFallbackName((string) $patient->user->name, $resolvedName)) {
                $patient->user->name = $resolvedName;
                $patient->user->save();
            }

            if ($this->shouldReplaceFallbackName((string) $patient->getOriginal('name'), $resolvedName)) {
                $patient->save();
            }
        });

        return view('dentist.add-existing-record', compact('patients'));
    }

    private function resolvePatientName(
        Patient $patient,
        Collection $facultiesByEmail,
        Collection $facultiesByCode
    ): string {
        $patientName = trim((string) ($patient->name ?? ''));
        $user = $patient->user;

        $userFullName = trim(collect([
            $user?->first_name,
            $user?->middle_name,
            $user?->last_name,
            $user?->suffix_name,
        ])->filter(fn ($value) => filled($value))->implode(' '));

        $userName = trim((string) ($user?->name ?? ''));
        $patientEmail = strtolower(trim((string) ($patient->email ?? '')));
        $patientFacultyCode = strtolower(trim((string) ($patient->faculty_code ?? '')));

        $matchedFaculty = $facultiesByEmail->get($patientEmail)
            ?? $facultiesByCode->get($patientFacultyCode);

        $facultyName = '';

        if (is_array($matchedFaculty)) {
            $facultyName = trim((string) ($matchedFaculty['name'] ?? ''));

            if ($facultyName === '') {
                $facultyName = trim(collect([
                    $matchedFaculty['first_name'] ?? null,
                    $matchedFaculty['middle_name'] ?? null,
                    $matchedFaculty['last_name'] ?? null,
                    $matchedFaculty['suffix_name'] ?? null,
                ])->filter(fn ($value) => filled($value))->implode(' '));
            }
        }

        foreach ([$facultyName, $userFullName, $userName, $patientName] as $candidate) {
            if ($candidate !== '' && ! $this->isFallbackPatientName($candidate)) {
                return $candidate;
            }
        }

        return $patientName !== '' ? $patientName : 'Patient';
    }

    private function shouldReplaceFallbackName(string $currentName, string $replacement): bool
    {
        $currentName = trim($currentName);
        $replacement = trim($replacement);

        if ($replacement === '') {
            return false;
        }

        return $currentName === '' || $this->isFallbackPatientName($currentName) || $currentName !== $replacement;
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
