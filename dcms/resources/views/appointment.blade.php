<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointment</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + daisyUI CDN -->
  <script type="module" src="https://unpkg.com/cally"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css"
    rel="stylesheet"
    type="text/css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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

    /* Smooth underline animation */
    .tabs-bordered .tab {
      transition: color 0.5s ease, font-weight 0.5s ease;
    }

    .tabs-bordered .tab::after {
      transition: width 0.5s ease, left 0.5s ease;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.8s ease-out forwards;
    }

    .tabs-bordered .tab {
      border-bottom-color: #ADADAD !important;
    }

    .tabs-bordered .tab-active {
      border-bottom-color: #660000 !important;
    }

    .service-card {
      position: relative;
      overflow: hidden;
      transition: transform 0.45s ease, box-shadow 0.45s ease;
    }

    .service-card::before {
      content: "";
      position: absolute;
      inset: -12px;
      /* THIS is the “umuusbong” part */
      background: linear-gradient(135deg, #8B0000, #660000);
      opacity: 0;
      border-radius: 1.25rem;
      transition: opacity 0.45s ease;
      z-index: 0;
    }

    .service-card:hover::before {
      opacity: 1;
    }

    .service-card:hover {
      transform: scale(1.06);
      z-index: 20;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
    }

    /* Keep content above */
    .service-card>* {
      position: relative;
      z-index: 1;
    }

    /* Icon motion */
    .service-card img {
      transition: transform 0.45s ease;
    }

    .service-card:hover img {
      transform: translateX(-6px) scale(1.08);
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
      padding-left: 0;
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

<body class="bg-white text-[#333333] font-normal">

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
          class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-200 z-50
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
          <i id="sidebarIcon" class="fa-solid fa-bars text-base"></i>
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

  <!-- ================= MAIN CONTENT ================= -->
  <!-- CONTENT -->
  <main
    id="mainContent"
    class="pt-[100px] px-6 py-6 fade-up min-h-screen">

    <div class="max-w-7xl mt-4 mx-auto">

      <!-- BREADCRUMB -->
      <div class="text-sm mb-4 font-medium fade-up">
        <span class="text-gray-400">User</span>
        <span class="mx-1 text-gray-400">&gt;</span>
        <span class="text-[#8B0000] font-semibold">Appointment</span>
      </div>

      <!-- ===== CLINIC SCHEDULE CALENDAR ===== -->
      <section class="fade-up mb-14">
        <div id="calendarSkeletonContainer"
          class="bg-white border shadow-sm rounded-2xl p-6 mx-auto"
          style="max-width:700px; min-height:480px;">

          <div class="animate-pulse space-y-4">
            <div class="h-6 w-32 bg-gray-200 rounded mx-auto"></div>

            <div class="grid grid-cols-7 gap-2">
              @for($i = 0; $i < 35; $i++)
                <div class="h-9 bg-gray-200 rounded-lg"></div>
              @endfor
            </div>
          </div>
        </div>
    </section>

    <!-- ===== My Appointments ===== -->
    <section class="max-w-5xl mx-auto fade-up">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-bold text-[#660000]">My Appointments</h2>
        <button class="btn bg-red-400 hover:bg-red-500 text-[#F4F4F4]">
          <a href="{{ route('book.appointment') }}">+ Book Appointment</a>
        </button>
      </div>

      <div class="card bg-[#F4F4F4] shadow-sm">
        <div class="card-body">

          <!-- Tabs -->
          <div class="tabs tabs-bordered mb-6">
            <a id="futureTab"
              class="tab tab-active font-bold text-[#660000] cursor-pointer"
              onclick="showFuture()">
              Future Visits
            </a>

            <a id="pastTab"
              class="tab text-[#660000] cursor-pointer"
              onclick="showPast()">
              Past Visits
            </a>
          </div>

          <!-- ================= FUTURE VISITS ================= -->

          <!-- IF future_visits.count == 0 -->
          <div id="futureContent" class="text-center py-10 text-[#333333]">
            <img src="{{ asset('images/future-visit.png') }}"
              class="w-24 h-24 mx-auto mb-4"
              alt="No Upcoming Visits">

            <p class="text-lg font-semibold text-[#660000]">No Upcoming Visits</p>
            <p class="text-sm text-[#ADADAD]">You currently have no scheduled appointments.</p>
          </div>

          <!-- ================= PAST VISITS ================= -->
          <!-- Show only when Past Visits tab is active -->

          <!-- IF past_visits.count == 0 -->
          <div id="pastContent" class="text-center py-10 text-[#333333] hidden">
            <img src="{{ asset('images/past-visit.png') }}"
              class="w-24 h-24 mx-auto mb-4"
              alt="No Past Visits">

            <p class="text-lg font-semibold text-[#660000]">No Past Visits Yet</p>
            <p class="text-sm text-[#ADADAD]">Your completed appointments will appear here.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== Services Offered ===== -->
    <section class="max-w-6xl mx-auto mt-16 mb-4 fade-up">
      <h2 class="text-4xl font-bold bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                bg-clip-text text-transparent mb-6">
        Services Offered
      </h2>

      <!-- Container -->
      <div
        class="grid md:grid-cols-2 rounded-2xl overflow-hidden bg-[#8B0000]">

        <!-- Oral Check-Up -->
        <div class="service-card relative p-10 text-[#F4F4F4]
            border-b border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">Oral Check-Up</h3>
          <p class="text-sm  max-w-xs">
            Routine oral examination • Dental consultation
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/oral-checkup.png') }}" class="absolute right-6 inset-y-0 my-auto w-28"
            alt="Oral Checkup" />
        </div>

        <!-- Dental Cleaning -->
        <div class="service-card relative p-10 text-[#F4F4F4]
            border-b border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">Dental Cleaning</h3>
          <p class="text-sm  max-w-xs">
            Oral hygiene treatment • Removing surface buildup
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/dental-cleaning.png') }}" class="absolute right-6 inset-y-0 my-auto w-28"
            alt="Dental Cleaning" />
        </div>

        <!-- Dental Restoration -->
        <div class="service-card relative p-10 text-[#F4F4F4]
            border-b border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">
            Dental Restoration & Prosthesis
          </h3>
          <p class="text-sm  max-w-xs">
            Repairs/replaces damaged teeth • Fillings • Crowns • Inlay • etc.
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/restoration-prosthesis.png') }}" class="absolute right-6 inset-y-0 my-auto w-28"
            alt="Restoration & Prosthesis" />
        </div>

        <!-- Dental Surgery -->
        <div class="service-card relative p-10 text-[#F4F4F4]
          border-b border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">Dental Surgery</h3>
          <p class="text-sm  max-w-xs">
            Treating dental issues surgically • Extraction • Supernumerary • etc.
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/dental-surgery.png') }}" class="absolute right-6 inset-y-0 my-auto w-28"
            alt="Dental Surgery" />
        </div>
      </div>
    </section>

    </div>
  </main>

  <!-- modal for one appointment only -->
  <dialog id="activeAppointmentModal" class="modal">
  <!-- Clicking outside closes by default for <dialog>, we will prevent that in JS -->
  <div class="modal-box swal-card rounded-2xl bg-white text-center shadow-2xl w-[min(92vw,420px)]">

    <!-- Icon bubble -->
    <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#FFF0F0] flex items-center justify-center">
      <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-2xl"></i>
    </div>

    <h3 class="text-xl font-extrabold text-[#8B0000] mb-2">
      One Appointment at a Time
    </h3>

    <p class="text-sm text-[#555] mb-6 leading-relaxed">
      {{ session('activeAppointmentMsg') ?? "You already have an active appointment. Please wait until it is completed before booking another one." }}
    </p>

    <div class="flex items-center justify-center gap-3">
      <!-- View appointment -->
      <a href="{{ route('appointment.index') }}"
         class="btn border-none bg-[#8B0000] hover:bg-[#660000] text-white rounded-xl px-5">
        <i class="fa-regular fa-calendar-check"></i>
        View My Appointment
      </a>

      <!-- Close -->
      <button type="button"
              id="closeActiveApptModalBtn"
              class="btn btn-ghost rounded-xl px-6">
        Close
      </button>
    </div>
  </div>
</dialog>

  @if(session('activeAppointmentModal'))
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const modal = document.getElementById("activeAppointmentModal");
      const closeBtn = document.getElementById("closeActiveApptModalBtn");

      if (!modal) return;

      // Open it
      modal.showModal();

      // Prevent closing via backdrop click (click outside)
      modal.addEventListener('click', (e) => {
        const box = modal.querySelector('.modal-box');
        if (!box) return;
        const clickedOutside = !box.contains(e.target);
        if (clickedOutside) e.preventDefault(); // keep open
      });

      // Prevent closing via ESC
      modal.addEventListener('cancel', (e) => {
        e.preventDefault();
      });

      // Close button
      if (closeBtn) {
        closeBtn.addEventListener("click", () => modal.close());
      }
    });
  </script>
  @endif


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

    function showFuture() {
      document.getElementById("futureTab").classList.add("tab-active", "font-bold", "text-[#8B0000]");
      document.getElementById("pastTab").classList.remove("tab-active", "font-bold", "text-[#8B0000]");

      document.getElementById("futureContent").classList.remove("hidden");
      document.getElementById("pastContent").classList.add("hidden");
    }

    function showPast() {
      document.getElementById("pastTab").classList.add("tab-active", "font-bold", "text-[#8B0000]");
      document.getElementById("futureTab").classList.remove("tab-active", "font-bold", "text-[#8B0000]");

      document.getElementById("pastContent").classList.remove("hidden");
      document.getElementById("futureContent").classList.add("hidden");
    }

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

    function loadCalendar() {
      // ── Data from Blade / PHP ──────────────────────────────
      const MAX_PER_DAY = 5;

      const myAppointments = {
        @if(isset($appointments) && $appointments->count() > 0)
        @foreach($appointments as $appt)
        "{{ \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d') }}": "{{ addslashes($appt->service_type) }} • {{ $appt->appointment_time }}",
        @endforeach
        @endif
      };

      const apptCounts = {
        @if(isset($appointmentCountsPerDay) && count($appointmentCountsPerDay) > 0)
          @foreach($appointmentCountsPerDay as $date => $count)
            "{{ $date }}": {{ $count }},
          @endforeach
        @endif
      };

      const unavailableDates = [
        @foreach(($unavailableDates ?? []) as $d)
        "{{ $d }}",
        @endforeach
      ];

      // ✅ ALL holidays from PHP (5 years)
      const allHolidays = {
        @foreach(($philippineHolidays ?? []) as $date => $name)
        "{{ $date }}": "{{ addslashes($name) }}",
        @endforeach
      };

      // ── State ──────────────────────────────────────────────
      const today = new Date();
      let currentYear = today.getFullYear();
      let currentMonth = today.getMonth();

      function pad(n) {
        return String(n).padStart(2, '0');
      }

      // Sunday = 0, Saturday = 6
      function isWeekend(year, month, day) {
        const dow = new Date(year, month, day).getDay();
        return dow === 0 || dow === 6;
      }

      // ✅ Filter holidays for the displayed year/month
      function getHolidaysForMonth(year, month) {
        const filtered = {};
        Object.keys(allHolidays).forEach(dateStr => {
          const [y, m] = dateStr.split('-').map(Number);
          if (y === year && m === month + 1) {
            filtered[dateStr] = allHolidays[dateStr];
          }
        });
        return filtered;
      }

      // ── Main render ────────────────────────────────────────
      function renderCalendar(year, month) {
        const monthNames = ["January", "February", "March", "April", "May", "June",
          "July", "August", "September", "October", "November", "December"
        ];

        // Sunday-first day labels
        const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

        const firstDow = new Date(year, month, 1).getDay(); // 0=Sun, 6=Sat
        const totalDays = new Date(year, month + 1, 0).getDate();

        // Sunday-based: no offset adjustment needed
        const leadingEmpties = firstDow;

        // ✅ Get holidays for THIS specific month/year
        const holidays = getHolidaysForMonth(year, month);

        let cells = '';

        // Leading empty cells
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

          // ── Styling ────────────────────────────────────────
          let bgClass = '';
          let textClass = 'text-[#333333]';
          let ringClass = '';
          let dotHtml = '';
          let tooltipTxt = '';

          if (isToday) {
            bgClass = 'bg-[#8B0000]';
            textClass = 'text-white font-extrabold';
            ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
          } else if (holiday) {
            bgClass = 'bg-amber-50 hover:bg-amber-100';
            textClass = 'text-amber-700 font-semibold';
          } else if (isUnavail) {
            bgClass = '';
            textClass = 'text-gray-300';
          } else {
            bgClass = 'hover:bg-[#FFF0F0]';
          }

          // ── Dots ───────────────────────────────────────────

          // My appointment (green dot)
          if (myAppt) {
            const dotColor = isToday ? 'bg-white' : 'bg-[#008440]';
            dotHtml += `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ${dotColor}"></span>`;
            tooltipTxt = `<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>${myAppt}`;
          }

          // Full schedule (red dot)
          if (isFull && !myAppt && !isUnavail && !holiday) {
            dotHtml += `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
            tooltipTxt = `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked (${count} appointments)`;
          }

          // Holiday
          if (holiday && !myAppt) {
            dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-amber-400"></span>`;
            tooltipTxt = `<i class="fa-solid fa-star mr-1 text-amber-300"></i>${holiday}`;
          }

          // Weekend / unavailable
          if (isUnavail && !holiday && !myAppt) {
            tooltipTxt = weekend ?
              `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed` :
              `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
          }

          // ── Tooltip ────────────────────────────────────────
          const tooltipHtml = tooltipTxt ? `
        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50
                    bg-[#1a1a1a] text-white text-[11px] font-medium
                    px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl
                    opacity-0 group-hover:opacity-100 pointer-events-none
                    transition-opacity duration-200">
          ${tooltipTxt}
          <div class="absolute top-full left-1/2 -translate-x-1/2
                      border-4 border-transparent border-t-[#1a1a1a]"></div>
        </div>` : '';

          cells += `
        <div class="relative group flex items-center justify-center">
          ${tooltipHtml}
          <div class="relative w-9 h-9 flex items-center justify-center
                      text-sm rounded-full transition-all duration-150
                      ${bgClass} ${textClass} ${ringClass} cursor-default">
            ${d}
            ${dotHtml}
          </div>
        </div>`;
        }

        // ── Day labels ─────────────────────────────────────
        const headerHtml = dayLabels.map((l, i) => {
          const labelColor = (i === 0 || i === 6) ? 'text-[#8B0000]/40' : 'text-[#9CA3AF]';
          return `<div class="text-center text-[10px] font-bold ${labelColor} uppercase tracking-widest">${l}</div>`;
        }).join('');

        // ── Render ─────────────────────────────────────────
        document.getElementById("calendarSkeletonContainer").innerHTML = `
        <div class="h-full flex flex-col select-none">

        <div class="flex items-center justify-center gap-2 mb-3">
          <i class="fa-regular fa-calendar-check text-[#333333] text-xl"></i>
          <h2 class="text-xl font-extrabold text-[#333333]">Dental Clinic Schedule</h2>
        </div>
        <hr class="border-t border-gray-200 mb-4">

          <!-- Month / Year header -->
          <div class="flex items-center justify-between mt-6 mb-5">
            <button onclick="changeMonth(-1)"
              class="w-8 h-8 flex items-center justify-center rounded-full
                    hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
              <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <div class="text-center">
              <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
              <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
            </div>
            <button onclick="changeMonth(1)"
              class="w-8 h-8 flex items-center justify-center rounded-full
                    hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
              <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
          </div>

          <!-- Day labels -->
          <div class="grid grid-cols-7 gap-2 mt-4 mb-2">${headerHtml}</div>

          <!-- Day cells -->
          <div class="grid grid-cols-7 space-y-4 gap-2 flex-1 content-start">${cells}</div>

          <!-- Legend -->
          <div class="mt-4 pt-3 border-t border-gray-200 flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5">
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-[#008440] flex-shrink-0"></span>
              <span class="text-[11px] text-[#555]">My Appointment</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span>
              <span class="text-[11px] text-[#555]">Full Schedule</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-2.5 h-2.5 rounded-full bg-amber-50 border border-amber-400 flex-shrink-0"></span>
              <span class="text-[11px] text-[#555]">Holiday</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="text-gray-300 text-base font-bold leading-none flex-shrink-0">–</span>
              <span class="text-[11px] text-[#555]">Not Available</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-4 h-4 rounded-full bg-[#8B0000] inline-flex items-center justify-center flex-shrink-0">
                <span class="text-white text-[8px] font-extrabold">•</span>
              </span>
              <span class="text-[11px] text-[#555]">Today</span>
            </div>
          </div>
        </div>
      `;
      }

      window.changeMonth = function(dir) {
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

    document.addEventListener('DOMContentLoaded', () => loadCalendar());
  </script>

</body>

</html>