<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Models\Appointment;
use App\Models\DentalHistory;
use App\Models\DentalHistoryCondition;
use App\Models\DentalHistoryAnswer;
use App\Models\DentalHistoryConditionDate;
use App\Models\DentalHistoryConcern;

use App\Models\MedicalHistory;
use App\Models\MedicalHistoryQuestion;
use App\Models\MedicalHistoryAnswer;
use App\Models\Disease;
use App\Models\MedicalHistoryDiseaseAnswer;

use App\Models\Patient;
use App\Models\User;
use App\Models\BlockedDate;
use App\Models\ClinicSchedule;
use App\Models\ServiceType;
use App\Helpers\PhilippineHolidays;
use App\Helpers\AuditLogger;
use App\Notifications\AppointmentBookedNotification;
use App\Notifications\AppointmentRescheduledNotification;
use App\Notifications\SignatureReuploadRequiredNotification;
use App\Services\SignatureAiVerifier;
use App\Helpers\BookingQuestions;

class AppointmentController extends Controller
{

    public function index()
    {
        $patientId = session('impersonated_patient_id') ?: session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        $now = now();
        $today = $now->toDateString();
        $nowTime = $now->format('H:i:s');

        $appointments = Appointment::with(['dentist.role'])
            ->where('patient_id', $patientId)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $futureVisits = Appointment::with(['dentist.role'])
            ->where('patient_id', $patientId)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->where(function ($q) use ($today, $nowTime) {
                $q->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($q2) use ($today, $nowTime) {
                        $q2->whereDate('appointment_date', '=', $today)
                            ->whereTime('appointment_time', '>=', $nowTime);
                    });
            })
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $pastVisits = Appointment::with(['dentist.role'])
            ->where('patient_id', $patientId)
            ->where(function ($q) use ($today, $nowTime) {
                $q->whereIn('status', ['completed', 'cancelled'])
                    ->orWhereDate('appointment_date', '<', $today)
                    ->orWhere(function ($q2) use ($today, $nowTime) {
                        $q2->whereDate('appointment_date', '=', $today)
                            ->whereTime('appointment_time', '<', $nowTime);
                    });
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $patient->load([
            'dentalHistory',
            'dentalHistoryDates',
            'dentalHistoryConcerns',
            'dentalHistoryAnswers.condition',
            'medicalHistory',
            'medicalHistory.answers.question',
            'medicalHistory.diseaseAnswers.disease',
        ]);

        $appointmentCountsPerDay = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $unavailableDates = [];

        $philippineHolidays = PhilippineHolidays::range(1, 3);

        $odontogramTeeth = \App\Models\Tooth::with('surfaces.legends')
            ->where('patient_id', $patient->id)
            ->get()
            ->map(function ($tooth) {
                $legends = $tooth->surfaces
                    ->flatMap(fn($surface) => $surface->legends)
                    ->unique('id')
                    ->values();

                return [
                    'tooth' => $tooth->tooth_number,
                    'legends' => $legends->map(fn($legend) => [
                        'code' => $legend->code,
                        'description' => $legend->description,
                        'category' => $legend->category,
                    ])->values(),
                    'surfaces' => $tooth->surfaces->map(fn($surface) => [
                        'surface_number' => $surface->surface_number,
                        'legends' => $surface->legends->map(fn($legend) => [
                            'code' => $legend->code,
                            'description' => $legend->description,
                            'category' => $legend->category,
                        ])->values(),
                    ])->values(),
                ];
            })
            ->values();

        $notifications = [];

        $chartStart = now()->startOfMonth()->subMonths(5)->toDateString();
        $chartEnd = now()->endOfMonth()->toDateString();

        $activityRows = Appointment::query()
            ->where('patient_id', $patientId)
            ->whereBetween('appointment_date', [$chartStart, $chartEnd])
            ->selectRaw("DATE_FORMAT(appointment_date, '%Y-%m') as ym")
            ->selectRaw("SUM(CASE WHEN TRIM(LOWER(COALESCE(status, ''))) = 'completed' THEN 1 ELSE 0 END) as completed")
            ->selectRaw("SUM(CASE WHEN TRIM(LOWER(COALESCE(status, ''))) IN ('cancelled', 'declined') THEN 1 ELSE 0 END) as cancelled")
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $appointmentActivityChart = collect(range(5, 0))
            ->map(function ($offset) use ($activityRows) {
                $month = now()->startOfMonth()->subMonths($offset);
                $key = $month->format('Y-m');
                $row = $activityRows->get($key);

                return [
                    'key' => $key,
                    'label' => $month->format('M'),
                    'completed' => (int) ($row->completed ?? 0),
                    'cancelled' => (int) ($row->cancelled ?? 0),
                ];
            })
            ->values()
            ->all();

        AuditLogger::log(
            'view',
            'appointments',
            "Patient viewed appointment page"
        );

        $clinicDentist = \App\Models\User::with('role')
            ->whereHas('role', fn($q) => $q->where('slug', 'dentist'))
            ->first();

        return view('patient.appointment', compact(
            'appointments',
            'clinicDentist',
            'futureVisits',
            'pastVisits',
            'patient',
            'appointmentCountsPerDay',
            'unavailableDates',
            'philippineHolidays',
            'notifications',
            'odontogramTeeth',
            'appointmentActivityChart'
        ));
    }


    public function create()
    {
        $patientId = session('impersonated_patient_id') ?: session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient = Patient::findOrFail($patientId);

        $patient->load([
            'dentalHistory',
            'dentalHistoryDates',
            'dentalHistoryConcerns',
            'dentalHistoryAnswers.condition',
            'medicalHistory.answers.question',
            'medicalHistory.diseaseAnswers.disease',
        ]);

        $dentalDefaults = [
            'last_dental_visit' => $patient->dentalHistory?->last_dental_visit
                ? $patient->dentalHistory->last_dental_visit->format('Y-m-d')
                : '',

            'previous_dentist' => $patient->dentalHistory?->previous_dentist ?? '',

            'additional_concerns' =>
            $patient->dentalHistoryConcerns?->additional_concerns ?? '',

            'extraction_date' => $patient->dentalHistoryDates?->extraction_date
                ? $patient->dentalHistoryDates->extraction_date->format('Y-m-d')
                : '',

            'dentures_date' => $patient->dentalHistoryDates?->dentures_date
                ? $patient->dentalHistoryDates->dentures_date->format('Y-m-d')
                : '',

            'ortho_date' => $patient->dentalHistoryDates?->ortho_date
                ? $patient->dentalHistoryDates->ortho_date->format('Y-m-d')
                : '',
        ];

        foreach ($patient->dentalHistoryAnswers as $answer) {
            $code = $answer->condition?->code;

            if (!$code) {
                continue;
            }

            $dentalDefaults[$code] = $answer->answer ? 'YES' : 'NO';
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
                        $answer->answer_date->format('Y-m-d');
                }
            }
        }

