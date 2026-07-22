@php
$profileMode = $profileMode ?? 'dentist';

$layoutRole = $profileMode === 'admin'
? 'admin'
: 'dentist';
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
$showManualSignatureReview = in_array($profileMode, ['admin', 'dentist'], true)
&& in_array($signatureReviewStatus, ['pending_manual_review', 'invalid_reupload_required'], true)
&& !empty($signaturePath);

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

$patientType = $patient->faculty_code ? 'Faculty' : ($patient->student_no ? 'Student' : 'Patient');

$procedureAppointment = $nextAppointment ?? collect($futureVisits ?? [])->first();
$odontogramData = optional($patient->odontogram)->odontogram_data ?? [];
$odontogramLastUpdatedAt = optional($patient->odontogram)->updated_at;
$odontogramMetaVisit = $lastVisit ?? $appointment ?? $nextAppointment ?? null;
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
                    <a href="{{ $backUrl }}"
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>

                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Patient Profile</h1>
                </div>
            </div>

            @if ($isDentistProfile)
            <div class="flex items-center gap-2">
                <a href="{{ route('dentist.odontogram.historical.create', ['patient' => $patient->id]) }}"
                    class="flex items-center gap-2 px-5 py-2.5 bg-white text-[#8B0000] border border-[#8B0000]/20 rounded-lg text-sm font-bold shadow-sm hover:bg-red-50 transition">
                    <i class="fa-solid fa-clock-rotate-left text-xs"></i> Add Existing Appointment
                </a>
                @if ($procedureAppointment)
                <button type="button" onclick="openStartModal()"
                    class="flex items-center gap-2 px-5 py-2.5 bg-[#8B0000] text-white rounded-lg text-sm font-bold shadow-md hover:bg-[#6b0000] transition">
                    <i class="fa-solid fa-play text-xs"></i> Start Procedure
                </button>
                @endif
            </div>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <div class="w-full lg:w-[400px] xl:w-[450px] 2xl:w-[480px] flex-shrink-0 lg:sticky lg:top-[80px]">
                <div id="profileContainer">
                    <div class="glass-card overflow-hidden fade-up">
                        <div class="h-24 bg-gradient-to-r from-[#8B0000] to-[#b30000] relative"></div>

                        <div class="px-5 pb-5 relative flex flex-col items-center mt-[-40px]">
                            <div class="relative mb-3">
                                <img src="{{ $avatarUrl }}" alt="Profile"
                                    class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md bg-white">
                            </div>

                            <h2 class="text-[19px] font-extrabold text-gray-900 text-center leading-tight">
                                {{ $displayName }}
                            </h2>

                            <p class="text-[13px] font-medium text-gray-500 mt-1 text-center">
                                {{ $patientType }}
                            </p>

                            @if ($patient->faculty_code)
                            <div
                                class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold tracking-wide">
                                <i class="fa-regular fa-id-badge text-[10px]"></i>
                                Faculty Code: {{ $patient->faculty_code }}
                            </div>
                            @elseif($patient->student_no)
                            <div
                                class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold tracking-wide">
                                <i class="fa-regular fa-id-badge text-[10px]"></i>
                                Student No: {{ $patient->student_no }}
                            </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="px-5 py-4 space-y-3 text-sm">
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-gray-400 font-semibold text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-cake-candles w-3"></i>
                                    Age <br> Date of Birth
                                </span>

                                <span class="text-gray-800 font-medium text-right">
                                    {{ $age ? $age . ' yrs' : 'N/A' }}
                                    <span class="text-gray-400 text-xs font-normal block">
                                        {{ $birthdateFormatted }}
                                    </span>
                                </span>
                            </div>

                            <div class="flex justify-between items-center gap-4">
                                <span class="text-gray-400 font-semibold text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-venus-mars w-3"></i>
                                    Gender
                                </span>

                                <span class="text-gray-800 font-medium text-right">
                                    {{ $patient->gender ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-start gap-4">
                                <span class="text-gray-400 font-semibold text-xs flex items-center gap-2 mt-0.5">
                                    <i class="fa-solid fa-phone w-3"></i>
                                    Contact
                                </span>

                                <span class="text-gray-800 font-medium text-right">
                                    {{ $patient->phone ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-start gap-3">
                                <span
                                    class="text-gray-400 font-semibold text-xs flex items-center gap-2 mt-0.5 flex-shrink-0 w-[92px]">
                                    <i class="fa-solid fa-envelope w-3"></i>
                                    Email
                                </span>

                                <span
                                    class="text-gray-800 font-medium text-right break-words leading-snug flex-1 min-w-0">
                                    {{ $patient->email ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-red-50/50 px-5 py-4 border-t border-red-100">
                            <p
                                class="text-[10px] font-bold text-red-800 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-heart-pulse"></i>
                                Emergency Contact
                            </p>

                            @if (optional($patient->medicalHistory)->emergency_person)
                            <p class="text-sm font-bold text-gray-900">
                                {{ optional($patient->medicalHistory)->emergency_person }}
                            </p>

                            <p class="text-xs font-medium text-gray-600 mt-0.5">
                                <i class="fa-solid fa-phone text-[10px] mr-1"></i>
                                {{ optional($patient->medicalHistory)->emergency_number ?? 'N/A' }}

                                @if (optional($patient->medicalHistory)->emergency_relation)
                                <span class="ml-1 text-gray-400">
                                    ({{ optional($patient->medicalHistory)->emergency_relation }})
                                </span>
                                @endif
                            </p>
                            @else
                            <div class="text-center py-2">
                                <i class="fa-solid fa-user-plus text-red-300 text-lg mb-1"></i>
                                <p class="text-xs text-gray-400 font-medium mb-2">
                                    No emergency contact added
                                </p>
                            </div>
                            @endif
                        </div>

                        @if ($showManualSignatureReview)
                        <div class="{{ $isInvalidSignature ? 'bg-red-50/70 border-red-100' : 'bg-amber-50/70 border-amber-100' }} px-5 py-4 border-t">
                            <p
                                class="text-[10px] font-bold {{ $isInvalidSignature ? 'text-red-800' : 'text-amber-800' }} uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-file-signature"></i>
                                {{ $isInvalidSignature ? 'Signature Re-upload Requested' : 'Signature Review Required' }}
                            </p>

                            <div class="rounded-xl border {{ $isInvalidSignature ? 'border-red-200' : 'border-amber-200' }} bg-white p-3 shadow-sm">
                                <a href="{{ $signatureUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="block overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                                    <img src="{{ $signatureUrl }}" alt="Patient signature for manual review"
                                        class="w-full h-auto object-contain max-h-56">
                                </a>

                                <div class="mt-3 space-y-2">
                                    <div
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $isInvalidSignature ? 'bg-red-100 text-red-800 border-red-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                                        <i class="fa-solid {{ $isInvalidSignature ? 'fa-circle-xmark' : 'fa-triangle-exclamation' }} text-[10px]"></i>
                                        {{ $isInvalidSignature ? 'Invalid Signature' : 'Pending Manual Review' }}
                                    </div>

                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        {{ $signatureReviewNotes ?: 'The AI signature checker was unavailable during submission, so this uploaded signature needs manual review.' }}
                                    </p>

                                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                                        <a href="{{ $signatureUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 text-xs font-bold text-[#8B0000] hover:text-[#6b0000] transition">
                                            <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                                            Open Full Signature
                                        </a>

                                        @if ($isPendingManualReview)
                                        <form method="POST"
                                            action="{{ $profileMode === 'admin' ? route('admin.patient.signature.invalid', $patient) : route('dentist.patient.signature.invalid', $patient) }}"
                                            onsubmit="return confirm('Mark this uploaded signature as invalid and notify the patient to upload a new one?');"
                                            class="ml-auto">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-full bg-[#8B0000] px-2.5 py-1 text-[7px] font-extrabold leading-none text-white shadow-sm transition hover:bg-[#6b0000]"
                                                style="font-family: inherit;">
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
                    </div>
                </div>
            </div>

            <div class="flex-1 min-w-0 flex flex-col gap-6 max-w-[1100px]">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="glass-card p-4 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fa-regular fa-calendar-check text-xl"></i>
                        </div>

                        <div>
                            <p class="text-2xl font-extrabold text-gray-900 leading-none">
                                {{ $totalVisits ?? $pastCount + $futureCount }}
                            </p>
                            <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mt-1">
                                Total Visits
                            </p>
                        </div>
                    </div>

                    <div class="glass-card p-4 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 flex-shrink-0">
                            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-gray-900 truncate max-w-[120px]">
                                {{ $lastVisit?->appointment_date
                                ? Carbon::parse($lastVisit->appointment_date)->format('M d, Y')
                                : 'No past visits' }}
                            </p>
                            <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mt-1">
                                Last Visit
                            </p>
                        </div>
                    </div>

                    <div class="glass-card p-4 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                            <i class="fa-regular fa-calendar-plus text-xl"></i>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-gray-900 truncate max-w-[120px]">
                                {{ $nextAppointment?->appointment_date
                                ? Carbon::parse($nextAppointment->appointment_date)->format('M d, Y')
                                : 'No schedule' }}
                            </p>
                            <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mt-1">
                                Next Appointment
                            </p>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-folder-open text-[#8B0000]"></i>
                            Treatment History
                        </h2>
                    </div>

                    <div class="flex gap-2 mb-6 bg-gray-100 p-1 rounded-lg w-fit">
                        <button id="futureTab" onclick="showFuture()"
                            class="visit-tab px-4 py-1.5 text-sm font-bold text-[#8B0000] bg-white shadow-sm rounded-md transition-all">
                            Upcoming ({{ $futureCount }})
                        </button>

                        <button id="pastTab" onclick="showPast()"
                            class="visit-tab px-4 py-1.5 text-sm font-semibold text-gray-500 hover:text-gray-700 rounded-md transition-all">
                            Past Visits ({{ $pastCount }})
                        </button>
                    </div>

                    <div id="futureContent" class="space-y-3">
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
                            'follow_up' => $visitFollowUp ? [
                                'date' => $visitFollowUp->appointment_date ? Carbon::parse($visitFollowUp->appointment_date)->format('d M Y') : 'N/A',
                                'time' => $visitFollowUp->appointment_time ? Carbon::parse($visitFollowUp->appointment_time)->format('g:i A') : 'N/A',
                                'service' => $visitFollowUp->service_type ?? 'Follow-up',
                                'status' => $visitFollowUp->status ?? 'upcoming',
                                'reason' => $visitFollowUp->follow_up_reason,
                            ] : null,
                        ];
                        @endphp

                        <div
                            class="group border border-gray-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4 hover:border-[#8B0000]/30 hover:shadow-md transition-all bg-white relative overflow-hidden">
                            <div class="status-accent accent-gray js-status-accent"
                                data-status="{{ strtolower($visitStatus) }}"></div>

                            <div class="flex-shrink-0 w-[140px] pl-2">
                                <p class="font-extrabold text-gray-900 text-sm">{{ $visitDate }}</p>
                                <p class="text-[12px] font-medium text-gray-500 mt-0.5">
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ $visitTime }}
                                </p>
                            </div>

                            <div class="flex-1">
                                <span class="status-badge js-status-badge" data-status="{{ strtolower($visitStatus) }}">
                                    {{ $visitStatus }}
                                </span>

                                <p class="text-sm font-bold text-gray-800">{{ $visitService }}</p>
                                <p class="text-[11px] font-semibold text-gray-400 mt-0.5">
                                    Dentist:
                                    <span class="text-gray-600">
                                        {{ $visit->dentist->name ?? 'Dr. Angeles' }}
                                    </span>
                                </p>
                            </div>

                            <div class="flex-shrink-0">
                                <button
                                    data-record='@json($visitRecord, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                    onclick="openDetailsDrawer(JSON.parse(this.dataset.record))"
                                    class="w-full md:w-auto px-4 py-2 bg-gray-50 hover:bg-[#8B0000] text-gray-600 hover:text-white border border-gray-200 hover:border-[#8B0000] rounded-lg text-xs font-bold transition-colors">
                                    View Details
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="py-8 text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                            <p class="text-gray-600 font-bold text-sm">No upcoming appointments</p>
                        </div>
                        @endforelse
                    </div>

                    <div id="pastContent" class="hidden space-y-3">
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
                            'follow_up' => $visitFollowUp ? [
                                'date' => $visitFollowUp->appointment_date ? Carbon::parse($visitFollowUp->appointment_date)->format('d M Y') : 'N/A',
                                'time' => $visitFollowUp->appointment_time ? Carbon::parse($visitFollowUp->appointment_time)->format('g:i A') : 'N/A',
                                'service' => $visitFollowUp->service_type ?? 'Follow-up',
                                'status' => $visitFollowUp->status ?? 'upcoming',
                                'reason' => $visitFollowUp->follow_up_reason,
                            ] : null,
                        ];
                        @endphp

                        <div
                            class="group border border-gray-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4 hover:border-gray-300 hover:shadow-sm transition-all bg-white relative overflow-hidden">
                            <div class="status-accent accent-gray js-status-accent"
                                data-status="{{ strtolower($visitStatus) }}"></div>

                            <div class="flex-shrink-0 w-[140px] pl-2">
                                <p class="font-extrabold text-gray-600 text-sm">{{ $visitDate }}</p>
                                <p class="text-[12px] font-medium text-gray-400 mt-0.5">
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ $visitTime }}
                                </p>
                            </div>

                            <div class="flex-1">
                                <span class="status-badge js-status-badge" data-status="{{ strtolower($visitStatus) }}">
                                    {{ $visitStatus }}
                                </span>

                                <p class="text-sm font-bold text-gray-700">{{ $visitService }}</p>
                            </div>

                            <div class="flex-shrink-0">
                                <button
                                    data-record='@json($visitRecord, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                    onclick="openDetailsDrawer(JSON.parse(this.dataset.record))"
                                    class="w-full md:w-auto px-4 py-2 bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 rounded-lg text-xs font-bold transition-colors">
                                    View Record
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="py-8 text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                            <p class="text-gray-600 font-bold text-sm">No past records</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="glass-card p-6 mb-10">
                    <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-4">
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-notes-medical text-[#8B0000]"></i>
                            Health & Lifestyle Information
                        </h2>

                        <span class="text-[10px] text-gray-400 font-medium bg-gray-100 px-2 py-1 rounded">
                            Latest Record
                        </span>
                    </div>

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
                                        {{ str_replace('_', ' ', Str::title(optional($dentAnswer->condition)->code ??
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
                                {{ $odontogramLastUpdatedAt ? 'Updated ' . $odontogramLastUpdatedAt->format('M d, Y h:i A') : 'Saved chart' }}
                            </span>
                            @endif
                        </div>

                        @if (!empty($odontogramData))
                        <div class="profile-odontogram-wrap">
                            <div class="profile-odontogram-head">
                                <div>
                                    <p class="profile-odontogram-label">Odontogram</p>
                                    <p class="profile-odontogram-sub">Patient's saved chart with dentist markings</p>
                                </div>

                                <div class="profile-odontogram-legend">
                                    <span class="profile-odontogram-legend-item">
                                        <span class="profile-odontogram-legend-dot" style="background:#ef4444;"></span> Decay / Procedure
                                    </span>
                                    <span class="profile-odontogram-legend-item">
                                        <span class="profile-odontogram-legend-dot" style="background:#2563eb;"></span> Restoration
                                    </span>
                                    <span class="profile-odontogram-legend-item">
                                        <span class="profile-odontogram-legend-dot" style="background:#111827;"></span> Missing / Special
                                    </span>
                                </div>
                            </div>

                            <div class="profile-odontogram-board-wrap">
                                <div class="profile-odontogram-guide" aria-label="3D model mouse controls">
                                    <div class="profile-odontogram-guide-item">
                                        <span class="profile-odontogram-guide-key">L</span>
                                        <span>Select tooth</span>
                                    </div>
                                    <div class="profile-odontogram-guide-item">
                                        <span class="profile-odontogram-guide-key">R</span>
                                        <span>Move model</span>
                                    </div>
                                    <div class="profile-odontogram-guide-item">
                                        <span class="profile-odontogram-guide-key"><i class="fa-solid fa-arrows-up-down text-[9px]"></i></span>
                                        <span>Zoom</span>
                                    </div>
                                </div>

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

                        <div id="profileOdontogramModal" class="profile-odontogram-modal hidden">
                            <div class="profile-odontogram-backdrop" onclick="closeProfileOdontogramModal()"></div>

                            <div class="profile-odontogram-card">
                                <div class="profile-odontogram-card-hero">
                                    <button type="button" onclick="closeProfileOdontogramModal()" class="profile-odontogram-close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                    <h3 id="profileOdontogramModalTitle">Tooth #18</h3>
                                    <p id="profileOdontogramModalSubtitle">Upper Right · 3rd Molar</p>
                                </div>

                                <div class="profile-odontogram-card-body">
                                    <div class="profile-odontogram-tooth-main">
                                        <div id="profileOdontogramToothVisual" class="profile-odontogram-tooth-visual"></div>

                                        <div>
                                            <p class="profile-odontogram-info-label">Overall Marking</p>
                                            <div id="profileOdontogramCondition" class="profile-odontogram-condition-pill">Healthy</div>
                                        </div>
                                    </div>

                                    <p id="profileOdontogramToothName" class="profile-odontogram-tooth-name">#18 — 3rd Molar</p>

                                    <div class="profile-odontogram-info-grid">
                                        <div class="profile-odontogram-info-box"><p>FDI Number</p><strong id="profileOdontogramFdi">#18</strong></div>
                                        <div class="profile-odontogram-info-box"><p>Quadrant</p><strong id="profileOdontogramQuadrant">Upper Right</strong></div>
                                        <div class="profile-odontogram-info-box"><p>Tooth Type</p><strong id="profileOdontogramToothType">3rd Molar</strong></div>
                                        <div class="profile-odontogram-info-box"><p>Arch</p><strong id="profileOdontogramArch">Maxillary (Upper)</strong></div>
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
                        @else
                        <div class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                            <p class="text-gray-600 font-bold text-sm">No odontogram saved yet</p>
                            <p class="text-xs text-gray-400 mt-1">This patient does not have a recorded odontogram procedure yet.</p>
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
                </div>
            </div>
        </div>
    </div>
</main>

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
            <button type="button" onclick="closeStartModal()"
                class="flex-1 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 font-bold px-4 py-2.5 rounded-xl transition text-sm">
                Cancel
            </button>

            <button type="button" onclick="confirmStart()"
                class="flex-1 bg-[#8B0000] hover:bg-[#6b0000] text-white shadow-md shadow-red-900/20 font-bold px-4 py-2.5 rounded-xl transition text-sm">
                Yes, Start
            </button>
        </div>
    </div>
</div>
@endif

<div id="drawerOverlay" class="drawer-overlay fixed left-0 right-0 bottom-0 z-[110]" style="top: var(--header-h);"
    onclick="closeDetailsDrawer()"></div>

<div id="detailsDrawer"
    class="side-drawer fixed right-0 bottom-0 w-full max-w-[500px] bg-white shadow-[-10px_0_40px_rgba(0,0,0,0.1)] z-[120] flex flex-col"
    style="top: var(--header-h); height: calc(100vh - var(--header-h));">
    <div
        class="bg-gradient-to-r from-[#8B0000] to-[#b30000] px-6 py-5 md:py-6 flex items-start justify-between text-white flex-shrink-0">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-white/70 mb-1">
                Appointment Details
            </p>
            <h2 id="drawerService" class="text-xl font-extrabold leading-tight">Service Type</h2>
            <div class="flex items-center gap-3 mt-2 text-sm font-medium text-white/90">
                <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> <span
                        id="drawerDate">Date</span></span>
                <span>|</span>
                <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock"></i> <span
                        id="drawerTime">Time</span></span>
            </div>
        </div>

        <button onclick="closeDetailsDrawer()"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition text-white">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="px-6 py-3 bg-gray-50 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Status</span>
        <span id="drawerStatus"
            class="inline-flex px-3 py-1 rounded-md text-[11px] font-extrabold bg-orange-100 text-orange-700 uppercase tracking-wide">
            STATUS
        </span>
    </div>

    <div id="drawerBody" class="flex-1 overflow-y-auto p-6 space-y-6 bg-[#F9FAFB]">
        <section id="statusMetaSection" class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hidden">
            <h3
                class="flex items-center gap-2 text-sm font-bold text-[#8B0000] uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                <i class="fa-solid fa-circle-info"></i> Status Details
            </h3>

            <div class="space-y-2 text-sm">
                <p id="rescheduledToMetaRow" class="hidden">
                    <span class="font-semibold text-gray-600">Rescheduled To:</span>
                    <span id="detailRescheduledTo">Not available</span>
                </p>
            </div>
        </section>

        <section class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h3
                class="flex items-center gap-2 text-sm font-bold text-[#8B0000] uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                <i class="fa-regular fa-calendar"></i> Appointment Information
            </h3>

            <div class="space-y-2 text-sm">
                <p><span class="font-semibold text-gray-600">Appointment Date:</span> <span
                        id="detailAppointmentDate">N/A</span></p>
                <p><span class="font-semibold text-gray-600">Appointment Time:</span> <span
                        id="detailAppointmentTime">N/A</span></p>
                <p><span class="font-semibold text-gray-600">Service Type:</span> <span
                        id="detailServiceType">N/A</span></p>
                <p><span class="font-semibold text-gray-600">Status:</span> <span id="detailStatusText">N/A</span></p>
            </div>
        </section>

        <section class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h3
                class="flex items-center gap-2 text-sm font-bold text-[#8B0000] uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                <i class="fa-solid fa-notes-medical"></i> Clinical Notes
            </h3>

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
        </section>

        <section class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h3
                class="flex items-center gap-2 text-sm font-bold text-[#8B0000] uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                <i class="fa-solid fa-calendar-plus"></i> Follow-up Appointment
            </h3>

            <p id="detailFollowUp" class="text-sm text-gray-800">No follow-up appointment scheduled.</p>
        </section>

        <section class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h3
                class="flex items-center gap-2 text-sm font-bold text-[#8B0000] uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                <i class="fa-solid fa-tooth"></i> Odontogram
            </h3>

            <div id="detailOdontogram" class="text-sm text-gray-800">No odontogram record yet.</div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script>
    const STATUS_THEME = {
        today: {
            badge: 'status-blue',
            accent: 'accent-blue'
        },
        scheduled_today: {
            badge: 'status-blue',
            accent: 'accent-blue'
        },
        upcoming: {
            badge: 'status-orange',
            accent: 'accent-orange'
        },
        rescheduled: {
            badge: 'status-yellow',
            accent: 'accent-yellow'
        },
        cancelled: {
            badge: 'status-red',
            accent: 'accent-red'
        },
        completed: {
            badge: 'status-green',
            accent: 'accent-green'
        },
        default: {
            badge: 'status-gray',
            accent: 'accent-gray'
        }
    };

    function getStatusTheme(status) {
        const s = (status || '').toLowerCase().trim();

        if (s === 'scheduled today' || s === 'today') return STATUS_THEME.today;
        if (s.includes('upcoming')) return STATUS_THEME.upcoming;
        if (s.includes('rescheduled')) return STATUS_THEME.rescheduled;
        if (s.includes('cancelled')) return STATUS_THEME.cancelled;
        if (s.includes('completed')) return STATUS_THEME.completed;

        return STATUS_THEME.default;
    }

    function applyStatusTheme(el, type, status) {
        const theme = getStatusTheme(status);

        if (type === 'badge') {
            el.classList.remove('status-blue', 'status-orange', 'status-yellow', 'status-red', 'status-green',
                'status-gray');
            el.classList.add(theme.badge);
        }

        if (type === 'accent') {
            el.classList.remove('accent-blue', 'accent-orange', 'accent-yellow', 'accent-red', 'accent-green',
                'accent-gray');
            el.classList.add(theme.accent);
        }
    }

    function initStatusThemes() {
        document.querySelectorAll('.js-status-badge').forEach(el => {
            applyStatusTheme(el, 'badge', el.dataset.status);
        });

        document.querySelectorAll('.js-status-accent').forEach(el => {
            applyStatusTheme(el, 'accent', el.dataset.status);
        });
    }

    function showFuture() {
        document.getElementById('futureContent').classList.remove('hidden');
        document.getElementById('pastContent').classList.add('hidden');

        document.getElementById('futureTab').className =
            'visit-tab px-4 py-1.5 text-sm font-bold text-[#8B0000] bg-white shadow-sm rounded-md transition-all';
        document.getElementById('pastTab').className =
            'visit-tab px-4 py-1.5 text-sm font-semibold text-gray-500 hover:text-gray-700 rounded-md transition-all';
    }

    function showPast() {
        document.getElementById('pastContent').classList.remove('hidden');
        document.getElementById('futureContent').classList.add('hidden');

        document.getElementById('pastTab').className =
            'visit-tab px-4 py-1.5 text-sm font-bold text-[#8B0000] bg-white shadow-sm rounded-md transition-all';
        document.getElementById('futureTab').className =
            'visit-tab px-4 py-1.5 text-sm font-semibold text-gray-500 hover:text-gray-700 rounded-md transition-all';
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

        const statusEl = document.getElementById('drawerStatus');
        const statusLower = (status || '').toLowerCase();

        statusEl.innerText = status;
        statusEl.className = 'inline-flex px-3 py-1 rounded-md text-[11px] font-extrabold uppercase tracking-wide';
        applyStatusTheme(statusEl, 'badge', status);

        document.getElementById('detailAppointmentDate').innerText = date;
        document.getElementById('detailAppointmentTime').innerText = time;
        document.getElementById('detailServiceType').innerText = service;
        document.getElementById('detailStatusText').innerText = status;

        document.getElementById('detailTreatment').innerText = formatTreatmentLabel(appointmentRecord.treatment);
        document.getElementById('detailOralExam').innerText = formatRecordText(appointmentRecord.oral_examination, 'No oral examination record yet.');
        document.getElementById('detailDiagnosis').innerText = formatRecordText(appointmentRecord.diagnosis, 'No diagnosis record yet.');
        document.getElementById('detailPrescription').innerText = formatRecordText(appointmentRecord.prescriptions, 'No prescription recorded.');

        const followUp = appointmentRecord.follow_up;
        document.getElementById('detailFollowUp').innerText = followUp
            ? `${followUp.date} • ${followUp.time} • ${followUp.service}${followUp.reason ? ` • ${followUp.reason}` : ''}`
            : 'No follow-up appointment scheduled.';

        document.getElementById('detailOdontogram').innerHTML = buildRecordOdontogramSummary(appointmentRecord.odontogram_data);

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

        document.getElementById('drawerOverlay').classList.add('open');
        document.getElementById('detailsDrawer').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailsDrawer() {
        document.getElementById('drawerOverlay').classList.remove('open');
        document.getElementById('detailsDrawer').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        initStatusThemes();

        document.getElementById('startModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeStartModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeStartModal();
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
        if (record.surfaces && typeof record.surfaces === 'object') legends.push(...Object.values(record.surfaces).filter(Boolean));
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

        const surfaces = entry.surfaces && typeof entry.surfaces === 'object' && !Array.isArray(entry.surfaces)
            ? entry.surfaces
            : {};

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
        document.getElementById('profileOdontogramArch').textContent = String(tooth).startsWith('1') || String(tooth).startsWith('2')
            ? 'Maxillary (Upper)'
            : 'Mandibular (Lower)';

        document.getElementById('profileOdontogramCondition').textContent =
            displayRecord ? `${displayRecord.code} - ${displayRecord.label}` : (condition.charAt(0).toUpperCase() + condition.slice(1));
        document.getElementById('profileOdontogramCondition').style.background = displayRecord?.colorHex ? `${displayRecord.colorHex}22` : '#fee2e2';
        document.getElementById('profileOdontogramCondition').style.borderColor = displayRecord?.colorHex || 'rgba(139, 0, 0, 0.28)';
        document.getElementById('profileOdontogramCondition').style.color = displayRecord?.colorHex || '#7f1d1d';

        document.getElementById('profileOdontogramToothVisual').innerHTML = `
            <div class="profile-odontogram-big-tooth" style="background:${displayRecord?.colorHex || '#fecaca'}22;border-color:${displayRecord?.colorHex || '#9b1c1c'};color:${displayRecord?.colorHex || '#7f1d1d'};">
                ${condition === 'extracted' ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-tooth"></i>'}
            </div>
        `;

        const surfaceList = document.getElementById('profileOdontogramSurfaceList');
        const treatedSurfaces = profileSurfaceOrder
            .map(key => ({ key, record: record?.surfaces?.[key] || null }))
            .filter(item => item.record);

        surfaceList.innerHTML = treatedSurfaces.length
            ? treatedSurfaces.map(item => `
                <span class="profile-odontogram-surface-pill">
                    <span class="profile-odontogram-surface-swatch" style="background:${item.record.colorHex};"></span>
                    ${profileSurfaceLabels[item.key]}: ${item.record.code}
                </span>
            `).join('')
            : '<span class="text-xs text-gray-500">No individual surface markings saved for this tooth.</span>';

        document.getElementById('profileOdontogramModal').classList.remove('hidden');
    }

    function closeProfileOdontogramModal() {
        document.getElementById('profileOdontogramModal')?.classList.add('hidden');
    }

    function initProfileThreeScene() {
        const container = document.getElementById('profileOdontogramCanvas');
        const loadingOverlay = document.getElementById('profileOdontogramLoading');
        if (!container || typeof THREE === 'undefined') return;

        const width = container.clientWidth || 700;
        const height = container.clientHeight || 440;

        profileScene = new THREE.Scene();
        profileScene.background = new THREE.Color('#D8E0EA');

        profileCamera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
        profileCamera.position.set(0, 1.2, 14);

        profileRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
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
                incisor: { width: 0.34, height: 0.50, depth: 0.24, hitWidth: 0.50, hitHeight: 0.66, hitDepth: 0.38 },
                canine: { width: 0.36, height: 0.54, depth: 0.26, hitWidth: 0.52, hitHeight: 0.70, hitDepth: 0.40 },
                premolar: { width: 0.46, height: 0.48, depth: 0.34, hitWidth: 0.62, hitHeight: 0.64, hitDepth: 0.48 },
                molar: { width: 0.62, height: 0.47, depth: 0.44, hitWidth: 0.78, hitHeight: 0.64, hitDepth: 0.60 }
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
            const cusp = new THREE.Mesh(new THREE.SphereGeometry(0.105 * scale, 18, 12), material.clone());
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
                addVisualPart(toothGroup, createSoftCusp(-size.width * 0.20, cuspY, -size.depth * 0.15, 0.90, enamelMaterial), visualParts, colorableParts);
                addVisualPart(toothGroup, createSoftCusp(size.width * 0.20, cuspY, size.depth * 0.15, 0.90, enamelMaterial), visualParts, colorableParts);
            }

            if (type === 'molar') {
                const cuspY = crownDirection * 0.51;
                [
                    [-size.width * 0.23, cuspY, -size.depth * 0.20],
                    [size.width * 0.23, cuspY, -size.depth * 0.20],
                    [-size.width * 0.23, cuspY, size.depth * 0.20],
                    [size.width * 0.23, cuspY, size.depth * 0.20]
                ].forEach(pos => {
                    addVisualPart(toothGroup, createSoftCusp(pos[0], pos[1], pos[2], 1.0, enamelMaterial), visualParts, colorableParts);
                });
            }

            const hitGeometry = new THREE.SphereGeometry(1, 16, 12);
            const hitMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff, transparent: true, opacity: 0.001, depthWrite: false });
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

            return { group: toothGroup, hitMesh };
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
                const molarAngleOffsetMap = { 6: 0.016, 7: 0.033, 8: 0.052 };
                const molarYNudgeMap = { 6: 0.05, 7: 0.08, 8: 0.11 };
                if (molarAngleOffsetMap[lastDigit]) angle += sideSign * molarAngleOffsetMap[lastDigit];
                const x = Math.cos(angle) * archWidthRadius;
                const z = Math.sin(angle) * archDepthRadius;
                const yNudge = molarYNudgeMap[lastDigit] ? (isUpper ? molarYNudgeMap[lastDigit] : -molarYNudgeMap[lastDigit]) : 0;
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
                visualGroup.scale.set(profileSelectedTooth === toothId ? 1.13 : 1, profileSelectedTooth === toothId ? 1.13 : 1, profileSelectedTooth === toothId ? 1.13 : 1);
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
