@extends('layouts.dentist')

@section('title', 'Appointments | PUP Taguig Dental Clinic')

@section('usesAppointmentCalendar', true)

@section('styles')
<style>
  .summary-bar {
    background: linear-gradient(135deg, #8B0000 0%, #660000 100%);
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
    overflow: visible;
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

  .service-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 500;
    padding: 4px 8px;
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

  .mode-list .desktop-appointments-table>.grid,
  .mode-list .desktop-appointments-table .appt-card {
    min-width: 1000px !important;
  }

  .time-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #F5F0EB;
    border: 1px solid #E8E0D8;
    border-radius: 7px;
    padding: 4px 8px;
    font-size: 12px;
    font-weight: 500;
    color: #6B5E52;
  }

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

  .action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 34px;
    padding: 0 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    transition: all .18s ease;
    white-space: nowrap;
  }

  .action-btn i {
    font-size: 12px;
    flex-shrink: 0;
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

  .toast-item.toast-success {
    background: #0f172a;
    border: 1px solid rgba(16, 185, 129, .22);
    box-shadow: 0 12px 34px rgba(15, 23, 42, .32);
  }

  .toast-item.toast-success .toast-icon-wrap {
    background: rgba(16, 185, 129, .14);
    border-color: rgba(16, 185, 129, .26);
  }

  .toast-item.toast-success .toast-progress {
    background: linear-gradient(90deg, #10b981, #34d399);
  }

  .toast-item.toast-success .toast-title {
    color: #f8fafc;
  }

  .toast-item.toast-success .toast-message {
    color: #cbd5e1;
  }

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

  @media (min-width: 768px) {
    .desktop-appointments-table {
      display: block !important;
    }

    .mobile-appointments-list {
      display: none !important;
    }
  }

  .view-toggle-container {
    background: #ffffff;
    border-radius: 14px;
    padding: 4px;
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
    transform: translateX(40px);
  }

  .btn-view-mode {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9CA3AF;
    transition: color 0.3s ease;
    border: none;
    background: transparent !important;
    cursor: pointer;
    position: relative;
    z-index: 2;
  }

  .btn-view-mode:hover:not(.active) {
    color: #8B0000;
  }

  .btn-view-mode.active {
    color: #ffffff !important;
    background: transparent !important;
    box-shadow: none !important;
  }

  .mode-list .desktop-appointments-table {
    display: block !important;
    overflow: visible;
    padding-bottom: 8px;
  }

  .mode-list .desktop-appointments-table>.grid,
  .mode-list .desktop-appointments-table .appt-card {
    min-width: 0 !important;
  }

  .mode-list .desktop-appointments-table .appt-card {
    border-radius: 16px;
    border: 1px solid #eee4dd;
    box-shadow: none;
  }

  .mode-list .desktop-appointments-table .appt-card:hover {
    border-color: rgba(139, 0, 0, .18);
    box-shadow: 0 8px 20px rgba(139, 0, 0, .05);
  }

  .mode-list .desktop-appointments-table .appt-card .grid {
    min-height: 72px;
  }

  .mode-list .desktop-appointments-table .service-badge {
    min-height: 32px;
    padding: 6px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 700;
    line-height: 1.1;
    white-space: nowrap;
  }

  .mode-list .desktop-appointments-table .time-chip {
    min-height: 32px;
    padding: 6px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
  }

  .mode-list .desktop-appointments-table .status-pill {
    min-height: 30px;
    padding: 6px 10px;
    border-radius: 9999px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
  }

  .mode-list .desktop-appointments-table .action-btn {
    width: 34px;
    min-width: 34px;
    height: 34px;
    min-height: 34px;
    padding: 0;
    border-radius: 10px;
    font-size: 0;
  }

  .mode-list .desktop-appointments-table .action-btn i {
    font-size: 12px;
    margin: 0;
  }

  .mode-list .desktop-appointments-table .appt-patient-name {
    max-width: 220px;
  }

  .mode-list .desktop-appointments-table .appt-program-pill {
    display: inline-block;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .mode-list .desktop-appointments-table .appt-actions-wrap {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    width: 100%;
    flex-wrap: nowrap;
  }

  .appt-actions-wrap {
    position: relative;
    z-index: 40;
  }

  .action-tooltip {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999999;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity .14s ease, visibility .14s ease;
  }

  .action-tooltip.show {
    opacity: 1;
    visibility: visible;
  }

  .action-tooltip-bubble {
    position: relative;
    display: inline-flex;
    align-items: center;
    min-height: 34px;
    padding: 0 10px;
    border-radius: 8px;
    background: #111827;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .18);
  }

  .action-tooltip-bubble::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 100%;
    transform: translateY(-50%);
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent transparent #111827;
  }

  .mode-list .desktop-appointments-table .appt-patient-cell,
  .mode-list .desktop-appointments-table .appt-service-cell,
  .mode-list .desktop-appointments-table .appt-program-cell,
  .mode-list .desktop-appointments-table .appt-status-cell {
    min-width: 0;
  }

  .mode-list .desktop-appointments-table .appt-table-head {
    position: sticky;
    top: 0;
    z-index: 2;
    background: #fafafa;
  }

  .mode-list .desktop-appointments-table .appt-row-date {
    line-height: 1.15;
  }

  .mode-list .desktop-appointments-table .appt-row-date .date-main {
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
  }

  .mode-list .desktop-appointments-table .appt-row-date .date-sub {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
  }

  .mode-list .mobile-appointments-list {
    display: none !important;
  }

  .mode-grid .desktop-appointments-table {
    display: none !important;
  }

  .mode-grid .mobile-appointments-list {
    display: grid !important;
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  @media (min-width: 640px) {
    .mode-grid .mobile-appointments-list {
      grid-template-columns: repeat(2, 1fr) !important;
    }
  }

  @media (min-width: 1024px) {
    .mode-grid .mobile-appointments-list {
      grid-template-columns: repeat(3, 1fr) !important;
    }
  }

  @media (max-width: 767px) {

    .action-btn {
      width: 100%;
      min-height: 44px;
      padding: 10px 14px;
      font-size: 12.5px;
      border-radius: 12px;
    }

    .action-btn i {
      font-size: 12px;
    }

    .mobile-appt-card {
      padding: 1.1rem;
    }

    .mobile-appt-card .grid.grid-cols-2.gap-2.pl-1 {
      gap: 0.75rem;
      padding-left: 0;
    }

    .view-toggle-container {
      display: none !important;
    }

    .mode-list .desktop-appointments-table,
    .mode-grid .desktop-appointments-table {
      display: none !important;
    }

    .mode-list .mobile-appointments-list,
    .mode-grid .mobile-appointments-list {
      display: flex !important;
      flex-direction: column !important;
      width: 100% !important;
    }

    .mobile-appt-card {
      width: 100% !important;
      box-sizing: border-box;
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

  .reschedule-modal-panel {
    animation: modalUp .3s cubic-bezier(.34, 1.56, .64, 1) forwards;
  }

  .reschedule-icon-ring {
    position: relative;
    width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .reschedule-icon-ring::before,
  .reschedule-icon-ring::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid rgba(245, 158, 11, .35);
    animation: ringPulse 2s ease-out infinite;
  }

  .reschedule-icon-ring::after {
    animation-delay: .7s;
  }

  .reschedule-icon-core {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 2px solid #fcd34d;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(245, 158, 11, .18);
    z-index: 1;
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
$nextName = $nextAppt ? optional($nextAppt->patient)->name ?? 'Unknown' : null;
$nextTime = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_time)->format('g:i A') : null;
$nextDate = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M j') : null;
$upcomingGrouped = $upcomingAppointments->groupBy(
fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'),
);
$pastGrouped = $pastAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
$upcomingTotal = $upcomingAppointments->count();
$pastTotal = $pastAppointments->count();
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp


<main id="mainContent" class="pt-[90px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
  <div class="w-full fade-in">

    <div
      class="summary-bar rounded-2xl px-4 sm:px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 flex-wrap mb-5 mt-2 shadow-sm">
      <div class="flex items-center gap-2">
        <i class="fa-solid fa-circle-info text-white/80 text-sm"></i>
        <span class="text-white/90 text-[13px] font-semibold">Today's snapshot:</span>
      </div>

      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2.5 w-full sm:w-auto">
        @if ($todayCount > 0)
        <span class="summary-chip summary-chip-highlight w-full sm:w-auto justify-center sm:justify-start">
          <i class="fa-solid fa-calendar-check text-xs"></i>{{ $todayCount }}
          appt{{ $todayCount > 1 ? 's' : '' }} today
        </span>
        @else
        <span class="summary-chip w-full sm:w-auto justify-center sm:justify-start">
          <i class="fa-regular fa-calendar text-xs"></i>No appointments today
        </span>
        @endif

        @if ($nextAppt)
        <span class="summary-chip w-full sm:w-auto justify-center sm:justify-start">
          <i class="fa-solid fa-clock text-xs text-white/70"></i>
          <span>Next: <strong>{{ $nextName }}</strong> <span class="opacity-75">—
              {{ $nextTime }}</span></span>
        </span>
        @endif
      </div>
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

      <div class="flex items-center gap-3 self-start md:self-auto flex-shrink-0">

        <div class="view-toggle-container hidden md:flex">
          <div class="view-slider"></div>

          <button id="btnListView" onclick="switchView('list')" class="btn-view-mode active" title="List View">
            <i class="fa-solid fa-list text-sm"></i></button>
          <button id="btnGridView" onclick="switchView('grid')" class="btn-view-mode" title="Grid View"><i
              class="fa-solid fa-border-all text-sm"></i></button>
        </div>

        <div class="tab-toggle-wrap">
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

          <div
            class="appt-table-head grid gap-4 text-[10px] font-bold uppercase tracking-[0.14em] text-gray-500 py-3 px-5 bg-[#FAFAFA] border border-gray-200 rounded-t-2xl mb-3"
            style="grid-template-columns: 130px 100px 160px minmax(160px,1fr) 100px 100px 150px;">
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</div>
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time
            </div>
            <div class="appt-program-cell text-left">Service</div>
            <div class="appt-program-cell text-left">Patient</div>
            <div class="appt-program-cell text-left">Program</div>
            <div class="appt-program-cell text-left">Status</div>
            <div class="text-right">Actions</div>
          </div>

          <div class="space-y-2.5">
            @foreach ($items as $i => $appt)
            @php
            $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
            $program = optional($appt->patient)->program ?? '—';
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
            @endphp

            <div class="appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
              style="animation-delay:{{ $i * 0.04 }}s">

              <div class="rounded-[14px] grid gap-4 items-center px-5 py-3.5"
                style="grid-template-columns: 140px 110px 170px minmax(180px,1.2fr) 110px 110px 160px;">

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

                <div><span class="time-chip"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}</span>
                </div>

                <div class="appt-service-cell flex items-center justify-start"><span
                    class="service-badge {{ $badgeClass }}">{{ $serviceLabel }}</span>
                </div>

                <div class="appt-patient-cell flex items-center justify-start gap-3">
                  <img
                    src="{{ optional($appt->patient)->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patientName) . '&background=8B0000&color=ffffff&bold=true' }}"
                    alt="{{ $patientName }}"
                    class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                  <div class="text-left min-w-0">
                    <p class="appt-patient-name text-[13px] font-bold text-gray-800 leading-tight truncate">
                      {{ $patientName }}</p>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">ID
                      #{{ $appt->patient_id ?? 'N/A' }}</p>
                  </div>
                </div>

                <div class="appt-program-cell text-left">
                  @if ($program === '—')
                  <span class="text-[12px] text-gray-400">—</span>
                  @else
                  <span
                    class="appt-program-pill inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2 py-1 rounded-full border border-gray-200 truncate">
                    {{ $program }}
                  </span>
                  @endif
                </div>

                <div class="appt-status-cell text-left">
                  @if ($isToday)
                  <span class="status-pill status-confirmed"><span class="status-dot"></span>Confirmed</span>
                  @else
                  <span class="status-pill status-pending"><span class="status-dot"></span>Upcoming</span>
                  @endif
                </div>

                <div class="appt-actions-wrap">
                  <a href="{{ route('dentist.dentist.patient.profile', $appt->patient_id) }}?from=appointments"
                    class="action-btn action-btn-view" data-tooltip="View patient">
                    <i class="fa-regular fa-user"></i>
                  </a>

                  <button type="button" class="action-btn action-btn-start" data-tooltip="Start procedure"
                    onclick="openStartProcedureModal(this)" data-id="{{ $appt->id }}" data-name="{{ $patientName }}"
                    data-datetime="{{ $modalDatetime }}" {{ $isToday ? '' : 'disabled' }}>
                    <i class="fa-solid fa-play"></i>
                  </button>

                  <button type="button" class="action-btn action-btn-reschedule" data-tooltip="Reschedule" onclick="openRescheduleModal({
      id: '{{ $appt->id }}',
      name: @js($patientName),
      datetime: @js($modalDatetime),
      serviceType: @js($appt->service_type),
      updateUrl: '{{ route('dentist.dentist.appointments.reschedule.update', $appt->id) }}'
    })">
                    <i class="fa-solid fa-rotate-right"></i>
                  </button>

                  <button type="button" class="action-btn action-btn-cancel" data-tooltip="Cancel appointment"
                    onclick="cancelAppointmentFromModal('{{ route('dentist.dentist.appointments.cancel', $appt->id) }}', @js($patientName), @js($dateLabel . ' | ' . $timeLabel))">
                    <i class="fa-solid fa-xmark"></i>
                  </button>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- ── MOBILE CARD VIEW ── -->
        <div class="mobile-appointments-list">
          @foreach ($items as $i => $appt)
          @php
          $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
          $program = optional($appt->patient)->program ?? '—';
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
          @endphp

          <div class="mobile-appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}"
            style="animation-delay:{{ $i * 0.04 }}s">

            <div class="flex items-start justify-between gap-2 mb-4 pl-1">
              <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                  <p class="text-[15px] font-extrabold text-gray-800 truncate">
                    {{ $patientName }}</p>
                  @if ($isToday)
                  <span
                    class="text-[9px] font-bold uppercase tracking-wide bg-green-500 text-white px-2 py-0.5 rounded-md">Today</span>
                  @endif
                </div>
                <p class="text-[11px] font-medium text-gray-500">{{ $weekday }},
                  {{ $dateLabel }}</p>
              </div>
              @if ($isToday)
              <span class="status-pill status-confirmed flex-shrink-0"><span class="status-dot"></span>Confirmed</span>
              @else
              <span class="status-pill status-pending flex-shrink-0"><span class="status-dot"></span>Upcoming</span>
              @endif
            </div>

            <div class="bg-gray-50 rounded-xl p-3 mb-4 grid grid-cols-2 gap-3 border border-gray-100 ml-1">
              <div>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">
                  Schedule Time</p>
                <span class="time-chip text-[11px] bg-white w-full justify-center shadow-sm py-1.5 border-gray-200">
                  <i class="fa-regular fa-clock text-[#8B0000]"></i> {{ $timeLabel }}
                </span>
              </div>
              <div>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">
                  Service Type</p>
                <span
                  class="service-badge {{ $badgeClass }} text-[11px] w-full justify-center py-1.5 truncate shadow-sm border border-gray-100/50">
                  {{ $serviceLabel }}
                </span>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <button type="button" class="action-btn action-btn-start" onclick="openStartProcedureModal(this)"
                data-id="{{ $appt->id }}" data-name="{{ $patientName }}" data-datetime="{{ $modalDatetime }}" {{
                $isToday ? '' : 'disabled' }}>
                <i class="fa-solid fa-play text-[10px]"></i> Start
              </button>

              <a href="{{ route('dentist.dentist.patient.profile', $appt->patient_id) }}?from=appointments"
                class="action-btn action-btn-view">
                <i class="fa-regular fa-user text-[10px]"></i> View
              </a>

              <button type="button" class="action-btn action-btn-reschedule" onclick="openRescheduleModal({
                    id: '{{ $appt->id }}',
                    name: @js($patientName),
                    datetime: @js($modalDatetime),
                    serviceType: @js($appt->service_type),
                    updateUrl: '{{ route('dentist.dentist.appointments.reschedule.update', $appt->id) }}'
                })" data-id="{{ $appt->id }}" data-name="{{ $patientName }}" data-datetime="{{ $modalDatetime }}">
                <i class="fa-solid fa-rotate-right text-[10px]"></i> Reschedule
              </button>

              <button type="button" class="action-btn action-btn-cancel"
                onclick="cancelAppointmentFromModal('{{ route('dentist.dentist.appointments.cancel', $appt->id) }}', @js($patientName), @js($dateLabel . ' | ' . $timeLabel))">
                <i class="fa-solid fa-xmark text-[10px]"></i> Cancel
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

          <div
            class="appt-table-head grid gap-4 text-[10px] font-bold uppercase tracking-[0.14em] text-gray-400 py-3 px-5 bg-[#FAFAFA] border border-gray-200 rounded-t-2xl mb-3"
            style="grid-template-columns: 140px 110px 170px minmax(180px,1.2fr) 110px;">
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</div>
            <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time
            </div>
            <div class="appt-program-cell text-left">Service</div>
            <div class="appt-program-cell text-left">Patient</div>
            <div class="appt-program-cell text-left">Program</div>
          </div>

          <div class="space-y-2.5">
            @foreach ($items as $i => $appt)
            @php
            $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
            $program = optional($appt->patient)->program ?? '—';
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
            @endphp

            <div class="appt-card opacity-70" style="animation-delay:{{ $i * 0.04 }}s">

              <div class="grid gap-4 items-center px-5 py-3.5"
                style="grid-template-columns: 140px 110px 170px minmax(180px,1.2fr) 110px;">

                <div>
                  <p class="text-[13px] font-semibold text-gray-500">{{ $dateLabel }}</p>
                  <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                </div>

                <div><span class="time-chip text-gray-400"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel
                    }}</span>
                </div>

                <div class="flex items-center justify-start"><span class="service-badge {{ $badgeClass }} opacity-70">{{
                    $serviceLabel }}</span>
                </div>

                <div class="appt-patient-cell flex items-center justify-start gap-3">
                  <img
                    src="{{ optional($appt->patient)->profile_image ? asset('storage/' . $appt->patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patientName) . '&background=9ca3af&color=ffffff&bold=true' }}"
                    alt="{{ $patientName }}"
                    class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0 opacity-80">
                  <div class="text-left min-w-0">
                    <p class="text-[13px] font-bold text-gray-500 leading-tight truncate max-w-[140px]">
                      {{ $patientName }}</p>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">ID
                      #{{ $appt->patient_id ?? 'N/A' }}</p>
                  </div>
                </div>

                <div class="appt-program-cell text-left">
                  @if ($program === '—')
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

        <div class="mobile-appointments-list">
          @foreach ($items as $i => $appt)
          @php
          $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
          $program = optional($appt->patient)->program ?? '—';
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
          @endphp

          <div class="mobile-appt-card opacity-75 border-gray-200" style="animation-delay:{{ $i * 0.04 }}s">
            <div class="pl-1">
              <p class="text-[14px] font-extrabold text-gray-500">{{ $patientName }}</p>
              <p class="text-[11px] font-medium text-gray-400 mt-0.5 mb-3">{{ $weekday }},
                {{ $dateLabel }}</p>

              <div class="bg-gray-50 rounded-xl p-2.5 grid grid-cols-2 gap-2 border border-gray-100">
                <span
                  class="time-chip text-[11px] text-gray-400 bg-white w-full justify-center shadow-sm py-1.5 border-gray-100">
                  <i class="fa-regular fa-clock"></i> {{ $timeLabel }}
                </span>
                <span
                  class="service-badge {{ $badgeClass }} opacity-70 text-[11px] w-full justify-center py-1.5 truncate border border-gray-100/50">
                  {{ $serviceLabel }}
                </span>
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

