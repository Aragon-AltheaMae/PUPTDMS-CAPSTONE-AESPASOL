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

$procedureAppointment = $nextAppointment ?? collect($futureVisits ?? [])->first();
$odontogramData = optional($patient->odontogram)->odontogram_data ?? [];
$odontogramLastUpdatedAt = optional($patient->odontogram)->updated_at;
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
                <a href="{{ route('dentist.odontogram.historical.create', ['patient' => $patient->id]) }}"
                    class="ui-btn ui-btn-secondary">
                    <i class="fa-solid fa-clock-rotate-left text-xs"></i> Add Existing Appointment
                </a>
                @if ($procedureAppointment)
                <button type="button" onclick="openStartModal()" class="ui-btn ui-btn-primary">
                    <i class="fa-solid fa-play text-xs"></i> Start Procedure
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
                                <span class="patient-type-badge">
                                    <i
                                        class="fa-solid {{ $patientType === 'Faculty' ? 'fa-chalkboard-user' : 'fa-user-graduate' }}"></i>
                                    {{ $patientType }}
                                </span>

                                <span class="status-badge status-completed">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Profile Active
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
                <div id="patientProfileStats" class="stat-grid patient-profile-stat-grid">
                    <article class="stat-card s-blue">
                        <div class="stat-icon-wrapper">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>

                        <div class="stat-card-info">
                            <p class="stat-num">
                                {{ $totalVisits ?? $pastCount + $futureCount }}
                            </p>

                            <p class="stat-label">
                                Total Visits
                            </p>
                        </div>
                    </article>

                    <article class="stat-card s-purple">
                        <div class="stat-icon-wrapper">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>

                        <div class="stat-card-info">
                            <p class="stat-value stat-value-text">
                                {{ $lastVisit?->appointment_date
                                ? Carbon::parse($lastVisit->appointment_date)->format('M d, Y')
                                : 'No past visits' }}
                            </p>

                            <p class="stat-label">
                                Last Visit
                            </p>
                        </div>
                    </article>

                    <article class="stat-card s-amber">
                        <div class="stat-icon-wrapper">
                            <i class="fa-regular fa-calendar-plus"></i>
                        </div>

                        <div class="stat-card-info">
                            <p class="stat-value stat-value-text">
                                {{ $nextAppointment?->appointment_date
                                ? Carbon::parse($nextAppointment->appointment_date)->format('M d, Y')
                                : 'No schedule' }}
                            </p>

                            <p class="stat-label">
                                Next Appointment
                            </p>
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
                            $visitService = $visit->service_type ?? 'Appointment';
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
                            $normalizedVisitStatus = strtolower(trim($visitStatus));

                            $globalStatusClass = match (true) {
                            str_contains($normalizedVisitStatus, 'resched') => 'status-rescheduled',
                            str_contains($normalizedVisitStatus, 'complete') => 'status-completed',
                            str_contains($normalizedVisitStatus, 'cancel') => 'status-cancelled',
                            in_array($normalizedVisitStatus, ['today', 'scheduled_today'], true) => 'status-today',
                            default => 'status-upcoming',
                            };
                            @endphp

                            <article class="card treatment-visit-card {{ $globalStatusClass }}"
                                data-appointment-status="{{ $normalizedVisitStatus }}">
                                <span class="treatment-visit-accent" aria-hidden="true"></span>

                                <div class="treatment-visit-date">
                                    <span class="treatment-visit-date-value">
                                        {{ $visitDate }}
                                    </span>

                                    <span class="treatment-visit-time">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $visitTime }}
                                    </span>
                                </div>

                                <div class="treatment-visit-main">
                                    <span class="status-badge {{ $globalStatusClass }}">
                                        {{ $visitStatus }}
                                    </span>

                                    <h3 class="treatment-visit-service">
                                        {{ $visitService }}
                                    </h3>

                                    <p class="treatment-visit-meta">
                                        <i class="fa-solid fa-user-doctor"></i>

                                        <span>
                                            {{ $visit->dentist->name ?? 'Dr. Angeles' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="treatment-visit-action">
                                    <button type="button"
                                        data-record='@json($visitRecord, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                        onclick="openRecordModal(JSON.parse(this.dataset.record))"
                                        class="ui-btn ui-btn-secondary ui-btn-sm">
                                        <i class="fa-regular fa-eye"></i>
                                        View Details
                                    </button>
                                </div>
                            </article>
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
                            $visitService = $visit->service_type ?? 'Appointment';
                            $visitStatus = $visit->status ?? 'completed';
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
                            $normalizedVisitStatus = strtolower(trim($visitStatus));

                            $globalStatusClass = match (true) {
                            str_contains($normalizedVisitStatus, 'resched') => 'status-rescheduled',
                            str_contains($normalizedVisitStatus, 'complete') => 'status-completed',
                            str_contains($normalizedVisitStatus, 'cancel') => 'status-cancelled',
                            in_array($normalizedVisitStatus, ['today', 'scheduled_today'], true) => 'status-today',
                            default => 'status-upcoming',
                            };
                            @endphp

                            <article class="card treatment-visit-card {{ $globalStatusClass }}"
                                data-appointment-status="{{ $normalizedVisitStatus }}">
                                <span class="treatment-visit-accent" aria-hidden="true"></span>

                                <div class="treatment-visit-date">
                                    <span class="treatment-visit-date-value">
                                        {{ $visitDate }}
                                    </span>

                                    <span class="treatment-visit-time">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $visitTime }}
                                    </span>
                                </div>

                                <div class="treatment-visit-main">
                                    <span class="status-badge {{ $globalStatusClass }}">
                                        {{ $visitStatus }}
                                    </span>

                                    <h3 class="treatment-visit-service">
                                        {{ $visitService }}
                                    </h3>

                                    <p class="treatment-visit-meta">
                                        <i class="fa-solid fa-tooth"></i>
                                        Treatment record
                                    </p>
                                </div>

                                <div class="treatment-visit-action">
                                    <button type="button"
                                        data-record='@json($visitRecord, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                        onclick="openRecordModal(JSON.parse(this.dataset.record))"
                                        class="ui-btn ui-btn-secondary ui-btn-sm">
                                        <i class="fa-regular fa-file-lines"></i>
                                        View Record
                                    </button>
                                </div>
                            </article>
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
                            <span class="status-badge status-completed">
                                Latest Record
                            </span>
                        </div>
                    </div>

                    <div class="card-body health-lifestyle-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        Dental History
                                    </p>

                                    <div class="space-y-2 text-sm">
                                        <p><span class="font-semibold text-gray-600">Last Dental Visit:</span>
                                            {{ optional($patient->dentalHistory)->last_dental_visit ?? 'N/A' }}</p>
                                        <p><span class="font-semibold text-gray-600">Previous Dentist:</span>
                                            {{ optional($patient->dentalHistory)->previous_dentist ?? 'N/A' }}</p>
                                        <p><span class="font-semibold text-gray-600">Extraction Date:</span>
                                            {{ $dentalDates->extraction_date ?? 'N/A' }}</p>
                                        <p><span class="font-semibold text-gray-600">Dentures Date:</span>
                                            {{ $dentalDates->dentures_date ?? 'N/A' }}</p>
                                        <p><span class="font-semibold text-gray-600">Orthodontic Treatment Date:</span>
                                            {{ $dentalDates->ortho_date ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        Dental Symptoms & Habits
                                    </p>

                                    <div class="flex flex-wrap gap-1.5">
                                        @php $hasDentalAnswer = false; @endphp

                                        @foreach ($patient->dentalHistoryAnswers ?? [] as $dentAnswer)
                                        @if ($dentAnswer->answer)
                                        @php $hasDentalAnswer = true; @endphp
                                        <span
                                            class="bg-teal-50 text-teal-700 text-[11px] font-bold px-2.5 py-1 rounded border border-teal-100">
                                            {{ str_replace('_', ' ', Str::title(optional($dentAnswer->condition)->code
                                            ??
                                            'Symptom')) }}
                                        </span>
                                        @endif
                                        @endforeach

                                        @if (!$hasDentalAnswer)
                                        <span
                                            class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1 rounded border border-gray-100">
                                            No symptoms reported
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        Medical History
                                    </p>

                                    <div class="space-y-2 text-sm">
                                        @forelse($medicalAnswers as $mAns)
                                        @if ($mAns->answer_bool === true || !empty($mAns->answer_text) ||
                                        !empty($mAns->answer_date))
                                        <p>
                                            <span class="font-semibold text-gray-600">
                                                {{ str_replace('_', ' ', Str::title(optional($mAns->question)->code ??
                                                'Question')) }}:
                                            </span>
                                            @if ($mAns->answer_bool === true)
                                            YES
                                            @endif
                                            @if (!empty($mAns->answer_text))
                                            {{ $mAns->answer_text }}
                                            @endif
                                            @if (!empty($mAns->answer_date))
                                            {{ $mAns->answer_date }}
                                            @endif
                                        </p>
                                        @endif
                                        @empty
                                        <p class="text-xs text-gray-400">No medical records found.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        Medical Conditions
                                    </p>

                                    <div class="flex flex-wrap gap-1.5">
                                        @if (isset($patient->medicalHistory->diseaseAnswers) &&
                                        $patient->medicalHistory->diseaseAnswers->count() > 0)
                                        @foreach ($patient->medicalHistory->diseaseAnswers as $diseaseAnswer)
                                        <span
                                            class="bg-purple-50 text-purple-700 text-[11px] font-bold px-2.5 py-1 rounded border border-purple-100">
                                            {{ $diseaseAnswer->disease->label ?? 'Condition' }}
                                        </span>
                                        @endforeach
                                        @else
                                        <span
                                            class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1 rounded border border-gray-100">
                                            None reported
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-5 border-t border-gray-100">
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    Patient Odontogram
                                </p>

                                @if (!empty($odontogramData))
                                <span class="text-[11px] text-gray-500 font-medium">
                                    {{ $odontogramLastUpdatedAt
                                    ? 'Updated ' . $odontogramLastUpdatedAt->format('M d, Y h:i A')
                                    : 'Saved chart' }}
                                </span>
                                @endif
                            </div>

                            @if (!empty($odontogramData))
                            @include('components.odontogram-preview', [
                            'odontogramData' => $odontogramData,
                            ])
                            @else
                            <div class="empty-state">
                                <div class="appointment-empty-icon">
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

                        <div class="mt-6 pt-5 border-t border-gray-100">
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                                Additional Dental Concerns
                            </p>

                            @php
                            $concerns = optional($patient->dentalHistoryConcerns)->additional_concerns ?? null;
                            @endphp

                            @if ($concerns)
                            <div
                                class="text-[13px] text-gray-700 leading-relaxed bg-yellow-50/50 p-4 rounded-lg border border-yellow-100">
                                {{ $concerns }}
                            </div>
                            @else
                            <p class="text-xs text-gray-400 italic">No additional concerns added.</p>
                            @endif
                        </div>
                </section>
        </div>
    </div>
</main>

@if ($isDentistProfile)
<div id="startModal" class="ui-modal" role="dialog" aria-modal="true">

    <div class="ui-modal-card modal-sm" id="startModalContent">

        <div class="modal-hd">
            <i class="fa-solid fa-play text-xl"></i>
        </div>

        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Start Procedure?</h2>

        <p class="text-sm text-gray-500 mb-6">
            You are about to start a new dental procedure session for this patient. Do you want to continue?
        </p>

        <div class="modal-ft">
            <button type="button" onclick="closeStartModal()" class="ui-btn ui-btn-secondary flex-1">
                Cancel
            </button>

            <button type="button" onclick="confirmStart()" class="ui-btn ui-btn-primary flex-1">
                Yes, Start
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
        const modal = document.getElementById('startModal');
        const content = document.getElementById('startModalContent');

        if (!modal || !content) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);

        document.body.style.overflow = 'hidden';
    }

    function closeStartModal() {
        const modal = document.getElementById('startModal');
        const content = document.getElementById('startModalContent');

        if (!modal || !content) return;

        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 200);
    }
</script>
@endsection