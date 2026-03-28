@extends('layouts.dentist')

@section('title', 'Patient List | PUP Taguig Dental Clinic')

@section('styles')

  <style>
    
    .radio-red {
      -webkit-appearance: none;
      appearance: none;
      width: 16px;
      height: 16px;
      border: 2px solid #8B0000;
      border-radius: 9999px;
      display: inline-grid;
      place-content: center;
      background: #fff;
    }

    .radio-red::before {
      content: "";
      width: 8px;
      height: 8px;
      border-radius: 9999px;
      transform: scale(0);
      transition: transform 120ms ease-in-out;
      background: #8B0000;
    }

    .radio-red:checked::before {
      transform: scale(1);
    }

    /* ═══ TABS ═══ */
    @keyframes tabSlideUp {
      from {
        opacity: 0;
        transform: translateY(12px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .tab-btn {
      position: relative;
      background: #fff;
      border: 1.5px solid #E5E7EB;
      border-radius: 16px;
      padding: 14px 12px 12px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      cursor: pointer;
      transition: box-shadow .2s ease, transform .2s ease, border-color .2s;
      overflow: hidden;
      animation: tabSlideUp .35s ease both;
    }

    .tab-btn:nth-child(1) {
      animation-delay: .03s;
    }

    .tab-btn:nth-child(2) {
      animation-delay: .08s;
    }

    .tab-btn:nth-child(3) {
      animation-delay: .13s;
    }

    .tab-btn:nth-child(4) {
      animation-delay: .18s;
    }

    .tab-btn:nth-child(5) {
      animation-delay: .23s;
    }

    .tab-btn:nth-child(6) {
      animation-delay: .28s;
    }

    .tab-btn::before {
      display: none;
    }

    .tab-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
      border-color: transparent;
    }

    .tab-btn::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 4px;
      border-radius: 0 0 16px 16px;
      opacity: 0;
      transition: opacity .2s;
    }

    .tab-btn.tab-active {
      border-color: transparent;
      box-shadow: 0 6px 24px rgba(0, 0, 0, .10);
      transform: translateY(-2px);
    }

    .tab-btn.tab-active::after {
      opacity: 1;
    }

    .tab-icon-wrap {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
      font-size: 15px;
    }

    .tab-top-row {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      width: 100%;
      gap: 6px;
    }

    .tab-count {
      font-size: 28px;
      font-weight: 800;
      line-height: 1;
      letter-spacing: -1px;
      color: #111827;
    }

    .tab-label {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: .5px;
      color: #6B7280;
      text-transform: uppercase;
      margin-top: 5px;
      display: block;
    }

    .tab-scheduled .tab-icon-wrap {
      background: #EFF6FF;
      color: #2563EB;
    }

    .tab-upcoming .tab-icon-wrap {
      background: #FFF7ED;
      color: #EA580C;
    }

    .tab-rescheduled .tab-icon-wrap {
      background: #fefce8;
      color: #ca8a04;
    }

    .tab-cancelled .tab-icon-wrap {
      background: #ffecec;
      color: #df0606;
    }

    .tab-completed .tab-icon-wrap {
      background: #F0FDF4;
      color: #16A34A;
    }

    .tab-all .tab-icon-wrap {
      background: #FFF7ED;
      color: #D97706;
    }

    .tab-scheduled::after {
      background: #2563EB;
    }

    .tab-upcoming::after {
      background: #EA580C;
    }

    .tab-rescheduled::after {
      background: #ca8a04;
    }

    .tab-cancelled::after {
      background: #df0606;
    }

    .tab-completed::after {
      background: #16A34A;
    }

    .tab-all::after {
      background: #D97706;
    }

    .tab-scheduled.tab-active {
      box-shadow: 0 6px 24px rgba(37, 99, 235, .12);
    }

    .tab-upcoming.tab-active {
      box-shadow: 0 6px 24px rgba(234, 88, 12, .12);
    }

    .tab-rescheduled.tab-active {
      box-shadow: 0 6px 24px rgba(202, 138, 4, .12);
    }

    .tab-cancelled.tab-active {
      box-shadow: 0 6px 24px rgba(247, 85, 85, .12);
    }

    .tab-completed.tab-active {
      box-shadow: 0 6px 24px rgba(22, 163, 74, .12);
    }

    .tab-all.tab-active {
      box-shadow: 0 6px 24px rgba(217, 119, 6, .12);
    }

    /* ═══ PATIENT CARDS ═══ */
    @keyframes cardIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .patient-card {
      position: relative;
      background: #fff;
      border: 1.5px solid #E5E7EB;
      border-radius: 16px;
      overflow: hidden;
      cursor: pointer;
      transition: border-color .2s, box-shadow .2s, transform .2s;
      animation: cardIn .4s ease both;
    }

    .patient-card:nth-child(even) {
      background: #FDFAF8;
    }

    .patient-card:nth-child(1) {
      animation-delay: .05s;
    }

    .patient-card:nth-child(2) {
      animation-delay: .12s;
    }

    .patient-card:nth-child(3) {
      animation-delay: .19s;
    }

    .patient-card:nth-child(4) {
      animation-delay: .26s;
    }

    .patient-card:nth-child(5) {
      animation-delay: .33s;
    }

    .patient-card:hover {
      border-color: #D1D5DB;
      box-shadow: 0 8px 28px rgba(0, 0, 0, .09);
      transform: translateY(-2px);
    }

    .patient-card .accent-bar {
      position: absolute;
      left: 0;
      top: 14px;
      bottom: 14px;
      width: 4px;
      border-radius: 0 4px 4px 0;
    }

    .accent-upcoming {
      background: linear-gradient(180deg, #E64A19, #BF360C);
    }

    .accent-today {
      background: linear-gradient(180deg, #1E88E5, #1565C0);
    }

    .accent-rescheduled {
      background: linear-gradient(180deg, #ca8a04, #92400e);
    }

    .accent-cancelled {
      background: linear-gradient(180deg, #E53935, #B71C1C);
    }

    .accent-completed {
      background: linear-gradient(180deg, #388E3C, #1B5E20);
    }

    .accent-default {
      background: linear-gradient(180deg, #9CA3AF, #6B7280);
    }

    .card-arrow-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #F3F4F6;
      border: 1.5px solid #E5E7EB;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #9CA3AF;
      font-size: 14px;
      flex-shrink: 0;
      transition: all .2s;
    }

    .patient-card:hover .card-arrow-btn {
      background: #8B0000;
      border-color: #8B0000;
      color: #fff;
      box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
    }

    /* STATUS PILLS */
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 11px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      margin-top: 6px;
    }

    .status-pill .pill-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
      animation: pillPulse 2s infinite;
    }

    @keyframes pillPulse {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .35
      }
    }

    .pill-today {
      background: #EFF6FF;
      color: #1D4ED8;
      border: 1px solid #BFDBFE;
    }

    .pill-upcoming {
      background: #FFF7ED;
      color: #C2410C;
      border: 1px solid #FED7AA;
    }

    .pill-rescheduled {
      background: #fefce8;
      color: #92400e;
      border: 1px solid #FDE68A;
    }

    .pill-cancelled {
      background: #fbd8d8;
      color: #df0606;
      border: 1px solid #FECACA;
    }

    .pill-completed {
      background: #F0FDF4;
      color: #15803D;
      border: 1px solid #BBF7D0;
    }

    .pill-default {
      background: #F9FAFB;
      color: #374151;
      border: 1px solid #E5E7EB;
    }

    .icon-box {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    #openFilter.filter-active {
      background-color: #8B0000 !important;
      color: #fff !important;
      border-color: #8B0000 !important;
    }

    #openFilter.filter-active i {
      color: #fff !important;
    }

    /* COLUMN HEADER ROW — desktop only */
    .card-col-header {
      display: none;
      /* hidden on mobile, shown on lg+ */
      grid-template-columns: 30px 180px 100px 176px 50px 1fr 40px;
      align-items: center;
      padding: 10px 32px 10px 40px;
      border-bottom: 1px solid #F3F4F6;
      background: #FAFAFA;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: #757575;
      border-radius: 16px 16px 0 0;
    }

    /* SEARCH */
    #searchInput:focus {
      box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
    }

    /* PAGE SUMMARY */
    .page-summary {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
      margin-top: 4px;
    }

    .summary-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: #f9f9f9;
      border: 1px solid #e5e7eb;
      border-radius: 9999px;
      padding: 3px 10px;
      font-size: 11px;
      font-weight: 500;
      color: #6b7280;
    }

    .summary-tag-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    /* ═══ MOBILE PATIENT CARD ═══ */
    /* On mobile the card body switches to stacked layout */
    .card-body-desktop {
      display: flex;
    }

    .card-body-mobile {
      display: none;
    }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 1024px) {

      /* Tabs: 3-column grid on medium screens */
      .tabs-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
      }
    }

    @media (max-width: 767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent,
      #siteFooter {
        margin-left: 0 !important;
      }

      #mobileMenuBtn {
        display: flex;
      }

      .header {
        padding: 0 1rem;
      }

      .header-title {
        display: none;
      }

      .header-divider {
        display: none;
      }

      /* Hide desktop user name on small screens */
      .header-user-text {
        display: none;
      }

      .header-user-btn {
        padding: .25rem;
      }

      /* Notification menu narrower on mobile */
      #notifMenu {
        width: 280px;
        right: -60px;
      }

      /* Tabs: 2x3 on mobile */
      .tabs-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      }

      .tab-count {
        font-size: 22px;
      }

      .tab-icon-wrap {
        width: 30px;
        height: 30px;
        font-size: 13px;
      }

      /* Search bar full-width stacked on mobile */
      .search-filter-row {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 10px !important;
      }

      .search-filter-row .relative {
        width: 100% !important;
      }

      #searchInput {
        width: 100% !important;
      }

      #openFilter {
        width: 100%;
        justify-content: center;
      }

      /* Page title row stacked */
      .page-title-row {
        flex-direction: column !important;
        align-items: flex-start !important;
      }

      /* Card layout: mobile stacked */
      .card-col-header {
        display: none !important;
      }

      .card-body-desktop {
        display: none !important;
      }

      .card-body-mobile {
        display: flex !important;
      }

      /* Footer */
      #siteFooter {
        padding: 1rem;
      }

      .footer-inner {
        gap: .75rem;
        font-size: .7rem;
      }
    }

    @media (max-width: 480px) {
      .tabs-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      }

      .tab-btn {
        padding: 10px 10px 8px;
      }

      .tab-count {
        font-size: 20px;
      }

      .tab-label {
        font-size: 9px;
      }

      /* Filter modal full-screen on tiny devices */
      #filterModal>div {
        width: calc(100vw - 24px) !important;
        margin: 12px;
        max-height: calc(100vh - 24px);
      }
    }

    /* Show col header on large screens */
    @media (min-width: 1024px) {
      .card-col-header {
        display: grid;
      }
    }
  </style>
