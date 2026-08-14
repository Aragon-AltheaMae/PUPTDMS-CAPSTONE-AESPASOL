@extends('layouts.app')

@section('layout-role', 'dentist')

@section('title', 'Dashboard')

@section('usesAppointmentCalendar', true)

@section('content')
    @php
        $dentalCasesThisMonth = $dentalCasesThisMonth ?? 0;
        $totalApptsThisMonth = $totalApptsThisMonth ?? 0;

        $dentalCasesDelta = $dentalCasesDelta ?? null;
        $totalApptsDelta = $totalApptsDelta ?? null;

        $gadLabels = $gadLabels ?? ['Student', 'Administrative', 'Faculty', 'Dependent'];
        $gadFemale = $gadFemale ?? [0, 0, 0, 0];
        $gadMale = $gadMale ?? [0, 0, 0, 0];

        $appointmentCountsPerDay = $appointmentCountsPerDay ?? [];
        $blockedDates = $blockedDates ?? [];
        $philippineHolidays = $philippineHolidays ?? [];
        $todayAppointments = $todayAppointments ?? collect();

        $medicalSupplies = $medicalSupplies ?? collect();
        $medicineSupplies = $medicineSupplies ?? collect();

        $calendarAppointmentCounts = $appointmentCountsPerDay ?? [];
        $calendarAppointmentDetails = $calendarAppointmentDetails ?? [];
    @endphp

    <main id="mainContent" class="dentist-dashboard-page dentist-page-shell page-enter mode-list">
        <div class="w-full">

            <x-dashboard-loading-status />

            <div class="greeting-row">
                <div class="greeting-banner">
                    <div class="greeting-banner-inner">
                        <div class="greeting-banner-copy min-w-0">
                            <h1 class="greeting-heading">
                                <span class="greeting-line">
                                    <span id="greetingText"></span>
                                </span>
                                <span class="greeting-line greeting-name-line">
                                    <span class="greeting-name-prefix">Dr.</span>
                                    <span id="dentistName"></span>
                                    <i class="fa-solid fa-heart-pulse text-rose-300"></i>
                                </span>
                            </h1>
                            <p id="rotatingSubtitle" class="greeting-subtitle"></p>
                        </div>

                        <div class="greeting-banner-actions">
                            <div class="greeting-status-meta">
                                <div class="greeting-status-eyebrow">
                                    <i class="fa-solid fa-circle-plus"></i>
                                    Clinic Status
                                </div>
                                <div class="greeting-status-text">The Dentist is currently</div>
                            </div>

                            <div class="status-btn-wrap">
                                <div class="status-icon-badge">
                                    <i class="fa-solid fa-stethoscope"></i>
                                </div>

                                <button id="statusBtn" onclick="openStatusModal()"
                                    class="ui-btn {{ ($clinicStatus ?? 'in') === 'in' ? 'ui-btn-success' : 'ui-btn-danger' }} ui-btn-sm banner-status-btn">
                                    <span id="statusLabel" class="flex items-center gap-2">

                                        @if (($clinicStatus ?? 'in') === 'in')
                                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                            IN
                                        @else
                                            <span class="w-2 h-2 bg-white rounded-full"></span>
                                            OUT
                                        @endif

                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="kpiGridContainer" class="stat-grid dashboard-kpi-grid skeleton-section skeleton-fade-swap">
                <div class="skeleton-shell space-y-4">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="rounded-2xl h-32 skeleton-block">
                        </div>
                    @endfor
                </div>
            </div>

            <div class="row2-grid">
                {{-- LEFT: Calendar --}}
                <div class="min-w-0">
                    <div id="dentistCalendarContainer"
                        class="w-full h-full min-h-[420px] skeleton-section skeleton-fade-swap">
                        <div class="cal-shell skeleton-shell p-5 sm:p-6 h-full border-none shadow-sm">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="w-8 h-8 rounded-full skeleton-block"></div>
                                    <div class="text-center space-y-2">
                                        <div class="h-5 w-28 skeleton-block rounded mx-auto"></div>
                                        <div class="h-3 w-16 skeleton-line rounded mx-auto"></div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full skeleton-block"></div>
                                </div>

                                <div class="border-t border-gray-100 mb-3"></div>

                                <div class="grid grid-cols-7 gap-0.5 mb-2">
                                    @for ($i = 0; $i < 7; $i++)
                                        <div class="h-4 skeleton-line rounded mx-2">
                                        </div>
                                    @endfor
                                </div>

                                <div class="grid grid-cols-7 gap-1">
                                    @for ($i = 0; $i < 35; $i++)
                                        <div class="flex items-center justify-center py-1.5">
                                            <div class="w-9 h-9 rounded-xl skeleton-line"></div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-side-stack min-w-0">
                    <div id="upcomingAppointmentsContainer" class="skeleton-section skeleton-fade-swap h-full">
                        <div class="skeleton-shell bg-white rounded-xl p-4 h-full flex flex-col">
                            <div class="space-y-3 flex flex-col h-full">

                                <div class="h-5 w-40 skeleton-block rounded"></div>

                                <div class="flex gap-2 justify-center">
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="h-14 w-14 skeleton-line rounded-xl">
                                        </div>
                                    @endfor
                                </div>

                                <div class="flex-1 space-y-2 mt-2">
                                    @for ($i = 0; $i < 3; $i++)
                                        <div class="h-14 skeleton-block rounded-xl">
                                        </div>
                                    @endfor
                                </div>

                                <div class="h-6 w-40 mx-auto skeleton-line rounded"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row3-grid">

            <div id="gadAnalyticsContainer" class="skeleton-section skeleton-fade-swap">
                <div class="skeleton-shell bg-white p-5 rounded-3xl shadow-sm flex flex-col">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="space-y-2 flex-1">
                                <div class="h-5 w-32 skeleton-block rounded"></div>
                                <div class="h-4 w-24 skeleton-line rounded"></div>
                                <div class="h-3 w-40 skeleton-line rounded"></div>
                            </div>
                            <div class="flex gap-3">
                                <div class="h-6 w-24 skeleton-block rounded"></div>
                                <div class="h-6 w-24 skeleton-block rounded"></div>
                            </div>
                        </div>
                        <div class="h-48 skeleton-block rounded"></div>
                    </div>
                </div>
            </div>

            <div class="inventory-grid">
                <div id="medicalSuppliesContainer" class="skeleton-section skeleton-fade-swap">
                    <div class="skeleton-shell bg-white p-5 rounded-3xl shadow-sm flex flex-col">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="space-y-2 flex-1">
                                    <div class="h-5 w-32 skeleton-block rounded"></div>
                                    <div class="h-3 w-24 skeleton-line rounded"></div>
                                </div>
                                <div class="h-6 w-20 skeleton-block rounded"></div>
                            </div>
                            @for ($i = 0; $i < 3; $i++)
                                <div class="h-10 skeleton-block rounded">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div id="medicineSuppliesContainer" class="skeleton-section skeleton-fade-swap">
                    <div class="skeleton-shell bg-white p-5 rounded-3xl shadow-sm flex flex-col">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="space-y-2 flex-1">
                                    <div class="h-5 w-32 skeleton-block rounded"></div>
                                    <div class="h-3 w-24 skeleton-line rounded"></div>
                                </div>
                                <div class="h-6 w-20 skeleton-block rounded"></div>
                            </div>
                            @for ($i = 0; $i < 3; $i++)
                                <div class="h-10 skeleton-block rounded">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <div id="statusModal"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div id="statusModalBox"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-0 overflow-hidden scale-90 transition-all duration-300">
            <div id="modalBanner"
                class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center">
                <div id="modalIcon"
                    class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center text-2xl bg-white/20">
                    <i class="fa-solid fa-door-closed"></i>
                </div>
                <h2 id="modalTitle" class="text-xl font-extrabold">Close the Clinic?</h2>
                <p id="modalSubtitle" class="text-sm opacity-80 mt-1">You are about to mark yourself as
                    <strong>OUT</strong>
                </p>
            </div>
            <div class="px-6 py-5">
                <p id="modalBody" class="text-sm text-[#555] text-center leading-relaxed">
                    This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>.
                    Patients will not be able to book new appointments while you are out.
                </p>
                <div class="flex gap-3 mt-5">
                    <button onclick="closeStatusModal()"
                        class="flex-1 btn btn-ghost border border-gray-200 rounded-xl font-semibold text-gray-600 hover:bg-gray-100">Cancel</button>
                    <button id="confirmStatusBtn" onclick="confirmStatus()"
                        class="flex-1 btn rounded-xl font-bold text-white bg-[#8B0000] hover:bg-[#660000] border-none shadow">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div id="dayAppointmentsModal"
        class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div id="dayAppointmentsModalBox"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-0 overflow-hidden scale-90 transition-all duration-300">

            <div class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 py-4 text-white">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-base font-extrabold">Scheduled Patients</h2>
                        <p id="dayAppointmentsModalDate" class="text-sm opacity-80 mt-1"></p>
                    </div>
                    <button type="button" onclick="closeDayAppointmentsModal()"
                        class="text-white/80 hover:text-white text-2xl leading-none">
                        &times;
                    </button>
                </div>
            </div>

            <div class="px-6 py-5 max-h-[70vh] overflow-y-auto">
                <div id="dayAppointmentsModalList" class="space-y-3"></div>
            </div>

            <div class="px-6 pb-5">
                <button type="button" onclick="closeDayAppointmentsModal()"
                    class="w-full btn rounded-xl font-semibold border-none bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function buildUpcomingAppointments() {
            const apptDetails =
                dashboardData.dashboardAppointmentDetails || {};

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const pad = n =>
                String(n).padStart(2, '0');

            const dateKey = date =>
                `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;

            let windowStart = new Date(today);
            let selectedKey = dateKey(today);

            function getVisibleDays() {
                return Array.from({
                    length: 7
                }, (_, index) => {
                    const date = new Date(windowStart);

                    date.setDate(
                        windowStart.getDate() + index
                    );

                    return date;
                });
            }

            function statusClass(status = '') {
                const s =
                    String(status || '').toLowerCase();

                if (s.includes('cancel')) {
                    return 'upcoming-status-cancelled';
                }

                if (s.includes('resched')) {
                    return 'upcoming-status-rescheduled';
                }

                if (s.includes('complete')) {
                    return 'upcoming-status-completed';
                }

                return 'upcoming-status-upcoming';
            }

            function avatarClass(status = '') {
                const s =
                    String(status || '').toLowerCase();

                if (s.includes('cancel')) {
                    return 'avatar-cancelled';
                }

                if (s.includes('resched')) {
                    return 'avatar-rescheduled';
                }

                if (s.includes('complete')) {
                    return 'avatar-completed';
                }

                return 'avatar-upcoming';
            }

            function getInitials(name = 'Unknown') {
                return String(name)
                    .trim()
                    .split(/\s+/)
                    .map(n => n[0])
                    .slice(0, 2)
                    .join('')
                    .toUpperCase();
            }

            function render(selectedDateKey = selectedKey) {
                const days = getVisibleDays();

                const visibleKeys =
                    days.map(dateKey);

                if (
                    !visibleKeys.includes(selectedDateKey)
                ) {
                    selectedDateKey =
                        visibleKeys[0];
                }

                selectedKey = selectedDateKey;

                const appointments =
                    apptDetails[selectedKey] || [];

                const dateButtons =
                    days.map(d => {
                        const key = dateKey(d);

                        const active =
                            key === selectedKey;

                        const count =
                            (apptDetails[key] || []).length;

                        const hasAppointments =
                            count > 0;

                        const isToday =
                            key === dateKey(today);

                        return `
