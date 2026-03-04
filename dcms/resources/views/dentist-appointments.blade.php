<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Appointments | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter'; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(6px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }

    .sidebar-link{
      display:flex; align-items:center; width:100%;
      padding:12px; border-radius:12px;
      transition: background-color .2s ease, transform .2s ease;
    }

    .sidebar-link:hover .sidebar-tooltip{
      opacity:1; transform:scale(1);
    }

    /* Hide tooltip when expanded */
    #sidebar[style*="16rem"] .sidebar-tooltip { display: none; }
    #sidebar[style*="16rem"] .sidebar-link { justify-content: flex-start; }

    /* consistent icon column width */
    .sidebar-link i {
      width: 24px;
      min-width: 24px;
      text-align: center;
    }

    /* CLOSED: center icon only */
    #sidebar[style*="72px"] .sidebar-link { justify-content:center; gap:0; }

    /* when expanded, align items nicely */
    #sidebar[style*="16rem"] .sidebar-link { justify-content: flex-start; gap: 12px; }
    #sidebar[style*="16rem"] .sidebar-link:hover { transform: translateX(4px); }

    .sidebar-link:hover .sidebar-text { opacity: 1; transform: scale(1); }
    .sidebar-text { transform-origin: left center; }

    /* Notification dropdown animation */
    .notif-open{
      opacity:1 !important;
      transform:scale(1) !important;
      pointer-events:auto !important;
    }

    .notif-close {
      opacity: 0 !important;
      transform: scale(0.95) !important;
      pointer-events: none !important;
    }

    /* DARK MODE */
    [data-theme="dark"] body {
      background-color: #111827;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar { background-color: #1F2933; }
    [data-theme="dark"] .bg-white { background-color: #1F2937 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color: #E5E7EB !important; }

    body, #sidebar, main, .card {
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* ── IMPROVED APPOINTMENT CARD STYLES ── */
    @keyframes slideIn {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .appt-card {
      background: #ffffff;
      border: 1px solid #E8E0D8;
      border-radius: 14px;
      position: relative;
      overflow: hidden;
      transition: box-shadow 0.2s, border-color 0.2s, transform 0.15s;
      animation: slideIn 0.3s ease both;
    }
    .appt-card:hover {
      border-color: rgba(139,0,0,0.2);
      box-shadow: 0 4px 20px rgba(139,0,0,0.08);
      transform: translateX(2px);
    }
    .appt-card::before {
      content: '';
      position: absolute; left: 0; top: 0; bottom: 0;
      width: 4px;
      background: #8B0000;
      border-radius: 14px 0 0 14px;
      opacity: 0;
      transition: opacity 0.2s;
    }
    .appt-card:hover::before { opacity: 1; }

    .service-badge {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 12px; font-weight: 500;
      padding: 3px 10px; border-radius: 6px;
      width: fit-content;
    }
    .service-badge-default { background: #f9f0f0; color: #8B0000; }
    .service-badge-surgery  { background: #fff0f0; color: #C41E3A; }
    .service-badge-checkup  { background: #ebf5ee; color: #2D7A5E; }
    .service-badge-whitening{ background: #fff3e0; color: #B86C00; }
    .service-badge-extraction{ background: #fff0e8; color: #B85000; }

    .status-pill {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 11px; font-weight: 500;
      padding: 4px 10px; border-radius: 20px;
    }
    .status-confirmed { background: #ebf5ee; color: #2D7A5E; }
    .status-pending   { background: #fff3e0; color: #B86C00; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink:0; }

    .time-chip {
      display: inline-flex; align-items: center; gap: 5px;
      background: #F5F0EB; border: 1px solid #E8E0D8;
      border-radius: 7px; padding: 5px 10px;
      font-size: 13px; font-weight: 500; color: #6B5E52;
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal min-h-screen flex flex-col">

  <!-- ═══════════════════════════════════════════════
       HEADER (TOP BAR) — UNCHANGED
  ════════════════════════════════════════════════ -->
  <div class="fixed top-0 left-0 right-0 z-50
            bg-gradient-to-r from-[#660000] to-[#8B0000]
            text-[#F4F4F4] px-6 py-4
            flex items-center justify-between">

    <div class="flex items-center gap-3">
      <div class="w-12 rounded-full ml-5">
        <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" />
      </div>
      <div class="w-12 rounded-full">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
      </div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </div>

    <div class="flex items-center gap-8">
      @php
        $notifications = collect($notifications ?? []);
        $notifCount = $notifications->count();
      @endphp

      <div id="notifDropdown" class="relative">
        <button id="notifBtn" type="button" class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">
          @if($notifCount > 0)
            <span class="indicator-item badge badge-secondary text-s text-[#F4F4F4] bg-[#660000] border-none">
              {{ $notifCount }}
            </span>
          @endif
          <i class="fa-regular fa-bell text-lg"></i>
        </button>

        <div id="notifMenu"
          class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100 z-50
                 opacity-0 scale-95 pointer-events-none
                 transition-all duration-200 ease-out origin-top-right">

          <div class="p-4 border-b flex items-center justify-between">
            <span class="font-bold text-[#8B0000]">Notifications</span>
          </div>

          <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $n)
              <a href="{{ $n['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
                <div class="text-sm font-semibold text-gray-900">
                  {{ $n['title'] ?? 'Notification' }}
                </div>
                @if(!empty($n['message']))
                  <div class="text-xs text-[#ADADAD] mt-0.5">{{ $n['message'] }}</div>
                @endif
                @if(!empty($n['time']))
                  <div class="text-[11px] text-gray-400 mt-1">{{ $n['time'] }}</div>
                @endif
              </a>
            @empty
              <div class="px-4 py-10 text-center justify-items-center">
                <img src="{{ asset('images/no-notifications.png') }}" alt="No Notification">
                <div class="text-sm font-semibold text-gray-800">No notifications</div>
                <div class="text-xs text-[#757575] mt-1">You're all caught up.</div>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10" alt="Profile">
        <div>
          <p class="text-l font-semibold text-[#F4F4F4]">Dr. Nelson Angeles</p>
          <p class="italic text-xs text-[#F4F4F4]/80">Dentist</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════
       SIDEBAR — UNCHANGED
  ════════════════════════════════════════════════ -->
  <aside id="sidebar"
    class="fixed left-0 top-[80px]
           h-[calc(100vh-80px)]
           w-[72px]
           bg-[#FAFAFA]
           drop-shadow-xl
           transition-all duration-300
           flex flex-col justify-between z-40">

    <div>
      <div id="sidebarToggleWrapper"
        class="flex items-center justify-center px-4 py-6 transition-all duration-300">
        <button onclick="toggleSidebar()"
          id="sidebarToggleBtn"
          class="w-10 h-10 flex items-center justify-center
                 rounded-full text-[#757575] hover:text-[#8B0000]
                 hover:bg-[#D9D9D9] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
        </button>
      </div>

      <nav class="space-y-2 px-3 text-gray-600 text-sm">

        <a href="{{ route('dentist.dashboard') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.dashboard') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300 {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-chart-line text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dashboard</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                pointer-events-none transition-all duration-200">Dashboard</span>
        </a>

        <a href="{{ route('dentist.patients') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.patients*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300 {{ request()->routeIs('dentist.patients*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-users text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Patients</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                pointer-events-none transition-all duration-200">Patients</span>
        </a>

        <a href="{{ route('dentist.appointments') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.appointments*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300 {{ request()->routeIs('dentist.appointments*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-calendar-check text-lg"></i>
          <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Appointments</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                pointer-events-none transition-all duration-200">Appointments</span>
        </a>

        <a href="{{ route('dentist.documentrequests') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.documentrequests*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300 {{ request()->routeIs('dentist.documentrequests*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-file-circle-check text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Document Requests</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                pointer-events-none transition-all duration-200">Document Requests</span>
        </a>

        <a href="{{ route('dentist.inventory') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.inventory*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300 {{ request()->routeIs('dentist.inventory*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-box text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Inventory</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                pointer-events-none transition-all duration-200">Inventory</span>
        </a>

        <a href="{{ route('dentist.report') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.report*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300 {{ request()->routeIs('dentist.report*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-file text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Reports</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                pointer-events-none transition-all duration-200">Reports</span>
        </a>

      </nav>
    </div>

    <div class="px-3 pb-5 space-y-2">
      <button
        id="themeToggle"
        class="sidebar-link relative flex items-center justify-center
               w-full px-2 py-1.5 rounded-xl
               bg-[#7B6CF6] text-[#F4F4F4]
               transition-all duration-200
               hover:scale-105"
        aria-label="Toggle dark mode">
        <i id="themeIcon" class="fa-regular fa-moon text-sm"></i>
        <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dark Mode</span>
        <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
            text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Dark Mode
        </span>
      </button>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm
               text-red-600 hover:bg-red-50 transition-all duration-200">
          <i class="fa-solid fa-right-from-bracket text-sm"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Log out
          </span>
        </button>
      </form>
    </div>
  </aside>

  @php
    $upcomingAppointments = $upcomingAppointments ?? collect();
    $pastAppointments     = $pastAppointments ?? collect();
    $today                = $today ?? \Carbon\Carbon::today()->toDateString();

    $upcomingGrouped = $upcomingAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
    $pastGrouped     = $pastAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
  @endphp

  <!-- ═══════════════════════════════════════════════
       MAIN CONTENT — IMPROVED
  ════════════════════════════════════════════════ -->
  <main
    id="mainContent"
    class="flex-1 pt-[100px] px-6 pb-0 w-full transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

    <div class="max-w-7xl mt-4 mx-auto fade-in">

      <!-- Page title row -->
      <div class="flex items-end justify-between mt-8 mb-6 px-1">
        <div>
          <h1 class="text-2xl font-bold text-[#1A0F0F]">Appointments</h1>
          <p class="text-sm text-gray-400 mt-0.5">
            {{ now()->format('l, F j, Y') }}
          </p>
        </div>

        <!-- Tab toggle — same look, just repositioned inline -->
        <div class="flex bg-[#7a0000] rounded-full p-1.5 shadow-md gap-1">
          <button id="btnUpcoming"
            class="px-6 py-2 rounded-full bg-[#8b0000] text-white text-sm font-semibold transition-all duration-200">
            Upcoming Appointments
          </button>
          <button id="btnPast"
            class="px-6 py-2 rounded-full text-white/80 text-sm font-semibold transition-all duration-200">
            Past Appointments
          </button>
        </div>
      </div>

      <!-- ═══════ UPCOMING SECTION ═══════ -->
      <section id="upcomingSection" class="pb-14">

        @forelse($upcomingGrouped as $month => $items)
          <div class="relative pl-10 mb-14">
            <!-- Timeline line -->
            <div class="absolute left-[6px] top-[6px] w-[2px] h-full bg-[#8b0000]/20"></div>
            <!-- Timeline dot -->
            <div class="absolute left-0 top-[4px] w-3 h-3 bg-[#8b0000] rounded-full shadow-[0_0_0_3px_rgba(139,0,0,0.15)]"></div>

            <!-- Month heading -->
            <div class="flex items-center gap-3 mb-5">
              <h2 class="text-xl font-bold text-[#8b0000]">{{ $month }}</h2>
              <span class="bg-[#f9f0f0] text-[#8b0000] text-xs font-semibold px-3 py-1 rounded-full border border-[#8b0000]/10">
                {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
              </span>
            </div>

            <!-- Column headers -->
            <div class="grid grid-cols-[1.6fr_1.1fr_1.8fr_1.8fr_1.1fr_1fr_1.5fr]
              text-[11px] font-semibold uppercase tracking-wider text-gray-400
              pb-2 border-b border-gray-200 mb-3 px-5">
              <span>Date</span>
              <span>Time</span>
              <span>Service</span>
              <span>Patient</span>
              <span>Program</span>
              <span>Status</span>
              <span class="text-right">Actions</span>
            </div>

            <!-- Cards -->
            <div class="space-y-3">
              @foreach($items as $i => $appt)
                @php
                  $patientName  = optional($appt->patient)->name ?? 'Unknown Patient';
                  $program      = optional($appt->patient)->program ?? '—';
                  $dateLabel    = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
                  $weekday      = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
                  $timeLabel    = $appt->appointment_time
                                    ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A')
                                    : '—';
                  $serviceLabel = ($appt->service_type ?? '') === 'Others'
                                    ? (($appt->other_services ?? '') ?: 'Others')
                                    : ($appt->service_type ?? '—');
                  $isToday      = ($appt->appointment_date ?? null) === $today;

                  // Color-code the service badge
                  $serviceLower = strtolower($serviceLabel);
                  $badgeClass = 'service-badge-default';
                  if (str_contains($serviceLower, 'surgery'))    $badgeClass = 'service-badge-surgery';
                  elseif (str_contains($serviceLower, 'check'))  $badgeClass = 'service-badge-checkup';
                  elseif (str_contains($serviceLower, 'whiten')) $badgeClass = 'service-badge-whitening';
                  elseif (str_contains($serviceLower, 'extrac')) $badgeClass = 'service-badge-extraction';
                @endphp

                <div class="appt-card" style="animation-delay: {{ $i * 0.04 }}s">
                  <div class="grid grid-cols-[1.6fr_1.1fr_1.8fr_1.8fr_1.1fr_1fr_1.5fr]
                    items-center px-5 py-4 gap-2">

                    <!-- Date -->
                    <div>
                      <p class="text-[13px] font-semibold text-gray-800">{{ $dateLabel }}</p>
                      <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                      @if($isToday)
                        <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wide
                          bg-green-400 text-white px-2 py-0.5 rounded-md">Today</span>
                      @endif
                    </div>

                    <!-- Time -->
                    <div>
                      <span class="time-chip">
                        <i class="fa-regular fa-clock text-xs"></i>
                        {{ $timeLabel }}
                      </span>
                    </div>

                    <!-- Service -->
                    <div>
                      <span class="service-badge {{ $badgeClass }}">
                        {{ $serviceLabel }}
                      </span>
                    </div>

                    <!-- Patient -->
                    <div>
                      <p class="text-[13px] font-semibold text-gray-800">{{ $patientName }}</p>
                    </div>

                    <!-- Program -->
                    <div>
                      @if($program === '—')
                        <span class="text-[12px] text-gray-400">—</span>
                      @else
                        <span class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium
                          px-2.5 py-1 rounded-full border border-gray-200">
                          {{ $program }}
                        </span>
                      @endif
                    </div>

                    <!-- Status -->
                    <div>
                      @if($isToday)
                        <span class="status-pill status-confirmed">
                          <span class="status-dot"></span>Confirmed
                        </span>
                      @else
                        <span class="status-pill status-pending">
                          <span class="status-dot"></span>Upcoming
                        </span>
                      @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-1.5 items-end">
                      <button
                        type="button"
                        class="w-[120px] h-7 rounded-lg text-[11px] font-semibold text-white
                          bg-green-700 hover:bg-green-800 transition-all duration-150
                          flex items-center justify-center gap-1.5
                          disabled:opacity-50 disabled:cursor-not-allowed"
                        onclick="openStartProcedureModal(this)"
                        data-id="{{ $appt->id }}"
                        data-name="{{ $patientName }}"
                        data-datetime="{{ $dateLabel }} | {{ $timeLabel }}"
                        {{ $isToday ? '' : 'disabled' }}
                        title="{{ $isToday ? '' : 'Only available on appointment date' }}">
                        <i class="fa-solid fa-play text-[9px]"></i> Start
                      </button>

                      <button
                        type="button"
                        class="w-[120px] h-7 rounded-lg text-[11px] font-semibold
                          bg-amber-50 text-amber-700 border border-amber-200
                          hover:bg-amber-100 transition-all duration-150
                          flex items-center justify-center gap-1.5"
                        onclick="openRescheduleModal(this)"
                        data-id="{{ $appt->id }}"
                        data-name="{{ $patientName }}"
                        data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                        <i class="fa-solid fa-rotate-right text-[9px]"></i> Reschedule
                      </button>

                      <button
                        type="button"
                        class="w-[120px] h-7 rounded-lg text-[11px] font-semibold
                          bg-red-50 text-[#8b0000] border border-red-200
                          hover:bg-red-100 transition-all duration-150
                          flex items-center justify-center gap-1.5"
                        onclick="openCancelAppointmentModal(this)"
                        data-id="{{ $appt->id }}"
                        data-name="{{ $patientName }}"
                        data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                        <i class="fa-solid fa-xmark text-[9px]"></i> Cancel
                      </button>
                    </div>

                  </div>
                </div>
              @endforeach
            </div>

          </div>
        @empty
          <div class="flex flex-col items-center justify-center py-24 text-gray-400">
            <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
            <p class="text-base font-semibold text-gray-500">No upcoming appointments</p>
            <p class="text-sm mt-1">New appointments will appear here once scheduled.</p>
          </div>
        @endforelse

      </section>

      <!-- ═══════ PAST SECTION ═══════ -->
      <section id="pastSection" class="pb-14 hidden">

        @forelse($pastGrouped as $month => $items)
          <div class="relative pl-10 mb-14">
            <div class="absolute left-[6px] top-[6px] w-[2px] h-full bg-gray-200"></div>
            <div class="absolute left-0 top-[4px] w-3 h-3 bg-gray-400 rounded-full"></div>

            <div class="flex items-center gap-3 mb-5">
              <h2 class="text-xl font-bold text-gray-500">{{ $month }}</h2>
              <span class="bg-gray-100 text-gray-400 text-xs font-semibold px-3 py-1 rounded-full">
                {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
              </span>
            </div>

            <!-- Column headers -->
            <div class="grid grid-cols-[1.6fr_1.1fr_1.8fr_1.8fr_1.1fr]
              text-[11px] font-semibold uppercase tracking-wider text-gray-400
              pb-2 border-b border-gray-200 mb-3 px-5">
              <span>Date</span>
              <span>Time</span>
              <span>Service</span>
              <span>Patient</span>
              <span>Program</span>
            </div>

            <div class="space-y-3">
              @foreach($items as $i => $appt)
                @php
                  $patientName  = optional($appt->patient)->name ?? 'Unknown Patient';
                  $program      = optional($appt->patient)->program ?? '—';
                  $dateLabel    = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
                  $weekday      = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
                  $timeLabel    = $appt->appointment_time
                                    ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A')
                                    : '—';
                  $serviceLabel = ($appt->service_type ?? '') === 'Others'
                                    ? (($appt->other_services ?? '') ?: 'Others')
                                    : ($appt->service_type ?? '—');

                  $serviceLower = strtolower($serviceLabel);
                  $badgeClass = 'service-badge-default';
                  if (str_contains($serviceLower, 'surgery'))    $badgeClass = 'service-badge-surgery';
                  elseif (str_contains($serviceLower, 'check'))  $badgeClass = 'service-badge-checkup';
                  elseif (str_contains($serviceLower, 'whiten')) $badgeClass = 'service-badge-whitening';
                  elseif (str_contains($serviceLower, 'extrac')) $badgeClass = 'service-badge-extraction';
                @endphp

                <div class="appt-card opacity-75" style="animation-delay: {{ $i * 0.04 }}s">
                  <div class="grid grid-cols-[1.6fr_1.1fr_1.8fr_1.8fr_1.1fr]
                    items-center px-5 py-4 gap-2">

                    <div>
                      <p class="text-[13px] font-semibold text-gray-500">{{ $dateLabel }}</p>
                      <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                    </div>

                    <div>
                      <span class="time-chip text-gray-400">
                        <i class="fa-regular fa-clock text-xs"></i>
                        {{ $timeLabel }}
                      </span>
                    </div>

                    <div>
                      <span class="service-badge {{ $badgeClass }} opacity-70">
                        {{ $serviceLabel }}
                      </span>
                    </div>

                    <div>
                      <p class="text-[13px] font-medium text-gray-500">{{ $patientName }}</p>
                    </div>

                    <div>
                      @if($program === '—')
                        <span class="text-[12px] text-gray-400">—</span>
                      @else
                        <span class="inline-block bg-gray-100 text-gray-400 text-[11px] font-medium
                          px-2.5 py-1 rounded-full border border-gray-200">
                          {{ $program }}
                        </span>
                      @endif
                    </div>

                  </div>
                </div>
              @endforeach
            </div>

          </div>
        @empty
          <div class="flex flex-col items-center justify-center py-24 text-gray-400">
            <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
            <p class="text-base font-semibold text-gray-500">No past appointments</p>
            <p class="text-sm mt-1">Completed appointments will appear here.</p>
          </div>
        @endforelse

      </section>

    </div>
  </main>

  <!-- Footer -->
  <footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10"></footer>

  <!-- ═══════════════════════════════════════════════
       MODALS — UNCHANGED (logic preserved)
  ════════════════════════════════════════════════ -->

  <!-- Reschedule Modal -->
  <div id="rescheduleModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-yellow-200 px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-[#8b0000]">Reschedule Appointment</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to reschedule this appointment.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">You will be able to select a new date and time.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-circle-user text-lg"></i>
            <span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="resPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="resAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeRescheduleModal()"
            class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">
            Cancel
          </button>
          <button onclick="confirmReschedule()"
            class="px-6 py-2 rounded-lg bg-yellow-500 text-gray-800 font-semibold hover:bg-yellow-600 transition text-sm shadow-sm">
            Reschedule
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Start Procedure Modal -->
  <div id="startProcedureModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-green-700 px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-white">Confirm Procedure Start</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to begin this appointment's procedure.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">This will mark the appointment as in progress.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-circle-user text-lg"></i>
            <span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="startPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="startAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeStartProcedureModal()"
            class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">
            Cancel
          </button>
          <button onclick="confirmStartProcedure()"
            class="px-6 py-2 rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800 transition text-sm shadow-sm">
            Start Procedure
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Cancel Modal -->
  <div id="cancelAppointmentModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-[#8b0000] px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-white">Cancel Appointment</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to cancel this appointment.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">This action cannot be undone.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-calendar-check text-lg"></i>
            <span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="cancelPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="cancelAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeCancelAppointmentModal()"
            class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">
            Keep Appointment
          </button>
          <button onclick="confirmCancelAppointment()"
            class="px-6 py-2 rounded-lg bg-[#8b0000] text-white font-semibold hover:bg-[#6f0000] transition text-sm shadow-sm">
            Cancel Appointment
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ── DARK MODE ──
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon   = document.getElementById('themeIcon');
    const html        = document.documentElement;

    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle?.addEventListener('click', () => {
      const newTheme = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
      if (!themeIcon) return;
      themeIcon.classList.toggle('fa-moon', theme !== 'dark');
      themeIcon.classList.toggle('fa-sun',  theme === 'dark');
    }

    // ── SIDEBAR ──
    let sidebarOpen = false;

    function applyLayout(w) {
      const sidebar = document.getElementById('sidebar');
      const main    = document.getElementById('mainContent');
      if (sidebar) sidebar.style.width = w;
      if (main)    main.style.marginLeft = w;
    }

    function toggleSidebar() {
      const texts   = document.querySelectorAll('.sidebar-text');
      const wrapper = document.getElementById('sidebarToggleWrapper');
      const btn     = document.getElementById('sidebarToggleBtn');
      const icon    = document.getElementById('sidebarIcon');

      sidebarOpen = !sidebarOpen;

      if (sidebarOpen) {
        applyLayout('16rem');
        texts.forEach(t => { t.classList.remove('opacity-0','w-0'); t.classList.add('opacity-100','w-auto'); });
        wrapper?.classList.replace('justify-center','justify-end');
        btn?.classList.add('translate-x-2');
        if (icon) { icon.classList.remove('fa-bars'); icon.classList.add('fa-xmark'); }
      } else {
        applyLayout('72px');
        texts.forEach(t => { t.classList.add('opacity-0','w-0'); t.classList.remove('opacity-100','w-auto'); });
        wrapper?.classList.replace('justify-end','justify-center');
        btn?.classList.remove('translate-x-2');
        if (icon) { icon.classList.remove('fa-xmark'); icon.classList.add('fa-bars'); }
      }
    }

    document.addEventListener('DOMContentLoaded', () => { sidebarOpen = false; applyLayout('72px'); });

    // ── TABS ──
    const btnUpcoming     = document.getElementById('btnUpcoming');
    const btnPast         = document.getElementById('btnPast');
    const upcomingSection = document.getElementById('upcomingSection');
    const pastSection     = document.getElementById('pastSection');

    function setActiveTab(tab) {
      const isUpcoming = tab === 'upcoming';
      upcomingSection?.classList.toggle('hidden', !isUpcoming);
      pastSection?.classList.toggle('hidden', isUpcoming);
      btnUpcoming?.classList.toggle('bg-[#8b0000]', isUpcoming);
      btnUpcoming?.classList.toggle('text-white',   isUpcoming);
      btnUpcoming?.classList.toggle('text-white/70',!isUpcoming);
      btnPast?.classList.toggle('bg-[#8b0000]', !isUpcoming);
      btnPast?.classList.toggle('text-white',   !isUpcoming);
      btnPast?.classList.toggle('text-white/70', isUpcoming);
    }

    btnUpcoming?.addEventListener('click', () => setActiveTab('upcoming'));
    btnPast?.addEventListener('click',     () => setActiveTab('past'));

    // ── MODALS ──
    let selectedApptId = null;

    function openRescheduleModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('resPatientName').textContent    = btn.dataset.name || '—';
      document.getElementById('resAppointmentDate').textContent = btn.dataset.datetime || '—';
      document.getElementById('rescheduleModal').classList.remove('hidden');
    }
    function closeRescheduleModal() {
      document.getElementById('rescheduleModal').classList.add('hidden');
      selectedApptId = null;
    }
    function confirmReschedule() {
      window.location.href = `/dentist/appointments/${selectedApptId}/reschedule`;
    }

    function openStartProcedureModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('startPatientName').textContent    = btn.dataset.name || '—';
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

    function openCancelAppointmentModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('cancelPatientName').textContent    = btn.dataset.name || '—';
      document.getElementById('cancelAppointmentDate').textContent = btn.dataset.datetime || '—';
      document.getElementById('cancelAppointmentModal').classList.remove('hidden');
    }
    function closeCancelAppointmentModal() {
      document.getElementById('cancelAppointmentModal').classList.add('hidden');
      selectedApptId = null;
    }
    function confirmCancelAppointment() {
      window.location.href = `/dentist/appointments/${selectedApptId}/cancel`;
    }

    // ── NOTIFICATION DROPDOWN ──
    document.addEventListener('DOMContentLoaded', () => {
      const btn  = document.getElementById('notifBtn');
      const menu = document.getElementById('notifMenu');
      if (!btn || !menu) return;

      let isOpen = false;
      const openMenu  = () => { isOpen = true;  menu.classList.remove('notif-close'); menu.classList.add('notif-open'); };
      const closeMenu = () => { isOpen = false; menu.classList.remove('notif-open');  menu.classList.add('notif-close'); };

      btn.addEventListener('click', (e) => { e.stopPropagation(); isOpen ? closeMenu() : openMenu(); });
      menu.addEventListener('click', (e) => e.stopPropagation());
      document.addEventListener('click', () => { if (isOpen) closeMenu(); });
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && isOpen) closeMenu(); });

      closeMenu();
    });
  </script>

</body>
</html>