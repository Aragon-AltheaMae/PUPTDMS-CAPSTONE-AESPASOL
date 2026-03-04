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

    /* Sidebar base */
    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color .2s ease, transform .2s ease;
    }

    /* EXPANDED state */
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
      font-size: .65rem;
      font-weight: 700;
      letter-spacing: .08em;
      color: #9CA3AF;
      text-transform: uppercase;
      margin-bottom: .25rem;
    }

    /* Notification dropdown animation */
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

    /* DARK MODE */
    [data-theme="dark"] body {
      background-color: #111827;
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
      transition: background-color .3s ease, color .3s ease;
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
        <a href="{{ route('homepage') }}">
          <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
        </a>
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
              <div class="text-sm font-semibold text-gray-900">{{ $n['title'] ?? 'Notification' }}</div>
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
    class="fixed left-0 top-[72px]
         h-[calc(100vh-72px)]
         bg-white drop-shadow-xl
         transition-all duration-300
         flex flex-col justify-between z-40 expanded"
    style="width: 200px;">

    <div class="pt-4">

      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()"
          id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575]
               hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <div class="nav-section-label px-4 mb-6">Navigation</div>

      <nav class="space-y-2 px-3 text-gray-600">

        <a href="{{ route('homepage') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl mt-8
               transition-all duration-200
               hover:bg-[#8B0000] hover:text-[#F4F4F4]
               {{ request()->routeIs('homepage') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('homepage') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-house text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Home</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Home</span>
        </a>

        <a href="{{ route('appointment.index') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
               transition-all duration-200
               hover:bg-[#8B0000] hover:text-[#F4F4F4]
               {{ request()->routeIs('appointment.index*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('appointment.index*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-regular fa-calendar text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Appointment</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointment</span>
        </a>

        <a href="{{ route('record') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
               transition-all duration-200
               hover:bg-[#8B0000] hover:text-[#F4F4F4]
               {{ request()->routeIs('record*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('record*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-regular fa-folder-open text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Record</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Record</span>
        </a>

        <a href="{{ route('about.us') }}"
          class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
               transition-all duration-200
               hover:bg-[#8B0000] hover:text-[#F4F4F4]
               {{ request()->routeIs('about.us*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
              {{ request()->routeIs('about.us*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-circle-info text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">About Us</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">About Us</span>
        </a>

      </nav>
    </div>

    <div class="px-3 pb-5 space-y-2">
      <a href="#"
        class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 text-gray-500">
        <i class="fa-regular fa-circle-question text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Help</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Help</span>
      </a>

      <button id="themeToggle"
        class="sidebar-link relative flex items-center w-full px-3 py-2.5 rounded-xl
             bg-[#7B6CF6] text-[#F4F4F4] transition-all duration-200 hover:scale-105"
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
    /* =========================
   DARK MODE TOGGLE
========================= */
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const html = document.documentElement;

    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle.addEventListener('click', () => {
      const currentTheme = html.getAttribute('data-theme');
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
      if (theme === 'dark') {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
      } else {
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
      }
    }

    /* =========================
       SIDEBAR TOGGLE
    ========================= */
    let sidebarOpen = true;

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

    /* =========================
       NOTIFICATION DROPDOWN
    ========================= */
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
    });

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