@extends('layouts.app')

@section('layout-role', $layoutRole ?? 'admin')

@section('title', $pageTitle ?? 'Appointments')

@section('usesAppointmentCalendar', true)

@section('content')

@php
use Carbon\Carbon;
use Illuminate\Support\Str;

$layoutRole = $layoutRole ?? 'admin';
$pageTitle = $pageTitle ?? 'Appointments';

$isDentistView = $isDentistView ?? false;
$isAdminView = !$isDentistView;

$pageShellClass = $pageShellClass ?? ($isDentistView ? 'dentist-page-shell' : 'admin-page-shell');

$patientProfileRouteName =
$patientProfileRouteName ??
($isDentistView ? 'dentist.dentist.patient.profile' : 'admin.admin.patient.profile');

$canStartProcedure = $canStartProcedure ?? false;
$canRescheduleAppointment = $canRescheduleAppointment ?? false;
$canCancelAppointment = $canCancelAppointment ?? false;
$canViewTreatmentRecord = $canViewTreatmentRecord ?? false;
$canScheduleFollowUp = $canScheduleFollowUp ?? false;

$upcomingAppointments = collect($upcomingAppointments ?? []);
$pastAppointments = collect($pastAppointments ?? []);
$today = $today ?? Carbon::today()->toDateString();
$todayAppts = $upcomingAppointments->filter(fn($a) => ($a->appointment_date ?? null) === $today);
$todayCount = $todayAppts->count();
$firstTodayAppt = $todayAppts
->sortBy(fn($a) => ($a->appointment_date ?? '') . ' ' . ($a->appointment_time ?? '23:59:59'))
->first();

$firstTodayName = $firstTodayAppt ? optional($firstTodayAppt->patient)->name ?? 'Unknown Patient' : null;

$firstTodayTime =
$firstTodayAppt && $firstTodayAppt->appointment_time
? \Carbon\Carbon::parse($firstTodayAppt->appointment_time)->format('g:i A')
: null;

$firstTodayService = $firstTodayAppt
? (($firstTodayAppt->service_type ?? '') === 'Others'
? ($firstTodayAppt->other_services ?:
'Others')
: $firstTodayAppt->service_type ?? 'Appointment')
: null;

$nextAppt = $upcomingAppointments
->sortBy(fn($a) => ($a->appointment_date ?? '') . ' ' . ($a->appointment_time ?? '23:59:59'))
->first();

$nextName = $nextAppt ? optional($nextAppt->patient)->name ?? 'Unknown Patient' : null;

$nextTime =
$nextAppt && $nextAppt->appointment_time
? \Carbon\Carbon::parse($nextAppt->appointment_time)->format('g:i A')
: null;

$nextDate = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M j, Y') : null;

$nextService = $nextAppt
? (($nextAppt->service_type ?? '') === 'Others'
? ($nextAppt->other_services ?:
'Others')
: $nextAppt->service_type ?? 'Appointment')
: null;

$nextIsToday = $nextAppt && ($nextAppt->appointment_date ?? null) === $today;
$upcomingGrouped = $upcomingAppointments->groupBy(
fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'),
);
$pastGrouped = $pastAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
$upcomingTotal = $upcomingAppointments->count();
$pastTotal = $pastAppointments->count();
$allAppointments = $upcomingAppointments->merge($pastAppointments);
$appointmentRefreshItems = $allAppointments
->map(fn($appointment) => [
'id' => $appointment->id,
'updated_at' => optional($appointment->updated_at)->toISOString(),
])
->values();
$normalizeAppointmentStatus = function ($status) {
$normalized = strtolower(trim((string) ($status ?? '')));

return match ($normalized) {
'pending', 'confirmed', 'upcoming' => 'upcoming',
'reschedule', 'rescheduled' => 'rescheduled',
'canceled', 'cancelled' => 'cancelled',
'completed' => 'completed',
default => $normalized ?: 'upcoming',
};
};

$statusCounts = [
'all' => $allAppointments->count(),
'upcoming' => $upcomingAppointments
->filter(fn($a) => $normalizeAppointmentStatus($a->status ?? 'upcoming') === 'upcoming')
->count(),
'rescheduled' => $upcomingAppointments
->filter(fn($a) => $normalizeAppointmentStatus($a->status ?? '') === 'rescheduled')
->count(),
'completed' => $pastAppointments
->filter(fn($a) => $normalizeAppointmentStatus($a->status ?? '') === 'completed')
->count(),
'cancelled' => $pastAppointments
->filter(fn($a) => $normalizeAppointmentStatus($a->status ?? '') === 'cancelled')
->count(),
];

$statusOptions = [
'all' => ['label' => 'All statuses', 'icon' => 'fa-layer-group', 'tone' => 'all'],
'upcoming' => ['label' => 'Upcoming', 'icon' => 'fa-calendar-check', 'tone' => 'upcoming'],
'rescheduled' => ['label' => 'Rescheduled', 'icon' => 'fa-rotate-right', 'tone' => 'rescheduled'],
'completed' => ['label' => 'Completed', 'icon' => 'fa-circle-check', 'tone' => 'completed'],
'cancelled' => ['label' => 'Cancelled', 'icon' => 'fa-circle-xmark', 'tone' => 'cancelled'],
];