<div id="actionTooltip" class="action-tooltip">
  <div class="action-tooltip-bubble" id="actionTooltipText"></div>
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
      <p class="text-xs sm:text-sm text-gray-500 mb-5 text-center">This will mark the appointment as in progress.
      </p>
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
@endsection

@section('scripts')
<script>
  document.getElementById("currentDate").textContent = new Date().toLocaleDateString("en-US", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
  });

  document.getElementById('btnUpcoming')?.addEventListener('click', () => setActiveTab('upcoming'));
  document.getElementById('btnPast')?.addEventListener('click', () => setActiveTab('past'));

  function setActiveTab(tab) {
    const isUpcoming = tab === 'upcoming';
    document.getElementById('upcomingSection')?.classList.toggle('hidden', !isUpcoming);
    document.getElementById('pastSection')?.classList.toggle('hidden', isUpcoming);
    document.getElementById('btnUpcoming')?.classList.toggle('active', isUpcoming);
    document.getElementById('btnPast')?.classList.toggle('active', !isUpcoming);
  }

  function showToast({
    title = '',
    message = '',
    duration = 4000,
    type = 'success'
  }) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');

    const isSuccess = type === 'success';

    toast.className = `toast-item ${isSuccess ? 'toast-success' : ''}`;

    toast.innerHTML = `
    <div class="toast-icon-wrap">
      <i class="fa-solid ${isSuccess ? 'fa-circle-check text-emerald-400' : 'fa-circle-exclamation text-red-400'} text-sm"></i>
    </div>
    <div class="flex-1 min-w-0">
      <div class="toast-title">${title}</div>
      ${message ? `<div class="toast-message">${message}</div>` : ''}
    </div>
    <button class="toast-close" onclick="dismissToast(this.closest('.toast-item'))">
      <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="toast-progress" style="animation-duration:${duration}ms;"></div>
  `;

    container.appendChild(toast);
    setTimeout(() => dismissToast(toast), duration);
  }

  function dismissToast(toast) {
    if (!toast || toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => toast.remove(), 350);
  }

  function switchView(mode) {
    const mainContent = document.getElementById('mainContent');
    const btnList = document.getElementById('btnListView');
    const btnGrid = document.getElementById('btnGridView');

    if (mode === 'grid') {
      mainContent.classList.remove('mode-list');
      mainContent.classList.add('mode-grid');
      btnList.classList.remove('active');
      btnGrid.classList.add('active');
      localStorage.setItem('apptViewMode', 'grid');
    } else {
      mainContent.classList.remove('mode-grid');
      mainContent.classList.add('mode-list');
      btnGrid.classList.remove('active');
      btnList.classList.add('active');
      localStorage.setItem('apptViewMode', 'list');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    if (window.innerWidth <= 767) {
      switchView('grid');
    } else {
      const savedMode = localStorage.getItem('apptViewMode') || 'list';
      switchView(savedMode);
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth <= 767) {
      switchView('grid');
    }
  });

  function initActionTooltips() {
    const tooltip = document.getElementById('actionTooltip');
    const tooltipText = document.getElementById('actionTooltipText');

    if (!tooltip || !tooltipText) return;

    const targets = document.querySelectorAll('.appt-actions-wrap [data-tooltip]');

    const showTooltip = (el) => {
      if (el.disabled) return;

      tooltipText.textContent = el.dataset.tooltip || '';
      tooltip.classList.add('show');

      requestAnimationFrame(() => {
        const rect = el.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();

        const top = rect.top + (rect.height / 2) - (tooltipRect.height / 2);
        const left = rect.left - tooltipRect.width - 12;

        tooltip.style.top = `${Math.max(8, top)}px`;
        tooltip.style.left = `${Math.max(8, left)}px`;
      });
    };

    const hideTooltip = () => {
      tooltip.classList.remove('show');
    };

    targets.forEach((el) => {
      el.addEventListener('mouseenter', () => showTooltip(el));
      el.addEventListener('mouseleave', hideTooltip);
      el.addEventListener('focus', () => showTooltip(el));
      el.addEventListener('blur', hideTooltip);
    });

    window.addEventListener('scroll', hideTooltip, true);
    window.addEventListener('resize', hideTooltip);
  }

  document.addEventListener('DOMContentLoaded', () => {
    initActionTooltips();
  });

  var selectedApptId = null;

  function openStartProcedureModal(btn) {
    selectedApptId = btn.dataset.id;
    document.getElementById('startPatientName').textContent = btn.dataset.name || '—';
    document.getElementById('startAppointmentDate').textContent = btn.dataset.datetime || '—';
    document.getElementById('startProcedureModal').classList.remove('hidden');
  }

  function closeStartProcedureModal() {
    document.getElementById('startProcedureModal').classList.add('hidden');
    selectedApptId = null;
  }

  function confirmStartProcedure() {
    window.location.href = `/dentist/appointments/${selectedApptId}/start`;
  }
</script>
@endsection