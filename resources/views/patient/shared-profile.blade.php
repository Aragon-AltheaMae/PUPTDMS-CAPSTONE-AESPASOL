@php
$profileMode = $profileMode ?? 'dentist';

$layoutRole = $profileMode === 'admin' ? 'admin' : 'dentist';
@endphp

@extends('layouts.app')

@section('layout-role', $layoutRole)

@section('title', 'Patient Profile')

@section('usesPatientProfile', true)

@section('content')

@php
use Carbon\Carbon;

$isDentistProfile = $profileMode === 'dentist';

$patientName = $patient->name ?? 'Unknown Patient';
$displayName = ucwords(strtolower($patient->name ?? 'Guest'));
$age = $patient->birthdate ? Carbon::parse($patient->birthdate)->age : null;
$birthdateFormatted = $patient->birthdate ? Carbon::parse($patient->birthdate)->format('M d, Y') : 'N/A';

$futureCount = isset($futureVisits) ? $futureVisits->count() : 0;
$pastCount = isset($pastVisits) ? $pastVisits->count() : 0;

$medicalAnswers = optional($patient->medicalHistory)->answers ?? collect();
$dentalDates = optional($patient->dentalHistoryDates);
$signatureReviewStatus = optional($patient->medicalHistory)->signature_review_status;
$signatureReviewNotes = optional($patient->medicalHistory)->signature_review_notes;
$signaturePath = optional($patient->medicalHistory)->patient_signature;
$signatureUrl = $signaturePath ? asset('storage/' . $signaturePath) : null;
$isPendingManualReview = $signatureReviewStatus === 'pending_manual_review';
$isInvalidSignature = $signatureReviewStatus === 'invalid_reupload_required';
$showManualSignatureReview =
in_array($profileMode, ['admin', 'dentist'], true) &&
in_array($signatureReviewStatus, ['pending_manual_review', 'invalid_reupload_required'], true) &&
!empty($signaturePath);

$from = request('from');

if ($profileMode === 'admin') {
$backUrl = $from === 'patients' ? route('admin.admin.patients') : route('admin.admin.appointments');

$backLabel = $from === 'patients' ? 'Patients' : 'Appointments';
} else {
$backUrl =
$from === 'dashboard' ? route('dentist.dentist.dashboard') : route('dentist.dentist.appointments');

$backLabel = $from === 'dashboard' ? 'Dashboard' : 'Appointments';
}

$patientAvatar = $patient->profile_image ?? null;
$userAvatar = optional($patient->user)->profile_image ?? null;

if (!empty($patientAvatar)) {
$avatarUrl = asset('storage/' . $patientAvatar);
} elseif (!empty($userAvatar)) {
$avatarUrl = asset('storage/' . $userAvatar);
} else {
$avatarUrl =
'https://ui-avatars.com/api/?name=' .
urlencode($displayName) .
'&background=8B0000&color=ffffff&bold=true';
}

$identityLabel = $patient->faculty_code ? 'Faculty Code' : 'Student No';
$identityValue = $patient->faculty_code ?: ($patient->student_no ?: 'N/A');

$emergencyPerson = optional($patient->medicalHistory)->emergency_person;
$emergencyNumber = optional($patient->medicalHistory)->emergency_number ?? 'N/A';
$emergencyRelation = optional($patient->medicalHistory)->emergency_relation;

$profileIsActive = true;

$patientType = $patient->faculty_code ? 'Faculty' : ($patient->student_no ? 'Student' : 'Patient');

$procedureAppointment = collect($futureVisits ?? [])
->first(function ($visit) {
if (empty($visit->appointment_date)) {
return false;
}

$status = strtolower(trim((string) ($visit->status ?? '')));

$eligibleStatus = in_array(
$status,
[
'upcoming',
'rescheduled',
'today',
'scheduled_today',
],
true
);

return $eligibleStatus &&
Carbon::parse($visit->appointment_date)->isToday();
});

$canStartProcedure =
$isDentistProfile &&
!empty($procedureAppointment);
$odontogramData = optional($patient->odontogram)->odontogram_data ?? [];
$odontogramLastUpdatedAt = optional($patient->odontogram)->updated_at;
$odontogramLastUpdatedBy = optional($patient->odontogram)->updated_by;
$odontogramMetaVisit = $lastVisit ?? ($appointment ?? ($nextAppointment ?? null));
$odontogramMetaDate = $odontogramMetaVisit?->appointment_date
? Carbon::parse($odontogramMetaVisit->appointment_date)->format('M d, Y')
: 'Recorded visit';
$odontogramMetaService = $odontogramMetaVisit?->service_type ?: 'Dental Treatment';
@endphp

