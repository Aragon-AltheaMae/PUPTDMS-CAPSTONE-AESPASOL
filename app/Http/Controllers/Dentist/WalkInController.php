<?php

namespace App\Http\Controllers\Dentist;

use App\Helpers\PhilippineHolidays;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BlockedDate;
use App\Models\ClinicSchedule;
use App\Models\Disease;
use App\Models\MedicalHistory;
use App\Models\DentalHistory;
use App\Models\DentalHistoryCondition;
use App\Models\DentalHistoryAnswer;
use App\Models\DentalHistoryConditionDate;
use App\Models\DentalHistoryConcern;

use App\Models\MedicalHistoryQuestion;
use App\Models\MedicalHistoryAnswer;
use App\Models\MedicalHistoryDiseaseAnswer;
use App\Models\Patient;
use App\Models\ServiceType;
use App\Models\User;
use App\Services\FacultyApiService;
use App\Services\StudentApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\BookingQuestions;

class WalkInController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::query()
            ->orderBy('name')
            ->get()
            ->map(function ($service) {
                $image = trim((string) ($service->image ?? ''));

                return [
                    'name' => $service->name,
                    'desc' => $service->description ?? 'Dental service available for walk-in appointment.',
                    'img' => $image !== '' ? $image : null,
                ];
            });

        $diseases = Disease::query()
            ->orderBy('label')
            ->get();

        $schedules = ClinicSchedule::active()
            ->orderBy('id')
            ->get();

        $blockedDates = BlockedDate::orderBy('date')
            ->get();

        $startDate = now()->startOfMonth()->subMonth();
        $endDate = now()->endOfMonth()->addMonths(3);

        $appointmentCountsPerDay = Appointment::whereBetween('appointment_date', [
            $startDate->toDateString(),
            $endDate->toDateString(),
        ])
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('appointment_date, COUNT(*) as total')
            ->groupBy('appointment_date')
            ->pluck('total', 'appointment_date');

        $philippineHolidays = PhilippineHolidays::range(yearsBefore: 1, yearsAfter: 5);

        $dentalQuestions = BookingQuestions::dental();
        $medicalQuestions = BookingQuestions::medical();

        return view(
            'dentist.dentist-walk-in',
            compact(
                'serviceTypes',
                'diseases',
                'schedules',
                'blockedDates',
                'appointmentCountsPerDay',
                'philippineHolidays',
                'dentalQuestions',
                'medicalQuestions'
            )
        );
    }

    public function searchPatient(
        Request $request,
        FacultyApiService $facultyApiService,
        StudentApiService $studentApiService
    ) {
        $search = trim((string) $request->query('q', ''));

        $showAll =
            $request->boolean(
                'show_all'
            );

        $page = max(
            1,
            (int) $request->query('page', 1)
        );

        $perPageInput = (int) $request->query(
            'per_page',
            10
        );

        $perPage = in_array(
            $perPageInput,
            [10, 20, 50, 100],
            true
        )
            ? $perPageInput
            : 10;
            
        $sourceLimit = max(
            20,
            min(
                $perPage,
                50
            )
        );

        try {
            $hasMeaningfulSearch =
                mb_strlen($search) >= 2;

            $shouldLoadConnectedSources =
                $hasMeaningfulSearch ||
                $showAll;

            $patients = collect()
                ->merge(
                    $shouldLoadConnectedSources
                        ? $this->searchOgosPatients(
                            $search,
                            $sourceLimit,
                            $studentApiService
                        )
                        : []
                )
                ->merge(
                    $shouldLoadConnectedSources
                        ? $this->searchFacultyPatients(
                            $search,
                            $sourceLimit,
                            $facultyApiService
                        )
                        : []
                )
                ->merge(
                    $shouldLoadConnectedSources
                        ? $this->searchExternalAdminPatients(
                            $search,
                            $sourceLimit
                        )
                        : []
                )
                ->merge(
                    $this->searchLocalPatients(
                        $search,
                        $sourceLimit
                    )
                )
                ->filter()
                ->unique(
                    fn(array $patient) =>
                    $this->resolvePatientIdentityKey(
                        $patient
                    )
                )
                ->map(function (array $patient) use ($search) {
                    $patient['_score'] =
                        $this->scorePatientSearchMatch(
                            $patient,
                            $search
                        );

                    return $patient;
                })
                ->filter(
                    fn(array $patient) =>
                    $search === '' ||
                        (($patient['_score'] ?? -1) >= 0)
                )
                ->sort(function (
                    array $a,
                    array $b
                ) use ($search) {

                    if ($search === '') {
                        return strcasecmp(
                            (string) ($a['name'] ?? ''),
                            (string) ($b['name'] ?? '')
                        );
                    }

                    $scoreCompare =
                        ($b['_score'] ?? -1)
                        <=>
                        ($a['_score'] ?? -1);

                    if ($scoreCompare !== 0) {
                        return $scoreCompare;
                    }

                    return strcasecmp(
                        (string) ($a['name'] ?? ''),
                        (string) ($b['name'] ?? '')
                    );
                })
                ->map(function (array $patient) {
                    unset($patient['_score']);

                    return $patient;
                })
                ->values();

            $total = $patients->count();

            $lastPage = max(
                1,
                (int) ceil($total / $perPage)
            );

            $page = min($page, $lastPage);

            $offset = ($page - 1) * $perPage;

            $pageRecords = $patients
                ->slice($offset, $perPage)
                ->values();

            $from = $total > 0
                ? $offset + 1
                : null;

            $to = $total > 0
                ? min($offset + $perPage, $total)
                : null;

            return response()->json([
                'data' => $pageRecords,
                'current_page' => $page,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'total' => $total,
                'from' => $from,
                'to' => $to,
            ]);
        } catch (\Throwable $e) {
            Log::error('Walk-in student API search failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'message' => 'Unable to load patient records from connected systems.',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function patientBookingInformation(Patient $patient)
    {
        $patient->load([
            'user',
            'dentalHistory',
            'dentalHistoryDates',
            'dentalHistoryConcerns',
            'dentalHistoryAnswers.condition',
            'medicalHistory.answers.question',
            'medicalHistory.diseaseAnswers.disease',
        ]);

        /*
    |--------------------------------------------------------------------------
    | DENTAL HISTORY
    |--------------------------------------------------------------------------
    */

        $dentalDefaults = [
            'last_dental_visit' =>
            $patient->dentalHistory?->last_dental_visit
                ? Carbon::parse(
                    $patient->dentalHistory->last_dental_visit
                )->format('Y-m-d')
                : '',

            'previous_dentist' =>
            $patient->dentalHistory?->previous_dentist ?? '',

            'additional_concerns' =>
            $patient->dentalHistoryConcerns?->additional_concerns ?? '',

            'extraction_date' =>
            $patient->dentalHistoryDates?->extraction_date
                ? Carbon::parse(
                    $patient->dentalHistoryDates->extraction_date
                )->format('Y-m-d')
                : '',

            'dentures_date' =>
            $patient->dentalHistoryDates?->dentures_date
                ? Carbon::parse(
                    $patient->dentalHistoryDates->dentures_date
                )->format('Y-m-d')
                : '',

            'ortho_date' =>
            $patient->dentalHistoryDates?->ortho_date
                ? Carbon::parse(
                    $patient->dentalHistoryDates->ortho_date
                )->format('Y-m-d')
                : '',
        ];

        foreach ($patient->dentalHistoryAnswers as $answer) {
            $code = $answer->condition?->code;

            if (!$code) {
                continue;
            }

            $dentalDefaults[$code] =
                $answer->answer ? 'YES' : 'NO';
        }

        $medicalDefaults = [];

        if ($patient->medicalHistory) {
            $medicalDefaults = [
                'emergency_person' =>
                $patient->medicalHistory->emergency_person ?? '',

                'emergency_number' =>
                $patient->medicalHistory->emergency_number ?? '',

                'emergency_relation' =>
                $patient->medicalHistory->emergency_relation ?? '',
            ];

            foreach ($patient->medicalHistory->answers as $answer) {
                $code = $answer->question?->code;

                if (!$code) {
                    continue;
                }

                if ($answer->answer_bool !== null) {
                    $medicalDefaults[$code] =
                        $answer->answer_bool ? 'YES' : 'NO';

                    continue;
                }

                if ($answer->answer_text !== null) {
                    $medicalDefaults[$code] =
                        $answer->answer_text;

                    continue;
                }

                if ($answer->answer_date !== null) {
                    $medicalDefaults[$code] =
                        Carbon::parse(
                            $answer->answer_date
                        )->format('Y-m-d');
                }
            }
        }

        $selectedDiseases =
            $patient->medicalHistory
            ? $patient->medicalHistory
            ->diseaseAnswers
            ->filter(
                fn($answer) =>
                $answer->has_disease
            )
            ->map(
                fn($answer) =>
                $answer->disease?->code
            )
            ->filter()
            ->values()
            ->all()
            : [];
        $hasExistingDentalHistory =
            $this->hasExistingDentalHistoryRecord($patient);

        $hasExistingMedicalHistory =
            $this->hasExistingMedicalHistoryRecord($patient);

        $hasExistingAppointment =
            Appointment::where(
                'patient_id',
                $patient->id
            )->exists();

        $hasExistingBookingInformation =
            $hasExistingDentalHistory &&
            $hasExistingMedicalHistory;

        $hasReusableSignature =
            !empty($patient->medicalHistory?->patient_signature) &&
            $patient->medicalHistory?->signature_review_status !==
            'invalid_reupload_required';

        $existingSignatureUrl = null;

        if (
            $hasReusableSignature &&
            filled($patient->medicalHistory?->patient_signature)
        ) {
            $signaturePath = ltrim(
                str_replace(
                    'storage/',
                    '',
                    $patient->medicalHistory->patient_signature
                ),
                '/'
            );

            if (
                Storage::disk('public')->exists(
                    $signaturePath
                )
            ) {
                $existingSignatureUrl =
                    Storage::disk('public')->url(
                        $signaturePath
                    );
            }
        }

        return response()->json([
            'success' => true,

            'has_existing_dental_history' =>
            $hasExistingDentalHistory,

            'has_existing_medical_history' =>
            $hasExistingMedicalHistory,

            'has_existing_appointment' =>
            $hasExistingAppointment,

            'has_existing_booking_information' =>
            $hasExistingBookingInformation,

            'has_reusable_signature' =>
            $hasReusableSignature,

            'existing_signature_url' =>
            $existingSignatureUrl,

            'dental' =>
            $dentalDefaults,

            'medical' =>
            $medicalDefaults,

            'diseases' =>
            $selectedDiseases,

            'contact' => [
                'email' =>
                $patient->email
                    ?? $patient->user?->email
                    ?? '',

                'phone' =>
                $patient->phone ?? '',

                'address' =>
                $patient->address ?? '',
            ],
        ]);
    }

    private function hasExistingDentalHistoryRecord(Patient $patient): bool
    {
        if ($patient->dentalHistoryAnswers->isNotEmpty()) {
            return true;
        }

        if (filled($patient->dentalHistoryConcerns?->additional_concerns)) {
            return true;
        }

        if (
            filled($patient->dentalHistory?->last_dental_visit) ||
            filled($patient->dentalHistory?->previous_dentist) ||
            filled($patient->dentalHistoryDates?->extraction_date) ||
            filled($patient->dentalHistoryDates?->dentures_date) ||
            filled($patient->dentalHistoryDates?->ortho_date)
        ) {
            return true;
        }

        return false;
    }

    private function hasExistingMedicalHistoryRecord(Patient $patient): bool
    {
        if ($patient->medicalHistory?->answers->isNotEmpty()) {
            return true;
        }

        if ($patient->medicalHistory?->diseaseAnswers->isNotEmpty()) {
            return true;
        }

        if (
            filled($patient->medicalHistory?->emergency_person) ||
            filled($patient->medicalHistory?->emergency_number) ||
            filled($patient->medicalHistory?->emergency_relation) ||
            filled($patient->medicalHistory?->patient_signature)
        ) {
            return true;
        }

        return false;
    }

    private function searchOgosPatients(string $search, int $limit, StudentApiService $studentApiService): array
    {
        try {
            $students = $studentApiService->searchStudents(
                search: $search !== '' ? $search : null,
                limit: $limit
            );

            return collect($students)
                ->map(fn($student) => $studentApiService->normalizeStudent((array) $student))
                ->filter()
                ->map(function (array $student) {
                    $user = $this->syncWalkInUser($student);
                    $patient = $this->syncWalkInPatient($user, $student, 'Student');
                    return [
                        'id' =>
                        $patient->id,

                        'name' =>
                        $student['name'],

                        'gender' =>
                        $student['gender']
                            ?? $patient->gender,

                        'birthdate' =>
                        $student['birthdate']
                            ?? $patient->birthdate,

                        'email' =>
                        $student['email'],

                        'phone' =>
                        $student['phone']
                            ?? $patient->phone,

                        'type' =>
                        'Student',

                        'student_number' =>
                        $student['student_number']
                            ?? null,

                        'program' =>
                        $student['program']
                            ?? $patient->course_name,

                        'year_level' =>
                        $student['year_level']
                            ?? $patient->year_level,

                        'section' =>
                        $student['section']
                            ?? $patient->section,

                        'is_pwd' =>
                        $student['is_pwd']
                            ?? $patient->is_pwd,

                        'record_url' =>
                        route(
                            'dentist.odontogram.existing-appointment.create',
                            [
                                'patient' =>
                                $patient->id,
                            ]
                        ),

                        'avatar_url' =>
                        $this->resolvePatientAvatarUrl(
                            $patient,
                            $student['name']
                        ),
                    ];
                })
                ->all();
        } catch (\Throwable $e) {
            Log::warning('Walk-in OGOS search failed', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }

    private function scorePatientSearchMatch(array $patient, string $search): int
    {
        $normalizedQuery = $this->normalizeSearchText($search);
        if ($normalizedQuery === '') {
            return 0;
        }

        $tokens = array_values(array_filter(explode(' ', $normalizedQuery)));
        $values = [
            $patient['name'] ?? '',
            $patient['email'] ?? '',
            $patient['student_number'] ?? '',
            $patient['program'] ?? '',
            $patient['type'] ?? '',
        ];

        $best = -1;

        foreach ($values as $index => $value) {
            $score = $this->scoreSearchValue((string) $value, $normalizedQuery, $tokens);
            if ($score >= 0) {
                $best = max($best, $score - ($index * 10));
            }
        }

        return $best;
    }

    private function scoreSearchValue(string $haystack, string $query, array $tokens): int
    {
        $normalizedHaystack = $this->normalizeSearchText($haystack);
        if ($normalizedHaystack === '') {
            return -1;
        }

        if ($normalizedHaystack === $query) {
            return 1000;
        }

        if (str_starts_with($normalizedHaystack, $query)) {
            return 800;
        }

        if ($tokens !== [] && collect($tokens)->every(fn(string $token) => str_contains($normalizedHaystack, $token))) {
            return 500 - strpos($normalizedHaystack, $tokens[0]);
        }

        if (str_contains($normalizedHaystack, $query)) {
            return 250 - strpos($normalizedHaystack, $query);
        }

        return -1;
    }

    private function normalizeSearchText(string $value): string
    {
        $normalized = strtolower(trim($value));
        $normalized = preg_replace('/[^a-z0-9@\s._-]/', ' ', $normalized) ?? '';
        $normalized = preg_replace('/\s+/', ' ', $normalized) ?? '';

        return trim($normalized);
    }

    private function resolvePatientIdentityKey(array $patient): string
    {
        $email = strtolower(trim((string) ($patient['email'] ?? '')));

        if ($email !== '') {
            return 'email:' . $email;
        }

        $studentNumber = strtolower(trim((string) ($patient['student_number'] ?? '')));

        if ($studentNumber !== '') {
            return 'student:' . $studentNumber;
        }

        $facultyCode = strtolower(trim((string) ($patient['faculty_code'] ?? '')));

        if ($facultyCode !== '') {
            return 'faculty:' . $facultyCode;
        }

        return 'id:' . strtolower(trim((string) ($patient['id'] ?? ($patient['name'] ?? Str::uuid()->toString()))));
    }

    private function searchLocalPatients(
        string $search,
        int $limit
    ): array {
        $userColumns = [
            'id',
            'name',
            'first_name',
            'middle_name',
            'last_name',
            'suffix_name',
            'email',
        ];

        if (Schema::hasColumn('users', 'profile_image')) {
            $userColumns[] = 'profile_image';
        }

        $patientColumns = [
            'id',
            'user_id',
            'name',
            'email',
            'phone',
            'gender',
            'birthdate',
            'student_no',
            'course_name',
            'faculty_code',
            'year_level',
            'section',
            'is_pwd',
        ];

        if (Schema::hasColumn('patients', 'patient_type')) {
            $patientColumns[] = 'patient_type';
        }

        if (Schema::hasColumn('patients', 'type')) {
            $patientColumns[] = 'type';
        }

        if (Schema::hasColumn('patients', 'profile_image')) {
            $patientColumns[] = 'profile_image';
        }

        $query = Patient::query()
            ->with([
                'user' => function ($query) use ($userColumns) {
                    $query->select($userColumns);
                },
            ])
            ->select($patientColumns)
            ->orderBy('name');

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_no', 'like', "%{$search}%")
                    ->orWhere('course_name', 'like', "%{$search}%")
                    ->orWhere('faculty_code', 'like', "%{$search}%");
            });
        }

        return $query
            ->limit($limit)
            ->get()
            ->map(function (Patient $patient) {
                $user = $patient->user;

                $resolvedName = trim(collect([
                    $user?->first_name,
                    $user?->middle_name,
                    $user?->last_name,
                    $user?->suffix_name,
                ])->filter(fn($value) => filled($value))->implode(' '));

                if ($resolvedName === '') {
                    $resolvedName = trim((string) ($user?->name ?? ''));
                }

                if ($resolvedName === '') {
                    $resolvedName = trim((string) ($patient->name ?? ''));
                }

                $patientType = trim((string) (
                    $patient->getAttribute('patient_type')
                    ?: $patient->getAttribute('type')
                    ?: ''
                ));

                if ($patientType === '') {
                    $patientType = $patient->student_no
                        ? 'Student'
                        : (
                            $patient->faculty_code
                            ? 'Faculty'
                            : 'Patient'
                        );
                }

                return [
                    'id' =>
                    $patient->id,

                    'name' =>
                    $resolvedName !== ''
                        ? $resolvedName
                        : 'Patient',

                    'gender' =>
                    $patient->gender,

                    'birthdate' =>
                    $patient->birthdate,

                    'email' =>
                    $patient->email
                        ?? $user?->email,

                    'phone' =>
                    $patient->phone,

                    'type' => $patientType,
                    'student_number' =>
                    $patient->student_no,

                    'program' =>
                    $patient->course_name
                        ?? $patient->faculty_code,

                    'faculty_code' =>
                    $patient->faculty_code,

                    'year_level' =>
                    $patient->year_level,

                    'section' =>
                    $patient->section,

                    'is_pwd' =>
                    $patient->is_pwd,

                    'avatar_url' =>
                    $this->resolvePatientAvatarUrl(
                        $patient,
                        $resolvedName
                    ),

                    'record_url' =>
                    route(
                        'dentist.odontogram.existing-appointment.create',
                        [
                            'patient' =>
                            $patient->id,
                        ]
                    ),
                ];
            })
            ->all();
    }

    private function searchFacultyPatients(string $search, int $limit, FacultyApiService $facultyApiService): array
    {
        $faculties = collect($facultyApiService->getFaculties())
            ->filter(function ($faculty) use ($search) {
                if ($search === '') {
                    return true;
                }

                $haystack = strtolower(implode(' ', array_filter([
                    (string) ($faculty['name'] ?? ''),
                    (string) ($faculty['first_name'] ?? ''),
                    (string) ($faculty['middle_name'] ?? ''),
                    (string) ($faculty['last_name'] ?? ''),
                    (string) ($faculty['suffix_name'] ?? ''),
                    (string) ($faculty['email'] ?? ''),
                    (string) ($faculty['faculty_code'] ?? ''),
                    (string) ($faculty['department'] ?? ''),
                    (string) data_get($faculty, 'profile.department'),
                ])));

                return str_contains($haystack, strtolower($search));
            })
            ->take($limit)
            ->map(function (array $faculty) {
                $firstName = trim((string) ($faculty['first_name'] ?? ''));
                $middleName = trim((string) ($faculty['middle_name'] ?? ''));
                $lastName = trim((string) ($faculty['last_name'] ?? ''));
                $suffixName = trim((string) ($faculty['suffix_name'] ?? ''));
                $name = trim((string) ($faculty['name'] ?? ''));

                if ($name === '') {
                    $name = trim(collect([$firstName, $middleName, $lastName, $suffixName])->filter()->implode(' '));
                }

                if ($name === '') {
                    $name = 'Faculty Member';
                }

                $email = strtolower((string) ($faculty['email'] ?? ('faculty_' . Str::uuid() . '@walkin.local')));

                $user = $this->syncWalkInUser([
                    'name' => $name,
                    'email' => $email,
                ]);

                $patient = $this->syncWalkInPatient($user, [
                    'name' => $name,
                    'email' => $email,

                    'phone' =>
                    $faculty['contact_number']
                        ?? null,

                    'gender' =>
                    data_get($faculty, 'profile.gender'),

                    'birthdate' =>
                    $faculty['birthdate']
                        ?? $faculty['birthday']
                        ?? data_get($faculty, 'profile.birthdate'),

                    'student_number' =>
                    null,

                    'program' =>
                    $faculty['department']
                        ?? data_get($faculty, 'profile.department'),

                    'faculty_code' =>
                    $faculty['faculty_code']
                        ?? null,

                    'faculty_type' =>
                    $faculty['faculty_type']
                        ?? null,
                ], 'Faculty');

                return [
                    'id' =>
                    $patient->id,

                    'name' =>
                    $patient->name,

                    'gender' =>
                    $patient->gender
                        ?? data_get(
                            $faculty,
                            'profile.gender'
                        ),

                    'birthdate' =>
                    $faculty['birthdate']
                        ?? $faculty['birthday']
                        ?? data_get(
                            $faculty,
                            'profile.birthdate'
                        ),

                    'email' =>
                    $patient->email,

                    'phone' =>
                    $faculty['contact_number']
                        ?? $patient->phone,

                    'type' =>
                    'Faculty',

                    'student_number' =>
                    null,

                    'program' =>
                    $faculty['department']
                        ?? data_get(
                            $faculty,
                            'profile.department'
                        ),

                    'department' =>
                    $faculty['department']
                        ?? data_get(
                            $faculty,
                            'profile.department'
                        ),

                    'faculty_code' =>
                    $faculty['faculty_code']
                        ?? null,

                    'faculty_type' =>
                    $faculty['faculty_type']
                        ?? null,

                    'record_url' =>
                    route(
                        'dentist.odontogram.existing-appointment.create',
                        [
                            'patient' =>
                            $patient->id,
                        ]
                    ),

                    'avatar_url' =>
                    $this->resolvePatientAvatarUrl(
                        $patient,
                        $patient->name
                    ),
                ];
            });

        return $faculties->all();
    }

    private function searchExternalAdminPatients(string $search, int $limit): array
    {
        $baseUrl = rtrim((string) env('OCMS_EXTERNAL_API_URL'), '/');
        $apiKey = (string) env('OCMS_EXTERNAL_API_KEY');

        if ($baseUrl === '' || $apiKey === '') {
            return [];
        }

        $response = Http::timeout(15)
            ->acceptJson()
            ->withHeaders([
                'X-External-Api-Key' => $apiKey,
            ])
            ->get($baseUrl . '/external/admins', array_filter([
                'search' => $search !== '' ? $search : null,
            ]));

        if ($response->failed()) {
            Log::error('OCMS external admin search failed during walk-in', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [];
        }

        $records = collect(is_array($response->json('data')) ? $response->json('data') : [])
            ->take($limit)
            ->map(function (array $admin) {
                $name = trim((string) (($admin['name'] ?? '') ?: trim(((string) ($admin['first_name'] ?? '')) . ' ' . ((string) ($admin['last_name'] ?? '')))));
                $email = strtolower((string) (($admin['email'] ?? '') ?: ('admin_' . Str::uuid() . '@walkin.local')));
                $office = (string) ($admin['office'] ?? '');

                $user = $this->syncWalkInUser([
                    'name' => $name !== '' ? $name : 'Administrative Patient',
                    'email' => $email,
                ]);

                $patient = $this->syncWalkInPatient($user, [
                    'name' => $name !== '' ? $name : 'Administrative Patient',
                    'email' => $email,
                    'phone' => $admin['emergency_contact_no'] ?? null,
                    'gender' => $admin['gender'] ?? null,
                    'student_number' => null,
                    'program' => $office !== '' ? $office : null,
                    'faculty_code' => null,
                ], 'Administrative');

                return [
                    'id' =>
                    $patient->id,

                    'name' =>
                    $patient->name,

                    'gender' =>
                    $patient->gender
                        ?? ($admin['gender'] ?? null),

                    'email' =>
                    $patient->email,

                    'phone' =>
                    $admin['emergency_contact_no']
                        ?? $patient->phone,

                    'type' =>
                    'Administrative',

                    'student_number' =>
                    null,

                    'program' =>
                    $office !== ''
                        ? $office
                        : $patient->course_name,

                    'office' =>
                    $office !== ''
                        ? $office
                        : $patient->course_name,
                    'record_url' => route('dentist.odontogram.existing-appointment.create', ['patient' => $patient->id]),
                    'avatar_url' =>
                    $this->resolvePatientAvatarUrl(
                        $patient,
                        $patient->name
                    ),
                ];
            });

        return $records->all();
    }

    public function storeGuest(Request $request)
    {
        $validated = $request->validate([
            'guest_first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'guest_middle_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guest_last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'guest_email' => [
                'required',
                'email',
                'max:255',
            ],

            'guest_phone' => [
                'required',
                'string',
                'regex:/^09\d{9}$/',
            ],

            'guest_patient_type' => [
                'required',
                'in:student,faculty,administrative',
            ],

            'guest_gender' => [
                'required',
                'in:Male,Female',
            ],

            'guest_birthdate' => [
                'required',
                'date',
                'before:today',
            ],

            'guest_program' => [
                'nullable',
                'string',
                'max:255',
            ],

            'guest_year_level' => [
                'nullable',
                'string',
                'max:50',
            ],

            'guest_section' => [
                'nullable',
                'string',
                'max:50',
            ],

            'guest_is_pwd' => [
                'required',
                'boolean',
            ],
        ]);

        try {
            $patient = DB::transaction(function () use ($validated) {
                $email = $validated['guest_email'];
                $patientType = match ($validated['guest_patient_type']) {
                    'student' => 'Student',
                    'faculty' => 'Faculty',
                    default => 'Administrative',
                };

                $fullName = trim(
                    collect([
                        $validated['guest_first_name'],
                        $validated['guest_middle_name'] ?? null,
                        $validated['guest_last_name'],
                    ])
                        ->filter(fn($value) => filled($value))
                        ->implode(' ')
                );
                $studentLikeData = [
                    'name' => $fullName,

                    'first_name' =>
                    $validated['guest_first_name'],

                    'middle_name' =>
                    $validated['guest_middle_name'] ?? null,

                    'last_name' =>
                    $validated['guest_last_name'],

                    'email' =>
                    strtolower($email),

                    'phone' =>
                    $validated['guest_phone'] ?? null,

                    'gender' =>
                    $validated['guest_gender'],

                    'birthdate' =>
                    $validated['guest_birthdate'],

                    'program' =>
                    $validated['guest_program'] ?? null,

                    'year_level' =>
                    $validated['guest_year_level'] ?? null,

                    'section' =>
                    $validated['guest_section'] ?? null,

                    'is_pwd' =>
                    (bool) $validated['guest_is_pwd'],

                    'student_number' => null,
                    'patient_type' => $patientType,
                ];

                $user = $this->syncWalkInUser($studentLikeData);
                return $this->syncWalkInPatient($user, $studentLikeData, $patientType);
            });

            return response()->json([
                'success' => true,
                'patient' => [
                    'id' =>
                    $patient->id,

                    'name' =>
                    $patient->name
                        ?? optional(
                            $patient->user
                        )->name,

                    'first_name' =>
                    optional(
                        $patient->user
                    )->first_name,

                    'middle_name' =>
                    optional(
                        $patient->user
                    )->middle_name,

                    'last_name' =>
                    optional(
                        $patient->user
                    )->last_name,

                    'gender' =>
                    $patient->gender,


                    'email' =>
                    $patient->email
                        ?? optional($patient->user)->email,

                    'phone' => $patient->phone,

                    'birthdate' => $patient->birthdate,

                    'program' => $patient->course_name,

                    'faculty_code' => $patient->faculty_code,

                    'year_level' => $patient->year_level,

                    'section' => $patient->section,

                    'is_pwd' => (bool) $patient->is_pwd,

                    'avatar_url' =>
                    $this->resolvePatientAvatarUrl(
                        $patient,
                        $patient->name
                            ?? optional($patient->user)->name
                    ),

                    'patient_type' => $patient->patient_type,
                    'type' => $patient->patient_type ?: 'Guest',
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Walk-in guest creation failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create guest patient.',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function startWalkIn(Request $request)
    {
        $existingMedicalHistory = null;
        $hasReusableSignature = false;

        if ($request->filled('patient_id')) {
            $existingMedicalHistory =
                MedicalHistory::where(
                    'patient_id',
                    $request->input('patient_id')
                )->first();

            $hasReusableSignature =
                !empty($existingMedicalHistory?->patient_signature) &&
                $existingMedicalHistory?->signature_review_status !==
                'invalid_reupload_required';
        }

        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'service_type' => ['required', 'string', 'max:255'],
            'concern' => ['nullable', 'string', 'max:1000'],

            'emergency_person' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÑñ\s.\'-]+$/u',
            ],

            'emergency_number' => ['required', 'string', 'max:15'],
            'emergency_relation' => ['required', 'string', 'max:50'],

            'patient_signature' => [
                $hasReusableSignature
                    ? 'nullable'
                    : 'required',

                'file',
                'mimes:png,jpg,jpeg',
                'max:25600',
            ],

            'signature_source' => [
                'nullable',
                'in:drawn,upload',
            ],

            'diseases' => [
                'nullable',
                'array',
            ],

            'diseases.*' => [
                'string',
                'exists:diseases,code',
            ],
        ]);

        $patient = Patient::findOrFail(
            $validated['patient_id']
        );

        $now = Carbon::now();

        if ($request->hasFile('patient_signature')) {
            $signaturePath =
                $request
                ->file('patient_signature')
                ->store(
                    'signatures',
                    'public'
                );
        } elseif ($hasReusableSignature) {
            $signaturePath =
                $existingMedicalHistory
                ->patient_signature;
        } else {
            return response()->json([
                'success' => false,
                'message' =>
                'Patient signature is required.',
            ], 422);
        }

        $appointmentData = [
            'patient_id' => $patient->id,
            'dentist_id' => Auth::id(),
            'service_type' => $validated['service_type'],
            'appointment_date' => $now->toDateString(),
            'appointment_time' => $now->format('H:i:s'),
            'status' => 'upcoming',
        ];

        if (Schema::hasColumn('appointments', 'is_walk_in')) {
            $appointmentData['is_walk_in'] = true;
        }

        if (
            Schema::hasColumn(
                'appointments',
                'concern'
            )
        ) {
            $appointmentData['concern'] =
                $validated['concern'] ?? null;
        }

        $appointment = null;

        try {
            DB::transaction(
                function () use (
                    $request,
                    $patient,
                    $validated,
                    $appointmentData,
                    $signaturePath,
                    &$appointment
                ) {

                    $appointment =
                        Appointment::create(
                            $appointmentData
                        );

                    DentalHistory::updateOrCreate(
                        [
                            'patient_id' =>
                            $patient->id,
                        ],
                        [
                            'last_dental_visit' =>
                            $request->input(
                                'last_dental_visit'
                            ),

                            'previous_dentist' =>
                            $request->input(
                                'previous_dentist'
                            ),
                        ]
                    );

                    DentalHistoryConditionDate::updateOrCreate(
                        [
                            'patient_id' =>
                            $patient->id,
                        ],
                        [
                            'extraction_date' =>
                            $request->input(
                                'extraction_date'
                            ),

                            'dentures_date' =>
                            $request->input(
                                'dentures_date'
                            ),

                            'ortho_date' =>
                            $request->input(
                                'ortho_date'
                            ),
                        ]
                    );

                    DentalHistoryConcern::updateOrCreate(
                        [
                            'patient_id' =>
                            $patient->id,
                        ],
                        [
                            'additional_concerns' =>
                            $request->input(
                                'additional_concerns'
                            ),
                        ]
                    );

                    $dentalAnswerMap = [
                        'bleeding_gums' =>
                        $request->input(
                            'bleeding_gums'
                        ),

                        'sensitive_temp' =>
                        $request->input(
                            'sensitive_temp'
                        ),

                        'sensitive_taste' =>
                        $request->input(
                            'sensitive_taste'
                        ),

                        'tooth_pain' =>
                        $request->input(
                            'tooth_pain'
                        ),

                        'sores' =>
                        $request->input(
                            'sores'
                        ),

                        'injuries' =>
                        $request->input(
                            'injuries'
                        ),

                        'clicking' =>
                        $request->input(
                            'clicking'
                        ),

                        'joint_pain' =>
                        $request->input(
                            'joint_pain'
                        ),

                        'difficulty_moving' =>
                        $request->input(
                            'difficulty_moving'
                        ),

                        'difficulty_chewing' =>
                        $request->input(
                            'difficulty_chewing'
                        ),

                        'jaw_headaches' =>
                        $request->input(
                            'jaw_headaches'
                        ),

                        'clench_grind' =>
                        $request->input(
                            'clench_grind'
                        ),

                        'biting' =>
                        $request->input(
                            'biting'
                        ),

                        'teeth_loosening' =>
                        $request->input(
                            'teeth_loosening'
                        ),

                        'food_teeth' =>
                        $request->input(
                            'food_teeth'
                        ),

                        'med_reaction' =>
                        $request->input(
                            'med_reaction'
                        ),

                        'periodontal' =>
                        $request->input(
                            'periodontal'
                        ),

                        'difficult_extraction' =>
                        $request->input(
                            'difficult_extraction'
                        ),

                        'prolonged_bleeding' =>
                        $request->input(
                            'prolonged_bleeding'
                        ),

                        'dentures' =>
                        $request->input(
                            'dentures'
                        ),

                        'ortho_treatment' =>
                        $request->input(
                            'ortho_treatment'
                        ),
                    ];

                    $conditionIdsByCode =
                        DentalHistoryCondition::whereIn(
                            'code',
                            array_keys(
                                $dentalAnswerMap
                            )
                        )
                        ->pluck(
                            'id',
                            'code'
                        );

                    foreach (
                        $dentalAnswerMap
                        as $code => $rawValue
                    ) {
                        $conditionId =
                            $conditionIdsByCode[$code] ?? null;

                        if (!$conditionId) {
                            continue;
                        }

                        DentalHistoryAnswer::updateOrCreate(
                            [
                                'patient_id' =>
                                $patient->id,

                                'condition_id' =>
                                $conditionId,
                            ],
                            [
                                'answer' =>
                                $this->yesNoValue(
                                    $rawValue
                                ) === 'YES',
                            ]
                        );
                    }

                    $medicalHistory =
                        MedicalHistory::updateOrCreate(
                            [
                                'patient_id' =>
                                $patient->id,
                            ],
                            [
                                'emergency_person' =>
                                $validated['emergency_person'],

                                'emergency_number' =>
                                $validated['emergency_number'],

                                'emergency_relation' =>
                                $validated['emergency_relation'],

                                'patient_signature' =>
                                $signaturePath,
                            ]
                        );

                    $medicalAnswerMap = [
                        'good_health' =>
                        $request->input(
                            'good_health'
                        ),

                        'had_medical_exam' =>
                        $request->input(
                            'had_medical_exam'
                        ),

                        'under_treatment' =>
                        $request->input(
                            'under_treatment'
                        ),

                        'hospitalized' =>
                        $request->input(
                            'hospitalized'
                        ),

                        'allergy_medicine' =>
                        $request->input(
                            'allergy_medicine'
                        ),

                        'allergy_food' =>
                        $request->input(
                            'allergy_food'
                        ),

                        'medication' =>
                        $request->input(
                            'medication'
                        ),

                        'pregnant' =>
                        $request->input(
                            'pregnant'
                        ),

                        'nursing' =>
                        $request->input(
                            'nursing'
                        ),

                        'birth_control' =>
                        $request->input(
                            'birth_control'
                        ),

                        'tobacco_use' =>
                        $request->input(
                            'tobacco_use'
                        ),

                        'headaches' =>
                        $request->input(
                            'headaches'
                        ),

                        'earaches' =>
                        $request->input(
                            'earaches'
                        ),

                        'neck_aches' =>
                        $request->input(
                            'neck_aches'
                        ),

                        'good_health_details' =>
                        $request->input(
                            'good_health_details'
                        ),

                        'treatment_details' =>
                        $request->input(
                            'treatment_details'
                        ),

                        'hospital_details' =>
                        $request->input(
                            'hospital_details'
                        ),

                        'allergy_others' =>
                        $request->input(
                            'allergy_others'
                        ),

                        'medication_details' =>
                        $request->input(
                            'medication_details'
                        ),

                        'tobacco_per_day' =>
                        $request->input(
                            'tobacco_per_day'
                        ),

                        'tobacco_per_week' =>
                        $request->input(
                            'tobacco_per_week'
                        ),

                        'medical_exam_date' =>
                        $request->input(
                            'medical_exam_date'
                        ),
                    ];

                    $questions =
                        MedicalHistoryQuestion::whereIn(
                            'code',
                            array_keys(
                                $medicalAnswerMap
                            )
                        )
                        ->get()
                        ->keyBy(
                            'code'
                        );

                    foreach (
                        $medicalAnswerMap
                        as $code => $rawValue
                    ) {
                        $question =
                            $questions->get(
                                $code
                            );

                        if (!$question) {
                            continue;
                        }

                        $criteria = [
                            'patient_id' =>
                            $patient->id,

                            'medical_history_id' =>
                            $medicalHistory->id,

                            'question_id' =>
                            $question->id,
                        ];

                        if (
                            $question->type ===
                            'bool'
                        ) {
                            MedicalHistoryAnswer::updateOrCreate(
                                $criteria,
                                [
                                    'answer_bool' =>
                                    $this->yesNoValue(
                                        $rawValue
                                    ) === 'YES',

                                    'answer_text' =>
                                    null,

                                    'answer_date' =>
                                    null,
                                ]
                            );

                            continue;
                        }

                        if (
                            $question->type ===
                            'date'
                        ) {
                            $dateValue =
                                trim(
                                    (string) $rawValue
                                );

                            if (
                                $dateValue === ''
                            ) {
                                MedicalHistoryAnswer::where(
                                    $criteria
                                )->delete();

                                continue;
                            }

                            MedicalHistoryAnswer::updateOrCreate(
                                $criteria,
                                [
                                    'answer_bool' =>
                                    null,

                                    'answer_text' =>
                                    null,

                                    'answer_date' =>
                                    $dateValue,
                                ]
                            );

                            continue;
                        }

                        $textValue =
                            trim(
                                (string) $rawValue
                            );

                        if (
                            $textValue === ''
                        ) {
                            MedicalHistoryAnswer::where(
                                $criteria
                            )->delete();

                            continue;
                        }

                        MedicalHistoryAnswer::updateOrCreate(
                            $criteria,
                            [
                                'answer_bool' =>
                                null,

                                'answer_text' =>
                                $textValue,

                                'answer_date' =>
                                null,
                            ]
                        );
                    }

                    $selectedDiseaseCodes =
                        $request->input(
                            'diseases',
                            []
                        );

                    $selectedDiseaseIds =
                        Disease::whereIn(
                            'code',
                            $selectedDiseaseCodes
                        )
                        ->pluck(
                            'id'
                        )
                        ->all();

                    MedicalHistoryDiseaseAnswer::where(
                        'medical_history_id',
                        $medicalHistory->id
                    )->delete();

                    foreach (
                        $selectedDiseaseIds
                        as $diseaseId
                    ) {
                        MedicalHistoryDiseaseAnswer::create([
                            'patient_id' =>
                            $patient->id,

                            'medical_history_id' =>
                            $medicalHistory->id,

                            'disease_id' =>
                            $diseaseId,

                            'has_disease' =>
                            true,
                        ]);
                    }
                }
            );
        } catch (\Throwable $error) {
            Log::error(
                'Walk-in appointment creation failed',
                [
                    'message' =>
                    $error->getMessage(),

                    'file' =>
                    $error->getFile(),

                    'line' =>
                    $error->getLine(),

                    'patient_id' =>
                    $patient->id,
                ]
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,

                    'message' =>
                    config('app.debug')
                        ? $error->getMessage()
                        : 'Unable to create the walk-in appointment.',
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create the walk-in appointment.'
                );
        }

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' =>
                'The walk-in appointment could not be created.',
            ], 500);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,

                'message' =>
                'The walk-in appointment was recorded successfully.',

                'appointment_id' =>
                $appointment->id,

                'start_url' =>
                route(
                    'dentist.odontogram',
                    [
                        'appointment' =>
                        $appointment->id,
                    ]
                ) .
                    '?from=walk-in&start_procedure=1',
            ]);
        }

        return redirect()
            ->route(
                'dentist.odontogram',
                [
                    'appointment' =>
                    $appointment->id,
                ]
            )
            ->with(
                'success',
                'The walk-in appointment was recorded successfully.'
            );
    }

    private function syncWalkInUser(array $data): User
    {
        $email = strtolower(
            trim(
                (string) ($data['email'] ?? '')
            )
        );

        $user = User::where(
            'email',
            $email
        )->first();

        $userData = [];

        if (
            Schema::hasColumn('users', 'name') &&
            filled($data['name'] ?? null)
        ) {
            $userData['name'] =
                trim((string) $data['name']);
        }

        if (
            Schema::hasColumn('users', 'first_name') &&
            array_key_exists('first_name', $data)
        ) {
            $userData['first_name'] =
                filled($data['first_name'])
                ? trim((string) $data['first_name'])
                : null;
        }

        if (
            Schema::hasColumn('users', 'middle_name') &&
            array_key_exists('middle_name', $data)
        ) {
            $userData['middle_name'] =
                filled($data['middle_name'])
                ? trim((string) $data['middle_name'])
                : null;
        }

        if (
            Schema::hasColumn('users', 'last_name') &&
            array_key_exists('last_name', $data)
        ) {
            $userData['last_name'] =
                filled($data['last_name'])
                ? trim((string) $data['last_name'])
                : null;
        }

        if (!$user) {
            $user = new User();

            $userData['email'] =
                $email;

            $userData['password'] =
                bcrypt(
                    Str::random(32)
                );

            if (
                Schema::hasColumn(
                    'users',
                    'role'
                )
            ) {
                $userData['role'] =
                    'patient';
            }

            if (
                Schema::hasColumn(
                    'users',
                    'user_type'
                )
            ) {
                $userData['user_type'] =
                    'patient';
            }

            if (
                Schema::hasColumn(
                    'users',
                    'status'
                )
            ) {
                $userData['status'] =
                    'active';
            }

            $user->forceFill(
                $userData
            );

            $user->save();

            return $user;
        }

        if (!empty($userData)) {
            $user->forceFill(
                $userData
            );

            $user->save();
        }

        return $user;
    }

    private function syncWalkInPatient(
        User $user,
        array $data,
        string $type
    ): Patient {
        $patient = Patient::where('user_id', $user->id)->first();

        $patientData = [
            'user_id' => $user->id,
        ];


        if (
            Schema::hasColumn('patients', 'name') &&
            array_key_exists('name', $data) &&
            filled($data['name'])
        ) {
            $patientData['name'] = $data['name'];
        }

        if (
            Schema::hasColumn('patients', 'email') &&
            array_key_exists('email', $data) &&
            filled($data['email'])
        ) {
            $patientData['email'] = strtolower((string) $data['email']);
        }

        if (
            Schema::hasColumn('patients', 'phone') &&
            array_key_exists('phone', $data) &&
            filled($data['phone'])
        ) {
            $patientData['phone'] = $data['phone'];
        }


        if (
            Schema::hasColumn('patients', 'gender') &&
            array_key_exists('gender', $data) &&
            filled($data['gender'])
        ) {
            $patientData['gender'] = $data['gender'];
        }

        if (
            Schema::hasColumn('patients', 'birthdate') &&
            array_key_exists('birthdate', $data) &&
            filled($data['birthdate'])
        ) {
            $patientData['birthdate'] = $data['birthdate'];
        }

        if (
            Schema::hasColumn('patients', 'year_level') &&
            array_key_exists('year_level', $data) &&
            filled($data['year_level'])
        ) {
            $patientData['year_level'] = $data['year_level'];
        }

        if (
            Schema::hasColumn('patients', 'section') &&
            array_key_exists('section', $data) &&
            filled($data['section'])
        ) {
            $patientData['section'] = $data['section'];
        }


        if (
            Schema::hasColumn('patients', 'is_pwd') &&
            array_key_exists('is_pwd', $data) &&
            $data['is_pwd'] !== null
        ) {
            $patientData['is_pwd'] = (bool) $data['is_pwd'];
        }


        if (
            Schema::hasColumn('patients', 'program_code') &&
            array_key_exists('program', $data) &&
            filled($data['program'])
        ) {
            $patientData['program_code'] = $data['program'];
        }

        if (
            Schema::hasColumn('patients', 'course_name') &&
            array_key_exists('program', $data) &&
            filled($data['program'])
        ) {
            $patientData['course_name'] = $data['program'];
        }

        if (
            Schema::hasColumn('patients', 'faculty_code') &&
            array_key_exists('faculty_code', $data) &&
            filled($data['faculty_code'])
        ) {
            $patientData['faculty_code'] = $data['faculty_code'];
        }


        if (
            Schema::hasColumn('patients', 'student_number') &&
            array_key_exists('student_number', $data) &&
            filled($data['student_number'])
        ) {
            $patientData['student_number'] =
                $data['student_number'];
        }

        if (
            Schema::hasColumn('patients', 'student_no') &&
            array_key_exists('student_number', $data) &&
            filled($data['student_number'])
        ) {
            $patientData['student_no'] =
                $data['student_number'];
        }


        if (Schema::hasColumn('patients', 'patient_type')) {
            $patientData['patient_type'] = $type;
        }

        if (Schema::hasColumn('patients', 'type')) {
            $patientData['type'] = $type;
        }

        if (Schema::hasColumn('patients', 'status')) {
            $patientData['status'] = 'active';
        }

        if (Schema::hasColumn('patients', 'role')) {
            $patientData['role'] = 'patient';
        }


        if (! $patient) {

            if (
                Schema::hasColumn('patients', 'phone') &&
                array_key_exists('phone', $data) &&
                ! array_key_exists('phone', $patientData)
            ) {
                $patientData['phone'] = $data['phone'];
            }

            if (
                Schema::hasColumn('patients', 'program_code') &&
                array_key_exists('program', $data) &&
                ! array_key_exists('program_code', $patientData)
            ) {
                $patientData['program_code'] =
                    $data['program'];
            }

            if (
                Schema::hasColumn('patients', 'course_name') &&
                array_key_exists('program', $data) &&
                ! array_key_exists('course_name', $patientData)
            ) {
                $patientData['course_name'] =
                    $data['program'];
            }

            if (
                Schema::hasColumn('patients', 'faculty_code') &&
                array_key_exists('faculty_code', $data) &&
                ! array_key_exists('faculty_code', $patientData)
            ) {
                $patientData['faculty_code'] =
                    $data['faculty_code'];
            }

            if (
                Schema::hasColumn('patients', 'year_level') &&
                array_key_exists('year_level', $data) &&
                ! array_key_exists('year_level', $patientData)
            ) {
                $patientData['year_level'] =
                    $data['year_level'];
            }

            if (
                Schema::hasColumn('patients', 'section') &&
                array_key_exists('section', $data) &&
                ! array_key_exists('section', $patientData)
            ) {
                $patientData['section'] =
                    $data['section'];
            }

            if (
                Schema::hasColumn('patients', 'is_pwd') &&
                array_key_exists('is_pwd', $data) &&
                ! array_key_exists('is_pwd', $patientData)
            ) {
                $patientData['is_pwd'] =
                    (bool) $data['is_pwd'];
            }

            if (
                Schema::hasColumn('patients', 'password')
            ) {
                $patientData['password'] =
                    bcrypt(Str::random(32));
            }

            $patient = new Patient();
            $patient->forceFill($patientData);
            $patient->save();

            return $patient;
        }

        if (
            Schema::hasColumn('patients', 'password') &&
            empty($patient->password)
        ) {
            $patientData['password'] =
                bcrypt(Str::random(32));
        }

        $patient->forceFill($patientData);
        $patient->save();

        return $patient;
    }

    private function resolvePatientAvatarUrl(
        Patient $patient,
        ?string $displayName = null
    ): ?string {
        $patientAvatar = '';

        if (
            Schema::hasColumn(
                $patient->getTable(),
                'profile_image'
            )
        ) {
            $patientAvatar = trim(
                (string) (
                    $patient->getAttribute(
                        'profile_image'
                    ) ?? ''
                )
            );
        }

        $userAvatar = '';

        if (
            $patient->user &&
            Schema::hasColumn(
                $patient->user->getTable(),
                'profile_image'
            )
        ) {
            $userAvatar = trim(
                (string) (
                    $patient->user->getAttribute(
                        'profile_image'
                    ) ?? ''
                )
            );
        }

        foreach (
            [
                $patientAvatar,
                $userAvatar,
            ] as $avatar
        ) {
            if ($avatar === '') {
                continue;
            }

            $path = ltrim(
                str_replace(
                    'storage/',
                    '',
                    $avatar
                ),
                '/'
            );

            if (
                Storage::disk('public')->exists(
                    $path
                )
            ) {
                return Storage::disk('public')->url(
                    $path
                );
            }
        }

        return null;
    }

    private function yesNoValue($value): string
    {
        $normalized =
            strtoupper(
                trim(
                    (string) $value
                )
            );

        return $normalized === 'YES'
            ? 'YES'
            : 'NO';
    }
}
