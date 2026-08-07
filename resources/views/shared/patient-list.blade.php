@extends('layouts.app')

@section('layout-role', $layoutRole)

@section('title', $pageTitle)

@section('content')

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<main id="mainContent" class="{{ $pageShellClass }}
           shared-patient-page
           {{ $isDentistView ? 'dentist-patient-view' : 'admin-patient-view' }}
           page-enter
           mode-list">
    <div class="w-full">

        @php
        use Carbon\Carbon;
        $today = Carbon::today()->toDateString();
        $todayCount = $todayCount ?? 0;
        $upcomingCount = $upcomingCount ?? 0;
        $rescheduledCount = $rescheduledCount ?? 0;
        $cancelledCount = $cancelledCount ?? 0;
        $completedCount = $completedCount ?? 0;
        $allCount = $allCount ?? 0;
        @endphp

        @if ($isDentistView)
        <div class="dentist-hero page-title-row mb-6">
            <div class="dentist-hero-content">
                <div class="dentist-hero-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div class="min-w-0">
                    <div class="dentist-hero-eyebrow">
                        <i class="fa-solid fa-tooth"></i>
                        Patient Management
                    </div>

                    <h2 class="dentist-hero-title">
                        Patient Directory
                    </h2>

                    <div class="page-summary patient-hero-summary">
                        <span class="summary-tag">
                            <span class="summary-tag-dot bg-gray-400"></span>
                            {{ $allCount }} total
                        </span>

                        @if ($todayCount > 0)
                        <span class="summary-tag">
                            <span class="summary-tag-dot bg-blue-500"></span>
                            {{ $todayCount }} today
                        </span>
                        @endif

                        @if ($upcomingCount > 0)
                        <span class="summary-tag">
                            <span class="summary-tag-dot bg-orange-500"></span>
                            {{ $upcomingCount }} upcoming
                        </span>
                        @endif

                        @if ($completedCount > 0)
                        <span class="summary-tag">
                            <span class="summary-tag-dot bg-green-500"></span>
                            {{ $completedCount }} completed
                        </span>
                        @endif

                        @if ($cancelledCount > 0)
                        <span class="summary-tag">
                            <span class="summary-tag-dot bg-red-500"></span>
                            {{ $cancelledCount }} cancelled
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="page-banner mt-2 mb-6">
            <div class="page-banner-inner">
                <div>
                    <h1 class="page-title">Patient List</h1>
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="page-badge">
                        <span class="page-badge-dot"></span>

                        {{ $allCount }}
                        {{ \Illuminate\Support\Str::plural('record', $allCount) }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        <div class="w-full">
            <div class="relative">

                <div
                    class="table-card patient-table-card rounded-2xl border border-gray-200 shadow-sm overflow-visible">

                    <div class="patient-table-toolbar px-4 md:px-6 py-3.5 border-b border-gray-100">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">

                            <div class="order-2 md:order-1">
                                <span id="rowCount"
                                    class="text-[11px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">
                                    0 patients
                                </span>
                            </div>

                            <div
                                class="patient-toolbar-actions flex items-center gap-2 order-1 md:order-2 w-full md:w-auto justify-end">

                                <div class="patient-search-row relative flex-1 md:flex-none flex items-center gap-2">
                                    <div class="search-wrap global-search flex-1 md:w-64" data-search-wrapper>
                                        <i class="fa-solid fa-magnifying-glass search-icon"></i>

                                        <input id="searchInput" type="text" placeholder="Search patient"
                                            data-search-input class="search-input" />

                                        <button type="button" class="search-clear" data-search-clear
                                            aria-label="Clear search">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </div>

                                    <div class="voice-input-toggle">
                                        <span class="voice-status hidden" data-voice-status></span>
                                        <button type="button" class="voice-search-mic external"
                                            data-global-voice-trigger data-voice-target="#searchInput"
                                            aria-label="Use voice search" title="Voice search">
                                            <i class="fa-solid fa-microphone"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="patient-sort-row">

                                    <div class="patient-stats-dropdown" id="patientStatsDropdown">
                                        <button type="button" class="patient-stats-trigger s-all"
                                            id="patientStatsToggle" aria-expanded="false">
                                            <span class="patient-stats-trigger-left">
                                                <span class="patient-stats-trigger-icon s-all">
                                                    <i class="fa-solid fa-users"></i>
                                                </span>

                                                <span class="patient-stats-trigger-text">
                                                    <span class="patient-stats-trigger-label">Status</span>
                                                    <strong id="patientStatsSelectedLabel">All Patients</strong>
                                                </span>
                                            </span>

                                            <span class="patient-stats-trigger-right">
                                                <span class="patient-stats-count-badge" id="patientStatsSelectedCount">
                                                    {{ $allCount ?? 0 }}
                                                </span>
                                                <i class="fa-solid fa-chevron-down patient-stats-chevron"></i>
                                            </span>
                                        </button>

                                        <div class="patient-stats-panel" id="patientStatsPanel">
                                            <div id="tabsGrid" class="patient-stats-grid">
                                                <button type="button" class="patient-stat-option filter-btn s-today"
                                                    data-filter="today">
                                                    <span class="patient-stat-option-icon">
                                                        <i class="fa-solid fa-clock"></i>
                                                    </span>
                                                    <span class="patient-stat-option-label">Today</span>
                                                    <span class="patient-stat-option-count" id="statToday">{{
                                                        $todayCount ?? 0 }}</span>
                                                </button>

                                                <button type="button" class="patient-stat-option filter-btn s-upcoming"
                                                    data-filter="upcoming">
                                                    <span class="patient-stat-option-icon">
                                                        <i class="fa-solid fa-calendar-check"></i>
                                                    </span>
                                                    <span class="patient-stat-option-label">Upcoming</span>
                                                    <span class="patient-stat-option-count" id="statUpcoming">{{
                                                        $upcomingCount ?? 0 }}</span>
                                                </button>

                                                <button type="button"
                                                    class="patient-stat-option filter-btn s-rescheduled"
                                                    data-filter="rescheduled">
                                                    <span class="patient-stat-option-icon">
                                                        <i class="fa-solid fa-calendar-plus"></i>
                                                    </span>
                                                    <span class="patient-stat-option-label">Rescheduled</span>
                                                    <span class="patient-stat-option-count" id="statRescheduled">{{
                                                        $rescheduledCount ?? 0 }}</span>
                                                </button>

                                                <button type="button" class="patient-stat-option filter-btn s-completed"
                                                    data-filter="completed">
                                                    <span class="patient-stat-option-icon">
                                                        <i class="fa-solid fa-check-double"></i>
                                                    </span>
                                                    <span class="patient-stat-option-label">Completed</span>
                                                    <span class="patient-stat-option-count" id="statCompleted">{{
                                                        $completedCount ?? 0 }}</span>
                                                </button>

                                                <button type="button" class="patient-stat-option filter-btn s-cancelled"
                                                    data-filter="cancelled">
                                                    <span class="patient-stat-option-icon">
                                                        <i class="fa-solid fa-calendar-xmark"></i>
                                                    </span>
                                                    <span class="patient-stat-option-label">Cancelled</span>
                                                    <span class="patient-stat-option-count" id="statCancelled">{{
                                                        $cancelledCount ?? 0 }}</span>
                                                </button>

                                                <button type="button"
                                                    class="patient-stat-option filter-btn tab-active s-all"
                                                    data-filter="all">
                                                    <span class="patient-stat-option-icon">
                                                        <i class="fa-solid fa-users"></i>
                                                    </span>
                                                    <span class="patient-stat-option-label">All Patients</span>
                                                    <span class="patient-stat-option-count" id="statAll">{{ $allCount ??
                                                        0 }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="patient-filter-actions">
                                    <button id="filterBtn" type="button" class="global-filter-btn">
                                        <i class="fa-solid fa-sliders"></i>
                                        <span>Filter</span>
                                        <span id="filterBadge" class="filter-badge" style="display:none;"></span>
                                    </button>
                                </div>

                                <div class="view-toggle-container" data-global-view-toggle data-view-root="#mainContent"
                                    data-storage-key="patientListViewMode" aria-label="View options">
                                    <span class="view-slider" aria-hidden="true"></span>

                                    <button type="button" class="btn-view-mode active" title="List view"
                                        aria-label="List view" aria-pressed="true" data-view-mode="list">
                                        <i class="fa-solid fa-list"></i>
                                    </button>

                                    <button type="button" class="btn-view-mode" title="Grid view" aria-label="Grid view"
                                        aria-pressed="false" data-view-mode="grid">
                                        <i class="fa-solid fa-grip"></i>
                                    </button>
                                </div>

                                <button id="externalClearFilterBtn" type="button" class="global-filter-reset-btn hidden"
                                    title="Reset filters">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="global-pagebar global-pagebar-top patient-pagebar">
                        <div class="global-pagebar-left">
                            <span id="patientPageInfoTop" class="global-pagebar-info">
                                Showing <strong>0</strong> patients
                            </span>

                            <div class="global-page-size-control">
                                <label for="patientPerPage">Show</label>

                                <div class="global-page-size-select" data-global-page-size
                                    data-page-size-input="#patientPerPage"
                                    data-page-size-callback="changePatientPageSize">

                                    <input type="hidden" id="patientPerPage" class="global-page-size-native" value="10">

                                    <button type="button" class="global-page-size-trigger" data-page-size-trigger
                                        aria-haspopup="listbox" aria-expanded="false">

                                        <span data-page-size-value>10</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>

                                    <div class="global-page-size-menu" role="listbox">
                                        @foreach ([10, 20, 50, 100] as $size)
                                        <button type="button"
                                            class="global-page-size-option {{ $size === 10 ? 'is-selected' : '' }}"
                                            data-page-size-option data-value="{{ $size }}" role="option"
                                            aria-selected="{{ $size === 10 ? 'true' : 'false' }}">

                                            <span>{{ $size }}</span>
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>

                                <span>per page</span>
                            </div>
                        </div>

                        <div id="patientPaginationTop" class="global-pagination-wrap">
                        </div>
                    </div>

                    <div class="table-scroll-wrapper">
                        <div class="table-scroll-inner">

                            <div class="card-col-header">
                                <span></span>
                                <span>Patient</span>
                                <span></span>
                                <span>Date &amp; Time</span>
                                <span></span>
                                <span>Service &amp; Status</span>
                                <span></span>
                            </div>

                            <div id="patientSkeleton" class="hidden px-3 md:px-6 pb-6 pt-4">

                                <div class="skeleton-list-layout space-y-3">
                                    @for ($i = 0; $i < 3; $i++) <div class="skeleton-shell p-4">
                                        <div class="flex items-center gap-5">
                                            <div class="skeleton-circle w-14 h-14 flex-shrink-0"></div>

                                            <div class="w-44 flex-shrink-0 space-y-2">
                                                <div class="skeleton-line h-4 w-36"></div>
                                                <div class="skeleton-pill h-5 w-20"></div>
                                            </div>

                                            <div class="skeleton-block h-10 w-px hidden lg:block"></div>

                                            <div class="flex items-center gap-3 w-44 flex-shrink-0">
                                                <div class="skeleton-block w-10 h-10"></div>
                                                <div class="space-y-2">
                                                    <div class="skeleton-line h-3 w-20"></div>
                                                    <div class="skeleton-line h-4 w-28"></div>
                                                    <div class="skeleton-line h-3 w-16"></div>
                                                </div>
                                            </div>

                                            <div class="skeleton-block h-10 w-px hidden lg:block"></div>

                                            <div class="flex items-center gap-3 flex-1">
                                                <div class="skeleton-block w-10 h-10"></div>
                                                <div class="space-y-2 flex-1">
                                                    <div class="skeleton-line h-3 w-16"></div>
                                                    <div class="skeleton-line h-4 w-32"></div>
                                                    <div class="skeleton-pill h-6 w-36"></div>
                                                </div>
                                            </div>

                                            <div class="skeleton-circle w-9 h-9 flex-shrink-0"></div>
                                        </div>
                                </div>
                                @endfor
                            </div>

                            <div class="skeleton-grid-layout">
                                @for ($i = 0; $i < 6; $i++) <div class="skeleton-shell patient-grid-skeleton-card">
                                    <div class="flex items-start gap-3">
                                        <div class="skeleton-circle w-[54px] h-[54px] flex-shrink-0"></div>

                                        <div class="flex-1 min-w-0 space-y-2">
                                            <div class="skeleton-line h-4 w-4/5"></div>
                                            <div class="skeleton-line h-4 w-3/5"></div>

                                            <div class="flex gap-2 pt-1">
                                                <div class="skeleton-pill h-6 w-28"></div>
                                                <div class="skeleton-pill h-6 w-24"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-2 mt-4">
                                        <div class="skeleton-block h-14 w-full"></div>
                                        <div class="skeleton-block h-14 w-full"></div>
                                    </div>

                                    <div class="flex items-center justify-between gap-2 mt-4">
                                        <div class="skeleton-pill h-7 w-28"></div>
                                        <div class="skeleton-pill h-7 w-20"></div>
                                    </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div id="patientContainer" class="space-y-3 px-3 md:px-6 pb-6 pt-4">

                        @forelse($appointments as $appt)
                        @php
                        $status = strtolower($appt->status ?? '');
                        $isCancelled = $status === 'cancelled';
                        $isCompleted = $status === 'completed';
                        $isRescheduled = $status === 'rescheduled';
                        $isToday =
                        $appt->appointment_date === $today && !$isCancelled && !$isCompleted;
                        $isUpcoming =
                        $appt->appointment_date > $today &&
                        in_array(
                        $status,
                        ['upcoming', 'rescheduled', 'pending', 'confirmed'],
                        true,
                        );

                        $tabClass = $isCancelled
                        ? 'cancelled'
                        : ($isCompleted
                        ? 'completed'
                        : ($isRescheduled
                        ? 'rescheduled'
                        : ($isToday
                        ? 'today'
                        : ($isUpcoming
                        ? 'upcoming'
                        : 'all'))));

                        $patient = $appt->patient;
                        $isWalkInAppointment =
                        (bool) ($appt->is_walk_in ?? false);
                        $patientId = $patient?->id ?? $appt->patient_id;
                        $patientName = $patient?->name ?? 'Unknown Patient';
                        $patientStudentNo = filled($patient?->student_no)
                        ? $patient->student_no
                        : (filled($patient?->faculty_code)
                        ? 'Faculty: ' . $patient->faculty_code
                        : 'No identity number');

                        $patientCourseCode = trim((string) ($patient?->course_code ?? ''));
                        $patientCourseName = trim((string) ($patient?->course_name ?? ''));

                        $patientCourse =
                        $patientCourseCode !== ''
                        ? $patientCourseCode
                        : ($patientCourseName !== ''
                        ? $patientCourseName
                        : 'No program');

                        $patientCourseFull = collect([
                        $patientCourseCode,
                        $patientCourseName !== $patientCourseCode ? $patientCourseName : null,
                        ])
                        ->filter()
                        ->implode(' — ');

                        if ($patientCourseFull === '') {
                        $patientCourseFull = 'No program';
                        }

                        $patientYearLevel = $patient?->year_level ?? '';
                        $patientSection = $patient?->section ?? '';

                        $patientImage = $patient?->profile_image
                        ? asset('storage/' . $patient->profile_image)
                        : null;

                        $patientInitials = collect(preg_split('/\s+/', trim($patientName)))
                        ->filter()
                        ->take(2)
                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                        ->implode('');
                        $dateLabel = Carbon::parse($appt->appointment_date)->format('d M Y');
                        $timeLabel = Carbon::parse($appt->appointment_time)->format('g:i A');
                        $serviceLabel =
                        $appt->service_type === 'Others'
                        ? ($appt->other_services ?:
                        'Others')
                        : $appt->service_type;

                        $statusToneClass = $isCancelled
                        ? 'status-cancelled'
                        : ($isCompleted
                        ? 'status-completed'
                        : ($isRescheduled
                        ? 'status-rescheduled'
                        : ($isToday
                        ? 'status-today'
                        : ($isUpcoming
                        ? 'status-upcoming'
                        : 'status-default'))));
                        $pillClass = $isCancelled
                        ? 'pill-cancelled'
                        : ($isCompleted
                        ? 'pill-completed'
                        : ($isRescheduled
                        ? 'pill-rescheduled'
                        : ($isToday
                        ? 'pill-today'
                        : ($isUpcoming
                        ? 'pill-upcoming'
                        : 'pill-default'))));
                        $pillText = $isCancelled
                        ? 'Cancelled'
                        : ($isCompleted
                        ? 'Completed'
                        : ($isRescheduled
                        ? 'Rescheduled'
                        : ($isToday
                        ? 'Appointment Today'
                        : ($isUpcoming
                        ? ($status === 'upcoming'
                        ? 'Upcoming'
                        : 'Upcoming ·
                        ' . ucfirst($status))
                        : ucfirst($status ?: 'Pending')))));

                        $appointmentDate = Carbon::parse($appt->appointment_date)->startOfDay();
                        $todayDate = Carbon::today();
                        $daysDiff = (int) $todayDate->diffInDays($appointmentDate, false);

                        $showDateUrgency = !$isCancelled && !$isCompleted && $daysDiff >= 0;

                        $urgencyLabel = $showDateUrgency
                        ? ($daysDiff === 0
                        ? 'Today'
                        : ($daysDiff === 1
                        ? 'Tomorrow'
                        : 'In ' . $daysDiff . ' days'))
                        : '';

                        $urgencyClass = $showDateUrgency
                        ? ($isRescheduled
                        ? 'status-rescheduled'
                        : ($daysDiff === 0
                        ? 'urgency-today'
                        : ($daysDiff === 1
                        ? 'urgency-tomorrow'
                        : 'urgency-upcoming')))
                        : '';
                        @endphp

                        @php
                        $patientProfileUrl = $patientId
                        ? route($patientProfileRouteName, $patientId)
                        : null;
                        @endphp
                        @if ($patientProfileUrl)
                        <a href="{{ $patientProfileUrl }}" class="patient-card patient-item all {{ $tabClass }} block"
                            data-patient-id="{{ $patientId }}">
                            @else
                            <div class="patient-card patient-item all {{ $tabClass }} block" data-patient-id="">
                                @endif

                                <div class="accent-bar {{ $statusToneClass }}"></div>

                                <div class="patient-list-card-body">
                                    <div class="patient-list-main">
                                        <span class="patient-avatar patient-avatar-md">
                                            @if ($patientImage)
                                            <img src="{{ $patientImage }}" alt="{{ $patientName }}">
                                            @else
                                            <span>{{ $patientInitials ?: '?' }}</span>
                                            @endif
                                        </span>

                                        <div class="patient-list-person">
                                            <div class="patient-list-name-row">

                                                <h3 class="patient-list-name">
                                                    {{ $patientName }}
                                                </h3>

                                                @if ($isWalkInAppointment)
                                                <span class="ui-action-btn ui-action-neutral ui-action-indicator"
                                                    data-tooltip="Walk-in appointment" data-tooltip-tone="neutral"
                                                    aria-label="Walk-in appointment" tabindex="0">
                                                    <i class="fa-solid fa-person-walking"></i>
                                                </span>
                                                @endif

                                            </div>

                                            <div class="patient-list-meta">
                                                <span class="global-info-pill">
                                                    <i class="fa-regular fa-id-card"></i>
                                                    {{ $patientStudentNo }}
                                                </span>

                                                <span class="global-info-pill" title="{{ $patientCourseFull }}">
                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                    {{ $patientCourse }}
                                                </span>
                                            </div>

                                            <span class="patient-info hidden">
                                                {{ $patientCourseCode }}|
                                                {{ $patientYearLevel }}|
                                                {{ $patientSection }}|
                                                {{ $appt->appointment_date }}|
                                                {{ $patient?->department ?? '' }}|
                                                {{ optional($appt->created_at)->toDateTimeString() }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="patient-list-detail patient-list-date-block">
                                        <span class="patient-list-detail-icon global-info-icon {{ $statusToneClass }}">
                                            <i class="fa-regular fa-calendar"></i>
                                        </span>

                                        <div class="patient-list-detail-copy">
                                            <span class="patient-list-detail-label">
                                                Appointment
                                            </span>

                                            <strong class="patient-list-detail-value">
                                                {{ $dateLabel }}
                                            </strong>

                                            <small class="patient-list-detail-subvalue">
                                                {{ $timeLabel }}
                                            </small>

                                            @if ($showDateUrgency)
                                            <span class="urgency-chip {{ $urgencyClass }}">
                                                {{ $urgencyLabel }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="patient-list-detail patient-list-service-block patient-service-block">
                                        <span class="patient-list-detail-icon global-info-icon {{ $statusToneClass }}">
                                            <i class="fa-solid fa-tooth"></i>
                                        </span>

                                        <div class="patient-list-detail-copy">
                                            <span class="patient-list-detail-label global-info-label">
                                                Service
                                            </span>

                                            <strong class="patient-list-detail-value font-semibold">
                                                {{ $serviceLabel }}
                                            </strong>

                                            <span class="status-pill {{ $pillClass }} patient-list-status">
                                                <span class="pill-dot"></span>
                                                {{ $pillText }}
                                            </span>
                                        </div>
                                    </div>

                                    <span class="patient-list-chevron" aria-hidden="true">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                </div>

                                <div class="patient-grid-card-body">
                                    <div class="patient-grid-card-header">
                                        <div class="patient-grid-card-identity">
                                            <span class="patient-avatar patient-avatar-lg">
                                                @if ($patientImage)
                                                <img src="{{ $patientImage }}" alt="{{ $patientName }}">
                                                @else
                                                <span>{{ $patientInitials ?: '?' }}</span>
                                                @endif
                                            </span>

                                            <div class="patient-grid-card-person">
                                                <div class="patient-grid-name-row">

                                                    <h3 class="patient-grid-card-name">
                                                        {{ $patientName }}
                                                    </h3>

                                                    @if ($isWalkInAppointment)
                                                    <span class="ui-action-btn ui-action-neutral ui-action-indicator"
                                                        data-tooltip="Walk-in appointment" data-tooltip-tone="neutral"
                                                        aria-label="Walk-in appointment" tabindex="0">
                                                        <i class="fa-solid fa-person-walking"></i>
                                                    </span>
                                                    @endif

                                                </div>

                                                <div class="patient-grid-card-meta">
                                                    <span class="global-info-pill">
                                                        <i class="fa-regular fa-id-card"></i>
                                                        {{ $patientStudentNo }}
                                                    </span>

                                                    <span class="global-info-pill" title="{{ $patientCourseFull }}">
                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                        {{ $patientCourse }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="patient-grid-card-schedule">
                                            <strong>{{ $dateLabel }}</strong>
                                            <span>{{ $timeLabel }}</span>

                                            @if ($showDateUrgency)
                                            <span class="urgency-chip {{ $urgencyClass }}">
                                                {{ $urgencyLabel }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="patient-grid-card-footer">
                                        <div class="patient-grid-card-service">
                                            <span
                                                class="patient-grid-card-service-icon global-info-icon {{ $statusToneClass }}">
                                                <i class="fa-solid fa-tooth"></i>
                                            </span>

                                            <span class="patient-grid-card-service-name">
                                                {{ $serviceLabel }}
                                            </span>
                                        </div>

                                        <span class="status-pill {{ $pillClass }} patient-grid-card-status">
                                            <span class="pill-dot"></span>
                                            {{ $pillText }}
                                        </span>
                                    </div>
                                </div>
                                @if ($patientProfileUrl)
                        </a>
                        @else
                    </div>
                    @endif
                    @empty
                    <div class="empty-state col-span-full w-full">
                        <div class="empty-state-icon">
                            <i class="fa-solid fa-tooth"></i>
                        </div>

                        <p class="empty-state-title">No patients found</p>
                        <p class="empty-state-sub">
                            There are no patient appointments in the system yet.
                        </p>
                    </div>
                    @endforelse

                    <div id="patientSearchEmptyState"
                        class="empty-state empty-state-controlled col-span-full w-full hidden" hidden>

                        <div class="empty-state-icon patient-empty-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <p id="patientSearchEmptyTitle" class="empty-state-title">
                            No results found
                        </p>

                        <p class="empty-state-sub">
                            Try a different patient name, student number, program, or service.
                        </p>

                        <button type="button" id="clearPatientSearchBtn" class="empty-state-btn">

                            <i class="fa-solid fa-xmark"></i>
                            Clear search
                        </button>
                    </div>

                    <div id="patientStatusEmptyState"
                        class="empty-state empty-state-controlled col-span-full w-full hidden" hidden>

                        <div class="empty-state-icon patient-empty-icon">
                            <i id="patientStatusEmptyIcon" class="fa-regular fa-calendar-xmark"></i>
                        </div>

                        <p id="patientStatusEmptyTitle" class="empty-state-title">
                            No patients found
                        </p>

                        <p id="patientStatusEmptyText" class="empty-state-sub">
                            There are currently no patients under this appointment status.
                        </p>

                        <button type="button" id="resetPatientFiltersBtn" class="empty-state-btn hidden" hidden>

                            <i class="fa-solid fa-rotate-left"></i>
                            Clear filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="global-pagebar global-pagebar-bottom patient-pagebar">
            <span id="patientPageInfoBottom" class="global-pagebar-info">
                Showing <strong>0</strong> patients
            </span>

            <div id="patientPaginationBottom" class="global-pagination-wrap">
            </div>
        </div>
    </div>
    </div>
    </div>
</main>

<div id="filterModal" class="filter-drawer-wrapper" aria-hidden="true">
    <div class="filter-drawer-overlay" onclick="document.getElementById('closeFilterModalBtn').click()"></div>

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
                <div class="filter-chip-row" id="fSortGroup">
                    <button type="button" class="ftag ftag-active" data-val="nearest">
                        Nearest Appointment
                    </button>

                    <button type="button" class="ftag" data-val="farthest">
                        Farthest Appointment
                    </button>
                    <button type="button" class="ftag" data-val="az">Patient Name A-Z</button>
                    <button type="button" class="ftag" data-val="za">Patient Name Z-A</button>
                </div>
            </div>

            <div>
                <h3 class="filter-section-title">Filter by Date Range</h3>
                <div class="filter-chip-row" id="datePresetGroup">
                    <button type="button" class="quick-date-chip" data-range="7">Last 7 Days</button>
                    <button type="button" class="quick-date-chip" data-range="30">Last 30 Days</button>
                    <button type="button" class="quick-date-chip" data-range="90">Last 3 Months</button>
                    <button type="button" class="quick-date-chip" data-range="180">Last 6 Months</button>
                    <button type="button" class="quick-date-chip" data-range="365">Last 12 Months</button>
                </div>
            </div>

            <div>
                <h3 class="filter-section-title">Custom Date Range</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="filter-date-input-wrap">
                        <input id="fromDate" type="text" class="js-flatpickr-date-range-from" placeholder="Start date"
                            readonly autocomplete="off" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>

                    <div class="filter-date-input-wrap">
                        <input id="toDate" type="text" class="js-flatpickr-date-range-to" placeholder="End date"
                            readonly autocomplete="off" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="filter-section-title">Course</h3>
                <div class="filter-chip-grid">
                    @foreach ([
                    'BSIT',
                    'BSECE',
                    'BSBA - HRM',
                    'BSED - ENG',
                    'BSOA',
                    'BSPSYCH',
                    'DIT',
                    'BSME',
                    'BSBA -
                    MM',
                    'BSED - MATH',
                    'DOMT',
                    ] as $course)
                    <label class="choice-chip">
                        <input type="radio" name="course" value="{{ $course }}"
                            class="filter-input radio-red chip-radio" />
                        <span>{{ $course }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="filter-section-title">Year Level</h3>
                    <div class="filter-chip-row">
                        <label class="choice-chip">
                            <input type="radio" name="year" value="1st Year"
                                class="filter-input radio-red chip-radio" />
                            <span>1st Year</span>
                        </label>

                        <label class="choice-chip">
                            <input type="radio" name="year" value="2nd Year"
                                class="filter-input radio-red chip-radio" />
                            <span>2nd Year</span>
                        </label>

                        <label class="choice-chip">
                            <input type="radio" name="year" value="3rd Year"
                                class="filter-input radio-red chip-radio" />
                            <span>3rd Year</span>
                        </label>

                        <label class="choice-chip">
                            <input type="radio" name="year" value="4th Year"
                                class="filter-input radio-red chip-radio" />
                            <span>4th Year</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="filter-section-title">Section</h3>
                    <div class="filter-chip-row">
                        <label class="choice-chip">
                            <input type="radio" name="section" value="1" class="filter-input radio-red chip-radio" />
                            <span>1</span>
                        </label>

                        <label class="choice-chip">
                            <input type="radio" name="section" value="2" class="filter-input radio-red chip-radio" />
                            <span>2</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pb-6">
                <h3 class="filter-section-title">Department</h3>
                <div class="filter-chip-row">
                    <label class="choice-chip">
                        <input type="radio" name="department" value="Administrative"
                            class="filter-input radio-red chip-radio" />
                        <span>Administrative</span>
                    </label>

                    <label class="choice-chip">
                        <input type="radio" name="department" value="Faculty"
                            class="filter-input radio-red chip-radio" />
                        <span>Faculty</span>
                    </label>

                    <label class="choice-chip">
                        <input type="radio" name="department" value="Dependent"
                            class="filter-input radio-red chip-radio" />
                        <span>Dependent</span>
                    </label>
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
@endsection

@section('scripts')
<script>
    function getPatientDropdownMeta(status) {
        const map = {
            today: {
                label: 'Today',
                icon: 'fa-clock',
                tone: 's-today',
                countId: 'statToday'
            },
            upcoming: {
                label: 'Upcoming',
                icon: 'fa-calendar-check',
                tone: 's-upcoming',
                countId: 'statUpcoming'
            },
            rescheduled: {
                label: 'Rescheduled',
                icon: 'fa-calendar-plus',
                tone: 's-rescheduled',
                countId: 'statRescheduled'
            },
            completed: {
                label: 'Completed',
                icon: 'fa-check-double',
                tone: 's-completed',
                countId: 'statCompleted'
            },
            cancelled: {
                label: 'Cancelled',
                icon: 'fa-calendar-xmark',
                tone: 's-cancelled',
                countId: 'statCancelled'
            },
            all: {
                label: 'All Patients',
                icon: 'fa-users',
                tone: 's-all',
                countId: 'statAll'
            }
        };

        return map[status] || map.all;
    }

    function getPatientDropdownCount(status) {
        const meta = getPatientDropdownMeta(status);
        return document.getElementById(meta.countId)?.textContent?.trim() || '0';
    }

    function updatePatientStatsDropdownLabel() {
        const activeBtn =
            document.querySelector('#tabsGrid .filter-btn.tab-active') ||
            document.querySelector('#tabsGrid .filter-btn[data-filter="all"]');

        const labelEl = document.getElementById('patientStatsSelectedLabel');
        const countEl = document.getElementById('patientStatsSelectedCount');
        const leadingIcon = document.querySelector('#patientStatsToggle .patient-stats-trigger-icon');

        if (!activeBtn || !labelEl || !countEl) return;

        const status = activeBtn.getAttribute('data-filter') || 'all';
        const meta = getPatientDropdownMeta(status);

        labelEl.textContent = meta.label;
        countEl.textContent = getPatientDropdownCount(status);

        if (leadingIcon) {
            leadingIcon.className = `patient-stats-trigger-icon ${meta.tone}`;
            leadingIcon.innerHTML = `<i class="fa-solid ${meta.icon}"></i>`;
        }
        var trigger =
            document.getElementById(
                "patientStatsToggle"
            );

        if (trigger) {
            trigger.classList.remove(
                "s-today",
                "s-upcoming",
                "s-rescheduled",
                "s-completed",
                "s-cancelled",
                "s-all"
            );

            trigger.classList.add(meta.tone);
        }
        document.querySelectorAll('#tabsGrid .filter-btn').forEach(function (btn) {
            btn.classList.toggle('tab-active', btn.getAttribute('data-filter') === status);
        });
    }

    window.updatePatientStatsDropdownLabel = updatePatientStatsDropdownLabel;

    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('patientStatsDropdown');
        const toggle = document.getElementById('patientStatsToggle');
        const panel = document.getElementById('patientStatsPanel');

        if (!dropdown || !toggle || !panel) return;

        function closePatientStatsDropdown() {
            dropdown.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = dropdown.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        panel.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.addEventListener('click', closePatientStatsDropdown);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePatientStatsDropdown();
        });

        updatePatientStatsDropdownLabel();
    });

    document.addEventListener("DOMContentLoaded", function () {
        let patientFilterModal = null;
        let patientSearchInput = null;
        let patientFilterBtn = null;
        let patientFilterBadge = null;
        let patientExternalResetBtn = null;

        function openFilterModal() {
            window.openFilterDrawer?.('filterModal');
        }

        function closeFilterModal() {
            window.closeFilterDrawer?.('filterModal');
        }

        function onSearch(input) {
            if (!input) return;
            input.dispatchEvent(new Event('input'));
        }

        function resetPatientPanelFilters(
            shouldApply = true
        ) {
            clearFormState();

            selectedDepartment = null;
            selectedProgram = null;
            selectedYearLevel = null;
            selectedSection = null;

            activeFromDate = "";
            activeToDate = "";
            activeDatePreset = "";

            dateSort = "nearest";
            nameSort = null;

            renderFilterChips();
            syncMutualExclusion();
            updateFilterButtonState();

            if (shouldApply) {
                applyFilters();
            }
        }

        function resetAllFilters() {
            resetPatientPanelFilters(false);

            searchKeyword = "";

            if (patientSearchInput) {
                patientSearchInput.value = "";
            }

            selectPatientStatus("all");
            applyFilters();
        }

        try {
            var patientContainer = document.getElementById("patientContainer");
            if (!patientContainer) return;

            var patientSkeleton = document.getElementById("patientSkeleton");

            function showPatientSkeleton() {
                if (!patientSkeleton || !patientContainer) return;
                patientSkeleton.classList.remove("hidden");
                patientContainer.classList.add("hidden");
            }

            function hidePatientSkeleton() {
                if (!patientSkeleton || !patientContainer) return;
                patientSkeleton.classList.add("hidden");
                patientContainer.classList.remove("hidden");
            }

            var allPatients = Array.from(patientContainer.querySelectorAll(".patient-item"));
            var filterModal = document.getElementById("filterModal");
            var filterBtn = document.getElementById("filterBtn");
            var filterBadge = document.getElementById("filterBadge");
            var clearFiltersModalBtn = document.getElementById("clearFiltersModal");
            var applyFiltersBtn = document.getElementById("applyFilters");
            var searchInput = document.getElementById("searchInput");
            var externalClearFilterBtn = document.getElementById("externalClearFilterBtn");
            var colHeader = document.querySelector(".card-col-header");
            var patientSearchEmptyState =
                document.getElementById("patientSearchEmptyState");

            var patientSearchEmptyTitle =
                document.getElementById("patientSearchEmptyTitle");

            var patientStatusEmptyState =
                document.getElementById("patientStatusEmptyState");

            var patientStatusEmptyIcon =
                document.getElementById("patientStatusEmptyIcon");

            var patientStatusEmptyTitle =
                document.getElementById("patientStatusEmptyTitle");

            var patientStatusEmptyText =
                document.getElementById("patientStatusEmptyText");

            var clearPatientSearchBtn =
                document.getElementById("clearPatientSearchBtn");

            var resetPatientFiltersBtn =
                document.getElementById("resetPatientFiltersBtn");

            patientFilterModal = filterModal;
            patientSearchInput = searchInput;
            patientFilterBtn = filterBtn;
            patientFilterBadge = filterBadge;
            patientExternalResetBtn = externalClearFilterBtn;

            var activeTab = "all";
            var searchKeyword = "";

            function selectPatientStatus(status) {
                var nextStatus = status || "all";

                document.querySelectorAll(
                    "#tabsGrid .filter-btn"
                ).forEach(function (button) {
                    button.classList.toggle(
                        "tab-active",
                        button.getAttribute("data-filter") === nextStatus
                    );
                });

                activeTab = nextStatus;
                updatePatientStatsDropdownLabel();
            }

            var selectedProgram = null,
                selectedYearLevel = null,
                selectedSection = null,
                selectedDepartment = null;
            var nameSort = null,
                dateSort = "nearest";

            var activeFromDate = "",
                activeToDate = "",
                activeDatePreset = "";

            var deptRadios = Array.from(document.querySelectorAll('input[name="department"]'));
            var courseRadios = Array.from(document.querySelectorAll('input[name="course"]'));
            var yearRadios = Array.from(document.querySelectorAll('input[name="year"]'));
            var sectionRadios = Array.from(document.querySelectorAll('input[name="section"]'));
            var otherRadios = courseRadios.concat(yearRadios, sectionRadios);

            if (clearPatientSearchBtn) {
                clearPatientSearchBtn.addEventListener(
                    "click",
                    function () {
                        searchKeyword = "";

                        if (searchInput) {
                            searchInput.value = "";

                            searchInput.dispatchEvent(
                                new Event("input", {
                                    bubbles: true
                                })
                            );

                            searchInput.focus();
                        }

                        applyFilters();
                    }
                );
            }

            if (resetPatientFiltersBtn) {
                resetPatientFiltersBtn.addEventListener(
                    "click",
                    function () {
                        resetPatientPanelFilters();
                    }
                );
            }

            if (filterBtn) {
                filterBtn.onclick = function (e) {
                    e.preventDefault();
                    renderFilterChips();
                    syncMutualExclusion();
                    updateShowResultsButton();
                    openFilterModal();
                };
            }

            var cancelFilterBtn = document.getElementById("cancelFilterBtn");
            var closeFilterModalBtn =
                document.getElementById("closeFilterModalBtn");

            if (closeFilterModalBtn) {
                closeFilterModalBtn.onclick = function () {
                    closeFilterModal();
                    updateFilterButtonState();
                };
            }
            if (cancelFilterBtn) {
                cancelFilterBtn.onclick = function () {
                    if (filterModal) closeFilterModal();
                    updateFilterButtonState();
                };
            }

            document.addEventListener("keydown", function (e) {
                if (e.key === "Escape" && filterModal && filterModal.classList.contains("open")) {
                    closeFilterModal();
                    updateFilterButtonState();
                }
            });

            function clearFormState() {
                if (filterModal) {
                    filterModal.querySelectorAll("input[type='radio']").forEach(function (i) {
                        i.checked = false;
                        i.disabled = false;

                        var lbl = i.closest("label");
                        if (lbl) {
                            lbl.classList.remove("opacity-50", "cursor-not-allowed");
                        }
                    });
                }

                var f = document.getElementById("fromDate");
                var t = document.getElementById("toDate");

                if (f) f.value = "";
                if (t) t.value = "";

                document.querySelectorAll('#datePresetGroup .quick-date-chip').forEach(function (b) {
                    b.classList.remove('active');
                });

                selectedDepartment = null;
                selectedProgram = null;
                selectedYearLevel = null;
                selectedSection = null;
                activeFromDate = "";
                activeToDate = "";
                activeDatePreset = "";

                window.syncFilterTagGroup(
                    "fSortGroup",
                    "nearest"
                );

                syncMutualExclusion();
                updateFilterButtonState();

                dateSort = 'nearest';
                nameSort = null;

                updateShowResultsButton();
            }

            function getDraftFilterState() {
                var deptEl = filterModal ? filterModal.querySelector('input[name="department"]:checked') : null;
                var crsEl = filterModal ? filterModal.querySelector('input[name="course"]:checked') : null;
                var yrEl = filterModal ? filterModal.querySelector('input[name="year"]:checked') : null;
                var secEl = filterModal ? filterModal.querySelector('input[name="section"]:checked') : null;

                var fromDateEl = document.getElementById("fromDate");
                var toDateEl = document.getElementById("toDate");

                return {
                    department: deptEl ? deptEl.value : null,
                    program: crsEl ? crsEl.value : null,
                    year: yrEl ? yrEl.value : null,
                    section: secEl ? secEl.value : null,
                    fromDate: fromDateEl ? fromDateEl.value : "",
                    toDate: toDateEl ? toDateEl.value : ""
                };
            }

            function hasDraftFilterChips() {
                var draft = getDraftFilterState();

                var sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
                var sortVal = sortActive ?
                    sortActive.getAttribute("data-val") :
                    "nearest";

                return !!(
                    draft.department ||
                    draft.program ||
                    draft.year ||
                    draft.section ||
                    draft.fromDate ||
                    draft.toDate ||
                    activeDatePreset ||
                    sortVal !== 'nearest'
                );
            }

            function countDraftResults() {
                var draft = getDraftFilterState();
                var data = allPatients.slice();

                if (searchKeyword) {
                    data = data.filter(function (patient) {
                        return matchesSearch(
                            patient,
                            searchKeyword
                        );
                    });
                }

                if (draft.program) {
                    data = data.filter(function (patient) {
                        return ilike(
                            getInfo(patient).program,
                            draft.program
                        );
                    });
                }

                if (draft.year || draft.section) {
                    data = data.filter(function (patient) {
                        var info = getInfo(patient);

                        if (
                            draft.year &&
                            !ilike(info.year, draft.year)
                        ) {
                            return false;
                        }

                        if (
                            draft.section &&
                            String(info.section).trim() !==
                            String(draft.section).trim()
                        ) {
                            return false;
                        }

                        return true;
                    });
                }

                if (draft.department) {
                    data = data.filter(function (patient) {
                        return ilike(
                            getInfo(patient).department,
                            draft.department
                        );
                    });
                }

                if (draft.fromDate || draft.toDate) {
                    data = data.filter(function (patient) {
                        var date = new Date(
                            getInfo(patient).dateStr
                        );

                        if (isNaN(date.getTime())) {
                            return false;
                        }

                        if (
                            draft.fromDate &&
                            date < new Date(draft.fromDate)
                        ) {
                            return false;
                        }

                        if (
                            draft.toDate &&
                            date > new Date(draft.toDate)
                        ) {
                            return false;
                        }

                        return true;
                    });
                }

                return data.length;
            }

            function updateShowResultsButton() {
                if (!hasDraftFilterChips()) {
                    window.updateShowResultsText(0);
                    return;
                }

                var count = countDraftResults();
                window.updateShowResultsText(count);
            }

            function renderFilterChips() {
                var container = document.getElementById("activeChipsContainer");
                var section = document.getElementById("activeFiltersSection");
                if (!container || !section) return;

                container.innerHTML = "";
                var hasChips = false;

                function addChip(label, callback) {
                    hasChips = true;
                    var chip = document.createElement("div");
                    chip.className = "filter-chip";
                    chip.innerHTML = "<span>" + label +
                        "</span><span class='filter-chip-remove'><i class='fa-solid fa-xmark'></i></span>";
                    chip.querySelector(".filter-chip-remove").onclick = function () {
                        callback();
                        renderFilterChips();
                        syncMutualExclusion();
                        updateShowResultsButton();
                    };
                    container.appendChild(chip);
                }

                var sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
                if (
                    sortActive &&
                    sortActive.getAttribute("data-val") !== "nearest"
                ) {
                    addChip("Sort: " + sortActive.textContent.trim().replace(/\n/g, ' '), function () {
                        document.querySelectorAll('#fSortGroup .ftag').forEach(function (b) {
                            b.classList.remove('ftag-active');
                        });
                        var defSort = document.querySelector(
                            '#fSortGroup .ftag[data-val="nearest"]'
                        );
                        if (defSort) defSort.classList.add('ftag-active');
                    });
                }

                var fDate = document.getElementById("fromDate");
                var tDate = document.getElementById("toDate");
                var activePresetBtn = document.querySelector('#datePresetGroup .quick-date-chip.active');

                if (activePresetBtn) {
                    addChip(activePresetBtn.textContent.trim(), function () {
                        activePresetBtn.classList.remove("active");
                        if (fDate) fDate.value = "";
                        if (tDate) tDate.value = "";
                        activeDatePreset = "";
                    });
                } else if (fDate && tDate && (fDate.value || tDate.value)) {
                    var lbl = fDate.value && tDate.value ? (fDate.value + " to " + tDate.value) : (fDate.value ?
                        "From " + fDate.value : "Until " + tDate.value);

                    addChip(lbl, function () {
                        fDate.value = "";
                        tDate.value = "";
                        activeDatePreset = "";
                    });
                }

                var course = document.querySelector('input[name="course"]:checked');
                if (course) addChip(course.value, function () {
                    course.checked = false;
                });

                var year = document.querySelector('input[name="year"]:checked');
                if (year) addChip(year.value, function () {
                    year.checked = false;
                });

                var sectionElem = document.querySelector('input[name="section"]:checked');
                if (sectionElem) addChip("Section " + sectionElem.value, function () {
                    sectionElem.checked = false;
                });

                var dept = document.querySelector('input[name="department"]:checked');
                if (dept) addChip(dept.value, function () {
                    dept.checked = false;
                });

                if (hasChips) {
                    section.classList.remove("hidden");
                    var clearAllBtn = document.getElementById("clearAllChipsBtn");
                    if (clearAllBtn) {
                        clearAllBtn.onclick = function () {
                            clearFormState();
                            renderFilterChips();

                            selectedDepartment = null;
                            selectedProgram = null;
                            selectedYearLevel = null;
                            selectedSection = null;
                            activeFromDate = "";
                            activeToDate = "";
                            dateSort = 'nearest';
                            nameSort = null;

                            applyFilters();
                        };
                    }
                } else {
                    section.classList.add("hidden");
                }

                updateShowResultsButton();
            }

            if (filterModal) {
                var radioInputs = filterModal.querySelectorAll('input[type="radio"]');

                radioInputs.forEach(function (input) {
                    input.addEventListener("change", function () {
                        renderFilterChips();
                        syncMutualExclusion();
                        updateShowResultsButton();
                    });
                });
            }

            window.bindQuickDatePresets({
                groupId: "datePresetGroup",
                fromId: "fromDate",
                toId: "toDate",
                onChange: function () {
                    var activePresetBtn = document.querySelector(
                        "#datePresetGroup .quick-date-chip.active");
                    activeDatePreset = activePresetBtn ? activePresetBtn.getAttribute(
                        "data-range") : "";

                    renderFilterChips();
                    updateShowResultsButton();
                }
            });

            function anyChecked(list) {
                return list.some(function (i) {
                    return i.checked;
                });
            }

            function setDisabled(list, d) {
                list.forEach(function (i) {
                    i.disabled = d;
                    var label = i.closest("label");
                    if (label) {
                        label.classList.toggle("opacity-50", d);
                        label.classList.toggle("cursor-not-allowed", d);
                    }
                });
            }

            function clearChecked(list) {
                list.forEach(function (i) {
                    i.checked = false;
                });
            }

            function ilike(val, t) {
                return (val || "").toLowerCase().includes((t || "").toLowerCase());
            }

            function syncMutualExclusion() {
                if (anyChecked(deptRadios)) {
                    clearChecked(otherRadios);
                    setDisabled(otherRadios, true);
                    setDisabled(deptRadios, false);
                    return;
                }
                if (anyChecked(otherRadios)) {
                    clearChecked(deptRadios);
                    setDisabled(deptRadios, true);
                    setDisabled(otherRadios, false);
                    return;
                }
                setDisabled(deptRadios, false);
                setDisabled(otherRadios, false);
            }
            deptRadios.concat(otherRadios).forEach(function (r) {
                r.addEventListener("change", syncMutualExclusion);
            });

            function getInfo(p) {
                var infoEl = p.querySelector(".patient-info");
                var parts = ((infoEl ? infoEl.textContent.trim() : "") || "").split("|").map(function (s) {
                    return s.trim();
                });
                return {
                    program: parts[0] || "",
                    year: parts[1] || "",
                    section: parts[2] || "",
                    dateStr: parts[3] || "",
                    department: parts[4] || p.getAttribute("data-department") || "",
                    createdAt: parts[5] || ""
                };
            }

            function getPatientAppointmentTime(patient) {
                var dateValue =
                    getInfo(patient).dateStr;

                if (!dateValue) {
                    return null;
                }

                var timestamp = Date.parse(
                    dateValue + "T00:00:00"
                );

                return Number.isNaN(timestamp) ?
                    null :
                    timestamp;
            }

            function getPatientDateRank(patient) {
                var appointmentTime =
                    getPatientAppointmentTime(patient);

                if (appointmentTime === null) {
                    return {
                        group: 3,
                        distance: Number.MAX_SAFE_INTEGER
                    };
                }

                var today = new Date();

                today.setHours(0, 0, 0, 0);

                var difference =
                    appointmentTime - today.getTime();

                if (difference === 0) {
                    return {
                        group: 0,
                        distance: 0
                    };
                }

                if (difference > 0) {
                    return {
                        group: 1,
                        distance: difference
                    };
                }

                return {
                    group: 2,
                    distance: Math.abs(difference)
                };
            }

            function compareNearestAppointments(
                firstPatient,
                secondPatient
            ) {
                var firstRank =
                    getPatientDateRank(firstPatient);

                var secondRank =
                    getPatientDateRank(secondPatient);

                if (firstRank.group !== secondRank.group) {
                    return firstRank.group - secondRank.group;
                }

                return (
                    firstRank.distance -
                    secondRank.distance
                );
            }

            function getName(patient) {
                var element = patient.querySelector(
                    ".patient-list-name, .patient-grid-name"
                );

                return element ?
                    element.textContent.trim() :
                    "";
            }

            function getService(patient) {
                var serviceBlock = patient.querySelector(
                    ".patient-service-block"
                );

                if (!serviceBlock) {
                    var gridItems = patient.querySelectorAll(
                        ".global-info-item"
                    );

                    for (var index = 0; index < gridItems.length; index++) {
                        var label = gridItems[index].querySelector(
                            ".global-info-label"
                        );

                        if (
                            label &&
                            label.textContent.trim().toLowerCase() ===
                            "service"
                        ) {
                            return gridItems[index]
                                .querySelector("strong")
                                ?.textContent
                                ?.trim() || "";
                        }
                    }

                    return "";
                }

                var serviceName =
                    serviceBlock.querySelector(".font-semibold");

                return serviceName ?
                    serviceName.textContent.trim() :
                    "";
            }

            function getIdText(patient) {
                var element = patient.querySelector(
                    ".global-info-pill"
                );

                return element ?
                    element.textContent.trim() :
                    "";
            }

            function matchesSearch(patient, keyword) {
                if (!keyword) return true;

                var info = getInfo(patient);

                var searchableText = [
                    getName(patient),
                    getService(patient),
                    getIdText(patient),
                    info.program,
                    info.year,
                    info.section,
                    info.department,
                    info.dateStr
                ]
                    .join(" ")
                    .toLowerCase();

                return searchableText.includes(
                    keyword.toLowerCase()
                );
            }

            function updateFilterButtonState() {
                var count = 0;

                if (document.querySelector('input[name="course"]:checked')) count++;
                if (document.querySelector('input[name="year"]:checked')) count++;
                if (document.querySelector('input[name="section"]:checked')) count++;
                if (document.querySelector('input[name="department"]:checked')) count++;

                if (activeFromDate || activeToDate || activeDatePreset) count++;

                var sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
                if (sortActive && sortActive.getAttribute("data-val") !== "nearest") count++;

                var has = count > 0;

                if (filterBtn) {
                    filterBtn.classList.toggle("has-filters", has);
                }

                if (filterBadge) {
                    if (has) {
                        filterBadge.classList.remove("hidden");
                        filterBadge.style.display = "inline-flex";
                        filterBadge.textContent = count;
                    } else {
                        filterBadge.classList.add("hidden");
                        filterBadge.style.display = "none";
                        filterBadge.textContent = "";
                    }
                }

                if (externalClearFilterBtn) {
                    if (has) {
                        externalClearFilterBtn.classList.remove('hidden');
                    } else {
                        externalClearFilterBtn.classList.add('hidden');
                    }
                }
            }

            if (externalClearFilterBtn) {
                externalClearFilterBtn.onclick = function () {
                    resetAllFilters();
                };
            }

            if (searchInput) {
                searchInput.addEventListener("input", function () {
                    searchKeyword = searchInput.value.trim().toLowerCase();
                    applyFilters();
                });
            }

            window.bindFilterTagGroup({
                groupId: "fSortGroup",
                onChange: function () {
                    renderFilterChips();
                    updateShowResultsButton();
                }
            });

            var tabButtons = document.querySelectorAll(
                "#tabsGrid .filter-btn"
            );

            tabButtons.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    selectPatientStatus(
                        btn.getAttribute("data-filter") || "all"
                    );

                    var dropdown =
                        document.getElementById("patientStatsDropdown");

                    var toggle =
                        document.getElementById("patientStatsToggle");

                    if (dropdown) {
                        dropdown.classList.remove("open");
                    }

                    if (toggle) {
                        toggle.setAttribute(
                            "aria-expanded",
                            "false"
                        );
                    }

                    applyFilters();
                });
            });

            if (applyFiltersBtn) {
                applyFiltersBtn.onclick = function () {
                    var draft = getDraftFilterState();

                    selectedDepartment = draft.department;
                    selectedProgram = draft.program;
                    selectedYearLevel = draft.year;
                    selectedSection = draft.section;
                    activeFromDate = draft.fromDate;
                    activeToDate = draft.toDate;

                    var activePresetBtn = document.querySelector(
                        '#datePresetGroup .quick-date-chip.active');
                    activeDatePreset = activePresetBtn ? activePresetBtn.getAttribute("data-range") : "";

                    var sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
                    var sortVal = sortActive ?
                        sortActive.getAttribute("data-val") :
                        "nearest";

                    if (sortVal === "az") {
                        nameSort = "az";
                        dateSort = null;
                    } else if (sortVal === "za") {
                        nameSort = "za";
                        dateSort = null;
                    } else if (sortVal === "nearest") {
                        dateSort = "nearest";
                        nameSort = null;
                    } else if (sortVal === "farthest") {
                        dateSort = "farthest";
                        nameSort = null;
                    }

                    selectPatientStatus("all");
                    if (filterModal) closeFilterModal();

                    syncMutualExclusion();
                    applyFilters();
                    updateFilterButtonState();
                };
            }

            if (clearFiltersModalBtn) {
                clearFiltersModalBtn.onclick = function () {
                    resetPatientPanelFilters();
                    renderFilterChips();
                    updateShowResultsButton();
                };
            }

            var pageInfoTop = document.getElementById("patientPageInfoTop");
            var pageInfoBottom = document.getElementById("patientPageInfoBottom");

            var paginationTop = document.getElementById("patientPaginationTop");
            var paginationBottom = document.getElementById("patientPaginationBottom");

            var perPageInput = document.getElementById("patientPerPage");

            var PER_PAGE = Number(perPageInput?.value || 10);
            var currentPage = 1;
            var currentItems = [];

            function patientBuildPagination() {
                var totalItems = currentItems.length;
                var lastPage = Math.max(1, Math.ceil(totalItems / PER_PAGE));
                var current = Math.min(Math.max(currentPage, 1), lastPage);

                if (totalItems === 0 || lastPage <= 1) {
                    return "";
                }

                var windowSize = 5;
                var half = Math.floor(windowSize / 2);

                var start = Math.max(1, current - half);
                var end = Math.min(lastPage, start + windowSize - 1);

                if (end - start + 1 < windowSize) {
                    start = Math.max(1, end - windowSize + 1);
                }

                var html =
                    '<nav class="global-pagination" aria-label="Patient pagination">';

                if (current <= 1) {
                    html +=
                        '<button type="button" class="global-page-disabled" ' +
                        'aria-label="Previous page" disabled>' +
                        '<i class="fa-solid fa-chevron-left global-page-icon"></i>' +
                        '</button>';
                } else {
                    html +=
                        '<button type="button" class="global-page-btn" ' +
                        'aria-label="Previous page" ' +
                        'onclick="patientGoPage(' + (current - 1) + ')">' +
                        '<i class="fa-solid fa-chevron-left global-page-icon"></i>' +
                        '</button>';
                }

                if (start > 1) {
                    html +=
                        '<button type="button" class="global-page-btn" ' +
                        'onclick="patientGoPage(1)">1</button>';

                    if (start > 2) {
                        html +=
                            '<span class="global-page-ellipsis" aria-hidden="true">' +
                            '&hellip;' +
                            '</span>';
                    }
                }

                for (var page = start; page <= end; page++) {
                    if (page === current) {
                        html +=
                            '<span class="global-page-current" aria-current="page">' +
                            page +
                            '</span>';
                    } else {
                        html +=
                            '<button type="button" class="global-page-btn" ' +
                            'onclick="patientGoPage(' + page + ')">' +
                            page +
                            '</button>';
                    }
                }

                if (end < lastPage) {
                    if (end < lastPage - 1) {
                        html +=
                            '<span class="global-page-ellipsis" aria-hidden="true">' +
                            '&hellip;' +
                            '</span>';
                    }

                    html +=
                        '<button type="button" class="global-page-btn" ' +
                        'onclick="patientGoPage(' + lastPage + ')">' +
                        lastPage +
                        '</button>';
                }

                if (current >= lastPage) {
                    html +=
                        '<button type="button" class="global-page-disabled" ' +
                        'aria-label="Next page" disabled>' +
                        '<i class="fa-solid fa-chevron-right global-page-icon"></i>' +
                        '</button>';
                } else {
                    html +=
                        '<button type="button" class="global-page-btn" ' +
                        'aria-label="Next page" ' +
                        'onclick="patientGoPage(' + (current + 1) + ')">' +
                        '<i class="fa-solid fa-chevron-right global-page-icon"></i>' +
                        '</button>';
                }

                html += "</nav>";

                return html;
            }

            function renderPatientPagebars() {
                var totalItems = currentItems.length;
                var lastPage = Math.max(1, Math.ceil(totalItems / PER_PAGE));

                if (currentPage > lastPage) {
                    currentPage = lastPage;
                }

                if (currentPage < 1) {
                    currentPage = 1;
                }

                var from = totalItems > 0 ?
                    ((currentPage - 1) * PER_PAGE) + 1 :
                    0;

                var to = totalItems > 0 ?
                    Math.min(currentPage * PER_PAGE, totalItems) :
                    0;

                var infoHtml = totalItems > 0 ?
                    'Showing <strong>' + from + '–' + to +
                    '</strong> of <strong>' + totalItems +
                    '</strong> ' + (totalItems === 1 ? 'patient' : 'patients') :
                    'Showing <strong>0</strong> patients';

                if (pageInfoTop) {
                    pageInfoTop.innerHTML = infoHtml;
                }

                if (pageInfoBottom) {
                    pageInfoBottom.innerHTML = infoHtml;
                }

                var paginationHtml = patientBuildPagination();

                if (paginationTop) {
                    paginationTop.innerHTML = paginationHtml;
                }

                if (paginationBottom) {
                    paginationBottom.innerHTML = paginationHtml;
                }

                if (perPageInput) {
                    perPageInput.value = String(PER_PAGE);

                    window.syncGlobalPageSizeSelect?.(
                        perPageInput,
                        PER_PAGE
                    );
                }
            }

            function setPatientEmptyVisible(element, visible) {
                if (!element) return;

                element.hidden = !visible;

                element.classList.toggle("hidden", !visible);
                element.classList.toggle("show", visible);
                element.classList.toggle("is-visible", visible);
            }

            function getCurrentPatientStatus() {
                var activeButton = document.querySelector(
                    "#tabsGrid .filter-btn.tab-active"
                );

                return activeButton ?
                    activeButton.getAttribute("data-filter") || "all" :
                    activeTab || "all";
            }

            function getPatientStatusEmptyMeta(status) {
                var map = {
                    today: {
                        icon: "fa-solid fa-clock",
                        title: "No patients today",
                        text: "There are currently no patient appointments scheduled for today."
                    },

                    upcoming: {
                        icon: "fa-regular fa-calendar-check",
                        title: "No upcoming patients",
                        text: "There are currently no upcoming patient appointments."
                    },

                    rescheduled: {
                        icon: "fa-solid fa-rotate-right",
                        title: "No rescheduled patients",
                        text: "There are currently no rescheduled patient appointments."
                    },

                    completed: {
                        icon: "fa-solid fa-circle-check",
                        title: "No completed patients",
                        text: "Completed patient appointments will appear here."
                    },

                    cancelled: {
                        icon: "fa-regular fa-calendar-xmark",
                        title: "No cancelled patients",
                        text: "Cancelled patient appointments will appear here."
                    },

                    all: {
                        icon: "fa-solid fa-sliders",
                        title: "No patients match your filters",
                        text: "Try removing or changing the selected filter criteria."
                    }
                };

                return map[status] || map.all;
            }

            function updateFilteredEmptyState() {
                var hasResults = currentItems.length > 0;
                var hasSearch = searchKeyword.trim().length > 0;

                var hasAdvancedFilters = Boolean(
                    selectedProgram ||
                    selectedYearLevel ||
                    selectedSection ||
                    selectedDepartment ||
                    activeFromDate ||
                    activeToDate ||
                    activeDatePreset ||
                    nameSort ||
                    dateSort !== "nearest"
                );

                var currentStatus = getCurrentPatientStatus();

                var isStatusOnlyEmptyState = !hasSearch &&
                    !hasAdvancedFilters &&
                    currentStatus !== "all";

                setPatientEmptyVisible(
                    patientSearchEmptyState,
                    false
                );

                setPatientEmptyVisible(
                    patientStatusEmptyState,
                    false
                );

                if (resetPatientFiltersBtn) {
                    var showClearFiltersButton =
                        hasAdvancedFilters &&
                        !isStatusOnlyEmptyState;

                    resetPatientFiltersBtn.hidden = !showClearFiltersButton;

                    resetPatientFiltersBtn.classList.toggle(
                        "hidden",
                        !showClearFiltersButton
                    );

                    resetPatientFiltersBtn.classList.toggle(
                        "is-hidden",
                        !showClearFiltersButton
                    );

                    resetPatientFiltersBtn.style.display =
                        showClearFiltersButton ?
                            "inline-flex" :
                            "none";
                }

                if (hasResults) {
                    return;
                }

                if (allPatients.length === 0) {
                    return;
                }

                if (hasSearch) {
                    if (patientSearchEmptyTitle) {
                        patientSearchEmptyTitle.textContent =
                            'No results for "' +
                            searchKeyword +
                            '"';
                    }

                    setPatientEmptyVisible(
                        patientSearchEmptyState,
                        true
                    );

                    return;
                }

                if (
                    currentStatus === "all" &&
                    !hasAdvancedFilters
                ) {
                    return;
                }

                var meta = getPatientStatusEmptyMeta(
                    hasAdvancedFilters ?
                        "all" :
                        currentStatus
                );

                if (patientStatusEmptyIcon) {
                    patientStatusEmptyIcon.className =
                        meta.icon;
                }

                if (patientStatusEmptyTitle) {
                    patientStatusEmptyTitle.textContent =
                        meta.title;
                }

                if (patientStatusEmptyText) {
                    patientStatusEmptyText.textContent =
                        meta.text;
                }

                setPatientEmptyVisible(
                    patientStatusEmptyState,
                    true
                );
            }

            function updatePage() {
                var totalItems = currentItems.length;
                var startIndex = (currentPage - 1) * PER_PAGE;
                var endIndex = startIndex + PER_PAGE;

                allPatients.forEach(function (patient) {
                    patient.classList.add("hidden");
                });

                currentItems
                    .slice(startIndex, endIndex)
                    .forEach(function (patient) {
                        patient.classList.remove("hidden");
                    });

                var hasVisiblePatients = currentItems.length > 0;

                if (colHeader) {
                    colHeader.classList.toggle(
                        "hidden",
                        !hasVisiblePatients
                    );
                }

                updateFilteredEmptyState();
                renderPatientPagebars();
            }

            window.patientGoPage = function (page) {
                var lastPage = Math.max(
                    1,
                    Math.ceil(currentItems.length / PER_PAGE)
                );

                var nextPage = Number(page) || 1;

                if (nextPage < 1 || nextPage > lastPage) {
                    return;
                }

                if (nextPage === currentPage) {
                    return;
                }

                currentPage = nextPage;

                updatePage();

                document
                    .querySelector(".patient-table-card")
                    ?.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
            };

            window.changePatientPageSize = function (value) {
                var nextSize = Number(value);

                if (!Number.isFinite(nextSize) || nextSize <= 0) {
                    nextSize = 10;
                }

                PER_PAGE = nextSize;
                currentPage = 1;

                updatePage();
            };

            function applyFilters() {
                showPatientSkeleton();

                window.clearTimeout(window.patientDirectoryFilterTimer);
                window.patientDirectoryFilterTimer = window.setTimeout(function () {
                    try {
                        var data = allPatients.slice();

                        if (activeTab !== "all") {
                            data = data.filter(function (patient) {
                                return patient.classList.contains(activeTab);
                            });
                        }

                        if (searchKeyword) {
                            data = data.filter(function (patient) {
                                return matchesSearch(patient, searchKeyword);
                            });
                        }

                        if (selectedProgram) {
                            data = data.filter(function (patient) {
                                return ilike(
                                    getInfo(patient).program,
                                    selectedProgram
                                );
                            });
                        }

                        if (selectedYearLevel || selectedSection) {
                            data = data.filter(function (patient) {
                                var info = getInfo(patient);

                                if (
                                    selectedYearLevel &&
                                    !ilike(info.year, selectedYearLevel)
                                ) {
                                    return false;
                                }

                                if (
                                    selectedSection &&
                                    String(info.section).trim() !==
                                    String(selectedSection).trim()
                                ) {
                                    return false;
                                }

                                return true;
                            });
                        }

                        if (selectedDepartment) {
                            data = data.filter(function (patient) {
                                return ilike(
                                    getInfo(patient).department,
                                    selectedDepartment
                                );
                            });
                        }

                        if (activeFromDate || activeToDate) {
                            data = data.filter(function (patient) {
                                var date = new Date(
                                    getInfo(patient).dateStr
                                );

                                if (isNaN(date.getTime())) {
                                    return false;
                                }

                                if (
                                    activeFromDate &&
                                    date < new Date(activeFromDate)
                                ) {
                                    return false;
                                }

                                if (
                                    activeToDate &&
                                    date > new Date(activeToDate)
                                ) {
                                    return false;
                                }

                                return true;
                            });
                        }

                        if (nameSort === "az") data.sort(function (a, b) {
                            return getName(a).localeCompare(getName(b));
                        });
                        if (nameSort === "za") data.sort(function (a, b) {
                            return getName(b).localeCompare(getName(a));
                        });
                        if (dateSort === "nearest") {
                            data.sort(compareNearestAppointments);
                        }

                        if (dateSort === "farthest") {
                            data.sort(function (
                                firstPatient,
                                secondPatient
                            ) {
                                return compareNearestAppointments(
                                    secondPatient,
                                    firstPatient
                                );
                            });
                        }

                        var rowCountEl = document.getElementById("rowCount");
                        if (rowCountEl) {
                            rowCountEl.textContent = data.length + " " + (data.length === 1 ?
                                "patient" :
                                "patients");
                        }

                        currentItems = data;
                        currentPage = 1;

                        updatePage();
                        updateFilterButtonState();
                    } catch (error) {
                        console.error("Patient list filtering error:", error);
                    } finally {
                        hidePatientSkeleton();
                    }
                }, 300);
            }

            syncMutualExclusion();

            document.querySelectorAll('.filter-btn').forEach(function (b) {
                b.classList.remove('tab-active');
            });

            var allPatientsBtn = document.querySelector(
                '.filter-btn[data-filter="all"]'
            );

            if (allPatientsBtn) {
                allPatientsBtn.classList.add('tab-active');
            }

            activeTab = "all";

            updatePatientStatsDropdownLabel();
            window.initGlobalPageSizeSelects?.(document);

            applyFilters();

        } catch (err) {
            console.error("Initialization Error:", err);
        }
    });
</script>
@endsection