        $selectedDiseases = $patient->medicalHistory
            ? $patient->medicalHistory
            ->diseaseAnswers
            ->filter(fn($answer) => $answer->has_disease)
            ->map(fn($answer) => $answer->disease?->code)
            ->filter()
            ->values()
            ->all()
            : [];

        $hasExistingDentalHistory =
            $patient->dentalHistory !== null &&
            $patient->dentalHistoryAnswers->isNotEmpty();

        $hasExistingMedicalHistory =
            $patient->medicalHistory !== null &&
            $patient->medicalHistory->answers->isNotEmpty();

        $hasExistingBookingInformation =
            $hasExistingDentalHistory &&
            $hasExistingMedicalHistory;

        $hasReusableSignature =
            !empty($patient->medicalHistory?->patient_signature) &&
            $patient->medicalHistory?->signature_review_status !==
            'invalid_reupload_required';

        // continue with your existing create() code...

        // DO NOT REMOVE
        // $hasActiveAppointment = Appointment::where('patient_id', $patientId)
        //     ->whereIn('status', ['upcoming', 'rescheduled'])
        //     ->exists();

        // if ($hasActiveAppointment) {
        //     return redirect()->back()->with([
        //         'activeAppointmentModal' => true,
        //         'activeAppointmentMsg' =>
        //         "You already have an active appointment. Please wait until it is completed before booking another one."
        //     ]);
        // }

        $appointmentCountsPerDay = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $appointmentCountsPerSlot = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_date, appointment_time, COUNT(*) as count')
            ->groupBy('appointment_date', 'appointment_time')
            ->get()
            ->groupBy('appointment_date')
            ->map(function ($rows) {
                return $rows->pluck('count', 'appointment_time')->toArray();
            })
            ->toArray();

        $schedules = ClinicSchedule::active()->orderBy('id')->get();

        $blockedDates = BlockedDate::pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        $philippineHolidays = PhilippineHolidays::range(0, 1);

        $diseases = Disease::orderBy('sort_order')->get();

        $serviceTypes = ServiceType::where('is_active_for_booking', true)
            ->orderBy('name')
            ->get()
            ->map(function ($service) {
                return [
                    'name' => $service->name,
                    'desc' => $service->description ?: 'No description available.',
                    'img'  => null,
                ];
            });

