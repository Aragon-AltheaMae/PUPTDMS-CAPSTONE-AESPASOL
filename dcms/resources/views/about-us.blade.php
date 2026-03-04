<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PUP Taguig Dental Clinic | About Us</title>
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

    /* Custom FAQ */
    .faq-content {
      max-height: 0;
      overflow: hidden;
      opacity: 0;
      transition: max-height 0.5s ease, opacity 0.5s ease;
    }

    .faq-item.open .faq-content {
      max-height: 500px;
      /* adjust to content */
      opacity: 1;
    }

    /* Fade-up animation */
    .fade-up {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-up.show {
      opacity: 1;
      transform: translateY(0);
    }

    @keyframes floatVerySlow {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-12px);
      }
    }

    .float-bg {
      animation: floatVerySlow 14s ease-in-out infinite;
    }

    .float-delay {
      animation-delay: 4s;
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

    .shimmer {
      background: linear-gradient(110deg,
          rgba(255, 255, 255, 0.05) 25%,
          rgba(255, 255, 255, 0.22) 37%,
          rgba(255, 255, 255, 0.05) 63%);
      background-size: 200% 100%;
      animation: shimmer 10s linear infinite;
    }

    /* === BACKGROUND BLOOBS === */
    @keyframes blobFloat {
      0% {
        transform: translate(0, 0) scale(1);
      }

      50% {
        transform: translate(40px, -30px) scale(1.08);
      }

      100% {
        transform: translate(0, 0) scale(1);
      }
    }

    @keyframes blobPulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.15);
      }
    }

    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(40px);
      animation:
        blobFloat 28s ease-in-out infinite,
        blobPulse 6s ease-in-out infinite;
      pointer-events: none;
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
      transform: scale(0.95) !important;
      /* zoom out */
      pointer-events: none !important;
    }

    /* DARK MODE */
    [data-theme="dark"] body {
      background-color: #111827;
      /* slate-900 */
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

    #sidebar.collapsed .nav-section-label {
      display: none;
    }

    #sidebar.expanded .nav-section-label {
      display: block;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 10px;
      padding-right: 0;
    }

    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    /* Active nav glow */
    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, 0.45);
    }
  </style>
</head>

