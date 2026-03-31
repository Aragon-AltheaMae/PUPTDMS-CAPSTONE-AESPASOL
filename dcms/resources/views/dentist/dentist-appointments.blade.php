@extends('layouts.dentist')

@section('title', 'Appointments | PUP Taguig Dental Clinic')

@section('styles')
<style>
  /* ── SUMMARY BAR ── */
  .summary-bar {
    background: linear-gradient(135deg, #7f0000 0%, #a00000 100%);
    border-bottom: 1px solid rgba(255, 255, 255, .08);
  }

  .summary-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .18);
    border-radius: 9999px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 500;
    color: white;
  }

  .summary-chip-highlight {
    background: rgba(255, 255, 255, .22);
    border-color: rgba(255, 255, 255, .35);
    font-weight: 700;
  }

  /* ── TAB TOGGLE ── */
  .tab-toggle-wrap {
    background: #5a0000;
    border-radius: 9999px;
    padding: 5px;
    display: flex;
    gap: 4px;
    box-shadow: 0 4px 16px rgba(139, 0, 0, .35);
  }

  .tab-btn-toggle {
    padding: 8px 20px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    transition: all .25s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, .6);
  }

  .tab-btn-toggle.active {
    background: white;
    color: #8b0000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .15);
  }

  .tab-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 700;
  }

  .tab-btn-toggle.active .tab-count-badge {
    background: #8b0000;
    color: white;
  }

  .tab-btn-toggle:not(.active) .tab-count-badge {
    background: rgba(255, 255, 255, .2);
    color: rgba(255, 255, 255, .8);
  }

  /* ── APPOINTMENT CARDS ── */
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(8px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .appt-card {
    background: #fff;
    border: 1px solid #EDE8E3;
    border-radius: 14px;
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s, border-color .2s, transform .15s;
    animation: slideIn .3s ease both;
  }

  .appt-card:nth-child(even) {
    background: #FDFAF8;
  }

  .appt-card:hover {
    border-color: rgba(139, 0, 0, .25);
    box-shadow: 0 6px 24px rgba(139, 0, 0, .09);
  }

  .appt-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #8B0000;
    border-radius: 14px 0 0 14px;
    opacity: 0;
    transition: opacity .2s;
  }

  .appt-card:hover::before {
    opacity: 1;
  }

  .appt-card.is-today {
    background: #f0fdf4 !important;
    border-color: #86efac !important;
    box-shadow: 0 2px 12px rgba(34, 197, 94, .1);
  }

  .appt-card.is-today::before {
    background: #16a34a;
    opacity: 1;
  }

  /* ── BADGES & PILLS ── */
  .service-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 6px;
    width: fit-content;
  }

  .service-badge-default {
    background: #f9f0f0;
    color: #8B0000;
  }

  .service-badge-surgery {
    background: #fff0f0;
    color: #C41E3A;
  }

  .service-badge-checkup {
    background: #ebf5ee;
    color: #2D7A5E;
  }

  .service-badge-whitening {
    background: #fff3e0;
    color: #B86C00;
  }

  .service-badge-extraction {
    background: #fff0e8;
    color: #B85000;
  }

  .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
  }

  .status-confirmed {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #86efac;
  }

  .status-pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
  }

  .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
    flex-shrink: 0;
    animation: pulse 2s infinite;
  }

  @keyframes pulse {

    0%,
    100% {
      opacity: 1
    }

    50% {
      opacity: .4
    }
  }

  .time-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #F5F0EB;
    border: 1px solid #E8E0D8;
    border-radius: 7px;
    padding: 5px 10px;
    font-size: 13px;
    font-weight: 500;
    color: #6B5E52;
  }

  /* ── TIMELINE ── */
  .timeline-dot {
    width: 18px;
    height: 18px;
    background: #8b0000;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px rgba(139, 0, 0, .2), 0 2px 8px rgba(139, 0, 0, .3);
    flex-shrink: 0;
  }

  .timeline-dot-past {
    width: 18px;
    height: 18px;
    background: #9ca3af;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px rgba(156, 163, 175, .2);
    flex-shrink: 0;
  }

  /* ── ACTION BUTTONS ── */
  .action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    height: 28px;
    padding: 0 9px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    transition: all .15s ease;
    white-space: nowrap;
  }

  .action-btn-view {
    background: #fff;
    color: #8B0000;
    border: 1.5px solid rgba(139, 0, 0, .3);
  }

  .action-btn-view:hover {
    background: #8B0000;
    color: white;
  }

  .action-btn-start {
    background: #15803d;
    color: white;
    border: 1.5px solid #15803d;
  }

  .action-btn-start:hover {
    background: #166534;
    box-shadow: 0 2px 8px rgba(21, 128, 61, .3);
  }

  .action-btn-start:disabled {
    background: #d1d5db;
    border-color: #d1d5db;
    color: #9ca3af;
    cursor: not-allowed;
    box-shadow: none;
  }

  .action-btn-reschedule {
    background: #fffbeb;
    color: #92400e;
    border: 1.5px solid #fcd34d;
  }

  .action-btn-reschedule:hover {
    background: #fef3c7;
    box-shadow: 0 2px 8px rgba(251, 191, 36, .25);
  }

  .action-btn-cancel {
    background: #fff1f2;
    color: #9f1239;
    border: 1.5px solid #fecdd3;
  }

  .action-btn-cancel:hover {
    background: #ffe4e6;
    box-shadow: 0 2px 8px rgba(159, 18, 57, .15);
  }

  /* ── MOBILE APPOINTMENT CARD ── */
  .mobile-appt-card {
    background: #fff;
    border: 1px solid #EDE8E3;
    border-radius: 14px;
    padding: 1rem;
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s, border-color .2s;
    animation: slideIn .3s ease both;
  }

  .mobile-appt-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #8B0000;
    border-radius: 14px 0 0 14px;
  }

  .mobile-appt-card.is-today {
    background: #f0fdf4 !important;
    border-color: #86efac !important;
  }

  .mobile-appt-card.is-today::before {
    background: #16a34a;
  }

  /* ── TOAST ── */
  #toastContainer {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
  }

  .toast-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #1a1a1a;
    border: 1px solid #2d2d2d;
    border-radius: 14px;
    padding: 14px 16px;
    min-width: 280px;
    max-width: 360px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, .35);
    pointer-events: auto;
    position: relative;
    overflow: hidden;
    animation: toastIn .4s cubic-bezier(.34, 1.56, .64, 1) forwards;
  }

  .toast-item.toast-exit {
    animation: toastOut .35s ease forwards;
  }

  @keyframes toastIn {
    from {
      opacity: 0;
      transform: translateX(60px) scale(.95);
    }

    to {
      opacity: 1;
      transform: translateX(0) scale(1);
    }
  }

  @keyframes toastOut {
    from {
      opacity: 1;
      transform: translateX(0);
      max-height: 100px;
    }

    to {
      opacity: 0;
      transform: translateX(60px);
      max-height: 0;
    }
  }

  .toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    border-radius: 0 0 14px 14px;
    background: linear-gradient(90deg, #dc2626, #f87171);
    animation: toastProg linear forwards;
  }

  @keyframes toastProg {
    from {
      width: 100%;
    }

    to {
      width: 0%;
    }
  }

  .toast-icon-wrap {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: rgba(220, 38, 38, .15);
    border: 1px solid rgba(220, 38, 38, .25);
  }

  .toast-title {
    font-size: 13px;
    font-weight: 700;
    color: #f3f4f6;
    line-height: 1.3;
    margin-bottom: 2px;
  }

  .toast-message {
    font-size: 12px;
    color: #9ca3af;
    line-height: 1.4;
  }

  .toast-close {
    width: 22px;
    height: 22px;
    border-radius: 6px;
    background: rgba(255, 255, 255, .06);
    border: none;
    cursor: pointer;
    color: #6b7280;
    font-size: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s;
  }

  .toast-close:hover {
    background: rgba(255, 255, 255, .12);
    color: #e5e7eb;
  }

  /* ── CANCEL MODAL ── */
  .cancel-modal-panel {
    animation: modalUp .3s cubic-bezier(.34, 1.56, .64, 1) forwards;
  }

  .reschedule-modal-panel {
    animation: modalUp .3s cubic-bezier(.34, 1.56, .64, 1) forwards;
  }

  @keyframes modalUp {
    from {
      opacity: 0;
      transform: translateY(24px) scale(.97);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .cancel-icon-ring {
    position: relative;
    width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .cancel-icon-ring::before,
  .cancel-icon-ring::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid rgba(220, 38, 38, .35);
    animation: ringPulse 2s ease-out infinite;
  }

  .cancel-icon-ring::after {
    animation-delay: .7s;
  }

  @keyframes ringPulse {
    0% {
      transform: scale(.85);
      opacity: .8;
    }

    100% {
      transform: scale(1.5);
      opacity: 0;
    }
  }

  .cancel-icon-core {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 2px solid #fca5a5;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(220, 38, 38, .2);
    z-index: 1;
  }

  .reason-chip input[type="radio"] {
    display: none;
  }

  .reason-chip label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 9999px;
    border: 1.5px solid #e5e7eb;
    font-size: 12px;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    transition: all .15s;
    background: white;
    user-select: none;
  }

  .reason-chip label:hover {
    border-color: #fca5a5;
    color: #9f1239;
    background: #fff1f2;
  }

  .reason-chip input[type="radio"]:checked+label {
    border-color: #dc2626;
    background: #fef2f2;
    color: #dc2626;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(220, 38, 38, .15);
  }

  #cancelReasonChips.invalid .reason-chip label {
    border-color: #fca5a5;
    background: #fff5f5;
  }

  @keyframes errorShake {

    0%,
    100% {
      transform: translateX(0);
    }

    20% {
      transform: translateX(-5px);
    }

    40% {
      transform: translateX(5px);
    }

    60% {
      transform: translateX(-3px);
    }

    80% {
      transform: translateX(3px);
    }
  }

  .chips-error-shake {
    animation: errorShake .35s ease;
  }

  /* ── DARK MODE ── */

  [data-theme="dark"] .bg-white,
  [data-theme="dark"] .appt-card,
  [data-theme="dark"] .mobile-appt-card {
    background-color: #0d1117 !important;
    border-color: #21262d;
  }

  [data-theme="dark"] .appt-card:nth-child(even) {
    background: #0a0f14 !important;
  }

  [data-theme="dark"] .time-chip {
    background: #1c2128;
    border-color: #21262d;
    color: #9ca3af;
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 767px) {

    .desktop-appointments-table {
      display: none !important;
    }

    .mobile-appointments-list {
      display: block !important;
    }

    .tab-btn-toggle {
      padding: 7px 14px;
      font-size: 12px;
    }

    #toastContainer {
      bottom: 16px;
      right: 16px;
      left: 16px;
    }

    .toast-item {
      min-width: unset;
      max-width: 100%;
    }

    .summary-bar {
      padding: 0.75rem 1rem;
    }
  }

  @media (min-width: 768px) {
    .desktop-appointments-table {
      display: block !important;
    }

    .mobile-appointments-list {
      display: none !important;
    }
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(6px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .fade-in {
    animation: fadeIn .6s ease-out forwards;
  }
</style>
@endsection

@section('content')

@php
$upcomingAppointments = $upcomingAppointments ?? collect();
$pastAppointments = $pastAppointments ?? collect();
$today = $today ?? \Carbon\Carbon::today()->toDateString();
$todayAppts = $upcomingAppointments->filter(fn($a) => ($a->appointment_date ?? null) === $today);
$todayCount = $todayAppts->count();
$nextAppt = $upcomingAppointments->sortBy('appointment_date')->first();
$nextName = $nextAppt ? (optional($nextAppt->patient)->name ?? 'Unknown') : null;
$nextTime = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_time)->format('g:i A') : null;
$nextDate = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M j') : null;
$upcomingGrouped = $upcomingAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
$pastGrouped = $pastAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
$upcomingTotal = $upcomingAppointments->count();
$pastTotal = $pastAppointments->count();
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp


<main id="mainContent" class="pt-[100px] px-3 md:px-6 py-6 min-h-screen flex-1">
    <div class="w-full fade-in">

    <div class="summary-bar rounded-2xl px-4 sm:px-6 py-3 flex items-center gap-2 sm:gap-3 flex-wrap mb-5 mt-2">
      <i class="fa-solid fa-circle-info text-white/60 text-sm"></i>
      <span class="text-white/70 text-xs font-medium hidden sm:inline">Today's snapshot:</span>
      @if($todayCount > 0)
      <span class="summary-chip summary-chip-highlight"><i class="fa-solid fa-calendar-check text-xs"></i>{{
        $todayCount }} appt{{ $todayCount > 1 ? 's' : '' }} today</span>
      @else
      <span class="summary-chip"><i class="fa-regular fa-calendar text-xs"></i>No appointments today</span>
      @endif
      @if($nextAppt)
      <span class="summary-chip hidden sm:inline-flex"><i class="fa-solid fa-clock text-xs"></i>Next: <strong>{{
          $nextName }}</strong> — {{ $nextDate }} at {{ $nextTime }}</span>
      @endif
      {{-- <span class="summary-chip ml-auto"><i class="fa-solid fa-list text-xs"></i>{{ $upcomingTotal }} upcoming · {{
        $pastTotal }} past</span> --}}
    </div>

    <!-- Page Header & Tabs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mt-5 mb-8 px-1">

      <div class="flex items-center gap-3">
        <div>
          <h2 class="text-xl md:text-2xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-1.5">
            Appointments
          </h2>
          <div class="flex items-center gap-2 mt-1.5">
            <i class="fa-solid fa-sun text-yellow-500 text-sm"></i>
            <p id="currentDate" class="text-xs md:text-sm font-normal text-gray-700"></p>
          </div>
        </div>
      </div>

      <div class="tab-toggle-wrap self-start md:self-auto flex-shrink-0">
        <button id="btnUpcoming" class="tab-btn-toggle active">
          <i class="fa-solid fa-calendar-clock text-xs"></i>
          Upcoming
          <span class="tab-count-badge">{{ $upcomingTotal }}</span>
        </button>
        <button id="btnPast" class="tab-btn-toggle">
          <i class="fa-solid fa-clock-rotate-left text-xs"></i>
          Past
          <span class="tab-count-badge">{{ $pastTotal }}</span>
        </button>
      </div>

    </div>

    <!-- ═══ UPCOMING SECTION ═══ -->
    <section id="upcomingSection" class="pb-16">
      @forelse($upcomingGrouped as $month => $items)
      <div class="mb-10 sm:mb-14">
        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-5">
          <div class="timeline-dot"></div>
          <h2 class="text-lg sm:text-xl font-bold text-[#8b0000]">{{ $month }}</h2>
          <span
            class="bg-[#f9f0f0] text-[#8b0000] text-xs font-semibold px-3 py-1 rounded-full border border-[#8b0000]/15">
            {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
          </span>
        </div>

        <!-- ── DESKTOP TABLE VIEW ── -->
        <div class="desktop-appointments-table relative pl-10">
          <div
            class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gradient-to-b from-[#8b0000]/30 to-[#8b0000]/05 rounded-full">
          </div>

          <div class="grid gap-3 text-[10px] font-bold uppercase tracking-wider text-gray-500 py-3.5 px-6 bg-[#FAFAFA] border border-gray-200 rounded-t-2xl mb-3"
               style="grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr) minmax(0, 1.3fr) minmax(0, 1.6fr) minmax(0, 1fr) minmax(0, 1fr) 310px;">
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</div>
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time</div>
            <div class="text-left">Service</div>
            <div class="text-left">Patient</div>
            <div class="text-left">Program</div>
            <div class="text-left">Status</div>
            <div class="text-right">Actions</div>
          </div>

          <div class="space-y-2.5">
            @foreach($items as $i => $appt)
            @php
            $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
            $program = optional($appt->patient)->program ?? '—';
            $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
            $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
            $timeLabel = $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') :
            '—';
            $serviceLabel = ($appt->service_type ?? '') === 'Others' ? (($appt->other_services ?? '') ?: 'Others') :
            ($appt->service_type ?? '—');
            $isToday = ($appt->appointment_date ?? null) === $today;
            $serviceLower = strtolower($serviceLabel);
            $badgeClass = 'service-badge-default';
            if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
            elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
            elseif (str_contains($serviceLower, 'whiten')) $badgeClass = 'service-badge-whitening';
            elseif (str_contains($serviceLower, 'extrac')) $badgeClass = 'service-badge-extraction';
            @endphp

            <div class="appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
              style="animation-delay:{{ $i * 0.04 }}s">

              <div class="grid gap-3 items-center px-5 py-3.5"
                style="grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.9fr) minmax(0, 1.3fr) minmax(0, 1.6fr) minmax(0, 0.9fr) minmax(0, 1fr) 310px;">

                <div>
                  <p class="text-[13px] font-semibold text-gray-800">{{ $dateLabel }}</p>
                  <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                  @if($isToday)<span
                    class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wide bg-green-500 text-white px-2 py-0.5 rounded-md">Today</span>@endif
                </div>

                <div><span class="time-chip"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}</span></div>

                <div class="flex items-center justify-start"><span class="service-badge {{ $badgeClass }}">{{
                    $serviceLabel }}</span></div>

                <div class="flex items-center justify-start gap-3">
                  <img src="{{ optional($appt->patient)->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patientName).'&background=8B0000&color=ffffff&bold=true' }}" 
                       alt="{{ $patientName }}" 
                       class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                  <div class="text-left min-w-0">
                    <p class="text-[13px] font-bold text-gray-800 leading-tight truncate max-w-[140px]">{{ $patientName
                      }}</p>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">ID #{{ $appt->patient_id ?? 'N/A' }}</p>
                  </div>
                </div>

                <div class="text-left">
                  @if($program === '—')
                  <span class="text-[12px] text-gray-400">—</span>
                  @else
                  <span
                    class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2.5 py-1 rounded-full border border-gray-200">{{
                    $program }}</span>
                  @endif
                </div>

                <div class="text-left">
                  @if($isToday)
                  <span class="status-pill status-confirmed"><span class="status-dot"></span>Confirmed</span>
                  @else
                  <span class="status-pill status-pending"><span class="status-dot"></span>Upcoming</span>
                  @endif
                </div>

                <div class="flex items-center justify-end gap-1 flex-nowrap">
                  <a href="{{ route('dentist.dentist.appointments.patientProfile', $appt->id) }}"
                    class="action-btn action-btn-view">
                    <i class="fa-regular fa-user text-[9px]"></i> View
                  </a>
                  <button type="button" class="action-btn action-btn-start" onclick="openStartProcedureModal(this)"
                    data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                    data-datetime="{{ $dateLabel }} | {{ $timeLabel }}" {{ $isToday ? '' : 'disabled' }}>
                    <i class="fa-solid fa-play text-[9px]"></i> Start
                  </button>
                  <button type="button" class="action-btn action-btn-reschedule" onclick="openRescheduleModal(this)"
                    data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                    data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                    <i class="fa-solid fa-rotate-right text-[9px]"></i> Reschedule
                  </button>
                  <button type="button" class="action-btn action-btn-cancel" onclick="openCancelAppointmentModal(this)"
                    data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                    data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                    <i class="fa-solid fa-xmark text-[9px]"></i> Cancel
                  </button>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- ── MOBILE CARD VIEW ── -->
        <div class="mobile-appointments-list space-y-3">
          @foreach($items as $i => $appt)
          @php
          $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
          $program = optional($appt->patient)->program ?? '—';
          $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('M j, Y');
          $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
          $timeLabel = $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') :
          '—';
          $serviceLabel = ($appt->service_type ?? '') === 'Others' ? (($appt->other_services ?? '') ?: 'Others') :
          ($appt->service_type ?? '—');
          $isToday = ($appt->appointment_date ?? null) === $today;
          $serviceLower = strtolower($serviceLabel);
          $badgeClass = 'service-badge-default';
          if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
          elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
          elseif (str_contains($serviceLower, 'whiten')) $badgeClass = 'service-badge-whitening';
          elseif (str_contains($serviceLower, 'extrac')) $badgeClass = 'service-badge-extraction';
          @endphp
          <div class="mobile-appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
            style="animation-delay:{{ $i * 0.04 }}s">
            <!-- Card Top Row -->
            <div class="flex items-start justify-between gap-2 mb-3 pl-2">
              <div>
                <div class="flex items-center gap-2 flex-wrap">
                  <p class="text-[13px] font-bold text-gray-800">{{ $patientName }}</p>
                  @if($isToday)<span
                    class="text-[9px] font-bold uppercase bg-green-500 text-white px-2 py-0.5 rounded-md">Today</span>@endif
                </div>
                <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}, {{ $dateLabel }}</p>
              </div>
              @if($isToday)
              <span class="status-pill status-confirmed flex-shrink-0"><span class="status-dot"></span>Confirmed</span>
              @else
              <span class="status-pill status-pending flex-shrink-0"><span class="status-dot"></span>Upcoming</span>
              @endif
            </div>
            <!-- Info Row -->
            <div class="flex flex-wrap items-center gap-2 mb-3 pl-2">
              <span class="time-chip text-xs"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}</span>
              <span class="service-badge {{ $badgeClass }} text-xs">{{ $serviceLabel }}</span>
              @if($program !== '—')
              <span
                class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2.5 py-1 rounded-full border border-gray-200">{{
                $program }}</span>
              @endif
            </div>
            <!-- Action Buttons Row -->
            <div class="flex flex-wrap gap-2 pl-2">
              <a href="{{ route('dentist.dentist.appointments.patientProfile', $appt->id) }}"
                class="action-btn action-btn-view text-xs">
                <i class="fa-regular fa-user text-[9px]"></i> View
              </a>
              <button type="button" class="action-btn action-btn-start text-xs" onclick="openStartProcedureModal(this)"
                data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                data-datetime="{{ $dateLabel }} | {{ $timeLabel }}" {{ $isToday ? '' : 'disabled' }}>
                <i class="fa-solid fa-play text-[9px]"></i> Start
              </button>
              <button type="button" class="action-btn action-btn-reschedule text-xs" onclick="openRescheduleModal(this)"
                data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                <i class="fa-solid fa-rotate-right text-[9px]"></i> Reschedule
              </button>
              <button type="button" class="action-btn action-btn-cancel text-xs"
                onclick="openCancelAppointmentModal(this)" data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                <i class="fa-solid fa-xmark text-[9px]"></i> Cancel
              </button>
            </div>
          </div>
          @endforeach
        </div>

      </div>
      @empty
      <div class="flex flex-col items-center justify-center py-16 sm:py-24 text-gray-400">
        <i class="fa-regular fa-calendar-xmark text-4xl sm:text-5xl mb-4 text-gray-300"></i>
        <p class="text-base font-semibold text-gray-500">No upcoming appointments</p>
        <p class="text-sm mt-1 text-center px-4">New appointments will appear here once scheduled.</p>
      </div>
      @endforelse
    </section>

    <!-- ═══ PAST SECTION ═══ -->
    <section id="pastSection" class="pb-16 hidden">
      @forelse($pastGrouped as $month => $items)
      <div class="mb-10 sm:mb-14">
        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-5 pl-2">
          <div class="timeline-dot-past"></div>
          <h2 class="text-lg sm:text-xl font-bold text-gray-400">{{ $month }}</h2>
          <span class="bg-gray-100 text-gray-400 text-xs font-semibold px-3 py-1 rounded-full">
            {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
          </span>
        </div>

        <div class="desktop-appointments-table relative pl-10">
          <div class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gray-200 rounded-full"></div>

          <div class="grid gap-3 text-[10px] font-bold uppercase tracking-wider text-gray-400 py-3.5 px-6 bg-[#FAFAFA] border border-gray-200 rounded-t-2xl mb-3"
               style="grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr) minmax(0, 1.3fr) minmax(0, 1.6fr) minmax(0, 1fr);">
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</div>
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time</div>
            <div class="text-left">Service</div>
            <div class="text-left">Patient</div>
            <div class="text-left">Program</div>
          </div>

          <div class="space-y-2.5">
            @foreach($items as $i => $appt)
            @php
            $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
            $program = optional($appt->patient)->program ?? '—';
            $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
            $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
            $timeLabel = $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') :
            '—';
            $serviceLabel = ($appt->service_type ?? '') === 'Others' ? (($appt->other_services ?? '') ?: 'Others') :
            ($appt->service_type ?? '—');
            $serviceLower = strtolower($serviceLabel);
            $badgeClass = 'service-badge-default';
            if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
            elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
            elseif (str_contains($serviceLower, 'whiten')) $badgeClass = 'service-badge-whitening';
            elseif (str_contains($serviceLower, 'extrac')) $badgeClass = 'service-badge-extraction';
            @endphp

            <div class="appt-card opacity-70" style="animation-delay:{{ $i * 0.04 }}s">

              <div class="grid gap-3 items-center px-5 py-3.5"
                style="grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr) minmax(0, 1.3fr) minmax(0, 1.6fr) minmax(0, 1fr);">

                <div>
                  <p class="text-[13px] font-semibold text-gray-500">{{ $dateLabel }}</p>
                  <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                </div>

                <div><span class="time-chip text-gray-400"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel
                    }}</span></div>

                <div class="flex items-center justify-start"><span class="service-badge {{ $badgeClass }} opacity-70">{{
                    $serviceLabel }}</span></div>

                <div class="flex items-center justify-start gap-3">
                  <img src="{{ optional($appt->patient)->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patientName).'&background=9ca3af&color=ffffff&bold=true' }}" 
                       alt="{{ $patientName }}" 
                       class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0 opacity-80">
                  <div class="text-left min-w-0">
                    <p class="text-[13px] font-bold text-gray-500 leading-tight truncate max-w-[140px]">{{ $patientName
                      }}</p>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">ID #{{ $appt->patient_id ?? 'N/A' }}</p>
                  </div>
                </div>

                <div class="text-left">
                  @if($program === '—')
                  <span class="text-[12px] text-gray-400">—</span>
                  @else
                  <span
                    class="inline-block bg-gray-100 text-gray-400 text-[11px] font-medium px-2.5 py-1 rounded-full border border-gray-200">{{
                    $program }}</span>
                  @endif
                </div>

              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Mobile past cards -->
        <div class="mobile-appointments-list space-y-3">
          @foreach($items as $i => $appt)
          @php
          $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
          $program = optional($appt->patient)->program ?? '—';
          $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('M j, Y');
          $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
          $timeLabel = $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') :
          '—';
          $serviceLabel = ($appt->service_type ?? '') === 'Others' ? (($appt->other_services ?? '') ?: 'Others') :
          ($appt->service_type ?? '—');
          $serviceLower = strtolower($serviceLabel);
          $badgeClass = 'service-badge-default';
          if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
          elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
          elseif (str_contains($serviceLower, 'whiten')) $badgeClass = 'service-badge-whitening';
          elseif (str_contains($serviceLower, 'extrac')) $badgeClass = 'service-badge-extraction';
          @endphp
          <div class="mobile-appt-card opacity-70 border-gray-200" style="animation-delay:{{ $i * 0.04 }}s">
            <div class="pl-2">
              <p class="text-[13px] font-semibold text-gray-500">{{ $patientName }}</p>
              <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}, {{ $dateLabel }}</p>
              <div class="flex flex-wrap gap-2 mt-2">
                <span class="time-chip text-xs text-gray-400"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel
                  }}</span>
                <span class="service-badge {{ $badgeClass }} opacity-70 text-xs">{{ $serviceLabel }}</span>
                @if($program !== '—')
                <span
                  class="inline-block bg-gray-100 text-gray-400 text-[11px] px-2.5 py-1 rounded-full border border-gray-200">{{
                  $program }}</span>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>

      </div>
      @empty
      <div class="flex flex-col items-center justify-center py-16 sm:py-24 text-gray-400">
        <i class="fa-regular fa-calendar-xmark text-4xl sm:text-5xl mb-4 text-gray-300"></i>
        <p class="text-base font-semibold text-gray-500">No past appointments</p>
        <p class="text-sm mt-1">Completed appointments will appear here.</p>
      </div>
      @endforelse
    </section>

    <div class="pb-16"></div>
  </div>
