<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      daisyui: {
        themes: false
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
      overflow-x: hidden;
    }

    /* Layout (fix sidebar/main alignment) */
    #mainContent {
      margin-left: 200px;
      transition: margin-left .3s ease;
    }

    #sidebar {
      width: 200px;
      transition: width .3s ease;
    }

    #sidebar.collapsed {
      width: 72px !important;
    }

    /* Animations */
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
      animation: fadeIn 0.6s ease-out forwards;
    }

    @keyframes softPulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    .pulse-icon {
      animation: softPulse 2s ease-in-out infinite;
    }

    @keyframes shimmer {
      0% {
        background-position: -400px 0;
      }

      100% {
        background-position: 400px 0;
      }
    }

    .skeleton {
      background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 37%, #e5e7eb 63%);
      background-size: 800px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 0.75rem;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.6s ease-out forwards;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0) rotate(0deg);
      }

      50% {
        transform: translateY(-14px) rotate(2deg);
      }
    }

    .float-slow {
      animation: float 4.5s ease-in-out infinite;
      will-change: transform;
    }

    @keyframes shimmerBtn {
      0% {
        background-position: -200% 0;
      }

      100% {
        background-position: 200% 0;
      }
    }

    .shimmer-btn {
      background: linear-gradient(110deg, #660000 25%, rgba(255, 80, 80, 0.87) 37%, #660000 63%);
      background-size: 200% 100%;
      animation: shimmerBtn 10s linear infinite;
    }

    @keyframes wave {
      0% {
        transform: rotate(0deg);
      }

      20% {
        transform: rotate(14deg);
      }

      40% {
        transform: rotate(-8deg);
      }

      60% {
        transform: rotate(14deg);
      }

      80% {
        transform: rotate(-4deg);
      }

      100% {
        transform: rotate(0deg);
      }
    }

    .wave-hand {
      transform-origin: 70% 70%;
      animation: wave 2.5s ease-in-out infinite;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color .2s ease, transform .2s ease;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: .75rem;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    #sidebar.expanded .nav-section-label {
      display: block;
    }

    #sidebar.expanded .sidebar-text {
      opacity: 1;
      width: auto;
      overflow: visible;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
    }

    #sidebar.collapsed .sidebar-text {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.collapsed .nav-section-label {
      display: none;
    }

    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    .nav-section-label {
      font-size: .65rem;
      font-weight: 700;
      letter-spacing: .08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: .25rem;
    }

    .notif-open {
      opacity: 1 !important;
      transform: scale(1) !important;
      pointer-events: auto !important;
    }

    .notif-close {
      opacity: 0 !important;
      transform: scale(.95) !important;
      pointer-events: none !important;
    }

    [data-theme="dark"] body {
      background-color: #101010;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #101010;
    }

    [data-theme="dark"] .bg-white {
      background-color: #101010 !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, .45);
    }

    @keyframes spinSlow {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    @keyframes floatMoon {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-3px);
      }
    }

    @keyframes driftCloud {

      0%,
      100% {
        transform: translateX(0);
      }

      50% {
        transform: translateX(3px);
      }
    }

    .greet-spin {
      animation: spinSlow 8s linear infinite;
      display: inline-block;
    }

    .greet-float {
      animation: floatMoon 3s ease-in-out infinite;
      display: inline-block;
    }

    .greet-drift {
      animation: driftCloud 3s ease-in-out infinite;
      display: inline-block;
    }

    dialog#activeAppointmentModal::backdrop {
      background: rgba(16, 16, 16, .45);
    }

    dialog#activeAppointmentModal .swal-card {
      opacity: 0;
      transform: translateY(10px) scale(.97);
      transition: opacity .18s ease, transform .18s ease;
    }

    dialog#activeAppointmentModal[open] .swal-card {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal">

  @php
    use Carbon\Carbon;

    // Notifications safe defaults
    $notifications = collect($notifications ?? []);
    $notifCount = $notifications->count();

    // Prepare records for safe JSON use
    $homeRecords = ($records ?? collect())->map(function ($r) {
      return [
        'service' => $r->service_type,
        'date' => $r->appointment_date ? Carbon::parse($r->appointment_date)->format('F d, Y') : '',
        'time' => $r->appointment_time ?? '',
        'status' => 'completed',
        'duration' => $r->duration ?? '',
        'remarks' => $r->remarks ?? '',
        'oral' => $r->oral_examination ?? '',
        'diagnosis' => $r->diagnosis ?? '',
        'prescription' => $r->prescription ?? '',
      ];
    })->values();
  @endphp

  <!-- HEADER -->
  <div class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#660000] to-[#8B0000] text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-12 rounded-full ml-5">
        <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" />
      </div>
      <div class="w-12 rounded-full">
        <a href="{{ route('homepage') }}">
          <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
        </a>
      </div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </div>

    <div class="flex items-center gap-8">
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
          class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-200 z-50
                 opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right">

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
                <div class="text-xs text-[#757575] mt-1">You’re all caught up.</div>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="w-px h-8 bg-white/30"></div>

      <div class="flex items-center gap-3">
        <div class="avatar">
          <div class="w-10 rounded-full overflow-hidden">
            <img
              src="{{ $patient->profile_image
                ? asset('storage/'.$patient->profile_image)
                : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=128' }}"
              alt="Profile" />
          </div>
        </div>
        <div class="leading-tight">
          <div class="text-l font-semibold text-[#F4F4F4]">
            {{ ucwords(strtolower($patient->name)) }}
          </div>
          <div class="italic text-xs text-[#F4F4F4]/80">Student</div>
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px] h-[calc(100vh-72px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded">
    <!-- TOP -->
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <div class="nav-section-label px-4 mb-6">Navigation</div>

      <nav class="space-y-2 px-3 text-gray-600">
        <a href="{{ route('homepage') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('homepage') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300 {{ request()->routeIs('homepage') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-house text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Home</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Home</span>
        </a>

        <a href="{{ route('appointment.index') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('appointment.index*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300 {{ request()->routeIs('appointment.index*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-regular fa-calendar text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Appointment</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointment</span>
        </a>

        <a href="{{ route('record') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('record*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300 {{ request()->routeIs('record*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-regular fa-folder-open text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Record</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Record</span>
        </a>

        <a href="{{ route('about.us') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('about.us*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300 {{ request()->routeIs('about.us*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-circle-info text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">About Us</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">About Us</span>
        </a>
      </nav>
    </div>

    <!-- BOTTOM -->
    <div class="px-3 pb-5 space-y-2">
      <a href="#"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 text-gray-500">
        <i class="fa-regular fa-circle-question text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Help</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Help</span>
      </a>

      <button id="themeToggle"
        class="sidebar-link relative flex items-center w-full px-3 py-2.5 rounded-xl bg-[#7B6CF6] text-[#F4F4F4] transition-all duration-200 hover:scale-105"
        aria-label="Toggle dark mode">
        <i id="themeIcon" class="fa-regular fa-moon text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Dark Mode</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dark Mode</span>
      </button>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="sidebar-link w-full relative flex items-center px-3 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200">
          <i class="fa-solid fa-right-from-bracket text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Log Out</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log Out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- CONTENT -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mt-4 mx-auto">

      <!-- BREADCRUMB -->
      <div class="text-sm mb-4 font-medium fade-up">
        <span class="text-gray-400">User</span>
        <span class="mx-1 text-gray-400">&gt;</span>
        <span class="text-[#8B0000] font-semibold">Homepage</span>
      </div>

      <!-- HERO CARD -->
      <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] text-[#F4F4F4] rounded-2xl p-10 flex justify-between items-center mb-6 fade-up relative overflow-visible">
        <div>
          <div class="flex items-center gap-1.5 mb-1">
            <i class="fa-solid fa-sun text-yellow-400 text-sm greet-spin" id="greetingIcon"></i>
            <p class="text-m text-[#F4F4F4]" id="greetingText">Good morning</p>
          </div>

          <h1 class="text-5xl font-extrabold mt-1 mb-2 text-[#F4F4F4] fade-up">
            <span class="bg-gradient-to-r from-[#F4F4F4] to-[#FFD700] bg-clip-text text-transparent">
              Welcome, {{ ucwords(strtolower($patient->name)) }}!
            </span>
            <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
          </h1>

          <h2 class="text-m font-normal mt-4 mb-6 text-[#F4F4F4] fade-up">
            Healthy teeth start with one appointment. Let's keep your smile at its best.
          </h2>

          <button class="btn btn-soft shimmer-btn px-6 py-3 rounded-2xl border-none text-base font-semibold text-[#F4F4F4] transition-transform duration-500 hover:-translate-y-2 hover:shadow-[0_0_10px_rgba(255,255,255,0.4)]">
            <a href="{{ route('book.appointment') }}" class="flex items-center gap-2">
              <i class="fa-solid fa-calendar-plus"></i> Book Appointment
            </a>
          </button>
        </div>

        <div class="absolute right-7 top-1/2 -translate-y-1/2 pointer-events-none">
          <img src="{{ asset('images/home-tooth.png') }}" alt="Tooth Icon"
            class="float-slow w-[250px] max-w-none drop-shadow-[0_14px_26px_rgba(255,255,255,0.25)]" />
        </div>
      </div>

      <!-- UPCOMING -->
      <div class="mb-6 fade-up">
        <div id="upcomingAppointment"></div>
      </div>

      <!-- CALENDAR SECTION -->
      <section class="max-w-7xl mx-auto mb-10">
        <div class="flex flex-col md:flex-row gap-6">

          <!-- LEFT -->
          <div class="md:w-[600px] flex-shrink-0 flex flex-col gap-5">
            <div id="profileSkeletonContainer" class="rounded-2xl overflow-hidden shadow-lg"></div>
            <div class="bg-white rounded-2xl shadow-lg p-5">
              <div id="requestDocsContainer" class="space-y-3"></div>
            </div>
          </div>

          <!-- RIGHT -->
          <div class="flex-1 flex flex-col gap-2">
            <div id="calendarSkeletonContainer" class="bg-white border shadow-sm rounded-2xl p-6 h-[630px] w-full">
              <div class="animate-pulse space-y-4">
                <div class="h-6 w-32 bg-gray-200 rounded mx-auto"></div>
                <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:8px;">
                  @for($i = 0; $i < 35; $i++)
                    <div class="h-9 bg-gray-200 rounded-lg"></div>
                  @endfor
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>

      <!-- RECORDS -->
      <div class="bg-white rounded-2xl shadow-lg mb-8 fade-up overflow-hidden">
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b">
          <h2 class="text-xl font-extrabold text-[#8B0000]">My Dental Records</h2>
          <div id="viewAllContainer" class="hidden">
            <a href="{{ route('record') }}"
              class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#8B0000] border border-[#8B0000] px-4 py-1.5 rounded-lg hover:bg-[#8B0000] hover:text-white transition-colors duration-200">
              View Full Record <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>
        <div class="px-6 py-4">
          <div id="recordsInnerContainer" class="space-y-3"></div>
        </div>
      </div>

      <!-- RECORD MODAL -->
      <dialog id="record_modal" class="modal">
        <div class="modal-box p-0 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl bg-[#F3F3F3]">
          <div class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] px-8 py-6 text-white">
            <h3 id="m_service" class="text-3xl font-extrabold leading-tight">—</h3>
            <div class="mt-2 flex items-center gap-3 text-white/95">
              <i class="fa-regular fa-calendar"></i>
              <p class="text-base font-medium">
                <span id="m_date">—</span>
                <span class="mx-2">·</span>
                <span id="m_time">—</span>
              </p>
            </div>
          </div>

          <div class="px-8 py-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[90px] flex flex-col justify-center">
                <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
                  <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800">
                    <i class="fa-solid fa-check text-white text-[8px]"></i>
                  </span>
                  STATUS
                </div>
                <div class="mt-3 ml-4">
                  <span id="m_status" class="inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold bg-gray-200 text-gray-800">—</span>
                </div>
              </div>

              <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[90px] flex flex-col justify-center">
                <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
                  <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800">
                    <i class="fa-solid fa-check text-white text-[8px]"></i>
                  </span>
                  DURATION
                </div>
                <div class="mt-3 ml-4">
                  <span id="m_duration" class="inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold bg-gray-200 text-gray-800">—</span>
                </div>
              </div>
            </div>

            <div>
              <div class="flex items-center gap-4 mb-3">
                <span class="text-xs font-extrabold tracking-widest text-[#8B0000]">TREATMENT</span>
                <div class="h-px flex-1 bg-gray-300"></div>
              </div>
              <div class="bg-white rounded-md overflow-hidden">
                <div class="grid grid-cols-[6px_1fr]">
                  <div class="bg-gray-300"></div>
                  <div class="p-6 text-gray-700 text-sm leading-relaxed">
                    <span id="m_remarks">—</span>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div class="flex items-center gap-4 mb-3">
                <span class="text-xs font-extrabold tracking-widest text-[#8B0000]">ORAL EXAMINATION</span>
                <div class="h-px flex-1 bg-gray-300"></div>
              </div>
              <div class="bg-white rounded-md overflow-hidden">
                <div class="grid grid-cols-[6px_1fr]">
                  <div class="bg-gray-300"></div>
                  <div class="p-6 text-gray-700 text-sm leading-relaxed">
                    <span id="m_oral">—</span>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div class="flex items-center gap-4 mb-3">
                <span class="text-xs font-extrabold tracking-widest text-[#8B0000]">DIAGNOSIS</span>
                <div class="h-px flex-1 bg-gray-300"></div>
              </div>
              <div class="bg-white rounded-md overflow-hidden">
                <div class="grid grid-cols-[6px_1fr]">
                  <div class="bg-gray-300"></div>
                  <div class="p-6 text-gray-700 text-sm leading-relaxed">
                    <span id="m_diagnosis">—</span>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div class="flex items-center gap-4 mb-3">
                <span class="text-xs font-extrabold tracking-widest text-[#8B0000]">PRESCRIPTION</span>
                <div class="h-px flex-1 bg-gray-300"></div>
              </div>
              <div class="bg-white rounded-md overflow-hidden">
                <div class="grid grid-cols-[6px_1fr]">
                  <div class="bg-gray-300"></div>
                  <div class="p-6 text-gray-700 text-sm leading-relaxed">
                    <span id="m_prescription">—</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex justify-end pt-2">
              <form method="dialog">
                <button class="px-8 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">Close</button>
              </form>
            </div>
          </div>
        </div>

        <form method="dialog" class="modal-backdrop">
          <button>close</button>
        </form>
      </dialog>

      <!-- REQUEST CLEARANCE MODAL -->
      <dialog id="dentalClearanceModal" class="modal">
        <form
          id="clearanceRequestForm"
          method="POST"
          action="{{ route('document.requests.store') }}"
          class="modal-box rounded-2xl bg-[#F4F4F4] relative"
          novalidate>
          @csrf

          <div
            id="clearanceWarning"
            class="hidden absolute top-4 left-1/2 -translate-x-1/2
              px-4 py-1.5 rounded-full bg-red-600 text-[#F4F4F4]
              text-xs font-semibold shadow-lg">
            Please complete all required fields
          </div>

          <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">
            Request Clearance
          </h3>

          <p class="text-sm text-[#333333] mb-5">
            Please allow up to three (3) working days for processing.
          </p>

          <div class="mb-5">
            <label class="block text-sm font-bold text-[#8B0000] mb-1">
              Type of Clearance
            </label>
            <select
              name="document_type"
              required
              class="select select-bordered w-full rounded-xl
                 bg-[#F4F4F4] text-[#333333]
                 focus:outline-none focus:ring-0 focus:border-[#8B0000]">
              <option value="" disabled selected>Select type of clearance</option>
              <option value="Dental Clearance">Dental Clearance</option>
              <option value="Annual Dental Clearance">Annual Dental Clearance</option>
            </select>
          </div>

          <div class="mb-5">
            <label class="block text-sm font-bold text-[#8B0000] mb-1">
              Purpose
            </label>
            <select
              name="purpose"
              required
              class="select select-bordered w-full rounded-xl
                 bg-[#F4F4F4] text-[#333333]
                 focus:outline-none focus:ring-0 focus:border-[#8B0000]">
              <option value="" disabled selected>Select purpose</option>
              <option value="On-the-Job Training (OJT)">On-the-Job Training (OJT)</option>
              <option value="Employment Requirement">Employment Requirement</option>
              <option value="Academic Requirement">Academic Requirement</option>
            </select>
          </div>

          <div class="modal-action flex justify-between">
            <button type="button"
              onclick="dentalClearanceModal.close()"
              class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">
              Back
            </button>

            <button type="submit"
              class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">
              Save
            </button>
          </div>
        </form>
      </dialog>

      <!-- REQUEST DENTAL HEALTH RECORD MODAL -->
      <dialog id="dentalHealthRecordModal" class="modal">
        <form
          id="healthRecordRequestForm"
          method="POST"
          action="{{ route('document.requests.store') }}"
          class="modal-box rounded-2xl bg-[#F4F4F4] relative"
          novalidate>
          @csrf

          <div
            id="healthRecordWarning"
            class="hidden absolute top-4 left-1/2 -translate-x-1/2
              px-4 py-1.5 rounded-full bg-red-600 text-[#F4F4F4]
              text-xs font-semibold shadow-lg">
            Please complete all required fields
          </div>

          <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">
            Request Dental Health Record
          </h3>

          <p class="text-sm mb-5 text-[#333333]">
            Please allow up to three (3) working days for processing.
          </p>

          <div class="mb-5">
            <label class="block text-sm font-bold text-[#8B0000] mb-1">
              Type of Dental Health Record
            </label>
            <select
              name="document_type"
              required
              class="select select-bordered w-full rounded-xl
                 bg-[#F4F4F4] text-[#333333]
                 focus:outline-none focus:ring-0 focus:border-[#8B0000]">
              <option value="" disabled selected>Select type</option>
              <option value="All Dental Records">All Dental Records</option>
              <option value="Medical Records">Medical Records</option>
              <option value="Diagnosis and Treatment">Diagnosis and Treatment</option>
            </select>
          </div>

          <div class="mb-5">
            <label class="block text-sm font-bold text-[#8B0000] mb-1">
              Purpose
            </label>
            <select
              name="purpose"
              required
              class="select select-bordered w-full rounded-xl
                 bg-[#F4F4F4] text-[#333333]
                 focus:outline-none focus:ring-0 focus:border-[#8B0000]">
              <option value="" disabled selected>Select purpose</option>
              <option value="Personal Record">Personal Record</option>
              <option value="Academic Requirement">Academic Requirement</option>
              <option value="Employment Requirement">Employment Requirement</option>
            </select>
          </div>

          <div class="modal-action flex justify-between">
            <button type="button"
              onclick="dentalHealthRecordModal.close()"
              class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">
              Back
            </button>

            <button type="submit"
              class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">
              Save
            </button>
          </div>
        </form>
      </dialog>

      <!-- CONFIRM SAVE MODAL (kept, but not used by this file unless you wire it) -->
      <dialog id="confirmSaveModal" class="modal">
        <div class="modal-box rounded-2xl bg-[#F4F4F4]">
          <h3 class="font-bold text-lg mb-2">Confirm</h3>
          <p id="confirmSaveText" class="mb-6">Are you sure?</p>
          <div class="modal-action flex justify-between">
            <button onclick="confirmSaveModal.close()" class="btn">Cancel</button>
            <button onclick="submitConfirmedForm?.()" class="btn btn-error text-[#F4F4F4]">Yes, Submit</button>
          </div>
        </div>
      </dialog>

      <!-- SUBMITTED INFO MODAL (kept) -->
      <dialog id="submittedInfoModal" class="modal">
        <div class="modal-box rounded-2xl bg-[#F4F4F4]">
          <h3 class="font-bold text-lg mb-2">Submitted!</h3>
          <p>Your request has been submitted.</p>
          <div class="modal-action">
            <button onclick="submittedInfoModal.close()" class="btn btn-error text-[#F4F4F4]">OK</button>
          </div>
        </div>
      </dialog>

      <!-- ACTIVE APPOINTMENT MODAL (FIXED HTML) -->
      <dialog id="activeAppointmentModal" class="modal">
        <div class="modal-box swal-card rounded-2xl bg-white text-center shadow-2xl w-[min(92vw,420px)]">
          <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#FFF0F0] flex items-center justify-center">
            <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-2xl"></i>
          </div>

          <h3 class="text-xl font-extrabold text-[#8B0000] mb-2">Active Appointment Detected</h3>
          <p class="text-sm text-gray-600 mb-6">
            You already have an active appointment. Please complete or cancel it before booking a new one.
          </p>

          <div class="modal-action justify-center gap-3">
            <a href="{{ route('appointment.index') }}" class="btn bg-[#8B0000] text-[#F4F4F4] hover:bg-[#7A0000] transition-colors duration-200">
              View My Appointments
            </a>
            <button id="closeActiveApptModalBtn" type="button" class="btn btn-ghost">Close</button>
          </div>
        </div>
      </dialog>

    </div> <!-- /max-w -->
  </main>

  <!-- ACTIVE APPOINTMENT MODAL SCRIPT -->
  @if(session('activeAppointmentModal'))
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("activeAppointmentModal");
        const closeBtn = document.getElementById("closeActiveApptModalBtn");
        if (!modal) return;

        modal.showModal();

        modal.addEventListener('click', (e) => {
          const box = modal.querySelector('.modal-box');
          if (!box) return;
          if (!box.contains(e.target)) e.preventDefault();
        });

        modal.addEventListener('cancel', (e) => e.preventDefault());
        if (closeBtn) closeBtn.addEventListener("click", () => modal.close());
      });
    </script>
  @endif

  <script>
    // =========================
    // DARK MODE TOGGLE
    // =========================
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const html = document.documentElement;

    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle?.addEventListener('click', () => {
      const currentTheme = html.getAttribute('data-theme');
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
      if (!themeIcon) return;
      if (theme === 'dark') {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
      } else {
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
      }
    }

    // =========================
    // SIDEBAR TOGGLE (kept your logic, fixed layout)
    // =========================
    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      if (!sidebar || !main) return;

      sidebar.style.width = sidebarWidth;
      main.style.marginLeft = sidebarWidth;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');

      if (!sidebar) return;

      sidebarOpen = !sidebarOpen;

      if (sidebarOpen) {
        applyLayout('200px');
        sidebar.classList.remove('collapsed');
        sidebar.classList.add('expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper?.classList.remove('justify-center');
        toggleWrapper?.classList.add('justify-end');
        icon?.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.remove('expanded');
        sidebar.classList.add('collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper?.classList.remove('justify-end');
        toggleWrapper?.classList.add('justify-center');
        icon?.classList.replace('fa-xmark', 'fa-bars');
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('200px');
    });

    // =========================
    // Skeleton Loading
    // =========================
    document.addEventListener("DOMContentLoaded", () => {
      showSkeletons();

      setTimeout(() => {
        renderProfile();
        loadCalendar();
        renderRequestDocs();
        renderUpcomingSchedule();
        renderRecords();
      }, 1000);
    });

    function showSkeletons() {
      const viewAll = document.getElementById("viewAllContainer");
      if (viewAll) viewAll.classList.add('hidden');

      document.getElementById("profileSkeletonContainer").innerHTML = `
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg animate-pulse">
          <div class="bg-gray-200 h-24 w-full"></div>
          <div class="p-4 space-y-3">
            ${[1,2,3,4].map(() => `
              <div class="flex gap-4">
                <div class="h-3 w-24 skeleton"></div>
                <div class="h-3 w-40 skeleton"></div>
              </div>`).join('')}
          </div>
        </div>
      `;

      document.getElementById("upcomingAppointment").innerHTML = `
        <div class="bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center gap-6 animate-pulse">
          <div class="w-12 h-12 skeleton rounded-xl"></div>
          <div class="flex-1 grid grid-cols-3 gap-4">
            ${[1,2,3].map(() => `
              <div class="space-y-2">
                <div class="h-2 w-20 skeleton"></div>
                <div class="h-4 w-32 skeleton"></div>
              </div>`).join('')}
          </div>
          <div class="h-7 w-24 skeleton rounded-full"></div>
        </div>
      `;

      document.getElementById("calendarSkeletonContainer").innerHTML = `
        <div class="h-6 w-32 skeleton mx-auto mb-4"></div>
        <div class="grid grid-cols-7 gap-2">
          ${Array(35).fill('<div class="h-9 skeleton rounded-lg"></div>').join('')}
        </div>
      `;

      document.getElementById("requestDocsContainer").innerHTML = `
        ${[1,2].map(() => `
          <div class="flex items-center gap-3 border rounded-xl p-3 animate-pulse">
            <div class="w-10 h-10 skeleton rounded-lg flex-shrink-0"></div>
            <div class="flex-1 space-y-2">
              <div class="h-3 w-36 skeleton"></div>
              <div class="h-2 w-48 skeleton"></div>
            </div>
          </div>`).join('')}
      `;

      document.getElementById("recordsInnerContainer").innerHTML = `
        <div class="space-y-3 animate-pulse">
          ${[1,2,3].map(() => `
            <div class="flex items-center gap-4 border rounded-xl p-4">
              <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
              <div class="flex-1 space-y-2">
                <div class="h-4 w-40 skeleton"></div>
                <div class="h-3 w-56 skeleton"></div>
              </div>
              <div class="h-8 w-20 skeleton rounded-lg"></div>
            </div>`).join('')}
        </div>
      `;
    }

    function renderProfile() {
      document.getElementById("profileSkeletonContainer").innerHTML = `
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm fade-up">
          <div class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-6 text-[#F4F4F4] flex items-center gap-4">
            <div class="avatar flex-shrink-0">
              <div class="w-14 h-14 rounded-full overflow-hidden ring-1 ring-white/30">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=660000&color=FFFFFF&rounded=true&size=128" alt="Profile" />
              </div>
            </div>
            <div>
              <p class="font-bold text-xl leading-tight">{{ isset($patient->name) ? ucwords(strtolower($patient->name)) : 'Guest' }}</p>
              <p class="text-sm text-[#F4F4F4]/70 mb-2">Student</p>
              <span class="inline-block bg-[#FFD700]/40 text-[#FFD700] border border-[#FFD700] text-xs font-extrabold px-2.5 py-0.5 rounded-full">
                {{ $patient->patient_id ?? 'N/A' }}
              </span>
            </div>
          </div>

          <div class="mx-0 bg-white divide-y divide-gray-100 text-sm rounded-b-2xl overflow-hidden">
            <div class="flex px-4 py-3 gap-4">
              <span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Date of Birth</span>
              <span class="font-semibold text-[#333333]">
                {{ $patient->birthdate ? Carbon::parse($patient->birthdate)->format('F d, Y') : '-' }}
              </span>
            </div>
            <div class="flex px-4 py-3 gap-4">
              <span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Age</span>
              <span class="font-semibold text-[#333333]">{{ $patient->age ?? '-' }}</span>
            </div>
            <div class="flex px-4 py-3 gap-4">
              <span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Gender</span>
              <span class="font-semibold text-[#333333]">{{ $patient->gender ?? '-' }}</span>
            </div>
            <div class="flex px-4 py-3 gap-4">
              <span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Contact</span>
              <span class="font-semibold text-[#333333]">{{ $patient->phone ?? '-' }}</span>
            </div>
            <div class="flex px-4 py-3 gap-4">
              <span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Email</span>
              <span class="font-semibold text-[#333333]">{{ $patient->email ?? '-' }}</span>
            </div>
          </div>
        </div>
      `;
    }

    function renderRequestDocs() {
      document.getElementById("requestDocsContainer").innerHTML = `
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-folder text-[#8B0000] text-lg"></i>
          </div>
          <h3 class="font-extrabold text-lg text-[#333333]">Request Documents</h3>
        </div>

        <a onclick="document.getElementById('dentalHealthRecordModal')?.showModal()"
          class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
          <div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
            <img src="{{ asset('images/dental-health-record.png') }}" class="w-7 h-6"/>
          </div>
          <div>
            <p class="font-bold text-sm text-[#333333]">Request Dental Health Record</p>
            <p class="text-xs text-[#757575]">All Dental Records • Medical Record • Diagnosis & Treatments</p>
          </div>
        </a>

        <a onclick="document.getElementById('dentalClearanceModal')?.showModal()"
          class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
          <div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
            <img src="{{ asset('images/dental-clearance.png') }}" class="w-7 h-6"/>
          </div>
          <div>
            <p class="font-bold text-sm text-[#333333]">Request Dental Clearance</p>
            <p class="text-xs text-[#757575]">Dental Clearance • Annual Dental Clearance</p>
          </div>
        </a>
      `;
    }

    function renderUpcomingSchedule() {
      const container = document.getElementById("upcomingAppointment");

      @if(isset($upcomingAppointment) && $upcomingAppointment)
        container.innerHTML = `
          <div class="bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center gap-6 fade-up">
            <div class="w-12 h-12 bg-[#FFF0F0] rounded-xl flex items-center justify-center flex-shrink-0">
              <i class="fa-regular fa-calendar-check text-[#8B0000] text-xl"></i>
            </div>

            <div class="flex-1 grid grid-cols-3 gap-4">
              <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400 mb-0.5">Next Appointment</p>
                <p class="font-bold text-sm text-[#333333]">{{ $upcomingAppointment->service_type ?? 'Dental Visit' }}</p>
              </div>
              <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400 mb-0.5">Date & Time</p>
                <p class="font-bold text-sm text-[#333333]">
                  {{ Carbon::parse($upcomingAppointment->appointment_date)->format('F d, Y') }}
                  &bull; {{ $upcomingAppointment->appointment_time }}
                </p>
              </div>
              <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400 mb-0.5">Dentist</p>
                <p class="font-bold text-sm text-[#333333]">{{ $upcomingAppointment->dentist_name ?? '—' }}</p>
              </div>
            </div>

            <div class="flex-shrink-0">
              <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                {{ ($upcomingAppointment->status ?? '') === 'Confirmed'
                  ? 'bg-green-50 text-green-600 border border-green-200'
                  : 'bg-yellow-50 text-yellow-600 border border-yellow-200' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ ($upcomingAppointment->status ?? '') === 'Confirmed' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                {{ $upcomingAppointment->status ?? 'Pending' }}
              </span>
            </div>
          </div>
        `;
      @else
        container.innerHTML = `
          <div class="bg-white rounded-2xl shadow-sm px-6 py-5 flex items-center gap-4 fade-up">
            <div class="w-10 h-10 bg-[#FFF0F0] rounded-xl flex items-center justify-center flex-shrink-0">
              <i class="fa-regular fa-calendar text-[#8B0000]"></i>
            </div>
            <p class="text-sm text-[#757575]">No upcoming appointments.
              <a href="{{ route('book.appointment') }}" class="text-[#8B0000] font-semibold hover:underline">Book one now</a>.
            </p>
          </div>
        `;
      @endif
    }

    // =========================
    // Calendar (FIXED: removed "- >" typo + fixed counts object)
    // =========================
    function loadCalendar() {
      const MAX_PER_DAY = 5;

      const myAppointments = {
        @if(isset($appointments) && $appointments->count() > 0)
          @foreach($appointments as $appt)
            "{{ Carbon::parse($appt->appointment_date)->format('Y-m-d') }}": "{{ addslashes($appt->service_type) }} • {{ $appt->appointment_time }}",
          @endforeach
        @endif
      };

      const apptCounts = {
        @if(isset($appointmentCountsPerDay) && count($appointmentCountsPerDay) > 0)
          @foreach($appointmentCountsPerDay as $date => $count)
            "{{ $date }}": {{ (int) $count }},
          @endforeach
        @endif
      };

      const unavailableDates = [
        @foreach(($unavailableDates ?? []) as $d)
          "{{ $d }}",
        @endforeach
      ];

      const allHolidays = {
        @foreach(($philippineHolidays ?? []) as $date => $name)
          "{{ $date }}": "{{ addslashes($name) }}",
        @endforeach
      };

      const today = new Date();
      let currentYear = today.getFullYear();
      let currentMonth = today.getMonth();

      function pad(n) {
        return String(n).padStart(2, '0');
      }

      function isWeekend(year, month, day) {
        const dow = new Date(year, month, day).getDay();
        return dow === 0 || dow === 6;
      }

      function getHolidaysForMonth(year, month) {
        const filtered = {};
        Object.keys(allHolidays).forEach(dateStr => {
          const [y, m] = dateStr.split('-').map(Number);
          if (y === year && m === month + 1) filtered[dateStr] = allHolidays[dateStr];
        });
        return filtered;
      }

      function renderCalendar(year, month) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();
        const leadingEmpties = firstDow;

        const holidays = getHolidaysForMonth(year, month);
        let cells = '';
        for (let i = 0; i < leadingEmpties; i++) cells += `<div></div>`;

        for (let d = 1; d <= totalDays; d++) {
          const dateStr = `${year}-${pad(month + 1)}-${pad(d)}`;
          const isToday = (d === today.getDate() && month === today.getMonth() && year === today.getFullYear());
          const weekend = isWeekend(year, month, d);
          const holiday = holidays[dateStr] || null;
          const myAppt = myAppointments[dateStr] || null;
          const count = apptCounts[dateStr] || 0;
          const isFull = count >= MAX_PER_DAY;
          const isUnavail = unavailableDates.includes(dateStr) || weekend;

          let bgClass = '',
            textClass = 'text-[#333333]',
            ringClass = '',
            dotHtml = '',
            tooltipTxt = '';

          if (isToday) {
            bgClass = 'bg-[#8B0000]';
            textClass = 'text-white font-extrabold';
            ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
          } else if (holiday) {
            bgClass = 'bg-blue-50 hover:bg-blue-100';
            textClass = 'text-blue-700 font-semibold';
          } else if (isUnavail) {
            textClass = 'text-gray-300';
          } else {
            bgClass = 'hover:bg-[#FFF0F0]';
          }

          if (myAppt) {
            const dotColor = isToday ? 'bg-white' : 'bg-[#008440]';
            dotHtml += `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ${dotColor}"></span>`;
            tooltipTxt = `<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>${myAppt}`;
          }

          if (isFull && !myAppt && !isUnavail && !holiday) {
            dotHtml += `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
            tooltipTxt = `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked (${count} appointments)`;
          }

          if (holiday && !myAppt) {
            dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>`;
            tooltipTxt = `<i class="fa-solid fa-star mr-1 text-blue-300"></i>${holiday}`;
          }

          if (isUnavail && !holiday && !myAppt) {
            tooltipTxt = weekend ? `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed` :
              `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
          }

          const tooltipHtml = tooltipTxt ? `
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">
              ${tooltipTxt}
              <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div>
            </div>` : '';

          cells += `
            <div class="relative group flex items-center justify-center">
              ${tooltipHtml}
              <div class="relative w-9 h-9 flex items-center justify-center text-sm rounded-full transition-all duration-150 ${bgClass} ${textClass} ${ringClass} cursor-default">
                ${d}
                ${dotHtml}
              </div>
            </div>`;
        }

        const headerHtml = dayLabels.map((l, i) => {
          const labelColor = (i === 0 || i === 6) ? 'text-[#8B0000]/40' : 'text-[#333333]';
          return `<div class="text-center text-[10px] font-bold ${labelColor} uppercase tracking-widest">${l}</div>`;
        }).join('');

        document.getElementById("calendarSkeletonContainer").innerHTML = `
          <div class="h-full flex flex-col select-none">
            <div class="flex items-center justify-center gap-2 mb-3">
              <i class="fa-regular fa-calendar-check text-[#333333] text-xl"></i>
              <h2 class="text-xl font-extrabold text-[#333333]">Dental Clinic Schedule</h2>
            </div>
            <hr class="border-t border-gray-200 mb-4">

            <div class="flex items-center justify-between mt-6 mb-5">
              <button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
                <i class="fa-solid fa-chevron-left text-xs"></i>
              </button>
              <div class="text-center">
                <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
                <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
              </div>
              <button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
                <i class="fa-solid fa-chevron-right text-xs"></i>
              </button>
            </div>

            <div class="grid grid-cols-7 gap-2 mt-4 mb-2">${headerHtml}</div>
            <div class="grid grid-cols-7 gap-2 flex-1 content-start">${cells}</div>
          </div>
        `;
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

    // =========================
    // Dental Records Rendering
    // =========================
    const HOME_RECORDS = @json($homeRecords);

    function escapeHtml(str) {
      return String(str ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    function renderRecords() {
      const container = document.getElementById("recordsInnerContainer");
      const viewAll = document.getElementById("viewAllContainer");
      if (!container) return;

      if (!HOME_RECORDS || HOME_RECORDS.length === 0) {
        container.innerHTML = `
          <div class="flex flex-col items-center justify-center py-12 text-center space-y-4 fade-in">
            <div class="w-24 h-24 flex items-center justify-center pulse-icon">
              <img src="{{ asset('images/nodental-record.png') }}" class="w-24 h-24">
            </div>
            <p class="text-xl font-bold text-[#8B0000]">Nothing here yet…</p>
            <p class="text-sm text-[#ADADAD]">Time to book that first visit.</p>
            <button class="btn btn-soft shimmer-btn px-6 py-3 rounded-2xl border-none text-base font-semibold text-[#F4F4F4] transition-transform duration-500 hover:-translate-y-2 hover:shadow-[0_0_10px_rgba(255,255,255,0.4)]">
              <a href="{{ route('book.appointment') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-calendar-plus"></i>
                Book Appointment
              </a>
            </button>
          </div>
        `;
        if (viewAll) viewAll.classList.add('hidden');
        return;
      }

      if (viewAll) viewAll.classList.remove('hidden');

      let html = `
        <div class="relative">
          <div class="absolute left-[10px] top-3 bottom-3 w-px bg-[#8B0000]/30"></div>
          <div class="space-y-3 pl-10">
      `;

      HOME_RECORDS.forEach((r) => {
        const encoded = encodeURIComponent(JSON.stringify(r));
        html += `
          <div class="relative flex justify-between items-center border rounded-xl px-6 py-4 bg-white hover:shadow-sm transition fade-up">
            <div class="absolute -left-[26px] w-4 h-4 rounded-full bg-[#8B0000] border-2 border-white ring-2 ring-[#8B0000]/20"></div>

            <div>
              <p class="font-semibold text-[#8B0000] text-sm">${escapeHtml(r.service)}</p>
              <p class="text-xs text-[#757575] mt-0.5">
                ${escapeHtml(r.date)} &bull; ${escapeHtml(r.time)}
              </p>
            </div>

            <button type="button"
              class="flex items-center gap-1.5 bg-[#8B0000] hover:bg-[#660000] text-[#F4F4F4] text-xs font-semibold px-4 py-2 rounded-lg transition-colors duration-200"
              onclick="openRecordModalFromData('${encoded}')">
              <i class="fa-regular fa-eye text-xs"></i> Details
            </button>
          </div>
        `;
      });

      html += `</div></div>`;
      container.innerHTML = html;
    }

    function openRecordModalFromData(encodedJson) {
      const data = JSON.parse(decodeURIComponent(encodedJson));
      openRecordModal(data);
    }

    function openRecordModal(data) {
      const modal = document.getElementById('record_modal');
      if (!modal) return;

      document.getElementById('m_service').textContent = data.service || '—';
      document.getElementById('m_date').textContent = data.date || '—';
      document.getElementById('m_time').textContent = data.time || '—';

      const BADGE = 'inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold';

      const status = (data.status || 'completed').trim();
      const statusEl = document.getElementById('m_status');
      statusEl.textContent = status;
      statusEl.className = BADGE;

      const s = status.toLowerCase();
      if (s === 'completed') statusEl.classList.add('bg-emerald-200', 'text-emerald-900');
      else if (s === 'rescheduled') statusEl.classList.add('bg-yellow-200', 'text-yellow-900');
      else if (s === 'cancelled') statusEl.classList.add('bg-red-200', 'text-red-900');
      else statusEl.classList.add('bg-gray-200', 'text-gray-800');

      const durEl = document.getElementById('m_duration');
      durEl.textContent = (data.duration || '—').trim() || '—';
      durEl.className = BADGE + ' bg-gray-200 text-gray-800';

      document.getElementById('m_remarks').textContent = (data.remarks || '').trim() || '—';
      document.getElementById('m_oral').textContent = (data.oral || '').trim() || '—';
      document.getElementById('m_diagnosis').textContent = (data.diagnosis || '').trim() || '—';
      document.getElementById('m_prescription').textContent = (data.prescription || '').trim() || '—';

      modal.showModal();
    }

    // Notifications dropdown
    document.addEventListener("DOMContentLoaded", () => {
      const btn = document.getElementById("notifBtn");
      const menu = document.getElementById("notifMenu");
      let isOpen = false;

      function openMenu() {
        isOpen = true;
        menu.classList.remove("notif-close");
        menu.classList.add("notif-open");
      }

      function closeMenu() {
        isOpen = false;
        menu.classList.remove("notif-open");
        menu.classList.add("notif-close");
      }

      if (btn && menu) {
        btn.addEventListener("click", (e) => {
          e.stopPropagation();
          isOpen ? closeMenu() : openMenu();
        });
        menu.addEventListener("click", (e) => e.stopPropagation());
        document.addEventListener("click", () => {
          if (isOpen) closeMenu();
        });
        document.addEventListener("keydown", (e) => {
          if (e.key === "Escape" && isOpen) closeMenu();
        });
        closeMenu();
      }
    });

    // Dynamic greeting
    (function () {
      const hour = new Date().getHours();
      let greeting, iconClasses, animClass;

      if (hour >= 6 && hour < 12) {
        greeting = 'Good morning';
        iconClasses = 'fa-solid fa-sun text-yellow-400 text-sm';
        animClass = 'greet-spin';
      } else if (hour >= 12 && hour < 18) {
        greeting = 'Good afternoon';
        iconClasses = 'fa-solid fa-cloud-sun text-yellow-300 text-sm';
        animClass = 'greet-drift';
      } else {
        greeting = 'Good evening';
        iconClasses = 'fa-solid fa-moon text-blue-300 text-sm';
        animClass = 'greet-float';
      }

      const el = document.getElementById('greetingText');
      const icon = document.getElementById('greetingIcon');
      if (el) el.textContent = greeting;
      if (icon) icon.className = iconClasses + ' ' + animClass;
    })();
  </script>

</body>

</html>