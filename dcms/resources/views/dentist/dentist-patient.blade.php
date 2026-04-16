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
    background: linear-gradient(180deg, #333333, #6B7280);
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
    color: #333333;
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

  .card-col-header {
    display: none;
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

  #searchInput:focus {
    box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
  }

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

  .card-body-desktop {
    display: flex;
  }

  .card-body-mobile {
    display: none;
  }

  .active-filters-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding-bottom: 16px;
    margin-bottom: 16px;
    border-bottom: 1px solid #F3F4F6;
  }

  .filter-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #8B0000;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
  }

  #filterBtn.has-filters {
    border-color: #8B0000;
    color: #8B0000;
    background: rgba(139, 0, 0, 0.05);
  }

  .filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #ffffff;
    border: 1px solid #E5E7EB;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 600;
    color: #4B5563;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    transition: all 0.2s;
  }

  .filter-chip:hover {
    border-color: #D1D5DB;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
  }

  .filter-chip-remove {
    color: #333333;
    cursor: pointer;
    transition: color 0.2s;
    display: flex;
    align-items: center;
    margin-left: 2px;
  }

  .filter-chip-remove:hover {
    color: #EF4444;
  }

  .clear-all-chips {
    font-size: 11.5px;
    font-weight: 700;
    color: #D97706;
    background: #FFF7ED;
    border: 1px solid #FFEDD5;
    padding: 6px 14px;
    border-radius: 999px;
    cursor: pointer;
    transition: background 0.2s;
  }

  .clear-all-chips:hover {
    background: #FFEDD5;
  }

  .filter-drawer-wrapper {
    position: fixed;
    inset: 0;
    z-index: 1100;
    visibility: hidden;
  }

  .filter-drawer-wrapper.open {
    visibility: visible;
  }

  .filter-drawer-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(2px);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .filter-drawer-wrapper.open .filter-drawer-overlay {
    opacity: 1;
  }

  .filter-drawer-panel {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    max-width: 480px;
    background: #fff;
    border-radius: 24px 0 0 24px;
    box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
  }

  .filter-drawer-wrapper.open .filter-drawer-panel {
    transform: translateX(0);
  }

  .ftag {
    padding: 0.5rem 0.25rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #4B5563;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
  }

  .ftag:hover {
    color: #111827;
  }

  .ftag.ftag-active {
    background: #8B0000;
    color: #ffffff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  }

  /* ── VIEW TOGGLE STYLES ── */
  .view-toggle-container {
    background: #ffffff;
    border-radius: 14px;
    padding: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
    border: 1px solid #f9eaea;
    box-shadow: 0 2px 10px rgba(139, 0, 0, 0.04);
    position: relative;
  }

  .view-slider {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 36px;
    height: 36px;
    background: #8B0000;
    border-radius: 10px;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
    box-shadow: 0 4px 12px rgba(139, 0, 0, 0.25);
  }

  .mode-list .view-slider {
    transform: translateX(0);
  }

  .mode-grid .view-slider {
    transform: translateX(40px)
  }

  .btn-view-mode {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9CA3AF;
    transition: all 0.3s ease;
    border: none;
    background: transparent !important;
    cursor: pointer;
    position: relative;
    z-index: 2;
  }

  .btn-view-mode:hover:not(.active) {
    color: #8B0000;
    background: #fff5f5;
  }

  .btn-view-mode.active {
    color: #FFFFFF;
    background: transparent !important;
    box-shadow: none !important;
  }

  .mode-list .table-scroll-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
  }

  .mode-list .table-scroll-inner {
    min-width: 950px;
  }

  .mode-list .card-col-header {
    display: grid !important;
  }

  .mode-list .card-body-desktop {
    display: flex !important;
  }

  .mode-list .card-body-mobile {
    display: none !important;
  }

  .mode-grid .card-col-header {
    display: none !important;
  }

  .mode-grid .card-body-desktop {
    display: none !important;
  }

  .mode-grid .card-body-mobile {
    display: flex !important;
    flex-direction: row;
    align-items: flex-start;
    height: 100%;
  }

  .mode-grid #patientContainer {
    display: grid !important;
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .mode-grid #patientContainer>.patient-item {
    margin-top: 0 !important;
    height: 100%;
  }

  @media (min-width: 640px) {
    .mode-grid #patientContainer {
      grid-template-columns: repeat(2, 1fr) !important;
    }
  }

  @media (min-width: 1024px) {
    .mode-grid #patientContainer {
      grid-template-columns: repeat(2, 1fr) !important;
    }
  }

  @media (min-width: 1280px) {
    .mode-grid #patientContainer {
      grid-template-columns: repeat(3, 1fr) !important;
    }
  }

  /* ── MOBILE OVERRIDES ── */
  @media (max-width: 767px) {
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

    #searchInput {
      width: 100% !important;
    }

    #filterBtn {
      justify-content: center;
    }

    .page-title-row {
      flex-direction: column !important;
      align-items: flex-start !important;
    }

    .filter-drawer-panel {
      top: auto;
      bottom: 0;
      right: 0;
      left: 0;
      height: auto;
      max-height: 85vh;
      max-width: 100%;
      border-radius: 24px 24px 0 0;
      transform: translateY(100%);
    }

    .filter-drawer-wrapper.open .filter-drawer-panel {
      transform: translateY(0);
    }

    #externalClearFilterBtn {
      width: 38px;
      height: 38px;
      padding: 0;
    }
  }

  @media (max-width: 767px) {

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

    #searchInput {
      width: 100% !important;
    }

    #filterBtn {
      justify-content: center;
    }

    .page-title-row {
      flex-direction: column !important;
      align-items: flex-start !important;
    }

    .card-col-header {
      display: none !important;
    }

    .card-body-desktop {
      display: none !important;
    }

    .card-body-mobile {
      display: flex !important;
    }

    #siteFooter {
      padding: 1rem;
    }

    .footer-inner {
      gap: .75rem;
      font-size: .7rem;
    }

    .filter-drawer-panel {
      top: auto;
      bottom: 0;
      right: 0;
      left: 0;
      height: auto;
      max-height: 85vh;
      max-width: 100%;
      border-radius: 24px 24px 0 0;
      transform: translateY(100%);
    }

    .filter-drawer-wrapper.open .filter-drawer-panel {
      transform: translateY(0);
    }

    #externalClearFilterBtn {
      width: 38px;
      height: 38px;
      padding: 0;
    }
  }

  @media (max-width: 1024px) {

    .tabs-grid {
      grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
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

    #filterModal>div {
      width: calc(100vw - 24px) !important;
      margin: 12px;
      max-height: calc(100vh - 24px);
    }
  }

  @media (min-width: 1024px) {
    .card-col-header {
      display: grid;
    }
  }

  .table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
  }

  [data-theme="dark"] .table-card {
    background: #111827 !important;
    border-color: #2a3244 !important;
  }
