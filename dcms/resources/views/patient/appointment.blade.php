@extends('layouts.patient')

@section('title', 'PUP Taguig Dental Clinic | Appointment')

@section('styles')
<style>
    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.8s ease-out forwards; }

    @keyframes apptSlideUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes apptPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    /* ── DESKTOP LAYOUT ── */
    #mainContent {
        margin-left: 220px;
        transition: margin-left .3s ease;
    }
    @media (max-width: 767px) {
        #mainContent {
            margin-left: 0 !important;
            padding-bottom: 110px; /* Accounts for floating nav */
        }
        /* Calendar: full width, compact */
        #calendarSkeletonContainer {
            padding: 16px !important;
            min-height: 380px !important;
        }
    }

    /* ── APPOINTMENT STYLES ── */
    .appt-section-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #660000;
        line-height: 1.1;
    }
    @media (max-width: 767px) {
        .appt-section-title { font-size: 1.4rem; }
    }

    .appt-section-subtitle {
        font-size: 13px;
        color: #8A8A9A;
        margin-top: 3px;
    }

    .appt-book-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #8B0000;
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        padding: 11px 22px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 16px rgba(139, 0, 0, 0.25);
        white-space: nowrap;
    }

    .appt-book-btn:hover {
        background: #A31515;
        box-shadow: 0 6px 22px rgba(139, 0, 0, 0.35);
        transform: translateY(-1px);
        color: white;
    }
    @media (max-width: 767px) {
        .appt-book-btn { width: 100%; justify-content: center; }
        .appt-header-row { flex-direction: column; align-items: flex-start !important; gap: 12px; }
    }

    .appt-tabs {
        display: flex;
        background: #FFFFFF;
        border-radius: 14px;
        padding: 5px;
        width: fit-content;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        border: 1px solid #E8E0E0;
        margin-bottom: 20px;
    }
    @media (max-width: 640px) {
        .appt-tabs { width: 100%; }
        .appt-tab { flex: 1; justify-content: center; padding: 9px 12px; font-size: 12.5px; }
    }

    .appt-tab {
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 500;
        padding: 9px 22px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #8A8A9A;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .appt-tab .appt-count {
        font-size: 11px;
        font-weight: 700;
        background: #E8E0E0;
        color: #8A8A9A;
        padding: 1px 7px;
        border-radius: 20px;
        transition: all 0.2s ease;
    }

    .appt-tab.appt-active {
        background: #8B0000;
        color: white;
        box-shadow: 0 2px 10px rgba(139, 0, 0, 0.2);
    }

    .appt-tab.appt-active .appt-count {
        background: rgba(255, 255, 255, 0.25);
        color: white;
    }

    /* ── APPOINTMENT CARD ── */
    .appt-card-new {
        background: #FFFFFF;
        border-radius: 18px;
        border: 1px solid #E8E0E0;
        display: grid;
        grid-template-columns: 80px 1fr auto;
        overflow: hidden;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 14px;
        animation: apptSlideUp 0.35s ease backwards;
    }

    .appt-card-new:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.10);
        transform: translateY(-2px);
    }

    .appt-card-new:nth-child(2) { animation-delay: 0.07s; }
    .appt-card-new:nth-child(3) { animation-delay: 0.14s; }

    /* Mobile card: stack vertically */
    @media (max-width: 640px) {
        .appt-card-new {
            grid-template-columns: 1fr;
            grid-template-rows: auto auto auto;
            border-radius: 16px;
        }
        .appt-date-col {
            flex-direction: row !important;
            padding: 12px 16px !important;
            gap: 8px;
            border-right: none !important;
            border-bottom: 1px solid #F0DADA;
            justify-content: flex-start !important;
            align-items: center !important;
        }
        .appt-card-new.appt-past .appt-date-col { border-bottom-color: #E0E0E6; }
        .appt-date-day { font-size: 22px !important; }
        .appt-date-month { font-size: 13px !important; margin-top: 0 !important; }
        .appt-date-year { font-size: 12px !important; margin-top: 0 !important; }
        .appt-body-new { padding: 12px 14px !important; }
        .appt-actions-col {
            flex-direction: row !important;
            padding: 10px 14px !important;
            justify-content: space-between !important;
            border-top: 1px solid #F5F5F5;
            width: 100%;
        }
        .appt-meta-row { gap: 10px !important; flex-wrap: wrap; }
        .appt-top-row { flex-wrap: wrap; gap: 6px !important; }
        .appt-service-name { font-size: 14px !important; }
    }

    .appt-date-col {
        background: #FDF1F1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 22px 10px;
        border-right: 1px solid #F0DADA;
        flex-shrink: 0;
    }

    .appt-card-new.appt-past .appt-date-col {
        background: #F4F4F6;
        border-right-color: #E0E0E6;
    }

    .appt-date-day {
        font-size: 34px;
        font-weight: 800;
        color: #8B0000;
        line-height: 1;
    }
    .appt-card-new.appt-past .appt-date-day { color: #8A8A9A; }

    .appt-date-month {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #C0392B;
        margin-top: 2px;
    }
    .appt-card-new.appt-past .appt-date-month { color: #ADADAD; }

    .appt-date-year {
        font-size: 11px;
        color: #8A8A9A;
        margin-top: 1px;
    }

    .appt-body-new {
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .appt-top-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    .appt-service-name {
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: #2D2D3A;
    }
    .appt-card-new.appt-past .appt-service-name { color: #5A5A6A; }

    .appt-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'DM Sans', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .appt-badge-upcoming { background: #FEF3E2; color: #E67E22; }
    .appt-badge-confirmed { background: #E8F8EE; color: #27AE60; }
    .appt-badge-completed { background: #EAF0FB; color: #3B6CC7; }
    .appt-badge-cancelled { background: #F5F5F5; color: #999999; }
    .appt-badge-scheduled { background: #FEF3E2; color: #E67E22; }

    .appt-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        animation: apptPulse 2s infinite;
    }

    .appt-meta-row { display: flex; gap: 18px; flex-wrap: wrap; }
    .appt-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12.5px;
        color: #8A8A9A;
    }
    .appt-meta-item i { font-size: 12px; color: #C0392B; opacity: 0.7; }
    .appt-meta-item strong { color: #2D2D3A; font-weight: 500; }

    .appt-actions-col {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
        padding: 16px 14px 16px 0;
        gap: 10px;
        flex-shrink: 0;
    }

    .appt-more-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #E8E0E0;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #8A8A9A;
        transition: all 0.18s ease;
    }
    .appt-more-btn:hover { background: #FDF1F1; border-color: #C0392B; color: #8B0000; }

    .appt-countdown {
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        font-weight: 600;
        color: #8B0000;
        background: #FDF1F1;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
        border: 1px solid #F0DADA;
    }

    .appt-rebook-btn {
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        font-weight: 600;
        color: #8B0000;
        background: #FDF1F1;
        border: 1px solid #F0DADA;
        padding: 4px 12px;
        border-radius: 20px;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.18s ease;
        text-decoration: none;
    }
    .appt-rebook-btn:hover { background: #8B0000; color: white; border-color: #8B0000; }

    .appt-divider-label {
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #ADADAD;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .appt-divider-label::after { content: ''; flex: 1; height: 1px; background: #E8E0E0; }

    .appt-empty {
        text-align: center;
        padding: 40px 20px;
        background: #FFFFFF;
        border-radius: 18px;
        border: 1px dashed #E8E0E0;
    }
    .appt-empty img { width: 70px; height: 70px; margin: 0 auto 12px; opacity: 0.6; }
    .appt-empty-title { font-size: 16px; color: #8A8A9A; margin-bottom: 4px; }
    .appt-empty-sub { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: #ADADAD; }

    /* ── SERVICES SECTION ── */
    .service-card {
        position: relative;
        overflow: hidden;
        transition: transform 0.45s ease, box-shadow 0.45s ease;
    }
    .service-card::before {
        content: "";
        position: absolute;
        inset: -12px;
        background: linear-gradient(135deg, #8B0000, #660000);
        opacity: 0;
        border-radius: 1.25rem;
        transition: opacity 0.45s ease;
        z-index: 0;
    }
    .service-card:hover::before { opacity: 1; }
    .service-card:hover { transform: scale(1.06); z-index: 20; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35); }
    .service-card > * { position: relative; z-index: 1; }
    .service-card img { transition: transform 0.45s ease; }
    .service-card:hover img { transform: translateX(-6px) scale(1.08); }

    @media (max-width: 640px) {
        .service-card { padding: 20px 16px !important; }
        .service-card img { width: 70px !important; right: 10px !important; }
        .service-card h3 { font-size: 1rem !important; }
        .service-card p { font-size: 11px !important; max-width: 55% !important; }
    }

    /* ── MODAL ── */
    dialog#appt_detail_modal::backdrop { background: rgba(16, 16, 16, .45); }

    /* DARK THEME FIXES FOR SPECIFIC ELEMENTS */
    [data-theme="dark"] .appt-card-new { background: #0a1628; border-color: #1a2a3a; }
    [data-theme="dark"] .appt-date-col { background: #0d1f35; border-right-color: #1a2a3a; }
    [data-theme="dark"] .appt-card-new.appt-past .appt-date-col { background: #111827; }
    [data-theme="dark"] .appt-tabs { background: #0a1628; border-color: #1a2a3a; }
    [data-theme="dark"] .appt-service-name { color: #E5E7EB; }
    [data-theme="dark"] .appt-meta-item { color: #9CA3AF; }
    [data-theme="dark"] .appt-meta-item strong { color: #E5E7EB; }
    [data-theme="dark"] .appt-empty { background: #000D1A; border-color: #1a2a3a; }
</style>
@endsection

@section('content')

@php
    $calendarAppointments = [];
    foreach (($appointments ?? collect()) as $appt) {
        $calendarAppointments[\Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d')] =
        $appt->service_type . ' • ' . $appt->appointment_time;
    }
@endphp

<main id="mainContent" class="pt-[100px] px-4 sm:px-6 py-6 fade-up min-h-screen">
    <div class="mx-auto">

        <div class="text-xs mb-5 font-medium flex items-center gap-1.5 text-gray-400">
            <a href="{{ route('homepage') }}" class="hover:text-[#8B0000] transition-colors">Home</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-[#8B0000] font-semibold">Appointment</span>
        </div>

        <section class="fade-up mb-8 sm:mb-14">
            <div id="calendarSkeletonContainer" class="bg-white dark:bg-[#000D1A] border dark:border-[#1a2a3a] shadow-sm rounded-2xl p-4 sm:p-6 mx-auto" style="max-width:700px; min-height:420px;">
                <div class="animate-pulse space-y-4">
                    <div class="h-6 w-32 bg-gray-200 dark:bg-gray-800 rounded mx-auto"></div>
                    <div class="grid grid-cols-7 gap-2">
                        @for($i = 0; $i < 35; $i++)
                            <div class="h-8 sm:h-9 bg-gray-200 dark:bg-gray-800 rounded-lg"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>

        <section class="fade-up mb-10 sm:mb-16">

            <div class="appt-header-row flex justify-between items-end mb-5 sm:mb-6 gap-3">
                <div>
                    <h2 class="appt-section-title">My Appointments</h2>
                    <p class="appt-section-subtitle">
                        You have {{ $futureVisits->count() }} upcoming
                        {{ $futureVisits->count() === 1 ? 'visit' : 'visits' }} scheduled
                    </p>
                </div>
                <a href="{{ route('patient.book.appointment') }}" class="appt-book-btn">
                    <i class="fa-solid fa-plus text-xs"></i> Book Appointment
                </a>
            </div>

            @php
                $futureCount = $futureVisits->count();
                $pastCount = $pastVisits->count();
            @endphp

            <div class="appt-tabs">
                <button class="appt-tab appt-active" id="apptFutureTab" onclick="apptShowFuture()">
                    Future Visits <span class="appt-count">{{ $futureCount }}</span>
                </button>
                <button class="appt-tab" id="apptPastTab" onclick="apptShowPast()">
                    Past Visits <span class="appt-count">{{ $pastCount }}</span>
                </button>
            </div>

            <div id="apptFuturePanel">
                @if($futureVisits->count())
                    <div class="appt-divider-label">Upcoming</div>
                    @foreach($futureVisits as $appt)
                        @php
                            $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
                            $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
                            $now = \Carbon\Carbon::now();
                            $diffDays = (int) $now->startOfDay()->diffInDays($apptDate->copy()->startOfDay(), false);
                            if ($diffDays === 0) $countdown = 'Today';
                            elseif ($diffDays === 1) $countdown = 'Tomorrow';
                            else $countdown = 'In '.$diffDays.' days';

                            $rawStatus = strtolower($appt->status ?? 'scheduled');
                            $badgeClass = match($rawStatus) {
                                'upcoming' => 'appt-badge-upcoming',
                                'confirmed' => 'appt-badge-confirmed',
                                default => 'appt-badge-scheduled',
                            };
                            $showDot = in_array($rawStatus, ['upcoming','scheduled']);
                        @endphp
                        <div class="appt-card-new">
                            <div class="appt-date-col">
                                <span class="appt-date-day">{{ $apptDate->format('d') }}</span>
                                <span class="appt-date-month">{{ $apptDate->format('M') }}</span>
                                <span class="appt-date-year">{{ $apptDate->format('Y') }}</span>
                            </div>
                            <div class="appt-body-new">
                                <div class="appt-top-row">
                                    <span class="appt-service-name">
                                        {{ $appt->service_type }}{{ $appt->other_services ? ' ('.$appt->other_services.')' : '' }}
                                    </span>
                                    <span class="appt-badge {{ $badgeClass }}">
                                        @if($showDot)<span class="appt-status-dot"></span>@endif
                                        {{ ucfirst($rawStatus) }}
                                    </span>
                                </div>
                                <div class="appt-meta-row">
                                    <div class="appt-meta-item">
                                        <i class="fa-regular fa-clock"></i>
                                        <strong>{{ $apptTime->format('g:i A') }} – {{ $apptTime->copy()->addHour()->format('g:i A') }}</strong>
                                    </div>
                                    <div class="appt-meta-item">
                                        <i class="fa-regular fa-user"></i> Dr. Nelson Angeles
                                    </div>
                                </div>
                            </div>
                            <div class="appt-actions-col">
                                <button class="appt-more-btn" title="Options">
                                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                </button>
                                <span class="appt-countdown">{{ $countdown }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="appt-empty">
                        <img src="{{ asset('images/future-visit.png') }}" alt="No Upcoming Visits">
                        <p class="appt-empty-title">No Upcoming Visits</p>
                        <p class="appt-empty-sub">You currently have no scheduled appointments.</p>
                    </div>
                @endif
            </div>

            <div id="apptPastPanel" style="display:none;">
                @if($pastVisits->count())
                    <div class="appt-divider-label">Recent History</div>
                    @foreach($pastVisits as $appt)
                        @php
                            $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
                            $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
                            $rawStatus = 'completed';
                            $modalPayload = [
                                'service' => $appt->service_type ?? '—',
                                'date' => $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('F d, Y') : '—',
                                'time' => $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('H:i:s') : '—',
                                'status' => $rawStatus,
                                'duration' => $appt->duration ?? '—',
                                'remarks' => $appt->remarks ?? '—',
                                'oral' => $appt->oral_examination ?? '—',
                                'diagnosis' => $appt->diagnosis ?? '—',
                                'prescription' => $appt->prescription ?? '—',
                            ];
                        @endphp
                        <div class="appt-card-new appt-past">
                            <div class="appt-date-col">
                                <span class="appt-date-day">{{ $apptDate->format('d') }}</span>
                                <span class="appt-date-month">{{ $apptDate->format('M') }}</span>
                                <span class="appt-date-year">{{ $apptDate->format('Y') }}</span>
                            </div>
                            <div class="appt-body-new">
                                <div class="appt-top-row">
                                    <span class="appt-service-name">
                                        {{ $appt->service_type }}{{ $appt->other_services ? ' ('.$appt->other_services.')' : '' }}
                                    </span>
                                    <span class="appt-badge appt-badge-completed">
                                        <i class="fa-solid fa-check" style="font-size:9px"></i> Completed
                                    </span>
                                </div>
                                <div class="appt-meta-row">
                                    <div class="appt-meta-item">
                                        <i class="fa-regular fa-clock"></i>
                                        <strong>{{ $apptTime->format('g:i A') }} – {{ $apptTime->copy()->addHour()->format('g:i A') }}</strong>
                                    </div>
                                    <div class="appt-meta-item">
                                        <i class="fa-regular fa-user"></i> Dr. Nelson Angeles
                                    </div>
                                </div>
                            </div>
                            <div class="appt-actions-col">
                                <button class="appt-more-btn" title="Options">
                                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                </button>
                                <button type="button" class="appt-rebook-btn" data-appt='@json($modalPayload)' onclick="openApptDetailModal(this)">
                                    Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="appt-empty">
                        <img src="{{ asset('images/past-visit.png') }}" alt="No Past Visits">
                        <p class="appt-empty-title">No Past Visits Yet</p>
                        <p class="appt-empty-sub">Your completed appointments will appear here.</p>
                    </div>
                @endif
            </div>

        </section>

        <section class="mt-2 mb-6 fade-up">
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-[#8B0000] to-[#FFD700] bg-clip-text text-transparent mb-4 sm:mb-6">
                Services Offered
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 rounded-2xl overflow-hidden bg-[#8B0000]">
                <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
                    <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Oral Check-Up</h3>
                    <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs">Routine oral examination • Dental consultation</p>
                    <img src="{{ asset('images/oral-checkup.png') }}" class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Oral Checkup" />
                </div>
                <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b border-[#F4F4F4]/60">
                    <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Dental Cleaning</h3>
                    <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs">Oral hygiene treatment • Removing surface buildup</p>
                    <img src="{{ asset('images/dental-cleaning.png') }}" class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Dental Cleaning" />
                </div>
                <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
                    <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Dental Restoration & Prosthesis</h3>
                    <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs">Repairs/replaces damaged teeth • Fillings • Crowns • Inlay • etc.</p>
                    <img src="{{ asset('images/restoration-prosthesis.png') }}" class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Restoration & Prosthesis" />
                </div>
                <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b border-[#F4F4F4]/60">
                    <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Dental Surgery</h3>
                    <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs">Treating dental issues surgically • Extraction • Supernumerary • etc.</p>
                    <img src="{{ asset('images/dental-surgery.png') }}" class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Dental Surgery" />
                </div>
            </div>
        </section>

        <dialog id="appt_detail_modal" class="modal">
            <div class="modal-box p-0 w-full max-w-md rounded-2xl bg-[#F4F4F4] overflow-hidden dark:bg-[#000D1A]">
                <div class="bg-[#7A0000] px-5 sm:px-6 py-4 sm:py-5 text-white">
                    <h3 id="d_service" class="text-xl sm:text-2xl font-extrabold leading-tight">—</h3>
                    <div class="mt-2 flex items-center gap-3 text-white/90 text-sm flex-wrap">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar"></i><span id="d_date">—</span>
                        </div>
                        <span class="opacity-60">·</span>
                        <span id="d_time">—</span>
                    </div>
                </div>
                <div class="px-4 sm:px-6 py-4 sm:py-5 space-y-4 sm:space-y-5">
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="bg-white dark:bg-[#0d1f35] border border-gray-200 dark:border-[#1a2a3a] rounded-xl px-3 sm:px-4 py-3">
                            <div class="flex items-center gap-2 text-[11px] font-extrabold tracking-widest text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-circle-check"></i> STATUS
                            </div>
                            <div class="mt-3">
                                <span id="d_status" class="inline-flex items-center justify-center w-full px-3 py-1 text-xs rounded-full font-bold bg-emerald-200 text-emerald-900">—</span>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-[#0d1f35] border border-gray-200 dark:border-[#1a2a3a] rounded-xl px-3 sm:px-4 py-3">
                            <div class="flex items-center gap-2 text-[11px] font-extrabold tracking-widest text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-circle-check"></i> DURATION
                            </div>
                            <div class="mt-3">
                                <span id="d_duration" class="inline-flex items-center justify-center w-full px-3 py-1 text-xs rounded-full font-bold bg-gray-200 text-gray-800">—</span>
                            </div>
                        </div>
                    </div>
                    @foreach([['TREATMENT','d_remarks'],['ORAL EXAMINATION','d_oral'],['DIAGNOSIS','d_diagnosis'],['PRESCRIPTION','d_prescription']] as [$label,$id])
                    <div>
                        <div class="flex items-center gap-4 mb-2">
                            <span class="text-[11px] font-extrabold tracking-widest text-[#8B0000] dark:text-[#ff6b6b]">{{ $label }}</span>
                            <div class="h-px flex-1 bg-gray-300 dark:bg-[#1a2a3a]"></div>
                        </div>
                        <div class="bg-white dark:bg-[#0d1f35] rounded-xl overflow-hidden">
                            <div class="grid grid-cols-[6px_1fr]">
                                <div class="bg-gray-300 dark:bg-gray-700"></div>
                                <div class="p-3 sm:p-4 text-gray-700 dark:text-gray-300 text-sm leading-relaxed"><span id="{{ $id }}">—</span></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="flex justify-end pt-1">
                        <form method="dialog">
                            <button class="px-6 sm:px-8 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300 dark:hover:bg-gray-700 transition text-sm">Close</button>
                        </form>
                    </div>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop"><button>close</button></form>
        </dialog>

        <dialog id="activeAppointmentModal" class="modal">
            <div class="modal-box swal-card rounded-2xl bg-white dark:bg-[#000D1A] text-center shadow-2xl w-[min(92vw,420px)]">
                <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#FFF0F0] flex items-center justify-center">
                    <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-2xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#8B0000] dark:text-[#ff6b6b] mb-2">One Appointment at a Time</h3>
                <p class="text-sm text-[#333] dark:text-gray-300 mb-6 leading-relaxed">
                    {{ session('activeAppointmentMsg') ?? "You already have an active appointment. Please wait until it is completed before booking another one." }}
                </p>
                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <a href="{{ route('patient.appointment.index') }}" class="btn border-none bg-[#8B0000] hover:bg-[#660000] text-white rounded-xl px-5">
                        <i class="fa-regular fa-calendar-check"></i> View My Appointment
                    </a>
                    <button type="button" id="closeActiveApptModalBtn" class="btn btn-ghost dark:text-gray-300 rounded-xl px-6">Close</button>
                </div>
            </div>
        </dialog>

    </div>
</main>
@endsection

@section('scripts')
<script>
    const calendarAppointments = @json($calendarAppointments);
    const calendarCounts = @json($appointmentCountsPerDay ?? []);
    const calendarUnavailableDates = @json($unavailableDates ?? []);
    const calendarHolidays = @json($philippineHolidays ?? []);

    /* ── TAB TOGGLE ── */
    function apptShowFuture() {
        document.getElementById('apptFuturePanel').style.display = '';
        document.getElementById('apptPastPanel').style.display = 'none';
        document.getElementById('apptFutureTab').classList.add('appt-active');
        document.getElementById('apptPastTab').classList.remove('appt-active');
    }

    function apptShowPast() {
        document.getElementById('apptFuturePanel').style.display = 'none';
        document.getElementById('apptPastPanel').style.display = '';
        document.getElementById('apptPastTab').classList.add('appt-active');
        document.getElementById('apptFutureTab').classList.remove('appt-active');
    }

    /* ── DETAIL MODAL ── */
    function openApptDetailModal(btn) {
        var modal = document.getElementById('appt_detail_modal');
        if (!modal) return;
        var data = {};
        try {
            data = JSON.parse(btn.getAttribute('data-appt') || '{}');
        } catch (e) { }

        function setText(id, val) {
            var el = document.getElementById(id);
            if (el) el.textContent = (val != null ? String(val) : '').trim() || '—';
        }
        setText('d_service', data.service);
        setText('d_date', data.date);
        setText('d_time', data.time);
        setText('d_duration', data.duration);
        setText('d_remarks', data.remarks);
        setText('d_oral', data.oral);
        setText('d_diagnosis', data.diagnosis);
        setText('d_prescription', data.prescription);

        var statusEl = document.getElementById('d_status');
        if (statusEl) {
            var s = (data.status || 'completed').toLowerCase().trim();
            statusEl.textContent = s || '—';
            statusEl.className = 'inline-flex items-center justify-center w-full px-3 py-1 text-xs rounded-full font-bold';
            if (s === 'completed' || s === 'confirmed') statusEl.classList.add('bg-emerald-200', 'text-emerald-900');
            else if (s === 'upcoming' || s === 'scheduled') statusEl.classList.add('bg-yellow-200', 'text-yellow-900');
            else if (s === 'cancelled') statusEl.classList.add('bg-gray-200', 'text-gray-700');
            else statusEl.classList.add('bg-gray-200', 'text-gray-800');
        }
        modal.showModal();
    }

    document.addEventListener('DOMContentLoaded', function () {
        /* ── ACTIVE APPOINTMENT MODAL ── */
        @if(session('activeAppointmentModal'))
            var activeModal = document.getElementById("activeAppointmentModal");
            var closeActiveBtn = document.getElementById("closeActiveApptModalBtn");
            if (activeModal) {
                activeModal.showModal();
                activeModal.addEventListener('click', function (e) {
                    var box = activeModal.querySelector('.modal-box');
                    if (box && !box.contains(e.target)) e.preventDefault();
                });
                activeModal.addEventListener('cancel', function (e) {
                    e.preventDefault();
                });
                if (closeActiveBtn) {
                    closeActiveBtn.addEventListener("click", function () {
                        activeModal.close();
                    });
                }
            }
        @endif

        /* ── CALENDAR ── */
        function loadCalendar() {
            var MAX_PER_DAY = 5;
            var myAppointments = calendarAppointments || {};
            var apptCounts = calendarCounts || {};
            var unavailableDates = calendarUnavailableDates || [];
            var allHolidays = calendarHolidays || {};

            var today = new Date();
            var currentYear = today.getFullYear();
            var currentMonth = today.getMonth();

            function pad(n) { return String(n).padStart(2, '0'); }

            function isWeekend(y, m, d) {
                var dow = new Date(y, m, d).getDay();
                return dow === 0 || dow === 6;
            }

            function getHolidaysForMonth(y, m) {
                var f = {};
                Object.keys(allHolidays).forEach(function (ds) {
                    var p = ds.split('-').map(Number);
                    if (p[0] === y && p[1] === m + 1) f[ds] = allHolidays[ds];
                });
                return f;
            }

            function formatTime(raw) {
                if (!raw) return '—';
                raw = String(raw).trim();
                if (/[AaPp][Mm]$/.test(raw)) return raw;
                var m = raw.match(/^(\d{1,2}):(\d{2})/);
                if (!m) return raw;
                var h = parseInt(m[1], 10), mn = m[2], ampm = h >= 12 ? 'PM' : 'AM', hr = h % 12 || 12;
                return hr + ':' + mn + ' ' + ampm;
            }

            function renderCalendar(year, month) {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                var firstDow = new Date(year, month, 1).getDay();
                var totalDays = new Date(year, month + 1, 0).getDate();
                var holidays = getHolidaysForMonth(year, month);
                var cells = '';

                for (var i = 0; i < firstDow; i++) cells += '<div></div>';

                for (var d = 1; d <= totalDays; d++) {
                    var dateStr = year + '-' + pad(month + 1) + '-' + pad(d);
                    var isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    var weekend = isWeekend(year, month, d);
                    var holiday = holidays[dateStr] || null;
                    var myAppt = myAppointments[dateStr] || null;
                    var count = apptCounts[dateStr] || 0;
                    var isFull = count >= MAX_PER_DAY;
                    var isUnavail = unavailableDates.indexOf(dateStr) !== -1 || weekend;

                    var bgClass = '';
                    var textClass = 'text-[#333333] dark:text-gray-200';
                    var ringClass = '';
                    var dotHtml = '';
                    var tooltipTxt = '';

                    if (isToday) {
                        bgClass = 'bg-[#8B0000]';
                        textClass = 'text-white font-extrabold';
                        ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
                    } else if (holiday) {
                        bgClass = 'bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-800/40';
                        textClass = 'text-blue-700 dark:text-blue-400 font-semibold';
                    } else if (isUnavail) {
                        textClass = 'text-gray-300 dark:text-gray-600';
                    } else {
                        bgClass = 'hover:bg-[#FFF0F0] dark:hover:bg-gray-800';
                    }

                    if (myAppt) {
                        dotHtml += '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ' + (isToday ? 'bg-white' : 'bg-[#008440]') + '"></span>';
                        var apptParts = myAppt.split(' • ');
                        var apptService = apptParts[0] || '';
                        var apptTime = apptParts[1] ? formatTime(apptParts[1]) : '';
                        tooltipTxt = '<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>' + apptService + (apptTime ? ' • ' + apptTime : '');
                    }

                    if (isFull && !myAppt && !isUnavail && !holiday) {
                        dotHtml += '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>';
                        tooltipTxt = '<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked (' + count + ')';
                    }

                    if (holiday && !myAppt) {
                        dotHtml = '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>';
                        tooltipTxt = '<i class="fa-solid fa-star mr-1 text-blue-300"></i>' + holiday;
                    }

                    if (isUnavail && !holiday && !myAppt) {
                        tooltipTxt = weekend ?
                            '<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed' :
                            '<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available';
                    }

                    var tooltipHtml = tooltipTxt ?
                        '<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">' + tooltipTxt + '<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div></div>' :
                        '';

                    cells += '<div class="relative group flex items-center justify-center">' +
                        tooltipHtml +
                        '<div class="relative w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs sm:text-sm rounded-full transition-all duration-150 ' + bgClass + ' ' + textClass + ' ' + ringClass + ' cursor-default">' +
                        d + dotHtml +
                        '</div></div>';
                }

                var headerHtml = dayLabels.map(function (l, i) {
                    return '<div class="text-center text-[9px] sm:text-[10px] font-bold ' + (i === 0 || i === 6 ? 'text-[#8B0000]/40 dark:text-[#ff6b6b]/60' : 'text-[#333333] dark:text-gray-400') + ' uppercase tracking-widest">' + l + '</div>';
                }).join('');

                var container = document.getElementById("calendarSkeletonContainer");
                if (container) {
                    container.innerHTML =
                        '<div class="h-full flex flex-col select-none">' +
                        '<div class="flex items-center justify-center gap-2 mb-3">' +
                        '<i class="fa-regular fa-calendar-check text-[#333333] dark:text-gray-300 text-lg sm:text-xl"></i>' +
                        '<h2 class="text-lg sm:text-xl font-extrabold text-[#333333] dark:text-gray-200">Dental Clinic Schedule</h2></div>' +
                        '<hr class="border-t border-gray-200 dark:border-gray-800 mb-3 sm:mb-4">' +
                        '<div class="flex items-center justify-between mt-4 sm:mt-6 mb-4 sm:mb-5">' +
                        '<button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] dark:hover:bg-gray-800 text-[#8B0000] dark:text-[#ff6b6b] transition-colors duration-150"><i class="fa-solid fa-chevron-left text-xs"></i></button>' +
                        '<div class="text-center"><p class="text-base sm:text-lg font-extrabold text-[#8B0000] dark:text-[#ff6b6b]">' + monthNames[month] + '</p><p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">' + year + '</p></div>' +
                        '<button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] dark:hover:bg-gray-800 text-[#8B0000] dark:text-[#ff6b6b] transition-colors duration-150"><i class="fa-solid fa-chevron-right text-xs"></i></button></div>' +
                        '<div class="grid grid-cols-7 gap-1 sm:gap-2 mt-2 sm:mt-4 mb-2">' + headerHtml + '</div>' +
                        '<div class="grid grid-cols-7 gap-1 sm:gap-2 flex-1 content-start">' + cells + '</div>' +
                        '<div class="flex flex-wrap items-center justify-center gap-2 mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100 dark:border-gray-800">' +
                        '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 font-medium px-2.5 py-1 rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800"><span class="w-2 h-2 rounded-full bg-[#008440] inline-block flex-shrink-0"></span>My Appointment</div>' +
                        '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 font-medium px-2.5 py-1 rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800"><span class="w-2 h-2 rounded-full bg-blue-400 inline-block flex-shrink-0"></span>Holiday</div>' +
                        '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 font-medium px-2.5 py-1 rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800"><span class="w-2 h-2 rounded-full bg-red-500 inline-block flex-shrink-0"></span>Full Schedule</div>' +
                        '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 font-medium px-2.5 py-1 rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800"><span class="w-2 h-2 rounded-full bg-[#8B0000] inline-block flex-shrink-0"></span>Today</div>' +
                        '</div></div>';
                }
            }

            window.changeMonth = function (dir) {
                currentMonth += dir;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentYear, currentMonth);
            };

            renderCalendar(currentYear, currentMonth);
        }

        // Initialize calendar
        loadCalendar();
    });
</script>
@endsection