<main id="mainContent" class="patient-profile-page pt-[100px] px-3 md:px-6 py-6 min-h-screen flex-1">
    <div class="w-full fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <p class="text-xs text-gray-500 mb-1.5 font-medium uppercase tracking-wider">
                    <a href="{{ $backUrl }}" class="hover:text-[#8B0000] transition">{{ $backLabel }}</a>
                    <span class="mx-1">/</span> Patient Record
                </p>

                <div class="flex items-center gap-3">
                    <a href="{{ $backUrl }}" class="ui-icon-btn neutral" data-tooltip="Back to {{ $backLabel }}"
                        aria-label="Back to {{ $backLabel }}">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>

                    <h1 class="patient-profile-title">
                        Patient Profile
                    </h1>
                </div>
            </div>

            @if ($isDentistProfile)
            <div class="flex items-center gap-2">
                <a href="{{ route('dentist.odontogram.existing-appointment.create', ['patient' => $patient->id]) }}"
                    class="ui-btn ui-btn-secondary">
                    <i class="fa-solid fa-clock-rotate-left text-xs"></i> Add Existing Appointment
                </a>
                @if ($canStartProcedure)
                <button type="button" onclick="openStartModal()" class="ui-btn ui-btn-primary">
                    <i class="fa-solid fa-play"></i>
                    <span>Start Procedure</span>
                </button>
                @endif
            </div>
            @endif
        </div>

        <div class="patient-profile-layout">
            <aside class="patient-profile-sidebar">
                <div id="profileContainer">
                    <article class="card patient-summary-card fade-up">
                        <div class="patient-summary-cover"></div>

                        <div class="patient-summary-avatar-wrap">
                            <img src="{{ $avatarUrl }}" alt="{{ $displayName }}" class="patient-summary-avatar">
                        </div>

                        <div class="patient-summary-heading">
                            <div class="patient-summary-name-row">
                                <h2 class="patient-summary-name">
                                    {{ $displayName }}
                                </h2>

                                <button id="patientProfilePrivacyToggle" type="button"
                                    class="ui-icon-btn neutral patient-privacy-toggle" data-masked="true"
                                    data-tooltip="Show private information" data-tooltip-tone="neutral"
                                    aria-label="Show private information" aria-pressed="false"
                                    onclick="togglePatientProfilePrivacy(this)">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>

                            <div class="patient-summary-badges">
                                @php
                                $patientRoleClass = match ($patientType) {
                                'Faculty' => 'role-faculty',
                                'Student' => 'role-student',
                                default => 'role-patient',
                                };

                                $patientRoleIcon = match ($patientType) {
                                'Faculty' => 'fa-chalkboard-user',
                                'Student' => 'fa-user-graduate',
                                default => 'fa-user',
                                };
                                @endphp

                                <span class="badge-role {{ $patientRoleClass }}">
                                    <i class="fa-solid {{ $patientRoleIcon }}"></i>
                                    <span>{{ $patientType }}</span>
                                </span>

                                <span class="status-pill status-active">
                                    <span class="status-dot"></span>
                                    <span>Profile Active</span>
                                </span>
                            </div>
                        </div>

                        <div class="patient-summary-details">
                            <div class="patient-detail-row patient-detail-row-birth">
                                <div class="patient-detail-label">
                                    <i class="fa-solid fa-cake-candles"></i>

                                    <span>
                                        <span>Age</span>
                                        <span>Date of Birth</span>
                                    </span>
                                </div>

                                <div class="patient-detail-value">
                                    <strong>{{ $age ? $age . ' yrs' : 'N/A' }}</strong>
                                    <span>{{ $birthdateFormatted }}</span>
                                </div>
                            </div>

                            <div class="patient-detail-row">
                                <div class="patient-detail-label">
                                    <i class="fa-solid fa-venus-mars"></i>
                                    <span>Gender</span>
                                </div>

                                <div class="patient-detail-value">
                                    <strong>{{ $patient->gender ?? 'N/A' }}</strong>
                                </div>
                            </div>

                            <div class="patient-detail-row">
                                <div class="patient-detail-label">
                                    <i class="fa-regular fa-id-badge"></i>
                                    <span>{{ $identityLabel }}</span>
                                </div>

                                <div id="profileIdentityValue" class="patient-detail-value patient-sensitive-value"
                                    data-raw="{{ $identityValue }}" data-type="identity">
                                    <strong></strong>
                                </div>
                            </div>

                            <div class="patient-detail-row">
                                <div class="patient-detail-label">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>Contact</span>
                                </div>

                                <div id="profileContactValue" class="patient-detail-value patient-sensitive-value"
                                    data-raw="{{ $patient->phone ?? 'N/A' }}" data-type="phone">
                                    <strong></strong>
                                </div>
                            </div>

                            <div class="patient-detail-row">
                                <div class="patient-detail-label">
                                    <i class="fa-solid fa-envelope"></i>
                                    <span>Email</span>
                                </div>

                                <div id="profileEmailValue" class="patient-detail-value patient-sensitive-value"
                                    data-raw="{{ $patient->email ?? 'N/A' }}" data-type="email">
                                    <strong></strong>
                                </div>
                            </div>
                        </div>

                        <div class="patient-emergency-panel">
                            <p class="patient-emergency-label">
                                <i class="fa-solid fa-heart-pulse"></i>
                                Emergency Contact
                            </p>

                            @if ($emergencyPerson)
                            <div class="patient-emergency-content">
                                <div>
                                    <strong class="patient-emergency-name">
                                        {{ $emergencyPerson }}
                                    </strong>

                                    @if ($emergencyRelation)
                                    <span class="patient-emergency-relation">
                                        ({{ $emergencyRelation }})
                                    </span>
                                    @endif
                                </div>

                                <div id="profileEmergencyValue" class="patient-emergency-number patient-sensitive-value"
                                    data-raw="{{ $emergencyNumber }}" data-type="phone">
                                    <i class="fa-solid fa-phone"></i>
                                    <strong></strong>
                                </div>
                            </div>
                            @else
                            <div class="patient-emergency-empty">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="global-info-value">No emergency contact added</span>
                            </div>
                            @endif
                        </div>

                        @if ($showManualSignatureReview)
                        <div
                            class="{{ $isInvalidSignature ? 'bg-red-50/70 border-red-100' : 'bg-amber-50/70 border-amber-100' }} px-5 py-4 border-t">
                            <p
                                class="text-[10px] font-bold {{ $isInvalidSignature ? 'text-red-800' : 'text-amber-800' }} uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-file-signature"></i>
                                {{ $isInvalidSignature ? 'Signature Re-upload Requested' : 'Signature Review Required'
                                }}
                            </p>

                            <div
                                class="rounded-xl border {{ $isInvalidSignature ? 'border-red-200' : 'border-amber-200' }} bg-white p-3 shadow-sm">
                                <a href="{{ $signatureUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="block overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                                    <img src="{{ $signatureUrl }}" alt="Patient signature for manual review"
                                        class="w-full h-auto object-contain max-h-56">
                                </a>

                                <div class="mt-3 space-y-2">
                                    <div
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $isInvalidSignature ? 'bg-red-100 text-red-800 border-red-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                                        <i
                                            class="fa-solid {{ $isInvalidSignature ? 'fa-circle-xmark' : 'fa-triangle-exclamation' }} text-[10px]"></i>
                                        {{ $isInvalidSignature ? 'Invalid Signature' : 'Pending Manual Review' }}
                                    </div>

                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        {{ $signatureReviewNotes ?:
                                        'The AI signature checker was unavailable during
                                        submission, so this uploaded signature needs manual review.' }}
                                    </p>

                                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                                        <a href="{{ $signatureUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="ui-btn ui-btn-secondary ui-btn-sm">
                                            <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                                            Open Full Signature
                                        </a>

                                        @if ($isPendingManualReview)
                                        <form method="POST"
                                            action="{{ $profileMode === 'admin' ? route('admin.patient.signature.invalid', $patient) : route('dentist.patient.signature.invalid', $patient) }}"
                                            onsubmit="return confirm('Mark this uploaded signature as invalid and notify the patient to upload a new one?');"
                                            class="ml-auto">
                                            @csrf
                                            <button type="submit" class="ui-btn ui-btn-secondary ui-btn-sm">
                                                <i class="fa-solid fa-ban text-[8px]"></i>
                                                Invalid Signature
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </article>
                </div>
            </aside>

            <section class="patient-profile-content">
                <div id="statCards" class="stat-grid">
                    <article class="stat-card s-blue">

                        <div class="stat-card-info">
                            <p class="stat-num">
                                {{ $totalVisits ?? $pastCount + $futureCount }}
                            </p>

                            <p class="stat-label">
                                Total Visits
                            </p>
                        </div>

                        <div class="stat-icon-wrapper">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>

                    </article>

                    <article class="stat-card s-purple">

                        <div class="stat-card-info">
                            <p class="stat-value-text">
                                {{ $lastVisit?->appointment_date
                                ? Carbon::parse($lastVisit->appointment_date)->format('M d, Y')
                                : 'No past visits' }}
                            </p>

                            <p class="stat-label">
                                Last Visit
                            </p>
                        </div>

                        <div class="stat-icon-wrapper">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>

                    </article>

                    <article class="stat-card s-amber">

                        <div class="stat-card-info">
                            <p class="stat-value-text">
                                {{ $nextAppointment?->appointment_date
                                ? Carbon::parse($nextAppointment->appointment_date)->format('M d, Y')
                                : 'No schedule' }}
                            </p>

                            <p class="stat-label">
                                Next Appointment
                            </p>
                        </div>

                        <div class="stat-icon-wrapper">
                            <i class="fa-regular fa-calendar-plus"></i>
                        </div>

                    </article>
                </div>

                <section class="card profile-section-card treatment-history-card">
                    <div class="card-header treatment-history-header">
                        <div class="card-header-left">
                            <div class="card-header-icon status-upcoming">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>

                            <div>
                                <h2 class="card-title">Treatment History</h2>
                                <p class="card-subtitle">
                                    Review upcoming appointments and completed patient visits.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body treatment-history-body">
                        <div class="treatment-tabs" role="tablist" aria-label="Treatment history">
                            <button id="futureTab" type="button" class="treatment-tab is-active" role="tab"
                                aria-selected="true" aria-controls="futureContent"
                                onclick="switchTreatmentTab('future')">
                                <i class="fa-regular fa-calendar"></i>

                                <span>Upcoming</span>

                                <span class="treatment-tab-count">
                                    {{ $futureCount }}
                                </span>
                            </button>

                            <button id="pastTab" type="button" class="treatment-tab" role="tab" aria-selected="false"
                                aria-controls="pastContent" onclick="switchTreatmentTab('past')">
                                <i class="fa-solid fa-clock-rotate-left"></i>

                                <span>Past Visits</span>

                                <span class="treatment-tab-count">
                                    {{ $pastCount }}
                                </span>
                            </button>
                        </div>

                        <div id="futureContent" class="treatment-tab-panel is-active">
                            @forelse($futureVisits ?? [] as $visit)
                            @php
                            $visitDate = $visit->appointment_date
                            ? Carbon::parse($visit->appointment_date)->format('d M Y')
                            : 'N/A';
                            $visitTime = $visit->appointment_time
                            ? Carbon::parse($visit->appointment_time)->format('g:i A')
                            : 'N/A';
                            $rawVisitService = $visit->service_type ?? 'Appointment';
                            $visitService = strtolower(trim((string) $rawVisitService)) === 'follow-up'
                            ? 'Follow-up Appointment'
                            : $rawVisitService;
                            $visitStatus = $visit->status ?? 'upcoming';
                            $visitProcedure = $visit->procedure;
                            $visitFollowUp = $visit->followUpAppointments
                            ->sortBy('appointment_time')
                            ->sortBy('appointment_date')
                            ->first();
                            $visitRecord = [
                            'id' => $visit->id,
                            'date' => $visitDate,
                            'time' => $visitTime,
                            'service' => $visitService,
                            'status' => $visitStatus,
                            'duration_seconds' =>
                            $visitProcedure
                            ?->procedure_duration_seconds,
                            'oral_examination' => $visitProcedure?->oral_examination,
                            'diagnosis' => $visitProcedure?->diagnosis,
                            'prescriptions' => $visitProcedure?->prescriptions,
                            'odontogram_data' => $visitProcedure?->odontogram_data,
                            'follow_up' => $visitFollowUp
                            ? [
                            'date' => $visitFollowUp->appointment_date
                            ? Carbon::parse($visitFollowUp->appointment_date)->format('d M Y')
                            : 'N/A',
                            'time' => $visitFollowUp->appointment_time
                            ? Carbon::parse($visitFollowUp->appointment_time)->format('g:i A')
                            : 'N/A',
                            'service' => $visitFollowUp->service_type ?? 'Follow-up',
                            'status' => $visitFollowUp->status ?? 'upcoming',
                            'reason' => $visitFollowUp->follow_up_reason,
                            ]
                            : null,
                            ];
                            @endphp

                            @php
                            $apptDate = Carbon::parse($visit->appointment_date);
                            $apptTime = Carbon::parse($visit->appointment_time);

                            $rawStatus = strtolower(
                            trim((string) ($visit->status ?? 'upcoming'))
                            );

                            $statusClass = match ($rawStatus) {
                            'rescheduled' => 'status-rescheduled',

                            'upcoming',
                            'scheduled',
                            'confirmed' => 'status-upcoming',

                            'completed' => 'status-completed',

                            'cancelled',
                            'canceled' => 'status-cancelled',

                            default => 'status-default',
                            };

                            $dentistName =
                            $visit->dentist?->name
                            ?? 'Not yet assigned';
                            @endphp

                            <div class="global-record-card appt-visit-card appt-visit-card-upcoming {{ $statusClass }}">

                                <div class="appt-visit-date">
                                    <span class="appt-visit-day">
                                        {{ $apptDate->format('d') }}
                                    </span>

                                    <span class="appt-visit-month">
                                        {{ $apptDate->format('M') }}
                                    </span>

                                    <span class="appt-visit-year">
                                        {{ $apptDate->format('Y') }}
                                    </span>
                                </div>

                                <div class="appt-visit-main">

                                    <div class="appt-visit-head">

                                        <div class="appt-visit-title-group">

                                            <h3 class="appt-visit-title">
                                                {{ $visitService }}
                                            </h3>

                                            <span class="status-pill {{ $statusClass }}">
                                                <span class="status-dot"></span>
                                                {{ Str::headline($rawStatus) }}
                                            </span>

                                        </div>

                                    </div>

                                    <div class="appt-visit-meta">

                                        <span class="global-info-pill">
                                            <i class="fa-regular fa-clock"></i>
                                            <span>
                                                {{ $apptTime->format('g:i A') }}
                                            </span>
                                        </span>

                                        <span class="global-info-pill">
                                            <i class="fa-solid fa-user-doctor"></i>
                                            <span>{{ $dentistName }}</span>
                                        </span>

                                    </div>

                                </div>

                            </div>
                            @empty
                            <div class="empty-state treatment-history-empty">
                                <div class="appointment-empty-icon">
                                    <i class="fa-regular fa-calendar-xmark"></i>
                                </div>

                                <h3 class="empty-state-title">
                                    No upcoming appointments
                                </h3>

                                <p class="empty-state-sub">
                                    This patient currently has no scheduled or rescheduled appointments.
                                </p>
                            </div>
                            @endforelse
                        </div>

                        <div id="pastContent" class="treatment-tab-panel" hidden>
                            @forelse($pastVisits ?? [] as $visit)
                            @php
                            $visitDate = $visit->appointment_date
                            ? Carbon::parse($visit->appointment_date)->format('d M Y')
                            : 'N/A';
                            $visitTime = $visit->appointment_time
                            ? Carbon::parse($visit->appointment_time)->format('g:i A')
                            : 'N/A';
                            $rawVisitService = $visit->service_type ?? 'Appointment';
                            $visitService = strtolower(trim((string) $rawVisitService)) === 'follow-up'
                            ? 'Follow-up Appointment'
                            : $rawVisitService;
                            $visitStatus = $visit->status ?? 'completed';
                            $visitProcedure = $visit->procedure;

                            $visitOdontogramData = collect($visitProcedure?->odontogram_data ?? []);
                            $appliedTreatments = $visitOdontogramData
                            ->flatMap(function ($entry) {
                            $labels = collect();

                            $statusLabel = data_get($entry, 'status.label');
                            if ($statusLabel) {
                            $labels->push($statusLabel);
                            }

                            $threeDLabel = data_get($entry, 'threeD.label');
                            if ($threeDLabel) {
                            $labels->push($threeDLabel);
                            }

                            foreach (['top', 'left', 'center', 'right', 'bottom'] as $surface) {
                            $surfaceLabel = data_get($entry, "surfaces.$surface.label");

                            if ($surfaceLabel) {
                            $labels->push($surfaceLabel);
                            }
                            }

                            return $labels;
                            })
                            ->filter()
                            ->unique()
                            ->values();

                            $isOralProphylaxis =strcasecmp(trim((string) $visitService),
                            'Oral Prophylaxis'
                            ) === 0;

                            $visitTreatment = $appliedTreatments->isNotEmpty()
                            ? $appliedTreatments->implode(', ')
                            : ($isOralProphylaxis ? 'Teeth Cleaning' : 'N/A');

                            $visitFollowUp = $visit->followUpAppointments
                            ->sortBy('appointment_time')
                            ->sortBy('appointment_date')
                            ->first();
                            $visitRecord = [
                            'id' => $visit->id,
                            'date' => $visitDate,
                            'time' => $visitTime,
                            'service' => $visitService,
                            'status' => $visitStatus,
                            'treatment' => $visitTreatment,
                            'duration_seconds' =>
                            $visitProcedure
                            ?->procedure_duration_seconds,
                            'oral_examination' => $visitProcedure?->oral_examination,
                            'diagnosis' => $visitProcedure?->diagnosis,
                            'prescriptions' => $visitProcedure?->prescriptions,
                            'odontogram_data' => $visitProcedure?->odontogram_data,
                            'follow_up' => $visitFollowUp
                            ? [
                            'date' => $visitFollowUp->appointment_date
                            ? Carbon::parse($visitFollowUp->appointment_date)->format('d M Y')
                            : 'N/A',
                            'time' => $visitFollowUp->appointment_time
                            ? Carbon::parse($visitFollowUp->appointment_time)->format('g:i A')
                            : 'N/A',
                            'service' => $visitFollowUp->service_type ?? 'Follow-up',
                            'status' => $visitFollowUp->status ?? 'upcoming',
                            'reason' => $visitFollowUp->follow_up_reason,
                            ]
                            : null,
                            ];
                            @endphp

                            @php
                            $apptDate = Carbon::parse($visit->appointment_date);
                            $apptTime = Carbon::parse($visit->appointment_time);

                            $rawStatus = strtolower(
                            trim((string) ($visit->status ?? 'completed'))
                            );
                            @endphp

                            @php
                            $displayStatus = $rawStatus;
                            $statusClass = match ($displayStatus) {
                            'completed' => 'status-completed',

                            'cancelled',
                            'canceled' => 'status-cancelled',

                            'rescheduled' => 'status-rescheduled',

                            'upcoming',
                            'scheduled',
                            'confirmed' => 'status-upcoming',

                            default => 'status-default',
                            };

                            $dentistName =
                            $visit->dentist?->name
                            ?? 'Not assigned';
                            @endphp

                            <div class="global-record-card appt-visit-card appt-visit-card-past {{ $statusClass }}">

                                <div class="appt-visit-date appt-visit-date-muted">

                                    <span class="appt-visit-day">
                                        {{ $apptDate->format('d') }}
                                    </span>

                                    <span class="appt-visit-month">
                                        {{ $apptDate->format('M') }}
                                    </span>

                                    <span class="appt-visit-year">
                                        {{ $apptDate->format('Y') }}
                                    </span>

                                </div>

                                <div class="appt-visit-main">

                                    <div class="appt-visit-head">

                                        <div class="appt-visit-title-group">

                                            <h3 class="appt-visit-title">
                                                {{ $visitService }}
                                            </h3>

                                            <span class="status-pill {{ $statusClass }}">
                                                <span class="status-dot"></span>

                                                <span>
                                                    {{ Str::headline($displayStatus) }}
                                                </span>
                                            </span>

                                        </div>

                                    </div>

                                    <div class="appt-visit-meta">

                                        <span class="global-info-pill">
                                            <i class="fa-regular fa-clock"></i>

                                            <span>
                                                {{ $apptTime->format('g:i A') }}
                                            </span>
                                        </span>

                                        <span class="global-info-pill">
                                            <i class="fa-solid fa-user-doctor"></i>

                                            <span>
                                                {{ $dentistName }}
                                            </span>
                                        </span>

                                    </div>

                                </div>

                                <div class="appt-visit-actions">

                                    <button type="button" data-record='@json(
                $visitRecord,
                JSON_HEX_TAG |
                JSON_HEX_APOS |
                JSON_HEX_AMP |
                JSON_HEX_QUOT
            )' onclick="openRecordModal(
                JSON.parse(this.dataset.record)
            )" class="ui-action-btn ui-action-view" aria-label="View details" data-tooltip="View details"
                                        data-tooltip-tone="view">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                </div>

                            </div>
                            @empty
                            <div class="empty-state treatment-history-empty">
                                <div class="appointment-empty-icon">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>

                                <h3 class="empty-state-title">
                                    No past visits
                                </h3>

                                <p class="empty-state-sub">
                                    Completed and cancelled appointment records will appear here.
                                </p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="card health-lifestyle-card mb-10">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-header-icon status-completed">
                                <i class="fa-solid fa-notes-medical"></i>
                            </div>

                            <div>
                                <h2 class="card-title">
                                    Health & Lifestyle Information
                                </h2>

                                <p class="card-subtitle">
                                    Patient dental, medical, and lifestyle records.
                                </p>
                            </div>
                        </div>

                        <div class="card-header-right">
                            <span class="status-pill status-completed">
                                <span class="status-dot"></span>
                                <span>Latest Record</span>
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="space-y-6">

                            {{-- =========================
                            DENTAL HISTORY
                            ========================== --}}
                            <div>
                                <div class="section-card-title">
                                    <i class="fa-solid fa-tooth"></i>
                                    <span>Dental History</span>
                                    <span class="section-card-title-line"></span>
                                </div>

                                <div class="global-info-grid global-info-grid-2">

                                    <div class="global-info-item global-info-item-compact">
                                        <span class="global-info-icon status-completed">
                                            <i class="fa-regular fa-calendar-check"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                Last Dental Visit
                                            </span>

                                            <strong class="global-info-value">
                                                {{ optional($patient->dentalHistory)->last_dental_visit
                                                ? Carbon::parse(
                                                optional($patient->dentalHistory)->last_dental_visit
                                                )->format('M d, Y')
                                                : 'N/A' }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="global-info-item global-info-item-compact">
                                        <span class="global-info-icon status-default">
                                            <i class="fa-solid fa-user-doctor"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                Previous Dentist
                                            </span>

                                            <strong class="global-info-value">
                                                {{ optional($patient->dentalHistory)->previous_dentist ?? 'N/A' }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="global-info-item global-info-item-compact">
                                        <span class="global-info-icon status-default">
                                            <i class="fa-solid fa-tooth"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                Extraction Date
                                            </span>

                                            <strong class="global-info-value">
                                                {{ $dentalDates?->extraction_date
                                                ? Carbon::parse($dentalDates->extraction_date)->format('M d, Y')
                                                : 'N/A' }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="global-info-item global-info-item-compact">
                                        <span class="global-info-icon status-default">
                                            <i class="fa-solid fa-teeth-open"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                Dentures Date
                                            </span>

                                            <strong class="global-info-value">
                                                {{ $dentalDates?->dentures_date
                                                ? Carbon::parse($dentalDates->dentures_date)->format('M d, Y')
                                                : 'N/A' }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="global-info-item global-info-item-compact global-info-item-wide">
                                        <span class="global-info-icon status-default">
                                            <i class="fa-solid fa-teeth"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                Orthodontic Treatment Date
                                            </span>

                                            <strong class="global-info-value">
                                                {{ $dentalDates?->ortho_date
                                                ? Carbon::parse($dentalDates->ortho_date)->format('M d, Y')
                                                : 'N/A' }}
                                            </strong>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- =========================
                            DENTAL SYMPTOMS & HABITS
                            ========================== --}}
                            <div>
                                <div class="section-card-title">
                                    <i class="fa-solid fa-notes-medical"></i>
                                    <span>Dental Symptoms & Habits</span>
                                    <span class="section-card-title-line"></span>
                                </div>

                                <div class="global-info-group">
                                    @php
                                    $hasDentalAnswer = false;
                                    @endphp

                                    @foreach ($patient->dentalHistoryAnswers ?? [] as $dentAnswer)
                                    @if ($dentAnswer->answer)
                                    @php
                                    $hasDentalAnswer = true;
                                    @endphp

                                    <span class="status-pill status-completed">
                                        <span class="status-dot"></span>

                                        <span>
                                            {{ str_replace(
                                            '_',
                                            ' ',
                                            Str::title(
                                            optional($dentAnswer->condition)->code
                                            ?? 'Symptom'
                                            )
                                            ) }}
                                        </span>
                                    </span>
                                    @endif
                                    @endforeach

                                    @if (!$hasDentalAnswer)
                                    <span class="status-pill status-default">
                                        <span class="status-dot"></span>
                                        <span>No symptoms reported</span>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            {{-- =========================
                            MEDICAL HISTORY
                            ========================== --}}
                            <div>
                                <div class="section-card-title">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                    <span>Medical History</span>
                                    <span class="section-card-title-line"></span>
                                </div>

                                <div class="global-info-grid global-info-grid-2">
                                    @php
                                    $hasMedicalRecord = false;
                                    @endphp

                                    @foreach ($medicalAnswers as $mAns)
                                    @if (
                                    $mAns->answer_bool === true ||
                                    !empty($mAns->answer_text) ||
                                    !empty($mAns->answer_date)
                                    )
                                    @php
                                    $hasMedicalRecord = true;

                                    $medicalValue = collect([
                                    $mAns->answer_bool === true
                                    ? 'Yes'
                                    : null,

                                    $mAns->answer_text ?: null,

                                    $mAns->answer_date
                                    ? Carbon::parse($mAns->answer_date)->format('M d, Y')
                                    : null,
                                    ])
                                    ->filter()
                                    ->implode(' · ');
                                    @endphp

                                    <div class="global-info-item global-info-item-compact">
                                        <span class="global-info-icon status-default">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                {{ str_replace(
                                                '_',
                                                ' ',
                                                Str::title(
                                                optional($mAns->question)->code
                                                ?? 'Question'
                                                )
                                                ) }}
                                            </span>

                                            <strong class="global-info-value">
                                                {{ $medicalValue }}
                                            </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach

                                    @if (!$hasMedicalRecord)
                                    <div class="global-info-item global-info-item-compact">
                                        <span class="global-info-icon status-default">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </span>

                                        <div class="global-info-copy">
                                            <span class="global-info-label">
                                                Medical History
                                            </span>

                                            <strong class="global-info-value">
                                                No medical records found
                                            </strong>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>


                            {{-- =========================
                            MEDICAL CONDITIONS
                            ========================== --}}
                            <div>
                                <div class="section-card-title">
                                    <i class="fa-solid fa-disease"></i>
                                    <span>Medical Conditions</span>
                                    <span class="section-card-title-line"></span>
                                </div>

                                <div class="global-info-group">
                                    @if (
                                    isset($patient->medicalHistory->diseaseAnswers) &&
                                    $patient->medicalHistory->diseaseAnswers->count() > 0
                                    )
                                    @foreach (
                                    $patient->medicalHistory->diseaseAnswers
                                    as $diseaseAnswer
                                    )
                                    <span class="status-pill status-pending">
                                        <span class="status-dot"></span>

                                        <span>
                                            {{ $diseaseAnswer->disease->label ?? 'Condition' }}
                                        </span>
                                    </span>
                                    @endforeach
                                    @else
                                    <span class="status-pill status-default">
                                        <span class="status-dot"></span>
                                        <span>None reported</span>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            {{-- =========================
                            PATIENT ODONTOGRAM
                            ========================== --}}
                            <div>
                                <div class="section-card-title">
                                    <i class="fa-solid fa-teeth"></i>
                                    <span>Patient Odontogram</span>
                                    <span class="section-card-title-line"></span>

                                    @if (!empty($odontogramData))
                                    <span class="status-pill status-default">
                                        <span class="status-dot"></span>

                                        <span>
                                            {{ $odontogramLastUpdatedAt
                                            ? 'Updated ' . $odontogramLastUpdatedAt->format('M d, Y')
                                            : 'Saved Chart' }}
                                        </span>
                                    </span>
                                    @endif
                                </div>

                                @if (!empty($odontogramData))
                                @include('components.odontogram-preview', [
                                'odontogramData' => $odontogramData,
                                ])
                                @else
                                <div class="empty-state empty-state-compact">
                                    <div class="empty-state-icon">
                                        <i class="fa-solid fa-tooth"></i>
                                    </div>

                                    <h3 class="empty-state-title">
                                        No odontogram saved yet
                                    </h3>

                                    <p class="empty-state-sub">
                                        This patient does not have a recorded odontogram procedure yet.
                                    </p>
                                </div>
                                @endif
                            </div>


                            {{-- =========================
                            ADDITIONAL CONCERNS
                            ========================== --}}
                            <div>
                                <div class="section-card-title">
                                    <i class="fa-regular fa-comment-dots"></i>
                                    <span>Additional Dental Concerns</span>
                                    <span class="section-card-title-line"></span>
                                </div>

                                @php
                                $concerns =
                                optional($patient->dentalHistoryConcerns)
                                ->additional_concerns
                                ?? null;
                                @endphp

                                @if ($concerns)
                                <div class="global-info-item">
                                    <span class="global-info-icon status-pending">
                                        <i class="fa-regular fa-comment-dots"></i>
                                    </span>

                                    <div class="global-info-copy">
                                        <span class="global-info-label">
                                            Patient Concern
                                        </span>

                                        <span class="global-info-value">
                                            {{ $concerns }}
                                        </span>
                                    </div>
                                </div>
                                @else
                                <div class="global-info-item global-info-item-compact">
                                    <span class="global-info-icon status-default">
                                        <i class="fa-regular fa-comment"></i>
                                    </span>

                                    <div class="global-info-copy">
                                        <span class="global-info-label">
                                            Additional Dental Concerns
                                        </span>

                                        <span class="global-info-value">
                                            No additional concerns added
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </section>
        </div>
    </div>
</main>

@if ($canStartProcedure)
<div id="startModal" class="ui-modal modal-theme-primary" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="startProcedureModalTitle">
    <div class="ui-modal-card modal-sm">

        <div class="modal-hd">
            <div class="modal-heading">

                <div class="modal-icon">
                    <i class="fa-solid fa-play"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="startProcedureModalTitle" class="modal-title">
                        Start Procedure
                    </h2>

                    <p class="modal-subtitle">
                        Begin today's scheduled dental procedure.
                    </p>
                </div>

            </div>

            <button type="button" class="modal-x" onclick="closeStartModal()" aria-label="Close start procedure modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">

            <div class="global-confirm-alert">
                <i class="fa-solid fa-circle-play"></i>

                <div>
                    <strong>
                        Start this dental procedure?
                    </strong>

                    <span>
                        Confirm that the patient's appointment details are correct before continuing.
                    </span>
                </div>
            </div>

        </div>

        <div class="modal-ft">

            <button type="button" onclick="closeStartModal()" class="ui-btn ui-btn-secondary">
                Cancel
            </button>

            <button type="button" onclick="confirmStart()" class="ui-btn ui-btn-primary">
                <i class="fa-solid fa-play"></i>
                <span>Start Procedure</span>
            </button>

        </div>

    </div>
</div>
@endif
@endsection

@section('scripts')
<script>

    function maskPatientPhone(value) {
        const raw = String(value || '').trim();

        if (!raw || raw === 'N/A') {
            return 'N/A';
        }

        const digits = raw.replace(/\D/g, '');

        if (digits.length <= 4) {
            return '••' + digits.slice(-2);
        }

        return digits.slice(0, 2) + '••• ••• ' + digits.slice(-4);
    }

    function maskPatientEmail(value) {
        const raw = String(value || '').trim();

        if (!raw || raw === 'N/A') {
            return 'N/A';
        }

        const [local, domain] = raw.split('@');

        if (!domain) {
            return raw;
        }

        const visibleLocal = local.length > 2 ?
            local.slice(0, 2) :
            local.slice(0, 1);

        return `${visibleLocal}•••@${domain}`;
    }

    function maskPatientIdentity(value) {
        const raw = String(value || '').trim();

        if (!raw || raw === 'N/A') {
            return 'N/A';
        }

        if (raw.length <= 4) {
            return `••${raw.slice(-2)}`;
        }

        return `${raw.slice(0, 2)}••••${raw.slice(-2)}`;
    }

    function getMaskedPatientValue(type, value) {
        if (type === 'email') {
            return maskPatientEmail(value);
        }

        if (type === 'phone') {
            return maskPatientPhone(value);
        }

        return maskPatientIdentity(value);
    }

    function syncPatientSensitiveValues(masked = true) {
        document
            .querySelectorAll('#profileContainer .patient-sensitive-value')
            .forEach(element => {
                const rawValue = element.dataset.raw || 'N/A';
                const type = element.dataset.type || 'identity';
                const output = element.querySelector('strong') || element;

                output.textContent = masked ?
                    getMaskedPatientValue(type, rawValue) :
                    rawValue;

                element.dataset.masked = masked ? 'true' : 'false';
            });
    }

    function togglePatientProfilePrivacy(button) {
        if (!button) {
            return;
        }

        const currentlyMasked = button.dataset.masked !== 'false';
        const nextMasked = !currentlyMasked;

        syncPatientSensitiveValues(nextMasked);

        button.dataset.masked = nextMasked ? 'true' : 'false';
        button.setAttribute('aria-pressed', nextMasked ? 'false' : 'true');

        const tooltip = nextMasked ?
            'Show private information' :
            'Hide private information';

        button.dataset.tooltip = tooltip;
        button.setAttribute('aria-label', tooltip);

        button.innerHTML = nextMasked ?
            '<i class="fa-regular fa-eye"></i>' :
            '<i class="fa-regular fa-eye-slash"></i>';
    }

    document.addEventListener('DOMContentLoaded', () => {
        syncPatientSensitiveValues(true);
    });

    function switchTreatmentTab(tabName) {
        const futureTab =
            document.getElementById('futureTab');

        const pastTab =
            document.getElementById('pastTab');

        const futureContent =
            document.getElementById('futureContent');

        const pastContent =
            document.getElementById('pastContent');

        if (
            !futureTab ||
            !pastTab ||
            !futureContent ||
            !pastContent
        ) {
            return;
        }

        const showFuture = tabName === 'future';
        const activePanel = showFuture
            ? futureContent
            : pastContent;

        const inactivePanel = showFuture
            ? pastContent
            : futureContent;

        futureTab.classList.toggle(
            'is-active',
            showFuture
        );

        pastTab.classList.toggle(
            'is-active',
            !showFuture
        );

        futureTab.setAttribute(
            'aria-selected',
            showFuture ? 'true' : 'false'
        );

        pastTab.setAttribute(
            'aria-selected',
            showFuture ? 'false' : 'true'
        );

        inactivePanel.classList.remove(
            'is-active',
            'is-entering'
        );

        inactivePanel.hidden = true;

        activePanel.hidden = false;
        activePanel.classList.remove(
            'is-active',
            'is-entering'
        );

        void activePanel.offsetWidth;

        activePanel.classList.add(
            'is-active',
            'is-entering'
        );

        window.setTimeout(() => {
            activePanel.classList.remove(
                'is-entering'
            );
        }, 320);
    }

    function openStartModal() {
        window.openModal?.('startModal');
    }

    function closeStartModal() {
        window.closeModal?.('startModal');
    }
</script>
@endsection