        $odontogramTeeth = \App\Models\Tooth::with('surfaces.legends')
            ->where('patient_id', $patient->id)
            ->get()
            ->map(function ($tooth) {
                $legends = $tooth->surfaces
                    ->flatMap(fn($surface) => $surface->legends)
                    ->unique('id')
                    ->values();

                return [
                    'tooth' => $tooth->tooth_number,
                    'legends' => $legends->map(fn($legend) => [
                        'code' => $legend->code,
                        'description' => $legend->description,
                        'category' => $legend->category,
                    ])->values(),
                    'surfaces' => $tooth->surfaces->map(fn($surface) => [
                        'surface_number' => $surface->surface_number,
                        'legends' => $surface->legends->map(fn($legend) => [
                            'code' => $legend->code,
                            'description' => $legend->description,
                            'category' => $legend->category,
                        ])->values(),
                    ])->values(),
                ];
            })
            ->values();

        $dentalQuestions = BookingQuestions::dental();
        $medicalQuestions = BookingQuestions::medical();

        AuditLogger::log(
            'view',
            'appointments',
            "Patient opened book appointment page"
        );

        return view('patient.book-appointment', compact(
            'patient',
            'appointmentCountsPerDay',
            'appointmentCountsPerSlot',
            'schedules',
            'blockedDates',
            'philippineHolidays',
            'diseases',
            'serviceTypes',
            'odontogramTeeth',
            'dentalQuestions',
            'medicalQuestions',
            'dentalDefaults',
            'medicalDefaults',
            'selectedDiseases',
            'hasExistingDentalHistory',
            'hasExistingMedicalHistory',
            'hasExistingBookingInformation',
            'hasReusableSignature'
        ));
    }

    /* =======================
       STORE APPOINTMENT
    ======================= */
    public function store(Request $request, SignatureAiVerifier $signatureVerifier)
    {
        $patientId = session('impersonated_patient_id') ?: session('patient_id');

        if (!$patientId) {
            return redirect()->route('login')
                ->with('error', 'Please login first!');
        }

        $existingMedicalHistory = MedicalHistory::where(
            'patient_id',
            $patientId
        )->first();

        $hasReusableSignature =
            !empty($existingMedicalHistory?->patient_signature) &&
            $existingMedicalHistory?->signature_review_status !== 'invalid_reupload_required';

        $request->validate([
            'appointment_date'     => 'required|date|after:today',
            'appointment_time'     => 'required|string', // "1:00 PM"
            'service_type' => 'required|string|max:255',

            'contact_email' => [
                'required',
                'email',
                'max:255',
            ],

            'contact_phone' => [
                'required',
                'regex:/^09\d{9}$/',
            ],

            'contact_address' => [
                'required',
                'string',
                'max:500',
            ],

            'emergency_person' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÑñ\s.\'-]+$/u',
            ],
            'emergency_number'     => 'required|string|max:15',
            'emergency_relation' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::in([
                    'Mother',
                    'Father',
                    'Sibling',
                    'Guardian',
                    'Spouse',
                    'Grandparent',
                    'Aunt',
                    'Uncle',
                    'Cousin',
                    'Child',
                ]),
            ],

            'patient_signature' => [
                $hasReusableSignature ? 'nullable' : 'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:25600', // 25 MB
            ],
            'signature_source' => 'nullable|in:drawn',

            'diseases'   => 'array',
            'diseases.*' => 'string|exists:diseases,code',
        ]);


        if (!ServiceType::where('name', $request->service_type)
            ->where('is_active_for_booking', true)
            ->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid service type selected.');
        }

        $patient = Patient::findOrFail($patientId);
        $isFemalePatient = strtolower($patient->gender ?? '') === 'female';

        // Convert UI "1:00 PM" -> DB TIME "13:00:00"
        try {
            $mysqlTime = $this->toMysqlTime($request->appointment_time);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid time format. Please pick a valid time slot.');
        }

        $date = Carbon::parse($request->appointment_date);
        $dayAbbr = $date->format('D');

        if ($date->isToday()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Same-day booking is not allowed. Please select a future date.');
        }

        if (BlockedDate::whereDate('date', $request->appointment_date)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This date is blocked and unavailable for booking.');
        }

        $philippineHolidays = PhilippineHolidays::range(0, 1);
        if (isset($philippineHolidays[$request->appointment_date])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The clinic is closed on holidays. Please choose another date.');
        }

        $schedule = ClinicSchedule::active()
            ->get()
            ->first(function ($rule) use ($dayAbbr) {
                return in_array($dayAbbr, $rule->days ?? []);
            });

        if (! $schedule || $schedule->status === 'closed') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The clinic is closed on the selected date.');
        }

        if (! $schedule->open_time || ! $schedule->close_time) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Clinic hours are not configured properly for this date.');
        }

        if ($mysqlTime < $schedule->open_time || $mysqlTime >= $schedule->close_time) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Selected time is outside clinic operating hours.');
        }

        if (!empty($schedule->break_time) && $schedule->break_time !== 'none') {
            [$breakStart, $breakEnd] = explode('-', $schedule->break_time);

            $breakStartTime = Carbon::createFromFormat('H:i', trim($breakStart))->format('H:i:s');
            $breakEndTime   = Carbon::createFromFormat('H:i', trim($breakEnd))->format('H:i:s');

            if ($mysqlTime >= $breakStartTime && $mysqlTime < $breakEndTime) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Selected time falls within the clinic lunch break.');
            }
        }

        $appointmentCount = Appointment::where('appointment_date', $request->appointment_date)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->count();

        if ($appointmentCount >= $schedule->max_slots) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, this date is fully booked. Please select another date.');
        }

        $timeTaken = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $mysqlTime)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->exists();

        if ($timeTaken) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, that time slot was already taken. Please choose another time.');
        }

        if (! $isFemalePatient) {
            $request->merge([
                'pregnant' => 'NO',
                'nursing' => 'NO',
                'birth_control' => 'NO',
            ]);
        }

        // AI Signature Validation

        $signatureFile = $request->file('patient_signature');

        if (!$signatureFile && $hasReusableSignature) {


            $signaturePath = $existingMedicalHistory->patient_signature;

            $signatureReviewStatus =
                $existingMedicalHistory->signature_review_status ?? 'verified';

            $signatureReviewNotes =
                $existingMedicalHistory->signature_review_notes;

            $aiResult = [
                'accepted' => true,
                'source' => 'existing',
                'reason' => 'Existing patient signature reused.',
                'confidence' => $existingMedicalHistory->signature_ai_confidence,
                'review_required' =>
                $signatureReviewStatus === 'pending_manual_review',
                'review_status' => $signatureReviewStatus,
                'detected_type' => 'existing_signature',
            ];
        } else {

            $isDrawnSignature =
                $this->isDrawnSignatureSubmission($request);

            if (! $isDrawnSignature) {

                $aiResult =
                    $signatureVerifier->verify(
                        $signatureFile
                    );

                \Log::info(
                    'Store Appointment Signature Result',
                    $aiResult
                );

                if (!($aiResult['accepted'] ?? false)) {

                    $reason =
                        $aiResult['reason']
                        ?? 'The uploaded image did not pass signature validation.';

                    $detectedType =
                        $aiResult['detected_type']
                        ?? 'unknown';

                    $confidence =
                        $aiResult['confidence']
                        ?? 0;

                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            'patient_signature' =>
                            'Signature could not be processed. Please try again. ' .
                                'Reason: ' . $reason .
                                ' Detected: ' . $detectedType .
                                ' Confidence: ' . $confidence,
                        ]);
                }
            } else {

                $aiResult = [
                    'accepted' => true,
                    'source' => 'drawn',
                    'reason' =>
                    'Drawn signature skipped AI validation.',
                    'confidence' => 1,
                    'review_required' => false,
                    'review_status' => 'verified',
                    'detected_type' => 'drawn_signature',
                ];

                \Log::info(
                    'Store Appointment Signature Result',
                    [
                        'accepted' =>
                        $aiResult['accepted'],

                        'source' =>
                        $aiResult['source'],

                        'reason' =>
                        $aiResult['reason'],
                    ]
                );
            }

            $signatureReviewStatus =
                ($aiResult['review_status'] ?? null)
                === 'pending_manual_review'
                ? 'pending_manual_review'
                : 'verified';

            $signatureReviewNotes =
                $aiResult['review_required'] ?? false
                ? (
                    $aiResult['reason']
                    ?? 'Accepted for manual review.'
                )
                : null;

            $signaturePath =
                $signatureFile->store(
                    'signatures',
                    'public'
                );
        }

        $appointment = null;

        DB::transaction(function () use ($request, $signaturePath, $mysqlTime, $patientId, $signatureReviewStatus, $signatureReviewNotes, $aiResult, &$appointment) {

            // 1) APPOINTMENT
            $appointment = Appointment::create([
                'patient_id'       => $patientId,
                'service_type'     => $request->service_type,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $mysqlTime,
                'status'           => 'upcoming',
            ]);

            Patient::where('id', $patientId)->update([
                'email' => $request->contact_email,
                'phone' => $request->contact_phone,
                'address' => $request->contact_address,
            ]);

            //  Notify dentists
            $dentists = User::whereHas('role', function ($q) {
                $q->where('slug', 'dentist');
            })->get();

            foreach ($dentists as $dentist) {
                $dentist->notify(new AppointmentBookedNotification($appointment, $appointment->patient));
            }

            //  Notify admins
            $admins = User::whereHas('role', function ($q) {
                $q->where('slug', 'admin');
            })->get();

            foreach ($admins as $admin) {
                $admin->notify(new AppointmentBookedNotification($appointment, $appointment->patient));
            }

            // 2) DENTAL HISTORY (patient-based)
            DentalHistory::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'last_dental_visit' => $request->last_dental_visit,
                    'previous_dentist'  => $request->previous_dentist,
                ]
            );

            DentalHistoryConditionDate::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'extraction_date' => $request->extraction_date,
                    'dentures_date'   => $request->dentures_date,
                    'ortho_date'      => $request->ortho_date,
                ]
            );

            DentalHistoryConcern::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'additional_concerns' => $request->additional_concerns,
                ]
            );

            // YES/NO answers (dental_history_answers)
            $dentalAnswerMap = [
                'bleeding_gums'      => $request->bleeding_gums,
                'sensitive_temp'     => $request->sensitive_temp,
                'sensitive_taste'    => $request->sensitive_taste,
                'tooth_pain'         => $request->tooth_pain,
                'sores'              => $request->sores,
                'injuries'           => $request->injuries,

                'clicking'           => $request->clicking,
                'joint_pain'         => $request->joint_pain,
                'difficulty_moving'  => $request->difficulty_moving,
                'difficulty_chewing' => $request->difficulty_chewing,
                'jaw_headaches'      => $request->jaw_headaches,
                'clench_grind'       => $request->clench_grind,
                'biting'             => $request->biting,
                'teeth_loosening'    => $request->teeth_loosening,
                'food_teeth'         => $request->food_teeth,
                'med_reaction'       => $request->med_reaction,

                'periodontal'          => $request->periodontal,
                'difficult_extraction' => $request->difficult_extraction,
                'prolonged_bleeding'   => $request->prolonged_bleeding,
                'dentures'             => $request->dentures,
                'ortho_treatment'      => $request->ortho_treatment,
            ];

            $conditionIdsByCode = DentalHistoryCondition::whereIn('code', array_keys($dentalAnswerMap))
                ->pluck('id', 'code');

            foreach ($dentalAnswerMap as $code => $rawValue) {
                $conditionId = $conditionIdsByCode[$code] ?? null;
                if (!$conditionId) continue;

                DentalHistoryAnswer::updateOrCreate(
                    [
                        'patient_id'   => $patientId,
                        'condition_id' => $conditionId,
                    ],
                    [
                        'answer' => ($this->yesNoValue($rawValue) === 'YES'),
                    ]
                );
            }

            // 3) MEDICAL HISTORY (patient-based)
            $medicalHistory = MedicalHistory::updateOrCreate(
                ['patient_id' => $patientId],
                [
                    'emergency_person'   => $request->emergency_person,
                    'emergency_number'   => $request->emergency_number,
                    'emergency_relation' => $request->emergency_relation,
                    'patient_signature'  => $signaturePath,
                    'signature_review_status' => $signatureReviewStatus,
                    'signature_review_notes' => $signatureReviewNotes,
                    'signature_ai_provider' => 'openai',
                    'signature_ai_confidence' => $aiResult['confidence'] ?? null,
                ]
            );

            // Medical answers map
            $medicalAnswerMap = [
                // bool
                'good_health'       => $request->good_health,
                'had_medical_exam'  => $request->had_medical_exam,
                'under_treatment'   => $request->under_treatment,
                'hospitalized'      => $request->hospitalized,
                'allergy_medicine'  => $request->allergy_medicine,
                'allergy_food'      => $request->allergy_food,
                'medication'        => $request->medication,
                'pregnant'          => $request->pregnant,
                'nursing'           => $request->nursing,
                'birth_control'     => $request->birth_control,
                'tobacco_use'       => $request->tobacco_use,
                'headaches'         => $request->headaches,
                'earaches'          => $request->earaches,
                'neck_aches'        => $request->neck_aches,

                // text
                'good_health_details' => $request->good_health_details,
                'treatment_details'   => $request->treatment_details,
                'hospital_details'    => $request->hospital_details,
                'allergy_others'      => $request->allergy_others,
                'medication_details'  => $request->medication_details,
                'tobacco_per_day'     => $request->tobacco_per_day,
                'tobacco_per_week'    => $request->tobacco_per_week,

                // date
                'medical_exam_date'   => $request->medical_exam_date,
            ];

            $questions = MedicalHistoryQuestion::whereIn('code', array_keys($medicalAnswerMap))
                ->get()
                ->keyBy('code');

            foreach ($medicalAnswerMap as $code => $rawValue) {
                $q = $questions->get($code);
                if (!$q) continue;

                // Normalize by type
                if ($q->type === 'bool') {
                    $bool = ($this->yesNoValue($rawValue) === 'YES');

                    MedicalHistoryAnswer::updateOrCreate(
                        [
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ],
                        [
                            'answer_bool' => $bool,
                            'answer_text' => null,
                            'answer_date' => null,
                        ]
                    );

                    continue;
                }

                if ($q->type === 'text') {
                    $text = ($rawValue === null) ? '' : trim((string) $rawValue);

                    // remove row if empty text 
                    if ($text === '') {
                        MedicalHistoryAnswer::where([
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ])->delete();
                        continue;
                    }

                    MedicalHistoryAnswer::updateOrCreate(
                        [
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ],
                        [
                            'answer_bool' => null,
                            'answer_text' => $text,
                            'answer_date' => null,
                        ]
                    );

                    continue;
                }

                if ($q->type === 'date') {
                    $date = $rawValue ? trim((string) $rawValue) : '';

                    // remove row if empty date
                    if ($date === '') {
                        MedicalHistoryAnswer::where([
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ])->delete();
                        continue;
                    }

                    MedicalHistoryAnswer::updateOrCreate(
                        [
                            'patient_id'         => $patientId,
                            'medical_history_id' => $medicalHistory->id,
                            'question_id'        => $q->id,
                        ],
                        [
                            'answer_bool' => null,
                            'answer_text' => null,
                            'answer_date' => $date,
                        ]
                    );

                    continue;
                }
            }

            MedicalHistoryAnswer::where('patient_id', $patientId)
                ->where('medical_history_id', $medicalHistory->id)
                ->whereNull('answer_bool')
                ->whereNull('answer_date')
                ->where(function ($q) {
                    $q->whereNull('answer_text')
                        ->orWhereRaw("TRIM(answer_text) = ''");
                })
                ->delete();

            // 4) DISEASES (selected codes from form)
            $selectedDiseaseCodes = $request->input('diseases', []);
            $selectedDiseaseIds = Disease::whereIn('code', $selectedDiseaseCodes)
                ->pluck('id')
                ->all();

            MedicalHistoryDiseaseAnswer::where('medical_history_id', $medicalHistory->id)->delete();

            foreach ($selectedDiseaseIds as $diseaseId) {
                MedicalHistoryDiseaseAnswer::create([
                    'patient_id'         => $patientId,
                    'medical_history_id' => $medicalHistory->id,
                    'disease_id'         => $diseaseId,
                    'has_disease'        => true,
                ]);
            }
        });

        if ($appointment) {
            AuditLogger::log(
                'create',
                'appointments',
                "Patient booked appointment for {$appointment->appointment_date} at {$appointment->appointment_time}"
            );
        }
        $successMessage = $signatureReviewStatus === 'pending_manual_review'
            ? 'Appointment booked successfully! The signature was accepted and flagged for manual review.'
            : 'Appointment booked successfully!';

        return redirect()->route('homepage')->with('success', $successMessage);
    }

    public function slotsForDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:today',
        ]);

        $iso = $request->date;
        $date = Carbon::parse($iso);
        $dayAbbr = $date->format('D');

        if ($date->isToday()) {
            return response()->json([
                'slots' => [],
                'message' => 'Same-day booking is not allowed. Please choose a future date.',
            ]);
        }

        if (BlockedDate::whereDate('date', $iso)->exists()) {
            return response()->json([
                'slots' => [],
                'message' => 'This date is blocked and unavailable for booking.',
            ]);
        }

        $philippineHolidays = PhilippineHolidays::range(0, 1);
        if (isset($philippineHolidays[$iso])) {
            return response()->json([
                'slots' => [],
                'message' => 'The clinic is closed on holidays.',
            ]);
        }

        $schedule = ClinicSchedule::active()
            ->get()
            ->first(fn($s) => in_array($dayAbbr, $s->days ?? []));

        if (! $schedule || $schedule->status === 'closed') {
            return response()->json([
                'slots' => [],
                'message' => 'The clinic is closed on this day.',
            ]);
        }

        $bookedSlotCounts = Appointment::where('appointment_date', $iso)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_time, COUNT(*) as cnt')
            ->groupBy('appointment_time')
            ->pluck('cnt', 'appointment_time')
            ->toArray();

        $totalBooked = array_sum($bookedSlotCounts);

        if ($totalBooked >= $schedule->max_slots) {
            return response()->json([
                'slots' => [],
                'message' => 'All slots for this day are fully booked.',
                'max_slots' => $schedule->max_slots,
                'booked' => $totalBooked,
                'remaining' => 0,
            ]);
        }

        return response()->json([
            'slots'      => $schedule->availableSlots($iso, $bookedSlotCounts),
            'max_slots'  => $schedule->max_slots,
            'booked'     => $totalBooked,
            'remaining'  => max(0, $schedule->max_slots - $totalBooked),
            'open_time'  => $schedule->open_time,
            'close_time' => $schedule->close_time,
            'break_time' => $schedule->break_time,
            'status'     => $schedule->status,
        ]);
    }

    /* =======================
   VALIDATE SIGNATURE AJAX
======================= */
    public function validateSignature(Request $request, SignatureAiVerifier $signatureVerifier)
    {
        $request->validate([
            'patient_signature' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:25600',
            ],
        ]);

        $signatureFile = $request->file('patient_signature');

        if ($this->isDrawnSignatureSubmission($request)) {
            return response()->json([
                'valid' => true,
                'accepted' => true,
                'message' => 'Drawn signature accepted',
                'detected_type' => 'drawn_signature',
                'confidence' => 1,
                'reason' => '',
            ]);
        }

        $aiResult = $signatureVerifier->verify($signatureFile);

        \Log::info('Validate Signature Endpoint Result', $aiResult);

        if (!($aiResult['accepted'] ?? false)) {
            return response()->json([
                'valid' => false,
                'accepted' => false,
                'message' => 'Signature could not be processed. Please try again.',
                'detected_type' => $aiResult['detected_type'] ?? 'unknown',
                'confidence' => $aiResult['confidence'] ?? 0,
                'reason' => $aiResult['reason'] ?? 'The uploaded image did not pass signature validation.',
            ], 422);
        }

        return response()->json([
            'valid' => true,
            'accepted' => true,
            'message' => $aiResult['review_required'] ?? false
                ? 'Signature accepted for manual review.'
                : 'Signature verified and accepted',
            'detected_type' => $aiResult['detected_type'] ?? 'signature',
            'confidence' => $aiResult['confidence'] ?? 0,
            'reason' => $aiResult['reason'] ?? '',
            'review_required' => (bool) ($aiResult['review_required'] ?? false),
            'review_status' => $aiResult['review_status'] ?? 'verified',
        ]);
    }

    public function showSignatureReview()
    {
        $patient = $this->resolveAuthenticatedPatient();

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient->load('medicalHistory');
        $medicalHistory = $patient->medicalHistory;

        if (!$medicalHistory || $medicalHistory->signature_review_status !== 'invalid_reupload_required') {
            return redirect()->route('homepage')->with('info', 'There is no pending signature re-upload request for your account.');
        }

        return view('patient.signature-review', compact('patient', 'medicalHistory'));
    }

    public function updateSignatureReview(Request $request, SignatureAiVerifier $signatureVerifier)
    {
        $patient = $this->resolveAuthenticatedPatient();

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        $patient->load('medicalHistory');
        $medicalHistory = $patient->medicalHistory;

        if (!$medicalHistory || $medicalHistory->signature_review_status !== 'invalid_reupload_required') {
            return redirect()->route('homepage')->with('error', 'There is no signature re-upload request to update.');
        }

        $request->validate([
            'patient_signature' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:25600',
            ],
        ]);

        $signatureFile = $request->file('patient_signature');
        $isDrawnSignature = $this->isDrawnSignatureSubmission($request);

        if (! $isDrawnSignature) {
            $aiResult = $signatureVerifier->verify($signatureFile);

            \Log::info('Signature Reupload Verification Result', $aiResult);

            if (!($aiResult['accepted'] ?? false)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'patient_signature' => $aiResult['reason'] ?? 'The uploaded image did not pass signature validation.',
                    ]);
            }
        } else {
            $aiResult = [
                'accepted' => true,
                'reason' => 'Drawn signature accepted.',
                'confidence' => 1,
                'review_required' => false,
                'review_status' => 'verified',
            ];
        }

        $oldSignaturePath = $medicalHistory->patient_signature;
        $newSignaturePath = $signatureFile->store('signatures', 'public');
        $signatureReviewStatus = ($aiResult['review_status'] ?? null) === 'pending_manual_review'
            ? 'pending_manual_review'
            : 'verified';
        $signatureReviewNotes = $aiResult['review_required'] ?? false
            ? ($aiResult['reason'] ?? 'Accepted for manual review.')
            : null;

        $medicalHistory->update([
            'patient_signature' => $newSignaturePath,
            'signature_review_status' => $signatureReviewStatus,
            'signature_review_notes' => $signatureReviewNotes,
            'signature_ai_provider' => 'openai',
            'signature_ai_confidence' => $aiResult['confidence'] ?? null,
        ]);

        if ($oldSignaturePath && $oldSignaturePath !== $newSignaturePath) {
            Storage::disk('public')->delete($oldSignaturePath);
        }

        AuditLogger::log(
            'update',
            'medical_histories',
            "Patient re-uploaded signature for manual review follow-up (patient_id: {$patient->id})"
        );

        $successMessage = $signatureReviewStatus === 'pending_manual_review'
            ? 'Your new signature was uploaded successfully and is pending manual review.'
            : 'Your new signature was uploaded and verified successfully.';

        return redirect()->route('homepage')->with('success', $successMessage);
    }

    public function markSignatureInvalid(Request $request, Patient $patient)
    {
        $patient->load('medicalHistory', 'user');

        $medicalHistory = $patient->medicalHistory;

        if (!$medicalHistory || !$medicalHistory->patient_signature) {
            return redirect()->back()->with('error', 'No uploaded signature was found for this patient.');
        }

        if ($medicalHistory->signature_review_status !== 'pending_manual_review') {
            return redirect()->back()->with('error', 'Only signatures awaiting manual review can be marked invalid.');
        }

        $reason = 'The uploaded image is not a valid patient signature. Please upload a clearer or correct signature image.';

        $medicalHistory->update([
            'signature_review_status' => 'invalid_reupload_required',
            'signature_review_notes' => $reason,
        ]);

        if ($patient->user) {
            $patient->user->notify(new SignatureReuploadRequiredNotification($patient, $reason));
        }

        AuditLogger::log(
            'update',
            'medical_histories',
            "Signature marked invalid during manual review (patient_id: {$patient->id})"
        );

        return redirect()->back()->with('success', 'The signature was marked invalid and the patient was notified to upload a new one.');
    }

    /* =======================
       HELPERS
    ======================= */
    private function toMysqlTime(string $time12h): string
    {
        return Carbon::createFromFormat('g:i A', trim($time12h))->format('H:i:s');
    }

    private function yesNoValue($value): string
    {
        if ($value === null) return 'NO';
        if (is_bool($value)) return $value ? 'YES' : 'NO';

        $v = strtoupper(trim((string) $value));
        if (in_array($v, ['YES', 'Y', 'TRUE', '1', 'ON'], true)) return 'YES';

        return 'NO';
    }

    private function resolveAuthenticatedPatient(): ?Patient
    {
        $patientId = session('impersonated_patient_id') ?: session('patient_id');

        if ($patientId) {
            return Patient::find($patientId);
        }

        return auth()->user()?->patient;
    }

    public function reschedule($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);

        $appointmentCountsPerDay = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $appointmentCountsPerSlot = Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('DATE(appointment_date) as date, appointment_time, COUNT(*) as count')
            ->groupBy('date', 'appointment_time')
            ->get()
            ->groupBy(function ($item) {
                return $item->date;
            })
            ->map(function ($group) {
                return $group->pluck('count', 'appointment_time')->toArray();
            })
            ->toArray();

        $unavailableDates = [];

        $philippineHolidays = PhilippineHolidays::current();

        return view('dentist.dentist-reschedule', compact(
            'appointment',
            'appointmentCountsPerDay',
            'appointmentCountsPerSlot',
            'unavailableDates',
            'philippineHolidays'
        ));
    }

    /**
     * Update the rescheduled appointment
     */
    public function updateReschedule(Request $request, $id)
    {
        $request->validate([
            'new_appointment_date' => 'required|date|after_or_equal:today',
            'new_appointment_time' => 'required',
            'service_type' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($id);

        try {
            $mysqlTime = $this->toMysqlTime($request->new_appointment_time);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid time format. Please pick a valid time slot.');
        }

        $slotTaken = Appointment::where('appointment_date', $request->new_appointment_date)
            ->where('appointment_time', $mysqlTime)
            ->where('id', '!=', $id)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->exists();

        if ($slotTaken) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, that time slot is already taken. Please choose another time.');
        }

        $appointment->update([
            'appointment_date' => $request->new_appointment_date,
            'appointment_time' => $mysqlTime,
            'service_type' => $request->service_type,
            'status' => 'rescheduled',
        ]);

        $appointment->load('patient');

        $dentists = User::query()
            ->where('status', 'active')
            ->whereHas('role', function ($query) {
                $query->where('slug', 'dentist');
            })
            ->get();

        if ($dentists->isNotEmpty()) {
            foreach ($dentists as $dentist) {
                $dentist->notify(new AppointmentRescheduledNotification($appointment, 'Patient'));
            }
        }

        return response()->json(['success' => true]);
    }

    private function isDrawnSignatureSubmission(Request $request): bool
    {
        $signatureFile = $request->file('patient_signature');

        return $request->input('signature_source') === 'drawn'
            && $signatureFile
            && str_starts_with($signatureFile->getClientOriginalName(), 'drawn-signature-');
    }
}
