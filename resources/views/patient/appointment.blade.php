@extends('layouts.app')

@section('layout-role', 'patient')

@section('title', 'Appointments')

@section('content')

@php
$calendarAppointments = [];

foreach (
collect($appointments ?? [])->filter(function ($appt) {
$status = strtolower($appt->status ?? '');

return !in_array(
$status,
['completed', 'cancelled']
);
})
as $appt
) {
if (empty($appt->appointment_date)) {
continue;
}

$calendarAppointments[
\Carbon\Carbon::parse(
$appt->appointment_date
)->format('Y-m-d')
] =
'My Appointment: ' .
($appt->service_type ?? 'Dental Appointment') .
' • ' .
(
!empty($appt->appointment_time)
? \Carbon\Carbon::parse(
$appt->appointment_time
)->format('g:i A')
: 'Time not recorded'
);
}

$completedCalendarAppointments = [];

foreach (
collect($pastVisits ?? [])->filter(function ($appt) {
return strtolower(
trim((string) ($appt->status ?? ''))
) === 'completed';
})
as $appt
) {
if (empty($appt->appointment_date)) {
continue;
}

$dateKey = \Carbon\Carbon::parse(
$appt->appointment_date
)->format('Y-m-d');

$completedCalendarAppointments[$dateKey] ??= [];

$completedCalendarAppointments[$dateKey][] = [
'service' =>
$appt->service_type
?? 'Dental Appointment',

'time' =>
!empty($appt->appointment_time)
? \Carbon\Carbon::parse(
$appt->appointment_time
)->format('g:i A')
: 'Time not recorded',

'status' => 'completed',

'dentist' =>
$appt->dentist_name
?? (
optional($appt->dentist)->name
?? optional($clinicDentist)->name
?? 'Assigned Dentist'
),

'duration' =>
$appt->procedure?->procedure_duration_seconds
? \Carbon\CarbonInterval::seconds(
(int) $appt->procedure->procedure_duration_seconds
)
->cascade()
->forHumans([
'short' => true,
'minimumUnit' => 'second',
])
: (
$appt->duration
?? $appt->procedure_duration
?? $appt->treatment_duration
?? null
),

'remarks' =>
$appt->procedure?->completion_action
? \Illuminate\Support\Str::of(
$appt->procedure->completion_action
)
->replace('_', ' ')
->title()
->toString()
: ($appt->remarks ?? null),

'oral' =>
$appt->procedure?->oral_examination
?? $appt->oral_examination
?? null,

'diagnosis' =>
$appt->procedure?->diagnosis
?? $appt->diagnosis
?? null,

'prescription' =>
$appt->procedure?->prescriptions
?? $appt->prescription
?? null,
];
}
@endphp

<script>
    window.patientOdontogramTeeth = @json($odontogramTeeth ?? []);
    window.apptActivityChartData = @json($appointmentActivityChart ?? []);
</script>