$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<main id="mainContent" class="{{ $pageShellClass }}
           shared-appointments-page
           {{ $isDentistView ? 'dentist-appointments-view' : 'admin-appointments-view' }}
           page-enter
           mode-list">
    <div class="w-full">

        <div class="appointment-header-wrap">

            @if ($isDentistView)
            <div class="dentist-hero">
                <div class="dentist-hero-content">
                    <div class="dentist-hero-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>

                    <div class="min-w-0">
                        <div class="dentist-hero-eyebrow">
                            <i class="fa-solid fa-tooth"></i>
                            Appointment Management
                        </div>

                        <h2 class="dentist-hero-title">
                            Appointments
                        </h2>
                    </div>
                </div>
            </div>
            @else
            <div class="page-banner admin-appointment-banner">
                <div class="page-banner-inner">
                    <div class="appointment-banner-title-wrap">
                        <h1 class="page-title">
                            Appointment Management
                        </h1>
                    </div>
                </div>
            </div>
            @endif

            <div class="today-snapshot-card compact-snapshot-card">
                <div class="today-snapshot-header">
                    <div>
                        <span class="today-snapshot-kicker">Today’s Snapshot</span>
                    </div>
                </div>

                <div class="snapshot-focus-grid">
                    <div class="snapshot-focus-item {{ $firstTodayAppt ? 'has-appointment' : 'is-clear' }}">
                        <div class="snapshot-focus-icon">
                            <i class="fa-solid {{ $firstTodayAppt ? 'fa-calendar-check' : 'fa-mug-hot' }}"></i>
                        </div>

                        <div class="snapshot-focus-content">
                            <span class="snapshot-focus-label">Today</span>

                            @if ($firstTodayAppt)
                            <h4>{{ $todayCount }} appointment{{ $todayCount > 1 ? 's' : '' }} today</h4>
                            <p>
                                First visit: <strong>{{ $firstTodayName }}</strong>
                                @if ($firstTodayTime)
                                at <strong>{{ $firstTodayTime }}</strong>
                                @endif
                            </p>
                            <span class="snapshot-mini-chip">
                                <i class="fa-solid fa-tooth"></i>
                                {{ $firstTodayService }}
                            </span>
                            @else
                            <h4>No appointments today</h4>
                            @endif
                        </div>
                    </div>

                    <div class="snapshot-focus-item next-appointment">
                        <div class="snapshot-focus-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>

                        <div class="snapshot-focus-content">
                            <span class="snapshot-focus-label">Next Appointment</span>

                            @if ($nextAppt)
                            <h4>{{ $nextName }}</h4>
                            <p>
                                {{ $nextDate }}
                                @if ($nextTime)
                                at <strong>{{ $nextTime }}</strong>
                                @endif
                            </p>
                            <div class="snapshot-chip-row">
                                <span class="snapshot-mini-chip">
                                    <i class="fa-solid fa-tooth"></i>
                                    {{ $nextService }}
                                </span>

                                @if ($nextIsToday)
                                <span class="snapshot-mini-chip today-chip">
                                    Today
                                </span>
                                @endif
                            </div>
                            @else
                            <h4>No upcoming appointments</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="appointment-controls-bar">
                <div class="appointment-control-copy">
                    <span class="appointment-control-kicker">Manage view</span>
                </div>

                <div class="appointment-filter-wrap">
                    <div class="appointment-search-row voice-search-row">
                        <div class="search-wrap global-search" data-search-wrapper>
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>

                            <input id="apptSearchInput" type="text" placeholder="Search patient" class="search-input"
                                data-search-input autocomplete="off">

                            <button type="button" class="search-clear" data-search-clear aria-label="Clear search">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>

                        <div class="voice-input-toggle">
                            <button type="button" class="voice-search-mic external" data-voice-trigger
                                data-voice-target="#apptSearchInput" data-voice-status="#apptVoiceStatus"
                                aria-label="Voice search appointments">
                                <i class="fa-solid fa-microphone"></i>
                            </button>

                            <span id="apptVoiceStatus" class="voice-status hidden" data-voice-status
                                aria-live="polite"></span>
                        </div>
                    </div>

                    <input type="hidden" id="apptStatusFilter" value="all">

                    <div class="appointment-status-dropdown" id="apptStatusDropdown">
                        <button type="button" class="appointment-status-trigger" id="apptStatusToggle"
                            aria-expanded="false">
                            <span class="appointment-status-trigger-left">
                                <span class="appointment-status-trigger-icon tone-all" id="apptStatusIcon">
                                    <i class="fa-solid fa-layer-group"></i>
                                </span>

                                <span class="appointment-status-trigger-text">
                                    <span class="appointment-status-trigger-label">Status</span>
                                    <strong id="apptStatusSelectedLabel">All statuses</strong>
                                </span>
                            </span>

                            <span class="appointment-status-trigger-right">
                                <span class="appointment-status-count-badge" id="apptStatusSelectedCount">
                                    {{ $statusCounts['all'] ?? 0 }}
                                </span>
                                <i class="fa-solid fa-chevron-down appointment-status-chevron"></i>
                            </span>
                        </button>

                        <div class="appointment-status-panel" id="apptStatusPanel">
                            <div class="appointment-status-grid">
                                @foreach ($statusOptions as $value => $meta)
                                <button type="button"
                                    class="appointment-status-option {{ $value === 'all' ? 'is-active' : '' }} tone-{{ $meta['tone'] }}"
                                    data-status-value="{{ $value }}" data-status-label="{{ $meta['label'] }}"
                                    data-status-icon="{{ $meta['icon'] }}" data-status-tone="{{ $meta['tone'] }}"
                                    data-status-count="{{ $statusCounts[$value] ?? 0 }}">
                                    <span class="appointment-status-option-icon">
                                        <i class="fa-solid {{ $meta['icon'] }}"></i>
                                    </span>

                                    <span class="appointment-status-option-label">{{ $meta['label'] }}</span>
                                    <span class="appointment-status-option-count">{{ $statusCounts[$value] ?? 0
                                        }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="appointment-controls-actions">
                    <div class="appointment-filter-actions">
                        <button id="appointmentFilterBtn" type="button" onclick="openAppointmentFilterPanel()"
                            class="global-filter-btn">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Filter</span>
                            <span id="appointmentFilterBadge" class="filter-badge" style="display:none;"></span>
                        </button>
                    </div>

                    <div class="view-toggle-container" data-global-view-toggle data-view-root="#mainContent"
                        data-storage-key="ViewToggleMode" aria-label="View options">
                        <span class="view-slider" aria-hidden="true"></span>

                        <button type="button" class="btn-view-mode active" title="List view" aria-label="List view"
                            aria-pressed="true" data-view-mode="list">
                            <i class="fa-solid fa-list"></i>
                        </button>

                        <button type="button" class="btn-view-mode" title="Grid view" aria-label="Grid view"
                            aria-pressed="false" data-view-mode="grid">
                            <i class="fa-solid fa-grip"></i>
                        </button>
                    </div>

                    <button id="appointmentClearFilterBtn" type="button" onclick="resetAppointmentFilters()"
                        class="global-filter-reset-btn hidden" title="Reset filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section id="upcomingSection">
        @forelse($upcomingGrouped as $month => $items)
        <details class="appt-month-group" open>
            <summary class="appt-month-summary">
                <span class="appt-month-left">
                    <span class="timeline-dot"></span>
                    <span class="appt-month-title text-[#8b0000]">{{ $month }}</span>
                    <span class="month-count-pill">
                        {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
                    </span>
                </span>

                <i class="fa-solid fa-chevron-down appt-month-chevron"></i>
            </summary>

            <div class="appt-month-body">
                <div class="desktop-appointments-table relative pl-10">
                    <div
                        class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gradient-to-b from-[#8b0000]/30 to-[#8b0000]/05 rounded-full">
                    </div>

                    <div
                        class="appt-table-head appointment-table-grid grid gap-4 text-[10px] font-bold uppercase tracking-[0.14em] text-gray-500 py-3 px-5 bg-[#FAFAFA] border border-gray-200 rounded-t-2xl mb-3">
                        <div class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-[10px]"></i>Date
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-[10px]"></i>Time
                        </div>
                        <div class="appt-program-cell text-left">Service</div>
                        <div class="appt-patient-heading">Patient</div>
                        <div class="appt-program-cell text-left">Program</div>
                        <div class="appt-program-cell text-left">Status</div>
                        <div class="appt-actions-heading">Actions</div>
                    </div>

                    <div class="space-y-2.5">
                        @foreach ($items as $i => $appt)
                        @php
                        $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
                        $profilePatientId = optional($appt->patient)->id ?? ($appt->patient_id ?? null);

                        $profileUrl = $profilePatientId
                        ? route($patientProfileRouteName, ['patient' => $profilePatientId])
                        : null;

                        if ($isDentistView && $profilePatientId) {
                        $profileUrl =
                        route($patientProfileRouteName, $profilePatientId) .
                        '?from=appointments';
                        }
                        $patient = $appt->patient;

                        $studentNumber = filled($patient?->student_no)
                        ? $patient->student_no
                        : (filled($patient?->faculty_code)
                        ? 'Faculty: ' . $patient->faculty_code
                        : 'No identity number');

                        $courseCode = trim((string) ($patient?->course_code ?? ''));
                        $courseName = trim((string) ($patient?->course_name ?? ''));

                        $program =
                        $courseCode !== ''
                        ? $courseCode
                        : ($courseName !== ''
                        ? $courseName
                        : 'No program');

                        $programFull = collect([
                        $courseCode,
                        $courseName !== $courseCode ? $courseName : null,
                        ])
                        ->filter()
                        ->implode(' — ');

                        if ($programFull === '') {
                        $programFull = 'No program';
                        }
                        $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
                        $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
                        $timeLabel = $appt->appointment_time
                        ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A')
                        : '—';
                        $serviceLabel =
                        ($appt->service_type ?? '') === 'Others'
                        ? ($appt->other_services ?? '' ?:
                        'Others')
                        : $appt->service_type ?? '—';
                        $isToday = ($appt->appointment_date ?? null) === $today;
                        $serviceLower = strtolower($serviceLabel);
                        $badgeClass = 'service-badge-default';
                        if (str_contains($serviceLower, 'surgery')) {
                        $badgeClass = 'service-badge-surgery';
                        } elseif (str_contains($serviceLower, 'check')) {
                        $badgeClass = 'service-badge-checkup';
                        } elseif (str_contains($serviceLower, 'whiten')) {
                        $badgeClass = 'service-badge-whitening';
                        } elseif (str_contains($serviceLower, 'extrac')) {
                        $badgeClass = 'service-badge-extraction';
                        }
                        $modalDatetime =
                        \Carbon\Carbon::parse($appt->appointment_date)->format('l, F j, Y') .
                        ' • ' .
                        $timeLabel;
                        $statusRaw = strtolower((string) ($appt->status ?? 'completed'));
                        $isCancelledPast = in_array($statusRaw, ['cancelled', 'canceled']);
                        $cancelReason =
                        $appt->cancellation_reason ??
                        ($appt->cancel_reason ??
                        ($appt->cancelled_reason ?? ($appt->reason ?? '')));
                        $cancelReasonLabel = trim(
                        str_ireplace('Patient no-show', 'No-show', (string) $cancelReason),
                        );
                        $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                        $pastStatusLabel = $isCancelledPast
                        ? 'Cancelled' . ($cancelReasonLabel ? ' - ' . $cancelReasonLabel : '')
                        : 'Completed';
                        $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                        $recordDuration =
                        $appt->duration ??
                        ($appt->procedure_duration ?? ($appt->treatment_duration ?? ''));
                        $recordRemarks =
                        $appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? ''));
                        $recordOral = $appt->oral_examination ?? ($appt->oral ?? '');
                        $recordDiagnosis = $appt->diagnosis ?? '';
                        $recordPrescription = $appt->prescription ?? '';
                        @endphp

                        <div class="appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
                            data-period="upcoming" data-date="{{ $appt->appointment_date }}"
                            data-patient="{{ strtolower($patientName) }}"
                            data-student-no="{{ strtolower($studentNumber) }}"
                            data-program="{{ strtolower($programFull) }}" data-service="{{ strtolower($serviceLabel) }}"
                            data-patient-id="{{ strtolower((string) ($appt->patient_id ?? '')) }}"
                            data-status="{{ strtolower($appt->status ?? 'upcoming') === 'reschedule' ? 'rescheduled' : strtolower($appt->status ?? 'upcoming') }}"
                            style="animation-delay:{{ $i * 0.04 }}s">

                            <div class="appointment-table-grid rounded-[14px] grid gap-4 items-center px-5 py-3.5">

                                <div class="appt-row-date">
                                    <p class="date-main">{{ $dateLabel }}</p>
                                    <p class="date-sub">{{ $weekday }}</p>
                                    @if ($isToday)
                                    <span
                                        class="inline-flex mt-1.5 text-[9px] font-bold uppercase tracking-wide bg-green-500 text-white px-2 py-0.5 rounded-md">
                                        Today
                                    </span>
                                    @endif
                                </div>

                                <div><span class="time-chip"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel
                                        }}</span>
                                </div>

                                <div class="appt-service-cell flex items-center justify-start"><span
                                        class="service-badge {{ $badgeClass }}">{{ $serviceLabel }}</span>
                                </div>

                                <div class="appt-patient-cell flex items-center justify-start gap-3">
                                    <img src="{{ optional($appt->patient)->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patientName) . '&background=8B0000&color=ffffff&bold=true' }}"
                                        alt="{{ $patientName }}"
                                        class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    <div class="text-left min-w-0">
                                        <p class="appt-patient-name text-[13px] font-bold text-gray-800 leading-tight">
                                            {{ $patientName }}</p>
                                        <div class="global-info-group">
                                            <span class="global-info-pill">
                                                <i class="fa-regular fa-id-card"></i>
                                                {{ $studentNumber }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="appt-program-cell">
                                    <span class="global-info-pill" title="{{ $programFull }}">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        {{ $program }}
                                    </span>
                                </div>

                                @php
                                $appointmentStatus = strtolower($appt->status ?? 'upcoming');

                                $statusMap = [
                                'upcoming' => [
                                'label' => 'Upcoming',
                                'class' => 'status-upcoming',
                                ],
                                'rescheduled' => [
                                'label' => 'Rescheduled',
                                'class' => 'status-rescheduled',
                                ],
                                'completed' => [
                                'label' => 'Completed',
                                'class' => 'status-completed',
                                ],
                                'cancelled' => [
                                'label' => 'Cancelled',
                                'class' => 'status-cancelled',
                                ],
                                ];

                                $statusMeta = $statusMap[$appointmentStatus] ?? $statusMap['upcoming'];
                                @endphp

                                <div class="appt-status-cell text-left">
                                    <span class="status-pill {{ $statusMeta['class'] }}">
                                        <span class="status-dot"></span>{{ $statusMeta['label'] }}
                                    </span>
                                </div>

                                <div class="appt-actions-wrap ui-action-group">

                                    @if ($profileUrl)
                                    <a href="{{ $profileUrl }}" class="ui-action-btn ui-action-view"
                                        data-tooltip="View profile" data-tooltip-tone="view">
                                        <i class="fa-regular fa-user"></i>
                                    </a>
                                    @else
                                    <button type="button" class="ui-action-btn ui-action-view" disabled
                                        data-tooltip="No patient profile">
                                        <i class="fa-regular fa-user"></i>
                                    </button>
                                    @endif

                                    @if ($canStartProcedure)
                                    <button type="button"
                                        class="ui-action-btn ui-action-success {{ $isToday ? '' : 'is-start-locked' }}"
                                        data-tooltip="{{ $isToday ? 'Start procedure' : 'Start procedure is available on the appointment date only' }}"
                                        data-tooltip-tone="{{ $isToday ? 'start' : 'locked' }}"
                                        data-start-locked="{{ $isToday ? '0' : '1' }}"
                                        aria-disabled="{{ $isToday ? 'false' : 'true' }}"
                                        onclick="openStartProcedureModal(this)" data-id="{{ $appt->id }}"
                                        data-name="{{ $patientName }}" data-datetime="{{ $modalDatetime }}"
                                        data-start-url="{{ route('dentist.odontogram', ['appointment' => $appt->id]) }}?from=appointments&start_procedure=1">

                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    @endif

                                    @if ($canRescheduleAppointment)
                                    <button type="button" class="ui-action-btn ui-action-warning"
                                        data-tooltip="Reschedule appointment" data-tooltip-tone="reschedule"
                                        aria-label="Reschedule appointment" onclick="openRescheduleModal({
                id: '{{ $appt->id }}',
                name: @js($patientName),
                datetime: @js($modalDatetime),
                serviceType: @js($appt->service_type),
                updateUrl: '{{ route('dentist.dentist.appointments.reschedule.update', $appt->id) }}'
            })">

                                        <i class="fa-solid fa-rotate-right"></i>
                                    </button>
                                    @endif

                                    @if ($canCancelAppointment)
                                    <button type="button" class="ui-action-btn ui-action-delete"
                                        data-tooltip="Cancel appointment" data-tooltip-tone="cancel"
                                        aria-label="Cancel appointment" onclick="cancelAppointmentFromModal(
                '{{ route('dentist.dentist.appointments.cancel', $appt->id) }}',
                @js($patientName),
                @js($dateLabel . ' | ' . $timeLabel)
            )">

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mobile-appointments-list">
                    @foreach ($items as $i => $appt)
                    @php
                    $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
                    $profilePatientId = optional($appt->patient)->id ?? ($appt->patient_id ?? null);

                    $profileUrl = $profilePatientId
                    ? route($patientProfileRouteName, ['patient' => $profilePatientId])
                    : null;

                    if ($isDentistView && $profilePatientId) {
                    $profileUrl =
                    route($patientProfileRouteName, $profilePatientId) . '?from=appointments';
                    }
                    $patient = $appt->patient;

                    $studentNumber = filled($patient?->student_no)
                    ? $patient->student_no
                    : (filled($patient?->faculty_code)
                    ? 'Faculty: ' . $patient->faculty_code
                    : 'No identity number');

                    $courseCode = trim((string) ($patient?->course_code ?? ''));
                    $courseName = trim((string) ($patient?->course_name ?? ''));

                    $program =
                    $courseCode !== ''
                    ? $courseCode
                    : ($courseName !== ''
                    ? $courseName
                    : 'No program');

                    $programFull = collect([
                    $courseCode,
                    $courseName !== $courseCode ? $courseName : null,
                    ])
                    ->filter()
                    ->implode(' — ');

                    if ($programFull === '') {
                    $programFull = 'No program';
                    }
                    $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('M j, Y');
                    $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
                    $timeLabel = $appt->appointment_time
                    ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A')
                    : '—';
                    $serviceLabel =
                    ($appt->service_type ?? '') === 'Others'
                    ? ($appt->other_services ?? '' ?:
                    'Others')
                    : $appt->service_type ?? '—';
                    $isToday = ($appt->appointment_date ?? null) === $today;
                    $serviceLower = strtolower($serviceLabel);
                    $badgeClass = 'service-badge-default';
                    if (str_contains($serviceLower, 'surgery')) {
                    $badgeClass = 'service-badge-surgery';
                    } elseif (str_contains($serviceLower, 'check')) {
                    $badgeClass = 'service-badge-checkup';
                    } elseif (str_contains($serviceLower, 'whiten')) {
                    $badgeClass = 'service-badge-whitening';
                    } elseif (str_contains($serviceLower, 'extrac')) {
                    $badgeClass = 'service-badge-extraction';
                    }
                    $modalDatetime =
                    \Carbon\Carbon::parse($appt->appointment_date)->format('l, F j, Y') .
                    ' • ' .
                    $timeLabel;
                    $statusRaw = strtolower((string) ($appt->status ?? 'completed'));
                    $isCancelledPast = in_array($statusRaw, ['cancelled', 'canceled']);
                    $cancelReason =
                    $appt->cancellation_reason ??
                    ($appt->cancel_reason ?? ($appt->cancelled_reason ?? ($appt->reason ?? '')));
                    $cancelReasonLabel = trim(
                    str_ireplace('Patient no-show', 'No-show', (string) $cancelReason),
                    );
                    $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                    $pastStatusLabel = $isCancelledPast
                    ? 'Cancelled' . ($cancelReasonLabel ? ' - ' . $cancelReasonLabel : '')
                    : 'Completed';
                    $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                    $recordDuration =
                    $appt->duration ??
                    ($appt->procedure_duration ?? ($appt->treatment_duration ?? ''));
                    $recordRemarks = $appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? ''));
                    $recordOral = $appt->oral_examination ?? ($appt->oral ?? '');
                    $recordDiagnosis = $appt->diagnosis ?? '';
                    $recordPrescription = $appt->prescription ?? '';
                    @endphp

                    <div class="mobile-appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
                        data-period="upcoming" data-date="{{ $appt->appointment_date }}"
                        data-patient="{{ strtolower($patientName) }}" data-student-no="{{ strtolower($studentNumber) }}"
                        data-program="{{ strtolower($programFull) }}" data-service="{{ strtolower($serviceLabel) }}"
                        data-patient-id="{{ strtolower((string) ($appt->patient_id ?? '')) }}"
                        data-status="{{ strtolower($appt->status ?? 'upcoming') === 'reschedule' ? 'rescheduled' : strtolower($appt->status ?? 'upcoming') }}"
                        style="animation-delay:{{ $i * 0.04 }}s">

                        <div class="flex items-start justify-between gap-2 mb-4 pl-1">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <p
                                        class="mobile-patient-name text-[15px] font-extrabold text-gray-800 leading-snug">
                                        {{ $patientName }}</p>
                                    @if ($isToday)
                                    <span
                                        class="text-[9px] font-bold uppercase tracking-wide bg-blue-600 text-white px-2 py-0.5 rounded-md">Today</span>
                                    @endif
                                </div>
                                <div class="global-info-group">
                                    <span class="global-info-pill">
                                        <i class="fa-regular fa-id-card"></i>
                                        {{ $studentNumber }}
                                    </span>

                                    <span class="global-info-pill" title="{{ $programFull }}">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        {{ $program }}
                                    </span>
                                </div>

                                <p class="mobile-appointment-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $weekday }}, {{ $dateLabel }}
                                </p>
                            </div>
                            @php
                            $appointmentStatus = strtolower($appt->status ?? 'upcoming');

                            $statusMap = [
                            'upcoming' => [
                            'label' => 'Upcoming',
                            'class' => 'status-upcoming',
                            ],
                            'rescheduled' => [
                            'label' => 'Rescheduled',
                            'class' => 'status-rescheduled',
                            ],
                            'completed' => [
                            'label' => 'Completed',
                            'class' => 'status-completed',
                            ],
                            'cancelled' => [
                            'label' => 'Cancelled',
                            'class' => 'status-cancelled',
                            ],
                            ];

                            $statusMeta = $statusMap[$appointmentStatus] ?? $statusMap['upcoming'];
                            @endphp

                            <span class="status-pill {{ $statusMeta['class'] }} flex-shrink-0">
                                <span class="status-dot"></span>{{ $statusMeta['label'] }}
                            </span>
                        </div>

                        <div class="appointment-grid-details">
                            <div class="appointment-grid-detail">
                                <span class="appointment-grid-detail-label">
                                    Schedule Time
                                </span>

                                <span class="time-chip">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $timeLabel }}
                                </span>
                            </div>

                            <div class="appointment-grid-detail">
                                <span class="appointment-grid-detail-label">
                                    Service Type
                                </span>

                                <span class="service-badge {{ $badgeClass }}">
                                    {{ $serviceLabel }}
                                </span>
                            </div>
                        </div>

                        <div class="mobile-appt-actions ui-action-group">
                            @if ($profileUrl)
                            <a href="{{ $profileUrl }}" class="ui-action-btn ui-action-view" data-tooltip="View profile"
                                aria-label="View profile">
                                <i class="fa-regular fa-user"></i>
                            </a>
                            @else
                            <button type="button" class="ui-action-btn ui-action-view" data-tooltip="No patient profile"
                                aria-label="No patient profile" disabled>
                                <i class="fa-regular fa-user"></i>
                            </button>
                            @endif

                            @if ($canStartProcedure)
                            <button type="button"
                                class="ui-action-btn ui-action-success {{ $isToday ? '' : 'is-start-locked' }}"
                                data-tooltip="{{ $isToday
        ? 'Start procedure'
        : 'Start procedure is available on the appointment date only' }}"
                                data-tooltip-tone="{{ $isToday ? 'start' : 'locked' }}"
                                data-start-locked="{{ $isToday ? '0' : '1' }}"
                                aria-disabled="{{ $isToday ? 'false' : 'true' }}"
                                onclick="openStartProcedureModal(this)" data-id="{{ $appt->id }}"
                                data-name="{{ $patientName }}" data-datetime="{{ $modalDatetime }}"
                                data-start-url="{{ route('dentist.odontogram', ['appointment' => $appt->id]) }}?from=appointments&start_procedure=1">
                                <i class="fa-solid fa-play"></i>
                            </button>
                            @endif

                            @if ($canRescheduleAppointment)
                            <button type="button" class="ui-action-btn ui-action-warning"
                                data-tooltip="Reschedule appointment" data-tooltip-tone="reschedule"
                                aria-label="Reschedule appointment" onclick="openRescheduleModal({
                id: '{{ $appt->id }}',
                name: @js($patientName),
                datetime: @js($modalDatetime),
                serviceType: @js($appt->service_type),
                updateUrl: '{{ route('dentist.dentist.appointments.reschedule.update', $appt->id) }}'
            })">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                            @endif

                            @if ($canCancelAppointment)
                            <button type="button" class="ui-action-btn ui-action-delete"
                                data-tooltip="Cancel appointment" data-tooltip-tone="cancel"
                                aria-label="Cancel appointment" onclick="cancelAppointmentFromModal(
                '{{ route('dentist.dentist.appointments.cancel', $appt->id) }}',
                @js($patientName),
                @js($dateLabel . ' | ' . $timeLabel)
            )">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
            </div>
        </details>
        @empty
        <div id="appointmentStaticEmptyUpcoming" class="empty-state appointment-static-empty">
            <div class="empty-state-icon appointment-empty-icon">
                <i class="fa-regular fa-calendar-xmark"></i>
            </div>

            <p class="empty-state-title">No upcoming appointments</p>
            <p class="empty-state-sub">New appointments will appear here once scheduled.</p>
        </div>
        @endforelse

        <div id="appointmentFilterEmptyUpcoming" class="empty-state empty-state-controlled">
            <div class="empty-state-icon appointment-empty-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <p id="appointmentFilterEmptyUpcomingTitle" class="empty-state-title">
                No results found
            </p>

            <p class="empty-state-sub">
                Try a different name, ID, or service type.
            </p>

            <button type="button" onclick="clearAppointmentSearch()" class="empty-state-btn">
                <i class="fa-solid fa-xmark"></i>
                Clear search
            </button>
        </div>

        <div id="appointmentStatusEmptyUpcoming" class="empty-state empty-state-controlled">
            <div class="empty-state-icon appointment-empty-icon">
                <i id="appointmentStatusEmptyUpcomingIcon" class="fa-regular fa-calendar-xmark"></i>
            </div>

            <p id="appointmentStatusEmptyUpcomingTitle" class="empty-state-title">
                No upcoming appointments
            </p>

            <p id="appointmentStatusEmptyUpcomingSub" class="empty-state-sub">
                New appointments will appear here once scheduled.
            </p>

            <button type="button" onclick="resetAppointmentPanelFilters()" class="appointment-panel-empty-clear hidden"
                hidden>

                <i class="fa-solid fa-rotate-left"></i>
                Clear filters
            </button>
        </div>
    </section>

    <section id="pastSection">
        @forelse($pastGrouped as $month => $items)
        <details class="appt-month-group" open>
            <summary class="appt-month-summary">
                <span class="appt-month-left">
                    <span class="timeline-dot-past"></span>
                    <span class="appt-month-title text-gray-400">{{ $month }}</span>
                    <span class="month-count-pill">
                        {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
                    </span>
                </span>

                <i class="fa-solid fa-chevron-down appt-month-chevron"></i>
            </summary>

            <div class="appt-month-body">
                <div class="desktop-appointments-table relative pl-10">
                    <div class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gray-200 rounded-full"></div>

                    <div
                        class="appt-table-head appointment-table-grid grid gap-4 text-[10px] font-bold uppercase tracking-[0.14em] text-gray-400 py-3 px-5 bg-[#FAFAFA] border border-gray-200 rounded-t-2xl mb-3">
                        <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date
                        </div>
                        <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time
                        </div>
                        <div class="appt-program-cell text-left">Service</div>
                        <div class="appt-patient-heading">Patient</div>
                        <div class="appt-program-cell text-left">Program</div>
                        <div class="appt-program-cell text-left">Status</div>
                        <div class="appt-actions-heading">Actions</div>
                    </div>

                    <div class="space-y-2.5">
                        @foreach ($items as $i => $appt)
                        @php
                        $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
                        $profilePatientId = optional($appt->patient)->id ?? ($appt->patient_id ?? null);

                        $profileUrl = $profilePatientId
                        ? route($patientProfileRouteName, ['patient' => $profilePatientId])
                        : null;

                        if ($isDentistView && $profilePatientId) {
                        $profileUrl =
                        route($patientProfileRouteName, $profilePatientId) .
                        '?from=appointments';
                        }
                        $patient = $appt->patient;

                        $studentNumber = filled($patient?->student_no)
                        ? $patient->student_no
                        : (filled($patient?->faculty_code)
                        ? 'Faculty: ' . $patient->faculty_code
                        : 'No identity number');

                        $courseCode = trim((string) ($patient?->course_code ?? ''));
                        $courseName = trim((string) ($patient?->course_name ?? ''));

                        $program =
                        $courseCode !== ''
                        ? $courseCode
                        : ($courseName !== ''
                        ? $courseName
                        : 'No program');

                        $programFull = collect([
                        $courseCode,
                        $courseName !== $courseCode ? $courseName : null,
                        ])
                        ->filter()
                        ->implode(' — ');

                        if ($programFull === '') {
                        $programFull = 'No program';
                        }
                        $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
                        $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
                        $timeLabel = $appt->appointment_time
                        ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A')
                        : '—';
                        $serviceLabel =
                        ($appt->service_type ?? '') === 'Others'
                        ? ($appt->other_services ?? '' ?:
                        'Others')
                        : $appt->service_type ?? '—';
                        $serviceLower = strtolower($serviceLabel);
                        $badgeClass = 'service-badge-default';
                        if (str_contains($serviceLower, 'surgery')) {
                        $badgeClass = 'service-badge-surgery';
                        } elseif (str_contains($serviceLower, 'check')) {
                        $badgeClass = 'service-badge-checkup';
                        } elseif (str_contains($serviceLower, 'whiten')) {
                        $badgeClass = 'service-badge-whitening';
                        } elseif (str_contains($serviceLower, 'extrac')) {
                        $badgeClass = 'service-badge-extraction';
                        }
                        $modalDatetime =
                        \Carbon\Carbon::parse($appt->appointment_date)->format('l, F j, Y') .
                        ' • ' .
                        $timeLabel;
                        $statusRaw = strtolower((string) ($appt->status ?? 'completed'));
                        $isCancelledPast = in_array($statusRaw, ['cancelled', 'canceled']);
                        $cancelReason =
                        $appt->cancellation_reason ??
                        ($appt->cancel_reason ??
                        ($appt->cancelled_reason ?? ($appt->reason ?? '')));
                        $cancelReasonLabel = trim(
                        str_ireplace('Patient no-show', 'No-show', (string) $cancelReason),
                        );
                        $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                        $pastStatusLabel = $isCancelledPast
                        ? 'Cancelled' . ($cancelReasonLabel ? ' - ' . $cancelReasonLabel : '')
                        : 'Completed';
                        $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                        $recordDuration =
                        $appt->duration ??
                        ($appt->procedure_duration ?? ($appt->treatment_duration ?? ''));
                        $recordRemarks =
                        $appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? ''));
                        $recordOral = $appt->oral_examination ?? ($appt->oral ?? '');
                        $recordDiagnosis = $appt->diagnosis ?? '';
                        $recordPrescription = $appt->prescription ?? '';
                        @endphp

                        <div class="appt-card" data-appt-id="{{ $appt->id }}" data-period="past"
                            data-date="{{ $appt->appointment_date }}" data-patient="{{ strtolower($patientName) }}"
                            data-student-no="{{ strtolower($studentNumber) }}"
                            data-program="{{ strtolower($programFull) }}" data-service="{{ strtolower($serviceLabel) }}"
                            data-patient-id="{{ strtolower((string) ($appt->patient_id ?? '')) }}"
                            data-status="{{ $isCancelledPast ? 'cancelled' : 'completed' }}"
                            style="animation-delay:{{ $i * 0.04 }}s">

                            <div class="appointment-table-grid grid gap-4 items-center px-5 py-3.5">

                                <div class="appt-row-date">
                                    <p class="date-main">{{ $dateLabel }}</p>
                                    <p class="date-sub">{{ $weekday }}</p>
                                </div>

                                <div><span class="time-chip text-gray-400"><i class="fa-regular fa-clock text-xs"></i>{{
                                        $timeLabel }}</span>
                                </div>

                                <div class="flex items-center justify-start"><span
                                        class="service-badge {{ $badgeClass }} opacity-70">{{ $serviceLabel }}</span>
                                </div>

                                <div class="appt-patient-cell flex items-center justify-start gap-3">
                                    <img src="{{ optional($appt->patient)->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patientName) . '&background=9ca3af&color=ffffff&bold=true' }}"
                                        alt="{{ $patientName }}"
                                        class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0 opacity-80">
                                    <div class="text-left min-w-0">
                                        <p class="appt-patient-name text-[13px] font-bold text-gray-800 leading-tight"
                                            title="{{ $patientName }}">
                                            {{ $patientName }}</p>
                                        <div class="global-info-group">
                                            <span class="global-info-pill">
                                                <i class="fa-regular fa-id-card"></i>
                                                {{ $studentNumber }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="appt-program-cell">
                                    <span class="global-info-pill" title="{{ $programFull }}">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        {{ $program }}
                                    </span>
                                </div>

                                <div class="appt-status-cell text-left">
                                    <span class="status-pill {{ $pastStatusClass }} past-status-pill"
                                        data-appt-id="{{ $appt->id }}" data-status-base="{{ $pastStatusBase }}"
                                        data-cancel-reason="{{ $cancelReasonLabel }}"><span
                                            class="status-dot"></span><span class="past-status-text">{{ $pastStatusLabel
                                            }}</span></span>
                                </div>

                                <div class="appt-actions-wrap ui-action-group">

                                    @if ($canViewTreatmentRecord)
                                    <button type="button" class="ui-action-btn ui-action-neutral"
                                        data-tooltip="View details" onclick="openRecordModal(this)"
                                        data-appt-id="{{ $appt->id }}" data-service="{{ $serviceLabel }}"
                                        data-date="{{ $dateLabel }}" data-time="{{ $timeLabel }}"
                                        data-status="{{ $pastStatusLabel }}" data-duration="{{ $recordDuration }}"
                                        data-remarks="{{ $recordRemarks }}" data-oral="{{ $recordOral }}"
                                        data-diagnosis="{{ $recordDiagnosis }}"
                                        data-prescription="{{ $recordPrescription }}">

                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    @endif

                                    @if ($profileUrl)
                                    <a href="{{ $profileUrl }}" class="ui-action-btn ui-action-view"
                                        data-tooltip="View profile" data-tooltip-tone="view">

                                        <i class="fa-regular fa-user"></i>
                                    </a>
                                    @else
                                    <button type="button" class="ui-action-btn ui-action-view" disabled
                                        data-tooltip="No patient profile">

                                        <i class="fa-regular fa-user"></i>
                                    </button>
                                    @endif

                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mobile-appointments-list">
                    @foreach ($items as $i => $appt)
                    @php
                    $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
                    $profilePatientId = optional($appt->patient)->id ?? ($appt->patient_id ?? null);

                    $profileUrl = $profilePatientId
                    ? route($patientProfileRouteName, ['patient' => $profilePatientId])
                    : null;

                    if ($isDentistView && $profilePatientId) {
                    $profileUrl =
                    route($patientProfileRouteName, $profilePatientId) . '?from=appointments';
                    }
                    $patient = $appt->patient;

                    $studentNumber = filled($patient?->student_no)
                    ? $patient->student_no
                    : (filled($patient?->faculty_code)
                    ? 'Faculty: ' . $patient->faculty_code
                    : 'No identity number');

                    $courseCode = trim((string) ($patient?->course_code ?? ''));
                    $courseName = trim((string) ($patient?->course_name ?? ''));

                    $program =
                    $courseCode !== ''
                    ? $courseCode
                    : ($courseName !== ''
                    ? $courseName
                    : 'No program');

                    $programFull = collect([
                    $courseCode,
                    $courseName !== $courseCode ? $courseName : null,
                    ])
                    ->filter()
                    ->implode(' — ');

                    if ($programFull === '') {
                    $programFull = 'No program';
                    }
                    $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('M j, Y');
                    $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
                    $timeLabel = $appt->appointment_time
                    ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A')
                    : '—';
                    $serviceLabel =
                    ($appt->service_type ?? '') === 'Others'
                    ? ($appt->other_services ?? '' ?:
                    'Others')
                    : $appt->service_type ?? '—';
                    $serviceLower = strtolower($serviceLabel);
                    $badgeClass = 'service-badge-default';
                    if (str_contains($serviceLower, 'surgery')) {
                    $badgeClass = 'service-badge-surgery';
                    } elseif (str_contains($serviceLower, 'check')) {
                    $badgeClass = 'service-badge-checkup';
                    } elseif (str_contains($serviceLower, 'whiten')) {
                    $badgeClass = 'service-badge-whitening';
                    } elseif (str_contains($serviceLower, 'extrac')) {
                    $badgeClass = 'service-badge-extraction';
                    }
                    $modalDatetime =
                    \Carbon\Carbon::parse($appt->appointment_date)->format('l, F j, Y') .
                    ' • ' .
                    $timeLabel;
                    $statusRaw = strtolower((string) ($appt->status ?? 'completed'));
                    $isCancelledPast = in_array($statusRaw, ['cancelled', 'canceled']);
                    $cancelReason =
                    $appt->cancellation_reason ??
                    ($appt->cancel_reason ?? ($appt->cancelled_reason ?? ($appt->reason ?? '')));
                    $cancelReasonLabel = trim(
                    str_ireplace('Patient no-show', 'No-show', (string) $cancelReason),
                    );
                    $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                    $pastStatusLabel = $isCancelledPast
                    ? 'Cancelled' . ($cancelReasonLabel ? ' - ' . $cancelReasonLabel : '')
                    : 'Completed';
                    $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                    $recordDuration =
                    $appt->duration ??
                    ($appt->procedure_duration ?? ($appt->treatment_duration ?? ''));
                    $recordRemarks = $appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? ''));
                    $recordOral = $appt->oral_examination ?? ($appt->oral ?? '');
                    $recordDiagnosis = $appt->diagnosis ?? '';
                    $recordPrescription = $appt->prescription ?? '';
                    @endphp

                    <div class="mobile-appt-card" data-appt-id="{{ $appt->id }}" data-period="past"
                        data-date="{{ $appt->appointment_date }}" data-patient="{{ strtolower($patientName) }}"
                        data-student-no="{{ strtolower($studentNumber) }}" data-program="{{ strtolower($programFull) }}"
                        data-service="{{ strtolower($serviceLabel) }}"
                        data-patient-id="{{ strtolower((string) ($appt->patient_id ?? '')) }}"
                        data-status="{{ $isCancelledPast ? 'cancelled' : 'completed' }}"
                        style="animation-delay:{{ $i * 0.04 }}s">
                        <div class="pl-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="min-w-0">
                                    <p class="mobile-patient-name text-[15px] font-extrabold text-gray-800 leading-snug"
                                        title="{{ $patientName }}">
                                        {{ $patientName }}
                                    </p>

                                    <div class="global-info-group">
                                        <span class="global-info-pill">
                                            <i class="fa-regular fa-id-card"></i>
                                            {{ $studentNumber }}
                                        </span>

                                        <span class="global-info-pill" title="{{ $programFull }}">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            {{ $program }}
                                        </span>
                                    </div>

                                    <p class="mobile-appointment-date">
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ $weekday }}, {{ $dateLabel }}
                                    </p>
                                </div>
                                <span class="status-pill {{ $pastStatusClass }} past-status-pill flex-shrink-0"
                                    data-appt-id="{{ $appt->id }}" data-status-base="{{ $pastStatusBase }}"
                                    data-cancel-reason="{{ $cancelReasonLabel }}"><span class="status-dot"></span><span
                                        class="past-status-text">{{ $pastStatusLabel }}</span></span>
                            </div>

                            <div class="appointment-grid-details">
                                <div class="appointment-grid-detail">
                                    <span class="appointment-grid-detail-label">
                                        Schedule Time
                                    </span>

                                    <span class="time-chip">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $timeLabel }}
                                    </span>
                                </div>

                                <div class="appointment-grid-detail">
                                    <span class="appointment-grid-detail-label">
                                        Service Type
                                    </span>

                                    <span class="service-badge {{ $badgeClass }}">
                                        {{ $serviceLabel }}
                                    </span>
                                </div>
                            </div>

                            <div class="mobile-appt-actions ui-action-group">
                                @if ($canViewTreatmentRecord)
                                <button type="button" class="ui-action-btn ui-action-neutral"
                                    data-tooltip="View details" onclick="openRecordModal(this)"
                                    data-appt-id="{{ $appt->id }}" data-service="{{ $serviceLabel }}"
                                    data-date="{{ $dateLabel }}" data-time="{{ $timeLabel }}"
                                    data-status="{{ $pastStatusLabel }}" data-duration="{{ $recordDuration }}"
                                    data-remarks="{{ $recordRemarks }}" data-oral="{{ $recordOral }}"
                                    data-diagnosis="{{ $recordDiagnosis }}"
                                    data-prescription="{{ $recordPrescription }}">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                @endif

                                @if ($profileUrl)
                                <a href="{{ $profileUrl }}" class="ui-action-btn ui-action-view"
                                    data-tooltip="View profile" aria-label="View profile">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                @else
                                <button type="button" class="ui-action-btn ui-action-view"
                                    data-tooltip="No patient profile" aria-label="No patient profile" disabled>
                                    <i class="fa-regular fa-user"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </details>
        @empty
        <div id="appointmentStaticEmptyPast" class="empty-state appointment-static-empty">
            <div class="empty-state-icon appointment-empty-icon">
                <i class="fa-regular fa-calendar-xmark"></i>
            </div>

            <p class="empty-state-title">No past appointments</p>
            <p class="empty-state-sub">Completed and cancelled appointments will appear here.</p>
        </div>
        @endforelse

        <div id="appointmentFilterEmptyPast" class="empty-state empty-state-controlled">
            <div class="empty-state-icon appointment-empty-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <p id="appointmentFilterEmptyPastTitle" class="empty-state-title">
                No results found
            </p>

            <p class="empty-state-sub">
                Try a different name, ID, or service type.
            </p>

            <button type="button" onclick="clearAppointmentSearch()" class="empty-state-btn">
                <i class="fa-solid fa-xmark"></i>
                Clear search
            </button>
        </div>

        <div id="appointmentStatusEmptyPast" class="empty-state empty-state-controlled">
            <div class="empty-state-icon appointment-empty-icon">
                <i id="appointmentStatusEmptyPastIcon" class="fa-regular fa-calendar-xmark"></i>
            </div>

            <p id="appointmentStatusEmptyPastTitle" class="empty-state-title">
                No past appointments
            </p>

            <p id="appointmentStatusEmptyPastSub" class="empty-state-sub">
                Completed appointments will appear here.
            </p>

            <button type="button" onclick="resetAppointmentPanelFilters()" class="appointment-panel-empty-clear hidden"
                hidden>

                <i class="fa-solid fa-rotate-left"></i>
                Clear filters
            </button>
        </div>
    </section>