<button
    type="button"
    onclick="renderUpcomingAppointmentsDay('${key}')"
    class="
        upcoming-date-btn
        ${active ? 'active' : ''}
        ${hasAppointments ? 'has-appointments' : ''}
        ${isToday ? 'is-today' : ''}
    "
>
    ${hasAppointments
                            ? `<span class="upcoming-date-badge">${count}</span>`
                            : ''
                        }

    <div class="text-sm font-extrabold">
        ${d.getDate()}
    </div>

    <div class="text-[10px] font-semibold opacity-70">
        ${d.toLocaleDateString(
                            'en-US',
                            { weekday: 'short' }
                        )}
    </div>
</button>
`;
                    }).join('');

                const items = appointments.length ?
                    appointments
                    .slice(0, 3)
                    .map(appt => {
                        const name =
                            appt.name ||
                            'Unknown Patient';

                        const initials =
                            getInitials(name);

                        const photo =
                            appt.patientPhotoUrl ||
                            appt.profile_photo_url ||
                            appt.avatar ||
                            null;

                        return `
<a
    href="${
        appt.patientProfileUrl ||
        '{{ route('dentist.dentist.appointments') }}'
    }"
    class="
        upcoming-item
        hover:bg-red-50/40
        rounded-xl
        transition
    "