<main id="mainContent" class="patient-page-shell page-enter">
    <div id="appointmentPage" class="w-full">

        @php
        $latestPastVisit = $pastVisits->first();
        $latestPastDate =
        $latestPastVisit && $latestPastVisit->appointment_date
        ? \Carbon\Carbon::parse($latestPastVisit->appointment_date)->format('M d, Y')
        : 'No record yet';

        $allAppointments = collect($appointments ?? [])->filter(fn($appt) => !empty($appt->appointment_date));

        $serviceStats = $allAppointments
        ->groupBy(fn($appt) => trim((string)($appt->service_type ?? 'General Consultation')))
        ->map(fn($group) => $group->count())
        ->sortDesc();

        $mostVisitedService = $serviceStats->keys()->first() ?: 'No visit yet';
        $mostVisitedCount = (int) ($serviceStats->first() ?? 0);

        $latestCompleted = collect($pastVisits ?? [])
        ->filter(function ($appt) {
        $status = strtolower(trim((string) ($appt->status ?? '')));
        return !empty($appt->appointment_date) && $status === 'completed';
        })
        ->sortByDesc('appointment_date')
        ->first();

        $latestCompletedText = $latestCompleted && $latestCompleted->appointment_date
        ? \Carbon\Carbon::parse($latestCompleted->appointment_date)->format('M d, Y')
        : 'No completed visit yet';

        $nextRecommendedDate = $latestCompleted && $latestCompleted->appointment_date
        ? \Carbon\Carbon::parse($latestCompleted->appointment_date)->addMonthsNoOverflow(6)
        : \Carbon\Carbon::today()->addMonthsNoOverflow(6);

        $nextRecommendedText = $nextRecommendedDate->format('M d, Y');
        $daysUntilRecommended = \Carbon\Carbon::today()->diffInDays($nextRecommendedDate->copy()->startOfDay(), false);
        $recommendedHint = $daysUntilRecommended < 0 ? 'Due now' : ($daysUntilRecommended===0 ? 'Due today' : 'In ' .
            $daysUntilRecommended . ' days' ); @endphp <section class="appt-section-reveal mb-5">
            <div class="appt-summary-grid">
                <div class="appt-summary-card">
                    <div class="flex items-center gap-4">
                        <div class="appt-summary-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-gray-400">Next Visit
                            </p>
                            <h3 class="mt-1 text-lg font-extrabold text-gray-900 dark:text-gray-100">
                                {{ $futureVisits->count()
                                ? \Carbon\Carbon::parse($futureVisits->first()->appointment_date)->format('M d, Y')
                                : 'None' }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="appt-summary-card">
                    <div class="flex items-center gap-4">
                        <div class="appt-summary-icon">
                            <i class="fa-solid fa-tooth"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-gray-400">Total Visits
                            </p>
                            <h3 class="mt-1 text-lg font-extrabold text-gray-900 dark:text-gray-100">
                                {{ $pastVisits->count() }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="appt-summary-card">
                    <div class="flex items-center gap-4">
                        <div class="appt-summary-icon">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-gray-400">Last Visit
                            </p>
                            <h3 class="mt-1 text-lg font-extrabold text-gray-900 dark:text-gray-100">
                                {{ $latestPastDate }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="appt-tip-card mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-[#8B0000]/10 text-[#8B0000] dark:text-[#FCA5A5] flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-gray-900 dark:text-gray-100">Dental Care Tip</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Regular check-ups are recommended every 6 months to keep your oral health on track.
                        </p>
                    </div>
                </div>

                <button type="button" class="ui-btn ui-btn-secondary" onclick="handleScheduleCheckup()">
                    <i class="fa-solid fa-calendar-plus"></i>
                    <span>Schedule Check-Up</span>
                </button>
            </div>
            </section>

            <section class="fade-up mb-6 sm:mb-8">
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 items-stretch">
                    <div class="xl:col-span-4">
                        <div class="appt-calendar-side">
                            <div class="appt-calendar-side-card">
                                <p
                                    class="text-[11px] font-extrabold uppercase tracking-[0.14em] text-[#8B0000] dark:text-[#FCA5A5]">
                                    Monthly Highlights
                                </p>
                                <h3 class="mt-1 text-lg font-extrabold text-gray-900 dark:text-gray-100">Your Visit
                                    Patterns</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Personalized summary based on
                                    your appointment history.</p>

                                <div class="mt-4 space-y-2.5">
                                    <div class="appt-calendar-side-stat appt-highlight-service">
                                        <div class="appt-highlight-service-copy">
                                            <span class="appt-highlight-label">
                                                Most Visited Service
                                            </span>

                                            <strong class="appt-highlight-service-name">
                                                {{ $mostVisitedCount > 0
                                                ? $mostVisitedService
                                                : 'No visits recorded yet' }}
                                            </strong>
                                        </div>

                                        <span class="status-pill status-completed appt-highlight-count">
                                            <span class="status-dot"></span>

                                            {{ $mostVisitedCount > 0
                                            ? $mostVisitedCount . 'x'
                                            : '—' }}
                                        </span>
                                    </div>

                                    <div class="appt-calendar-side-stat flex items-center justify-between">
                                        <span
                                            class="text-xs font-bold uppercase tracking-[0.1em] text-gray-500 dark:text-gray-400">Last
                                            Completed Visit</span>
                                        <span class="text-xs font-extrabold text-blue-700 dark:text-blue-300">{{
                                            $latestCompletedText }}</span>
                                    </div>

                                    <div class="appt-calendar-side-stat flex items-center justify-between">
                                        <span
                                            class="text-xs font-bold uppercase tracking-[0.1em] text-gray-500 dark:text-gray-400">Next
                                            Recommended Checkup</span>
                                        <span class="text-xs font-extrabold text-amber-700 dark:text-amber-300">{{
                                            $nextRecommendedText }}</span>
                                    </div>
                                    <p class="px-1 -mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $recommendedHint
                                        }}</p>
                                </div>
                            </div>

                            <div class="appt-calendar-side-card">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs font-extrabold text-gray-800 dark:text-gray-200">6-Month Activity
                                    </p>
                                    <div class="flex items-center gap-2 text-[10px] font-bold">
                                        <span
                                            class="inline-flex items-center gap-1 text-emerald-700 dark:text-emerald-300"><i
                                                class="fa-solid fa-circle text-[8px]"></i>Completed</span>
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-700 dark:text-orange-300"><i
                                                class="fa-solid fa-circle text-[8px]"></i>Cancelled</span>
                                    </div>
                                </div>

                                <div class="appt-mini-chart">
                                    <canvas id="apptActivityChart" aria-label="Appointment activity chart"
                                        role="img"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="xl:col-span-8">
                        <div id="calendarSkeletonContainer" class="w-full h-full min-h-[420px] skeleton-fade-swap">
                        </div>
                    </div>
                </div>

                <div class="appt-quick-actions">
                    <a href="{{ route('patient.book.appointment') }}" class="ui-btn ui-btn-secondary ui-btn-block">
                        <i class="fa-solid fa-calendar-plus"></i>
                        <span>Rebook Appointment</span>
                    </a>

                    <button type="button" class="ui-btn ui-btn-secondary ui-btn-block"
                        onclick="apptShowPast(); document.getElementById('apptPastPanel')?.scrollIntoView({ behavior: 'smooth', block: 'start' });">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>View Past Visits</span>
                    </button>

                    <button type="button" class="ui-btn ui-btn-secondary ui-btn-block"
                        onclick="scrollToAppointmentCalendar()">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Focus Calendar</span>
                    </button>
                </div>
            </section>

            <section class="appt-appointments-section">

                @php
                $futureCount = $futureVisits->count();
                $pastCount = $pastVisits->count();
                @endphp

                <div class="appt-list-toolbar">

                    <div class="appt-list-heading">
                        <div class="appt-list-heading-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>

                        <div class="appt-list-heading-copy">
                            <h2>My Appointments</h2>

                            <p>
                                You have {{ $futureVisits->count() }} upcoming
                                {{ $futureVisits->count() === 1 ? 'visit' : 'visits' }} scheduled
                            </p>
                        </div>
                    </div>

                    <div class="appt-list-tabs" id="apptListTabs">

                        <button type="button" class="appt-tab appt-active" id="apptFutureTab"
                            onclick="apptShowFuture()">
                            <i class="fa-regular fa-calendar"></i>

                            <span>Future Visits</span>

                            <span class="status-pill s-upcoming appt-count">
                                <span class="status-dot"></span>
                                {{ $futureCount }}
                            </span>
                        </button>

                        <button type="button" class="appt-tab" id="apptPastTab" onclick="apptShowPast()">
                            <i class="fa-solid fa-clock-rotate-left"></i>

                            <span>Past Visits</span>

                            <span class="status-pill s-ended appt-count">
                                <span class="status-dot"></span>
                                {{ $pastCount }}
                            </span>
                        </button>

                    </div>

                </div>

                <div id="apptFuturePanel">
                    @if ($futureVisits->count())
                    <div class="appt-list-divider">
                        <span>Upcoming</span>
                        <span class="appt-list-divider-line"></span>
                    </div>

                    @foreach ($futureVisits as $index => $appt)
                    @php
                    $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
                    $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
                    $now = \Carbon\Carbon::now();
                    $diffDays = (int) $now
                    ->startOfDay()
                    ->diffInDays($apptDate->copy()->startOfDay(), false);
                    if ($diffDays === 0) {
                    $countdown = 'Today';
                    } elseif ($diffDays === 1) {
                    $countdown = 'Tomorrow';
                    } else {
                    $countdown = 'In ' . $diffDays . ' days';
                    }

                    $rawStatus = strtolower(
                    trim((string) ($appt->status ?? 'upcoming'))
                    );

                    $statusClass = match ($rawStatus) {
                    'rescheduled' => 'status-rescheduled',
                    'upcoming',
                    'scheduled',
                    'confirmed' => 'status-upcoming',
                    default => 'status-default',
                    };

                    $dentistName =
                    $appt->dentist?->name
                    ?? $appt->originalDentist?->name
                    ?? 'Not yet assigned';
                    @endphp

                    <div class="global-record-card appt-visit-card appt-visit-card-upcoming {{ $statusClass }}"
                        style="animation-delay: {{ $index * 0.08 }}s">
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
                                        {{ $appt->service_type }}
                                        {{ $appt->other_services ? ' (' . $appt->other_services . ')' : '' }}
                                    </h3>

                                    <span class="status-pill {{ $statusClass }}">
                                        <span class="status-dot"></span>
                                        {{ \Illuminate\Support\Str::headline($rawStatus) }}
                                    </span>
                                </div>

                                <span class="urgency-chip urgency-upcoming">
                                    {{ $countdown }}
                                </span>
                            </div>

                            <div class="appt-visit-meta">
                                <span class="global-info-pill">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>
                                        {{ $apptTime->format('g:i A') }}
                                        –
                                        {{ $apptTime->copy()->addHour()->format('g:i A') }}
                                    </span>
                                </span>

                                <span class="global-info-pill">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    <span>{{ $dentistName }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="appt-timeline-empty">
                        <div class="appt-timeline-empty-grid">
                            <div>
                                <div class="mb-4 text-center sm:text-left">
                                    <div class="appt-empty-hero-icon">
                                        <i class="fa-regular fa-calendar-xmark"></i>
                                    </div>

                                    <p
                                        class="text-xs font-extrabold uppercase tracking-[0.16em] text-[#8B0000] dark:text-[#FCA5A5]">
                                        Appointment Timeline
                                    </p>

                                    <h3
                                        class="mt-1 text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100">
                                        No upcoming visit yet
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-xl">
                                        You can book your next dental visit now or check the calendar for available
                                        dates.
                                    </p>
                                </div>

                                <div class="appt-timeline-path">
                                    <div class="appt-timeline-step">
                                        <span class="appt-timeline-dot active">
                                            <i class="fa-solid fa-user-check"></i>
                                        </span>
                                        <p class="text-sm font-extrabold text-gray-900 dark:text-gray-100">Profile ready
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Your patient account is
                                            ready
                                            for
                                            booking.</p>
                                    </div>

                                    <div class="appt-timeline-step">
                                        <span class="appt-timeline-dot">
                                            <i class="fa-regular fa-calendar-plus"></i>
                                        </span>
                                        <p class="text-sm font-extrabold text-gray-900 dark:text-gray-100">Choose a date
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pick an available schedule
                                            from
                                            the
                                            clinic calendar.</p>
                                    </div>

                                    <div class="appt-timeline-step">
                                        <span class="appt-timeline-dot">
                                            <i class="fa-solid fa-hospital"></i>
                                        </span>
                                        <p class="text-sm font-extrabold text-gray-900 dark:text-gray-100">Visit the
                                            clinic
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Your confirmed appointment
                                            will
                                            appear here.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="appt-recommended-card">
                                <div class="flex items-center gap-3">
                                    <div class="appt-recommended-date">
                                        <span class="text-[10px] font-black uppercase opacity-80">Next</span>
                                        <span class="text-xl font-black">6</span>
                                        <span class="text-[10px] font-black uppercase opacity-80">Months</span>
                                    </div>

                                    <div>
                                        <p class="text-xs font-black uppercase tracking-[0.13em] text-white/70">
                                            Recommended
                                        </p>
                                        <h4 class="mt-1 text-lg font-extrabold leading-tight">Routine Check-Up</h4>
                                        <p class="mt-1 text-xs text-white/75">Keep your oral health on track.</p>
                                    </div>
                                </div>

                                <a href="{{ route('patient.book.appointment') }}" class="appt-recommended-btn">
                                    <i class="fa-solid fa-calendar-plus"></i>
                                    Schedule Now
                                </a>

                                <button type="button" onclick="scrollToAppointmentCalendar()"
                                    class="mt-2 w-full text-xs font-bold text-white/80 hover:text-white transition">
                                    Check available dates
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div id="apptPastPanel" style="display:none;">
                    @if ($pastVisits->count())
                    <div class="appt-list-divider">
                        <span>Recent History</span>
                        <span class="appt-list-divider-line"></span>
                    </div>

                    @foreach ($pastVisits as $index => $appt)
                    @php
                    $apptDate =
                    \Carbon\Carbon::parse(
                    $appt->appointment_date
                    );

                    $apptTime =
                    \Carbon\Carbon::parse(
                    $appt->appointment_time
                    );

                    $rawStatus =
                    strtolower(
                    trim(
                    (string) (
                    $appt->status
                    ?? 'completed'
                    )
                    )
                    );

                    $statusClass = match ($rawStatus) {
                    'completed' => 'status-completed',
                    'cancelled',
                    'canceled' => 'status-cancelled',
                    'rescheduled' => 'status-rescheduled',
                    default => 'status-default',
                    };

                    $dentistName =
                    $appt->dentist?->name
                    ?? $appt->originalDentist?->name
                    ?? 'Not assigned';

                    $followUp =
                    $appt->followUpAppointments
                    ?->sortBy('appointment_date')
                    ?->first();

                    $recordPayload = [
                    'service' =>
                    $appt->service_type
                    ?? 'Dental Appointment',

                    'date' =>
                    $appt->appointment_date
                    ? \Carbon\Carbon::parse(
                    $appt->appointment_date
                    )->format('F d, Y')
                    : null,

                    'time' =>
                    $appt->appointment_time
                    ? \Carbon\Carbon::parse(
                    $appt->appointment_time
                    )->format('g:i A')
                    : null,

                    'status' =>
                    $rawStatus,

                    'duration_seconds' =>
                    $appt->procedure
                    ?->procedure_duration_seconds,

                    'remarks' =>
                    $appt->procedure
                    ?->completion_action
                    ?? $appt->remarks
                    ?? null,

                    'oral' =>
                    $appt->procedure
                    ?->oral_examination
                    ?? $appt->oral_examination
                    ?? null,

                    'diagnosis' =>
                    $appt->procedure
                    ?->diagnosis
                    ?? $appt->diagnosis
                    ?? null,

                    'prescription' =>
                    $appt->procedure
                    ?->prescriptions
                    ?? $appt->prescription
                    ?? null,

                    'follow_up' =>
                    $followUp
                    ? [
                    'date' =>
                    $followUp->appointment_date
                    ? \Carbon\Carbon::parse(
                    $followUp->appointment_date
                    )->format('F d, Y')
                    : null,

                    'time' =>
                    $followUp->appointment_time
                    ? \Carbon\Carbon::parse(
                    $followUp->appointment_time
                    )->format('g:i A')
                    : null,

                    'service' =>
                    $followUp->service_type
                    ?? null,

                    'reason' =>
                    $followUp->follow_up_reason
                    ?? null,
                    ]
                    : null,

                    'odontogram_data' =>
                    $odontogramTeeth
                    ?? [],
                    ];
                    @endphp

                    <div class="global-record-card appt-visit-card appt-visit-card-past {{ $statusClass }}"
                        style="animation-delay: {{ $index * 0.08 }}s">
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
                                        {{ $appt->service_type }}
                                        {{ $appt->other_services ? ' (' . $appt->other_services . ')' : '' }}
                                    </h3>

                                    <span class="status-pill {{ $statusClass }}">
                                        <span class="status-dot"></span>
                                        {{ \Illuminate\Support\Str::headline($rawStatus) }}
                                    </span>
                                </div>
                            </div>

                            <div class="appt-visit-meta">
                                <span class="global-info-pill">
                                    <i class="fa-regular fa-clock"></i>

                                    <span>
                                        {{ $apptTime->format('g:i A') }}
                                        –
                                        {{ $apptTime->copy()->addHour()->format('g:i A') }}
                                    </span>
                                </span>

                                <span class="global-info-pill">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    <span>{{ $dentistName }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="appt-visit-actions">

                            <button type="button" class="ui-action-btn ui-action-view"
                                data-record='@json($recordPayload)' onclick="openRecordModal(this)"
                                aria-label="View details" data-tooltip="View details" data-tooltip-tone="view">
                                <i class="fa-regular fa-eye"></i>
                            </button>

                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="appt-empty-state text-center">
                        <div class="appt-empty-icon">
                            <i class="fa-regular fa-folder-open text-3xl"></i>
                        </div>

                        <p class="text-lg font-extrabold text-gray-800 dark:text-gray-200 mt-2">
                            No Past Visits Yet
                        </p>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Your completed appointments will appear here.
                        </p>

                        <button type="button" onclick="apptShowFuture()" class="ui-btn ui-btn-secondary mt-4">
                            <i class="fa-solid fa-calendar-plus"></i>
                            Book First Appointment
                        </button>
                    </div>
                    @endif
                </div>

            </section>

            @php
            $bookingServiceTypes = \App\Models\ServiceType::query()
            ->activeForBooking()
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

            $serviceIconFor = function ($name) {
            $name = strtolower((string) $name);

            return match (true) {
            str_contains($name, 'clean') || str_contains($name, 'prophy') => 'fa-solid fa-broom',
            str_contains($name, 'check') || str_contains($name, 'consult') || str_contains($name, 'oral') => 'fa-solid
            fa-stethoscope',
            str_contains($name, 'restor') || str_contains($name, 'filling') || str_contains($name, 'crown') => 'fa-solid
            fa-tooth',
            str_contains($name, 'surgery') || str_contains($name, 'extraction') || str_contains($name, 'extract') =>
            'fa-solid fa-kit-medical',
            str_contains($name, 'clearance') || str_contains($name, 'certificate') => 'fa-solid fa-file-medical',
            default => 'fa-solid fa-tooth',
            };
            };
            @endphp

            <section class="appointment-services-section">
                <div class="appointment-services-heading">
                    <div class="appointment-services-heading-icon">
                        <i class="fa-solid fa-tooth"></i>
                    </div>

                    <div class="appointment-services-heading-copy">
                        <h2>Services Offered</h2>

                        <p>
                            Available dental care services at the clinic.
                        </p>
                    </div>
                </div>

                <div class="services-grid">
                    @forelse ($bookingServiceTypes as $service)

                    <article class="card appointment-service-card">

                        <div class="card-body appointment-service-card-body">

                            <div class="card-header-icon appointment-service-icon">
                                <i class="{{ $serviceIconFor($service->name) }}"></i>
                            </div>

                            <div class="appointment-service-copy">

                                <h3 class="appointment-service-title">
                                    {{ $service->name }}
                                </h3>

                                <p class="appointment-service-desc">
                                    {{ $service->description
                                    ?: 'This dental service is currently available for patient booking.' }}
                                </p>

                            </div>

                            <span class="status-pill s-active appointment-service-status">
                                <span class="status-dot"></span>
                                Available
                            </span>

                        </div>

                    </article>
                    @empty
                    <div class="card service-card-empty">
                        <div>
                            <div class="appt-empty-icon">
                                <i class="fa-solid fa-tooth text-3xl"></i>
                            </div>

                            <p class="text-lg font-extrabold text-gray-800 dark:text-gray-200 mt-2">
                                No Services Available
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Active service types added by the admin will appear here.
                            </p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </section>
    </div>
</main>

@include('components.appointment-calendar-script', [
'mode' => 'patient-dashboard',
'renderStyle' => 'patient',
'calendarContainerId' => 'calendarSkeletonContainer',

'dateInputId' => null,
'timeInputId' => null,

'slotEndpoint' => route('book.appointment.slots'),
'bookingUrl' => route('patient.book.appointment'),

'scheduleRules' => isset($schedules)
? $schedules
: (
isset($scheduleRules)
? $scheduleRules
: \App\Models\ClinicSchedule::active()
->get()
->values()
->toArray()
),

'blockedDates' => $unavailableDates ?? [],
'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
'philippineHolidays' => $philippineHolidays ?? [],

'personalAppointments' => $calendarAppointments ?? [],
'completedAppointments' => $completedCalendarAppointments ?? [],

'useDynamicScheduleRules' => true,
'disallowToday' => true,
'allowToggleOffDate' => false,

'maxFutureMonths' => 6,
'historyMonths' => 12,

'appointmentHistoryUrl' => route('patient.record'),
])
@endsection

@section('scripts')
<script>
    let apptActivityChartInstance = null;

    function initAppointmentActivityChart() {
        const canvas = document.getElementById('apptActivityChart');
        if (!canvas || typeof Chart === 'undefined') return;

        const dataRows = Array.isArray(window.apptActivityChartData) ? window.apptActivityChartData : [];
        const labels = dataRows.map(row => row.label || '');
        const completed = dataRows.map(row => Number(row.completed || 0));
        const cancelled = dataRows.map(row => Number(row.cancelled || 0));

        if (apptActivityChartInstance) {
            apptActivityChartInstance.destroy();
        }

        apptActivityChartInstance = new Chart(canvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Completed',
                        data: completed,
                        backgroundColor: '#10B981',
                        hoverBackgroundColor: '#059669',
                        borderColor: 'rgba(4, 120, 87, 0.18)',
                        hoverBorderColor: '#047857',
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                        borderRadius: 8,
                        maxBarThickness: 16,
                    },
                    {
                        label: 'Cancelled',
                        data: cancelled,
                        backgroundColor: '#F97316',
                        hoverBackgroundColor: '#EA580C',
                        borderColor: 'rgba(194, 65, 12, 0.18)',
                        hoverBorderColor: '#C2410C',
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                        borderRadius: 8,
                        maxBarThickness: 16,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#6B7280',
                            font: { size: 10, weight: '700' }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#9CA3AF',
                            font: { size: 10 }
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.18)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip:
                        (
                            window.getGlobalChartTooltipOptions?.({
                                label(context) {
                                    const value =
                                        Number(context.raw || 0);

                                    return `${context.dataset.label}: ${value}`;
                                }
                            }) || {}
                        )
                }
            }
        });
    }

    function apptAnimatePanel(panel) {
        if (!panel) return;

        panel.classList.remove('appt-panel-fade');
        void panel.offsetWidth;
        panel.classList.add('appt-panel-fade');
    }

    function apptShowFuture() {
        const futurePanel =
            document.getElementById('apptFuturePanel');

        const pastPanel =
            document.getElementById('apptPastPanel');

        const tabs =
            document.getElementById('apptListTabs');

        if (!futurePanel || !pastPanel) {
            return;
        }

        futurePanel.style.display = '';
        pastPanel.style.display = 'none';

        document
            .getElementById('apptFutureTab')
            ?.classList.add('appt-active');

        document
            .getElementById('apptPastTab')
            ?.classList.remove('appt-active');

        tabs?.classList.remove('is-past');

        apptAnimatePanel(futurePanel);
    }

    function apptShowPast() {
        const futurePanel =
            document.getElementById('apptFuturePanel');

        const pastPanel =
            document.getElementById('apptPastPanel');

        const tabs =
            document.getElementById('apptListTabs');

        if (!futurePanel || !pastPanel) {
            return;
        }

        futurePanel.style.display = 'none';
        pastPanel.style.display = '';

        document
            .getElementById('apptPastTab')
            ?.classList.add('appt-active');

        document
            .getElementById('apptFutureTab')
            ?.classList.remove('appt-active');

        tabs?.classList.add('is-past');

        apptAnimatePanel(pastPanel);
    }

    function initApptAccordions() {
        document.querySelectorAll('.appt-record-accordion').forEach(function (acc) {
            const summary = acc.querySelector('summary');
            const panel = acc.querySelector('.appt-record-panel');

            if (!summary || !panel || acc.dataset.ready === 'true') return;
            acc.dataset.ready = 'true';

            if (acc.hasAttribute('open')) {
                acc.classList.add('is-open');
                panel.style.height = 'auto';
                panel.style.opacity = '1';
            }

            summary.addEventListener('click', function (e) {
                e.preventDefault();

                if (acc.classList.contains('is-animating')) return;

                if (acc.hasAttribute('open')) {
                    closeAccordion(acc);
                } else {
                    openAccordion(acc);
                }
            });
        });
    }

    function handleScheduleCheckup() {

        const hasActiveAppointment = @json(
            collect($futureVisits ?? [])
            -> whereNotIn('status', ['completed', 'cancelled'])
            -> count() > 0
        );


        if (hasActiveAppointment) {

            window.openModal?.(
                'activeAppointmentModal'
            );

            return;
        }


        window.location.href =
            "{{ route('patient.book.appointment') }}";
    }

    function openAccordion(acc) {
        const panel = acc.querySelector('.appt-record-panel');
        if (!panel) return;

        acc.classList.add('is-animating');
        acc.setAttribute('open', true);
        acc.classList.add('is-open');

        panel.style.height = '0px';
        panel.style.opacity = '0';

        requestAnimationFrame(function () {
            panel.style.height = panel.scrollHeight + 'px';
            panel.style.opacity = '1';
        });

        setTimeout(function () {
            panel.style.height = 'auto';
            acc.classList.remove('is-animating');
        }, 310);
    }

    function closeAccordion(acc) {
        const panel = acc.querySelector('.appt-record-panel');
        if (!panel) return;

        acc.classList.add('is-animating');

        panel.style.height = panel.scrollHeight + 'px';

        requestAnimationFrame(function () {
            acc.classList.remove('is-open');
            panel.style.height = '0px';
            panel.style.opacity = '0';
        });

        setTimeout(function () {
            acc.removeAttribute('open');
            acc.classList.remove('is-animating');
        }, 310);
    }

    document.addEventListener('DOMContentLoaded', function () {
        initApptAccordions();
        initAppointmentActivityChart();
    });

    let viewOdontogramData = [];

    const voTeeth = {
        upperRight: [18, 17, 16, 15, 14, 13, 12, 11],
        upperLeft: [21, 22, 23, 24, 25, 26, 27, 28],
        lowerRight: [48, 47, 46, 45, 44, 43, 42, 41],
        lowerLeft: [31, 32, 33, 34, 35, 36, 37, 38],
    };

    function voToothName(n) {
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

    function voConditionFromRecord(record) {
        if (!record) return 'healthy';

        const legends = Array.isArray(record.legends) ? record.legends : [];

        const allCodes = legends
            .map(l => String(l.code || l.description || '').toLowerCase())
            .join(' ');

        if (allCodes.includes('x') || allCodes.includes('extract')) return 'extracted';
        if (allCodes.includes('m') || allCodes.includes('missing')) return 'missing';
        if (allCodes.includes('f') || allCodes.includes('fill')) return 'filled';
        if (allCodes.includes('d') || allCodes.includes('decay') || allCodes.includes('caries')) return 'decay';
        if (allCodes.includes('jc') || allCodes.includes('crown')) return 'crown';

        return 'healthy';
    }

    function voFindRecord(tooth) {
        return viewOdontogramData.find(item => Number(item.tooth) === Number(tooth)) || null;
    }

    function renderViewOdontogram(rawData) {
        const board = document.getElementById('viewOdontogramBoard');
        if (!board) return;

        try {
            viewOdontogramData = typeof rawData === 'string' ? JSON.parse(rawData || '[]') : (rawData || []);
        } catch (e) {
            viewOdontogramData = [];
        }

        function toothHtml(n, bottom = false) {
            const record = voFindRecord(n);
            const condition = voConditionFromRecord(record);

            return `
            <button type="button" class="vo-tooth ${condition}" onclick="openViewToothModal(${n})">
                ${bottom ? '<div class="vo-root"></div>' : ''}
                <div class="vo-num">${n}</div>
                <div class="vo-box">${condition === 'extracted' ? '<i class="fa-solid fa-xmark"></i>' : ''}</div>
                ${!bottom ? '<div class="vo-root"></div>' : ''}
            </button>
        `;
        }

        const upper = [...voTeeth.upperRight, ...voTeeth.upperLeft].map(n => toothHtml(n)).join('');
        const lower = [...voTeeth.lowerRight, ...voTeeth.lowerLeft].map(n => toothHtml(n, true)).join('');

        board.innerHTML = `
        <div class="vo-row">${upper}</div>
        <div class="vo-arch-line">Maxilla · Mandible</div>
        <div class="vo-row">${lower}</div>
    `;
    }

    function openViewToothModal(tooth) {
        const record = voFindRecord(tooth);
        const condition = voConditionFromRecord(record);
        const name = voToothName(tooth);
        const parts = name.split('·').map(x => x.trim());

        document.getElementById('voToothTitle').textContent = `Tooth #${tooth}`;
        document.getElementById('voToothSubtitle').textContent = name;
        document.getElementById('voToothName').textContent = `#${tooth} — ${parts[1] || 'Tooth'}`;
        document.getElementById('voFdi').textContent = `#${tooth}`;
        document.getElementById('voQuadrant').textContent = parts[0] || '—';
        document.getElementById('voToothType').textContent = parts[1] || '—';
        document.getElementById('voArch').textContent = String(tooth).startsWith('1') || String(tooth).startsWith('2')
            ? 'Maxillary (Upper)'
            : 'Mandibular (Lower)';

        document.getElementById('voToothCondition').textContent =
            condition.charAt(0).toUpperCase() + condition.slice(1);

        document.getElementById('voTreatedBadge').classList.toggle('hidden', !record);

        document.getElementById('voToothVisual').innerHTML = `
        <div class="vo-big-tooth">
            ${condition === 'extracted' ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-tooth"></i>'}
        </div>
    `;

        document.getElementById('voTreatmentHistory').innerHTML = record
            ? `
            <div class="vo-history-item">
                <span class="vo-history-dot"></span>
                <span>${document.getElementById('m_date')?.textContent || 'Visit date'}</span>
                <strong>${document.getElementById('m_service')?.textContent || 'Dental Treatment'}</strong>
            </div>
        `
            : `
            <div class="appt-empty-mini">
                <div class="appt-empty-mini-icon">
                    <i class="fa-regular fa-folder-open"></i>
                </div>
                <p class="appt-empty-mini-title">No treatment history</p>
                <p class="appt-empty-mini-text">No saved treatment for this tooth yet.</p>
            </div>
        `;

        document.getElementById('viewToothModal').classList.remove('hidden');
    }

    function closeViewToothModal() {
        document.getElementById('viewToothModal')?.classList.add('hidden');
    }

    function scrollToAppointmentCalendar() {
        var calendar = document.getElementById('calendarSkeletonContainer');
        if (!calendar) return;

        calendar.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        calendar.classList.add('calendar-focus-pulse');

        setTimeout(function () {
            calendar.classList.remove('calendar-focus-pulse');
        }, 1200);
    }
</script>
@endsection