</main>

<div id="filterModal" class="filter-drawer-wrapper" aria-hidden="true">
    <div class="filter-drawer-overlay" onclick="document.getElementById('closeFilterModalBtn').click()">
    </div>

    <div class="filter-drawer-panel">

        <div class="filter-drawer-header">
            <div class="filter-drawer-title">
                <i class="fa-solid fa-sliders"></i>
                <h2>Filters</h2>
            </div>

            <button id="closeFilterModalBtn" type="button" class="filter-drawer-close" aria-label="Close filters">

                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="filter-drawer-body">

            <div id="activeFiltersSection" class="filter-active-section hidden">

                <div class="filter-active-header">
                    <span class="filter-active-title">
                        Active Filters
                    </span>

                    <button id="clearAllChipsBtn" type="button"
                        class="filter-clear-all ui-btn ui-btn-secondary ui-btn-sm">

                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Clear All</span>
                    </button>
                </div>

                <div id="activeChipsContainer" class="active-filters-container">
                </div>
            </div>

            <div>
                <h3 class="filter-section-title">Sort By</h3>

                <div class="filter-chip-row" id="apptSortGroup">
                    <button type="button" class="ftag ftag-active" data-sort="newest">
                        Newest First
                    </button>

                    <button type="button" class="ftag" data-sort="oldest">
                        Oldest First
                    </button>

                    <button type="button" class="ftag" data-sort="az">
                        Patient Name A-Z
                    </button>

                    <button type="button" class="ftag" data-sort="za">
                        Patient Name Z-A
                    </button>
                </div>
            </div>

            <div>
                <h3 class="filter-section-title">
                    Filter by Date Range
                </h3>

                <div class="filter-chip-row" id="datePresetGroup">
                    <button type="button" class="quick-date-chip" data-range="7">
                        Last 7 Days
                    </button>

                    <button type="button" class="quick-date-chip" data-range="30">
                        Last 30 Days
                    </button>

                    <button type="button" class="quick-date-chip" data-range="90">
                        Last 3 Months
                    </button>

                    <button type="button" class="quick-date-chip" data-range="180">
                        Last 6 Months
                    </button>

                    <button type="button" class="quick-date-chip" data-range="365">
                        Last 12 Months
                    </button>
                </div>
            </div>

            <div>
                <h3 class="filter-section-title">
                    Custom Date Range
                </h3>

                <div class="filter-date-grid">
                    <div class="filter-date-input-wrap">
                        <input id="fromDate" type="text" class="js-flatpickr-date-range-from" placeholder="Start date"
                            readonly autocomplete="off">

                        <i class="fa-regular fa-calendar"></i>
                    </div>

                    <div class="filter-date-input-wrap">
                        <input id="toDate" type="text" class="js-flatpickr-date-range-to" placeholder="End date"
                            readonly autocomplete="off">

                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="filter-drawer-footer">

            <button id="clearFiltersModal" type="button" class="filter-clear-btn ui-btn ui-btn-secondary ui-btn-sm">

                <i class="fa-regular fa-trash-can"></i>
                <span>Clear Filters</span>
            </button>

            <div class="filter-footer-actions">

                <button id="cancelFilterBtn" type="button" class="filter-cancel-btn ui-btn ui-btn-secondary">

                    <i class="fa-solid fa-xmark"></i>
                    <span>Cancel</span>
                </button>

                <button id="applyFilters" type="button" class="filter-apply-btn ui-btn ui-btn-primary">

                    <i class="fa-solid fa-check"></i>

                    <span id="showResultsText" class="filter-results-text">
                        Show 0 results
                    </span>
                </button>

            </div>
        </div>

    </div>