<body class="relative text-[#333333] bg-[#F8F8F8] overflow-x-hidden">
  <div id="bg-blobs" class="fixed inset-0 z-0 pointer-events-none overflow-hidden">

    <div class="blob blob-slow
    w-[460px] h-[460px]
    top-[-120px] left-[-120px]"
      style="background: radial-gradient(circle,
      rgba(139,0,0,0.45) 0%,
      rgba(139,0,0,0.25) 45%,
      rgba(139,0,0,0.08) 65%,
      transparent 75%);
    ">
    </div>

    <div class="blob blob-fast
    w-[380px] h-[380px]
    top-[35%] right-[-140px]"
      style="background: radial-gradient(circle,
      rgba(255,215,0,0.4) 0%,
      rgba(255,215,0,0.22) 45%,
      rgba(255,215,0,0.07) 65%,
      transparent 75%);
    ">
    </div>

    <div class="blob
    w-[340px] h-[340px]
    bottom-[15%] left-[10%]"
      style="background: radial-gradient(circle,
      rgba(102,0,0,0.45) 0%,
      rgba(102,0,0,0.25) 45%,
      rgba(102,0,0,0.07) 65%,
      transparent 75%);
    ">
    </div>

    <div class="blob blob-slow
    w-[280px] h-[280px]
    bottom-[-120px] right-[20%]"
      style="background: radial-gradient(circle,
      rgba(255,215,0,0.65) 0%,
      rgba(255,215,0,0.4) 45%,
      rgba(255,215,0,0.1) 65%,
      transparent 75%);
    ">
    </div>
  </div>

  <!-- <div class="relative z-10"> -->
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
        <a href="{{ route('homepage') }}">
          <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
        </a>
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
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <!-- NAVIGATION LABEL -->
      <div class="nav-section-label px-4 mb-6">Navigation</div>

      <!-- MENU -->
      <nav class="space-y-2 px-3 text-gray-600">

        <!-- HOME -->
        <a href="{{ route('homepage') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('homepage') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('homepage') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-house text-base w-5 "></i>
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
          <i class="fa-regular fa-calendar text-base w-5 "></i>
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
          <i class="fa-regular fa-folder-open text-base w-5 "></i>
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
          <i class="fa-solid fa-circle-info text-base w-5 "></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">About Us</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">About Us</span>
        </a>

      </nav>
    </div>

    <!-- BOTTOM -->
    <div class="px-3 pb-5 space-y-2">

      <a href="#"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 text-gray-500">
        <i class="fa-regular fa-circle-question text-base w-5 "></i>
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
        <i id="themeIcon" class="fa-regular fa-moon text-base w-5 "></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Dark Mode</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dark Mode</span>
      </button>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="sidebar-link w-full relative flex items-center px-3 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200">
          <i class="fa-solid fa-right-from-bracket text-base w-5 "></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Log Out</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log Out</span>
        </button>
      </form>

    </div>
  </aside>

  <!-- ================= MAIN CONTENT ================= -->
  <!-- CONTENT -->
  <main
    id="mainContent"
    class="pt-[100px]
         transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]
         min-h-screen">

    <!-- BREADCRUMB -->
    <div class="text-sm ml-6 mb-4 font-medium fade-up">
      <span class="text-gray-700">User</span>
      <span class="mx-1 text-gray-700">&gt;</span>
      <span class="text-[#8B0000] font-semibold">About Us</span>
    </div>

    <!-- FULL-WIDTH BANNER (NOT padded) -->
    <section class="relative w-full py-24 text-center fade-up">
      <img
        src="{{ asset('images/PUP TAGUIG CAMPUS.jpg') }}"
        class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none" />
      <h2 class="relative z-10 font-extrabold text-6xl text-[#8B0000]">
        About Us
      </h2>
    </section>

    <!-- CENTERED CONTENT -->
    <div class="max-w-5xl mx-auto w-full px-6 py-10">

      <p class="text-[#8B0000] text-lg leading-relaxed text-justify text-wrap mt-12 mb-24 fade-up">
        The Polytechnic University of the Philippines – Taguig Campus is committed to promoting the
        health and well-being of its academic community by providing free dental services to students,
        alumni, faculty, and staff. These services aim to support overall wellness and ensure access to
        basic dental care within the campus.
      </p>

      <!-- CARD -->
      <div class="relative overflow-hidden
        bg-gradient-to-br from-[#8B0000] to-[#660000]
        text-[#F4F4F4]
        rounded-2xl pl-6
        flex flex-wrap md:flex-nowrap items-center gap-4
        shadow-lg shadow-red-300
        fade-up">

        <!-- BACKGROUND CIRCLES (SOFT, AMBIENT) -->
        <div class="absolute -left-24 -top-20
            w-[300px] h-[300px]
            bg-[#FFD700]/15
            rounded-full blur-3xl
            float-bg pointer-events-none"></div>

        <div class="absolute left-1/3 top-6
            w-[220px] h-[220px]
            bg-white/10
            rounded-full blur-3xl
            float-bg float-delay pointer-events-none"></div>

        <div class="absolute right-10 -bottom-16
            w-[260px] h-[260px]
            bg-[#FFD700]/10
            rounded-full blur-3xl
            pointer-events-none"></div>

        <div class="absolute -right-20 top-1/2
            w-[340px] h-[340px]
            bg-white/10
            rounded-full blur-3xl
            pointer-events-none"></div>

        <!-- GLASS TEXT WITH SHIMMER -->
        <div class="relative z-10 shimmer
            bg-white/15 backdrop-blur-md
            rounded-xl p-6 ml-5 pl-12 pr-12
            border border-white/20
            shadow-lg
            font-normal text-xl leading-relaxed
            max-w-2xl">

          The dental clinic is headed by
          <span class="font-bold">Dr. Nelson P. Angeles</span>
          the campus dentist, who delivers professional, safe, and reliable dental care.
        </div>

        <!-- IMAGE -->
        <img
          src="images/Nelson-Angeles.png"
          alt="Dr. Nelson P. Angeles"
          class="relative z-10
               w-full max-w-sm
               h-auto
               object-contain
               drop-shadow-xl" />
      </div>

      <!-- FAQs Title -->
      <div class="text-center mt-36 mb-12 fade-up">
        <h3 class="font-extrabold text-5xl
                bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                bg-clip-text text-transparent">
          Frequently Asked Questions
        </h3>

        <p class="font-normal mt-4 text-[#660000] text-lg">
          Got questions? Here are quick answers about the PUP Taguig Dental Management System.
        </p>
      </div>

      <section class="max-w-5xl mx-auto mt-2 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#FFD700] p-1 fade-up">
        <div class="bg-white rounded-xl p-4">

          <!-- FAQ 1 -->
          <div id="faq1" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">Who can avail of the dental services at the University Dental Clinic?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq1-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              All students, alumni, faculty, and staff of the University are eligible for free dental services.
            </div>
          </div>

          <!-- FAQ 2 -->
          <div id="faq2" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">How do I book an appointment?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq2-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              You can book an appointment through the Dental Management System online portal.
            </div>
          </div>

          <!-- FAQ 3 -->
          <div id="faq3" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">Will the dentist prescribe medications during my visit?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq3-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              Yes, depending on your dental condition, the dentist may prescribe
              antibiotics, pain relievers, or other medications.
            </div>
          </div>

          <!-- FAQ 4 -->
          <div id="faq4" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">Can I make an appointment anytime?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq4-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              Appointments are subject to availability. Since the clinic has limited
              slots and only one dentist, early booking is recommended.
            </div>
          </div>

          <!-- FAQ 5 -->
          <div id="faq5" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">How can I cancel or reschedule my appointment?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq5-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              Appointments can be canceled or rescheduled through the Dental Management System
              or by contacting the clinic directly at least three (3) days before the scheduled appointment.
            </div>
          </div>

          <!-- FAQ 6 -->
          <div id="faq6" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">What happens if the University Dentist is unavailable on my scheduled day?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq6-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              If the dentist is unavailable, your confirmed schedule will be rescheduled to the next available slot.
            </div>
          </div>

          <!-- FAQ 7 -->
          <div id="faq7" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]"> What services are offered at the University Dental Clinic?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq7-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              The clinic provides basic dental check-ups, cleaning, fillings, extractions,
              oral health advice, and other preventive care services.
            </div>
          </div>

          <!-- FAQ 8 -->
          <div id="faq8" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">Is there a priority system for urgent dental cases?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq8-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              Yes, urgent cases may be given priority, but it depends on the daily schedule and the dentist’s discretion.
            </div>
          </div>

          <!-- FAQ 9 -->
          <div id="faq9" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">Are there any restrictions for certain treatments?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq9-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              Some advanced dental procedures may not be available due to the clinic’s resources.
              The dentist will provide guidance on alternatives if needed.
            </div>
          </div>

          <!-- FAQ 10 -->
          <div id="faq10" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
            <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
              aria-expanded="false" onclick="toggleFAQ(this)">
              <span>
                <span class="text-yellow-500 mr-2">•</span>
                <span class="text-[#8B0000]">Are follow-up appointments required?</span>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="faq10-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-normal rounded-b-lg">
              Some treatments may require follow-up visits. The dentist will advise if a follow-up is necessary.
            </div>
          </div>
      </section>

      <p class="text-[#8B0000] text-xl leading-relaxed text-justify text-wrap mt-10 fade-up">
        The PUPT Dental Management System was developed to manage records and appointments more effectively,
        ensuring an efficient dental service while supporting the University's commitment to quality and accessible care.
      </p>

      <!-- DEVELOPERS -->
      <section class="text-center text-2xl mt-12">
        <h3 class="font-extrabold text-[#8B0000] mb-4 fade-up">The Developers</h3>
        <div class="flex justify-center gap-6 fade-up">
          <img src="images/Althea-Aragon.png" alt="Althea Aragon" class="h-32 w-32 rounded-md shadow-lg border border-yellow-400 object-cover" />
          <img src="images/Grace-Lim.png" alt="Grace Lim" class="h-32 w-32 rounded-md border shadow-lg border-yellow-400 object-cover" />
          <img src="images/Hoshea-Lopez.png" alt="Hoshea Lopez" class="h-32 w-32 rounded-md shadow-lg border border-yellow-400 object-cover" />
          <img src="images/Rain-Romero.png" alt="Rain Romero" class="h-32 w-32 rounded-md shadow-lg border border-yellow-400 object-cover" />
        </div>
      </section>
    </div>
  </main>

  <script>
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

    function toggleFAQ(button) {
      const item = button.parentElement;
      const content = item.querySelector('.faq-content');

      if (item.classList.contains('open')) {
        content.style.maxHeight = 0;
        content.style.opacity = 0;
        item.classList.remove('open');
        button.setAttribute('aria-expanded', 'false');
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
        content.style.opacity = 1;
        item.classList.add('open');
        button.setAttribute('aria-expanded', 'true');
      }
    }

    /* ===============================
       FADE-UP ANIMATION OBSERVER
    =============================== */
    const fadeObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('show');
            fadeObserver.unobserve(entry.target); // optional: animate once
          }
        });
      }, {
        threshold: 0.15
      }
    );

    document.querySelectorAll('.fade-up').forEach(el => {
      fadeObserver.observe(el);
    });


    /* ===============================
       BLOB VISIBILITY OBSERVER
    =============================== */
    const blobs = document.getElementById('bg-blobs');
    const footer = document.querySelector('footer');

    const blobObserver = new IntersectionObserver(
      ([entry]) => {
        blobs.style.opacity = entry.isIntersecting ? '0' : '1';
      }, {
        threshold: 0.1
      }
    );
    blobObserver.observe(footer);
  </script>
  </div>
</body>

</html>