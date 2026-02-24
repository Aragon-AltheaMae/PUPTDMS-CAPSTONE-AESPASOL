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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script type="module" src="https://unpkg.com/cally"></script>

  <script>
    tailwind.config = {
      daisyui: {
        themes: false,
      },
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
    }

    /* Fade-in animation */
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

    /* Subtle pulse for icon */
    @keyframes softPulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
    }

    .pulse-icon {
      animation: softPulse 2s ease-in-out infinite;
    }

    /* Skeleton shimmer */
    @keyframes shimmer {
      0% {
        background-position: -400px 0;
      }
      100% {
        background-position: 400px 0;
      }
    }

    .skeleton {
      background: linear-gradient(
        90deg,
        #e5e7eb 25%,
        #f3f4f6 37%,
        #e5e7eb 63%
      );
      background-size: 800px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 0.75rem;
    }

    /* Fade-up after skeleton loading */
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
      0%, 100% {
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

      /* Shimmer effect */
    @keyframes shimmer {
      0% {
        background-position: -200% 0;
      }
      100% {
        background-position: 200% 0;
      }
    }

    .shimmer-btn {
      background: linear-gradient(
        110deg,
        #660000 25%,
        rgba(255, 80, 80, 0.87) 37%,
        #660000 63%
      );
      background-size: 200% 100%;
      animation: shimmer 10s linear infinite;
    }

    @keyframes wave {
      0% { transform: rotate(0deg); }
      20% { transform: rotate(14deg); }
      40% { transform: rotate(-8deg); }
      60% { transform: rotate(14deg); }
      80% { transform: rotate(-4deg); }
      100% { transform: rotate(0deg); }
    }

    .wave-hand {
      transform-origin: 70% 70%;
      animation: wave 2.5s ease-in-out infinite;
    }

    /* Sidebar base */
    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color 0.2s ease, transform 0.2s ease;
    }

    /* EXPANDED state */
    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
    }
    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
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

    /* COLLAPSED state */
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

    /* Tooltip style */
    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    .nav-section-label {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      color: #9CA3AF;
      text-transform: uppercase;
      margin-bottom: 0.25rem;
    }

    /* Notification dropdown animation */
    .notif-open {
      opacity: 1 !important;
      transform: scale(1) !important;
      pointer-events: auto !important;
    }

    .notif-close {
      opacity: 0 !important;
      transform: scale(0.95) !important; /* zoom out */
      pointer-events: none !important;
    }

    /* DARK MODE */
    [data-theme="dark"] body {
    background-color: #111827; /* slate-900 */
    color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #1F2933;
    }

    [data-theme="dark"] .bg-white {
      background-color: #1F2937 !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    #sidebar.collapsed .nav-section-label { display: none; }
    #sidebar.expanded .nav-section-label { display: block; }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 0;
      padding-right: 0;
    }
    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    #sidebar.expanded .sidebar-link { justify-content: flex-start; }
    #sidebar.expanded .sidebar-link i { margin-right: 0.75rem; }
    #sidebar.expanded .sidebar-link:hover { transform: translateX(4px); }
    #sidebar.collapsed .sidebar-tooltip { display: block; }
    #sidebar.expanded .sidebar-tooltip { display: none; }

    /* Active nav glow */
    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, 0.45);
    }

  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal">

<!-- <form method="POST" action="{{ url('/homepage') }}"> -->

