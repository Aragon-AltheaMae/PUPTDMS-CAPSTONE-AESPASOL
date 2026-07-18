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
                                        <button type="button" class="patient-stats-trigger" id="patientStatsToggle"
                                            aria-expanded="false">
                                            <span class="patient-stats-trigger-left">
                                                <span class="patient-stats-trigger-icon">
                                                    <i class="fa-solid fa-calendar-day"></i>
                                                </span>

                                                <span class="patient-stats-trigger-text">
                                                    <span class="patient-stats-trigger-label">Sort by</span>
                                                    <strong id="patientStatsSelectedLabel">Today</strong>
                                                </span>
                                            </span>

                                            <span class="patient-stats-trigger-right">
                                                <span class="patient-stats-count-badge"
                                                    id="patientStatsSelectedCount">{{ $todayCount ?? 0
                                                    }}</span>
                                                <i class="fa-solid fa-chevron-down patient-stats-chevron"></i>
                                            </span>
                                        </button>

                                        <div class="patient-stats-panel" id="patientStatsPanel">
                                            <div id="tabsGrid" class="patient-stats-grid">
                                                <button type="button"
                                                    class="patient-stat-option filter-btn tab-active s-today"
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
                                                        $rescheduledCount ?? 0
                                                        }}</span>
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

                                                <button type="button" class="patient-stat-option filter-btn s-all"
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
                                                <div class="skeleton-pill h-5 w-24"></div>
                                                <div class="skeleton-pill h-5 w-20"></div>
                                            </div>
                                        </div>

                                        <div class="skeleton-circle w-9 h-9 flex-shrink-0"></div>
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

                    <div class="global-pagebar global-pagebar-bottom patient-pagebar">
                        <span id="patientPageInfoBottom" class="global-pagebar-info">
                            Showing <strong>0</strong> patients
                        </span>

                        <div id="patientPaginationBottom" class="global-pagination-wrap">
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

                        $patientId = $patient?->id ?? $appt->patient_id;
                        $patientName = $patient?->name ?? 'Unknown Patient';
                        $patientCourse = $patient?->course ?: 'No Program';
                        $patientYearLevel = $patient?->year_level ?? '';
                        $patientSection = $patient?->section ?? '';
                        $patientDepartment = $patient?->department ?? '';

                        $patientImage = $patient?->profile_image
                        ? asset('storage/' . $patient->profile_image)
                        : 'https://ui-avatars.com/api/?name='
                        . urlencode($patientName)
                        . '&background=660000&color=FFFFFF&rounded=true&size=128';
                        $dateLabel = Carbon::parse($appt->appointment_date)->format('d M Y');
                        $timeLabel = Carbon::parse($appt->appointment_time)->format('g:i A');
                        $serviceLabel =
                        $appt->service_type === 'Others'
                        ? ($appt->other_services ?:
                        'Others')
                        : $appt->service_type;

                        $accentClass = $isCancelled
                        ? 'accent-cancelled'
                        : ($isCompleted
                        ? 'accent-completed'
                        : ($isRescheduled
                        ? 'accent-rescheduled'
                        : ($isToday
                        ? 'accent-today'
                        : ($isUpcoming
                        ? 'accent-upcoming'
                        : 'accent-default'))));
                        $iconBg = $isCancelled
                        ? 'bg-red-100'
                        : ($isCompleted
                        ? 'bg-green-100'
                        : ($isRescheduled
                        ? 'bg-yellow-100'
                        : ($isToday
                        ? 'bg-blue-50'
                        : ($isUpcoming
                        ? 'bg-orange-100'
                        : 'bg-gray-100'))));
                        $iconColor = $isCancelled
                        ? 'text-red-600'
                        : ($isCompleted
                        ? 'text-green-600'
                        : ($isRescheduled
                        ? 'text-yellow-600'
                        : ($isToday
                        ? 'text-blue-600'
                        : ($isUpcoming
                        ? 'text-orange-600'
                        : 'text-gray-500'))));
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
                        ? ($daysDiff === 0
                        ? 'urgency-today'
                        : ($daysDiff === 1
                        ? 'urgency-tomorrow'
                        : 'urgency-upcoming'))
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

                                <div class="accent-bar {{ $accentClass }}"></div>

                                <div class="card-body-desktop items-center gap-5 px-8 py-4 pl-10">
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ $patientImage }}"
                                            class="patient-avatar w-14 h-14 rounded-full object-cover shadow-sm"
                                            alt="{{ $patientName }}" />
                                    </div>
                                    <div class="w-44 flex-shrink-0">
                                        <p class="font-semibold text-[#1a1a1a] text-sm leading-tight">
                                            {{ $patientName }}</p>
                                        <span
                                            class="inline-flex px-2.5 py-0.5 rounded-md bg-gray-200 text-gray-600 text-[10px] font-bold tracking-wide w-max">
                                            {{ $patientCourse }}
                                        </span>
                                        <span class="patient-info hidden">
                                            {{ $patientCourse }}|
                                            {{ $patientYearLevel }}|
                                            {{ $patientSection }}|
                                            {{ $appt->appointment_date }}|
                                            {{ $patientDepartment }}|
                                            {{ optional($appt->created_at)->toDateTimeString() }}
                                        </span>
                                    </div>
                                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>
                                    <div
                                        class="patient-meta-block patient-date-block flex items-start gap-3 w-44 flex-shrink-0">
                                        <div class="icon-box {{ $iconBg }} flex-shrink-0">
                                            <i class="fa-regular fa-calendar {{ $iconColor }} text-base"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">
                                                Date &amp; Time
                                            </p>
                                            <p class="font-semibold text-[#1a1a1a] text-sm">
                                                {{ $dateLabel }}</p>
                                            <p class="text-gray-500 text-xs mt-0.5">{{ $timeLabel }}</p>
                                            @if ($showDateUrgency)
                                            <span class="urgency-chip {{ $urgencyClass }}">
                                                {{ $urgencyLabel }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>
                                    <div
                                        class="patient-meta-block patient-service-block flex items-start gap-3 flex-1 min-w-0">
                                        <div class="icon-box {{ $iconBg }} flex-shrink-0">
                                            <i class="fa-solid fa-tooth {{ $iconColor }} text-base"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p
                                                class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">
                                                Service</p>
                                            <p class="font-semibold text-[#1a1a1a] text-sm">
                                                {{ $serviceLabel }}</p>
                                            <span class="status-pill {{ $pillClass }}">
                                                <span class="pill-dot"></span>{{ $pillText }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="patient-actions">
                                        <span class="patient-action-chip">
                                            <i class="fa-regular fa-user"></i>
                                            View
                                        </span>
                                        <span class="patient-action-chip patient-action-primary">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body-mobile redesigned-grid-card w-full h-full relative">

                                    <div class="grid-card-top mobile-profile-header">
                                        <div class="mobile-avatar-row">
                                            <div class="grid-avatar-wrap">
                                                <img src="{{ $patientImage }}"
                                                    class="patient-avatar grid-patient-avatar object-cover shadow-sm"
                                                    alt="{{ $patientName }}" />
                                            </div>

                                            <div class="card-arrow-btn grid-arrow-btn">
                                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                            </div>
                                        </div>

                                        <div class="grid-patient-main">
                                            <h3 class="patient-grid-name">
                                                {{ $patientName }}
                                            </h3>

                                            <div class="grid-badge-row">
                                                <span class="status-pill {{ $pillClass }} grid-status-pill">
                                                    <span class="pill-dot"></span>{{ $pillText }}
                                                </span>

                                                <span class="grid-program-pill">
                                                    {{ $patientCourse }}
                                                </span>
                                            </div>

                                            <span class="patient-info hidden">
                                                {{ $patientCourse }}|
                                                {{ $patientYearLevel }}|
                                                {{ $patientSection }}|
                                                {{ $appt->appointment_date }}|
                                                {{ $patientDepartment }}|
                                                {{ optional($appt->created_at)->toDateTimeString() }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid-info-stack">
                                        <div class="grid-info-item">
                                            <div class="grid-info-icon {{ $iconBg }}">
                                                <i class="fa-regular fa-calendar {{ $iconColor }}"></i>
                                            </div>
                                            <div class="grid-info-text">
                                                <span class="grid-info-label">Date &amp; Time</span>
                                                <strong>{{ $dateLabel }} · {{ $timeLabel }}</strong>
                                            </div>
                                        </div>

                                        <div class="grid-info-item">
                                            <div class="grid-info-icon {{ $iconBg }}">
                                                <i class="fa-solid fa-tooth {{ $iconColor }}"></i>
                                            </div>
                                            <div class="grid-info-text">
                                                <span class="grid-info-label">Service</span>
                                                <strong>{{ $serviceLabel }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid-card-footer">
                                        <span class="grid-action-pill">
                                            <i class="fa-regular fa-user"></i>
                                            View Profile
                                        </span>

                                        @if ($showDateUrgency)
                                        <span class="grid-urgency-pill {{ $urgencyClass }}">
                                            {{ $urgencyLabel }}
                                        </span>
                                        @endif
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

                        <p class="empty-state-title">No appointments found</p>
                        <p class="empty-state-sub">There are no appointments in the system yet.</p>
                    </div>
                    @endforelse
                </div>
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
                    <button type="button" class="ftag ftag-active" data-val="newest">Newest First</button>
                    <button type="button" class="ftag" data-val="oldest">Oldest First</button>
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
                    'BSBA - MM',
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

                    <span class="filter-results-text">
                        Show results
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

        return map[status] || map.today;
    }

    function getPatientDropdownCount(status) {
        const meta = getPatientDropdownMeta(status);
        return document.getElementById(meta.countId)?.textContent?.trim() || '0';
    }

    function updatePatientStatsDropdownLabel() {
        const activeBtn =
            document.querySelector('#tabsGrid .filter-btn.tab-active') ||
            document.querySelector('#tabsGrid .filter-btn[data-filter="today"]');

        const labelEl = document.getElementById('patientStatsSelectedLabel');
        const countEl = document.getElementById('patientStatsSelectedCount');
        const leadingIcon = document.querySelector('#patientStatsToggle .patient-stats-trigger-icon');

        if (!activeBtn || !labelEl || !countEl) return;

        const status = activeBtn.getAttribute('data-filter') || 'today';
        const meta = getPatientDropdownMeta(status);

        labelEl.textContent = meta.label;
        countEl.textContent = getPatientDropdownCount(status);

        if (leadingIcon) {
            leadingIcon.className = `patient-stats-trigger-icon ${meta.tone}`;
            leadingIcon.innerHTML = `<i class="fa-solid ${meta.icon}"></i>`;
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

        document.querySelectorAll('#tabsGrid .filter-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#tabsGrid .filter-btn').forEach(function (b) {
                    b.classList.remove('tab-active');
                });

                btn.classList.add('tab-active');
                updatePatientStatsDropdownLabel();
                closePatientStatsDropdown();
            });
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

        function resetAllFilters() {
            clearFormState();

            selectedDepartment = null;
            selectedProgram = null;
            selectedYearLevel = null;
            selectedSection = null;
            activeFromDate = "";
            activeToDate = "";
            dateSort = 'desc';
            nameSort = null;
            searchKeyword = "";

            if (patientSearchInput) {
                patientSearchInput.value = "";
                patientSearchInput.dispatchEvent(new Event("input", {
                    bubbles: true
                }));
            }

            activeTab = "today";
            document.querySelectorAll('.filter-btn').forEach(function (b) {
                b.classList.remove('tab-active');
            });
            var todayBtn = document.querySelector('.filter-btn[data-filter="today"]');
            if (todayBtn) {
                todayBtn.classList.add('tab-active');
            }

            renderFilterChips();
            syncMutualExclusion();
            applyFilters();
            updateFilterButtonState();
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

            patientFilterModal = filterModal;
            patientSearchInput = searchInput;
            patientFilterBtn = filterBtn;
            patientFilterBadge = filterBadge;
            patientExternalResetBtn = externalClearFilterBtn;

            var activeTab = "today";
            var searchKeyword = "";
            var selectedProgram = null,
                selectedYearLevel = null,
                selectedSection = null,
                selectedDepartment = null;
            var nameSort = null,
                dateSort = 'desc';

            var activeFromDate = "",
                activeToDate = "",
                activeDatePreset = "";

            var deptRadios = Array.from(document.querySelectorAll('input[name="department"]'));
            var courseRadios = Array.from(document.querySelectorAll('input[name="course"]'));
            var yearRadios = Array.from(document.querySelectorAll('input[name="year"]'));
            var sectionRadios = Array.from(document.querySelectorAll('input[name="section"]'));
            var otherRadios = courseRadios.concat(yearRadios, sectionRadios);

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

                window.syncFilterTagGroup("fSortGroup", "newest");

                syncMutualExclusion();
                updateFilterButtonState();

                dateSort = 'desc';
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
                var sortVal = sortActive ? sortActive.getAttribute('data-val') : 'newest';

                return !!(
                    draft.department ||
                    draft.program ||
                    draft.year ||
                    draft.section ||
                    draft.fromDate ||
                    draft.toDate ||
                    activeDatePreset ||
                    sortVal !== 'newest'
                );
            }

            function countDraftResults() {
                var draft = getDraftFilterState();
                var data = allPatients.slice();

                if (searchKeyword) {
                    data = data.filter(function (p) {
                        return matchesSearch(p, searchKeyword);
                    });
                } else {

                    if (draft.program) {
                        data = data.filter(function (p) {
                            return ilike(getInfo(p).program, draft.program);
                        });
                    }

                    if (draft.year || draft.section) {
                        data = data.filter(function (p) {
                            var i = getInfo(p);

                            if (draft.year && !ilike(i.year, draft.year)) return false;
                            if (draft.section && String(i.section).trim() !== String(draft.section)
                                .trim()) return false;

                            return true;
                        });
                    }

                    if (draft.department) {
                        data = data.filter(function (p) {
                            return ilike(getInfo(p).department, draft.department);
                        });
                    }

                    if (draft.fromDate || draft.toDate) {
                        data = data.filter(function (p) {
                            var d = new Date(getInfo(p).dateStr);
                            if (isNaN(d.getTime())) return false;
                            if (draft.fromDate && d < new Date(draft.fromDate)) return false;
                            if (draft.toDate && d > new Date(draft.toDate)) return false;
                            return true;
                        });
                    }
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
                if (sortActive && sortActive.getAttribute('data-val') !== 'newest') {
                    addChip("Sort: " + sortActive.textContent.trim().replace(/\n/g, ' '), function () {
                        document.querySelectorAll('#fSortGroup .ftag').forEach(function (b) {
                            b.classList.remove('ftag-active');
                        });
                        var defSort = document.querySelector('#fSortGroup .ftag[data-val="newest"]');
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
                            dateSort = 'desc';
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

            function getName(p) {
                var el = p.querySelector(".font-semibold");
                return (el ? el.textContent : "").trim();
            }

            function getService(p) {
                var el = p.querySelector(".truncate");
                return (el ? el.textContent : "").trim();
            }

            function getIdText(p) {
                var el = p.querySelector(".text-gray-500.text-\\[11px\\]");
                return el ? el.textContent.trim() : "";
            }

            function matchesSearch(p, kw) {
                if (!kw) return true;
                var info = getInfo(p);
                var haystack = [getName(p), getService(p), getIdText(p), info.program, info.department, info
                    .dateStr
                ].join(" ").toLowerCase();
                return haystack.includes(kw);
            }

            function updateFilterButtonState() {
                var count = 0;

                if (document.querySelector('input[name="course"]:checked')) count++;
                if (document.querySelector('input[name="year"]:checked')) count++;
                if (document.querySelector('input[name="section"]:checked')) count++;
                if (document.querySelector('input[name="department"]:checked')) count++;

                if (activeFromDate || activeToDate || activeDatePreset) count++;

                var sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
                if (sortActive && sortActive.getAttribute('data-val') !== 'newest') count++;

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

            var tabButtons = document.querySelectorAll('.filter-btn');
            tabButtons.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    activeTab = btn.getAttribute("data-filter");
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
                    var sortVal = sortActive ? sortActive.getAttribute('data-val') : 'newest';

                    if (sortVal === 'az') {
                        nameSort = 'az';
                        dateSort = null;
                    } else if (sortVal === 'za') {
                        nameSort = 'za';
                        dateSort = null;
                    } else if (sortVal === 'newest') {
                        dateSort = 'desc';
                        nameSort = null;
                    } else if (sortVal === 'oldest') {
                        dateSort = 'asc';
                        nameSort = null;
                    }

                    if (filterModal) closeFilterModal();

                    syncMutualExclusion();
                    applyFilters();
                    updateFilterButtonState();
                };
            }

            if (clearFiltersModalBtn) {
                clearFiltersModalBtn.onclick = function () {
                    clearFormState();
                    renderFilterChips();

                    selectedDepartment = null;
                    selectedProgram = null;
                    selectedYearLevel = null;
                    selectedSection = null;
                    activeFromDate = "";
                    activeToDate = "";
                    dateSort = 'desc';
                    nameSort = null;

                    applyFilters();
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

                var from = totalItems > 0
                    ? ((currentPage - 1) * PER_PAGE) + 1
                    : 0;

                var to = totalItems > 0
                    ? Math.min(currentPage * PER_PAGE, totalItems)
                    : 0;

                var infoHtml = totalItems > 0
                    ? 'Showing <strong>' + from + '–' + to +
                    '</strong> of <strong>' + totalItems +
                    '</strong> ' + (totalItems === 1 ? 'patient' : 'patients')
                    : 'Showing <strong>0</strong> patients';

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

                    var data = allPatients.slice();

                    if (searchKeyword) {
                        data = data.filter(function (p) {
                            return matchesSearch(p, searchKeyword);
                        });
                    } else {
                        if (activeTab !== "all") data = data.filter(function (p) {
                            return p.classList.contains(activeTab);
                        });

                        if (selectedProgram) data = data.filter(function (p) {
                            return ilike(getInfo(p).program, selectedProgram);
                        });
                        if (selectedYearLevel || selectedSection) data = data.filter(function (p) {
                            var i = getInfo(p);
                            if (selectedYearLevel && !ilike(i.year, selectedYearLevel))
                                return false;
                            if (selectedSection && String(i.section).trim() !== String(
                                selectedSection)
                                .trim()) return false;
                            return true;
                        });
                        if (selectedDepartment) data = data.filter(function (p) {
                            return ilike(getInfo(p).department, selectedDepartment);
                        });
                        if (activeFromDate || activeToDate) data = data.filter(function (p) {
                            var d = new Date(getInfo(p).dateStr);
                            if (isNaN(d.getTime())) return false;
                            if (activeFromDate && d < new Date(activeFromDate)) return false;
                            if (activeToDate && d > new Date(activeToDate)) return false;
                            return true;
                        });
                    }

                    if (nameSort === "az") data.sort(function (a, b) {
                        return getName(a).localeCompare(getName(b));
                    });
                    if (nameSort === "za") data.sort(function (a, b) {
                        return getName(b).localeCompare(getName(a));
                    });
                    if (dateSort === "asc") data.sort(function (a, b) {
                        return new Date(getInfo(a).createdAt || getInfo(a).dateStr) - new Date(
                            getInfo(b).createdAt || getInfo(b).dateStr);
                    });

                    if (dateSort === "desc") data.sort(function (a, b) {
                        return new Date(getInfo(b).createdAt || getInfo(b).dateStr) - new Date(
                            getInfo(a).createdAt || getInfo(a).dateStr);
                    });

                    var rowCountEl = document.getElementById("rowCount");
                    if (rowCountEl) {
                        rowCountEl.textContent = data.length + " " + (data.length === 1 ? "patient" :
                            "patients");
                    }

                    currentItems = data;
                    currentPage = 1;
                    updatePage();
                    updateFilterButtonState();
                    hidePatientSkeleton();
                }, 600);
            }

            syncMutualExclusion();
            document.querySelectorAll('.filter-btn').forEach(function (b) {
                b.classList.remove('tab-active');
            });
            var todayBtn = document.querySelector('.filter-btn[data-filter="today"]');
            if (todayBtn) todayBtn.classList.add('tab-active');
            window.initGlobalPageSizeSelects?.(document);

            applyFilters();

        } catch (err) {
            console.error("Initialization Error:", err);
        }
    });
</script>
@endsection