</main>

<!-- TOAST CONTAINER -->
<div id="toastContainer"></div>

<!-- ═══ RESCHEDULE MODAL ═══ -->
<div id="rescheduleModal"
  class="fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center backdrop-blur-sm hidden z-[9999] p-0 sm:p-4"
  onclick="handleRescheduleBackdropClick(event)">
  <div
    class="reschedule-modal-panel bg-white w-full sm:w-[580px] rounded-t-2xl sm:rounded-2xl overflow-hidden shadow-2xl">
    <div class="relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-500"></div>
      <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10"></div>
      <div class="relative px-6 sm:px-8 pt-5 pb-5 flex items-center gap-4">
        <div
          class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center flex-shrink-0">
          <i class="fa-solid fa-calendar-day text-white text-lg sm:text-xl"></i>
        </div>
        <div class="flex-1">
          <h2 class="text-white font-bold text-lg sm:text-xl leading-tight">Reschedule Appointment</h2>
          <p class="text-white/70 text-xs mt-0.5">The patient will be notified of the new schedule.</p>
        </div>
        <button onclick="closeRescheduleModal()"
          class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white/80 hover:text-white flex items-center justify-content:center transition text-sm flex-shrink-0 flex items-center justify-center">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </div>
    <div class="px-6 sm:px-8 py-5 sm:py-6 bg-gray-50">
      <div class="bg-white border border-amber-100 rounded-xl p-4 mb-4 shadow-sm">
        <p class="text-[10px] font-bold uppercase tracking-widest text-amber-500 mb-2">Current Appointment</p>
        <div class="flex items-center gap-3">
          <div
            class="w-9 h-9 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-regular fa-circle-user text-amber-400 text-base"></i>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[13px] font-bold text-gray-800 truncate" id="resPatientName">—</p>
            <p class="text-[11px] text-gray-400 mt-0.5 truncate" id="resAppointmentDate">—</p>
          </div>
        </div>
      </div>
      <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-5">
        <i class="fa-solid fa-circle-info text-amber-500 text-sm mt-0.5 flex-shrink-0"></i>
        <p class="text-[12px] text-amber-700 leading-relaxed">You'll be taken to the scheduling page to pick a new
          date and time slot.</p>
      </div>
      <div class="flex items-center gap-3">
        <button onclick="closeRescheduleModal()"
          class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-600 font-semibold hover:bg-gray-50 transition text-sm shadow-sm">
          <i class="fa-solid fa-xmark text-xs mr-1.5 text-gray-400"></i>Cancel
        </button>
        <button onclick="confirmReschedule()"
          class="flex-[2] px-4 py-2.5 rounded-xl font-bold text-sm transition bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white shadow-md active:scale-[.98]">
          <i class="fa-solid fa-calendar-day text-xs mr-1.5"></i>Proceed to Reschedule
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ═══ START PROCEDURE MODAL ═══ -->
<div id="startProcedureModal"
  class="fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center backdrop-blur-sm hidden z-[9999] p-0 sm:p-4">
  <div class="bg-white w-full sm:w-[560px] rounded-t-2xl sm:rounded-2xl overflow-hidden shadow-2xl">
    <div class="bg-green-700 px-6 sm:px-8 py-5 text-center">
      <h2 class="text-lg sm:text-xl font-bold text-white">Confirm Procedure Start</h2>
    </div>
    <div class="px-6 sm:px-10 py-6 sm:py-7 bg-gray-50">
      <p class="text-sm sm:text-base font-bold text-gray-900 mb-1 text-center">You are about to begin this
        appointment's procedure.</p>
      <p class="text-xs sm:text-sm text-gray-500 mb-5 text-center">This will mark the appointment as in progress.</p>
      <div class="bg-white border border-gray-200 rounded-2xl px-6 sm:px-8 py-4 sm:py-5 text-center mb-4 shadow-sm">
        <p class="text-sm text-gray-800">Patient: <span class="font-bold" id="startPatientName">—</span></p>
        <p class="text-sm text-gray-600 mt-1" id="startAppointmentDate">—</p>
      </div>
      <div class="flex justify-end gap-3">
        <button onclick="closeStartProcedureModal()"
          class="px-5 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm">Cancel</button>
        <button onclick="confirmStartProcedure()"
          class="px-5 py-2 rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800 transition text-sm">Start
          Procedure</button>
      </div>
    </div>
  </div>
