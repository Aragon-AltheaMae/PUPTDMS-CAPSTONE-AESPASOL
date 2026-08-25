<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

class DentalRecordController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $status = trim((string) $request->input('status', 'all'));
        $perPageInput = (int) $request->input('per_page', 10);
        $perPage = in_array($perPageInput, [10, 20, 50, 100], true) ? $perPageInput : 10;

        $statsCollection = $this->loadRecordPatients(
            $this->applyRecordFilters($this->buildRecordPatientsQuery(), '', 'all')
        );

        $totalRecords = $statsCollection->count();
        $recordsToday = $statsCollection->filter(fn ($record) => $record->date_iso === Carbon::today()->toDateString())->count();
        $pending = $statsCollection->where('status', 'pending')->count();
        $ongoingCount = $statsCollection->where('status', 'ongoing')->count();
        $completedCount = $statsCollection->where('status', 'completed')->count();
        $cancelledCount = $statsCollection->where('status', 'cancelled')->count();
        $topProcedure = $statsCollection
            ->pluck('procedure')
            ->filter(fn ($procedure) => filled($procedure) && $procedure !== 'Dental Record')
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first() ?? 'No data yet';
        $completedThisWeek = $statsCollection
            ->filter(function ($record) {
                if ($record->status !== 'completed' || empty($record->date_iso)) {
                    return false;
                }

                $date = Carbon::parse($record->date_iso);

                return $date->betweenIncluded(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
            })
            ->count();
        $patientsForFollowUp = $statsCollection->filter(fn ($record) => $record->has_follow_up)->count();

        $recordsPaginator = $this->applyRecordFilters(
            $this->buildRecordPatientsQuery(),
            $search,
            $status
        )->paginate($perPage)->withQueryString();

        $recordItems = $this->summarizePatients($recordsPaginator->getCollection());
        $recordsPaginator->setCollection($recordItems);
        $records = $recordsPaginator;

        $viewData = compact(
            'totalRecords',
            'recordsToday',
            'pending',
            'ongoingCount',
            'completedCount',
            'cancelledCount',
            'records',
            'topProcedure',
            'completedThisWeek',
            'patientsForFollowUp'
        );

        $isPaginator = $records instanceof AbstractPaginator;

        $pagination = [
            'current_page' => $isPaginator ? $records->currentPage() : 1,
            'last_page' => $isPaginator ? $records->lastPage() : 1,
            'total' => $isPaginator ? $records->total() : $records->count(),
            'from' => $isPaginator ? ($records->firstItem() ?? 0) : 0,
            'to' => $isPaginator ? ($records->lastItem() ?? 0) : $records->count(),
            'per_page' => $isPaginator ? $records->perPage() : $perPage,
        ];

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.dental-records', $viewData + [
                    'layoutRole' => $this->resolveLayoutRole(),
                ])->render(),
                'pagination' => $pagination,
                'counts' => [
                    'all' => $totalRecords,
                    'today' => $recordsToday,
                    'pending' => $pending,
                    'ongoing' => $ongoingCount,
                    'completed' => $completedCount,
                    'cancelled' => $cancelledCount,
                ],
            ]);
        }

        return view('admin.dental-records', $viewData + [
            'layoutRole' => $this->resolveLayoutRole(),
        ]);
    }

    public function show(Request $request, Patient $patient)
    {
        $patient->load([
            'appointments' => function ($query) {
                $query->with([
                    'dentist:id,name',
                    'procedure',
                    'followUpAppointments' => function ($followUpQuery) {
                        $followUpQuery
                            ->orderBy('appointment_date', 'asc')
                            ->orderBy('appointment_time', 'asc');
                    },
                ])->orderBy('appointment_date', 'desc')
                    ->orderBy('appointment_time', 'desc');
            },
            'medicalHistory.answers.question',
            'medicalHistory.diseaseAnswers.disease',
            'dentalHistory',
            'dentalHistoryDates',
            'dentalHistoryConcerns',
            'dentalHistoryAnswers.condition',
            'odontogram',
        ]);

        $record = $this->buildPatientRecordSummary($patient);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json($record);
        }

        return redirect()->route('admin.admin.patient.profile', [
            'patient' => $patient->id,
            'from' => 'patients',
        ]);
    }

    private function buildRecordPatientsQuery(): Builder
    {
        return Patient::query()
            ->where(function (Builder $query) {
                $query->has('appointments')
                    ->orHas('medicalHistory')
                    ->orHas('dentalHistory')
                    ->orHas('dentalHistoryAnswers')
                    ->orHas('dentalHistoryConcerns')
                    ->orHas('odontogram');
            })
            ->with([
                'appointments' => function ($query) {
                    $query->with([
                        'dentist:id,name',
                        'procedure',
                        'followUpAppointments' => function ($followUpQuery) {
                            $followUpQuery
                                ->orderBy('appointment_date', 'asc')
                                ->orderBy('appointment_time', 'asc');
                        },
                    ])->orderBy('appointment_date', 'desc')
                        ->orderBy('appointment_time', 'desc');
                },
                'medicalHistory.answers.question',
                'medicalHistory.diseaseAnswers.disease',
                'dentalHistory',
                'dentalHistoryDates',
                'dentalHistoryConcerns',
                'dentalHistoryAnswers.condition',
                'odontogram',
            ])
            ->orderBy('name');
    }

    private function applyRecordFilters(Builder $query, string $search, string $status): Builder
    {
        if ($search !== '') {
            $query->where(function (Builder $searchQuery) use ($search) {
                $searchQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('appointments', function (Builder $appointmentQuery) use ($search) {
                        $appointmentQuery->where('service_type', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhereHas('dentist', function (Builder $dentistQuery) use ($search) {
                                $dentistQuery->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        if ($status !== 'all') {
            $query->where(function (Builder $statusQuery) use ($status) {
                if ($status === 'today') {
                    $statusQuery->whereHas('appointments', function (Builder $appointmentQuery) {
                        $appointmentQuery->whereDate('appointment_date', Carbon::today());
                    });

                    return;
                }

                if ($status === 'ongoing') {
                    $statusQuery->whereHas('appointments', function (Builder $appointmentQuery) {
                        $appointmentQuery->whereIn('status', ['ongoing', 'in-progress', 'in_progress']);
                    });

                    return;
                }

                if ($status === 'cancelled') {
                    $statusQuery->whereHas('appointments', function (Builder $appointmentQuery) {
                        $appointmentQuery->whereIn('status', ['cancelled', 'canceled']);
                    });

                    return;
                }

                if (in_array($status, ['pending', 'completed'], true)) {
                    $statusQuery->whereHas('appointments', function (Builder $appointmentQuery) use ($status) {
                        $appointmentQuery->where('status', $status);
                    });
                }
            });
        }

        return $query;
    }

    private function loadRecordPatients(Builder $query): Collection
    {
        return $this->summarizePatients($query->get());
    }

    private function summarizePatients(Collection $patients): Collection
    {
        return $patients
            ->map(fn (Patient $patient) => $this->buildPatientRecordSummary($patient))
            ->sortByDesc(function ($record) {
                return $record->date_sort ?? '1900-01-01 00:00:00';
            })
            ->values();
    }

    private function buildPatientRecordSummary(Patient $patient): object
    {
        $appointments = $patient->appointments ?? collect();
        $latestAppointment = $appointments->first();
        $latestProcedure = $latestAppointment?->procedure;
        $followUpAppointment = $latestAppointment?->followUpAppointments?->first();
        $latestActivityAt = $this->resolveLatestActivityAt($patient, $latestAppointment, $latestProcedure);
        $status = $this->normalizeRecordStatus($latestAppointment?->status);
        $procedure = $latestAppointment?->service_type ?: 'Dental Record';
        $visitCount = $appointments->count();
        $servicesCount = $appointments
            ->pluck('service_type')
            ->filter(fn ($value) => filled($value))
            ->unique()
            ->count();
        $medicalSummary = $this->buildMedicalHistorySummary($patient);
        $dentalSummary = $this->buildDentalHistorySummary($patient);
        $treatmentSummary = $this->buildTreatmentSummary($latestProcedure, $procedure);

        return (object) [
            'id' => $patient->id,
            'patient_id' => $patient->id,
            'patient_name' => $patient->name ?: 'Unknown Patient',
            'procedure' => $procedure,
            'dentist_name' => $latestAppointment?->dentist?->name ?: '—',
            'status' => $status,
            'date' => $latestActivityAt ? $latestActivityAt->format('M d, Y') : '—',
            'date_iso' => $latestActivityAt ? $latestActivityAt->toDateString() : '',
            'date_sort' => $latestActivityAt ? $latestActivityAt->format('Y-m-d H:i:s') : '',
            'time' => $latestAppointment?->appointment_time
                ? Carbon::parse($latestAppointment->appointment_time)->format('g:i A')
                : '',
            'notes' => $treatmentSummary,
            'visit_count' => $visitCount,
            'services_count' => $servicesCount,
            'profile_fields' => $this->buildPatientProfileFields($patient),
            'dental_history_summary' => $dentalSummary,
            'medical_history_summary' => $medicalSummary,
            'dental_history_fields' => $this->buildDentalHistoryFields($patient),
            'dental_symptoms' => $this->buildDentalSymptoms($patient),
            'medical_history_fields' => $this->buildMedicalHistoryFields($patient),
            'medical_conditions' => $this->buildMedicalConditions($patient),
            'record_sections' => $this->buildRecordSections($patient, $latestAppointment, $latestProcedure),
            'follow_up_summary' => $this->buildFollowUpSummary($followUpAppointment),
            'follow_up' => $followUpAppointment ? [
                'date' => $followUpAppointment->appointment_date
                    ? Carbon::parse($followUpAppointment->appointment_date)->format('d M Y')
                    : null,
                'time' => $followUpAppointment->appointment_time
                    ? Carbon::parse($followUpAppointment->appointment_time)->format('g:i A')
                    : null,
                'service' => $followUpAppointment->service_type ?: 'Follow-up',
                'status' => $followUpAppointment->status ?: 'upcoming',
                'reason' => $followUpAppointment->follow_up_reason,
            ] : null,
            'has_follow_up' => (bool) $followUpAppointment,
            'oral' => $latestProcedure?->oral_examination ?: 'No oral examination record yet.',
            'diagnosis' => $latestProcedure?->diagnosis ?: 'No diagnosis record yet.',
            'prescription' => $latestProcedure?->prescriptions ?: 'No prescription recorded.',
            'odontogram_data' => $latestProcedure?->odontogram_data ?: ($patient->odontogram?->odontogram_data ?: []),
            'full_record_url' => route('admin.admin.patient.profile', [
                'patient' => $patient->id,
                'from' => 'patients',
            ]),
        ];
    }

    private function resolveLatestActivityAt(Patient $patient, $latestAppointment, $latestProcedure): ?Carbon
    {
        $candidates = collect([
            $latestProcedure?->procedure_completed_at,
            $latestProcedure?->updated_at,
            $latestAppointment?->appointment_date
                ? Carbon::parse(trim((string) $latestAppointment->appointment_date) . ' ' . trim((string) ($latestAppointment->appointment_time ?: '00:00:00')))
                : null,
            $patient->odontogram?->updated_at,
            $patient->medicalHistory?->updated_at,
            $patient->dentalHistory?->updated_at,
            $patient->updated_at,
        ])->filter();

        if ($candidates->isEmpty()) {
            return null;
        }

        return $candidates
            ->map(fn ($value) => $value instanceof Carbon ? $value : Carbon::parse($value))
            ->sortDesc()
            ->first();
    }

    private function normalizeRecordStatus(?string $status): string
    {
        $normalized = strtolower(trim((string) $status));

        return match ($normalized) {
            'ongoing', 'in-progress', 'in_progress' => 'ongoing',
            'cancelled', 'canceled' => 'cancelled',
            'completed' => 'completed',
            'pending', 'confirmed', 'upcoming', 'rescheduled', 'today', 'scheduled_today' => 'pending',
            default => 'completed',
        };
    }

    private function buildTreatmentSummary($latestProcedure, string $fallback): string
    {
        $parts = collect([
            $latestProcedure?->completion_action === 'follow_up' ? 'Follow-up required' : null,
            $latestProcedure?->diagnosis,
            $latestProcedure?->oral_examination,
            $fallback,
        ])->filter(fn ($value) => filled($value));

        return $parts->implode(' | ');
    }

    private function buildDentalHistorySummary(Patient $patient): string
    {
        $parts = collect($this->buildDentalHistoryFields($patient))
            ->map(fn ($item) => ($item['label'] ?? 'Item') . ': ' . ($item['value'] ?? 'N/A'))
            ->values();

        $symptoms = collect($this->buildDentalSymptoms($patient));

        if ($symptoms->isNotEmpty()) {
            $parts->push('Reported: ' . $symptoms->implode(', '));
        }

        return $parts->filter()->implode("\n") ?: 'No dental history recorded yet.';
    }

    private function buildMedicalHistorySummary(Patient $patient): string
    {
        $parts = collect($this->buildMedicalHistoryFields($patient))
            ->map(fn ($item) => ($item['label'] ?? 'Item') . ': ' . ($item['value'] ?? 'N/A'))
            ->values();

        $conditions = collect($this->buildMedicalConditions($patient));

        if ($conditions->isNotEmpty()) {
            $parts->push('Conditions: ' . $conditions->implode(', '));
        }

        return $parts->implode("\n") ?: 'No medical history recorded yet.';
    }

    private function buildPatientProfileFields(Patient $patient): array
    {
        $program = trim((string) ($patient->course_code ?? ''));
        $courseName = trim((string) ($patient->course_name ?? ''));
        $programLabel = collect([
            $program,
            $courseName !== '' && $courseName !== $program ? $courseName : null,
        ])->filter()->implode(' — ');

        if ($programLabel === '') {
            $programLabel = filled($patient->classification) ? $this->formatHistoryLabel($patient->classification) : 'No program';
        }

        $yearLevel = $patient->year_level ? 'Year ' . $patient->year_level : null;
        $section = filled($patient->section) ? 'Section ' . $patient->section : null;
        $programYear = collect([$programLabel, $yearLevel, $section])->filter()->implode(' • ');

        $identity = filled($patient->student_no)
            ? $patient->student_no
            : (filled($patient->faculty_code) ? 'Faculty: ' . $patient->faculty_code : 'No identity number');

        $emergencyContact = collect([
            $patient->medicalHistory?->emergency_person,
            $patient->medicalHistory?->emergency_number,
            $patient->medicalHistory?->emergency_relation,
        ])->filter()->implode(' • ');

        return [
            ['label' => 'Name', 'value' => $patient->name ?: 'Unknown Patient', 'icon' => 'fa-regular fa-user'],
            ['label' => 'Program / Year', 'value' => $programYear !== '' ? $programYear : 'No program', 'icon' => 'fa-solid fa-graduation-cap'],
            ['label' => 'Student No.', 'value' => $identity, 'icon' => 'fa-regular fa-id-badge'],
            ['label' => 'Email', 'value' => $patient->email ?: 'No email', 'icon' => 'fa-regular fa-envelope'],
            ['label' => 'Emergency Contact', 'value' => $emergencyContact !== '' ? $emergencyContact : 'No emergency contact', 'icon' => 'fa-solid fa-phone'],
        ];
    }

    private function buildDentalHistoryFields(Patient $patient): array
    {
        $fields = [];

        if ($patient->dentalHistory?->last_dental_visit) {
            $fields[] = [
                'label' => 'Last dental visit',
                'value' => Carbon::parse($patient->dentalHistory->last_dental_visit)->format('M d, Y'),
                'icon' => 'fa-regular fa-calendar-check',
            ];
        }

        if (filled($patient->dentalHistory?->previous_dentist)) {
            $fields[] = [
                'label' => 'Previous dentist',
                'value' => $patient->dentalHistory->previous_dentist,
                'icon' => 'fa-solid fa-user-doctor',
            ];
        }

        if ($patient->dentalHistoryDates?->extraction_date) {
            $fields[] = [
                'label' => 'Extraction date',
                'value' => Carbon::parse($patient->dentalHistoryDates->extraction_date)->format('M d, Y'),
                'icon' => 'fa-solid fa-tooth',
            ];
        }

        if ($patient->dentalHistoryDates?->dentures_date) {
            $fields[] = [
                'label' => 'Dentures date',
                'value' => Carbon::parse($patient->dentalHistoryDates->dentures_date)->format('M d, Y'),
                'icon' => 'fa-solid fa-calendar-days',
            ];
        }

        if ($patient->dentalHistoryDates?->ortho_date) {
            $fields[] = [
                'label' => 'Orthodontic treatment date',
                'value' => Carbon::parse($patient->dentalHistoryDates->ortho_date)->format('M d, Y'),
                'icon' => 'fa-regular fa-calendar',
            ];
        }

        if (filled($patient->dentalHistoryConcerns?->additional_concerns)) {
            $fields[] = [
                'label' => 'Additional concern',
                'value' => $patient->dentalHistoryConcerns->additional_concerns,
                'icon' => 'fa-regular fa-comment-dots',
            ];
        }

        return $fields;
    }

    private function buildDentalSymptoms(Patient $patient): array
    {
        return collect($patient->dentalHistoryAnswers ?? [])
            ->filter(fn ($answer) => (bool) $answer->answer)
            ->map(fn ($answer) => $this->formatHistoryLabel($answer->condition?->label ?: $answer->condition?->code))
            ->filter()
            ->values()
            ->all();
    }

    private function buildMedicalHistoryFields(Patient $patient): array
    {
        return collect($patient->medicalHistory?->answers ?? [])
            ->filter(function ($answer) {
                return $answer->answer_bool === true || filled($answer->answer_text) || filled($answer->answer_date);
            })
            ->map(function ($answer) {
                $label = $this->formatHistoryLabel(
                    $answer->question?->label ?: $answer->question?->code ?: 'Medical item'
                );

                $value = collect([
                    $answer->answer_bool === true ? 'Yes' : null,
                    $answer->answer_text,
                    $answer->answer_date ? Carbon::parse($answer->answer_date)->format('M d, Y') : null,
                ])->filter()->implode(' ');

                return [
                    'label' => $label,
                    'value' => $value !== '' ? $value : 'N/A',
                    'icon' => 'fa-solid fa-stethoscope',
                ];
            })
            ->values()
            ->all();
    }

    private function buildMedicalConditions(Patient $patient): array
    {
        return collect($patient->medicalHistory?->diseaseAnswers ?? [])
            ->map(fn ($answer) => $this->formatHistoryLabel($answer->disease?->label))
            ->filter()
            ->values()
            ->all();
    }

    private function buildRecordSections(Patient $patient, $latestAppointment, $latestProcedure): array
    {
        $sections = [];

        $appointmentRows = [
            ['label' => 'Service', 'value' => $latestAppointment?->service_type ?: 'Dental Record'],
            ['label' => 'Date', 'value' => $latestAppointment?->appointment_date ? Carbon::parse($latestAppointment->appointment_date)->format('F d, Y') : 'N/A'],
            ['label' => 'Time', 'value' => $latestAppointment?->appointment_time ? Carbon::parse($latestAppointment->appointment_time)->format('g:i A') : 'N/A'],
            ['label' => 'Duration', 'value' => $this->formatProcedureDurationForDisplay($latestProcedure?->procedure_duration_seconds)],
            ['label' => 'Status', 'value' => ucfirst($this->normalizeRecordStatus($latestAppointment?->status))],
            ['label' => 'Follow-up', 'value' => $this->buildFollowUpSummary($latestAppointment?->followUpAppointments?->first())],
        ];

        $sections[] = [
            'title' => 'Appointment Details',
            'icon' => 'fa-calendar-check',
            'rows' => $appointmentRows,
        ];

        $dentalGroups = [
            [
                'title' => 'Basic Info',
                'rows' => array_values(array_filter([
                    ['label' => 'Last Dental Visit', 'value' => $patient->dentalHistory?->last_dental_visit ? Carbon::parse($patient->dentalHistory->last_dental_visit)->format('F d, Y') : 'N/A'],
                    ['label' => 'Previous Dentist', 'value' => $patient->dentalHistory?->previous_dentist ?: 'N/A'],
                ], fn ($row) => true)),
            ],
            [
                'title' => 'Dental Symptoms & Procedures',
                'rows' => collect($patient->dentalHistoryAnswers ?? [])
                    ->map(function ($answer) {
                        return [
                            'label' => $this->formatHistoryLabel($answer->condition?->label ?: $answer->condition?->code ?: 'Dental item'),
                            'value' => $this->formatBooleanAnswer($answer->answer),
                        ];
                    })
                    ->values()
                    ->all(),
            ],
            [
                'title' => 'Procedure Dates',
                'rows' => [
                    ['label' => 'Extraction Date', 'value' => $patient->dentalHistoryDates?->extraction_date ? Carbon::parse($patient->dentalHistoryDates->extraction_date)->format('F d, Y') : 'N/A'],
                    ['label' => 'Dentures Date', 'value' => $patient->dentalHistoryDates?->dentures_date ? Carbon::parse($patient->dentalHistoryDates->dentures_date)->format('F d, Y') : 'N/A'],
                    ['label' => 'Orthodontic Treatment Date', 'value' => $patient->dentalHistoryDates?->ortho_date ? Carbon::parse($patient->dentalHistoryDates->ortho_date)->format('F d, Y') : 'N/A'],
                ],
            ],
            [
                'title' => 'Additional Dental Concerns',
                'rows' => [
                    ['label' => 'Concern', 'value' => $patient->dentalHistoryConcerns?->additional_concerns ?: 'N/A'],
                ],
            ],
        ];

        $sections[] = [
            'title' => 'Dental History',
            'icon' => 'fa-tooth',
            'groups' => $dentalGroups,
        ];

        $medicalAnswerRows = collect($patient->medicalHistory?->answers ?? [])
            ->map(function ($answer) {
                $value = collect([
                    $answer->answer_bool === true ? 'Yes' : ($answer->answer_bool === false ? 'No' : null),
                    filled($answer->answer_text) ? $answer->answer_text : null,
                    filled($answer->answer_date) ? Carbon::parse($answer->answer_date)->format('F d, Y') : null,
                ])->filter()->implode(' | ');

                return [
                    'label' => $this->formatHistoryLabel($answer->question?->label ?: $answer->question?->code ?: 'Medical item'),
                    'value' => $value !== '' ? $value : 'N/A',
                ];
            })
            ->values()
            ->all();

        $medicalConditionRows = collect($patient->medicalHistory?->diseaseAnswers ?? [])
            ->map(function ($answer) {
                return [
                    'label' => $this->formatHistoryLabel($answer->disease?->label ?: 'Condition'),
                    'value' => $this->formatBooleanAnswer($answer->has_disease),
                ];
            })
            ->values()
            ->all();

        $sections[] = [
            'title' => 'Medical History',
            'icon' => 'fa-heart-pulse',
            'groups' => [
                ['title' => 'Medical Answers', 'rows' => $medicalAnswerRows],
                ['title' => 'Medical Conditions', 'rows' => $medicalConditionRows],
                ['title' => 'Emergency Contact', 'rows' => [
                    ['label' => 'Name', 'value' => $patient->medicalHistory?->emergency_person ?: 'N/A'],
                    ['label' => 'Number', 'value' => $patient->medicalHistory?->emergency_number ?: 'N/A'],
                    ['label' => 'Relation', 'value' => $patient->medicalHistory?->emergency_relation ?: 'N/A'],
                ]],
            ],
        ];

        $sections[] = [
            'title' => 'Clinical Notes',
            'icon' => 'fa-file-medical',
            'rows' => [
                ['label' => 'Treatment', 'value' => $this->buildTreatmentSummary($latestProcedure, $latestAppointment?->service_type ?: 'Dental Record') ?: 'N/A'],
                ['label' => 'Oral Examination', 'value' => $latestProcedure?->oral_examination ?: 'N/A'],
                ['label' => 'Diagnosis', 'value' => $latestProcedure?->diagnosis ?: 'N/A'],
                ['label' => 'Prescription', 'value' => $latestProcedure?->prescriptions ?: 'N/A'],
            ],
        ];

        return $sections;
    }

    private function formatBooleanAnswer($value): string
    {
        if ($value === true || $value === 1 || $value === '1') {
            return 'Yes';
        }

        if ($value === false || $value === 0 || $value === '0') {
            return 'No';
        }

        return filled($value) ? (string) $value : 'N/A';
    }

    private function formatProcedureDurationForDisplay($seconds): string
    {
        $seconds = (int) $seconds;

        if ($seconds <= 0) {
            return 'N/A';
        }

        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $parts = [];

        if ($hours > 0) {
            $parts[] = $hours . ' hr' . ($hours === 1 ? '' : 's');
        }

        if ($minutes > 0) {
            $parts[] = $minutes . ' min' . ($minutes === 1 ? '' : 's');
        }

        if (empty($parts)) {
            $parts[] = $seconds . ' sec' . ($seconds === 1 ? '' : 's');
        }

        return implode(' ', $parts);
    }

    private function formatHistoryLabel(?string $value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        $value = str_replace(['_', '-'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return ucfirst(strtolower($value));
    }

    private function buildFollowUpSummary($followUpAppointment): string
    {
        if (! $followUpAppointment) {
            return 'No follow-up appointment scheduled.';
        }

        $parts = collect([
            $followUpAppointment->appointment_date
                ? Carbon::parse($followUpAppointment->appointment_date)->format('M d, Y')
                : null,
            $followUpAppointment->appointment_time
                ? Carbon::parse($followUpAppointment->appointment_time)->format('g:i A')
                : null,
            $followUpAppointment->service_type,
            $followUpAppointment->follow_up_reason,
        ])->filter();

        return $parts->implode(' | ') ?: 'No follow-up appointment scheduled.';
    }

    private function resolveLayoutRole(): string
    {
        return request()->routeIs('dentist.dental-records*') ? 'dentist' : 'admin';
    }
}