@endsection

@section('content')
@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

  <!-- ═══════ MAIN ═══════ -->
  <main id="mainContent" class="pt-[100px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
    <div class="max-w-7xl mx-auto">
      <div class="px-0 md:px-2 lg:px-6">

        @php
        use Carbon\Carbon;
        $today = Carbon::today()->toDateString();
        $appts = ($appointments instanceof \Illuminate\Pagination\AbstractPaginator)
        ? collect($appointments->items()) : collect($appointments);
        $todayCount = $todayCount ?? 0;
        $upcomingCount = $upcomingCount ?? 0;
        $rescheduledCount= $rescheduledCount?? 0;
        $cancelledCount = $cancelledCount ?? 0;
        $completedCount = $completedCount ?? 0;
        $allCount = $allCount ?? 0;
        @endphp

        <!-- Title + Search / Filter -->
        <div class="page-title-row flex flex-col md:flex-row md:items-start justify-between mb-6 gap-4">
          <div class="mb-2">
            <h2 class="text-xl md:text-2xl font-bold text-[#660000]">Patient List</h2>
            <p class="text-gray-500 mt-1 text-sm">Click to Access Patient Information</p>
            <div class="page-summary mt-3">
              <span class="summary-tag"><span class="summary-tag-dot bg-gray-400"></span>{{ $allCount }} total</span>
              @if($todayCount > 0)<span class="summary-tag"><span class="summary-tag-dot bg-blue-500"></span>{{
                $todayCount }} today</span>@endif
              @if($upcomingCount > 0)<span class="summary-tag"><span class="summary-tag-dot bg-orange-500"></span>{{
                $upcomingCount }} upcoming</span>@endif
              @if($completedCount > 0)<span class="summary-tag"><span class="summary-tag-dot bg-green-500"></span>{{
                $completedCount }} completed</span>@endif
              @if($cancelledCount > 0)<span class="summary-tag"><span class="summary-tag-dot bg-red-500"></span>{{
                $cancelledCount }} cancelled</span>@endif
            </div>
          </div>

          <!-- Search + Filter -->
          <div class="search-filter-row flex items-center gap-3 mt-1 w-full md:w-auto">
            <div class="relative flex items-center flex-1 md:flex-none">
              <span class="absolute left-3.5 text-[#8B0000] pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
              </span>
              <input id="searchInput" type="text" placeholder="Search patients..." class="pl-10 pr-9 py-2.5 w-full md:w-64 rounded-xl border border-gray-200 bg-white
                       text-sm text-gray-700 placeholder:text-gray-400
                       shadow-sm focus:outline-none focus:ring-2 focus:ring-[#8B0000]/10
                       focus:border-[#8B0000] transition-all duration-200" />
              <button id="searchClearBtn" type="button"
                class="absolute right-3 text-red-400 hover:text-red-600 transition-colors hidden"
                aria-label="Clear search">
                <i class="fa-solid fa-xmark text-sm"></i>
              </button>
            </div>
            <button id="openFilter" type="button" class="relative flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200
                     bg-white text-sm font-semibold text-gray-600 shadow-sm
                     hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5
                     transition-all duration-200 flex-shrink-0">
              <i class="fa-solid fa-sliders text-sm"></i>
              Filter
              <span id="filterDot"
                class="hidden absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#8B0000] rounded-full border-2 border-white"></span>
            </button>
          </div>
        </div>

        <div class="w-full max-w-6xl mx-auto">
          <div class="relative">

            <!-- TABS: 2 cols on mobile, 3 on md, 6 on lg -->
            <div class="tabs-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 md:gap-3 relative z-20 mb-4">

              <button class="filter-btn tab-btn tab-scheduled" data-filter="today" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-calendar-days"></i></div>
                  <span class="tab-count">{{ $todayCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Scheduled Today</span>
              </button>

              <button class="filter-btn tab-btn tab-upcoming" data-filter="upcoming" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-hourglass-half"></i></div>
                  <span class="tab-count">{{ $upcomingCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Upcoming</span>
              </button>

              <button class="filter-btn tab-btn tab-rescheduled" data-filter="rescheduled" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-rotate"></i></div>
                  <span class="tab-count">{{ $rescheduledCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Rescheduled</span>
              </button>

              <button class="filter-btn tab-btn tab-cancelled" data-filter="cancelled" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-xmark"></i></div>
                  <span class="tab-count">{{ $cancelledCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Cancelled</span>
              </button>

              <button class="filter-btn tab-btn tab-completed" data-filter="completed" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-circle-check"></i></div>
                  <span class="tab-count">{{ $completedCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Completed</span>
              </button>

              <button class="filter-btn tab-btn tab-all" data-filter="all" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-clipboard-list"></i></div>
                  <span class="tab-count">{{ $allCount ?? 0 }}</span>
                </div>
                <span class="tab-label">All Patients</span>
              </button>
            </div>
            <!-- /tabs -->

            <!-- PATIENT CARDS CONTAINER -->
            <div class="shadow-lg rounded-2xl bg-white overflow-hidden relative">

              <!-- Column header — hidden on mobile via CSS, visible on lg+ -->
              <div class="card-col-header">
                <span></span>
                <span>Patient</span>
                <span></span>
                <span>Date &amp; Time</span>
                <span></span>
                <span>Service &amp; Status</span>
                <span></span>
              </div>

              <div id="patientContainer" class="space-y-3 px-3 md:px-6 pb-6 pt-4">

                @forelse($appointments as $appt)
                @php
                $status = strtolower($appt->status ?? '');
                $isCancelled = $status === 'cancelled';
                $isCompleted = $status === 'completed';
                $isRescheduled= $status === 'rescheduled';
                $isToday = ($appt->appointment_date === $today) && !$isCancelled && !$isCompleted;
                $isUpcoming = ($appt->appointment_date > $today) && in_array($status,
                ['upcoming','rescheduled','pending','confirmed'], true);

                $tabClass = $isCancelled ? 'cancelled' : ($isCompleted ? 'completed' : ($isRescheduled ? 'rescheduled' :
                ($isToday ? 'today' : ($isUpcoming ? 'upcoming' : 'all'))));

                $patientName = $appt->patient->name ?? 'Unknown Patient';
                $dateLabel = Carbon::parse($appt->appointment_date)->format('d M Y');
                $timeLabel = Carbon::parse($appt->appointment_time)->format('g:i A');
                $serviceLabel = ($appt->service_type === 'Others') ? ($appt->other_services ?: 'Others') :
                $appt->service_type;

                $accentClass = $isCancelled ? 'accent-cancelled' : ($isCompleted ? 'accent-completed' : ($isRescheduled
                ? 'accent-rescheduled' : ($isToday ? 'accent-today' : ($isUpcoming ? 'accent-upcoming' :
                'accent-default'))));
                $iconBg = $isCancelled ? 'bg-red-100' : ($isCompleted ? 'bg-green-100' : ($isRescheduled ?
                'bg-yellow-100' : ($isToday ? 'bg-blue-100' : ($isUpcoming ? 'bg-orange-100' : 'bg-gray-100'))));
                $iconColor = $isCancelled ? 'text-red-600' : ($isCompleted ? 'text-green-600' : ($isRescheduled ?
                'text-yellow-600' : ($isToday ? 'text-blue-600' : ($isUpcoming ? 'text-orange-600' :
                'text-gray-500'))));
                $pillClass = $isCancelled ? 'pill-cancelled' : ($isCompleted ? 'pill-completed' : ($isRescheduled ?
                'pill-rescheduled' : ($isToday ? 'pill-today' : ($isUpcoming ? 'pill-upcoming' : 'pill-default'))));
                $pillText = $isCancelled ? 'Cancelled' : ($isCompleted ? 'Completed' : ($isRescheduled ? 'Rescheduled' :
                ($isToday ? 'Appointment Today' : ($isUpcoming ? 'Upcoming · '.ucfirst($status) : ucfirst($status ?:
                'Pending')))));
                @endphp

                <a href="{{ route('dentist.dentist.patient.profile', ['patient' => $appt->patient_id]) }}"
                  class="patient-card patient-item all {{ $tabClass }} block">

                  <div class="accent-bar {{ $accentClass }}"></div>

                  <!-- ── DESKTOP LAYOUT (hidden on mobile) ── -->
                  <div class="card-body-desktop items-center gap-5 px-8 py-4 pl-10">
                    <!-- Avatar -->
                    <div class="relative flex-shrink-0">
                      <img
                        src="{{ $appt->patient->profile_image ? asset('storage/'.$appt->patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patientName).'&background=660000&color=FFFFFF&rounded=true&size=128' }}"
                        class="w-14 h-14 rounded-2xl object-cover shadow-sm border-2 border-gray-100"
                        alt="{{ $patientName }}" />
                    </div>
                    <!-- Name + ID -->
                    <div class="w-44 flex-shrink-0">
                      <p class="font-semibold text-[#1a1a1a] text-sm leading-tight">{{ $patientName }}</p>
                      <span
                        class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-500 text-[11px] font-medium">
                        ID #{{ $appt->patient_id }}
                      </span>
                      <span class="patient-info hidden">
                          {{ $appt->patient->course ?? '' }}|
                          {{ $appt->patient->year_level ?? '' }}|
                          {{ $appt->patient->section ?? '' }}|
                          {{ $appt->appointment_date }}|
                          {{ $appt->patient->department ?? '' }}
                      </span>
                    </div>
                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>
                    <!-- Date & Time -->
                    <div class="flex items-start gap-3 w-44 flex-shrink-0">
                      <div class="icon-box bg-blue-50">
                        <i class="fa-regular fa-calendar text-blue-500 text-base"></i>
                      </div>
                      <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">Date &amp; Time
                        </p>
                        <p class="font-semibold text-[#1a1a1a] text-sm">{{ $dateLabel }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $timeLabel }}</p>
                      </div>
                    </div>
                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>
                    <!-- Service + Status -->
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                      <div class="icon-box {{ $iconBg }} flex-shrink-0">
                        <i class="fa-solid fa-tooth {{ $iconColor }} text-base"></i>
                      </div>
                      <div class="min-w-0">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">Service</p>
                        <p class="font-semibold text-[#1a1a1a] text-sm truncate">{{ $serviceLabel }}</p>
                        <span class="status-pill {{ $pillClass }}">
                          <span class="pill-dot"></span>{{ $pillText }}
                        </span>
                      </div>
                    </div>
                    <!-- Arrow -->
                    <div class="card-arrow-btn ml-auto flex-shrink-0">
                      <i class="fa-solid fa-arrow-right text-xs"></i>
                    </div>
                  </div>

                  <!-- ── MOBILE LAYOUT (hidden on desktop) ── -->
                  <div class="card-body-mobile items-center gap-3 px-5 py-3.5 pl-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                      <img
                        src="{{ $appt->patient->profile_image ? asset('storage/'.$appt->patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patientName).'&background=660000&color=FFFFFF&rounded=true&size=128' }}"
                        class="w-11 h-11 rounded-xl object-cover shadow-sm border-2 border-gray-100"
                        alt="{{ $patientName }}" />
                    </div>
                    <!-- Name, ID, status, date — stacked -->
                    <div class="flex-1 min-w-0">
                      <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                          <p class="font-semibold text-[#1a1a1a] text-sm leading-tight truncate">{{ $patientName }}</p>
                          <span
                            class="inline-block mt-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-[10px] font-medium">
                            ID #{{ $appt->patient_id }}
                          </span>
                          <span class="patient-info hidden">N/A|N/A|N/A|{{ $appt->appointment_date }}|N/A</span>
                        </div>
                        <div class="card-arrow-btn flex-shrink-0" style="width:28px;height:28px;">
                          <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i>
                        </div>
                      </div>
                      <!-- Date + service row -->
                      <div class="flex items-center gap-3 mt-2 flex-wrap">
                        <span class="flex items-center gap-1 text-[11px] text-gray-500">
                          <i class="fa-regular fa-calendar text-blue-400 text-[10px]"></i>
                          {{ $dateLabel }} · {{ $timeLabel }}
                        </span>
                        <span class="flex items-center gap-1 text-[11px] text-gray-500 truncate max-w-[120px]">
                          <i class="fa-solid fa-tooth {{ $iconColor }} text-[10px]"></i>
                          {{ $serviceLabel }}
                        </span>
                      </div>
                      <span class="status-pill {{ $pillClass }}" style="margin-top:5px;padding:3px 8px;font-size:10px;">
                        <span class="pill-dot"></span>{{ $pillText }}
                      </span>
                    </div>
                  </div>

                </a>

                @empty
                <div class="py-20 text-center">
                  <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-tooth text-3xl text-gray-300"></i>
                  </div>
                  <p class="text-gray-500 font-semibold text-base">No appointments found</p>
                  <p class="text-gray-400 text-sm mt-1">There are no appointments in the system yet.</p>
                </div>
                @endforelse

              </div>
            </div>

            <!-- Pagination -->
            <div id="pagination"
              class="flex items-center justify-center gap-2 md:gap-4 py-5 text-sm text-gray-600 border-t border-gray-100 flex-wrap">
              <button id="prevPage"
                class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-gray-300 cursor-not-allowed" disabled>
                <span>‹</span> Previous
              </button>
              <div id="pageNumbers" class="flex items-center gap-1 md:gap-2 flex-wrap justify-center"></div>
              <button id="nextPage"
                class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-[#8B0000] hover:bg-[#8B0000]/5 transition">
                Next <span>›</span>
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="pb-16 md:pb-24"></div>
  </main>

  <!-- FILTER MODAL -->
  <div id="filterModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden p-3 md:p-0">
    <div
      class="bg-white w-full md:w-[760px] rounded-xl shadow-2xl overflow-hidden border border-gray-200 flex flex-col max-h-[90vh]">
      <div class="px-5 py-4 flex items-center gap-3 flex-shrink-0">
        <i class="fa-solid fa-sliders text-[#8B0000]"></i>
        <h2 class="text-lg md:text-xl font-medium text-[#8B0000]">Filter</h2>
      </div>
      <div class="h-px bg-gray-200"></div>
      <div class="px-5 py-5 space-y-5 overflow-y-auto scroll-smooth flex-1">
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Sort</p>
          <div class="space-y-2">
            <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="sort" value="A-Z"
                class="filter-input radio-red" /> A-Z</label>
            <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="sort" value="Z-A"
                class="filter-input radio-red" /> Z-A</label>
          </div>
        </div>
        <div class="h-px bg-gray-200"></div>
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Date Range</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
              <label class="text-sm text-gray-700">From:</label>
              <input type="date" id="fromDate"
                class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200" />
            </div>
            <div class="space-y-2">
              <label class="text-sm text-gray-700">To:</label>
              <input type="date" id="toDate"
                class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200" />
            </div>
          </div>
          <div class="flex gap-6 pt-1">
            <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="dateOrder"
                value="Ascending" class="radio-red" /> Ascending</label>
            <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="dateOrder"
                value="Descending" class="radio-red" /> Descending</label>
          </div>
        </div>
        <div class="h-px bg-gray-200"></div>
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Course</p>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-x-6 gap-y-3 text-sm text-gray-700">
            @foreach(['BSIT','BSECE','BSBA - HRM','BSED - ENG','BSOA','BSPSYCH','DIT','BSME','BSBA - MM','BSED -
            MATH','DOMT'] as $course)
            <label class="flex items-center gap-2"><input type="radio" name="course" value="{{ $course }}"
                class="filter-input radio-red" /> {{ $course }}</label>
            @endforeach
          </div>
        </div>
        <div class="h-px bg-gray-200"></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-3">
            <p class="text-sm text-gray-500">Year</p>
            <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-700">
              <label class="flex items-center gap-3"><input type="radio" name="year" value="1st Year"
                  class="filter-input radio-red" /> 1st Year</label>
              <label class="flex items-center gap-3"><input type="radio" name="year" value="3rd Year"
                  class="filter-input radio-red" /> 3rd Year</label>
              <label class="flex items-center gap-3"><input type="radio" name="year" value="2nd Year"
                  class="filter-input radio-red" /> 2nd Year</label>
              <label class="flex items-center gap-3"><input type="radio" name="year" value="4th Year"
                  class="filter-input radio-red" /> 4th Year</label>
            </div>
          </div>
          <div class="space-y-3">
            <p class="text-sm text-gray-500">Section</p>
            <div class="space-y-3 text-sm text-gray-700">
              <label class="flex items-center gap-3"><input type="radio" name="section" value="1"
                  class="filter-input radio-red" /> 1</label>
              <label class="flex items-center gap-3"><input type="radio" name="section" value="2"
                  class="filter-input radio-red" /> 2</label>
            </div>
          </div>
        </div>
        <div class="h-px bg-gray-200"></div>
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Department</p>
          <div class="flex flex-wrap gap-x-8 gap-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="department" value="Administrative"
                class="filter-input radio-red" /> Administrative</label>
            <label class="flex items-center gap-3"><input type="radio" name="department" value="Faculty"
                class="filter-input radio-red" /> Faculty</label>
            <label class="flex items-center gap-3"><input type="radio" name="department" value="Dependent"
                class="filter-input radio-red" /> Dependent</label>
          </div>
        </div>
      </div>
      <div class="h-px bg-gray-200 flex-shrink-0"></div>
      <div class="px-5 py-4 flex items-center justify-between bg-white flex-shrink-0">
        <button id="clearFiltersModal" type="button"
          class="text-[#8B0000] text-sm font-medium hover:underline">Clear</button>
        <button id="applyFilters" type="button"
          class="bg-[#8B0000] text-white px-8 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000] transition">Save</button>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>

    /* TAB ACTIVE STATE */
    document.querySelectorAll('.filter-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(function (b) { b.classList.remove('tab-active'); });
        btn.classList.add('tab-active');
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      var patientContainer = document.getElementById("patientContainer");
      if (!patientContainer) return;

      var allPatients = Array.from(patientContainer.querySelectorAll(".patient-item"));
      var filterModal = document.getElementById("filterModal");
      var filterPill = document.getElementById("openFilter");
      var filterDot = document.getElementById("filterDot");
      var clearFiltersModal = document.getElementById("clearFiltersModal");
      var applyFiltersBtn = document.getElementById("applyFilters");
      var searchInput = document.getElementById("searchInput");
      var filterButtons = document.querySelectorAll(".filter-btn");

      var countEls = {
        today: document.querySelector('.filter-btn[data-filter="today"] .tab-count'),
        upcoming: document.querySelector('.filter-btn[data-filter="upcoming"] .tab-count'),
        rescheduled: document.querySelector('.filter-btn[data-filter="rescheduled"] .tab-count'),
        cancelled: document.querySelector('.filter-btn[data-filter="cancelled"] .tab-count'),
        completed: document.querySelector('.filter-btn[data-filter="completed"] .tab-count'),
        all: document.querySelector('.filter-btn[data-filter="all"] .tab-count'),
      };

      var activeTab = "today", searchKeyword = "";
      var selectedProgram = null, selectedYearLevel = null, selectedSection = null, selectedDepartment = null;
      var nameSort = null, dateSort = null;
      var activeFromDate = "", activeToDate = "";

      var deptRadios = Array.from(document.querySelectorAll('input[name="department"]'));
      var courseRadios = Array.from(document.querySelectorAll('input[name="course"]'));
      var yearRadios = Array.from(document.querySelectorAll('input[name="year"]'));
      var sectionRadios = Array.from(document.querySelectorAll('input[name="section"]'));
      var otherRadios = courseRadios.concat(yearRadios).concat(sectionRadios);

      function anyChecked(list) { return list.some(function (i) { return i.checked; }); }
      function setDisabled(list, d) {
        list.forEach(function (i) {
          i.disabled = d;
          if (i.closest("label")) {
            i.closest("label").classList.toggle("opacity-50", d);
            i.closest("label").classList.toggle("cursor-not-allowed", d);
          }
        });
      }
      function clearChecked(list) { list.forEach(function (i) { i.checked = false; }); }
      function ilike(val, t) { return (val || "").toLowerCase().includes((t || "").toLowerCase()); }

      function syncMutualExclusion() {
        if (anyChecked(deptRadios)) { clearChecked(otherRadios); setDisabled(otherRadios, true); setDisabled(deptRadios, false); return; }
        if (anyChecked(otherRadios)) { clearChecked(deptRadios); setDisabled(deptRadios, true); setDisabled(otherRadios, false); return; }
        setDisabled(deptRadios, false); setDisabled(otherRadios, false);
      }
      deptRadios.concat(otherRadios).forEach(function (r) { r.addEventListener("change", syncMutualExclusion); });

      function getInfo(p) {
        var parts = ((p.querySelector(".patient-info") ? p.querySelector(".patient-info").textContent.trim() : "") || "").split("|").map(function (s) { return s.trim(); });
        return { program: parts[0] || "", year: parts[1] || "", section: parts[2] || "", dateStr: parts[3] || "", department: parts[4] || p.dataset.department || "" };
      }
      function getName(p) { return (p.querySelector(".font-semibold") ? p.querySelector(".font-semibold").textContent : "").trim(); }
      function getService(p) { return (p.querySelector(".truncate") ? p.querySelector(".truncate").textContent : "").trim(); }
      function getIdText(p) { var el = p.querySelector(".text-gray-500.text-\\[11px\\]"); return el ? el.textContent.trim() : ""; }

      function matchesSearch(p, kw) {
        if (!kw) return true;
        var info = getInfo(p);
        var haystack = [getName(p), getService(p), getIdText(p), info.program, info.department, info.dateStr].join(" ").toLowerCase();
        return haystack.includes(kw);
      }

      function updateFilterButtonState() {
        var has = !!searchKeyword || !!selectedProgram || !!selectedYearLevel || !!selectedSection || !!selectedDepartment || !!nameSort || !!dateSort || !!activeFromDate || !!activeToDate;
        if (filterPill) filterPill.classList.toggle("filter-active", has);
        if (filterDot) filterDot.classList.toggle("hidden", !has);
      }

      if (filterPill) filterPill.addEventListener("click", function (e) {
        e.preventDefault();
        if (filterModal) filterModal.classList.remove("hidden");
        syncMutualExclusion();
      });
      if (filterModal) filterModal.addEventListener("click", function (e) {
        if (e.target === filterModal) { filterModal.classList.add("hidden"); updateFilterButtonState(); }
      });
      document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && filterModal) { filterModal.classList.add("hidden"); updateFilterButtonState(); }
      });

      var pagination = document.getElementById("pagination");
      var pageNumbers = document.getElementById("pageNumbers");
      var prevPageBtn = document.getElementById("prevPage");
      var nextPageBtn = document.getElementById("nextPage");
      var PER_PAGE = 5;
      var currentPage = 1, currentItems = [];

      function renderPagination(items) {
        currentItems = items;
        var total = Math.ceil(items.length / PER_PAGE);
        if (pageNumbers) pageNumbers.innerHTML = "";
        if (total <= 1) { if (pagination) pagination.classList.add("hidden"); return; }
        if (pagination) pagination.classList.remove("hidden");
        for (var i = 1; i <= total; i++) {
          (function (pageNum) {
            var btn = document.createElement("button");
            btn.textContent = pageNum;
            btn.className = pageNum === currentPage
              ? "px-3 py-1.5 rounded-lg bg-[#8B0000]/10 text-[#8B0000] font-semibold text-sm"
              : "px-3 py-1.5 rounded-lg hover:bg-gray-100 text-gray-600 text-sm";
            btn.addEventListener("click", function () { currentPage = pageNum; updatePage(); });
            if (pageNumbers) pageNumbers.appendChild(btn);
          })(i);
        }
        if (prevPageBtn) {
          prevPageBtn.disabled = currentPage === 1;
          prevPageBtn.classList.toggle("cursor-not-allowed", currentPage === 1);
          prevPageBtn.classList.toggle("text-gray-300", currentPage === 1);
          prevPageBtn.classList.toggle("text-[#8B0000]", currentPage !== 1);
        }
        if (nextPageBtn) {
          nextPageBtn.disabled = currentPage === total;
          nextPageBtn.classList.toggle("cursor-not-allowed", currentPage === total);
          nextPageBtn.classList.toggle("text-gray-300", currentPage === total);
          nextPageBtn.classList.toggle("text-[#8B0000]", currentPage !== total);
        }
      }

      function updatePage() {
        var s = (currentPage - 1) * PER_PAGE, e = s + PER_PAGE;
        patientContainer.innerHTML = "";

        if (currentItems.length === 0) {
          var isSearching = searchKeyword.trim().length > 0;
          var hasFilters = !!selectedProgram || !!selectedYearLevel || !!selectedSection || !!selectedDepartment || !!activeFromDate || !!activeToDate;
          var emptyMessages = {
            today: { icon: "fa-calendar-days", title: "No appointments today", sub: "Enjoy the quiet — nothing scheduled for today." },
            upcoming: { icon: "fa-hourglass-half", title: "No upcoming appointments", sub: "New bookings will show up here once confirmed." },
            rescheduled: { icon: "fa-rotate", title: "No rescheduled appointments", sub: "Any rescheduled visits will appear here." },
            cancelled: { icon: "fa-xmark-circle", title: "No cancelled appointments", sub: "That's great! Nothing has been cancelled." },
            completed: { icon: "fa-circle-check", title: "No completed appointments yet", sub: "Completed visits will be recorded here." },
            all: { icon: "fa-clipboard-list", title: "No appointments found", sub: "There are no appointments in the system yet." },
          };
          var icon, title, sub, extraHtml = "";
          if (isSearching) {
            icon = "fa-magnifying-glass"; title = 'No results for "' + searchKeyword + '"'; sub = "Try a different name, ID, or service type.";
            extraHtml = '<button onclick="document.getElementById(\'searchInput\').value=\'\'; document.getElementById(\'searchInput\').dispatchEvent(new Event(\'input\'));" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear search</button>';
          } else if (hasFilters) {
            icon = "fa-sliders"; title = "No matches for your filters"; sub = "Try removing or adjusting your filter criteria.";
            extraHtml = '<button id="clearFiltersInline" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear filters</button>';
          } else {
            var msg = emptyMessages[activeTab] || emptyMessages.all;
            icon = msg.icon; title = msg.title; sub = msg.sub;
          }
          patientContainer.innerHTML = '<div class="flex flex-col items-center justify-center py-20 text-center gap-2"><div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-3"><i class="fa-solid ' + icon + ' text-3xl text-gray-300"></i></div><p class="text-base font-semibold text-gray-500">' + title + '</p><p class="text-sm text-gray-400 max-w-xs">' + sub + '</p>' + extraHtml + '</div>';

          var inlineClear = document.getElementById("clearFiltersInline");
          if (inlineClear) inlineClear.addEventListener("click", function () {
            selectedDepartment = selectedProgram = selectedYearLevel = selectedSection = nameSort = dateSort = null;
            activeFromDate = activeToDate = "";
            if (filterModal) filterModal.querySelectorAll("input[type='radio']").forEach(function (i) { i.checked = false; i.disabled = false; if (i.closest("label")) { i.closest("label").classList.remove("opacity-50", "cursor-not-allowed"); } });
            var f = document.getElementById("fromDate"), t = document.getElementById("toDate");
            if (f) f.value = ""; if (t) t.value = "";
            syncMutualExclusion(); applyFilters(); updateFilterButtonState();
          });

          if (pagination) pagination.classList.add("hidden");
          return;
        }

        currentItems.slice(s, e).forEach(function (p) { patientContainer.appendChild(p); });
        renderPagination(currentItems);
      }

      if (prevPageBtn) prevPageBtn.addEventListener("click", function () { if (currentPage > 1) { currentPage--; updatePage(); } });
      if (nextPageBtn) nextPageBtn.addEventListener("click", function () { if (currentPage < Math.ceil(currentItems.length / PER_PAGE)) { currentPage++; updatePage(); } });

      function applyFilters() {
        var data = allPatients.slice();
        if (activeTab !== "all") data = data.filter(function (p) { return p.classList.contains(activeTab); });
        if (searchKeyword) data = data.filter(function (p) { return matchesSearch(p, searchKeyword); });
        if (selectedProgram) data = data.filter(function (p) { return ilike(getInfo(p).program, selectedProgram); });
        if (selectedYearLevel || selectedSection) data = data.filter(function (p) {
          var i = getInfo(p);
          if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
          if (selectedSection && String(i.section).trim() !== String(selectedSection).trim()) return false;
          return true;
        });
        if (selectedDepartment) data = data.filter(function (p) { return ilike(getInfo(p).department, selectedDepartment); });
        if (activeFromDate || activeToDate) data = data.filter(function (p) {
          var d = new Date(getInfo(p).dateStr);
          if (isNaN(d)) return false;
          if (activeFromDate && d < new Date(activeFromDate)) return false;
          if (activeToDate && d > new Date(activeToDate)) return false;
          return true;
        });
        if (nameSort === "az") data.sort(function (a, b) { return getName(a).localeCompare(getName(b)); });
        if (nameSort === "za") data.sort(function (a, b) { return getName(b).localeCompare(getName(a)); });
        if (dateSort === "asc") data.sort(function (a, b) { return new Date(getInfo(a).dateStr) - new Date(getInfo(b).dateStr); });
        if (dateSort === "desc") data.sort(function (a, b) { return new Date(getInfo(b).dateStr) - new Date(getInfo(a).dateStr); });
        currentPage = 1;
        renderPagination(data);
        updatePage();
        updateCounts();
        updateFilterButtonState();
      }

      function computeCount(tab) {
        var data = allPatients.slice();
        if (tab !== "all") data = data.filter(function (p) { return p.classList.contains(tab); });
        if (searchKeyword) data = data.filter(function (p) { return matchesSearch(p, searchKeyword); });
        if (selectedProgram) data = data.filter(function (p) { return ilike(getInfo(p).program, selectedProgram); });
        if (selectedYearLevel || selectedSection) data = data.filter(function (p) {
          var i = getInfo(p);
          if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
          if (selectedSection && String(i.section).trim() !== String(selectedSection).trim()) return false;
          return true;
        });
        if (selectedDepartment) data = data.filter(function (p) { return ilike(getInfo(p).department, selectedDepartment); });
        if (activeFromDate || activeToDate) data = data.filter(function (p) {
          var d = new Date(getInfo(p).dateStr);
          if (isNaN(d)) return false;
          if (activeFromDate && d < new Date(activeFromDate)) return false;
          if (activeToDate && d > new Date(activeToDate)) return false;
          return true;
        });
        return data.length;
      }

      function updateCounts() {
        Object.keys(countEls).forEach(function (tab) {
          if (countEls[tab]) countEls[tab].textContent = computeCount(tab);
        });
      }

      filterButtons.forEach(function (btn) {
        btn.addEventListener("click", function () { activeTab = btn.dataset.filter; applyFilters(); });
      });

      if (searchInput) searchInput.addEventListener("input", function () {
        searchKeyword = searchInput.value.trim().toLowerCase(); applyFilters();
      });

      var searchClearBtn = document.getElementById("searchClearBtn");
      if (searchInput) searchInput.addEventListener("input", function () {
        if (searchClearBtn) searchClearBtn.classList.toggle("hidden", searchInput.value.length === 0);
      });
      if (searchClearBtn) searchClearBtn.addEventListener("click", function () {
        searchInput.value = ""; searchInput.dispatchEvent(new Event("input"));
        searchClearBtn.classList.add("hidden"); searchInput.focus();
      });

      if (applyFiltersBtn) applyFiltersBtn.addEventListener("click", function () {
        selectedDepartment = (filterModal && filterModal.querySelector('input[name="department"]:checked')) ? filterModal.querySelector('input[name="department"]:checked').value : null;
        selectedProgram = (filterModal && filterModal.querySelector('input[name="course"]:checked')) ? filterModal.querySelector('input[name="course"]:checked').value : null;
        selectedYearLevel = (filterModal && filterModal.querySelector('input[name="year"]:checked')) ? filterModal.querySelector('input[name="year"]:checked').value : null;
        selectedSection = (filterModal && filterModal.querySelector('input[name="section"]:checked')) ? filterModal.querySelector('input[name="section"]:checked').value : null;
        var sv = (filterModal && filterModal.querySelector('input[name="sort"]:checked')) ? filterModal.querySelector('input[name="sort"]:checked').value : null;
        nameSort = (sv === "A-Z" || sv === "az") ? "az" : (sv === "Z-A" || sv === "za") ? "za" : null;
        var dv = (filterModal && filterModal.querySelector('input[name="dateOrder"]:checked')) ? filterModal.querySelector('input[name="dateOrder"]:checked').value : null;
        dateSort = (dv === "Ascending" || dv === "asc") ? "asc" : (dv === "Descending" || dv === "desc") ? "desc" : null;
        activeFromDate = document.getElementById("fromDate") ? document.getElementById("fromDate").value : "";
        activeToDate = document.getElementById("toDate") ? document.getElementById("toDate").value : "";
        if (filterModal) filterModal.classList.add("hidden");
        syncMutualExclusion(); applyFilters(); updateFilterButtonState();
      });

      if (clearFiltersModal) clearFiltersModal.addEventListener("click", function () {
        if (filterModal) filterModal.querySelectorAll("input[type='radio']").forEach(function (i) { i.checked = false; i.disabled = false; if (i.closest("label")) { i.closest("label").classList.remove("opacity-50", "cursor-not-allowed"); } });
        var f = document.getElementById("fromDate"), t = document.getElementById("toDate");
        if (f) f.value = ""; if (t) t.value = "";
        syncMutualExclusion();
      });

      syncMutualExclusion();
      document.querySelectorAll('.filter-btn').forEach(function (b) { b.classList.remove('tab-active'); });
      var todayBtn = document.querySelector('.filter-btn[data-filter="today"]');
      if (todayBtn) todayBtn.classList.add('tab-active');
      applyFilters();
    });
  </script>
@endsection