</div>

<!-- ═══ CANCEL MODAL ═══ -->
<div id="cancelAppointmentModal"
  class="fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center backdrop-blur-sm hidden z-[9999] p-0 sm:p-4"
  onclick="handleCancelBackdropClick(event)">
  <div class="cancel-modal-panel bg-white w-full sm:w-[620px] rounded-t-2xl sm:rounded-2xl overflow-hidden shadow-2xl">
    <div class="relative bg-gradient-to-r from-[#7f0000] to-[#b91c1c] px-6 sm:px-8 pt-5 pb-7 sm:pb-8">
      <button onclick="closeCancelAppointmentModal()"
        class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white/70 hover:text-white flex items-center justify-center transition text-sm">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="flex justify-center mb-3">
        <div class="cancel-icon-ring">
          <div class="cancel-icon-core"><i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i></div>
        </div>
      </div>
      <h2 class="text-center text-white font-bold text-lg leading-tight">Cancel Appointment</h2>
      <p class="text-center text-white/60 text-xs mt-1">This action cannot be undone.</p>
    </div>
    <div class="px-6 sm:px-8 py-5 sm:py-6 bg-gray-50">
      <div class="bg-white border border-gray-100 rounded-xl px-4 sm:px-5 py-4 mb-4 shadow-sm">
        <div class="flex items-center gap-3">
          <div
            class="w-9 h-9 rounded-full bg-red-50 border border-red-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-regular fa-circle-user text-red-400 text-sm"></i>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Patient</p>
            <p class="text-[14px] font-bold text-gray-800 truncate" id="cancelPatientName">—</p>
          </div>
          <div class="text-right flex-shrink-0">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Scheduled</p>
            <p class="text-[12px] font-medium text-gray-600" id="cancelAppointmentDate">—</p>
          </div>
        </div>
      </div>
      <div class="mb-5">
        <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2.5">
          Reason <span class="text-red-400 font-normal normal-case">* required</span>
        </p>
        <div class="flex flex-wrap gap-2" id="cancelReasonChips" onchange="clearReasonError()">
          <div class="reason-chip"><input type="radio" name="cancelReason" id="r1" value="Patient no-show"><label
              for="r1"><i class="fa-regular fa-circle-xmark text-[11px]"></i> Patient no-show</label></div>
          <div class="reason-chip"><input type="radio" name="cancelReason" id="r2" value="Doctor unavailable"><label
              for="r2"><i class="fa-solid fa-user-doctor text-[11px]"></i> Doctor unavailable</label></div>
          <div class="reason-chip"><input type="radio" name="cancelReason" id="r3" value="Patient request"><label
              for="r3"><i class="fa-regular fa-hand text-[11px]"></i> Patient request</label></div>
          <div class="reason-chip"><input type="radio" name="cancelReason" id="r4" value="Emergency"><label for="r4"><i
                class="fa-solid fa-bolt text-[11px]"></i> Emergency</label></div>
          <div class="reason-chip"><input type="radio" name="cancelReason" id="r5" value="Rescheduled"><label
              for="r5"><i class="fa-solid fa-rotate text-[11px]"></i> Rescheduled</label></div>
        </div>
        <div id="reasonError" class="hidden mt-2.5 flex items-center gap-1.5 text-red-500 text-[12px] font-semibold">
          <i class="fa-solid fa-circle-exclamation text-[11px]"></i> Please select a reason before cancelling.
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button onclick="closeCancelAppointmentModal()"
          class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-600 font-semibold hover:bg-gray-50 transition text-sm shadow-sm">
          <i class="fa-solid fa-arrow-left text-xs mr-1.5"></i>Keep
        </button>
        <button id="confirmCancelBtn" onclick="confirmCancelAppointment()"
          class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#8b0000] to-[#c0392b] text-white font-bold hover:from-[#6f0000] hover:to-[#a93226] transition text-sm shadow-md active:scale-[.98]">
          <i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  document.getElementById("currentDate").textContent = new Date().toLocaleDateString("en-US", { weekday: "long", year: "numeric", month: "long", day: "numeric" });

  // ── Tabs ──
  document.getElementById('btnUpcoming')?.addEventListener('click', () => setActiveTab('upcoming'));
  document.getElementById('btnPast')?.addEventListener('click', () => setActiveTab('past'));
  function setActiveTab(tab) {
    const isUpcoming = tab === 'upcoming';
    document.getElementById('upcomingSection')?.classList.toggle('hidden', !isUpcoming);
    document.getElementById('pastSection')?.classList.toggle('hidden', isUpcoming);
    document.getElementById('btnUpcoming')?.classList.toggle('active', isUpcoming);
    document.getElementById('btnPast')?.classList.toggle('active', !isUpcoming);
  }

  // ── Toast ──
  function showToast({ title = '', message = '', duration = 4000 }) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast-item';
    toast.innerHTML = `
        <div class="toast-icon-wrap"><i class="fa-solid fa-ban text-red-400 text-sm"></i></div>
        <div class="flex-1 min-w-0">
          <div class="toast-title">${title}</div>
          ${message ? `<div class="toast-message">${message}</div>` : ''}
        </div>
        <button class="toast-close" onclick="dismissToast(this.closest('.toast-item'))"><i class="fa-solid fa-xmark"></i></button>
        <div class="toast-progress" style="animation-duration:${duration}ms;"></div>`;
    container.appendChild(toast);
    setTimeout(() => dismissToast(toast), duration);
  }
  function dismissToast(toast) {
    if (!toast || toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => toast.remove(), 350);
  }

  // ── Modals ──
  var selectedApptId = null;

  function openRescheduleModal(btn) {
    selectedApptId = btn.dataset.id;
    document.getElementById('resPatientName').textContent = btn.dataset.name || '—';
    document.getElementById('resAppointmentDate').textContent = btn.dataset.datetime || '—';
    const modal = document.getElementById('rescheduleModal');
    modal.classList.remove('hidden');
    const panel = modal.querySelector('.reschedule-modal-panel');
    panel.style.animation = 'none'; requestAnimationFrame(() => requestAnimationFrame(() => { panel.style.animation = ''; }));
  }
  function closeRescheduleModal() { document.getElementById('rescheduleModal').classList.add('hidden'); selectedApptId = null; }
  function handleRescheduleBackdropClick(e) { if (e.target === document.getElementById('rescheduleModal')) closeRescheduleModal(); }
  function confirmReschedule() {
    var url = "{{ route('dentist.dentist.appointments.reschedule', ['id' => ':id']) }}".replace(':id', selectedApptId);
    window.location.href = url;
  }

  function openStartProcedureModal(btn) {
    selectedApptId = btn.dataset.id;
    document.getElementById('startPatientName').textContent = btn.dataset.name || '—';
    document.getElementById('startAppointmentDate').textContent = btn.dataset.datetime || '—';
    document.getElementById('startProcedureModal').classList.remove('hidden');
  }
  function closeStartProcedureModal() { document.getElementById('startProcedureModal').classList.add('hidden'); selectedApptId = null; }
  function confirmStartProcedure() { window.location.href = `/dentist/appointments/${selectedApptId}/start`; }

  var cancelPatientNameCache = '';
  function openCancelAppointmentModal(btn) {
    selectedApptId = btn.dataset.id;
    cancelPatientNameCache = btn.dataset.name || 'this patient';
    document.getElementById('cancelPatientName').textContent = btn.dataset.name || '—';
    document.getElementById('cancelAppointmentDate').textContent = btn.dataset.datetime || '—';
    document.querySelectorAll('input[name="cancelReason"]').forEach(r => r.checked = false);
    clearReasonError();
    const confirmBtn = document.getElementById('confirmCancelBtn');
    confirmBtn.disabled = false;
    confirmBtn.innerHTML = '<i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel';
    const modal = document.getElementById('cancelAppointmentModal');
    modal.classList.remove('hidden');
    const panel = modal.querySelector('.cancel-modal-panel');
    panel.style.animation = 'none'; requestAnimationFrame(() => requestAnimationFrame(() => { panel.style.animation = ''; }));
  }
  function closeCancelAppointmentModal() { document.getElementById('cancelAppointmentModal').classList.add('hidden'); selectedApptId = null; }
  function handleCancelBackdropClick(e) { if (e.target === document.getElementById('cancelAppointmentModal')) closeCancelAppointmentModal(); }

  function clearReasonError() {
    document.getElementById('cancelReasonChips').classList.remove('invalid', 'chips-error-shake');
    document.getElementById('reasonError').classList.add('hidden');
  }
  document.querySelectorAll('input[name="cancelReason"]').forEach(r => r.addEventListener('change', clearReasonError));

  function confirmCancelAppointment() {
    var selectedReason = document.querySelector('input[name="cancelReason"]:checked')?.value || null;
    if (!selectedReason) {
      var chips = document.getElementById('cancelReasonChips');
      document.getElementById('reasonError').classList.remove('hidden');
      chips.classList.add('invalid'); chips.classList.remove('chips-error-shake');
      void chips.offsetWidth; chips.classList.add('chips-error-shake');
      return;
    }
    var btn = document.getElementById('confirmCancelBtn');
    btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-xs mr-1.5"></i>Cancelling…';
    var patientName = cancelPatientNameCache;
    var apptId = selectedApptId;
    closeCancelAppointmentModal();
    fetch(`/dentist/appointments/${apptId}/cancel`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Remove all cards with this appt-id (both desktop and mobile)
          document.querySelectorAll(`[data-appt-id="${apptId}"]`).forEach(card => {
            card.style.transition = 'all 0.35s cubic-bezier(.4,0,.2,1)';
            card.style.overflow = 'hidden';
            requestAnimationFrame(() => {
              card.style.maxHeight = card.offsetHeight + 'px';
              requestAnimationFrame(() => { card.style.maxHeight = '0'; card.style.opacity = '0'; card.style.transform = 'scaleY(0.85) translateX(-8px)'; card.style.marginBottom = '0'; });
            });
            setTimeout(() => card.remove(), 380);
          });
          showToast({ title: 'Appointment Cancelled', message: `${patientName}'s appointment has been successfully cancelled.`, duration: 5000 });
        } else {
          showToast({ title: 'Cancel Failed', message: data.message || 'Something went wrong.', duration: 4000 });
        }
      })
      .catch(() => { showToast({ title: 'Network Error', message: 'Could not reach the server.', duration: 4000 }); });
  }
</script>
@endsection