</style>
@endsection

@section('content')
@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<main id="mainContent" class="pt-[100px] px-3 md:px-6 py-6 min-h-screen flex-1 mode-list">
  <div class="w-full fade-in">

    @php
    use Carbon\Carbon;
    $today = Carbon::today()->toDateString();
    $appts =
    $appointments instanceof \Illuminate\Pagination\AbstractPaginator
    ? collect($appointments->items())
    : collect($appointments);
    $todayCount = $todayCount ?? 0;
    $upcomingCount = $upcomingCount ?? 0;
    $rescheduledCount = $rescheduledCount ?? 0;
    $cancelledCount = $cancelledCount ?? 0;
    $completedCount = $completedCount ?? 0;
    $allCount = $allCount ?? 0;
    @endphp

    <div class="page-title-row flex flex-col md:flex-row md:items-start justify-between mb-6 gap-4">
      <div class="mb-2">
        <div class="flex items-center gap-3">
          <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-1.5">
              Patient Directory
            </h2>
          </div>
        </div>
        <div class="page-summary mt-3">
          <span class="summary-tag"><span class="summary-tag-dot bg-gray-400"></span>{{ $allCount }}
            total</span>
          @if ($todayCount > 0)
          <span class="summary-tag"><span class="summary-tag-dot bg-blue-500"></span>{{ $todayCount }}
            today</span>
          @endif
          @if ($upcomingCount > 0)
          <span class="summary-tag"><span class="summary-tag-dot bg-orange-500"></span>{{ $upcomingCount }}
            upcoming</span>
          @endif
          @if ($completedCount > 0)
          <span class="summary-tag"><span class="summary-tag-dot bg-green-500"></span>{{ $completedCount }}
            completed</span>
          @endif
          @if ($cancelledCount > 0)
          <span class="summary-tag"><span class="summary-tag-dot bg-red-500"></span>{{ $cancelledCount }}
            cancelled</span>
          @endif
        </div>
      </div>
    </div>

    <div class="w-full">
      <div class="relative">

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

        <div class="table-card rounded-2xl border border-gray-200 shadow-sm overflow-hidden bg-white">

          <div class="px-4 md:px-6 py-3.5 border-b border-gray-100 bg-[#FAFAFA]/50">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">

              <div class="order-2 md:order-1">
                <span id="rowCount" class="text-[11px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">
                  0 patients
                </span>
              </div>

              <div class="flex items-center gap-2 order-1 md:order-2 w-full md:w-auto justify-end">

                <div class="view-toggle-container hidden md:flex mr-2">
                  <div class="view-slider"></div>

                  <button id="btnListView" onclick="switchView('list')" class="btn-view-mode active"
                    title="List View"><i class="fa-solid fa-list text-sm"></i></button>
                  <button id="btnGridView" onclick="switchView('grid')" class="btn-view-mode" title="Grid View"><i
                      class="fa-solid fa-border-all text-sm"></i></button>
                </div>

                <div class="relative flex-1 md:flex-none flex items-center gap-2">
                  <div class="relative flex-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
                      <i class="fa-solid fa-magnifying-glass text-[#333333] text-xs"></i>
                    </span>
                    <input id="searchInput" type="text" placeholder="Search patient name…"
                      class="pl-9 pr-4 py-2 w-full md:w-64 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#8B0000]/10 focus:border-[#8B0000] transition-all" />
                  </div>

                  <button type="button" id="searchClearBtn"
                    class="text-xs font-bold text-red-600 hover:text-red-800 transition-colors hidden flex-shrink-0 px-1">
                    Clear
                  </button>
                </div>

                <button id="filterBtn" type="button"
                  class="relative flex items-center justify-center gap-2 px-3 md:px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-600 shadow-sm hover:border-[#8B0000] hover:text-[#8B0000] transition-all flex-shrink-0">
                  <i class="fa-solid fa-sliders text-sm"></i>
                  <span class="text-xs md:text-sm font-bold">Filter</span>
                  <span id="filterBadge" class="filter-badge" style="display:none;"></span>
                </button>

                <button id="externalClearFilterBtn" type="button"
                  class="hidden flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 bg-white text-red-600 hover:bg-red-50 hover:border-red-300 transition-all flex-shrink-0"
                  title="Reset filters">
                  <i class="fa-solid fa-rotate-left text-sm"></i>
                </button>
              </div>
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

                $patientName = $appt->patient->name ?? 'Unknown Patient';
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
                ? 'bg-blue-100'
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
                @endphp

                <a href="{{ route('dentist.dentist.patient.profile', ['patient' => $appt->patient_id]) }}"
                  class="patient-card patient-item all {{ $tabClass }} block">

                  <div class="accent-bar {{ $accentClass }}"></div>

                  <div class="card-body-desktop items-center gap-5 px-8 py-4 pl-10">
                    <div class="relative flex-shrink-0">
                      <img
                        src="{{ $appt->patient->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patientName) . '&background=660000&color=FFFFFF&rounded=true&size=128' }}"
                        class="w-14 h-14 rounded-2xl object-cover shadow-sm border-2 border-gray-100"
                        alt="{{ $patientName }}" />
                    </div>
                    <div class="w-44 flex-shrink-0">
                      <p class="font-semibold text-[#1a1a1a] text-sm leading-tight">
                        {{ $patientName }}</p>
                      <span
                        class="inline-flex px-2.5 py-0.5 rounded-md bg-gray-200 text-gray-600 text-[10px] font-bold tracking-wide w-max">
                        {{ $appt->patient->course ?: 'No Program' }}
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
                    <div class="flex items-start gap-3 w-44 flex-shrink-0">
                      <div class="icon-box bg-blue-50">
                        <i class="fa-regular fa-calendar text-blue-500 text-base"></i>
                      </div>
                      <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">
                          Date &amp; Time
                        </p>
                        <p class="font-semibold text-[#1a1a1a] text-sm">
                          {{ $dateLabel }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $timeLabel }}</p>
                      </div>
                    </div>
                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                      <div class="icon-box {{ $iconBg }} flex-shrink-0">
                        <i class="fa-solid fa-tooth {{ $iconColor }} text-base"></i>
                      </div>
                      <div class="min-w-0">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">
                          Service</p>
                        <p class="font-semibold text-[#1a1a1a] text-sm truncate">
                          {{ $serviceLabel }}</p>
                        <span class="status-pill {{ $pillClass }}">
                          <span class="pill-dot"></span>{{ $pillText }}
                        </span>
                      </div>
                    </div>
                    <div class="card-arrow-btn ml-auto flex-shrink-0">
                      <i class="fa-solid fa-arrow-right text-xs"></i>
                    </div>
                  </div>

                  <div class="card-body-mobile w-full h-full flex items-start gap-4 p-5 pl-7 relative">

                    <div class="flex-shrink-0 pt-1">
                      <img
                        src="{{ $appt->patient->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patientName) . '&background=660000&color=FFFFFF&rounded=true&size=128' }}"
                        class="w-14 h-14 rounded-full object-cover shadow-sm border-[3px] border-gray-50"
                        alt="{{ $patientName }}" />
                    </div>

                    <div class="flex-1 min-w-0 flex flex-col">

                      <div class="flex items-start justify-between gap-2">
                        <div class="flex flex-col min-w-0 gap-1.5">

                          <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-bold text-gray-900 text-[15px] leading-tight truncate max-w-[150px]">
                              {{ $patientName }}</h3>
                            <span class="status-pill {{ $pillClass }} !m-0 !px-2 !py-0.5 text-[9.5px]">
                              <span class="pill-dot"></span>{{ $pillText }}
                            </span>
                          </div>

                          <span
                            class="inline-flex px-2.5 py-0.5 rounded-md bg-gray-200 text-gray-600 text-[10px] font-bold tracking-wide w-max">
                            {{ $appt->patient->course ?: 'No Program' }}
                          </span>

                          <span class="patient-info hidden">
                            {{ $appt->patient->course ?? '' }}|{{ $appt->patient->year_level ?? '' }}|{{
                            $appt->patient->section ?? '' }}|{{ $appt->appointment_date }}|{{ $appt->patient->department
                            ?? '' }}
                          </span>
                        </div>

                        <div class="card-arrow-btn flex-shrink-0 !w-8 !h-8 bg-gray-50">
                          <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </div>
                      </div>

                      <div class="flex flex-col mt-4 gap-1">

                        <div
                          class="inline-flex items-center gap-3 px-3 py-2 bg-white rounded-xl border border-gray-200 shadow-[0_4px_12px_rgba(0,0,0,0.05)] w-fit transition-all ">
                          <div class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class="fa-regular fa-calendar text-blue-500 text-[11px]"></i>
                          </div>
                          <span class="text-[12px] text-gray-700 font-bold tracking-tight pr-2 whitespace-nowrap">
                            {{ $dateLabel }} &middot; {{ $timeLabel }}
                          </span>
                        </div>

                        <div
                          class="inline-flex items-center gap-3 px-3 py-2 bg-white rounded-xl border border-gray-200 shadow-[0_4px_12px_rgba(0,0,0,0.05)] w-fit max-w-full transition-all ">
                          <div class="w-6 h-6 rounded-lg {{ $iconBg }} flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-tooth {{ $iconColor }} text-[11px]"></i>
                          </div>
                          <span class="text-[12px] text-gray-600 font-semibold truncate pr-2">
                            {{ $serviceLabel }}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
                @empty
                <div class="py-20 text-center col-span-full w-full">
                  <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-tooth text-3xl text-gray-300"></i>
                  </div>
                  <p class="text-gray-500 font-semibold text-base">No appointments found</p>
                  <p class="text-gray-400 text-sm mt-1">There are no appointments in the system
                    yet.</p>
                </div>
                @endforelse
              </div>
            </div>

            <div id="pagination"
              class="flex items-center justify-center gap-2 md:gap-4 py-5 text-sm text-gray-600 border-t border-gray-100 flex-wrap">
              <button id="prevPage"
                class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-gray-300 cursor-not-allowed" disabled>
                <span>‹</span> Previous
              </button>
              <div id="pageNumbers" class="flex items-center gap-1 md:gap-2 flex-wrap justify-center">
              </div>
              <button id="nextPage"
                class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-[#8B0000] hover:bg-[#8B0000]/5 transition">
                Next <span>›</span>
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
</main>

<div id="filterModal" class="filter-drawer-wrapper">
  <div class="filter-drawer-overlay" onclick="document.getElementById('closeFilterModalBtn').click()"></div>

  <div class="filter-drawer-panel flex flex-col bg-white">

    <div class="px-6 py-5 flex items-center justify-between flex-shrink-0 bg-white border-b border-gray-100">
      <div class="flex items-center gap-2 text-[#8B0000]">
        <i class="fa-solid fa-filter text-xl"></i>
        <h2 class="text-xl font-extrabold">Filters</h2>
      </div>
      <button id="closeFilterModalBtn" type="button" class="text-gray-400 hover:text-gray-700 transition-colors">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
    </div>

    <div class="px-6 py-4 flex flex-col gap-6 flex-1 overflow-y-auto scroll-smooth bg-white">

      <div id="activeFiltersSection" class="hidden">
        <div class="flex items-center justify-between mb-2">
          <span class="text-[13px] font-bold text-gray-800">Active Filters</span>
          <button id="clearAllChipsBtn" type="button" class="text-xs font-bold text-[#8B0000] hover:underline">Clear
            All</button>
        </div>
        <div id="activeChipsContainer" class="flex flex-wrap gap-2 pb-4 border-b border-gray-100"></div>
      </div>

      <div>
        <h3 class="text-[13px] font-bold text-gray-800 mb-2">Sort Results</h3>
        <div class="flex bg-gray-100 p-1 rounded-lg w-full gap-2" id="fSortGroup">
          <button class="ftag ftag-active flex-1 text-[11px] leading-tight" data-val="newest">Newest
            First</button>
          <button class="ftag flex-1 text-[11px] leading-tight" data-val="oldest">Oldest First</button>
          <button class="ftag flex-1 text-[11px] leading-tight" data-val="az">Patient<br>Name A-Z</button>
          <button class="ftag flex-1 text-[11px] leading-tight" data-val="za">Patient<br>Name Z-A</button>
        </div>
      </div>

      <div class="h-px bg-gray-100"></div>

      <div>
        <h3 class="text-[13px] font-bold text-gray-800 mb-2">Date Range</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="space-y-1.5 relative">
            <label class="text-xs font-semibold text-gray-500">From:</label>
            <input type="text" id="fromDate"
              class="w-full pl-3 pr-10 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:border-[#8B0000] focus:ring-1 focus:ring-[#8B0000] js-flatpickr-date-range-from"
              placeholder="Select date" />
            <i class="fa-regular fa-calendar absolute right-3.5 bottom-3.5 text-gray-800 z-0"></i>
          </div>
          <div class="space-y-1.5 relative">
            <label class="text-xs font-semibold text-gray-500">To:</label>
            <input type="text" id="toDate"
              class="w-full pl-3 pr-10 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:border-[#8B0000] focus:ring-1 focus:ring-[#8B0000] js-flatpickr-date-range-to"
              placeholder="Select date" />
            <i class="fa-regular fa-calendar absolute right-3.5 bottom-3.5 text-gray-800 z-0"></i>
          </div>
        </div>
      </div>

      <div class="h-px bg-gray-100"></div>

      <div>
        <h3 class="text-[13px] font-bold text-gray-800 mb-2">Course</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-x-4 gap-y-3">
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
          'BSED -
          MATH',
          'DOMT',
          ] as $course)
          <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
              name="course" value="{{ $course }}" class="filter-input radio-red" /> <span
              class="text-sm font-semibold text-gray-700">{{ $course }}</span></label>
          @endforeach
        </div>
      </div>

      <div class="h-px bg-gray-100"></div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <h3 class="text-[13px] font-bold text-gray-800 mb-2">Year Level</h3>
          <div class="grid grid-cols-2 gap-y-3">
            <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
                name="year" value="1st Year" class="filter-input radio-red" />
              <span class="text-sm font-semibold text-gray-700">1st Year</span></label>
            <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
                name="year" value="3rd Year" class="filter-input radio-red" />
              <span class="text-sm font-semibold text-gray-700">3rd Year</span></label>
            <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
                name="year" value="2nd Year" class="filter-input radio-red" />
              <span class="text-sm font-semibold text-gray-700">2nd Year</span></label>
            <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
                name="year" value="4th Year" class="filter-input radio-red" />
              <span class="text-sm font-semibold text-gray-700">4th Year</span></label>
          </div>
        </div>
        <div>
          <h3 class="text-[13px] font-bold text-gray-800 mb-2">Section</h3>
          <div class="space-y-3">
            <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
                name="section" value="1" class="filter-input radio-red" /> <span
                class="text-sm font-semibold text-gray-700">1</span></label>
            <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
                name="section" value="2" class="filter-input radio-red" /> <span
                class="text-sm font-semibold text-gray-700">2</span></label>
          </div>
        </div>
      </div>

      <div class="h-px bg-gray-100"></div>

      <div class="pb-6">
        <h3 class="text-[13px] font-bold text-gray-800 mb-2">Department</h3>
        <div class="flex flex-wrap gap-x-6 gap-y-3">
          <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
              name="department" value="Administrative" class="filter-input radio-red" /> <span
              class="text-sm font-semibold text-gray-700">Administrative</span></label>
          <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
              name="department" value="Faculty" class="filter-input radio-red" /> <span
              class="text-sm font-semibold text-gray-700">Faculty</span></label>
          <label class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"><input type="radio"
              name="department" value="Dependent" class="filter-input radio-red" />
            <span class="text-sm font-semibold text-gray-700">Dependent</span></label>
        </div>
      </div>
    </div>

    <div
      class="px-6 py-5 bg-white flex flex-col sm:flex-row items-center justify-between flex-shrink-0 border-t border-gray-100 gap-4 sm:gap-0 relative z-20">

      <button id="clearFiltersModal" type="button"
        class="flex items-center gap-2 text-[#8B0000] hover:text-[#6b0000] transition-colors w-full sm:w-auto justify-center sm:justify-start">
        <i class="fa-regular fa-trash-can text-lg"></i>
        <div class="text-left leading-tight text-[13px] font-bold">Clear<br>Filters</div>
      </button>

      <div class="flex items-center gap-3 w-full sm:w-auto">
        <button id="cancelFilterBtn" type="button"
          class="flex-1 sm:flex-none px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
          Cancel
        </button>
        <button id="applyFilters" type="button"
          class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-[#8B0000] rounded-lg hover:bg-[#6b0000] transition-colors shadow-sm">
          <i class="fa-solid fa-check"></i> Apply
        </button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function switchView(mode) {
    const mainContent = document.getElementById('mainContent');
    const btnList = document.getElementById('btnListView');
    const btnGrid = document.getElementById('btnGridView');

    if (!mainContent || !btnList || !btnGrid) return;

    if (mode === 'grid') {
      mainContent.classList.remove('mode-list');
      mainContent.classList.add('mode-grid');
      btnList.classList.remove('active');
      btnGrid.classList.add('active');
      localStorage.setItem('patientViewMode', 'grid');
    } else {
      mainContent.classList.remove('mode-grid');
      mainContent.classList.add('mode-list');
      btnGrid.classList.remove('active');
      btnList.classList.add('active');
      localStorage.setItem('patientViewMode', 'list');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    if (window.innerWidth <= 767) {
      switchView('grid');
    } else {
      const savedMode = localStorage.getItem('patientViewMode') || 'list';
      switchView(savedMode);
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth <= 767) {
      switchView('grid');
    }
  });

  document.querySelectorAll('.filter-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.filter-btn').forEach(function (b) {
        b.classList.remove('tab-active');
      });
      btn.classList.add('tab-active');
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
    let patientFilterModal = null;
    let patientSearchInput = null;
    let patientSearchClearBtn = null;
    let patientFilterBtn = null;
    let patientFilterBadge = null;
    let patientExternalResetBtn = null;

    function openFilterModal() {
      if (!patientFilterModal) return;
      patientFilterModal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeFilterModal() {
      if (!patientFilterModal) return;
      patientFilterModal.classList.remove('open');
      document.body.style.overflow = '';
    }

    function onSearch(input) {
      if (!input) return;
      input.dispatchEvent(new Event('input'));
    }

    function clearSearch() {
      if (!patientSearchInput) return;
      patientSearchInput.value = '';
      patientSearchInput.dispatchEvent(new Event('input'));
      patientSearchInput.focus();
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
      }

      if (patientSearchClearBtn) {
        patientSearchClearBtn.classList.add("hidden");
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
      patientSearchClearBtn = document.getElementById("searchClearBtn");
      patientFilterBtn = filterBtn;
      patientFilterBadge = filterBadge;
      patientExternalResetBtn = externalClearFilterBtn;

      var countEls = {
        today: document.querySelector('.filter-btn[data-filter="today"] .tab-count'),
        upcoming: document.querySelector('.filter-btn[data-filter="upcoming"] .tab-count'),
        rescheduled: document.querySelector('.filter-btn[data-filter="rescheduled"] .tab-count'),
        cancelled: document.querySelector('.filter-btn[data-filter="cancelled"] .tab-count'),
        completed: document.querySelector('.filter-btn[data-filter="completed"] .tab-count'),
        all: document.querySelector('.filter-btn[data-filter="all"] .tab-count')
      };

      var activeTab = "today";
      var searchKeyword = "";
      var selectedProgram = null,
        selectedYearLevel = null,
        selectedSection = null,
        selectedDepartment = null;
      var nameSort = null,
        dateSort = null;
      var activeFromDate = "",
        activeToDate = "";

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
          openFilterModal();
        };
      }

      var closeFilterModalBtn = document.getElementById("closeFilterModalBtn");
      if (closeFilterModalBtn) {
        closeFilterModalBtn.onclick = function () {
          if (filterModal) closeFilterModal();
          updateFilterButtonState();
        };
      }

      var cancelFilterBtn = document.getElementById("cancelFilterBtn");
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
        var f = document.getElementById("fromDate"),
          t = document.getElementById("toDate");
        if (f) f.value = "";
        if (t) t.value = "";

        selectedDepartment = null;
        selectedProgram = null;
        selectedYearLevel = null;
        selectedSection = null;
        activeFromDate = "";
        activeToDate = "";

        document.querySelectorAll('#fSortGroup .ftag').forEach(function (b) {
          b.classList.remove('ftag-active');
        });
        var defSort = document.querySelector('#fSortGroup .ftag[data-val="newest"]');
        if (defSort) defSort.classList.add('ftag-active');

        syncMutualExclusion();
        updateFilterButtonState();
        dateSort = 'desc';
        nameSort = null;
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
        if (fDate && tDate && (fDate.value || tDate.value)) {
          var lbl = fDate.value && tDate.value ? (fDate.value + " to " + tDate.value) : (fDate.value ?
            "From " + fDate.value : "Until " + tDate.value);
          addChip(lbl, function () {
            fDate.value = "";
            tDate.value = "";
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
      }

      if (filterModal) {
        var allModalInputs = filterModal.querySelectorAll("input");
        allModalInputs.forEach(function (input) {
          input.addEventListener("change", renderFilterChips);
        });
      }

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
          department: parts[4] || p.getAttribute("data-department") || ""
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

        if (activeFromDate || activeToDate) count++;

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

      var searchClearBtn = document.getElementById("searchClearBtn");

      if (searchInput) {
        searchInput.addEventListener("input", function () {
          searchKeyword = searchInput.value.trim().toLowerCase();

          if (searchClearBtn) {
            if (searchKeyword.length > 0) {
              searchClearBtn.classList.remove("hidden");
            } else {
              searchClearBtn.classList.add("hidden");
            }
          }

          applyFilters();
        });
      }

      if (searchClearBtn) {
        searchClearBtn.onclick = function () {
          if (searchInput) {
            searchInput.value = "";
            searchInput.dispatchEvent(new Event("input"));
            searchInput.focus();
          }
        };
      }

      var fSortGroup = document.getElementById('fSortGroup');
      if (fSortGroup) {
        fSortGroup.onclick = function (e) {
          var btn = e.target.closest('.ftag');
          if (!btn) return;
          document.querySelectorAll('#fSortGroup .ftag').forEach(function (b) {
            b.classList.remove('ftag-active');
          });
          btn.classList.add('ftag-active');
          renderFilterChips();
        };
      }

      var tabButtons = document.querySelectorAll('.filter-btn');
      tabButtons.forEach(function (btn) {
        btn.addEventListener("click", function () {
          activeTab = btn.getAttribute("data-filter");
          applyFilters();
        });
      });

      if (applyFiltersBtn) {
        applyFiltersBtn.onclick = function () {
          var deptEl = filterModal ? filterModal.querySelector(
            'input[name="department"]:checked') : null;
          var crsEl = filterModal ? filterModal.querySelector('input[name="course"]:checked') :
            null;
          var yrEl = filterModal ? filterModal.querySelector('input[name="year"]:checked') : null;
          var secEl = filterModal ? filterModal.querySelector('input[name="section"]:checked') :
            null;

          selectedDepartment = deptEl ? deptEl.value : null;
          selectedProgram = crsEl ? crsEl.value : null;
          selectedYearLevel = yrEl ? yrEl.value : null;
          selectedSection = secEl ? secEl.value : null;

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

          var fromDateEl = document.getElementById("fromDate");
          var toDateEl = document.getElementById("toDate");
          activeFromDate = fromDateEl ? fromDateEl.value : "";
          activeToDate = toDateEl ? toDateEl.value : "";

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

      var pagination = document.getElementById("pagination");
      var pageNumbers = document.getElementById("pageNumbers");
      var prevPageBtn = document.getElementById("prevPage");
      var nextPageBtn = document.getElementById("nextPage");
      var PER_PAGE = 5;
      var currentPage = 1,
        currentItems = [];

      function renderPagination(items) {
        currentItems = items;
        var total = Math.ceil(items.length / PER_PAGE);
        if (pageNumbers) pageNumbers.innerHTML = "";
        if (total <= 1) {
          if (pagination) pagination.classList.add("hidden");
          return;
        }
        if (pagination) pagination.classList.remove("hidden");

        for (var i = 1; i <= total; i++) {
          (function (pageNum) {
            var btn = document.createElement("button");
            btn.textContent = pageNum;
            btn.className = pageNum === currentPage ?
              "px-3 py-1.5 rounded-lg bg-[#8B0000]/10 text-[#8B0000] font-semibold text-sm" :
              "px-3 py-1.5 rounded-lg hover:bg-gray-100 text-gray-600 text-sm";
            btn.onclick = function () {
              currentPage = pageNum;
              updatePage();
            };
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
        var s = (currentPage - 1) * PER_PAGE,
          e = s + PER_PAGE;
        patientContainer.innerHTML = "";

        if (currentItems.length === 0) {
          var isSearching = searchKeyword.trim().length > 0;
          var hasFilters = !!selectedProgram || !!selectedYearLevel || !!selectedSection || !!
            selectedDepartment || !!activeFromDate || !!activeToDate;

          var emptyMessages = {
            today: {
              icon: "fa-calendar-days",
              title: "No appointments today",
              sub: "Enjoy the quiet — nothing scheduled for today."
            },
            upcoming: {
              icon: "fa-hourglass-half",
              title: "No upcoming appointments",
              sub: "New bookings will show up here once confirmed."
            },
            rescheduled: {
              icon: "fa-rotate",
              title: "No rescheduled appointments",
              sub: "Any rescheduled visits will appear here."
            },
            cancelled: {
              icon: "fa-xmark-circle",
              title: "No cancelled appointments",
              sub: "That's great! Nothing has been cancelled."
            },
            completed: {
              icon: "fa-circle-check",
              title: "No completed appointments yet",
              sub: "Completed visits will be recorded here."
            },
            all: {
              icon: "fa-clipboard-list",
              title: "No appointments found",
              sub: "There are no appointments in the system yet."
            }
          };

          var icon, title, sub, extraHtml = "";
          if (isSearching) {
            icon = "fa-magnifying-glass";
            title = 'No results for "' + searchKeyword + '"';
            sub = "Try a different name, ID, or service type.";
            extraHtml =
              '<button onclick="document.getElementById(\'searchInput\').value=\'\'; document.getElementById(\'searchInput\').dispatchEvent(new Event(\'input\'));" class="mt-3 px-4 py-2 rounded-full border border-dashed border-gray-400 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear search</button>';
          } else if (hasFilters) {
            icon = "fa-sliders";
            title = "No matches for your filters";
            sub = "Try removing or adjusting your filter criteria.";
            extraHtml =
              '<button id="clearFiltersInline" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Reset</button>';
          } else {
            var msg = emptyMessages[activeTab] || emptyMessages.all;
            icon = msg.icon;
            title = msg.title;
            sub = msg.sub;
          }

          patientContainer.innerHTML =
            '<div class="col-span-full w-full flex flex-col items-center justify-center py-16 text-center gap-2"><div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-2"><i class="fa-solid ' +
            icon +
            ' text-2xl text-gray-300"></i></div><p class="text-base font-bold text-gray-500">' +
            title + '</p><p class="text-sm text-gray-400 max-w-xs">' + sub + '</p>' + extraHtml +
            '</div>';

          var inlineClear = document.getElementById("clearFiltersInline");
          if (inlineClear) {
            inlineClear.onclick = function () {
              if (externalClearFilterBtn) externalClearFilterBtn.click();
            };
          }

          if (pagination) pagination.classList.add("hidden");
          return;
        }

        if (colHeader) colHeader.style.display = "grid";
        currentItems.slice(s, e).forEach(function (p) {
          patientContainer.appendChild(p);
        });
        renderPagination(currentItems);
      }

      if (prevPageBtn) {
        prevPageBtn.onclick = function () {
          if (currentPage > 1) {
            currentPage--;
            updatePage();
          }
        };
      }
      if (nextPageBtn) {
        nextPageBtn.onclick = function () {
          if (currentPage < Math.ceil(currentItems.length / PER_PAGE)) {
            currentPage++;
            updatePage();
          }
        };
      }

      function applyFilters() {
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
            if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
            if (selectedSection && String(i.section).trim() !== String(selectedSection)
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
          return new Date(getInfo(a).dateStr) - new Date(getInfo(b).dateStr);
        });
        if (dateSort === "desc") data.sort(function (a, b) {
          return new Date(getInfo(b).dateStr) - new Date(getInfo(a).dateStr);
        });

        var rowCountEl = document.getElementById("rowCount");
        if (rowCountEl) {
          rowCountEl.textContent = data.length + " " + (data.length === 1 ? "patient" : "patients");
        }

        currentPage = 1;
        renderPagination(data);
        updatePage();
        updateCounts();
        updateFilterButtonState();
      }

      function computeCount(tab) {
        var data = allPatients.slice();
        if (tab !== "all") data = data.filter(function (p) {
          return p.classList.contains(tab);
        });

        if (selectedProgram) data = data.filter(function (p) {
          return ilike(getInfo(p).program, selectedProgram);
        });
        if (selectedYearLevel || selectedSection) data = data.filter(function (p) {
          var i = getInfo(p);
          if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
          if (selectedSection && String(i.section).trim() !== String(selectedSection).trim())
            return false;
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
        return data.length;
      }

      function updateCounts() {
        Object.keys(countEls).forEach(function (tab) {
          if (countEls[tab]) countEls[tab].textContent = computeCount(tab);
        });
      }

      syncMutualExclusion();
      document.querySelectorAll('.filter-btn').forEach(function (b) {
        b.classList.remove('tab-active');
      });
      var todayBtn = document.querySelector('.filter-btn[data-filter="today"]');
      if (todayBtn) todayBtn.classList.add('tab-active');
      applyFilters();

    } catch (err) {
      console.error("Initialization Error:", err);
    }
  });
</script>
@endsection