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

                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Patient Profile</h1>
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

                                <span class="patient-active-badge">
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
                                <span>No emergency contact added</span>
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
                            'treatment' => $visitProcedure?->completion_action,
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
                                        onclick="openDetailsDrawer(JSON.parse(this.dataset.record))"
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
                            'treatment' => $visitProcedure?->completion_action,
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
                                        onclick="openDetailsDrawer(JSON.parse(this.dataset.record))"
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
                                    ? 'Updated ' .
                                    $odontogramLastUpdatedAt->format('M d, Y h:i
                                    A')
                                    : 'Saved chart' }}
                                </span>
                                @endif
                            </div>

                            @if (!empty($odontogramData))
                            <div class="profile-odontogram-wrap">
                                <div class="profile-odontogram-head">
                                    <div>
                                        <p class="profile-odontogram-label">Odontogram</p>
                                        <p class="profile-odontogram-sub">Patient's saved chart with dentist markings
                                        </p>
                                    </div>

                                    <div class="profile-odontogram-legend">
                                        <span class="profile-odontogram-legend-item">
                                            <span class="profile-odontogram-legend-dot"
                                                style="background:#ef4444;"></span>
                                            Decay / Procedure
                                        </span>
                                        <span class="profile-odontogram-legend-item">
                                            <span class="profile-odontogram-legend-dot"
                                                style="background:#2563eb;"></span>
                                            Restoration
                                        </span>
                                        <span class="profile-odontogram-legend-item">
                                            <span class="profile-odontogram-legend-dot"
                                                style="background:#111827;"></span>
                                            Missing / Special
                                        </span>
                                    </div>
                                </div>

                                <div class="profile-odontogram-board-wrap">
                                    <div id="profileOdontogramLoading" class="profile-odontogram-loading">
                                        <i class="fa-solid fa-circle-notch fa-spin text-3xl text-[#8B0000]"></i>
                                        <p class="text-sm font-semibold text-gray-600">Generating 3D Model...</p>
                                    </div>

                                    <div id="profileOdontogramCanvas" class="profile-odontogram-canvas"></div>
                                    <div id="profileOdontogramTooltip" class="profile-odontogram-tooltip">
                                        <div id="profileOdontogramTooltipContent"></div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div
                                class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                                <p class="text-gray-600 font-bold text-sm">No odontogram saved yet</p>
                                <p class="text-xs text-gray-400 mt-1">This patient does not have a recorded odontogram
                                    procedure yet.</p>
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

