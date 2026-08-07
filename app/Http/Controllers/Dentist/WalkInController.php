<?php

namespace App\Http\Controllers\Dentist;

use App\Helpers\PhilippineHolidays;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BlockedDate;
use App\Models\ClinicSchedule;
use App\Models\Disease;
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

        return view('dentist.dentist-walk-in', compact(
            'serviceTypes',
            'diseases',
            'schedules',
            'blockedDates',
            'appointmentCountsPerDay',
            'philippineHolidays'
        ));
    }

    public function searchPatient(
        Request $request,
        FacultyApiService $facultyApiService,
        StudentApiService $studentApiService
    ) {
        $search = trim((string) $request->query('q', ''));
        $showAll = $request->boolean('show_all');

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
        $sourceLimit = 150;

        if ($search === '' && ! $showAll) {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => $perPage,
                'total' => 0,
                'from' => null,
                'to' => null,
            ]);
        }

        try {
            $hasMeaningfulSearch = mb_strlen($search) >= 2;

            $patients = collect()
                ->merge(
                    $this->searchLocalPatients(
                        $search,
                        $sourceLimit
                    )
                )
                ->merge(
                    $hasMeaningfulSearch
                        ? $this->searchOgosPatients(
                            $search,
                            $sourceLimit,
                            $studentApiService
                        )
                        : []
                )
                ->merge(
                    $hasMeaningfulSearch
                        ? $this->searchFacultyPatients(
                            $search,
                            $sourceLimit,
                            $facultyApiService
                        )
                        : []
                )
                ->merge(
                    $hasMeaningfulSearch
                        ? $this->searchExternalAdminPatients(
                            $search,
                            $sourceLimit
                        )
                        : []
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
                ->sortByDesc('_score')
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
                        'id' => $patient->id,
                        'name' => $student['name'],
                        'gender' => $student['gender'] ?? null,
                        'email' => $student['email'],
                        'type' => 'Student',
                        'student_number' => $student['student_number'] ?? null,
                        'program' => $student['program'] ?? null,
                        'record_url' => route('dentist.odontogram.historical.create', ['patient' => $patient->id]),
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
            'student_no',
            'course_name',
            'faculty_code',
        ];

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

                return [
                    'id' => $patient->id,

                    'name' =>
                    $resolvedName !== ''
                        ? $resolvedName
                        : 'Patient',

                    'gender' =>
                    $patient->gender,

                    'email' =>
                    $patient->email
                        ?? $user?->email,

                    'type' =>
                    $patient->faculty_code
                        ? 'Faculty'
                        : (
                            $patient->student_no
                            ? 'Student'
                            : 'Patient'
                        ),

                    'student_number' =>
                    $patient->student_no,

                    'program' =>
                    $patient->course_name
                        ?? $patient->faculty_code,

                    'faculty_code' =>
                    $patient->faculty_code,

                    'avatar_url' =>
                    $this->resolvePatientAvatarUrl(
                        $patient,
                        $resolvedName
                    ),

                    'record_url' =>
                    route(
                        'dentist.odontogram.historical.create',
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
                    'phone' => $faculty['contact_number'] ?? null,
                    'gender' => data_get($faculty, 'profile.gender'),
                    'student_number' => null,
                    'program' => $faculty['faculty_code'] ?? $faculty['department'] ?? data_get($faculty, 'profile.department'),
                    'faculty_code' => $faculty['faculty_code'] ?? null,
                ], 'Faculty');

                return [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'gender' =>
                    $patient->gender
                        ?? data_get(
                            $faculty,
                            'profile.gender'
                        ),
                    'email' => $patient->email,
                    'type' => 'Faculty',
                    'student_number' => null,
                    'program' => $faculty['faculty_code'] ?? $faculty['department'] ?? data_get($faculty, 'profile.department'),
                    'faculty_code' => $faculty['faculty_code'] ?? null,
                    'record_url' => route('dentist.odontogram.historical.create', ['patient' => $patient->id]),
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
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'gender' =>
                    $patient->gender
                        ?? ($admin['gender'] ?? null),
                    'email' => $patient->email,
                    'type' => 'Administrative',
                    'student_number' => null,
                    'program' => $office !== '' ? $office : null,
                    'record_url' => route('dentist.odontogram.historical.create', ['patient' => $patient->id]),
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
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'guest_phone' => ['nullable', 'string', 'max:30'],
        ]);

        try {
            $patient = DB::transaction(function () use ($validated) {
                $email = $validated['guest_email'] ?: 'guest_' . Str::uuid() . '@walkin.local';

                $studentLikeData = [
                    'name' => $validated['guest_name'],
                    'email' => strtolower($email),
                    'phone' => $validated['guest_phone'] ?? null,
                    'gender' => null,
                    'program' => null,
                    'student_number' => null,
                ];

                $user = $this->syncWalkInUser($studentLikeData);
                return $this->syncWalkInPatient($user, $studentLikeData, 'Guest');
            });

            return response()->json([
                'success' => true,
                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->name ?? optional($patient->user)->name,
                    'gender' => $patient->gender,
                    'email' => $patient->email ?? optional($patient->user)->email,
                    'avatar_url' =>
                    $this->resolvePatientAvatarUrl(
                        $patient,
                        $patient->name
                            ?? optional($patient->user)->name
                    ),
                    'type' => 'Guest',
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

            'patient_signature' => ['required', 'file', 'mimes:png,jpg,jpeg', 'max:25600'],
        ]);

        $patient = Patient::findOrFail($validated['patient_id']);
        $now = Carbon::now();

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

        if (Schema::hasColumn('appointments', 'concern')) {
            $appointmentData['concern'] = $validated['concern'] ?? null;
        }

        $appointment = Appointment::create(
            $appointmentData
        );

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
        $email = strtolower((string) $data['email']);

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = new User();

            $userData = [
                'name' => $data['name'],
                'email' => $email,
                'password' => bcrypt(Str::random(32)),
            ];

            if (Schema::hasColumn('users', 'role')) {
                $userData['role'] = 'patient';
            }

            if (Schema::hasColumn('users', 'user_type')) {
                $userData['user_type'] = 'patient';
            }

            if (Schema::hasColumn('users', 'status')) {
                $userData['status'] = 'active';
            }

            $user->forceFill($userData);
            $user->save();

            return $user;
        }

        $updates = [];

        if (Schema::hasColumn('users', 'name')) {
            $updates['name'] = $data['name'];
        }

        if (! empty($updates)) {
            $user->forceFill($updates);
            $user->save();
        }

        return $user;
    }
    private function syncWalkInPatient(User $user, array $data, string $type): Patient
    {
        $patient = Patient::where('user_id', $user->id)->first();

        $patientData = [
            'user_id' => $user->id,
        ];

        if (Schema::hasColumn('patients', 'name')) {
            $patientData['name'] = $data['name'];
        }

        if (Schema::hasColumn('patients', 'email')) {
            $patientData['email'] = $data['email'];
        }

        if (Schema::hasColumn('patients', 'phone')) {
            $patientData['phone'] = $data['phone'] ?? null;
        }

        if (Schema::hasColumn('patients', 'gender')) {
            $patientData['gender'] = $data['gender'] ?? null;
        }

        if (Schema::hasColumn('patients', 'faculty_code')) {
            $patientData['faculty_code'] = $data['faculty_code'] ?? null;
        }

        if (Schema::hasColumn('patients', 'program_code')) {
            $patientData['program_code'] = $data['program'] ?? null;
        }

        if (Schema::hasColumn('patients', 'course_name')) {
            $patientData['course_name'] = $data['program'] ?? null;
        }

        if (Schema::hasColumn('patients', 'student_number')) {
            $patientData['student_number'] = $data['student_number'] ?? null;
        }

        if (Schema::hasColumn('patients', 'student_no')) {
            $patientData['student_no'] = $data['student_number'] ?? null;
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
            if (Schema::hasColumn('patients', 'password')) {
                $patientData['password'] = bcrypt(Str::random(32));
            }

            $patient = new Patient();
            $patient->forceFill($patientData);
            $patient->save();

            return $patient;
        }

        if (Schema::hasColumn('patients', 'password') && empty($patient->password)) {
            $patientData['password'] = bcrypt(Str::random(32));
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
}