>
    <span
        class="
            upcoming-time-dot
            ${statusClass(appt.status)}
        "
    ></span>

    <div
        class="
            patient-avatar
            patient-avatar-sm
            ${avatarClass(appt.status)}
        "
    >
        ${
            photo
                ? `
                                                    <img
                                                        src="${escHtml(photo)}"
                                                        alt="${escHtml(name)}"
                                                    >
                                                `
                : `
                                                    <span>
                                                        ${escHtml(initials)}
                                                    </span>
                                                `
        }
    </div>

    <div class="flex-1 min-w-0">
        <div
            class="
                flex
                items-center
                justify-between
                gap-2
            "
        >
            <p
                class="
                    text-sm
                    font-bold
                    text-gray-800
                    truncate
                "
            >
                ${escHtml(name)}
            </p>

            <span
                class="
                    text-[11px]
                    font-bold
                    text-[#8B0000]
                    flex-shrink-0
                "
            >
                ${escHtml(
                    appt.time || '—'
                )}
            </span>
        </div>

        <p class="text-xs text-gray-500 truncate">
            ${escHtml(
                appt.service ||
                'General Service'
            )}
        </p>
    </div>
</a>
`;
                    })
                    .join('') :
                    (
                        window.EmptyState?.buildHtml ?
                        window.EmptyState.buildHtml({
                            title: 'No appointments for this day',

                            message: 'Scheduled appointments for this date will appear here.',

                            icon: 'fa-calendar-xmark',

                            className: 'upcoming-empty-state'
                        }) :
                        ''
                    );

                const firstVisibleDate = days[0];
                const lastVisibleDate =
                    days[days.length - 1];

                const rangeLabel =
                    `${firstVisibleDate.toLocaleDateString(
                    'en-US',
                    {
                        month: 'short',
                        day: 'numeric'
                    }
                )} – ${lastVisibleDate.toLocaleDateString(
                    'en-US',
                    {
                        month: 'short',
                        day: 'numeric'
                    }
                )
                }`;

                const html = `
<article class="card upcoming-card">

<header class="card-header">

    <div class="card-header-left">
        <div class="card-header-icon">
            <i class="fa-regular fa-calendar-days"></i>
        </div>

        <div>
            <h3 class="card-title">
                Upcoming Appointments
            </h3>

            <p class="upcoming-range-label">
                ${rangeLabel}
            </p>
        </div>
    </div>

</header>

<div class="card-body upcoming-card-body">

    <div class="upcoming-date-navigation">

        <button
            type="button"
            class="upcoming-date-nav-btn"
            onclick="changeUpcomingAppointmentWindow(-7)"
            aria-label="Previous 7 days"
            data-tooltip="Previous 7 days"
        >
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <div class="upcoming-date-strip">
            ${dateButtons}
        </div>

        <button
            type="button"
            class="upcoming-date-nav-btn"
            onclick="changeUpcomingAppointmentWindow(7)"
            aria-label="Next 7 days"
            data-tooltip="Next 7 days"
        >
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>

    <div
        class="
            upcoming-list-area
            divide-y
            divide-gray-100
        "
    >
        ${items}
    </div>

    <a
        href="{{ route('dentist.dentist.appointments') }}"
        class="card-link upcoming-view-all"
    >
        View all appointments
        <i class="fa-solid fa-arrow-right"></i>
    </a>

</div>
</article>
`;

                const container =
                    document.getElementById(
                        'upcomingAppointmentsContainer'
                    );

                if (container) {
                    if (!container.dataset.loaded) {
                        swapSkeletonContent(
                            'upcomingAppointmentsContainer',
                            html
                        );

                        container.dataset.loaded =
                            'true';
                    } else {
                        container.innerHTML = html;
                    }
                }

            }

            window.renderUpcomingAppointmentsDay =
                function(key) {
                    render(key);
                };

            window.changeUpcomingAppointmentWindow =
                function(daysToMove) {
                    windowStart.setDate(
                        windowStart.getDate() +
                        daysToMove
                    );

                    selectedKey =
                        dateKey(windowStart);

                    render(selectedKey);
                };
            render(selectedKey);

        }

        const dashboardData = {
            gadLabels: {!! json_encode($gadLabels) !!},
            gadFemale: {!! json_encode($gadFemale) !!},
            gadMale: {!! json_encode($gadMale) !!},

            apptCounts: {!! json_encode($calendarAppointmentCounts) !!},
            apptDetails: {!! json_encode($calendarAppointmentDetails) !!},

            dashboardAppointmentDetails: {!! json_encode($dashboardAppointmentDetails ?? []) !!},

            unavailableDates: {!! json_encode($blockedDates ?? []) !!},
            holidays: {!! json_encode($philippineHolidays ?? []) !!},
        };

        const KPI_DATA = {!! json_encode(
            (object) [
                'dentalCases' => $dentalCasesThisMonth ?? 0,
        
                'dentalCasesDelta' => $dentalCasesDelta,
        
                'totalAppts' => $totalApptsThisMonth ?? 0,
        
                'totalApptsDelta' => $totalApptsDelta,
        
                'todayCount' => $todayAppointments?->whereNotIn('status', ['cancelled'])?->count() ?? 0,
        
                'todayUpcoming' => $todayAppointments?->whereIn('status', ['upcoming', 'rescheduled'])?->count() ?? 0,
        
                'todayCompleted' => $todayAppointments?->where('status', 'completed')?->count() ?? 0,
            ],
        ) !!};

        const TODAY_APPOINTMENTS = {!! json_encode($todayAppointments ?? []) !!};
        const MEDICAL_SUPPLIES = {!! json_encode($medicalSupplies ?? []) !!};
        const MEDICINE_SUPPLIES = {!! json_encode($medicineSupplies ?? []) !!};

        const GAD_LABELS = dashboardData.gadLabels;
        const GAD_FEMALE = dashboardData.gadFemale;
        const GAD_MALE = dashboardData.gadMale;

        function renderGadChart() {
            const monthLabel = new Date().toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            });
            const totalFemale = GAD_FEMALE.reduce((sum, value) => sum + Number(value || 0), 0);
            const totalMale = GAD_MALE.reduce((sum, value) => sum + Number(value || 0), 0);
            const totalCases = totalFemale + totalMale;
            const hasData = [...GAD_FEMALE, ...GAD_MALE].some(v => Number(v || 0) > 0);

            const cardHeader = `
<div class="relative z-10 flex items-start justify-between mb-5 flex-wrap gap-4" >
<div class="flex items-start gap-3 min-w-0">
<div class="gad-header-badge flex-shrink-0">
<i class="fa-solid fa-chart-simple text-base"></i>
</div>
<div class="min-w-0">
<div class="flex items-center gap-2 flex-wrap">
<h3 class="text-base font-extrabold text-[#8B0000] leading-tight">GAD Analytics</h3>
<span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full bg-[#8B0000]/10 text-[#8B0000]">${monthLabel}</span>
</div>
<p class="text-sm text-gray-600 mt-1">Gender and Development Data</p>
<p class="text-xs text-gray-400 mt-0.5">Patient cases by category and sex</p>
</div>
</div>

<div class="flex items-center justify-end gap-2 flex-wrap">
<div class="gad-metric-chip">
<span class="w-2.5 h-2.5 rounded-full bg-[#E5B5B5]"></span>
Female <span class="font-semibold">${totalFemale}</span>
</div>
<div class="gad-metric-chip">
<span class="w-2.5 h-2.5 rounded-full bg-[#89CFF0]"></span>
Male <span class="font-semibold">${totalMale}</span>
</div>
<div class="gad-metric-chip">
<i class="fa-solid fa-users text-[11px]"></i>
Total <span class="font-semibold">${totalCases}</span>
</div>
</div>
</div>
`;

            if (!hasData) {
                const html = `
<div class="card gad-analytics-card p-5 sm:p-6 flex flex-col" >
${cardHeader}
<div class="relative z-10 flex-grow flex items-center justify-center w-full min-h-[255px]">
<div class="gad-empty-panel text-center">
<div class="gad-empty-icon-wrap">
<i class="fa-regular fa-clipboard text-5xl"></i>
</div>
<p class="font-extrabold text-base text-gray-800 leading-tight">No Treatments Recorded</p>
<p class="text-sm text-gray-500 max-w-md mx-auto mt-2">
Completed treatment records for this month will appear here once available.
</p>
<div class="gad-empty-actions">
<span class="gad-empty-pill"><i class="fa-solid fa-chart-column"></i> Category breakdown</span>
<span class="gad-empty-pill"><i class="fa-solid fa-venus-mars"></i> Sex-disaggregated data</span>
<span class="gad-empty-pill"><i class="fa-regular fa-calendar"></i> Monthly view</span>
</div>
</div>
</div>
</div>
`;
                swapSkeletonContent('gadAnalyticsContainer', html);
                return true;
            }

            const chartHtml = `
<div class="card gad-analytics-card p-5 sm:p-6 flex flex-col" >
${cardHeader}
<div class="gad-chart-shell relative z-10 flex-grow flex items-center justify-center w-full">
<canvas id="gadChart" style="display:block;width:100%;height:100%;min-height:240px;"></canvas>
</div>
</div>
`;

            swapSkeletonContent('gadAnalyticsContainer', chartHtml);

            if (typeof Chart === 'undefined') {
                console.warn('Chart.js is not loaded');
                return false;
            }

            setTimeout(() => {
                const newCtx = document.getElementById('gadChart');
                if (newCtx) {
                    new Chart(newCtx, {
                        type: 'bar',
                        data: {
                            labels: GAD_LABELS,
                            datasets: [{
                                    label: 'Female',
                                    data: GAD_FEMALE,
                                    backgroundColor: 'rgba(229,181,181,0.88)',
                                    borderColor: '#E5B5B5',
                                    borderWidth: 1,
                                    borderRadius: 10,
                                    borderSkipped: false
                                },
                                {
                                    label: 'Male',
                                    data: GAD_MALE,
                                    backgroundColor: 'rgba(137,207,240,0.88)',
                                    borderColor: '#89CFF0',
                                    borderWidth: 1,
                                    borderRadius: 10,
                                    borderSkipped: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(13,17,23,0.92)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    padding: 12,
                                    cornerRadius: 12
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#6B7280',
                                        font: {
                                            weight: '700'
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(139,0,0,0.08)'
                                    },
                                    ticks: {
                                        precision: 0,
                                        color: '#9CA3AF'
                                    }
                                }
                            }
                        }
                    });
                }
            }, 160);

            return true;
        }

        function buildKpiGrid() {
            const kpiData = KPI_DATA;

            const clinicStatusLabel =
                dentistIsIn ? 'Open' : 'Closed';

            const clinicStatusIcon =
                dentistIsIn ?
                'fa-door-open' :
                'fa-door-closed';

            const clinicStatusColor =
                dentistIsIn ?
                '#00A96E' :
                '#EF4444';

            const deltaBadge = (value) => {
                if (value === null || typeof value === 'undefined') return '';
                const tone = value >= 0 ? 'status-completed' : 'status-cancelled';
                return `<span class="status-pill ${tone}">${value >= 0 ? '+' : ''}${value}%</span>`;
            };

            const html = `
<article class="stat-card s-crimson dashboard-kpi-card" >
<div class="stat-card-info">
<span class="stat-label">Dental Cases</span>
<strong class="stat-num">${kpiData.dentalCases}</strong>
<div class="stat-footer">${deltaBadge(kpiData.dentalCasesDelta)}</div>
</div>
<div class="stat-icon-wrapper"><i class="fa-solid fa-tooth"></i></div>
</article>

<article class="stat-card s-red dashboard-kpi-card">
<div class="stat-card-info">
<span class="stat-label">Appointments</span>
<strong class="stat-num">${kpiData.totalAppts}</strong>
<div class="stat-footer">${deltaBadge(kpiData.totalApptsDelta)}</div>
</div>
<div class="stat-icon-wrapper"><i class="fa-regular fa-calendar-check"></i></div>
</article>

<article class="stat-card s-blue dashboard-kpi-card">
<div class="stat-card-info">
<span class="stat-label">Today's Patients</span>
<strong class="stat-num">${kpiData.todayCount}</strong>
<div class="stat-footer dashboard-kpi-breakdown">
<span>${kpiData.todayCompleted} completed</span>
<span>${kpiData.todayUpcoming} upcoming</span>
</div>
</div>
<div class="stat-icon-wrapper"><i class="fa-solid fa-user-clock"></i></div>
</article>

<article class="stat-card s-green dashboard-kpi-card dashboard-clinic-status-card">
<div class="stat-card-info">
<span class="stat-label">Clinic Status</span>
<strong
    id="statusKpiLabel"
    class="stat-num"
    style="color:${clinicStatusColor}"
>
    ${clinicStatusLabel}
</strong>
<div class="stat-footer dashboard-live-clock">
<span class="dashboard-live-dot"></span>
<span id="kpi-clock-hhmm">00:00</span>
<span id="kpi-clock-ampm">AM</span>
<span id="kpi-clock-ss" hidden></span>
</div>
</div>
<div class="dashboard-kpi-actions">
<div class="stat-icon-wrapper">
    <i
        id="statusKpiIcon"
        class="fa-solid ${clinicStatusIcon}"
        style="color:${clinicStatusColor}"
    ></i>
</div>
<button type="button" onclick="openStatusModal()" class="ui-btn ui-btn-secondary ui-btn-sm status-change-btn">Change</button>
</div>
</article>
`;

            swapSkeletonContent('kpiGridContainer', html);
        }

        function buildMedicalSupplies() {
            const medicalSupplies = MEDICAL_SUPPLIES;

            let tableHtml = '';
            if (medicalSupplies.length > 0) {
                const rows = medicalSupplies.map(item => {
                    const balance = item.qty - item.used;
                    const pct = item.qty > 0 ? (balance / item.qty) * 100 : 100;
                    const isLow = pct <= 30;

                    const balanceClass = isLow ?
                        'table-tag table-tag-danger' :
                        'table-tag table-tag-info';

                    return `
<tr >
<td class="table-cell-main">
<strong>${escHtml(item.name)}</strong>
</td>
<td class="table-cell-center">${item.qty}</td>
<td class="table-cell-center">${item.used}</td>
<td class="table-cell-center">
<span class="${balanceClass}">
${balance}
${isLow ? '<i class="fa-solid fa-triangle-exclamation"></i>' : ''}
</span>
</td>
</tr>
`;
                }).join('');

                tableHtml = `
<div class="table-body-surface table-scroll inventory-dashboard-table-scroll">
<table class="data-table inventory-dashboard-table">
<thead>
<tr class="table-column-header">
<th>Item</th>
<th class="table-cell-center">Stock</th>
<th class="table-cell-center">Used</th>
<th class="table-cell-center">Balance</th>
</tr>
</thead>
<tbody>
${rows}
</tbody>
</table>
</div>
`;
            } else {
                tableHtml = `
<div class="empty-state inventory-dashboard-empty">
    <div class="inventory-empty-icon">
        <i class="fa-solid fa-box-open"></i>
    </div>

    <h4 class="empty-state-title">No medical supplies yet</h4>

    <p class="empty-state-sub">
        Medical supply records will appear here once inventory items are available.
    </p>
</div>
`;
            }

            const html = `
<article class="card inventory-dashboard-card">
<header class="card-header">
<div class="flex items-center gap-3">
<div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center text-[#8B0000] border border-red-100 flex-shrink-0">
<i class="fa-solid fa-boxes-stacked text-base"></i>
</div>
<div>
<h3 class="font-extrabold text-[#8B0000] text-sm">Medical Supplies</h3>
<p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Top Inventory</p>
</div>
</div>
<a href="{{ route('dentist.dentist.inventory') }}" class="ui-btn ui-btn-secondary ui-btn-sm">
View All <i class="fa-solid fa-arrow-right"></i>
</a>
</header>
<div class="card-body">${tableHtml}</div>
</article>
`;

            swapSkeletonContent('medicalSuppliesContainer', html);
        }

        function buildMedicineSupplies() {
            const medicineSupplies = MEDICINE_SUPPLIES;

            let tableHtml = '';
            if (medicineSupplies.length > 0) {
                const rows = medicineSupplies.map(item => {
                    const balance = item.qty - item.used;
                    const pct = item.qty > 0 ? (balance / item.qty) * 100 : 100;
                    const isLow = pct <= 30;

                    const balanceClass = isLow ?
                        'table-tag table-tag-danger' :
                        'table-tag table-tag-info';

                    return `
<tr >
<td class="table-cell-main">
<strong>${escHtml(item.name)}</strong>
</td>
<td class="table-cell-center">${escHtml(item.form || '—')}</td>
<td class="table-cell-center">${item.qty}</td>
<td class="table-cell-center">
<span class="${balanceClass}">
${balance}
${isLow ? '<i class="fa-solid fa-triangle-exclamation"></i>' : ''}
</span>
</td>
</tr>
`;
                }).join('');

                tableHtml = `
<div class="table-body-surface table-scroll inventory-dashboard-table-scroll">
<table class="data-table inventory-dashboard-table">
<thead>
<tr class="table-column-header">
<th>Medicine</th>
<th class="table-cell-center">Form</th>
<th class="table-cell-center">Stock</th>
<th class="table-cell-center">Balance</th>
</tr>
</thead>
<tbody>
${rows}
</tbody>
</table>
</div>
`;
            } else {
                tableHtml = `
<div class="empty-state inventory-dashboard-empty">
    <div class="inventory-empty-icon">
        <i class="fa-solid fa-prescription-bottle-medical"></i>
    </div>

    <h4 class="empty-state-title">No medicine items yet</h4>

    <p class="empty-state-sub">
        Medicine inventory records will appear here once items are available.
    </p>
</div>
`;
            }

            const html = `
<article class="card inventory-dashboard-card">
<header class="card-header">
<div class="flex items-center gap-3">
<div class="w-9 h-9 rounded-xl bg-yellow-50 flex items-center justify-center text-[#8B0000] border border-yellow-100 flex-shrink-0">
<i class="fa-solid fa-pills text-base text-yellow-600"></i>
</div>
<div>
<h3 class="font-extrabold text-[#8B0000] text-sm">Medicine Supplies</h3>
<p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Top Inventory</p>
</div>
</div>
<a href="{{ route('dentist.dentist.inventory') }}" class="ui-btn ui-btn-secondary ui-btn-sm">
View All <i class="fa-solid fa-arrow-right"></i>
</a>
</header>
<div class="card-body">${tableHtml}</div>
</article>
`;

            swapSkeletonContent('medicineSuppliesContainer', html);
        }

        function scrollToDashboardAnalytics() {
            document.getElementById('gadAnalyticsContainer')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            const nameEl = document.getElementById("dentistName");
            const greetingEl = document.getElementById("greetingText");

            nameEl.textContent = "{{ auth()->user()->name ?? 'Doctor' }}";

            const h = new Date().getHours();
            let greeting = "";

            if (h < 12) {
                greeting = "Good Morning,";
            } else if (h < 18) {
                greeting = "Good Afternoon,";
            } else {
                greeting = "Good Evening,";
            }

            greetingEl.textContent = greeting + " ";

            const subtitleEl = document.getElementById('rotatingSubtitle');

            const subtitles = [
                'Delivering brighter smiles today.',
                'Healthy smiles start here.',
                'Providing quality dental care.',
                'Creating confident smiles every day.',
                'Another day of patient care excellence.',
                'Ready for today’s consultations.',
                'Compassionate care for every patient.',
                'Helping every patient smile with confidence.'
            ];

            if (subtitleEl) {
                const randomIndex = Math.floor(Math.random() * subtitles.length);
                subtitleEl.textContent = subtitles[randomIndex];
            }

            const loadingPhases = [{
                    label: 'Loading clinic dashboard',
                    tasks: [buildKpiGrid]
                },
                {
                    label: 'Loading charts and summaries',
                    tasks: [renderGadChart, buildUpcomingAppointments]
                },
                {
                    label: 'Loading inventory',
                    tasks: [buildMedicalSupplies, buildMedicineSupplies]
                },
                {
                    label: 'Loading appointments calendar',
                    tasks: [loadDentistCalendar]
                }
            ];

            if (typeof window.runEnterpriseLoading === 'function') {
                window.runEnterpriseLoading(loadingPhases, {
                    initialDelay: 80,
                    phaseGap: 220,
                    taskGap: 120
                });
                return;
            }

            if (typeof window.setDashboardLoadingStatus === 'function') {
                window.setDashboardLoadingStatus('Loading clinic dashboard', 18);
            }

            setTimeout(() => {
                buildKpiGrid();

                if (typeof window.setDashboardLoadingStatus === 'function') {
                    window.setDashboardLoadingStatus('Loading charts and summaries', 62);
                }

                renderGadChart();

                if (typeof window.setDashboardLoadingStatus === 'function') {
                    window.setDashboardLoadingStatus('Loading inventory', 70);
                }

                buildMedicalSupplies();
                buildMedicineSupplies();

                if (typeof window.setDashboardLoadingStatus === 'function') {
                    window.setDashboardLoadingStatus('Loading appointments calendar', 44);
                }

                loadDentistCalendar();

                if (typeof window.finishDashboardLoading === 'function') {
                    window.finishDashboardLoading();
                }
            }, 80);
        });

        (function() {

            function tickClock() {
                const now = new Date();
                let h = now.getHours(),
                    m = now.getMinutes(),
                    s = now.getSeconds();
                const ampm = h >= 12 ? 'PM' : 'AM';
                const isDaytime = h >= 6 && h < 18;
                const displayHour = h % 12 || 12;

                const hmEl = document.getElementById('kpi-clock-hhmm');
                if (!hmEl) return;

                hmEl.textContent = String(displayHour).padStart(2, '0') + ':' + String(m).padStart(2, '0');
                document.getElementById('kpi-clock-ss').textContent = ':' + String(s).padStart(2, '0');
                document.getElementById('kpi-clock-ampm').textContent = ampm;

                const dayicon = document.getElementById('kpi-clock-dayicon');
                const bigicon = document.getElementById('kpi-clock-icon');
                if (dayicon && bigicon) {
                    dayicon.className = isDaytime ? 'fa-solid fa-sun text-xs flex-shrink-0' :
                        'fa-solid fa-moon text-xs flex-shrink-0';
                    dayicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
                    bigicon.className = isDaytime ? 'fa-solid fa-sun text-base' : 'fa-solid fa-moon text-base';
                    bigicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
                }
            }
            tickClock();
            setInterval(tickClock, 1000);
        })();

        let dentistIsIn = @json(($clinicStatus ?? 'in') === 'in');

        function openStatusModal() {
            const modal = document.getElementById('statusModal');
            const box = document.getElementById('statusModalBox');
            const banner = document.getElementById('modalBanner');
            const icon = document.getElementById('modalIcon');
            const title = document.getElementById('modalTitle');
            const sub = document.getElementById('modalSubtitle');
            const body = document.getElementById('modalBody');

            if (dentistIsIn) {
                banner.className = 'bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center';
                icon.innerHTML = '<i class="fa-solid fa-door-closed"></i>';
                title.textContent = 'Close the Clinic?';
                sub.innerHTML = 'You are about to mark yourself as <strong>OUT</strong>';
                body.innerHTML =
                    'This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>. Patients will not be able to book new appointments while you are out.';
            } else {
                banner.className = 'bg-gradient-to-r from-green-600 to-green-700 px-6 pt-6 pb-4 text-white text-center';
                icon.innerHTML = '<i class="fa-solid fa-door-open"></i>';
                title.textContent = 'Open the Clinic?';
                sub.innerHTML = 'You are about to mark yourself as <strong>IN</strong>';
                body.innerHTML =
                    'This will indicate that the clinic is <span class="font-semibold text-green-700">now open</span>. Patients will be able to see your availability and book appointments.';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            setTimeout(() => box.classList.replace('scale-90', 'scale-100'), 10);
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            const box = document.getElementById('statusModalBox');
            box.classList.replace('scale-100', 'scale-90');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.classList.remove('opacity-100');
            }, 150);
        }

        async function confirmStatus() {
            const confirmBtn = document.getElementById('confirmStatusBtn');

            const newStatus = dentistIsIn ? 'out' : 'in';

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

            try {
                const response = await fetch("{{ route('dentist.clinic-status.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || "Failed to update clinic status.");
                }

                dentistIsIn = data.status === 'in';

                const btn = document.getElementById('statusBtn');
                const label = document.getElementById('statusLabel');
                const kpiLabel = document.getElementById('statusKpiLabel');
                const kpiIcon = document.getElementById('statusKpiIcon');

                if (dentistIsIn) {
                    btn.classList.remove('ui-btn-danger');
                    btn.classList.add('ui-btn-success');
                    btn.style.removeProperty('background');
                    label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN';

                    if (kpiLabel) {
                        kpiLabel.textContent = 'Open';
                        kpiLabel.style.color = '#00A96E';
                    }

                    if (kpiIcon) {
                        kpiIcon.className = 'fa-solid fa-door-open text-base';
                        kpiIcon.style.color = '#00A96E';
                    }
                } else {
                    btn.classList.remove('ui-btn-success');
                    btn.classList.add('ui-btn-danger');
                    btn.style.removeProperty('background');
                    label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full"></span> OUT';

                    if (kpiLabel) {
                        kpiLabel.textContent = 'Closed';
                        kpiLabel.style.color = '#EF4444';
                    }

                    if (kpiIcon) {
                        kpiIcon.className = 'fa-solid fa-door-closed text-base';
                        kpiIcon.style.color = '#EF4444';
                    }
                }

                closeStatusModal();

            } catch (error) {
                console.error(error);
                alert(error.message || "Something went wrong while updating clinic status.");
            } finally {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Confirm';
            }
        }

        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) closeStatusModal();
        });

        function escHtml(str = '') {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function escJs(str = '') {
            return String(str)
                .replace(/\\/g, '\\\\')
                .replace(/'/g, "\\'");
        }

        function buildDayHoverCard(
            dateStr,
            appointments,
            placement = 'hover-bottom',
            alignment = 'hover-align-center'
        ) {
            const safeAppointments = Array.isArray(appointments) ? appointments : [];

            if (!safeAppointments.length) {
                return `
<div
    class="card day-hover-card ${placement} ${alignment} w-[320px]">
<div class="absolute -top-3 left-0 right-0 h-3"></div>
<div class="card-header">
<div class="card-header-left">
<div>
<p class="card-title">Scheduled Patients</p>
<p class="card-subtitle">${escHtml(formatModalDate(dateStr))}</p>
</div>
</div>
</div>
<div class="card-body text-center">
<div class="w-11 h-11 mx-auto mb-3 rounded-full bg-[#fff5f5] flex items-center justify-center text-[#8B0000]">
<i class="fa-regular fa-calendar-xmark"></i>
</div>
<p class="text-sm font-semibold text-gray-700">No scheduled patients</p>
<p class="text-[12px] text-gray-500 mt-1">This date has no booked appointments.</p>
</div>
</div>
`;
            }

            const items = safeAppointments.slice(0, 3).map(appt => {
                const status = String(appt.status || '').toLowerCase();
                const canReschedule = ['upcoming', 'rescheduled'].includes(status);
                const canCancel = ['upcoming', 'rescheduled'].includes(status);

                const safeName = escJs(appt.name || 'Unknown Patient');
                const safeService = escJs(appt.service || 'General Service');
                const safeSchedule = escJs(
                    `${formatModalDate(appt.date || dateStr)} • ${appt.time || '—'} `);
                const rawProfileUrl = appt.patientProfileUrl || '#';
                const profileUrl =
                    `${rawProfileUrl}${rawProfileUrl.includes('?') ? '&' : '?'}from=dashboard`;

                return `
<div class="card scheduled-hover-patient-card" >
<div class="flex items-center justify-between gap-3 mb-2">
<div class="min-w-0">
<p class="text-[12px] font-bold text-gray-800 truncate">${escHtml(appt.name || 'Unknown Patient')}</p>
<p class="text-[11px] text-gray-500 truncate">${escHtml(appt.service || 'General Service')} · ${escHtml(appt.time || '—')}</p>
</div>
<a href="${escHtml(profileUrl)}"
class="text-[11px] font-semibold text-[#8B0000] hover:text-[#660000]">
View
</a>
</div>

<div class="flex flex-wrap gap-2">
<a href="${escHtml(profileUrl)}"
class="ui-btn ui-btn-primary ui-btn-sm">
<i class="fa-regular fa-user text-[10px]"></i> Profile
</a>

${canReschedule ? `
                                                                                    <button type="button"
                                                                                    onclick="event.stopPropagation(); openRescheduleModalFromDay('${escJs(appt.id)}', '${safeName}', '${safeSchedule}', '${safeService}', '${escJs(appt.rescheduleUrl || '#')}')"
                                                                                    class="ui-btn ui-btn-warning ui-btn-sm">
                                                                                    <i class="fa-solid fa-rotate-right text-[10px]"></i> Reschedule
                                                                                    </button>
                                                                                    ` : ''}

${canCancel ? `
                                                                                    <button type="button"
                                                                                    onclick="event.stopPropagation(); cancelAppointmentFromModal('${escJs(appt.cancelUrl || '#')}', '${safeName}', '${safeSchedule}')"
                                                                                    class="ui-btn ui-btn-danger ui-btn-sm">
                                                                                    <i class="fa-solid fa-ban text-[10px]"></i> Cancel
                                                                                    </button>
                                                                                    ` : ''}
</div>
</div>
`;
            }).join('');

            return `
<div class=" card day-hover-card ${placement} ${alignment} w-[320px]">
<div class="absolute -top-3 left-0 right-0 h-3"></div>
<div class="card-header">
<div class="card-header-left">
<div>
<p class="card-title">Scheduled Patients</p>
<p class="card-subtitle">${escHtml(formatModalDate(dateStr))}</p>
</div>
</div>
<a href="{{ route('dentist.dentist.appointments') }}"
class="card-link">
View all
</a>
</div>
<div class="card-body space-y-2">
${items}
</div>
</div>
`;
        }

        function loadDentistCalendar() {

            function renderUnifiedCalendarLegend(mode) {
                if (mode !== 'dentist') return '';

                return `
<div class="cal-legend mt-4" >
<div class="cal-legend-item">
<span class="cal-pill cal-pill-maroon">
<i class="fa-solid fa-calendar-day text-[10px]"></i> Today
</span>
</div>
<div class="cal-legend-item">
<span class="cal-pill cal-pill-green">
<i class="fa-solid fa-user-check text-[10px]"></i> Has Patients
</span>
</div>
<div class="cal-legend-item">
<span class="cal-pill cal-pill-red">
<i class="fa-solid fa-ban text-[10px]"></i> Fully Booked
</span>
</div>
<div class="cal-legend-item">
<span class="cal-pill cal-pill-yellow">
<i class="fa-solid fa-star text-[10px]"></i> Holiday
</span>
</div>
<div class="cal-legend-item">
<span class="cal-pill cal-pill-gray">
<i class="fa-solid fa-circle-minus text-[10px]"></i> Unavailable
</span>
</div>
</div>
`;
            }

            const MAX_PER_DAY = 5;
            const apptCounts = dashboardData.apptCounts || {};
            const apptDetails = dashboardData.apptDetails || {};
            const unavailableDates = dashboardData.unavailableDates || [];
            const allHolidays = dashboardData.holidays || {};

            const today = new Date();
            let currentYear = today.getFullYear(),
                currentMonth = today.getMonth();

            function pad(n) {
                return String(n).padStart(2, '0');
            }

            function isWeekend(y, m, d) {
                const dow = new Date(y, m, d).getDay();
                return dow === 0 || dow === 6;
            }

            function getHolidaysForMonth(year, month) {
                const out = {};
                Object.keys(allHolidays).forEach(ds => {
                    const [y, m] = ds.split('-').map(Number);
                    if (y === year && m === month + 1) out[ds] = allHolidays[ds];
                });
                return out;
            }

            const isHoverDevice = window.matchMedia('(hover:hover) and (pointer:fine)').matches;

            function renderDentistCalendar(year, month) {
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September",
                    "October", "November", "December"
                ];
                const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                const firstDow = new Date(year, month, 1).getDay();
                const totalDays = new Date(year, month + 1, 0).getDate();
                const holidays = getHolidaysForMonth(year, month);

                const headerHtml = dayLabels.map((l, i) =>
                    `<div class="text-center text-[0.6rem] font-bold py-1 pb-2 uppercase tracking-widest ${(i === 0 || i === 6) ? 'cal-day-weekend' : 'cal-day-label'}" > ${l}</div> `
                ).join('');

                let cells = '';
                for (let i = 0; i < firstDow; i++) cells += `<div ></div> `;

                for (let d = 1; d <= totalDays; d++) {
                    const dateStr = `${year}-${pad(month + 1)}-${pad(d)}`;
                    const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    const weekend = isWeekend(year, month, d);
                    const holiday = holidays[dateStr] || null;
                    const count = apptCounts[dateStr] || 0;
                    const isFull = count >= MAX_PER_DAY;
                    const isUnavail = unavailableDates.includes(dateStr) || weekend;
                    const hasAppts = count > 0;

                    const dayAppointments = apptDetails[dateStr] || [];
                    const canOpenModal = dayAppointments.length > 0;
                    const encodedAppointments = encodeURIComponent(JSON.stringify(dayAppointments));

                    let badgeHtml = '',
                        tooltipTxt = '',
                        tooltipTone = 'dark';

                    if (holiday) {
                        badgeHtml = `
<span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-yellow-400 text-[10px] leading-none flex items-center justify-center text-white shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white" >
<i class="fa-solid fa-star text-[8px]"></i>
</span> `;
                        tooltipTxt = `<i class="fa-solid fa-star mr-1 text-white" ></i > ${holiday} `;
                        tooltipTone = 'yellow';
                    }

                    if (hasAppts && !isUnavail) {
                        if (isFull) {
                            tooltipTxt =
                                `<i class="fa-solid fa-circle-xmark mr-1 text-red-300" ></i > Fully booked — ${count} patient${count > 1 ? 's' : ''} `;
                            tooltipTone = 'red';
                        } else {
                            tooltipTxt =
                                `<i class="fa-solid fa-user-clock mr-1 text-emerald-300" ></i > ${count} patient${count > 1 ? 's' : ''} scheduled`;
                            tooltipTone = 'green';
                        }
                        const dotClass = isFull ? 'bg-red-600' : 'bg-emerald-600';
                        badgeHtml = `
<span class="absolute -top-1 -right-1 min-w-[16px] h-4 px-1 rounded-full ${dotClass} text-[9px] font-bold leading-none flex items-center justify-center text-white shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white" >
${count}
</span> `;
                    }

                    if (isToday && !hasAppts && !holiday) {
                        tooltipTxt = `<i class="fa-solid fa-calendar-day mr-1 text-white/90" ></i > Today`;
                        tooltipTone = 'today';
                    } else if (isUnavail && !holiday && !hasAppts) {
                        badgeHtml = `
<span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-gray-500 text-[10px] leading-none flex items-center justify-center text-white shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white" >
<i class="fa-solid fa-minus text-[8px]"></i>
</span> `;
                        tooltipTxt = weekend ? `<i class="fa-solid fa-ban mr-1 text-gray-300" ></i > Clinic closed` :
                            ` <i class="fa-solid fa-ban mr-1 text-gray-300" ></i > Not available`;
                        tooltipTone = 'gray';
                    } else if (!hasAppts && !holiday && !isToday && !isUnavail) {
                        tooltipTxt =
                            `<i class="fa-regular fa-calendar mr-1 text-gray-300" ></i > No scheduled patients`;
                        tooltipTone = 'gray';
                    }

                    let cellClass = "cal-cell";
                    if (isToday) {
                        cellClass += " today";
                    } else if (holiday) {
                        cellClass += " holiday disabled";
                    } else if (isFull) {
                        cellClass += " full";
                    } else if (hasAppts) {
                        cellClass +=
                            " has-patients font-bold cursor-pointer";
                    } else if (isUnavail) {
                        cellClass += " disabled text-gray-400";
                    } else {
                        cellClass += " cursor-pointer hover:bg-gray-100 text-[#333]";
                    }

                    const col = (firstDow + d - 1) % 7;
                    let hoverAlignment =
                        'hover-align-center';

                    if (col <= 1) {
                        hoverAlignment =
                            'hover-align-right';
                    } else if (col >= 4) {
                        hoverAlignment =
                            'hover-align-left';
                    }

                    const tooltipSide = col >= 5 ? "tooltip-left" : col <= 1 ? "tooltip-right" : "tooltip-center";
                    const tooltipPalette = {
                        dark: {
                            bg: 'bg-[#1a1410]',
                            arrow: 'after:border-t-[#1a1410]'
                        },
                        gray: {
                            bg: 'bg-gray-600',
                            arrow: 'after:border-t-gray-600'
                        },
                        red: {
                            bg: 'bg-red-500',
                            arrow: 'after:border-t-red-500'
                        },
                        green: {
                            bg: 'bg-[#008440]',
                            arrow: 'after:border-t-[#008440]'
                        },
                        yellow: {
                            bg: 'bg-yellow-500',
                            arrow: 'after:border-t-yellow-500'
                        },
                        today: {
                            bg: 'bg-[#8B0000]',
                            arrow: 'after:border-t-[#8B0000]'
                        }
                    };

                    const palette = tooltipPalette[tooltipTone] || tooltipPalette.dark;
                    const showHoverCard = isHoverDevice && hasAppts && !holiday;
                    const calendarRow = Math.floor((firstDow + d - 1) / 7);
                    const hoverPlacement = calendarRow >= 3 ? 'hover-top' : 'hover-bottom';

                    const tooltipHtml = (!showHoverCard && tooltipTxt) ? `
<div class="day-smart-tooltip ${tooltipSide} absolute bottom-[calc(100%+10px)] z-[9999] pointer-events-none" >
<div class="${palette.bg} relative text-white text-[0.65rem] font-bold px-3 py-2 rounded-lg whitespace-nowrap shadow-xl
after:content-[''] after:absolute after:top-full after:border-4 after:border-transparent ${palette.arrow}">
${tooltipTxt}
</div>
</div>
` : '';

                    const hoverCardHtml =
                        showHoverCard ?
                        buildDayHoverCard(
                            dateStr,
                            dayAppointments,
                            hoverPlacement,
                            hoverAlignment
                        ) :
                        '';
                    const clickOpen = canOpenModal && !isHoverDevice ?
                        `onclick = "openDayAppointmentsModal('${dateStr}', decodeURIComponent('${encodedAppointments}'))"` :
                        '';

                    cells += `
<div class="cal-cell-wrap relative flex items-center justify-center group" ${clickOpen}>
${tooltipHtml}
${hoverCardHtml}
<div class="${cellClass}" data-date="${dateStr}">
<span>${d}</span>
${badgeHtml}
</div>
</div> `;
                }

                const container = document.getElementById('dentistCalendarContainer');
                if (container) {
                    const html = `
<div class="card cal-shell flex flex-col justify-between h-full p-5 sm:p-6" >
<div>
<div class="flex items-center justify-between mb-5">
<button onclick="changeDentistMonth(-1)" class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs transition-colors"><i class="fa-solid fa-chevron-left"></i></button>
<div class="text-center">
<p class="cal-month-label text-base font-extrabold">${monthNames[month]}</p>
<p class="text-[0.65rem] text-[#9e9690] font-semibold tracking-widest">${year}</p>
</div>
<button onclick="changeDentistMonth(1)" class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs transition-colors"><i class="fa-solid fa-chevron-right"></i></button>
</div>
<hr class="border-[#f0ebe6] mb-3">
<div class="cal-grid">${headerHtml}</div>
<div class="cal-grid" style="row-gap: 0.5rem;">${cells}</div>
</div>
${renderUnifiedCalendarLegend('dentist')}
</div> `;

                    swapSkeletonContent('dentistCalendarContainer', html);
                }
            }

            window.changeDentistMonth = function(dir) {
                currentMonth += dir;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderDentistCalendar(currentYear, currentMonth);
            };

            renderDentistCalendar(currentYear, currentMonth);
        }

        function formatModalDate(dateStr) {
            const date = new Date(dateStr + 'T00:00:00');
            return date.toLocaleDateString('en-PH', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function getStatusBadgeClass(status) {
            const s = String(status || '').toLowerCase().trim();

            if (s === 'cancelled' || s.includes('cancel')) {
                return 'appointment-status-badge appointment-status-cancelled';
            }

            if (s === 'rescheduled' || s.includes('resched')) {
                return 'appointment-status-badge appointment-status-rescheduled';
            }

            if (s === 'completed' || s.includes('complete')) {
                return 'appointment-status-badge appointment-status-completed';
            }

            if (s === 'upcoming') {
                return 'appointment-status-badge appointment-status-upcoming';
            }

            return 'appointment-status-badge appointment-status-upcoming';
        }

        function getAppointmentStatusLabel(status) {
            const s = String(status || '').toLowerCase().trim();

            if (s === 'rescheduled' || s.includes('resched')) return 'Rescheduled';
            if (s === 'completed' || s.includes('complete')) return 'Completed';
            if (s === 'cancelled' || s.includes('cancel')) return 'Cancelled';

            return 'Upcoming';
        }

        function openDayAppointmentsModal(dateStr, appointmentsJson) {
            const modal = document.getElementById('dayAppointmentsModal');
            const box = document.getElementById('dayAppointmentsModalBox');
            const dateEl = document.getElementById('dayAppointmentsModalDate');
            const listEl = document.getElementById('dayAppointmentsModalList');

            let appointments = [];

            try {
                appointments = JSON.parse(appointmentsJson);
            } catch (e) {
                appointments = [];
            }

            dateEl.textContent = formatModalDate(dateStr);

            if (!appointments.length) {
                listEl.innerHTML = `
<div class="flex flex-col items-center justify-center py-10 text-center opacity-60" >
<i class="fa-regular fa-calendar-xmark text-3xl mb-3 text-[#8B0000]"></i>
<p class="text-sm font-semibold text-gray-700">No appointments for this date</p>
</div>
`;
            } else {
                listEl.innerHTML = appointments.map(appt => {
                    const badgeClass = getStatusBadgeClass(appt.status);
                    const initial = (appt.name || '?').charAt(0).toUpperCase();
                    const profileUrl = appt.patientProfileUrl || '#';
                    const rescheduleUrl = appt.rescheduleUrl || '#';
                    const cancelUrl = appt.cancelUrl || '#';
                    const status = String(appt.status || '').toLowerCase().trim();

                    const canReschedule = ['upcoming', 'rescheduled'].includes(status);
                    const canCancel = ['upcoming', 'rescheduled'].includes(status);

                    const displayName = escHtml(appt.name || 'Unknown Patient');
                    const displayService = escHtml(appt.service || 'General Service');
                    const displayDate = escHtml(formatModalDate(appt.date || dateStr));
                    const displayTime = escHtml(appt.time || '—');

                    const safeName = (appt.name || 'Unknown Patient').replace(/'/g, "\\'");
                    const safeSchedule = `${formatModalDate(appt.date || dateStr)} • ${appt.time || '—'} `
                        .replace(
                            /'/g, "\\'");
                    const safeService = (appt.service || '').replace(/'/g, "\\'");

                    const photo = appt.patientPhotoUrl || appt.profile_photo_url || appt.avatar || null;
                    const avatarHtml = photo ?
                        `<img src = "${escHtml(photo)}" alt = "${displayName}" > ` :
                        `<span > ${escHtml(initial)}</span> `;

                    return `
<article class="card scheduled-patient-card" >
<div class="scheduled-patient-head">
<a href="${profileUrl}${profileUrl.includes('?') ? '&' : '?'}from=dashboard"
onclick="closeDayAppointmentsModal()"
class="patient-avatar patient-avatar-sm">
${avatarHtml}
</a>

<div class="scheduled-patient-info">
<a href="${profileUrl}${profileUrl.includes('?') ? '&' : '?'}from=dashboard"
onclick="closeDayAppointmentsModal()"
class="scheduled-patient-name">
${displayName}
</a>

<p class="scheduled-patient-meta">
<i class="fa-solid fa-stethoscope"></i>
<span class="scheduled-patient-meta-lines">
<span class="scheduled-patient-service">${displayService}</span>
<span class="scheduled-patient-schedule">${displayDate} · ${displayTime}</span>
</span>
</p>
</div>

<span class="${badgeClass}">
${getAppointmentStatusLabel(appt.status)}
</span>
</div>

<div class="scheduled-patient-actions">
<a href="${profileUrl}${profileUrl.includes('?') ? '&' : '?'}from=dashboard"
onclick="closeDayAppointmentsModal()"
class="ui-btn ui-btn-primary ui-btn-sm scheduled-action-btn">
<i class="fa-regular fa-user"></i>
<span>View Profile</span>
</a>

${canReschedule ? `
                                                                                    <button type="button"
                                                                                    onclick="openRescheduleModalFromDay('${appt.id}', '${safeName}', '${safeSchedule}', '${safeService}', '${rescheduleUrl}')"
                                                                                    class="ui-btn ui-btn-warning ui-btn-sm scheduled-action-btn">
                                                                                    <i class="fa-solid fa-rotate-right"></i>
                                                                                    <span>Reschedule</span>
                                                                                    </button>
                                                                                    ` : ''}

${canCancel ? `
                                                                                    <button type="button"
                                                                                    onclick="cancelAppointmentFromModal('${cancelUrl}', '${safeName}', '${safeSchedule}')"
                                                                                    class="ui-btn ui-btn-danger ui-btn-sm scheduled-action-btn">
                                                                                    <i class="fa-solid fa-ban"></i>
                                                                                    <span>Cancel</span>
                                                                                    </button>
                                                                                    ` : ''}
</div>
</article>
`;
                }).join('');
            }
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');

            setTimeout(() => {
                box.classList.replace('scale-90', 'scale-100');
            }, 10);
        }

        function closeDayAppointmentsModal() {
            const modal = document.getElementById('dayAppointmentsModal');
            const box = document.getElementById('dayAppointmentsModalBox');

            box.classList.replace('scale-100', 'scale-90');

            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.classList.remove('opacity-100');
            }, 150);
        }

        document.addEventListener('click', function(e) {
            const modal = document.getElementById('dayAppointmentsModal');
            if (e.target === modal) {
                closeDayAppointmentsModal();
            }
        });
    </script>
@endsection