</div>

@if ($isDentistView)
<div id="startProcedureModal"
    class="start-procedure-overlay fixed inset-0 hidden z-[9999] items-end sm:items-center justify-center p-0 sm:p-4">
    <div class="start-procedure-shell modal-box">
        <div class="start-procedure-header">
            <div class="start-procedure-header-left">
                <div class="start-procedure-icon">
                    <i class="fa-solid fa-tooth"></i>
                </div>

                <div class="min-w-0">
                    <h2>Start Procedure</h2>
                    <p>Open the odontogram to begin this appointment.</p>
                </div>
            </div>

            <button type="button" class="start-procedure-close" onclick="closeStartProcedureModal()"
                aria-label="Close start procedure modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="start-procedure-body">
            <div class="start-procedure-alert">
                <div class="start-procedure-alert-icon">
                    <i class="fa-solid fa-play"></i>
                </div>

                <div>
                    <p class="start-procedure-alert-title">Ready to start this appointment?</p>
                    <p class="start-procedure-alert-sub">You will be redirected to the odontogram page for the
                        selected
                        patient.</p>
                </div>
            </div>

            <div class="start-procedure-card">
                <div class="start-procedure-card-row">
                    <span>Patient</span>
                    <strong id="startPatientName">—</strong>
                </div>

                <div class="start-procedure-card-row">
                    <span>Schedule</span>
                    <strong id="startAppointmentDate">—</strong>
                </div>
            </div>
        </div>

        <div class="start-procedure-footer">
            <button type="button" onclick="closeStartProcedureModal()"
                class="start-procedure-btn start-procedure-btn-cancel">
                Cancel
            </button>

            <button type="button" onclick="confirmStartProcedure()"
                class="start-procedure-btn start-procedure-btn-primary">
                <i class="fa-solid fa-tooth"></i>
                Start Procedure
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    const APPOINTMENT_REFRESH_ITEMS = @json($appointmentRefreshItems);
    const APPOINTMENT_REFRESH_URL = window.location.href;
    let appointmentRefreshWatcher = null;

    function initAppointmentRefreshWatcher() {
        if (!window.initGlobalRefreshWatcher) return;

        appointmentRefreshWatcher = window.initGlobalRefreshWatcher({
            key: @json($isDentistView ? 'dentist-appointments' : 'admin-appointments'),
            url: APPOINTMENT_REFRESH_URL,
            initialItems: APPOINTMENT_REFRESH_ITEMS,
            anchorSelector: '#mainContent.shared-appointments-page .appointment-controls-bar',
            itemLabel: 'appointment',

            getItems(payload) {
                if (Array.isArray(payload)) {
                    return payload;
                }

                return Array.isArray(payload?.appointments)
                    ? payload.appointments
                    : [];
            },

            getItemId(appointment) {
                return appointment?.id;
            },

            title(count) {
                return `${count} new appointment${count === 1 ? '' : 's'} available`;
            },

            subtitle(count) {
                return `Refresh to see the latest appointment update${count === 1 ? '' : 's'}.`;
            },

            onRefresh() {
                window.location.reload();
            },

            toast: false
        });
    }

    function normalizeCancelReasonLabel(reason) {
        reason = String(reason || '').trim();
        if (!reason) return '';
        if (reason.toLowerCase() === 'patient no-show') return 'No-show';
        return reason;
    }

    function getStoredCancelReason(apptId) {
        if (!apptId) return '';
        return sessionStorage.getItem(`appointmentCancelReason:${apptId}`) || '';
    }

    function hydratePastCancellationReasons() {
        document.querySelectorAll('.past-status-pill[data-status-base="Cancelled"]').forEach((pill) => {
            const apptId = pill.dataset.apptId || '';
            const reason = normalizeCancelReasonLabel(pill.dataset.cancelReason || getStoredCancelReason(
                apptId));
            const label = reason ? `Cancelled - ${reason}` : 'Cancelled';
            const text = pill.querySelector('.past-status-text');

            if (text) text.textContent = label;
            pill.dataset.statusFull = label;

            document.querySelectorAll(`.action-btn-record[data-appt-id="${apptId}"]`).forEach((btn) => {
                btn.dataset.status = label;
            });
        });

        document.querySelectorAll('.past-status-pill[data-status-base="Completed"]').forEach((pill) => {
            const text = pill.querySelector('.past-status-text');
            if (text) text.textContent = 'Completed';
            pill.dataset.statusFull = 'Completed';
        });
    }

    document.addEventListener('DOMContentLoaded', hydratePastCancellationReasons);

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof initRecordModal === 'function') {
            initRecordModal();
        }
    });

    var selectedApptId = null;
    var selectedStartUrl = null;

    function openStartProcedureModal(btn) {
        if (!btn || btn.disabled || btn.dataset.startLocked === '1') return;

        selectedApptId = btn.dataset.id || null;
        selectedStartUrl = btn.dataset.startUrl || null;

        document.getElementById('startPatientName').textContent = btn.dataset.name || '—';
        document.getElementById('startAppointmentDate').textContent = btn.dataset.datetime || '—';

        const modal = document.getElementById('startProcedureModal');
        modal?.classList.remove('hidden');
        modal?.classList.add('flex');
    }

    function closeStartProcedureModal() {
        const modal = document.getElementById('startProcedureModal');
        modal?.classList.add('hidden');
        modal?.classList.remove('flex');

        selectedApptId = null;
        selectedStartUrl = null;
    }

    function confirmStartProcedure() {
        if (!selectedStartUrl) return;

        window.location.href = selectedStartUrl;
    }

    let apptSearchInput = null;
    let apptStatusFilter = null;

    let appointmentPeriodFilter = 'upcoming';
    let appointmentStatusFilter = 'all';
    let appointmentStatusFilterSource = 'dropdown';
    let appointmentSortFilter = 'newest';
    let appointmentFromDate = '';
    let appointmentToDate = '';

    function normalizeAppointmentStatusFilter(status = '') {
        const normalized = String(status || '').toLowerCase().trim();

        if (['pending', 'confirmed', 'upcoming'].includes(normalized)) {
            return 'upcoming';
        }

        if (['reschedule', 'rescheduled'].includes(normalized)) {
            return 'rescheduled';
        }

        if (['canceled', 'cancelled'].includes(normalized)) {
            return 'cancelled';
        }

        if (normalized.includes('complete')) {
            return 'completed';
        }

        return normalized || 'upcoming';
    }

    const apptStatusMeta = {
        all: {
            label: 'All statuses',
            icon: 'fa-layer-group',
            tone: 'all'
        },
        upcoming: {
            label: 'Upcoming',
            icon: 'fa-calendar-check',
            tone: 'upcoming'
        },
        rescheduled: {
            label: 'Rescheduled',
            icon: 'fa-rotate-right',
            tone: 'rescheduled'
        },
        completed: {
            label: 'Completed',
            icon: 'fa-circle-check',
            tone: 'completed'
        },
        cancelled: {
            label: 'Cancelled',
            icon: 'fa-circle-xmark',
            tone: 'cancelled'
        }
    };

    function setAppointmentStatusFilter(value = 'all', shouldApply = true, source = 'dropdown') {
        const nextValue = apptStatusMeta[value] ? value : 'all';
        const meta = apptStatusMeta[nextValue];

        appointmentStatusFilter = nextValue;
        appointmentStatusFilterSource = source;

        if (source === 'dropdown') {
            appointmentPeriodFilter = nextValue === 'all' ?
                'all' : ['completed', 'cancelled'].includes(nextValue) ?
                    'past' :
                    'upcoming';
        }

        if (apptStatusFilter) {
            apptStatusFilter.value = nextValue;
        }

        const label = document.getElementById('apptStatusSelectedLabel');
        const count = document.getElementById('apptStatusSelectedCount');
        const icon = document.getElementById('apptStatusIcon');
        const activeOption = document.querySelector(`.appointment-status-option[data-status-value="${nextValue}"]`);

        if (label) label.textContent = meta.label;
        if (count) count.textContent = activeOption?.dataset.statusCount || '0';

        if (icon) {
            icon.className = `appointment-status-trigger-icon tone-${meta.tone}`;
            icon.innerHTML = `<i class="fa-solid ${meta.icon}"></i>`;
        }

        document.querySelectorAll('.appointment-status-option').forEach(option => {
            option.classList.toggle('is-active', option.dataset.statusValue === nextValue);
        });

        if (shouldApply) {
            applyAppointmentFilters();
        }
    }

    apptSearchInput?.addEventListener('input', applyAppointmentFilters);
    apptStatusFilter?.addEventListener('change', applyAppointmentFilters);

    function setupAppointmentStatusDropdown() {
        const dropdown = document.getElementById('apptStatusDropdown');
        const trigger = document.getElementById('apptStatusToggle');
        const panel = document.getElementById('apptStatusPanel');

        if (!dropdown || !trigger || !panel) return;

        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = dropdown.classList.contains('open');

            document.querySelectorAll('.appointment-status-dropdown.open').forEach(item => {
                if (item !== dropdown) {
                    item.classList.remove('open');
                    item.querySelector('.appointment-status-trigger')?.setAttribute('aria-expanded',
                        'false');
                }
            });

            dropdown.classList.toggle('open', !isOpen);
            trigger.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
        });

        document.querySelectorAll('.appointment-status-option').forEach(option => {
            option.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                setAppointmentStatusFilter(option.dataset.statusValue || 'all', true, 'dropdown');

                dropdown.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                dropdown.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    function setupAppointmentAccordions() {
        document.querySelectorAll('details.appt-month-group').forEach((group) => {
            const summary = group.querySelector('summary');
            if (!summary || group.dataset.accordionReady === 'true') return;

            group.dataset.accordionReady = 'true';

            summary.addEventListener('click', function (event) {
                event.preventDefault();

                if (group.dataset.animating === 'true') return;

                if (group.open) {
                    group.dataset.animating = 'true';
                    group.classList.add('is-closing');

                    setTimeout(() => {
                        group.open = false;
                        group.classList.remove('is-closing');
                        group.dataset.animating = 'false';
                    }, 220);

                    return;
                }

                group.open = true;
                group.dataset.animating = 'true';
                group.classList.remove('is-closing');
                group.classList.add('is-opening');

                setTimeout(() => {
                    group.classList.remove('is-opening');
                    group.dataset.animating = 'false';
                }, 280);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.initGlobalVoiceInputs?.();
        window.initGlobalViewToggles?.();

        apptSearchInput = document.getElementById('apptSearchInput');
        apptStatusFilter = document.getElementById('apptStatusFilter');

        apptSearchInput?.addEventListener('input', applyAppointmentFilters);
        apptStatusFilter?.addEventListener('change', function () {
            setAppointmentStatusFilter(apptStatusFilter.value || 'all', true, 'dropdown');
        });

        hydratePastCancellationReasons();
        setupAppointmentStatusDropdown();
        setupAppointmentFilterPanel();
        setAppointmentStatusFilter('all', false);
        applyAppointmentFilters();
        updateAppointmentFilterButtonState();
        revealAppointmentContainer?.();
        setupAppointmentAccordions();
        initAppointmentRefreshWatcher();
    });

    function getAppointmentFilterModal() {
        return document.getElementById('filterModal');
    }

    function openAppointmentFilterPanel() {
        const modal = getAppointmentFilterModal();
        if (!modal) return;

        syncAppointmentFilterInputs();
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('filter-lock');
        document.body.classList.add('filter-lock');
        renderAppointmentFilterChips();
        updateAppointmentShowResultsButton();
    }

    function closeAppointmentFilterPanel() {
        const modal = getAppointmentFilterModal();
        if (!modal || modal.classList.contains('closing')) return;

        modal.classList.remove('open');
        modal.classList.add('closing');
        modal.setAttribute('aria-hidden', 'true');

        setTimeout(() => {
            modal.classList.remove('closing');

            if (!document.querySelector('#filterModal.open, #filterModal.closing')) {
                document.documentElement.classList.remove('filter-lock');
                document.body.classList.remove('filter-lock');
            }
        }, 300);
    }

    function setAppointmentPeriodFilter(period = 'upcoming') {
        appointmentPeriodFilter = ['upcoming', 'past', 'all'].includes(period) ? period : 'upcoming';
        document.getElementById('upcomingSection')?.classList.toggle('hidden', appointmentPeriodFilter === 'past');
        document.getElementById('pastSection')?.classList.toggle('hidden', appointmentPeriodFilter === 'upcoming');
    }

    function normalizeAppointmentDate(value) {
        if (!value) return null;
        const date = new Date(value);
        return Number.isNaN(date.getTime()) ? null : date;
    }

    function getAppointmentCards() {
        return Array.from(document.querySelectorAll('.appt-card, .mobile-appt-card'));
    }

    function getUniqueAppointmentCards() {
        const seen = new Set();
        return getAppointmentCards().filter((card) => {
            const key = `${card.dataset.apptId || ''}-${card.dataset.period || ''}`;
            if (seen.has(key)) return false;
            seen.add(key);
            return true;
        });
    }

    function matchesAppointmentFilters(card, draft = null) {
        const filters = draft || {
            period: appointmentPeriodFilter,
            status: appointmentStatusFilter,
            sort: appointmentSortFilter,
            fromDate: appointmentFromDate,
            toDate: appointmentToDate,
        };

        const searchValue = (apptSearchInput?.value || '').toLowerCase().trim();
        const status = normalizeAppointmentStatusFilter(card.dataset.status || '');
        const period = card.dataset.period || '';
        const date = normalizeAppointmentDate(card.dataset.date || '');

        const patient = card.dataset.patient || '';
        const patientId = card.dataset.patientId || '';
        const studentNumber = card.dataset.studentNo || '';
        const program = card.dataset.program || '';
        const service = card.dataset.service || '';

        const matchesSearch = !searchValue ||
            patient.includes(searchValue) ||
            patientId.includes(searchValue) ||
            studentNumber.includes(searchValue) ||
            program.includes(searchValue) ||
            service.includes(searchValue);

        const matchesPeriod = filters.period === 'all' || period === filters.period;
        const matchesStatus = filters.status === 'all' || status === filters.status;

        let matchesDate = true;
        const fromDate = normalizeAppointmentDate(filters.fromDate);
        const toDate = normalizeAppointmentDate(filters.toDate);

        if ((fromDate || toDate) && !date) {
            matchesDate = false;
        } else {
            if (fromDate && date < fromDate) matchesDate = false;
            if (toDate && date > toDate) matchesDate = false;
        }

        return matchesSearch && matchesPeriod && matchesStatus && matchesDate;
    }

    function sortAppointmentGroups() {
        const sortValue = appointmentSortFilter;

        document.querySelectorAll('.appt-month-group').forEach((group) => {
            ['.desktop-appointments-table .space-y-2\\.5', '.mobile-appointments-list'].forEach((selector) => {
                const holder = group.querySelector(selector);
                if (!holder) return;

                const cards = Array.from(holder.querySelectorAll(
                    ':scope > .appt-card, :scope > .mobile-appt-card'));
                cards.sort((a, b) => {
                    const aName = a.dataset.patient || '';
                    const bName = b.dataset.patient || '';
                    const aDate = normalizeAppointmentDate(a.dataset.date || '') || new Date(0);
                    const bDate = normalizeAppointmentDate(b.dataset.date || '') || new Date(0);

                    if (sortValue === 'az') return aName.localeCompare(bName);
                    if (sortValue === 'za') return bName.localeCompare(aName);
                    if (sortValue === 'oldest') return aDate - bDate;
                    return bDate - aDate;
                });

                cards.forEach((card) => holder.appendChild(card));
            });
        });
    }

    function clearAppointmentSearch() {
        if (apptSearchInput) {
            apptSearchInput.value = '';
            apptSearchInput.dispatchEvent(new Event('input', {
                bubbles: true
            }));
            apptSearchInput.dispatchEvent(new Event('change', {
                bubbles: true
            }));
            apptSearchInput.focus();
        }
        applyAppointmentFilters();
    }

    function applyAppointmentFilters() {
        setAppointmentPeriodFilter(appointmentPeriodFilter);

        getAppointmentCards().forEach((card) => {
            card.classList.toggle('hidden', !matchesAppointmentFilters(card));
        });

        sortAppointmentGroups();

        document.querySelectorAll('.appt-month-group').forEach((group) => {
            const cards = Array.from(group.querySelectorAll('.appt-card, .mobile-appt-card'));
            const hasVisibleCard = cards.some((card) => !card.classList.contains('hidden'));
            group.classList.toggle('hidden', !hasVisibleCard);
        });

        updateFilteredEmptyState();
        updateAppointmentFilterButtonState();
    }

    function updateFilteredEmptyState() {
        const searchValue = (apptSearchInput?.value || '').trim();
        const hasSearch = searchValue.length > 0;
        const hasDropdownStatusFilter = appointmentStatusFilterSource !== 'panel' && appointmentStatusFilter !== 'all';

        const hasPanelFilters =
            appointmentSortFilter !== "newest" ||
            !!appointmentFromDate ||
            !!appointmentToDate;

        const upcomingCards = Array.from(document.querySelectorAll(
            '#upcomingSection .appt-card, #upcomingSection .mobile-appt-card'));
        const pastCards = Array.from(document.querySelectorAll(
            '#pastSection .appt-card, #pastSection .mobile-appt-card'));

        const upcomingVisible = upcomingCards.some(card => !card.classList.contains('hidden'));
        const pastVisible = pastCards.some(card => !card.classList.contains('hidden'));

        const upcomingAllowed = appointmentPeriodFilter !== 'past';
        const pastAllowed = appointmentPeriodFilter !== 'upcoming';

        const searchTitle = hasSearch ? `No results for "${searchValue}"` : 'No results found';

        const upcomingSearchEmpty = document.getElementById('appointmentFilterEmptyUpcoming');
        const pastSearchEmpty = document.getElementById('appointmentFilterEmptyPast');
        const upcomingStatusEmpty = document.getElementById('appointmentStatusEmptyUpcoming');
        const pastStatusEmpty = document.getElementById('appointmentStatusEmptyPast');
        const upcomingStaticEmpty = document.getElementById('appointmentStaticEmptyUpcoming');
        const pastStaticEmpty = document.getElementById('appointmentStaticEmptyPast');

        const upcomingSearchTitle = document.getElementById('appointmentFilterEmptyUpcomingTitle');
        const pastSearchTitle = document.getElementById('appointmentFilterEmptyPastTitle');

        if (upcomingSearchTitle) upcomingSearchTitle.textContent = searchTitle;
        if (pastSearchTitle) pastSearchTitle.textContent = searchTitle;

        const statusEmptyCopy = {
            upcoming: {
                icon: 'fa-regular fa-calendar-xmark',
                title: 'No upcoming appointments',
                sub: 'New appointments will appear here once scheduled.'
            },
            rescheduled: {
                icon: 'fa-solid fa-rotate-right',
                title: 'No rescheduled appointments',
                sub: 'Rescheduled appointments will appear here once available.'
            },
            completed: {
                icon: 'fa-solid fa-circle-check',
                title: 'No completed appointments',
                sub: 'Completed appointments will appear here.'
            },
            cancelled: {
                icon: 'fa-regular fa-calendar-xmark',
                title: 'No cancelled appointments',
                sub: 'Cancelled appointments will appear here.'
            },
            all: {
                icon: 'fa-solid fa-sliders',
                title: 'No matches for your filters',
                sub: 'Try removing or adjusting your filter criteria.'
            }
        };

        const meta = hasPanelFilters ?
            statusEmptyCopy.all :
            (statusEmptyCopy[appointmentStatusFilter] || statusEmptyCopy.all);

        function setStatusEmptyContent(prefix) {
            const icon = document.getElementById(`appointmentStatusEmpty${prefix}Icon`);
            const title = document.getElementById(`appointmentStatusEmpty${prefix}Title`);
            const sub = document.getElementById(`appointmentStatusEmpty${prefix}Sub`);

            if (icon) icon.className = meta.icon;
            if (title) title.textContent = meta.title;
            if (sub) sub.textContent = meta.sub;
        }

        function toggleControlled(el, show) {
            if (!el) return;

            el.classList.toggle('show', show);
            el.classList.toggle('is-visible', show);
            el.classList.toggle('hidden', !show);
            el.classList.toggle('is-hidden', !show);
            el.setAttribute('aria-hidden', show ? 'false' : 'true');
        }

        function toggleStaticEmpty(el, show) {
            if (!el) return;

            el.classList.toggle('hidden', !show);
            el.classList.toggle('is-hidden', !show);
            el.setAttribute('aria-hidden', show ? 'false' : 'true');
        }

        setStatusEmptyContent('Upcoming');
        setStatusEmptyContent('Past');

        const showCombinedSearchEmpty =
            appointmentPeriodFilter === 'all' &&
            hasSearch &&
            !upcomingVisible &&
            !pastVisible;

        const showUpcomingSearchEmpty =
            hasSearch &&
            (
                showCombinedSearchEmpty ||
                (
                    appointmentPeriodFilter === 'upcoming' &&
                    !upcomingVisible
                )
            );

        const showPastSearchEmpty =
            hasSearch &&
            appointmentPeriodFilter === 'past' &&
            !pastVisible;

        const showCombinedPanelEmpty =
            appointmentPeriodFilter === 'all' &&
            !hasSearch &&
            hasPanelFilters &&
            !upcomingVisible &&
            !pastVisible;

        const showUpcomingStatusEmpty =
            !hasSearch &&
            (
                showCombinedPanelEmpty ||
                (
                    appointmentPeriodFilter === 'upcoming' &&
                    (hasPanelFilters || hasDropdownStatusFilter) &&
                    !upcomingVisible
                )
            );

        const showPastStatusEmpty =
            !hasSearch &&
            appointmentPeriodFilter === 'past' &&
            (hasPanelFilters || hasDropdownStatusFilter) &&
            !pastVisible;

        const upcomingSection = document.getElementById('upcomingSection');
        const pastSection = document.getElementById('pastSection');

        if (appointmentPeriodFilter === 'all' && (hasSearch || hasPanelFilters)) {
            const noCombinedResults = !upcomingVisible && !pastVisible;

            upcomingSection?.classList.toggle('hidden', false);
            pastSection?.classList.toggle('hidden', noCombinedResults);
        }
        const isDefaultState = !hasSearch &&
            !hasPanelFilters &&
            !hasDropdownStatusFilter &&
            appointmentStatusFilter === 'all';

        const showUpcomingStaticEmpty =
            upcomingAllowed &&
            isDefaultState &&
            upcomingCards.length === 0 &&
            pastCards.length === 0;

        const showPastStaticEmpty =
            pastAllowed &&
            isDefaultState &&
            pastCards.length === 0;

        toggleStaticEmpty(upcomingStaticEmpty, showUpcomingStaticEmpty);
        toggleStaticEmpty(pastStaticEmpty, showPastStaticEmpty);

        toggleControlled(upcomingSearchEmpty, showUpcomingSearchEmpty);
        toggleControlled(pastSearchEmpty, showPastSearchEmpty);
        toggleControlled(upcomingStatusEmpty, showUpcomingStatusEmpty);
        toggleControlled(pastStatusEmpty, showPastStatusEmpty);

        document.querySelectorAll(
            ".appointment-panel-empty-clear"
        ).forEach(function (button) {
            button.hidden = !hasPanelFilters;

            button.classList.toggle(
                "hidden",
                !hasPanelFilters
            );

            button.classList.toggle(
                "is-hidden",
                !hasPanelFilters
            );

            button.style.display =
                hasPanelFilters
                    ? "inline-flex"
                    : "none";
        });
    }

    function getDraftAppointmentFilters() {
        const activeSort = document.querySelector('#apptSortGroup .ftag.ftag-active');

        return {
            sort: activeSort?.dataset.sort || "newest",
            period: "all",
            status: "all",
            fromDate:
                document.getElementById("fromDate")?.value || "",
            toDate:
                document.getElementById("toDate")?.value || ""
        };
    }

    function countDraftAppointmentResults() {
        const draft = getDraftAppointmentFilters();
        return getUniqueAppointmentCards().filter((card) => matchesAppointmentFilters(card, draft)).length;
    }

    function updateAppointmentShowResultsButton() {
        const showResultsText = document.getElementById('showResultsText');
        if (!showResultsText) return;
        const count = countDraftAppointmentResults();
        showResultsText.textContent = `Show ${count} ${count === 1 ? 'result' : 'results'}`;
    }

    function updateAppointmentFilterButtonState() {
        const badge = document.getElementById('appointmentFilterBadge');
        const filterBtn = document.getElementById('appointmentFilterBtn');
        const clearBtn = document.getElementById('appointmentClearFilterBtn');
        const activeCount = [
            !!appointmentFromDate || !!appointmentToDate,
            appointmentSortFilter !== 'newest',
        ].filter(Boolean).length;

        if (badge) {
            badge.textContent = activeCount;
            badge.style.display = activeCount ? 'inline-flex' : 'none';
        }

        filterBtn?.classList.toggle('has-filters', activeCount > 0);
        filterBtn?.setAttribute('aria-pressed', activeCount > 0 ? 'true' : 'false');
        clearBtn?.classList.toggle('hidden', activeCount === 0);
    }

    function renderAppointmentFilterChips() {
        const container = document.getElementById('activeChipsContainer');
        const section = document.getElementById('activeFiltersSection');
        if (!container || !section) return;

        container.innerHTML = '';
        let hasChips = false;

        function addChip(label, callback) {
            hasChips = true;
            const chip = document.createElement('div');
            chip.className = 'filter-chip';
            chip.innerHTML =
                `<span>${label}</span><span class="filter-chip-remove"><i class="fa-solid fa-xmark"></i></span>`;
            chip.querySelector('.filter-chip-remove').onclick = function () {
                callback();
                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();
            };
            container.appendChild(chip);
        }

        const draft = getDraftAppointmentFilters();

        if (draft.sort !== 'newest') {
            const sortLabel = document.querySelector(`#apptSortGroup .ftag[data-sort="${draft.sort}"]`)?.textContent
                .trim() || draft.sort;
            addChip(`Sort: ${sortLabel}`, function () {
                document.querySelectorAll('#apptSortGroup .ftag').forEach(btn => btn.classList.remove(
                    'ftag-active'));
                document.querySelector('#apptSortGroup .ftag[data-sort="newest"]')?.classList.add(
                    'ftag-active');
            });
        }

        if (draft.fromDate || draft.toDate) {
            addChip(`Date: ${draft.fromDate || 'Any'} to ${draft.toDate || 'Any'}`, function () {
                const from = document.getElementById('fromDate');
                const to = document.getElementById('toDate');
                if (from) from.value = '';
                if (to) to.value = '';
                document.querySelectorAll('#datePresetGroup .quick-date-chip').forEach(btn => btn.classList
                    .remove('active'));
            });
        }

        section.classList.toggle('hidden', !hasChips);
    }

    function syncAppointmentFilterInputs() {
        document.querySelectorAll('#apptSortGroup .ftag').forEach(btn => {
            btn.classList.toggle('ftag-active', btn.dataset.sort === appointmentSortFilter);
        });

        const from = document.getElementById('fromDate');
        const to = document.getElementById('toDate');

        if (from) from.value = appointmentFromDate;
        if (to) to.value = appointmentToDate;
    }

    function resetAppointmentPanelFilters(
        shouldApply = true
    ) {
        appointmentSortFilter = "newest";
        appointmentFromDate = "";
        appointmentToDate = "";

        syncAppointmentFilterInputs();

        document.querySelectorAll(
            "#datePresetGroup .quick-date-chip"
        ).forEach(function (button) {
            button.classList.remove("active");
        });

        renderAppointmentFilterChips();

        if (shouldApply) {
            applyAppointmentFilters();
        }
    }

    function resetAppointmentFilters() {
        appointmentPeriodFilter = "all";
        appointmentStatusFilter = "all";
        appointmentStatusFilterSource = "dropdown";

        resetAppointmentPanelFilters(false);

        setAppointmentStatusFilter(
            "all",
            false,
            "dropdown"
        );

        applyAppointmentFilters();
    }

    function setupAppointmentFilterPanel() {
        const filterModal = getAppointmentFilterModal();
        const closeBtn = document.getElementById('closeFilterModalBtn');
        const cancelBtn = document.getElementById('cancelFilterBtn');
        const applyBtn = document.getElementById('applyFilters');
        const clearBtn = document.getElementById('clearFiltersModal');
        const clearAllBtn = document.getElementById('clearAllChipsBtn');

        closeBtn?.addEventListener('click', closeAppointmentFilterPanel);
        cancelBtn?.addEventListener('click', closeAppointmentFilterPanel);

        document.querySelectorAll('#apptSortGroup .ftag').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#apptSortGroup .ftag').forEach(item => item.classList.remove(
                    'ftag-active'));
                btn.classList.add('ftag-active');
                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();
            });
        });

        filterModal?.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', function () {
                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();
            });
        });

        filterModal?.querySelectorAll('#fromDate, #toDate').forEach(input => {
            input.addEventListener('change', function () {
                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();
            });
        });

        document.querySelectorAll('#datePresetGroup .quick-date-chip').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#datePresetGroup .quick-date-chip').forEach(item => item
                    .classList.remove('active'));
                btn.classList.add('active');

                const days = parseInt(btn.dataset.range || '0', 10);
                const toDate = new Date();
                const fromDate = new Date();
                fromDate.setDate(toDate.getDate() - days);

                const formatDate = (date) => date.toISOString().slice(0, 10);
                const from = document.getElementById('fromDate');
                const to = document.getElementById('toDate');
                if (from) from.value = formatDate(fromDate);
                if (to) to.value = formatDate(toDate);

                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();
            });
        });

        applyBtn?.addEventListener("click", function () {
            const draft = getDraftAppointmentFilters();

            appointmentSortFilter = draft.sort;
            appointmentFromDate = draft.fromDate;
            appointmentToDate = draft.toDate;
            appointmentPeriodFilter = "all";

            setAppointmentStatusFilter(
                "all",
                false,
                "dropdown"
            );

            applyAppointmentFilters();
            closeAppointmentFilterPanel();
        });

        clearBtn?.addEventListener("click", function () {
            resetAppointmentPanelFilters();
            openAppointmentFilterPanel();
        });

        clearAllBtn?.addEventListener("click", function () {
            resetAppointmentPanelFilters();
            openAppointmentFilterPanel();
        });
    }

    function revealAppointmentContainer() {
        const skeleton = document.getElementById('appointmentContainerSkeleton');
        const content = document.getElementById('appointmentContainerContent');

        setTimeout(() => {
            skeleton?.classList.add('is-hidden');
            content?.classList.remove('is-skeleton-hidden');
            content?.classList.add('is-ready');
        }, 320);
    }
</script>
@endsection