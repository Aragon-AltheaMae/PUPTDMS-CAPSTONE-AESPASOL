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

  <script type="module" src="https://unpkg.com/cally"></script>

  <script>
    tailwind.config = {
      daisyui: {
        themes: false
      },
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
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

    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
      padding: 0 2rem;
      height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 20px rgba(139, 0, 0, .25);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .header-logo {
      width: 36px;
      height: 36px;
      object-fit: contain;
    }

    .header-title {
      font-size: .95rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: .01em;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1.25rem;
    }

    .notif-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .12);
      border: none;
      cursor: pointer;
      color: #fff;
      font-size: .95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background .15s;
      position: relative;
    }

    .notif-btn:hover {
      background: rgba(255, 255, 255, .22);
    }

    .notif-badge {
      position: absolute;
      top: -3px;
      right: -3px;
      background: #ff6b6b;
      color: #fff;
      font-size: .6rem;
      font-weight: 700;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #8B0000;
    }

    .header-user {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .header-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, .4);
      object-fit: cover;
    }

    .header-name {
      font-size: .82rem;
      font-weight: 600;
      color: #fff;
      line-height: 1.2;
    }

    .header-role {
      font-size: .7rem;
      color: rgba(255, 255, 255, .7);
      font-style: italic;
    }

    #notifMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 300px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
      border: 1px solid #f0e6e6;
      opacity: 0;
      transform: scale(.95) translateY(-6px);
      pointer-events: none;
      transition: all .2s;
      transform-origin: top right;
      z-index: 100;
    }

    #notifMenu.open {
      opacity: 1;
      transform: scale(1) translateY(0);
      pointer-events: auto;
    }

    #notifDropdown {
      position: relative;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color .2s ease, transform .2s ease;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
      padding-left: .25rem;
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

    #sidebar.expanded .section-label {
      display: block;
    }

    #sidebar.expanded .sidebar-text {
      opacity: 1;
      width: auto;
      overflow: visible;
    }

    #sidebar.collapsed .sidebar-text {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.collapsed .section-label {
      display: none;
    }

    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    .section-label {
      font-size: .65rem;
      font-weight: 500;
      letter-spacing: .08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: .25rem;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
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

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, .45);
    }

    .theme-toggle-container {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      height: 34px;
      background: #F5F5F5;
      border: 1px solid #E0E0E0;
      border-radius: 24px;
      transition: all .3s ease;
    }

    #sidebar.collapsed .theme-toggle-container {
      flex-direction: column;
      width: 35px;
      height: 96px;
      border-radius: 24px;
      padding: 4px;
    }

    #sidebar.collapsed .w-full {
      display: flex;
      justify-content: center;
    }

    .theme-option {
      position: relative;
      z-index: 2;
      flex: 1;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      cursor: pointer;
      color: #9CA3AF;
      transition: color .2s ease;
      border-radius: 8px;
    }

    #sidebar.collapsed .theme-option {
      width: 35px;
      height: 40px;
      flex: none;
    }

    .theme-option i {
      font-size: 16px;
    }

    #sidebar.collapsed .theme-option i {
      font-size: 15px;
    }

    .theme-option.active {
      color: #374151;
    }

    .theme-indicator {
      position: absolute;
      background: white;
      border-radius: 24px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      transition: all .3s cubic-bezier(.4, 0, .2, 1);
      pointer-events: none;
    }

    #sidebar.expanded .theme-indicator {
      width: calc(50% - 2px);
      height: calc(100% - 8px);
      left: 4px;
      top: 4px;
      border-radius: 20px;
    }

    #sidebar.expanded .theme-indicator.dark-mode {
      transform: translateX(calc(100% + 0px));
    }

    #sidebar.collapsed .theme-indicator {
      width: calc(100% - 8px);
      height: calc(50% - 6px);
      left: 4px;
      top: 4px;
      border-radius: 16px;
    }

    #sidebar.collapsed .theme-indicator.dark-mode {
      transform: translateY(calc(100% + 4px));
    }

    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #000D1A;
    }

    [data-theme="dark"] .bg-white {
      background-color: #000D1A !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    [data-theme="dark"] .theme-toggle-container {
      background: #1F1F1F;
      border-color: #2A2A2A;
    }

    [data-theme="dark"] .theme-option {
      color: #6B7280;
    }

    [data-theme="dark"] .theme-option.active {
      color: #F3F4F6;
    }

    [data-theme="dark"] .theme-indicator {
      background: #2A2A2A;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-white text-[#333333] font-normal">

  <!-- HEADER -->
  <header class="header">
    <div class="header-left">
      <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
      <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="header-right">
      <div id="notifDropdown">
        <button class="notif-btn" id="notifBtn">
          <i class="fa-regular fa-bell"></i>
          @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
        </button>
        <div id="notifMenu">
          <div style="padding:.85rem 1rem .65rem; font-weight:700; color:#8B0000; font-size:.82rem; border-bottom:1px solid #f5e8e8;">Notifications</div>
          <div style="max-height:260px; overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}" style="display:block; padding:.65rem 1rem; font-size:.78rem; color:#333; text-decoration:none; border-bottom:1px solid #fdf5f5;">
              <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>@endif
            </a>
            @empty
            <div style="padding:2rem 1rem; text-align:center; color:#bbb; font-size:.78rem;">You're all caught up.</div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="header-user">
        <img src="{{ $patient->profile_image
                ? asset('storage/'.$patient->profile_image)
                : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=36' }}"
          alt="Profile" />
        <div>
          <div class="header-name">{{ ucwords(strtolower($patient->name)) }}</div>
          <div class="header-role">Student</div>
        </div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px] h-[calc(100vh-72px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
    style="width:220px;">
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>
      <div class="section-label px-4 mb-6">Navigation</div>
      <nav class="space-y-2 px-3 text-gray-600">
        @foreach([
        ['route'=>'homepage', 'icon'=>'fa-house', 'label'=>'Home'],
        ['route'=>'patient.appointment.index', 'icon'=>'fa-calendar', 'label'=>'Patients'],
        ['route'=>'patient.record', 'icon'=>'fa-folder-open', 'label'=>'Record'],
        ['route'=>'patient.about.us', 'icon'=>'fa-file-circle-check', 'label'=>'About Us'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs($nav['route']) ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs($nav['route']) ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid {{ $nav['icon'] }} text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">{{ $nav['label'] }}</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">{{ $nav['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>
      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode"><i class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode"><i class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 ml-2"><i class="fa-solid fa-right-from-bracket text-sm"></i></div>
          <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- CONTENT -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mt-4 mx-auto">

      <div class="text-sm mb-4 font-medium fade-up">
        <span class="text-gray-400">User</span>
        <span class="mx-1 text-gray-400">&gt;</span>
        <span class="text-[#8B0000] font-semibold">Record</span>
      </div>

      <h2 class="text-3xl font-extrabold text-center mt-12 mb-12 text-[#660000]">
        Dental Records
      </h2>

      <!-- ================= TIMELINE ================= -->
      <div class="max-w-6xl mx-auto bg-gradient-to-l from-[#FFD700] to-[#660000] p-0.5 rounded-2xl">
        <div class="bg-white rounded-2xl px-10 py-10">

          <div class="relative">
            <div class="absolute left-[28px] top-0 bottom-0 w-px bg-[#8B0000]/40"></div>

            <div class="space-y-8">
              @forelse($records as $record)
              <div class="relative flex items-center gap-6">

                <div class="w-14 flex justify-center relative z-10">
                  <span class="w-4 h-4 rounded-full bg-[#8B0000]"></span>
                </div>

                <div class="flex-1 bg-white border rounded-xl px-6 py-4 shadow-sm">
                  <div class="grid grid-cols-3 items-center">

                    <div>
                      <p class="font-semibold text-[#8B0000]">{{ $record->service_type }}</p>
                      <p class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}
                      </p>
                    </div>

                    <div class="text-center text-sm text-gray-700">
                      {{ $record->appointment_time }}
                    </div>

                    <div class="text-right">
                      <!-- DETAILS BUTTON (OPENS MODAL) -->
                      <button
                        type="button"
                        onclick="openRecordModal(this)"
                        data-service="{{ $record->service_type }}"
                        data-date="{{ \Carbon\Carbon::parse($record->appointment_date)->format('F d, Y') }}"
                        data-time="{{ $record->appointment_time }}"
                        data-status="completed"
                        data-duration="{{ $record->duration }}"
                        data-remarks="{{ $record->remarks ?? '' }}"
                        data-oral="{{ $record->oral_examination ?? '' }}"
                        data-diagnosis="{{ $record->diagnosis ?? '' }}"
                        data-prescription="{{ $record->prescription ?? '' }}"
                        class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-[#7A0000] text-white text-sm font-medium shadow-md hover:bg-[#660000] transition">
                        <i class="fa-regular fa-eye text-sm"></i>
                        Details
                      </button>
                      <!-- FUTURE USE: kpaag okay na yung dentist 
                            data-status="{{ $record->status }}"
                            -->
                    </div>

                  </div>
                </div>
              </div>
              @empty
              <div class="text-center py-16 text-gray-500">
                No dental records yet.
              </div>
              @endforelse
            </div>

          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 pl-24 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  <!-- ================= RECORD DETAILS MODAL ================= -->
  <dialog id="record_modal" class="modal">
    <div class="modal-box 
              p-0
              w-full
              max-w-2xl        
              max-h-[90vh]    
              overflow-y-auto
              rounded-xl
              bg-[#F3F3F3]">

      <!-- HEADER -->
      <div class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] px-8 py-6 text-white">
        <h3 id="m_service" class="text-3xl font-extrabold leading-tight">Dental Surgery</h3>
        <div class="mt-2 flex items-center gap-3 text-white/95">
          <i class="fa-regular fa-calendar"></i>
          <p class="text-base font-medium">
            <span id="m_date">December 29, 2025</span>
            <span class="mx-2">·</span>
            <span id="m_time">1:30 PM – 2:30 PM</span>
          </p>
        </div>
      </div>

      <!-- BODY -->
      <div class="px-8 py-8 space-y-8">

        <!-- STATUS + DURATION -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- STATUS -->
          <div class="bg-white border border-gray-200 rounded-xl 
                        px-4 py-3
                        min-h-[90px]
                        flex flex-col justify-center">

            <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
              <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800">
                <i class="fa-solid fa-check text-white text-[8px]"></i>
              </span>
              STATUS
            </div>

            <div class="mt-3 ml-4">
              <span id="m_status"
                class="inline-flex items-center justify-center
                          w-28                <!-- fixed width -->
                          px-3 py-0.5
                          text-xs
                          leading-none
                          rounded-full
                          font-semibold
                          bg-emerald-200 text-emerald-900">
                rescheduled
              </span>
            </div>

          </div>

          <!-- DURATION -->
          <div class="bg-white border border-gray-200 rounded-xl 
                        px-4 py-3
                        min-h-[90px]
                        flex flex-col justify-center">

            <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
              <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800">
                <i class="fa-solid fa-check text-white text-[8px]"></i>
              </span>
              DURATION
            </div>

            <div class="mt-3 ml-4">
              <span id="m_duration"
                class="inline-flex items-center justify-center
                          w-28
                          px-3 py-0.5
                          text-xs
                          leading-none
                          rounded-full
                          font-semibold
                          bg-gray-200 text-gray-800">
                3 hours
              </span>
            </div>
          </div>
        </div>

        <!-- TREATMENT -->
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

        <!-- ORAL EXAMINATION -->
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

        <!-- DIAGNOSIS -->
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

        <!-- PRESCRIPTION -->
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

        <!-- FOOTER -->
        <div class="flex justify-end pt-2">
          <form method="dialog">
            <button class="px-8 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">
              Close
            </button>
          </form>
        </div>

      </div>
    </div>

    <form method="dialog" class="modal-backdrop">
      <button>close</button>
    </form>
  </dialog>

  <script>
    // ── THEME TOGGLE ──
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(opt => opt.classList.toggle("active", opt.getAttribute("data-theme") === theme));
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
    }

    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(opt => opt.addEventListener("click", () => applyTheme(opt.getAttribute("data-theme"))));

    // ── SIDEBAR ──
    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      document.getElementById('sidebar').style.width = sidebarWidth;
      document.getElementById('mainContent').style.marginLeft = sidebarWidth;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('220px');
    });

    // ── NOTIF ──
    document.getElementById("notifBtn").addEventListener("click", e => {
      e.stopPropagation();
      document.getElementById("notifMenu").classList.toggle("open");
    });
    document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

    // View details in record modal
    function openRecordModal(btn) {
      const modal = document.getElementById('record_modal');
      if (!modal) return;

      // ===== BASIC INFO =====
      document.getElementById('m_service').textContent = btn.dataset.service || '—';
      document.getElementById('m_date').textContent = btn.dataset.date || '—';
      document.getElementById('m_time').textContent = btn.dataset.time || '—';

      // ===== BADGE SIZE SETTINGS =====
      // NOTE: w-25 is invalid in Tailwind. Use w-28/w-32/etc.
      const BADGE_BASE_CLASS =
        'inline-flex items-center justify-center ' +
        'w-32 px-4 py-1 text-sm leading-none ' +
        'rounded-full font-semibold';

      // ===== STATUS (hard-coded fallback) =====
      // If wala pang data-status sa button, default muna tayo
      const status = (btn.dataset.status || 'rescheduled').trim();
      const statusEl = document.getElementById('m_status');
      statusEl.textContent = status;

      // Reset to base (size stays consistent)
      statusEl.className = BADGE_BASE_CLASS;

      // Color coding by status
      const s = status.toLowerCase();
      if (s === 'completed') {
        statusEl.classList.add('bg-emerald-200', 'text-emerald-900');
      } else if (s === 'rescheduled') {
        statusEl.classList.add('bg-yellow-200', 'text-yellow-900');
      } else if (s === 'cancelled') {
        statusEl.classList.add('bg-red-200', 'text-red-900');
      } else {
        // unknown status
        statusEl.classList.add('bg-gray-200', 'text-gray-800');
      }

      // ===== DURATION (hard-coded fallback optional) =====
      const durEl = document.getElementById('m_duration');
      durEl.textContent = (btn.dataset.duration || '3 hours').trim();

      // Keep same size, fixed gray style
      durEl.className = BADGE_BASE_CLASS + ' bg-gray-200 text-gray-800';

      // ===== OTHER DETAILS =====
      document.getElementById('m_remarks').textContent = (btn.dataset.remarks || '').trim() || '—';
      document.getElementById('m_oral').textContent = (btn.dataset.oral || '').trim() || '—';
      document.getElementById('m_diagnosis').textContent = (btn.dataset.diagnosis || '').trim() || '—';
      document.getElementById('m_prescription').textContent = (btn.dataset.prescription || '').trim() || '—';

      // ===== SHOW MODAL =====
      modal.showModal();
    }
  </script>

</body>

</html>