@if (!empty($odontogramData))
<div id="profileOdontogramModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-3 sm:p-5"
    role="dialog" aria-modal="true" aria-labelledby="profileOdontogramModalTitle">

    <button type="button" class="absolute inset-0 bg-slate-950/65 backdrop-blur-sm"
        aria-label="Close odontogram details" onclick="closeProfileOdontogramModal()"></button>

    <div id="profileOdontogramModalContent"
        class="profile-odontogram-card relative z-10 w-full max-w-2xl max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100dvh-2.5rem)] overflow-hidden shadow-2xl"
        onclick="event.stopPropagation()">

        <div class="profile-odontogram-card-hero">
            <button type="button" onclick="closeProfileOdontogramModal()" class="profile-odontogram-close"
                aria-label="Close odontogram details">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 id="profileOdontogramModalTitle">Tooth #18</h3>
            <p id="profileOdontogramModalSubtitle">Upper Right · 3rd Molar</p>
        </div>

        <div class="profile-odontogram-card-body overflow-y-auto overscroll-contain"
            style="max-height: calc(100dvh - 9rem);">
            <div class="profile-odontogram-tooth-main">
                <div id="profileOdontogramToothVisual" class="profile-odontogram-tooth-visual"></div>

                <div>
                    <p class="profile-odontogram-info-label">Overall Marking</p>
                    <div id="profileOdontogramCondition" class="profile-odontogram-condition-pill">Healthy</div>
                </div>
            </div>

            <p id="profileOdontogramToothName" class="profile-odontogram-tooth-name">#18 — 3rd Molar</p>

            <div class="profile-odontogram-info-grid">
                <div class="profile-odontogram-info-box">
                    <p>FDI Number</p>
                    <strong id="profileOdontogramFdi">#18</strong>
                </div>
                <div class="profile-odontogram-info-box">
                    <p>Quadrant</p>
                    <strong id="profileOdontogramQuadrant">Upper Right</strong>
                </div>
                <div class="profile-odontogram-info-box">
                    <p>Tooth Type</p>
                    <strong id="profileOdontogramToothType">3rd Molar</strong>
                </div>
                <div class="profile-odontogram-info-box">
                    <p>Arch</p>
                    <strong id="profileOdontogramArch">Maxillary (Upper)</strong>
                </div>
            </div>

            <div class="profile-odontogram-history">
                <p class="profile-odontogram-info-label">Surface Markings</p>
                <div id="profileOdontogramSurfaceList" class="profile-odontogram-surface-list"></div>
            </div>

            <div class="profile-odontogram-history">
                <p class="profile-odontogram-info-label">Latest Saved Visit</p>
                <div class="profile-odontogram-history-item">
                    <span class="profile-odontogram-history-dot"></span>
                    <span>{{ $odontogramMetaDate }}</span>
                    <strong>{{ $odontogramMetaService }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($isDentistProfile)
<div id="startModal"
    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 transition-opacity items-center justify-center">

    <div class="bg-white w-full max-w-md rounded-2xl p-6 md:p-8 relative shadow-2xl mx-4 transform transition-transform scale-95"
        id="startModalContent">

        <div class="w-12 h-12 bg-red-50 text-[#8B0000] rounded-full flex items-center justify-center mb-5">
            <i class="fa-solid fa-play text-xl"></i>
        </div>

        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Start Procedure?</h2>

        <p class="text-sm text-gray-500 mb-6">
            You are about to start a new dental procedure session for this patient. Do you want to continue?
        </p>

        <div class="flex gap-3">
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

<div id="drawerOverlay" class="drawer-overlay fixed left-0 right-0 bottom-0 z-[110]" style="top: var(--header-h);"
    onclick="closeDetailsDrawer()"></div>

<aside id="detailsDrawer" class="side-drawer appointment-details-drawer" role="dialog" aria-modal="true"
    aria-labelledby="drawerService" aria-hidden="true">
    <header class="appointment-drawer-header">
        <div class="appointment-drawer-heading">
            <div class="card-header-icon status-upcoming">
                <i class="fa-regular fa-calendar-check"></i>
            </div>

            <div>
                <p class="appointment-drawer-eyebrow">
                    Appointment Details
                </p>

                <h2 id="drawerService" class="appointment-drawer-title">
                    Service Type
                </h2>

                <div class="appointment-drawer-schedule">
                    <span>
                        <i class="fa-regular fa-calendar"></i>
                        <span id="drawerDate">Date</span>
                    </span>

                    <span>
                        <i class="fa-regular fa-clock"></i>
                        <span id="drawerTime">Time</span>
                    </span>
                </div>
            </div>
        </div>

        <button type="button" onclick="closeDetailsDrawer()" class="ui-icon-btn neutral"
            aria-label="Close appointment details">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </header>

    <div class="appointment-drawer-status-bar">
        <span class="appointment-drawer-status-label">
            Status
        </span>

        <span id="drawerStatus" class="status-badge status-default">
            Status
        </span>
    </div>

    <div id="drawerBody" class="appointment-drawer-body">
        <section id="statusMetaSection" class="card appointment-drawer-section hidden">
            <div class="card-header appointment-drawer-section-header">
                <div class="card-header-left">
                    <div class="card-header-icon status-rescheduled">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <h3 class="card-title">
                        Status Details
                    </h3>
                </div>
            </div>

            <div class="card-body appointment-drawer-section-body">
                <p id="rescheduledToMetaRow" class="hidden">
                    <strong>Rescheduled To:</strong>
                    <span id="detailRescheduledTo">
                        Not available
                    </span>
                </p>
            </div>
        </section>

        <section class="card appointment-drawer-section">
            <div class="card-header appointment-drawer-section-header">
                <div class="card-header-left">
                    <div class="card-header-icon status-upcoming">
                        <i class="fa-regular fa-calendar"></i>
                    </div>

                    <h3 class="card-title">
                        Appointment Information
                    </h3>
                </div>
            </div>

            <div class="card-body appointment-drawer-section-body">
                <p><span class="font-semibold text-gray-600">Appointment Date:</span> <span
                        id="detailAppointmentDate">N/A</span></p>
                <p><span class="font-semibold text-gray-600">Appointment Time:</span> <span
                        id="detailAppointmentTime">N/A</span></p>
                <p><span class="font-semibold text-gray-600">Service Type:</span> <span
                        id="detailServiceType">N/A</span></p>
                <p><span class="font-semibold text-gray-600">Status:</span> <span id="detailStatusText">N/A</span></p>
            </div>
        </section>

        <section class="card appointment-drawer-section">
            <div class="card-header appointment-drawer-section-header">
                <div class="card-header-left">
                    <div class="card-header-icon status-upcoming">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>

                    <h3 class="card-title">
                        Clinical Notes
                    </h3>
                </div>
            </div>

            <div class="card-body appointment-drawer-section-body">
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">Treatment</p>
                        <p id="detailTreatment" class="text-gray-800">No treatment record yet.</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">Oral Examination</p>
                        <p id="detailOralExam" class="text-gray-800">No oral examination record yet.</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">Diagnosis</p>
                        <p id="detailDiagnosis" class="text-gray-800">No diagnosis record yet.</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">Prescription</p>
                        <p id="detailPrescription" class="text-gray-800">No prescription recorded.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="card appointment-drawer-section">
            <div class="card-header appointment-drawer-section-header">
                <div class="card-header-left">
                    <div class="card-header-icon status-upcoming">
                        <i class="fa-solid fa-calendar-plus"></i>
                    </div>

                    <h3 class="card-title">
                        Follow-up Appointment
                    </h3>
                </div>
            </div>

            <div class="card-body appointment-drawer-section-body">
                <p id="detailFollowUp" class="text-sm text-gray-800">No follow-up appointment scheduled.</p>
            </div>
        </section>

        <section class="card appointment-drawer-section">
            <div class="card-header appointment-drawer-section-header">
                <div class="card-header-left">
                    <div class="card-header-icon status-upcoming">
                        <i class="fa-solid fa-tooth"></i>
                    </div>

                    <h3 class="card-title">
                        Odontogram
                    </h3>
                </div>
            </div>

            <div id="detailOdontogram" class="card-body appointment-drawer-section-body">
                <p class="text-sm text-gray-800">No odontogram record yet.</p>
            </div>
        </section>
    </div>
</aside>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
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

    function confirmStart() {
        window.location.href = "{{ route('dentist.odontogram.start', ['patient' => $patient->id]) }}";
    }

    function formatRecordText(value, fallback) {
        const normalized = String(value ?? '').trim();
        return normalized.length ? normalized : fallback;
    }

    function formatTreatmentLabel(value) {
        const normalized = String(value ?? '').trim().toLowerCase();

        if (!normalized) {
            return 'No treatment record yet.';
        }

        if (normalized === 'finished') {
            return 'Finished procedure';
        }

        if (normalized === 'follow_up') {
            return 'Follow-up required';
        }

        return String(value)
            .replace(/_/g, ' ')
            .replace(/\b\w/g, letter => letter.toUpperCase());
    }

    function buildRecordOdontogramSummary(odontogramData) {
        if (!Array.isArray(odontogramData) || !odontogramData.length) {
            return 'No odontogram record yet.';
        }

        const markedTeeth = odontogramData
            .map(entry => Number(entry?.tooth || entry?.tooth_number || 0))
            .filter(Boolean);

        const uniqueMarkedTeeth = [...new Set(markedTeeth)];
        const preview = uniqueMarkedTeeth.slice(0, 8).join(', ');
        const suffix = uniqueMarkedTeeth.length > 8 ? ', ...' : '';

        return `
            <div class="space-y-2">
                <p class="font-semibold text-gray-800">${uniqueMarkedTeeth.length} marked tooth/teeth saved for this visit.</p>
                <p class="text-xs text-gray-500">FDI teeth: ${preview}${suffix}</p>
            </div>
        `;
    }

    function openDetailsDrawer(record) {
        const appointmentRecord = record || {};
        const date = appointmentRecord.date || 'N/A';
        const time = appointmentRecord.time || 'N/A';
        const service = appointmentRecord.service || 'Appointment';
        const status = appointmentRecord.status || 'Unknown';

        document.getElementById('drawerDate').innerText = date;
        document.getElementById('drawerTime').innerText = time;
        document.getElementById('drawerService').innerText = service;

        const statusEl =
            document.getElementById('drawerStatus');

        const statusLower =
            String(status || '').toLowerCase().trim();

        const statusMeta =
            window.getAppointmentStatusMeta
                ? window.getAppointmentStatusMeta(statusLower)
                : {
                    label: status || 'Status',
                    className: 'status-default',
                    icon: 'fa-circle'
                };

        statusEl.className =
            `status-badge ${statusMeta.className}`;

        statusEl.innerHTML = `
    <i class="fa-solid ${statusMeta.icon}"></i>
    <span>${statusMeta.label}</span>
`;

        document.getElementById('detailAppointmentDate').innerText = date;
        document.getElementById('detailAppointmentTime').innerText = time;
        document.getElementById('detailServiceType').innerText = service;
        document.getElementById('detailStatusText').innerText = status;

        document.getElementById('detailTreatment').innerText = formatTreatmentLabel(appointmentRecord.treatment);
        document.getElementById('detailOralExam').innerText = formatRecordText(appointmentRecord.oral_examination,
            'No oral examination record yet.');
        document.getElementById('detailDiagnosis').innerText = formatRecordText(appointmentRecord.diagnosis,
            'No diagnosis record yet.');
        document.getElementById('detailPrescription').innerText = formatRecordText(appointmentRecord.prescriptions,
            'No prescription recorded.');

        const followUp = appointmentRecord.follow_up;
        document.getElementById('detailFollowUp').innerText = followUp ?
            `${followUp.date} • ${followUp.time} • ${followUp.service}${followUp.reason ? ` • ${followUp.reason}` : ''}` :
            'No follow-up appointment scheduled.';

        document.getElementById('detailOdontogram').innerHTML = buildRecordOdontogramSummary(appointmentRecord
            .odontogram_data);

        const statusMetaSection = document.getElementById('statusMetaSection');
        const rescheduledToMetaRow = document.getElementById('rescheduledToMetaRow');

        statusMetaSection.classList.add('hidden');
        rescheduledToMetaRow.classList.add('hidden');
        document.getElementById('detailRescheduledTo').innerText = 'Not available';

        if (statusLower.includes('rescheduled')) {
            statusMetaSection.classList.remove('hidden');
            rescheduledToMetaRow.classList.remove('hidden');
            document.getElementById('detailRescheduledTo').innerText = date + ' • ' + time;
        }

        const overlay =
            document.getElementById('drawerOverlay');

        const drawer =
            document.getElementById('detailsDrawer');

        overlay?.classList.add('open');
        drawer?.classList.add('open');

        drawer?.setAttribute('aria-hidden', 'false');

        document.documentElement.classList.add(
            'drawer-lock'
        );

        document.body.classList.add(
            'drawer-lock'
        );

        requestAnimationFrame(() => {
            drawer
                ?.querySelector('.ui-icon-btn')
                ?.focus({
                    preventScroll: true
                });
        });
    }

    function closeDetailsDrawer() {
        const overlay =
            document.getElementById('drawerOverlay');

        const drawer =
            document.getElementById('detailsDrawer');

        overlay?.classList.remove('open');
        drawer?.classList.remove('open');

        drawer?.setAttribute('aria-hidden', 'true');

        document.documentElement.classList.remove(
            'drawer-lock'
        );

        document.body.classList.remove(
            'drawer-lock'
        );
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('startModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeStartModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeStartModal();
                closeProfileOdontogramModal();
                closeDetailsDrawer();
            }
        });

        @if (!empty($odontogramData))
            renderProfileOdontogram(@json($odontogramData));
        @endif
    });

    let profileOdontogramData = [];
    const profileOdontogramMetaDate = @json($odontogramMetaDate);
    const profileOdontogramMetaService = @json($odontogramMetaService);
    const profileLegendColors = {
        D: '#ef4444',
        M: '#111827',
        F: '#2563eb',
        I: '#ef4444',
        RF: '#ef4444',
        MO: '#111827',
        IM: '#111827',
        J: '#2563eb',
        A: '#2563eb',
        AB: '#2563eb',
        P: '#2563eb',
        IN: '#2563eb',
        LC: '#2563eb',
        RM: '#2563eb',
        X: '#2563eb',
        XO: '#2563eb',
        '✓': '#111827',
        CM: '#111827',
        SP: '#111827'
    };
    const profileSurfaceOrder = ['top', 'left', 'center', 'right', 'bottom'];
    const profileSurfaceLabels = {
        top: 'Top',
        left: 'Left',
        center: 'Center',
        right: 'Right',
        bottom: 'Bottom'
    };

    const profileOdontogramTeeth = {
        upperRight: [18, 17, 16, 15, 14, 13, 12, 11],
        upperLeft: [21, 22, 23, 24, 25, 26, 27, 28],
        lowerRight: [48, 47, 46, 45, 44, 43, 42, 41],
        lowerLeft: [31, 32, 33, 34, 35, 36, 37, 38],
    };

    function profileToothName(n) {
        const names = {
            18: 'Upper Right · 3rd Molar',
            17: 'Upper Right · 2nd Molar',
            16: 'Upper Right · 1st Molar',
            15: 'Upper Right · 2nd Premolar',
            14: 'Upper Right · 1st Premolar',
            13: 'Upper Right · Canine',
            12: 'Upper Right · Lateral Incisor',
            11: 'Upper Right · Central Incisor',
            21: 'Upper Left · Central Incisor',
            22: 'Upper Left · Lateral Incisor',
            23: 'Upper Left · Canine',
            24: 'Upper Left · 1st Premolar',
            25: 'Upper Left · 2nd Premolar',
            26: 'Upper Left · 1st Molar',
            27: 'Upper Left · 2nd Molar',
            28: 'Upper Left · 3rd Molar',
            48: 'Lower Right · 3rd Molar',
            47: 'Lower Right · 2nd Molar',
            46: 'Lower Right · 1st Molar',
            45: 'Lower Right · 2nd Premolar',
            44: 'Lower Right · 1st Premolar',
            43: 'Lower Right · Canine',
            42: 'Lower Right · Lateral Incisor',
            41: 'Lower Right · Central Incisor',
            31: 'Lower Left · Central Incisor',
            32: 'Lower Left · Lateral Incisor',
            33: 'Lower Left · Canine',
            34: 'Lower Left · 1st Premolar',
            35: 'Lower Left · 2nd Premolar',
            36: 'Lower Left · 1st Molar',
            37: 'Lower Left · 2nd Molar',
            38: 'Lower Left · 3rd Molar',
        };

        return names[n] || `Tooth #${n}`;
    }

    function profileConditionFromRecord(record) {
        if (!record) return 'healthy';

        const legends = [];

        if (record.status) legends.push(record.status);
        if (record.threeD) legends.push(record.threeD);
        if (record.surfaces && typeof record.surfaces === 'object') legends.push(...Object.values(record.surfaces)
            .filter(Boolean));
        if (Array.isArray(record.legends)) legends.push(...record.legends);

        const allCodes = legends
            .map(item => String(item?.code || item?.label || item?.description || '').toLowerCase())
            .join(' ');

        if (allCodes.includes('x') || allCodes.includes('extract')) return 'extracted';
        if (allCodes.includes('m') || allCodes.includes('missing')) return 'missing';
        if (allCodes.includes('f') || allCodes.includes('fill')) return 'filled';
        if (allCodes.includes('d') || allCodes.includes('decay') || allCodes.includes('caries')) return 'decay';
        if (allCodes.includes('jc') || allCodes.includes('crown')) return 'crown';

        return 'healthy';
    }

    function findProfileOdontogramRecord(tooth) {
        return profileOdontogramData.find(item => Number(item.tooth) === Number(tooth)) || null;
    }

    function normalizeProfileLegendRecord(record) {
        if (!record || !record.code) return null;

        const rawCode = String(record.code).trim();
        const normalizedCode = ['PT', '+'].includes(rawCode.toUpperCase()) ? '✓' : rawCode.toUpperCase();

        return {
            ...record,
            code: normalizedCode,
            label: record.label || normalizedCode,
            colorHex: profileLegendColors[normalizedCode] || record.colorHex || '#111827'
        };
    }

    function normalizeProfileOdontogramEntry(entry) {
        if (!entry) return null;

        const toothNumber = Number(entry.tooth || entry.tooth_number || 0);
        if (!toothNumber) return null;

        const surfaces = entry.surfaces && typeof entry.surfaces === 'object' && !Array.isArray(entry.surfaces) ?
            entry.surfaces :
            {};

        return {
            tooth: toothNumber,
            toothName: entry.toothName || entry.tooth_name || profileToothName(toothNumber),
            status: normalizeProfileLegendRecord(entry.status),
            threeD: normalizeProfileLegendRecord(entry.threeD || entry.three_d),
            surfaces: {
                top: normalizeProfileLegendRecord(surfaces.top),
                left: normalizeProfileLegendRecord(surfaces.left),
                center: normalizeProfileLegendRecord(surfaces.center),
                right: normalizeProfileLegendRecord(surfaces.right),
                bottom: normalizeProfileLegendRecord(surfaces.bottom)
            }
        };
    }

    function getProfileDisplayRecord(entry) {
        return entry?.status || entry?.threeD || null;
    }

    let profileScene = null;
    let profileCamera = null;
    let profileRenderer = null;
    let profileControls = null;
    let profileRaycaster = null;
    let profileMouse = null;
    let profileTeethMeshes = [];
    let profileHoveredMesh = null;
    let profileAnimationHandle = null;
    let profileThreeSceneInitialized = false;
    let profileSelectedTooth = null;

    function renderProfileOdontogram(rawData) {
        const canvasContainer = document.getElementById('profileOdontogramCanvas');
        if (!canvasContainer) return;

        try {
            const parsed = typeof rawData === 'string' ? JSON.parse(rawData || '[]') : (rawData || []);
            profileOdontogramData = (Array.isArray(parsed) ? parsed : Object.values(parsed || {}))
                .map(normalizeProfileOdontogramEntry)
                .filter(Boolean);
        } catch (e) {
            profileOdontogramData = [];
        }

        if (!profileThreeSceneInitialized) {
            initProfileThreeScene();
        } else {
            renderProfileThreeVisuals();
        }
    }

    function openProfileOdontogramModal(tooth) {
        const record = findProfileOdontogramRecord(tooth);
        const condition = profileConditionFromRecord(record);
        const displayRecord = getProfileDisplayRecord(record);
        const name = profileToothName(tooth);
        const parts = name.split('·').map(x => x.trim());

        document.getElementById('profileOdontogramModalTitle').textContent = `Tooth #${tooth}`;
        document.getElementById('profileOdontogramModalSubtitle').textContent = name;
        document.getElementById('profileOdontogramToothName').textContent = `#${tooth} — ${parts[1] || 'Tooth'}`;
        document.getElementById('profileOdontogramFdi').textContent = `#${tooth}`;
        document.getElementById('profileOdontogramQuadrant').textContent = parts[0] || '—';
        document.getElementById('profileOdontogramToothType').textContent = parts[1] || '—';
        document.getElementById('profileOdontogramArch').textContent = String(tooth).startsWith('1') || String(tooth)
            .startsWith('2') ?
            'Maxillary (Upper)' :
            'Mandibular (Lower)';

        document.getElementById('profileOdontogramCondition').textContent =
            displayRecord ? `${displayRecord.code} - ${displayRecord.label}` : (condition.charAt(0).toUpperCase() +
                condition.slice(1));
        document.getElementById('profileOdontogramCondition').style.background = displayRecord?.colorHex ?
            `${displayRecord.colorHex}22` : '#fee2e2';
        document.getElementById('profileOdontogramCondition').style.borderColor = displayRecord?.colorHex ||
            'rgba(139, 0, 0, 0.28)';
        document.getElementById('profileOdontogramCondition').style.color = displayRecord?.colorHex || '#7f1d1d';

        document.getElementById('profileOdontogramToothVisual').innerHTML = `
            <div class="profile-odontogram-big-tooth" style="background:${displayRecord?.colorHex || '#fecaca'}22;border-color:${displayRecord?.colorHex || '#9b1c1c'};color:${displayRecord?.colorHex || '#7f1d1d'};">
                ${condition === 'extracted' ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-tooth"></i>'}
            </div>
        `;

        const surfaceList = document.getElementById('profileOdontogramSurfaceList');
        const treatedSurfaces = profileSurfaceOrder
            .map(key => ({
                key,
                record: record?.surfaces?.[key] || null
            }))
            .filter(item => item.record);

        surfaceList.innerHTML = treatedSurfaces.length ?
            treatedSurfaces.map(item => `
                <span class="profile-odontogram-surface-pill">
                    <span class="profile-odontogram-surface-swatch" style="background:${item.record.colorHex};"></span>
                    ${profileSurfaceLabels[item.key]}: ${item.record.code}
                </span>
            `).join('') :
            '<span class="text-[11px] text-gray-400 italic">No surface markings recorded.</span>';

        const modal = document.getElementById('profileOdontogramModal');
        if (!modal) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.documentElement.classList.add('overflow-hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            modal.querySelector('.profile-odontogram-close')?.focus();
        });
    }

    function closeProfileOdontogramModal() {
        const modal = document.getElementById('profileOdontogramModal');
        if (!modal || modal.classList.contains('hidden')) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.documentElement.classList.remove('overflow-hidden');
        document.body.classList.remove('overflow-hidden');
        profileSelectedTooth = null;
        renderProfileThreeVisuals();
    }

    function initProfileThreeScene() {
        const container = document.getElementById('profileOdontogramCanvas');
        const loadingOverlay = document.getElementById('profileOdontogramLoading');
        if (!container || typeof THREE === 'undefined') return;

        const width = container.clientWidth || 700;
        const height = container.clientHeight || 440;
        const isDarkMode = document.documentElement.getAttribute('data-theme') === 'dark';

        profileScene = new THREE.Scene();
        profileScene.background = new THREE.Color(isDarkMode ? '#0d1117' : '#D8E0EA');

        profileCamera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
        profileCamera.position.set(0, 1.2, 14);

        profileRenderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: false
        });
        profileRenderer.setPixelRatio(window.devicePixelRatio);
        profileRenderer.setSize(width, height);
        profileRenderer.shadowMap.enabled = true;
        profileRenderer.shadowMap.type = THREE.PCFSoftShadowMap;
        container.innerHTML = '';
        container.appendChild(profileRenderer.domElement);

        profileControls = new THREE.OrbitControls(profileCamera, profileRenderer.domElement);
        profileControls.enableDamping = true;
        profileControls.dampingFactor = 0.07;
        profileControls.minDistance = 2.2;
        profileControls.maxDistance = 30;
        profileControls.maxPolarAngle = Math.PI / 1.8;
        profileControls.target.set(0, 0, 0);
        profileControls.update();

        profileScene.add(new THREE.AmbientLight(0xffffff, 0.75));

        const keyLight = new THREE.DirectionalLight(0xffffff, 0.8);
        keyLight.position.set(10, 15, 10);
        keyLight.castShadow = true;
        keyLight.shadow.mapSize.width = 1024;
        keyLight.shadow.mapSize.height = 1024;
        profileScene.add(keyLight);

        const backLight = new THREE.DirectionalLight(0xffffff, 0.45);
        backLight.position.set(-10, 5, -10);
        profileScene.add(backLight);

        const fillLight = new THREE.DirectionalLight(0xffffff, 0.35);
        fillLight.position.set(0, 8, 12);
        profileScene.add(fillLight);

        const enamelMaterialProps = {
            color: 0xFFFFF8,
            metalness: 0.02,
            roughness: 0.26,
            emissive: 0x090909,
            emissiveIntensity: 0.04,
            envMapIntensity: 0.95
        };

        const gumMaterialProps = {
            color: 0xF2A7A2,
            roughness: 0.68,
            metalness: 0.0,
            emissive: 0x220808,
            emissiveIntensity: 0.025
        };

        function createStandardMaterial(props) {
            return new THREE.MeshStandardMaterial(props);
        }

        function getToothType(toothNum) {
            const lastDigit = Number(String(toothNum).slice(-1));
            if (lastDigit === 1 || lastDigit === 2) return 'incisor';
            if (lastDigit === 3) return 'canine';
            if (lastDigit === 4 || lastDigit === 5) return 'premolar';
            return 'molar';
        }

        function getToothDimensions(type) {
            const sizes = {
                incisor: {
                    width: 0.34,
                    height: 0.50,
                    depth: 0.24,
                    hitWidth: 0.50,
                    hitHeight: 0.66,
                    hitDepth: 0.38
                },
                canine: {
                    width: 0.36,
                    height: 0.54,
                    depth: 0.26,
                    hitWidth: 0.52,
                    hitHeight: 0.70,
                    hitDepth: 0.40
                },
                premolar: {
                    width: 0.46,
                    height: 0.48,
                    depth: 0.34,
                    hitWidth: 0.62,
                    hitHeight: 0.64,
                    hitDepth: 0.48
                },
                molar: {
                    width: 0.62,
                    height: 0.47,
                    depth: 0.44,
                    hitWidth: 0.78,
                    hitHeight: 0.64,
                    hitDepth: 0.60
                }
            };
            return sizes[type] || sizes.incisor;
        }

        function addVisualPart(group, mesh, visualParts, colorableParts = null) {
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            group.add(mesh);
            visualParts.push(mesh);
            if (colorableParts) {
                mesh.userData.colorable = true;
                colorableParts.push(mesh);
            }
            return mesh;
        }

        function createSoftCusp(x, y, z, scale, material) {
            const cusp = new THREE.Mesh(
                new THREE.SphereGeometry(0.105 * scale, 18, 12),
                material.clone()
            );

            cusp.scale.set(1.05, 0.50, 0.85);
            cusp.position.set(x, y, z);

            return cusp;
        }

        function createStylizedTooth(toothNum, isUpper = true) {
            const type = getToothType(toothNum);
            const size = getToothDimensions(type);
            const toothGroup = new THREE.Group();
            const visualParts = [];
            const colorableParts = [];
            const enamelMaterial = createStandardMaterial(enamelMaterialProps);
            const crownDirection = isUpper ? -1 : 1;
            const gumDirection = isUpper ? 1 : -1;

            const crown = new THREE.Mesh(new THREE.SphereGeometry(1, 32, 22), enamelMaterial.clone());
            crown.scale.set(size.width, size.height, size.depth);
            crown.position.set(0, crownDirection * 0.22, 0);
            addVisualPart(toothGroup, crown, visualParts, colorableParts);

            const neck = new THREE.Mesh(
                new THREE.CylinderGeometry(size.width * 0.74, size.width * 0.86, 0.12, 26, 1),
                enamelMaterial.clone()
            );
            neck.position.set(0, gumDirection * 0.08, 0);
            addVisualPart(toothGroup, neck, visualParts, colorableParts);

            if (type === 'canine') {
                const point = new THREE.Mesh(
                    new THREE.ConeGeometry(size.width * 0.35, 0.16, 28, 1),
                    enamelMaterial.clone()
                );
                point.position.set(0, crownDirection * 0.70, 0);
                if (isUpper) point.rotation.x = Math.PI;
                addVisualPart(toothGroup, point, visualParts, colorableParts);
            }

            if (type === 'premolar') {
                const cuspY = crownDirection * 0.54;
                addVisualPart(toothGroup, createSoftCusp(-size.width * 0.20, cuspY, -size.depth * 0.15, 0.90,
                    enamelMaterial), visualParts, colorableParts);
                addVisualPart(toothGroup, createSoftCusp(size.width * 0.20, cuspY, size.depth * 0.15, 0.90,
                    enamelMaterial), visualParts, colorableParts);
            }

            if (type === 'molar') {
                const cuspY = crownDirection * 0.51;
                [
                    [-size.width * 0.23, cuspY, -size.depth * 0.20],
                    [size.width * 0.23, cuspY, -size.depth * 0.20],
                    [-size.width * 0.23, cuspY, size.depth * 0.20],
                    [size.width * 0.23, cuspY, size.depth * 0.20]
                ].forEach(pos => {
                    addVisualPart(toothGroup, createSoftCusp(pos[0], pos[1], pos[2], 1.0, enamelMaterial),
                        visualParts, colorableParts);
                });
            }

            const hitGeometry = new THREE.SphereGeometry(1, 16, 12);
            const hitMaterial = new THREE.MeshBasicMaterial({
                color: 0xffffff,
                transparent: true,
                opacity: 0.001,
                depthWrite: false
            });
            const hitMesh = new THREE.Mesh(hitGeometry, hitMaterial);
            hitMesh.scale.set(size.hitWidth, size.hitHeight, size.hitDepth);
            hitMesh.position.set(0, crownDirection * 0.25, 0);
            hitMesh.userData = {
                tooth: toothNum,
                originalColor: '#FFFFF8',
                visualGroup: toothGroup,
                visualParts,
                colorableParts
            };
            toothGroup.add(hitMesh);

            return {
                group: toothGroup,
                hitMesh
            };
        }

        function createArch(teethArray, yPosition, isUpper = true) {
            const group = new THREE.Group();
            const archStartAngle = Math.PI + 0.08;
            const archEndAngle = -0.08;
            const archWidthRadius = 3.18;
            const archDepthRadius = 2.85;

            teethArray.forEach((toothNum, i) => {
                const tooth = createStylizedTooth(toothNum, isUpper);
                const ratio = teethArray.length > 1 ? (i / (teethArray.length - 1)) : 0;
                const sideSign = ratio < 0.5 ? -1 : 1;
                let angle = archStartAngle - ratio * (archStartAngle - archEndAngle);
                const lastDigit = Number(String(toothNum).slice(-1));
                const molarAngleOffsetMap = {
                    6: 0.016,
                    7: 0.033,
                    8: 0.052
                };
                const molarYNudgeMap = {
                    6: 0.05,
                    7: 0.08,
                    8: 0.11
                };
                if (molarAngleOffsetMap[lastDigit]) angle += sideSign * molarAngleOffsetMap[lastDigit];
                const x = Math.cos(angle) * archWidthRadius;
                const z = Math.sin(angle) * archDepthRadius;
                const yNudge = molarYNudgeMap[lastDigit] ? (isUpper ? molarYNudgeMap[lastDigit] : -
                    molarYNudgeMap[lastDigit]) : 0;
                tooth.group.position.set(x, yPosition + yNudge, z);
                tooth.group.lookAt(0, yPosition + yNudge, -0.10);
                group.add(tooth.group);
                profileTeethMeshes.push(tooth.hitMesh);
            });

            profileScene.add(group);
        }

        function createGumArch(yPosition, isUpper = true) {
            const points = [];
            const gumStartAngle = Math.PI + 0.08;
            const gumEndAngle = -0.08;
            const gumWidthRadius = 3.58;
            const gumDepthRadius = 2.92;

            for (let i = 0; i <= 72; i++) {
                const t = i / 72;
                const angle = gumStartAngle - t * (gumStartAngle - gumEndAngle);
                const x = Math.cos(angle) * gumWidthRadius;
                const z = Math.sin(angle) * gumDepthRadius;
                points.push(new THREE.Vector3(x, yPosition, z));
            }

            const curve = new THREE.CatmullRomCurve3(points);
            const mainGeometry = new THREE.TubeGeometry(curve, 96, 0.39, 24, false);
            const mainGum = new THREE.Mesh(mainGeometry, createStandardMaterial(gumMaterialProps));
            mainGum.castShadow = true;
            mainGum.receiveShadow = true;
            profileScene.add(mainGum);
        }

        createGumArch(1.30, true);
        createGumArch(-1.30, false);
        createArch([...profileOdontogramTeeth.upperRight, ...profileOdontogramTeeth.upperLeft], 0.95, true);
        createArch([...profileOdontogramTeeth.lowerRight, ...profileOdontogramTeeth.lowerLeft], -0.95, false);

        profileRaycaster = new THREE.Raycaster();
        profileMouse = new THREE.Vector2();

        profileRenderer.domElement.addEventListener('pointermove', onProfileThreePointerMove);
        profileRenderer.domElement.addEventListener('pointerleave', onProfileThreePointerLeave);
        profileRenderer.domElement.addEventListener('pointerdown', onProfileThreePointerDown);

        function animate() {
            profileAnimationHandle = requestAnimationFrame(animate);
            profileControls.update();
            profileRenderer.render(profileScene, profileCamera);
        }

        animate();
        setTimeout(() => {
            if (loadingOverlay) {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 400);
            }
        }, 500);

        profileThreeSceneInitialized = true;
        renderProfileThreeVisuals();
    }

    function setProfileToothPartVisual(part, options = {}) {
        if (!part || !part.material) return;
        const material = part.material;
        const opacity = options.opacity ?? 1;
        material.transparent = opacity < 1;
        material.opacity = opacity;
        material.emissive.setHex(options.emissiveHex ?? 0x111111);
        material.emissiveIntensity = options.emissiveIntensity ?? 0.08;
        if (options.colorHex && part.userData.colorable) {
            material.color.setStyle(options.colorHex);
        }
        material.needsUpdate = true;
    }

    function renderProfileThreeVisuals() {
        if (!profileTeethMeshes.length) return;

        profileTeethMeshes.forEach(mesh => {
            const toothId = Number(mesh.userData.tooth);
            const state = findProfileOdontogramRecord(toothId);
            const visualRecord = state?.threeD || state?.status || null;
            const visualGroup = mesh.userData.visualGroup;
            const visualParts = mesh.userData.visualParts || [];
            const colorableParts = mesh.userData.colorableParts || [];

            if (visualGroup) {
                visualGroup.scale.set(profileSelectedTooth === toothId ? 1.13 : 1, profileSelectedTooth ===
                    toothId ? 1.13 : 1, profileSelectedTooth === toothId ? 1.13 : 1);
            }

            visualParts.forEach(part => {
                setProfileToothPartVisual(part, {
                    opacity: 1,
                    emissiveHex: profileSelectedTooth === toothId ? 0x8B0000 : 0x111111,
                    emissiveIntensity: profileSelectedTooth === toothId ? 0.20 : 0.08
                });
            });

            colorableParts.forEach(part => {
                setProfileToothPartVisual(part, {
                    colorHex: visualRecord?.colorHex || '#FFFFF8',
                    opacity: 1,
                    emissiveHex: profileSelectedTooth === toothId ? 0x8B0000 : 0x111111,
                    emissiveIntensity: profileSelectedTooth === toothId ? 0.28 : 0.10
                });
            });

            mesh.userData.originalColor = visualRecord?.colorHex || '#FFFFF8';
        });
    }

    function updateProfileMousePosition(event) {
        const rect = profileRenderer.domElement.getBoundingClientRect();
        profileMouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        profileMouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
    }

    function showProfileTooltip(event, mesh) {
        const tooltip = document.getElementById('profileOdontogramTooltip');
        const tooltipContent = document.getElementById('profileOdontogramTooltipContent');
        const container = document.getElementById('profileOdontogramCanvas');
        if (!tooltip || !tooltipContent || !container) return;

        const toothNumber = mesh.userData.tooth;
        const toothName = profileToothName(toothNumber);
        const state = findProfileOdontogramRecord(toothNumber);
        const treatment = state?.threeD || state?.status || null;

        tooltipContent.innerHTML = `
            <div class="text-xs font-extrabold tracking-wide text-red-200 mb-1">Tooth #${toothNumber}</div>
            <div class="text-sm font-bold leading-tight">${toothName}</div>
            <div class="mt-1 text-[11px] text-gray-300">Click to view saved markings and surfaces.</div>
            <div class="mt-2 text-xs ${treatment ? 'text-emerald-200' : 'text-gray-300'}">
                ${treatment ? `Current visual: ${treatment.code} - ${treatment.label}` : 'No treatment assigned'}
            </div>
        `;

        const rect = container.getBoundingClientRect();
        tooltip.style.left = `${event.clientX - rect.left}px`;
        tooltip.style.top = `${event.clientY - rect.top}px`;
        tooltip.classList.add('show');
    }

    function hideProfileTooltip() {
        document.getElementById('profileOdontogramTooltip')?.classList.remove('show');
    }

    function onProfileThreePointerMove(event) {
        updateProfileMousePosition(event);
        profileRaycaster.setFromCamera(profileMouse, profileCamera);
        const intersects = profileRaycaster.intersectObjects(profileTeethMeshes);
        if (intersects.length > 0) {
            profileHoveredMesh = intersects[0].object;
            showProfileTooltip(event, profileHoveredMesh);
        } else {
            profileHoveredMesh = null;
            hideProfileTooltip();
        }
    }

    function onProfileThreePointerLeave() {
        profileHoveredMesh = null;
        hideProfileTooltip();
    }

    function onProfileThreePointerDown(event) {
        event.preventDefault();
        updateProfileMousePosition(event);
        profileRaycaster.setFromCamera(profileMouse, profileCamera);
        const intersects = profileRaycaster.intersectObjects(profileTeethMeshes);
        if (intersects.length > 0) {
            const mesh = intersects[0].object;
            profileSelectedTooth = Number(mesh.userData.tooth);
            renderProfileThreeVisuals();
            openProfileOdontogramModal(profileSelectedTooth);
            showProfileTooltip(event, mesh);
        }
    }

    window.addEventListener('resize', function () {
        const container = document.getElementById('profileOdontogramCanvas');
        if (!profileRenderer || !profileCamera || !container) return;
        const newWidth = container.clientWidth || 700;
        const newHeight = container.clientHeight || 440;
        profileCamera.aspect = newWidth / newHeight;
        profileCamera.updateProjectionMatrix();
        profileRenderer.setSize(newWidth, newHeight);
    });
</script>
@endsection