<!-- HEADER (TOP BAR) -->
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
  // Pass $notifications from controller, or leave it empty for now
  // Expected format: [['title'=>'...', 'message'=>'...', 'time'=>'...', 'url'=>'...'], ...]
  $notifications = collect($notifications ?? []);
  $notifCount = $notifications->count();
  @endphp

  <div id="notifDropdown" class="relative">
    
  <button id="notifBtn" type="button"
    class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">

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
            <div class="text-xs text-[#ADADAD] mt-0.5">
              {{ $n['message'] }}
            </div>
          @endif
          @if(!empty($n['time']))
            <div class="text-[11px] text-gray-400 mt-1">
              {{ $n['time'] }}
            </div>
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

    <!-- Separator -->
    <div class="w-px h-8 bg-white/30"></div>

    <div class="flex items-center gap-3">
      <div class="avatar">
        <div class="w-10 rounded-full overflow-hidden">
          <img
            src="{{ $patient->profile_image
                  ? asset('storage/'.$patient->profile_image)
                  : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=128' }}"
            alt="Profile"
          />
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
  class="fixed left-0 top-[72px]
         h-[calc(100vh-72px)]
         bg-white
         drop-shadow-xl
         transition-all duration-300
         flex flex-col justify-between z-40 expanded"
  style="width: 200px;">

  <!-- TOP -->
  <div class="pt-4">

    <!-- Toggle Button -->
    <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
      <button onclick="toggleSidebar()"
        id="sidebarToggleBtn"
        class="w-8 h-8 flex items-center justify-center
              rounded-full text-[#757575] hover:text-[#8B0000]
              hover:bg-[#F0F0F0] transition-all duration-300">
        <i id="sidebarIcon" class="fa-solid fa-bars text-base"></i>
      </button>
    </div>

  <!-- NAVIGATION LABEL -->
<div class="nav-section-label px-4 mb-6">Navigation</div>

    <!-- MENU -->
    <nav class="space-y-1 px-3 text-gray-600">

      <!-- HOME -->
      <a href="{{ route('homepage') }}"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('homepage') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
        <span class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('homepage') ? 'opacity-100' : 'opacity-0' }}"></span>
        <i class="fa-solid fa-house text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Home</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Home</span>
      </a>

      <!-- APPOINTMENT -->
      <a href="{{ route('appointment.index') }}"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('appointment.index*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
        <span class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('appointment.index*') ? 'opacity-100' : 'opacity-0' }}"></span>
        <i class="fa-regular fa-calendar text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Appointment</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointment</span>
      </a>

      <!-- RECORD -->
      <a href="{{ route('record') }}"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('record*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
        <span class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('record*') ? 'opacity-100' : 'opacity-0' }}"></span>
        <i class="fa-regular fa-folder-open text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Record</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Record</span>
      </a>

      <!-- ABOUT US -->
      <a href="{{ route('about.us') }}"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('about.us*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
        <span class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('about.us*') ? 'opacity-100' : 'opacity-0' }}"></span>
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

    <!-- DARK MODE TOGGLE -->
    <button id="themeToggle"
      class="sidebar-link relative flex items-center
            w-full px-3 py-2.5 rounded-xl
            bg-[#7B6CF6] text-[#F4F4F4]
            transition-all duration-200 hover:scale-105"
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
<main
  id="mainContent"
  class="pt-[100px] px-6 py-6 fade-up min-h-screen"
  >

  <div class="max-w-7xl mt-4 mx-auto">

    <!-- BREADCRUMB -->
    <div class="text-sm mb-4 font-medium fade-up">
      <span class="text-gray-400">User</span>
      <span class="mx-1 text-gray-400">&gt;</span>
      <span class="text-[#8B0000] font-semibold">Homepage</span>
    </div>

    <!-- HERO CARD -->
    <div class="bg-gradient-to-r from-[#8B0000] to-[#660000]
            text-[#F4F4F4] rounded-2xl p-10
            flex justify-between items-center
            mb-6 fade-up relative overflow-visible">

      <div>
        <i class="fa-solid fa-sun text-yellow-400 text-sm"></i>
        <p class="text-sm text-[#F4F4F4] mb-1" id="greetingText">Good morning</p>
        <h1 class="text-5xl font-extrabold mt-1 mb-2 text-[#F4F4F4] fade-up">
          <span class="bg-gradient-to-r from-[#F4F4F4] to-[#FFD700] bg-clip-text text-transparent">
        Welcome, {{ ucwords(strtolower($patient->name)) }}!
      </span>

      <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
        </h1>
        <h2 class="text-sm font-normal mb-8 text-[#F4F4F4] fade-up">
          Healthy teeth start with one appointment. Let's keep your smile at its best.
        </h2>

        <button
          class="btn btn-soft shimmer-btn
                px-6 py-3 rounded-2xl
                border-none text-base font-semibold
                text-[#F4F4F4]
                transition-transform duration-300
                hover:-translate-y-0.5
                hover:shadow-[0_0_10px_rgba(255,255,255,0.4)]">

          <a href="{{ route('book.appointment') }}" class="flex items-center gap-2">
            <i class="fa-solid fa-calendar-plus"></i>
            Book Appointment
          </a>
        </button>
      </div>

      <!-- IMAGE (ABSOLUTE) -->
      <div class="absolute right-7 top-1/2 -translate-y-1/2 pointer-events-none">
        <img
          src="images/home-tooth.png"
          alt="Tooth Icon"
          class="float-slow w-[250px] max-w-none
                drop-shadow-[0_14px_26px_rgba(255,255,255,0.25)]"
        />
      </div>

    </div>

    <!-- UPCOMING SCHEDULE CARD -->
    <div class="mb-6 fade-up">
      <div id="upcomingScheduleContainer">
        <!-- Injected by JS -->
      </div>
    </div>

      <!-- PROFILE + CALENDAR SECTION -->
    <section class="max-w-7xl mx-auto mb-10">
      <div class="flex flex-col md:flex-row gap-6">

        <!-- LEFT COLUMN: Profile + Request Docs -->
        <div class="md:w-[600px] flex-shrink-0 flex flex-col gap-5">

          <!-- PROFILE CARD -->
          <div id="profileSkeletonContainer" class="rounded-2xl overflow-hidden shadow-lg">
            <!-- content will be injected by JS -->
          </div>

          <!-- REQUEST DOCUMENTS -->
          <div class="bg-white rounded-2xl shadow-lg p-5">
            <div class="flex items-center gap-4 mb-4">
              <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-folder text-[#8B0000] text-lg"></i>
              </div>
              <h3 class="font-extrabold text-lg text-[#333333]">Request Documents</h3>
            </div>
            <div id="requestDocsContainer" class="space-y-3"></div>
          </div>

        </div>

        <!-- RIGHT COLUMN: Calendar -->
        <div class="flex-1 flex flex-col gap-2">
          <h2 class="text-xl font-extrabold text-[#8B0000] mb-3">Upcoming Schedule</h2>
          <div id="calendarSkeletonContainer"
            class="bg-white border shadow-sm rounded-2xl p-6 h-[420px] w-full">
          </div>
        </div>

      </div>
    </section>

    <!-- DENTAL RECORDS SECTION -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 fade-up overflow-hidden">
      <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b">
        <h2 class="text-xl font-extrabold text-[#8B0000]">My Dental Records</h2>
        <div id="viewAllContainer" class="hidden">
          <a href="{{ route('record') }}"
            class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#8B0000]
                   border border-[#8B0000] px-4 py-1.5 rounded-lg hover:bg-[#8B0000] hover:text-white transition-colors duration-200">
            View Full Record <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
        </div>
      </div>
      <div class="px-6 py-4">
        <div id="recordsInnerContainer" class="space-y-3"></div>
      </div>
    </div>

<!-- REQUEST CLEARANCE MODAL -->
<dialog id="dentalClearanceModal" class="modal">
  <form
    id="clearanceRequestForm"
    method="POST"
    action="{{ route('document.requests.store') }}"
    class="modal-box rounded-2xl bg-[#F4F4F4] relative"
    novalidate 
  >
    @csrf

    <!-- MINI WARNING -->
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

    <!-- TYPE -->
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

    <!-- PURPOSE -->
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
        <option value= "Employment Requirement">Employment Requirement</option>
        <option value="Academic Requirement">Academic Requirement</option>
      </select>
    </div>

    <!-- ACTIONS -->
    <div class="modal-action flex justify-between">
      <button type="button"
        onclick="dentalClearanceModal.close()"
        class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">
        Back
      </button>

      <button type="button"
        onclick="validateAndConfirm(
        'clearanceRequestForm',
        'Submit Dental Clearance request?',
        'dentalClearanceModal'
        )"
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
    novalidate
  >
    @csrf

    <!-- MINI WARNING -->
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

    <!-- TYPE -->
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

    <!-- PURPOSE -->
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

    <!-- ACTIONS -->
    <div class="modal-action flex justify-between">
      <button type="button"
        onclick="dentalHealthRecordModal.close()"
        class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">
        Back
      </button>

      <button type="button"
        onclick="validateHealthRecord(
        'healthRecordRequestForm',
        'Submit Dental Health Record request?',
        'dentalHealthRecordModal'
        )"
        class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">
        Save
        </button>
      </div>
    </form>
  </dialog>

  </div>
</main>

<!-- CONFIRM SAVE MODAL -->
<dialog id="confirmSaveModal" class="modal">
  <div class="modal-box rounded-2xl bg-[#F4F4F4]">
    <h3 class="font-bold text-lg mb-2">Confirm</h3>
    <p id="confirmSaveText" class="mb-6">Are you sure?</p>
    <div class="modal-action flex justify-between">
      <button onclick="confirmSaveModal.close()" class="btn">Cancel</button>
      <button onclick="submitConfirmedForm()" class="btn btn-error text-[#F4F4F4]">Yes, Submit</button>
    </div>
  </div>
</dialog>

<!-- SUBMITTED INFO MODAL -->
<dialog id="submittedInfoModal" class="modal">
  <div class="modal-box rounded-2xl bg-[#F4F4F4]">
    <h3 class="font-bold text-lg mb-2">Submitted!</h3>
    <p>Your request has been submitted.</p>
    <div class="modal-action">
      <button onclick="submittedInfoModal.close()" class="btn btn-error text-[#F4F4F4]">OK</button>
    </div>
  </div>
</dialog>

  <!-- ========================= -->
  <!-- FETCH DENTAL RECORDS -->
  <!-- ========================= -->

<script>
// =========================
// DARK MODE TOGGLE
// =========================
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const html = document.documentElement;

// Load saved theme
const savedTheme = localStorage.getItem('theme') || 'light';
html.setAttribute('data-theme', savedTheme);
updateThemeIcon(savedTheme);

// Toggle on click
themeToggle.addEventListener('click', () => {
  const currentTheme = html.getAttribute('data-theme');
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';

  html.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
  updateThemeIcon(newTheme);
});

// Icon switch
function updateThemeIcon(theme) {
  if (theme === 'dark') {
    themeIcon.classList.remove('fa-moon');
    themeIcon.classList.add('fa-sun');
  } else {
    themeIcon.classList.remove('fa-sun');
    themeIcon.classList.add('fa-moon');
  }
}

let sidebarOpen = true; // expanded by default

function applyLayout(sidebarWidth) {
  const sidebar = document.getElementById('sidebar');
  const main = document.getElementById('mainContent');
  sidebar.style.width = sidebarWidth;
  main.style.marginLeft = sidebarWidth;
}

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const texts = document.querySelectorAll('.sidebar-text');
  const icon = document.getElementById('sidebarIcon');
  const toggleWrapper = document.getElementById('sidebarToggleWrapper');

  sidebarOpen = !sidebarOpen;

  if (sidebarOpen) {
    applyLayout('200px');
    sidebar.classList.remove('collapsed');
    sidebar.classList.add('expanded');
    texts.forEach(t => {
      t.classList.remove('opacity-0', 'w-0');
      t.classList.add('opacity-100');
    });
    toggleWrapper.classList.remove('justify-center');
    toggleWrapper.classList.add('justify-end');
    icon.classList.replace('fa-bars', 'fa-xmark');
  } else {
    applyLayout('72px');
    sidebar.classList.remove('expanded');
    sidebar.classList.add('collapsed');
    texts.forEach(t => {
      t.classList.add('opacity-0', 'w-0');
      t.classList.remove('opacity-100');
    });
    toggleWrapper.classList.remove('justify-end');
    toggleWrapper.classList.add('justify-center');
    icon.classList.replace('fa-xmark', 'fa-bars');
  }
}

  document.addEventListener('DOMContentLoaded', () => {
    sidebarOpen = true;
    applyLayout('200px');
  });

  // Request Clearance Confirmation
  let _pendingFormId = null;
  let _pendingModalIdToClose = null;

  // Call this from Save buttons
  function openConfirm(formId, message, modalIdToClose) {
    _pendingFormId = formId;
    _pendingModalIdToClose = modalIdToClose || null;

    document.getElementById('confirmSaveText').textContent = message;
    confirmSaveModal.showModal();
  }

  function submitConfirmedForm() {
    // close confirm modal
    confirmSaveModal.close();

    // SUBMIT FIRST
    if (_pendingFormId) {
      submitFormAjax(_pendingFormId);
    }

    // close request modal
    if (_pendingModalIdToClose) {
      const reqModal = document.getElementById(_pendingModalIdToClose);
      if (reqModal) reqModal.close();
    }

    // reset AFTER submit
    _pendingFormId = null;
    _pendingModalIdToClose = null;

    // optional UX modal (will be interrupted by redirect anyway)
    submittedInfoModal.showModal();
  }

    // validate submit request
function validateAndConfirm(formId, message, modalId) {
  const form = document.getElementById(formId);
  const warn = document.getElementById('clearanceWarning');
  warn.classList.add('hidden');
  if (!form.checkValidity()) { warn.classList.remove('hidden'); return; }
  openConfirm(formId, message, modalId);
}

function validateHealthRecord(formId, message, modalId) {
  const form = document.getElementById(formId);
  const warn = document.getElementById('healthRecordWarning');
  warn.classList.add('hidden');
  if (!form.checkValidity()) { warn.classList.remove('hidden'); return; }
  openConfirm(formId, message, modalId);
}

  // Skeleton Loading
  document.addEventListener("DOMContentLoaded", () => {
    
     document.querySelectorAll('#clearanceRequestForm select')
    .forEach(select => {
      select.addEventListener('change', () => {
        document.getElementById('clearanceWarning').classList.add('hidden');
      });
    });

  document.querySelectorAll('#healthRecordRequestForm select')
    .forEach(select => {
      select.addEventListener('change', () => {
        document.getElementById('healthRecordWarning').classList.add('hidden');
      });
    });

    // Show all skeletons first
    showSkeletons();

    // Simulate fetching data after 2 seconds
    setTimeout(() => {
      renderProfile();
      loadCalendar();
      renderRequestDocs();
      renderUpcomingSchedule();

      renderRecords();
    }, 2000);

  });

  // =========================
  // Functions
  // =========================
  function showSkeletons() {
    const viewAll = document.getElementById("viewAllContainer");
    if (viewAll) viewAll.classList.add('hidden');

    document.getElementById("profileSkeletonContainer").innerHTML = `
      <div class="bg-white rounded-2xl overflow-hidden shadow-lg animate-pulse">
        <div class="bg-gray-200 h-24 w-full"></div>
        <div class="p-4 space-y-3">
          ${[1,2,3,4].map(() => `<div class="flex gap-4"><div class="h-3 w-24 skeleton"></div><div class="h-3 w-40 skeleton"></div></div>`).join('')}
        </div>
      </div>
    `;

    document.getElementById("upcomingScheduleContainer").innerHTML = `
      <div class="bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center gap-6 animate-pulse">
        <div class="w-12 h-12 skeleton rounded-xl"></div>
        <div class="flex-1 grid grid-cols-3 gap-4">
          ${[1,2,3].map(() => `<div class="space-y-2"><div class="h-2 w-20 skeleton"></div><div class="h-4 w-32 skeleton"></div></div>`).join('')}
        </div>
        <div class="h-7 w-24 skeleton rounded-full"></div>
      </div>
    `;

    document.getElementById("calendarSkeletonContainer").innerHTML = `
      <div class="animate-pulse space-y-4">
        <div class="h-6 w-32 skeleton mx-auto"></div>
        <div class="grid grid-cols-7 gap-2">
          ${Array(35).fill('<div class="h-9 skeleton rounded-lg"></div>').join('')}
        </div>
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
        </div>
      `).join('')}
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
          </div>
        `).join('')}
      </div>
    `;
  }

  function renderProfile() {
    document.getElementById("profileSkeletonContainer").innerHTML = `
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm fade-up">
        <div class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-5 pt-6 pb-6 text-[#F4F4F4] flex items-center gap-4">
          <div class="avatar flex-shrink-0">
            <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-white/30">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=660000&color=FFFFFF&rounded=true&size=128" alt="Profile" />
            </div>
          </div>
          <div>
            <p class="font-bold text-base leading-tight">{{ isset($patient->name) ? ucwords(strtolower($patient->name)) : 'Guest' }}</p>
            <p class="text-xs text-[#F4F4F4]/70 mb-2">Patient</p>
            <span class="inline-block bg-[#FFD700] text-[#660000] text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">
              {{ $patient->patient_id ?? 'N/A' }}
            </span>
          </div>
        </div>
        <div class="mx-0 bg-white divide-y divide-gray-100 text-sm rounded-b-2xl overflow-hidden">
          <div class="flex px-4 py-3 gap-4">
            <span class="text-[#9CA3AF] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Date of Birth</span>
            <span class="font-semibold text-[#333333]">{{ $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('F d, Y') : '-' }}</span>
          </div>
          <div class="flex px-4 py-3 gap-4">
            <span class="text-[#9CA3AF] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Gender</span>
            <span class="font-semibold text-[#333333]">{{ $patient->gender ?? '-' }}</span>
          </div>
          <div class="flex px-4 py-3 gap-4">
            <span class="text-[#9CA3AF] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Address</span>
            <span class="font-semibold text-[#333333]">{{ $patient->address ?? '-' }}</span>
          </div>
          <div class="flex px-4 py-3 gap-4">
            <span class="text-[#9CA3AF] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Contact</span>
            <div>
              <p class="font-semibold text-[#333333]">{{ $patient->phone ?? '-' }}</p>
            </div>
          </div>
          <div class="flex px-4 py-3 gap-4">
            <span class="text-[#9CA3AF] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">Email</span>
            <p class="font-semibold text-[#333333]">{{ $patient->email ?? '-' }}</p>
          </div>
        </div>
      </div>
    `;
  }

  function renderRequestDocs() {
    document.getElementById("requestDocsContainer").innerHTML = `
      <a onclick="dentalHealthRecordModal.showModal()"
        class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
        <div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('images/dental-health-record.png') }}" class="w-7 h-6"/>
        </div>
        <div>
          <p class="font-bold text-sm text-[#333333]">Request Dental Health Record</p>
          <p class="text-xs text-[#9CA3AF]">All Dental Records • Medical Record • Diagnosis & Treatments</p>
        </div>
      </a>
      <a onclick="dentalClearanceModal.showModal()"
        class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
        <div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('images/dental-clearance.png') }}" class="w-7 h-6"/>
        </div>
        <div>
          <p class="font-bold text-sm text-[#333333]">Request Dental Clearance</p>
          <p class="text-xs text-[#9CA3AF]">Dental Clearance • Annual Dental Clearance</p>
        </div>
      </a>
    `;
  }

  function renderUpcomingSchedule() {
  const container = document.getElementById("upcomingScheduleContainer");
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
            {{ \Carbon\Carbon::parse($upcomingAppointment->appointment_date)->format('F d, Y') }}
            &bull;
            {{ $upcomingAppointment->appointment_time }}
          </p>
        </div>
        <div>
          <p class="text-[10px] uppercase font-semibold text-gray-400 mb-0.5">Dentist</p>
          <p class="font-bold text-sm text-[#333333]">{{ $upcomingAppointment->dentist_name ?? 'TBA' }}</p>
        </div>
      </div>
      <div class="flex-shrink-0">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
          {{ ($upcomingAppointment->status ?? '') === 'Confirmed'
            ? 'bg-green-50 text-green-600 border border-green-200'
            : 'bg-yellow-50 text-yellow-600 border border-yellow-200' }}">
          <span class="w-1.5 h-1.5 rounded-full
            {{ ($upcomingAppointment->status ?? '') === 'Confirmed' ? 'bg-green-500' : 'bg-yellow-500' }}">
          </span>
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
      <p class="text-sm text-[#9CA3AF]">No upcoming appointments.
        <a href="{{ route('book.appointment') }}" class="text-[#8B0000] font-semibold hover:underline">Book one now</a>.
      </p>
    </div>
  `;
  @endif
}

  function showCalendarSkeleton() {
  document.getElementById("calendarSkeletonContainer").innerHTML = `
    <div class="grid grid-cols-7 gap-2 animate-pulse">
      ${Array(35).fill('<div class="h-8 w-8 skeleton rounded"></div>').join("")}
    </div>
  `;
}

function loadCalendar() {
  document.getElementById("calendarSkeletonContainer").innerHTML = `
    <calendar-date class="cally w-full h-full flex flex-col p-2 fade-up">
      <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
        <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
      </svg>

      <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
        <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
      </svg>

      <calendar-month class="w-full flex-1"></calendar-month>
    </calendar-date>
  `;
}

  // Dental Records Rendering
  function renderRecords() {
    const container = document.getElementById("recordsInnerContainer");
    const viewAll = document.getElementById("viewAllContainer");

    @if(isset($records) && $records->count() > 0)
      container.innerHTML = `
        <div class="relative">
          <div class="absolute left-[10px] top-3 bottom-3 w-px bg-[#8B0000]/30"></div>
          <div class="space-y-3 pl-10">
            @foreach($records as $record)
            <div class="relative flex justify-between items-center border rounded-xl px-6 py-4 bg-white hover:shadow-sm transition fade-up">
              <div class="absolute -left-[26px] w-4 h-4 rounded-full bg-[#8B0000] border-2 border-white ring-2 ring-[#8B0000]/20"></div>
              <div>
                <p class="font-semibold text-[#8B0000] text-sm">{{ $record->service_type }}</p>
                <p class="text-xs text-[#9CA3AF] mt-0.5">
                  {{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}
                  &bull;
                  {{ $record->appointment_time }}
                </p>
              </div>
              <button
                class="flex items-center gap-1.5 bg-[#8B0000] hover:bg-[#660000] text-[#F4F4F4] text-xs font-semibold px-4 py-2 rounded-lg transition-colors duration-200">
                <i class="fa-regular fa-eye text-xs"></i> Details
              </button>
            </div>
            @endforeach
          </div>
        </div>
      `;
      viewAll.classList.remove('hidden');
    @else
      container.innerHTML = `
        <div class="flex flex-col items-center justify-center py-12 text-center space-y-4 fade-in">
          <div class="w-24 h-24 flex items-center justify-center pulse-icon">
            <img src="{{ asset('images/nodental-record.png') }}" class="w-24 h-24">
          </div>
          <p class="text-xl font-bold text-[#8B0000]">Nothing here yet…</p>
          <p class="text-sm text-[#ADADAD]">Time to book that first visit.</p>
          <button>
            <a href="{{ route('book.appointment') }}"
              class="btn btn-soft bg-[#8B0000] font-mediumhover:bg-[#333333] border-none text-sm rounded-2xl text-[#F4F4F4] px-6">
              Book Appointment
            </a>
          </button>
        </div>
      `;
      viewAll.classList.add('hidden');
    @endif
  }

  // function showRecordsError() {
  //   const container = document.getElementById("recordsInnerContainer");
  //   document.getElementById("viewAllContainer").style.display = "none";
  //   container.innerHTML = `
  //     <div class="flex flex-col items-center justify-center py-14 text-center space-y-5 fade-in">
  //       <img src="images/error-records.png" alt="Error" class="w-24 h-24">
  //       <p class="text-2xl font-extrabold text-[#8B0000]">Oops! Something went wrong</p>
  //       <p class="text-sm text-[#ADADAD] max-w-sm">Unable to fetch your records.</p>
  //     </div>
  //   `;
  // }

  // Helpers
  // function viewRecord(id) { window.location.href = `record.php?id=${id}`; }
  // function formatDate(dateStr) { return new Date(dateStr).toLocaleDateString(); }
  // function formatTime(timeStr) { return timeStr.substring(0,5); }

  function submitFormAjax(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        submittedInfoModal.showModal();
        form.reset();
      }
    })
    .catch(() => {
      alert('Something went wrong. Please try again.');
    });
  }

  // Dynamic greeting
  (function() {
    const hour = new Date().getHours();
    let greeting = 'Good morning';
    if (hour >= 12 && hour < 18) greeting = 'Good afternoon';
    else if (hour >= 18) greeting = 'Good evening';
    const el = document.getElementById('greetingText');
    if (el) el.textContent = greeting;
  })();

  // NOTIFICATION
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

    // Toggle when clicking bell
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      isOpen ? closeMenu() : openMenu();
    });

    // Keep open when clicking inside menu
    menu.addEventListener("click", (e) => {
      e.stopPropagation();
    });

    // Close when clicking outside
    document.addEventListener("click", () => {
      if (isOpen) closeMenu();
    });

    // Close on ESC
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && isOpen) closeMenu();
    });

    // Start closed
    closeMenu();
  });

</script>
</body>
</html>