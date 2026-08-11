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
->map(
fn($appointment) => [
'id' => $appointment->id,
'updated_at' => optional($appointment->updated_at)->toISOString(),
],
)
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

$appointmentStatusOptions = [
[
'value' => 'all',
'label' => 'All statuses',
'icon' => 'fa-layer-group',
'tone' => 'status-all',
'count' => $statusCounts['all'] ?? 0,
],
[
'value' => 'upcoming',
'label' => 'Upcoming',
'icon' => 'fa-calendar-check',
'tone' => 'status-upcoming',
'count' => $statusCounts['upcoming'] ?? 0,
],
[
'value' => 'rescheduled',
'label' => 'Rescheduled',
'icon' => 'fa-rotate-right',
'tone' => 'status-rescheduled',
'count' => $statusCounts['rescheduled'] ?? 0,
],
[
'value' => 'completed',
'label' => 'Completed',
'icon' => 'fa-circle-check',
'tone' => 'status-completed',
'count' => $statusCounts['completed'] ?? 0,
],
[
'value' => 'cancelled',
'label' => 'Cancelled',
'icon' => 'fa-circle-xmark',
'tone' => 'status-cancelled',
'count' => $statusCounts['cancelled'] ?? 0,
],
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
                        <x-search-bar id="apptSearchInput" placeholder="Search patient"
                            callback="handleAppointmentSearch" :debounce="250" class="flex-1" />

                        <x-voice-input target="#apptSearchInput" status-id="apptVoiceStatus"
                            label="Voice search appointments" title="Voice search" />
                    </div>

                    <x-filter-select id="appointmentStatusFilter" name="appointment_status" label="Status" value="all"
                        :options="$appointmentStatusOptions" callback="handleAppointmentStatusSelect" />
                </div>

                <div class="appointment-controls-actions">
                    <div class="appointment-filter-actions">
                        <button id="appointmentFilterBtn" type="button" class="global-filter-btn">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Filter</span>
                            <span id="appointmentFilterBadge" class="filter-badge" style="display:none;"></span>
                        </button>
                    </div>

                    <x-view-toggle id="appointmentsViewToggle" root="#mainContent" storage-key="appointmentsViewMode"
                        list-label="List" grid-label="Grid" />

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
                        class="table-list-header appt-table-head appointment-table-grid grid gap-4 py-3 px-5 rounded-t-2xl mb-3">
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

                        $isWalkInAppointment = (bool) ($appt->is_walk_in ?? false);

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

                        $isFacultyPatient = filled($patient?->faculty_code);

                        if ($isFacultyPatient) {
                        $program = 'Faculty';
                        $programFull = 'Faculty';
                        } else {
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
                        }

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
                        $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                        $pastStatusLabel = $pastStatusBase;
                        $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                        $recordProcedure = $appt->procedure;
                        $recordFollowUp = $appt->followUpAppointments
                        ->sortBy(
                        fn($followUpAppt) => sprintf(
                        '%s %s',
                        $followUpAppt->appointment_date ?? '',
                        $followUpAppt->appointment_time ?? '',
                        ),
                        )
                        ->first();
                        $recordDuration = $recordProcedure?->procedure_duration_seconds;
                        $recordRemarks =
                        $recordProcedure?->completion_action ??
                        ($appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? '')));
                        $recordOral = $recordProcedure?->oral_examination ?? '';
                        $recordDiagnosis = $recordProcedure?->diagnosis ?? '';
                        $recordPrescription = $recordProcedure?->prescriptions ?? '';
                        $recordFollowUpPayload = $recordFollowUp
                        ? [
                        'date' => $recordFollowUp->appointment_date
                        ? \Carbon\Carbon::parse($recordFollowUp->appointment_date)->format(
                        'F j, Y',
                        )
                        : 'N/A',
                        'time' => $recordFollowUp->appointment_time
                        ? \Carbon\Carbon::parse($recordFollowUp->appointment_time)->format(
                        'g:i A',
                        )
                        : 'N/A',
                        'service' =>
                        ($recordFollowUp->service_type ?? '') === 'Others'
                        ? ($recordFollowUp->other_services ?:
                        'Others')
                        : $recordFollowUp->service_type ?? 'Follow-up',
                        'status' => $recordFollowUp->status ?? 'upcoming',
                        'reason' => $recordFollowUp->follow_up_reason,
                        ]
                        : null;
                        $recordOdontogramData = $recordProcedure?->odontogram_data ?? [];
                        @endphp

                        <div class="appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
                            data-period="upcoming" data-date="{{ $appt->appointment_date }}"
                            data-patient="{{ strtolower($patientName) }}"
                            data-student-no="{{ strtolower($studentNumber) }}"
                            data-program="{{ strtolower($programFull) }}" data-service="{{ strtolower($serviceLabel) }}"
                            data-patient-id="{{ strtolower((string) ($appt->patient_id ?? '')) }}"
                            data-status="{{ strtolower($appt->status ?? 'upcoming') === 'reschedule' ? 'rescheduled' : strtolower($appt->status ?? 'upcoming') }}"
                            style="animation-delay:{{ $i * 0.04 }}s">

                            <div class="appointment-table-grid grid gap-4 items-center px-5 py-3.5">

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
                                    @php
                                    $patientImage = optional($appt->patient)->profile_image
                                    ? asset('storage/' . optional($appt->patient)->profile_image)
                                    : '';
                                    @endphp

                                    <span class="patient-avatar patient-avatar-md" data-patient-avatar
                                        data-patient-name="{{ $patientName }}"
                                        data-patient-url="{{ $patientImage }}"></span>
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

                    $isWalkInAppointment = (bool) ($appt->is_walk_in ?? false);

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

                    $isFacultyPatient = filled($patient?->faculty_code);

                    if ($isFacultyPatient) {
                    $program = 'Faculty';
                    $programFull = 'Faculty';
                    } else {
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
                    }

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
                    $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                    $pastStatusLabel = $pastStatusBase;
                    $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                    $recordProcedure = $appt->procedure;
                    $recordFollowUp = $appt->followUpAppointments
                    ->sortBy(
                    fn($followUpAppt) => sprintf(
                    '%s %s',
                    $followUpAppt->appointment_date ?? '',
                    $followUpAppt->appointment_time ?? '',
                    ),
                    )
                    ->first();
                    $recordDuration = $recordProcedure?->procedure_duration_seconds;
                    $recordRemarks =
                    $recordProcedure?->completion_action ??
                    ($appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? '')));
                    $recordOral = $recordProcedure?->oral_examination ?? '';
                    $recordDiagnosis = $recordProcedure?->diagnosis ?? '';
                    $recordPrescription = $recordProcedure?->prescriptions ?? '';
                    $recordFollowUpPayload = $recordFollowUp
                    ? [
                    'date' => $recordFollowUp->appointment_date
                    ? \Carbon\Carbon::parse($recordFollowUp->appointment_date)->format(
                    'F j, Y',
                    )
                    : 'N/A',
                    'time' => $recordFollowUp->appointment_time
                    ? \Carbon\Carbon::parse($recordFollowUp->appointment_time)->format(
                    'g:i A',
                    )
                    : 'N/A',
                    'service' =>
                    ($recordFollowUp->service_type ?? '') === 'Others'
                    ? ($recordFollowUp->other_services ?:
                    'Others')
                    : $recordFollowUp->service_type ?? 'Follow-up',
                    'status' => $recordFollowUp->status ?? 'upcoming',
                    'reason' => $recordFollowUp->follow_up_reason,
                    ]
                    : null;
                    $recordOdontogramData = $recordProcedure?->odontogram_data ?? [];
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
                                        {{ $patientName }}
                                    </p>

                                    @if ($isWalkInAppointment)
                                    <span class="ui-action-btn ui-action-neutral ui-action-indicator"
                                        data-tooltip="Walk-in appointment" data-tooltip-tone="neutral"
                                        aria-label="Walk-in appointment" tabindex="0">
                                        <i class="fa-solid fa-person-walking"></i>
                                    </span>
                                    @endif

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
                        class="table-list-header appt-table-head appointment-table-grid grid gap-4 py-3 px-5 rounded-t-2xl mb-3">
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

                        $isWalkInAppointment = (bool) ($appt->is_walk_in ?? false);

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

                        $isFacultyPatient = filled($patient?->faculty_code);

                        if ($isFacultyPatient) {
                        $program = 'Faculty';
                        $programFull = 'Faculty';
                        } else {
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
                        }

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
                        $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                        $pastStatusLabel = $pastStatusBase;
                        $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                        $recordProcedure = $appt->procedure;
                        $recordFollowUp = $appt->followUpAppointments
                        ->sortBy(
                        fn($followUpAppt) => sprintf(
                        '%s %s',
                        $followUpAppt->appointment_date ?? '',
                        $followUpAppt->appointment_time ?? '',
                        ),
                        )
                        ->first();
                        $recordDuration = $recordProcedure?->procedure_duration_seconds;
                        $recordRemarks =
                        $recordProcedure?->completion_action ??
                        ($appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? '')));
                        $recordOral = $recordProcedure?->oral_examination ?? '';
                        $recordDiagnosis = $recordProcedure?->diagnosis ?? '';
                        $recordPrescription = $recordProcedure?->prescriptions ?? '';
                        $recordFollowUpPayload = $recordFollowUp
                        ? [
                        'date' => $recordFollowUp->appointment_date
                        ? \Carbon\Carbon::parse($recordFollowUp->appointment_date)->format(
                        'F j, Y',
                        )
                        : 'N/A',
                        'time' => $recordFollowUp->appointment_time
                        ? \Carbon\Carbon::parse($recordFollowUp->appointment_time)->format(
                        'g:i A',
                        )
                        : 'N/A',
                        'service' =>
                        ($recordFollowUp->service_type ?? '') === 'Others'
                        ? ($recordFollowUp->other_services ?:
                        'Others')
                        : $recordFollowUp->service_type ?? 'Follow-up',
                        'status' => $recordFollowUp->status ?? 'upcoming',
                        'reason' => $recordFollowUp->follow_up_reason,
                        ]
                        : null;
                        $recordOdontogramData = $recordProcedure?->odontogram_data ?? [];
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
                                    @php
                                    $patientImage = optional($appt->patient)->profile_image
                                    ? asset('storage/' . optional($appt->patient)->profile_image)
                                    : '';
                                    @endphp

                                    <span class="patient-avatar patient-avatar-md" data-patient-avatar
                                        data-patient-name="{{ $patientName }}"
                                        data-patient-url="{{ $patientImage }}"></span>
                                    <div class="text-left min-w-0">

                                        <div class="appt-patient-name-row">

                                            <p class="appt-patient-name">
                                                {{ $patientName }}
                                            </p>

                                            @if ($isWalkInAppointment)
                                            <span class="ui-action-btn ui-action-neutral ui-action-indicator"
                                                data-tooltip="Walk-in appointment" data-tooltip-tone="neutral"
                                                aria-label="Walk-in appointment" tabindex="0">
                                                <i class="fa-solid fa-person-walking"></i>
                                            </span>
                                            @endif

                                        </div>

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
                                        data-appt-id="{{ $appt->id }}" data-status-base="{{ $pastStatusBase }}"><span
                                            class="status-dot"></span><span class="past-status-text">{{ $pastStatusLabel
                                            }}</span></span>
                                </div>

                                <div class="appt-actions-wrap ui-action-group">

                                    @if ($canViewTreatmentRecord)
                                    <button type="button" class="ui-action-btn ui-action-neutral"
                                        data-tooltip="View details" onclick="openRecordModal(this)"
                                        data-appt-id="{{ $appt->id }}" data-service="{{ $serviceLabel }}"
                                        data-date="{{ $dateLabel }}" data-time="{{ $timeLabel }}"
                                        data-status="{{ $pastStatusLabel }}"
                                        data-duration-seconds="{{ $recordDuration }}"
                                        data-remarks="{{ $recordRemarks }}" data-oral="{{ $recordOral }}"
                                        data-diagnosis="{{ $recordDiagnosis }}"
                                        data-prescription="{{ $recordPrescription }}"
                                        data-follow-up='@json($recordFollowUpPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                        data-odontogram-data='@json($recordOdontogramData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'>

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

                    $isWalkInAppointment = (bool) ($appt->is_walk_in ?? false);

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

                    $isFacultyPatient = filled($patient?->faculty_code);

                    if ($isFacultyPatient) {
                    $program = 'Faculty';
                    $programFull = 'Faculty';
                    } else {
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
                    }

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
                    $pastStatusBase = $isCancelledPast ? 'Cancelled' : 'Completed';
                    $pastStatusLabel = $pastStatusBase;
                    $pastStatusClass = $isCancelledPast ? 'status-cancelled' : 'status-completed';
                    $recordProcedure = $appt->procedure;
                    $recordFollowUp = $appt->followUpAppointments
                    ->sortBy(
                    fn($followUpAppt) => sprintf(
                    '%s %s',
                    $followUpAppt->appointment_date ?? '',
                    $followUpAppt->appointment_time ?? '',
                    ),
                    )
                    ->first();
                    $recordDuration = $recordProcedure?->procedure_duration_seconds;
                    $recordRemarks =
                    $recordProcedure?->completion_action ??
                    ($appt->remarks ?? ($appt->treatment_notes ?? ($appt->notes ?? '')));
                    $recordOral = $recordProcedure?->oral_examination ?? '';
                    $recordDiagnosis = $recordProcedure?->diagnosis ?? '';
                    $recordPrescription = $recordProcedure?->prescriptions ?? '';
                    $recordFollowUpPayload = $recordFollowUp
                    ? [
                    'date' => $recordFollowUp->appointment_date
                    ? \Carbon\Carbon::parse($recordFollowUp->appointment_date)->format(
                    'F j, Y',
                    )
                    : 'N/A',
                    'time' => $recordFollowUp->appointment_time
                    ? \Carbon\Carbon::parse($recordFollowUp->appointment_time)->format(
                    'g:i A',
                    )
                    : 'N/A',
                    'service' =>
                    ($recordFollowUp->service_type ?? '') === 'Others'
                    ? ($recordFollowUp->other_services ?:
                    'Others')
                    : $recordFollowUp->service_type ?? 'Follow-up',
                    'status' => $recordFollowUp->status ?? 'upcoming',
                    'reason' => $recordFollowUp->follow_up_reason,
                    ]
                    : null;
                    $recordOdontogramData = $recordProcedure?->odontogram_data ?? [];
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

                                    <div class="flex items-center gap-2 flex-wrap mb-1">

                                        <p
                                            class="mobile-patient-name text-[15px] font-extrabold text-gray-800 leading-snug">
                                            {{ $patientName }}
                                        </p>

                                        @if ($isWalkInAppointment)
                                        <span class="ui-action-btn ui-action-neutral ui-action-indicator"
                                            data-tooltip="Walk-in appointment" data-tooltip-tone="neutral"
                                            aria-label="Walk-in appointment" tabindex="0">
                                            <i class="fa-solid fa-person-walking"></i>
                                        </span>
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

                                <span class="status-pill {{ $pastStatusClass }} past-status-pill flex-shrink-0"
                                    data-appt-id="{{ $appt->id }}" data-status-base="{{ $pastStatusBase }}">
                                    <span class="status-dot"></span>
                                    <span class="past-status-text">
                                        {{ $pastStatusLabel }}
                                    </span>
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
                                @if ($canViewTreatmentRecord)
                                <button type="button" class="ui-action-btn ui-action-neutral"
                                    data-tooltip="View details" onclick="openRecordModal(this)"
                                    data-appt-id="{{ $appt->id }}" data-service="{{ $serviceLabel }}"
                                    data-date="{{ $dateLabel }}" data-time="{{ $timeLabel }}"
                                    data-status="{{ $pastStatusLabel }}" data-duration-seconds="{{ $recordDuration }}"
                                    data-remarks="{{ $recordRemarks }}" data-oral="{{ $recordOral }}"
                                    data-diagnosis="{{ $recordDiagnosis }}"
                                    data-prescription="{{ $recordPrescription }}"
                                    data-follow-up='@json($recordFollowUpPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                    data-odontogram-data='@json($recordOdontogramData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'>
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
        @endforelse
    </section>
    <div id="appointmentEmptyState" class="empty-state-host">
    </div>
</main>

<x-filter-drawer id="filterModal" title="Filters" close-id="closeFilterModalBtn"
    close-callback="window.closeFilterDrawer?.('filterModal')" clear-id="clearFiltersModal" clear-label="Clear Filters"
    cancel-id="cancelFilterBtn" cancel-callback="window.closeFilterDrawer?.('filterModal')" cancel-label="Cancel"
    apply-id="applyFilters" apply-callback="applyAppointmentDrawerFilters()" apply-label="Show 0 results"
    results-id="showResultsText">

    <div id="activeFiltersSection" class="filter-active-section hidden">

        <div class="filter-active-header">
            <span class="filter-active-title">
                Active Filters
            </span>

            <button id="clearAllChipsBtn" type="button" class="filter-clear-all ui-btn ui-btn-secondary ui-btn-sm">

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
                <input id="fromDate" type="text" class="js-flatpickr-date-range-from" placeholder="Start date" readonly
                    autocomplete="off">

                <i class="fa-regular fa-calendar"></i>
            </div>

            <div class="filter-date-input-wrap">
                <input id="toDate" type="text" class="js-flatpickr-date-range-to" placeholder="End date" readonly
                    autocomplete="off">

                <i class="fa-regular fa-calendar"></i>
            </div>
        </div>
    </div>

</x-filter-drawer>

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

                return Array.isArray(payload?.appointments) ?
                    payload.appointments : [];
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

    const statusEmptyCopy = {
        all: {
            icon: 'fa-filter-circle-xmark',
            title: 'No appointments found',
            sub: 'No appointments match the selected filters.'
        },

        upcoming: {
            icon: 'fa-calendar-check',
            title: 'No upcoming appointments',
            sub: 'No upcoming appointments match the selected filters.'
        },

        rescheduled: {
            icon: 'fa-rotate-right',
            title: 'No rescheduled appointments',
            sub: 'No rescheduled appointments match the selected filters.'
        },

        completed: {
            icon: 'fa-circle-check',
            title: 'No completed appointments',
            sub: 'No completed appointments match the selected filters.'
        },

        cancelled: {
            icon: 'fa-circle-xmark',
            title: 'No cancelled appointments',
            sub: 'No cancelled appointments match the selected filters.'
        }
    };

    function setAppointmentStatusFilter(
        value = 'all',
        shouldApply = true,
        source = 'dropdown'
    ) {
        const nextValue =
            apptStatusMeta[value] ?
                value :
                'all';

        appointmentStatusFilter =
            nextValue;

        appointmentStatusFilterSource =
            source;


        if (source === 'dropdown') {
            appointmentPeriodFilter =
                nextValue === 'all' ?
                    'all' :
                    ['completed', 'cancelled']
                        .includes(nextValue) ?
                        'past' :
                        'upcoming';
        }

        window.setGlobalFilterSelectValue?.(
            'appointmentStatusFilter',
            nextValue, {
            callback: false,
            focus: false
        }
        );

        if (shouldApply) {
            applyAppointmentFilters();
        }
    }

    window.handleAppointmentStatusSelect =
        function (value) {
            const nextValue =
                apptStatusMeta[value]
                    ? value
                    : 'all';

            if (apptSearchInput) {
                apptSearchInput.value = '';

                window.syncInputClearButton?.(
                    apptSearchInput
                );
            }

            appointmentStatusFilter =
                nextValue;

            appointmentPeriodFilter =
                nextValue === 'all'
                    ? 'all'
                    : (
                        [
                            'completed',
                            'cancelled'
                        ].includes(nextValue)
                            ? 'past'
                            : 'upcoming'
                    );

            applyAppointmentFilters();
        };

    window.handleAppointmentSearch =
        function (value) {
            const query =
                String(value || '')
                    .trim();

            if (
                query &&
                appointmentStatusFilter !==
                'all'
            ) {
                setAppointmentStatusFilter(
                    'all',
                    false,
                    'dropdown'
                );
            }

            appointmentPeriodFilter =
                'all';

            applyAppointmentFilters();
        };

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

    document.addEventListener(
        'DOMContentLoaded',
        () => {
            window.initGlobalVoiceInputs?.();
            window.initGlobalViewToggles?.();
            window.initGlobalSearchBars?.();
            window.initGlobalFilterSelects?.();

            apptSearchInput =
                document.getElementById(
                    'apptSearchInput'
                );

            setupAppointmentFilterPanel();

            const initialStatus =
                document.getElementById(
                    'appointmentStatusFilterInput'
                )?.value || 'all';

            setAppointmentStatusFilter(
                initialStatus,
                false,
                'dropdown'
            );

            applyAppointmentFilters();
            updateAppointmentFilterButtonState();
            revealAppointmentContainer?.();
            setupAppointmentAccordions();
            initAppointmentRefreshWatcher();
        }
    );

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

    function matchesAppointmentFilters(
        card,
        filters = null
    ) {
        if (!card) {
            return false;
        }

        const appliedFilters =
            filters || {
                period:
                    appointmentPeriodFilter,

                status:
                    appointmentStatusFilter,

                sort:
                    appointmentSortFilter,

                fromDate:
                    appointmentFromDate,

                toDate:
                    appointmentToDate,
            };

        const searchValue =
            String(
                apptSearchInput?.value || ''
            )
                .trim()
                .toLowerCase();

        const status =
            normalizeAppointmentStatusFilter(
                card.dataset.status || ''
            );

        const period =
            card.dataset.period || '';

        const date =
            normalizeAppointmentDate(
                card.dataset.date || ''
            );

        const patient =
            card.dataset.patient || '';

        const patientId =
            card.dataset.patientId || '';

        const studentNumber =
            card.dataset.studentNo || '';

        const program =
            card.dataset.program || '';

        const service =
            card.dataset.service || '';

        const matchesSearch =
            !searchValue ||
            patient.includes(searchValue) ||
            patientId.includes(searchValue) ||
            studentNumber.includes(searchValue) ||
            program.includes(searchValue) ||
            service.includes(searchValue);

        const matchesPeriod =
            appliedFilters.period === 'all' ||
            period === appliedFilters.period;

        const matchesStatus =
            appliedFilters.status === 'all' ||
            status === appliedFilters.status;

        let matchesDate = true;

        const fromDate =
            normalizeAppointmentDate(
                appliedFilters.fromDate
            );

        const toDate =
            normalizeAppointmentDate(
                appliedFilters.toDate
            );

        if (
            (fromDate || toDate) &&
            !date
        ) {
            matchesDate = false;
        } else {
            if (
                fromDate &&
                date < fromDate
            ) {
                matchesDate = false;
            }

            if (
                toDate &&
                date > toDate
            ) {
                matchesDate = false;
            }
        }

        return (
            matchesSearch &&
            matchesPeriod &&
            matchesStatus &&
            matchesDate
        );
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
        const cards =
            getAppointmentCards();

        cards.forEach(function (card) {
            const isVisible =
                matchesAppointmentFilters(card);

            card.hidden =
                !isVisible;

            card.classList.toggle(
                'hidden',
                !isVisible
            );
        });

        sortAppointmentGroups();

        document
            .querySelectorAll(
                '.appt-month-group'
            )
            .forEach(function (group) {
                const groupCards =
                    Array.from(
                        group.querySelectorAll(
                            '.appt-card, .mobile-appt-card'
                        )
                    );

                const hasVisibleCard =
                    groupCards.some(
                        card => !card.hidden
                    );

                group.hidden =
                    !hasVisibleCard;

                group.classList.toggle(
                    'hidden',
                    !hasVisibleCard
                );
            });

        updateFilteredEmptyState();
        updateAppointmentFilterButtonState();
    }

    function updateFilteredEmptyState() {
        const host =
            document.getElementById(
                'appointmentEmptyState'
            );

        const upcomingSection =
            document.getElementById(
                'upcomingSection'
            );

        const pastSection =
            document.getElementById(
                'pastSection'
            );

        const rawSearchValue =
            String(
                apptSearchInput?.value || ''
            ).trim();

        const hasSearch =
            rawSearchValue !== '';

        const hasStatusFilter =
            appointmentStatusFilter !==
            'all';

        const hasAdvancedFilters =
            appointmentSortFilter !==
            'newest' ||
            !!appointmentFromDate ||
            !!appointmentToDate;

        const uniqueCards =
            getUniqueAppointmentCards();

        const matchingCards =
            uniqueCards.filter(
                card =>
                    matchesAppointmentFilters(
                        card
                    )
            );

        const upcomingMatches =
            matchingCards.filter(
                card =>
                    card.dataset.period ===
                    'upcoming'
            );

        const pastMatches =
            matchingCards.filter(
                card =>
                    card.dataset.period ===
                    'past'
            );

        window.EmptyState?.hide?.(
            host
        );

        const hasResults =
            matchingCards.length > 0;

        if (hasResults) {
            const showUpcoming =
                upcomingMatches.length > 0;

            const showPast =
                pastMatches.length > 0;

            upcomingSection?.classList.toggle(
                'hidden',
                !showUpcoming
            );

            pastSection?.classList.toggle(
                'hidden',
                !showPast
            );

            return;
        }

        upcomingSection?.classList.add(
            'hidden'
        );

        pastSection?.classList.add(
            'hidden'
        );

        if (hasSearch) {
            window.EmptyState?.renderSearch({
                host:
                    '#appointmentEmptyState',

                input:
                    '#apptSearchInput',

                query:
                    rawSearchValue,

                message:
                    'Try a different patient name, service, program, or appointment status.'
            });

            return;
        }

        if (hasAdvancedFilters) {
            window.EmptyState?.render({
                host:
                    '#appointmentEmptyState',

                icon:
                    'fa-filter-circle-xmark',

                title:
                    'No appointments found',

                message:
                    'No appointments match the selected filters.',

                actionHtml: `
                <button
                    type="button"
                    class="empty-state-btn"
                    data-appointment-clear-filters>
                    <i class="fa-solid fa-rotate-left"></i>
                    Clear filters
                </button>
            `
            });

            document
                .querySelector(
                    '#appointmentEmptyState ' +
                    '[data-appointment-clear-filters]'
                )
                ?.addEventListener(
                    'click',
                    function () {
                        resetAppointmentPanelFilters();
                    }
                );

            return;
        }

        if (hasStatusFilter) {
            const copy =
                statusEmptyCopy[
                appointmentStatusFilter
                ] ||
                statusEmptyCopy.all;

            window.EmptyState?.render({
                host:
                    '#appointmentEmptyState',

                icon:
                    copy.icon,

                title:
                    copy.title,

                message:
                    copy.sub
            });

            return;
        }

        window.EmptyState?.render({
            host:
                '#appointmentEmptyState',

            icon:
                'fa-calendar-xmark',

            title:
                'No appointments yet',

            message:
                'Appointments will appear here once scheduled.'
        });
    }

    function getDraftAppointmentFilters() {
        const activeSort =
            document.querySelector(
                '#apptSortGroup .ftag.ftag-active'
            );

        return {
            sort:
                activeSort?.dataset.sort ||
                'newest',

            period:
                appointmentPeriodFilter,

            status:
                appointmentStatusFilter,

            fromDate:
                document.getElementById(
                    'fromDate'
                )?.value || '',

            toDate:
                document.getElementById(
                    'toDate'
                )?.value || ''
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
        const badge =
            document.getElementById(
                'appointmentFilterBadge'
            );

        const filterBtn =
            document.getElementById(
                'appointmentFilterBtn'
            );

        const clearBtn =
            document.getElementById(
                'appointmentClearFilterBtn'
            );

        let count = 0;

        if (
            appointmentSortFilter !==
            'newest'
        ) {
            count++;
        }

        if (
            appointmentFromDate ||
            appointmentToDate
        ) {
            count++;
        }

        const has = count > 0;

        if (filterBtn) {
            filterBtn.classList.toggle(
                'has-filters',
                has
            );

            filterBtn.setAttribute(
                'aria-pressed',
                has ? 'true' : 'false'
            );
        }

        if (badge) {
            badge.classList.toggle(
                'show',
                has
            );

            badge.textContent =
                has ? count : '';
        }

        if (clearBtn) {
            clearBtn.classList.toggle(
                'hidden',
                !has
            );

            clearBtn.classList.toggle(
                'show',
                has
            );
        }
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
        appointmentSortFilter = 'newest';
        appointmentFromDate = '';
        appointmentToDate = '';

        syncAppointmentFilterInputs();

        document
            .querySelectorAll(
                '#datePresetGroup .quick-date-chip'
            )
            .forEach(function (button) {
                button.classList.remove(
                    'active'
                );
            });

        renderAppointmentFilterChips();
        updateAppointmentShowResultsButton();
        updateAppointmentFilterButtonState();

        if (shouldApply) {
            applyAppointmentFilters();
        }
    }

    function resetAppointmentFilters() {
        if (apptSearchInput) {
            apptSearchInput.value = '';

            window.syncInputClearButton?.(
                apptSearchInput
            );
        }

        appointmentStatusFilter =
            'all';

        appointmentPeriodFilter =
            'all';

        window.setGlobalFilterSelectValue?.(
            'appointmentStatusFilter',
            'all',
            {
                callback: false,
                focus: false
            }
        );

        resetAppointmentPanelFilters(
            false
        );

        applyAppointmentFilters();
    }

    window.applyAppointmentDrawerFilters =
        function () {
            const draft =
                getDraftAppointmentFilters();

            appointmentSortFilter =
                draft.sort;

            appointmentFromDate =
                draft.fromDate;

            appointmentToDate =
                draft.toDate;

            window.closeFilterDrawer?.(
                'filterModal'
            );

            applyAppointmentFilters();

            updateAppointmentFilterButtonState();
        };

    function setupAppointmentFilterPanel() {
        const filterBtn =
            document.getElementById(
                'appointmentFilterBtn'
            );
        const filterModal =
            document.getElementById(
                'filterModal'
            );
        const clearBtn = document.getElementById('clearFiltersModal');
        const clearAllBtn = document.getElementById('clearAllChipsBtn');

        document.querySelectorAll('#apptSortGroup .ftag').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#apptSortGroup .ftag').forEach(item => item.classList.remove(
                    'ftag-active'));
                btn.classList.add('ftag-active');
                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();
            });
        });

        filterBtn?.addEventListener(
            'click',
            function (event) {
                event.preventDefault();

                syncAppointmentFilterInputs();
                renderAppointmentFilterChips();
                updateAppointmentShowResultsButton();

                window.openFilterDrawer?.(
                    'filterModal'
                );
            }
        );

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

        clearBtn?.addEventListener(
            'click',
            function () {
                resetAppointmentPanelFilters();
                updateAppointmentShowResultsButton();
            }
        );

        clearAllBtn?.addEventListener(
            'click',
            function () {
                resetAppointmentPanelFilters();
                updateAppointmentShowResultsButton();
            }
        );
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