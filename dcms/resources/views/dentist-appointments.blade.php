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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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



    .sidebar-link {
      display: flex;
      align-items: center;
      width: 100%;
      padding: 12px;
      border-radius: 12px;
      transition: background-color .2s ease, transform .2s ease;
    }

    /* Tooltip appears ONLY when collapsed */
    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1;
      transform: scale(1);
    }

    /* Hide tooltip when expanded */
    #sidebar[style*="16rem"] .sidebar-tooltip {
      display: none;
    }

    #sidebar[style*="16rem"] .sidebar-link {
      justify-content: flex-start;
    }

    /* consistent icon column width */
    .sidebar-link i {
      width: 24px;
      /* fixed width column */
      min-width: 24px;
      text-align: center;
    }

    /* CLOSED: center icon only */
    #sidebar[style*="72px"] .sidebar-link {
      justify-content: center;
      gap: 0;
    }

    /* when expanded, align items nicely */
    #sidebar[style*="16rem"] .sidebar-link {
      justify-content: flex-start;
      gap: 12px;
      /* spacing between icon and text */
    }

    #sidebar[style*="16rem"] .sidebar-link:hover {
      transform: translateX(4px);
    }

    .sidebar-link:hover .sidebar-text {
      opacity: 1;
      transform: scale(1);
    }

    .sidebar-text {
      transform-origin: left center;
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
    .card {
      transition: background-color 0.3s ease, color 0.3s ease;
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal min-h-screen flex flex-col"">

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

      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
        <div>
          <p class="text-l font-semibold text-[#F4F4F4]">Dr. Nelson Angeles</p>
          <p class="italic text-xs text-[#F4F4F4]/80">Dentist</p>
        </div>
      </div>
    </div>
  </div>

  <aside id="sidebar"
    class="fixed left-0 top-[80px]
         h-[calc(100vh-80px)]
         w-[72px]
         bg-[#FAFAFA]
         drop-shadow-xl
         transition-all duration-300
         flex flex-col justify-between z-40">

    <!-- TOP -->
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

      <!-- MENU -->
      <nav class="space-y-2 px-3 text-gray-600 text-sm">

        <!-- DASHBOARD -->
        <a href="{{ route('dentist.dashboard') }}"
          class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.dashboard')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

          <span
            class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}">
          </span>

          <i class="fa-solid fa-chart-line text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
            Dashboard
          </span>

          <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200
            opacity-0 scale-95 transition-all duration-200">
            Dashboard
          </span>
        </a>

        <!-- PATIENTS -->
        <a href="{{ route('dentist.patients') }}"
          class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.patients*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

          <span
            class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.patients*') ? 'opacity-100' : 'opacity-0' }}">
          </span>

          <i class="fa-solid fa-users text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
            Patients
          </span>

          <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
            Patients
          </span>
        </a>

        <!-- APPOINTMENTS -->
        <a href="{{ route('dentist.appointments') }}"
          class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.appointments*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

          <span
            class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.appointments*') ? 'opacity-100' : 'opacity-0' }}">
          </span>

          <i class="fa-solid fa-calendar-check text-lg"></i>
          <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
            Appointments
          </span>

          <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
            Appointments
          </span>
        </a>

        <!-- Document Requests -->
        <a href="{{ route('dentist.documentrequests') }}"
          class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.documentrequests*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

          <span
            class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.documentrequests*') ? 'opacity-100' : 'opacity-0' }}">
          </span>

          <i class="fa-solid fa-file-circle-check text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
            Document Requests
          </span>

          <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
            Document Requests
          </span>
        </a>

        <!-- INVENTORY -->
        <a href="{{ route('dentist.inventory') }}"
          class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.inventory*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

          <span
            class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.inventory*') ? 'opacity-100' : 'opacity-0' }}">
          </span>

          <i class="fa-solid fa-box text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
            Inventory
          </span>

          <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
            Inventory
          </span>
        </a>

        <!-- REPORTS -->
        <a href="{{ route('dentist.report') }}"
          class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.report*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

          <span
            class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.report*') ? 'opacity-100' : 'opacity-0' }}">
          </span>

          <i class="fa-solid fa-file text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
            Reports
          </span>

          <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
            Reports
          </span>
        </a>
      </nav>
    </div>

    <!-- BOTTOM -->
    <div class="px-3 pb-5 space-y-2">

      <!-- DARK MODE TOGGLE -->
      <button
        id="themeToggle"
        class="sidebar-link relative flex items-center justify-center
          w-full px-2 py-1.5 rounded-xl
          bg-[#7B6CF6] text-[#F4F4F4]
          transition-all duration-200
          hover:scale-105"
        aria-label="Toggle dark mode">

        <i id="themeIcon" class="fa-regular fa-moon text-sm"></i>
        <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden
               transition-all duration-300 delay-150">
          Dark Mode
        </span>
        <!-- Tooltip (collapsed only) -->
        <span
          class="sidebar-tooltip
            absolute left-full ml-8
            px-3 py-1
            rounded-full
            bg-[#8B0000]
            text-[#F4F4F4] text-sm font-semibold
            whitespace-nowrap
            opacity-0 scale-95
            pointer-events-none
            transition-all duration-200">
          Dark Mode
        </span>
      </button>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button
          class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm
               text-red-600 hover:bg-red-50 transition-all duration-200">
          <i class="fa-solid fa-right-from-bracket text-sm"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
            Log out
          </span>
          <span
            class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
            Log out
          </span>
        </button>
      </form>

    </div>
  </aside>

  <!-- ================= MAIN ================= -->
  <main
    id="mainContent"
    class="flex-1 pt-[100px] px-6 pb-0 w-full transition-transform duration-500
            ease-[cubic-bezier(0.4,0,0.2,1)]">

    <div class="max-w-7xl mt-4 mx-auto fade-in">
      <!-- Toggle pill -->
      <div class="flex justify-center mt-14">
        <div class="w-[760px] h-14 bg-[#7a0000] rounded-full p-1.5 flex shadow-md">

          <button id="btnUpcoming" class="flex-1 rounded-full bg-[#8b0000]
        text-white text-sm font-semibold
        transition-all duration-200">
            Upcoming Appointments
          </button>

          <button id="btnPast" class="flex-1 rounded-full text-white/80 text-sm font-semibold
        transition-all duration-200">
            Past Appointments
          </button>
        </div>
      </div>

      <!-- ========== UPCOMING SECTION ========== -->
      <section id="upcomingSection" class="mt-14 flex justify-center">
        <div class="w-[1100px]">

          <div class="relative pl-10">
            <div class="absolute left-[6px] top-[6px] w-[2px] h-[220px] bg-[#8b0000]"></div>
            <div class="absolute left-[0px] top-[0px] w-3 h-3 bg-orange-400 rounded-full"></div>
            <h2 class="text-xl font-semibold text-[#8b0000] mb-6">February</h2>

            <div class="grid grid-cols-[36px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr_1.6fr]
            text-[13px] font-semibold text-[#8b0000] pb-3 border-b border-gray-400 mb-6 px-8">
              <div>

              </div>
              <p>Date</p>
              <p>Time</p>
              <p>Service</p>
              <p>Name</p>
              <p>Program</p>
              <p class="pl-16">Action</p>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-200 px-8 py-5">
              <div class="grid grid-cols-[36px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr_1.6fr]
            items-center text-[13px] text-[#8b0000]">


                <div class="flex justify-center">
                  <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>

                <p class="font-semibold">February 2, 2025</p>
                <p>1:00 PM</p>
                <p>Dental Cleaning</p>
                <p class="font-semibold">Alilah Gomez</p>
                <p>BSME</p>

                <!-- Actions -->
                <div class="flex flex-col gap-2 items-end pr-2">
                  <button onclick="openStartProcedureModal()" class="h-6 w-[130px]
                    rounded-md text-[11px] font-semibold text-white bg-green-600
                    cursor-pointer hover:bg-green-700 transition">
                    Start Procedure
                  </button>

                  <button onclick="openRescheduleModal()" class="h-6 w-[130px]
                    rounded-md text-[11px] font-semibold text-black bg-yellow-400
                    cursor-pointer hover:bg-yellow-500 transition">
                    Reschedule
                  </button>

                  <button onclick="openCancelAppointmentModal()" class="h-6 w-[130px]
                    rounded-md text-[11px] font-semibold
                    text-white bg-[#8b0000] cursor-pointer hover:bg-[#6f0000] transition">
                    Cancel
                  </button>
                </div>
              </div> 
            </div> 
          </div> 
        </div> 
      </section>

                <!-- ================= RESCHEDULE MODAL ================= -->
                <div id="rescheduleModal"
                  class="fixed inset-0 bg-black/40 flex items-center 
                      justify-center hidden z-50">
                  <div class="bg-white w-[560px] rounded-2xl overflow-hidden 
                              shadow-2xl">

                    <!-- HEADER -->
                    <div class="bg-yellow-200 px-8 py-5 text-center">
                      <h2 class="text-xl font-bold text-[#8b0000]">
                        Reschedule Appointment
                      </h2>
                    </div>

                    <!-- BODY -->
                    <div class="px-10 py-7 bg-gray-50">

                      <p class="text-base font-bold text-gray-900 mb-1 text-center">
                        You are about to reschedule this appointment.
                      </p>
                      <p class="text-sm text-gray-500 mb-5 text-center">
                        You will be able to select a new date and time.
                      </p>

                      <!-- Appointment Details card -->
                      <div class="bg-white border border-gray-200 rounded-2xl 
                                  px-8 py-5 text-center mb-4 shadow-sm">
                        <div class="flex items-center justify-center gap-2 
                                  text-gray-700 text-sm font-bold mb-3">
                          <i class="fa-regular fa-circle-user text-lg"></i>
                          <span>Appointment Details</span>
                        </div>

                        <p class="text-sm text-gray-800">
                          Patient Name: <span class="font-bold">Alilah Gomez</span>
                        </p>

                        <p class="text-sm text-gray-600 mt-1">
                          February 2, 2025 | 1:00 PM
                        </p>
                      </div>

                      <p class="text-xs text-gray-400 mb-5 text-center">
                        This change will be recorded in the appointment history.
                      </p>

                      <!-- BUTTONS -->
                      <div class="flex justify-end gap-3">
                        <button onclick="closeRescheduleModal()"
                          class="px-6 py-2 rounded-lg border border-gray-300
                                  bg-white text-gray-700 font-semibold
                                  hover:bg-gray-100 transition text-sm shadow-sm">
                          Cancel
                        </button>
                        <button onclick="confirmReschedule()"
                          class="px-6 py-2 rounded-lg bg-yellow-400 
                                 text-gray-700 font-semibold hover:bg-yellow-500  
                                 transition text-sm shadow-sm">
                          Reschedule
                        </button>
                      </div>

                    </div>
                  </div>
                </div>

                <!-- ================= START PROCEDURE MODAL ================= -->
                <div id="startProcedureModal"
                  class="fixed inset-0 bg-black/50 flex items-center 
                       justify-center hidden z-50">
                  <div class="bg-white w-[560px] rounded-2xl 
                              overflow-hidden shadow-2xl">

                    <!-- HEADER -->
                    <div class="bg-green-700 px-8 py-5 text-center">
                      <h2 class="text-xl font-bold text-white">
                        Confirm Procedure Start
                      </h2>
                    </div>

                    <!-- BODY -->
                    <div class="px-10 py-7 bg-gray-50">

                      <p class="text-base font-bold text-gray-900 mb-1 text-center">
                        You are about to begin this appointment's procedure.
                      </p>
                      <p class="text-sm text-gray-500 mb-5 text-center">
                        This will mark the appointment as in progress.
                      </p>

                      <!-- Appointment Details card -->
                      <div class="bg-white border border-gray-200 rounded-2xl 
                                  px-8 py-5 text-center mb-4 shadow-sm">
                        <div class="flex items-center justify-center gap-2 
                                    text-gray-700 text-sm font-bold mb-3">
                          <i class="fa-regular fa-circle-user text-lg"></i>
                          <span>Appointment Details</span>
                        </div>

                        <p class="text-sm text-gray-800">
                          Patient Name: <span class="font-bold" id="startPatientName">Alilah Gomez</span>
                        </p>

                        <p class="text-sm text-gray-600 mt-1" id="startAppointmentDate">
                          February 2, 2025 | 1:00 PM
                        </p>
                      </div>

                      <p class="text-xs text-gray-400 mb-5 text-center">
                        This action will be recorded in the patient's treatment history.
                      </p>

                      <!-- BUTTONS -->
                      <div class="flex justify-end gap-3">
                        <button onclick="closeStartProcedureModal()"
                          class="px-6 py-2 rounded-lg border border-gray-300 
                                bg-white text-gray-700 font-semibold
                                hover:bg-gray-100 transition text-sm shadow-sm">
                          Cancel
                        </button>
                        <button onclick="confirmStartProcedure()"
                          class="px-6 py-2 rounded-lg bg-green-700 
                                text-white font-semibold hover:bg-green-800 
                                transition text-sm shadow-sm">
                          Start Procedure
                        </button>
                      </div>

                    </div>
                  </div>
                </div>

                <!-- ================= CANCEL APPOINTMENT MODAL ================= -->
                <div id="cancelAppointmentModal"
                  class="fixed inset-0 bg-black/40 flex items-center 
                      justify-center hidden z-50">
                  <div class="bg-white w-[560px] rounded-2xl 
                              overflow-hidden shadow-2xl">

                    <!-- HEADER -->
                    <div class="bg-[#8b0000] px-8 py-5 text-center">
                      <h2 class="text-xl font-bold text-white">
                        Cancel Appointment
                      </h2>
                    </div>

                    <!-- BODY -->
                    <div class="px-10 py-7 bg-gray-50">

                      <p class="text-base font-bold text-gray-900 mb-1 text-center">
                        You are about to cancel this appointment.
                      </p>
                      <p class="text-sm text-gray-500 mb-5 text-center">
                        This action cannot be undone.
                      </p>

                      <!-- Appointment Details card -->
                      <div class="bg-white border border-gray-200 rounded-2xl 
                                  px-8 py-5 text-center mb-4 shadow-sm">
                        <div class="flex items-center justify-center gap-2 
                                    text-gray-700 text-sm font-bold mb-3">
                          <i class="fa-regular fa-calendar-check text-lg"></i>
                          <span>Appointment Details</span>
                        </div>

                        <p class="text-sm text-gray-800">
                          Patient Name: <span class="font-bold">
                            Alilah Gomez</span>
                        </p>

                        <p class="text-sm text-gray-600 mt-1">
                          February 2, 2025 | 1:00 PM</p>
                      </div>

                      <p class="text-xs text-gray-400 mb-5 text-center">
                        This action will be recorded and cannot be undone.
                      </p>

                      <!-- Buttons — right-aligned -->
                      <div class="flex justify-end gap-3">
                        <button onclick="closeCancelAppointmentModal()"
                          class="px-6 py-2 rounded-lg border border-gray-300 
                                bg-white text-gray-700 font-semibold
                                hover:bg-gray-100 transition text-sm shadow-sm">
                          Keep Appointment
                        </button>
                        <button onclick="confirmCancelAppointment()"
                          class="px-6 py-2 rounded-lg bg-[#8b0000] text-white 
                                font-semibold hover:bg-[#6f0000] 
                                transition text-sm shadow-sm">
                          Cancel Appointment
                        </button>
                      </div>

                    </div>
                  </div>
                </div>


                <!-- ========== PAST SECTION ========== -->
                <section id="pastSection" 
                  class="mt-14 flex justify-center hidden">
                  <div class="w-[1100px]">

                    <div class="relative pl-10">
                      <div class="absolute left-[6px] top-[6px] w-[2px] 
                                  h-[200px] bg-[#8b0000]"></div>
                      <div class="absolute left-[0px] top-[0px] w-3 h-3 
                                  bg-orange-400 rounded-full"></div>

                      <h2 class="text-xl font-semibold text-[#8b0000] mb-6">
                        January
                      </h2>

                      <div class="grid grid-cols-[32px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr]
                                  text-[13px] font-semibold text-[#8b0000]
                                  pb-3 border-b border-gray-400 mb-6 px-8">

                        <div></div>
                        <p>Date</p>
                        <p>Time</p>
                        <p>Service</p>
                        <p>Name</p>
                        <p>Program</p>
                      </div>

                      <!-- Appointment card -->
                      <div class="bg-white rounded-xl shadow-md border border-gray-200 px-8 py-5">

                        <div class="grid grid-cols-[32px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr]
                                    items-center text-[13px] text-[#8b0000]">


                          <div class="flex justify-center">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                          </div>

                          <p class="font-semibold">January 10, 2025</p>
                          <p>—</p>
                          <p>Tooth Extraction</p>
                          <p class="font-semibold">Juan Dela Cruz</p>
                          <p>BSIT</p>

                        </div>
                      </div>

                    </div>
                  </div>
                </section>
            </div>
        </main>

          <!-- Footer -->
          <footer class="footer sm:footer-horizontal 
            bg-[#660000] text-[#F4F4F4] p-10">
          </footer>

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

    let sidebarOpen = false;

    function applyLayout(sidebarWidth) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');

      sidebar.style.width = sidebarWidth;
      main.style.marginLeft = sidebarWidth;
      main.style.width = `auto`;
    }

    function toggleSidebar() {
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');

      sidebarOpen = !sidebarOpen;

      if (sidebarOpen) {
        // EXPAND
        applyLayout('16rem');

        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100', 'w-auto');
        });

        toggleWrapper.classList.remove('justify-center');
        toggleWrapper.classList.add('justify-end');

        toggleBtn.classList.add('translate-x-2');
        icon.classList.replace('fa-bars', 'fa-xmark');

      } else {
        // COLLAPSE
        applyLayout('72px');

        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100', 'w-auto');
        });

        toggleWrapper.classList.remove('justify-end');
        toggleWrapper.classList.add('justify-center');

        toggleBtn.classList.remove('translate-x-2');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
    }

    // ✅ INITIAL STATE SYNC (CRITICAL FIX)
    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = false; // ensure state is correct
      applyLayout('72px'); // collapsed layout on load
    });

    const btnUpcoming = document.getElementById("btnUpcoming");
    const btnPast = document.getElementById("btnPast");
    const upcomingSection = document.getElementById("upcomingSection");
    const pastSection = document.getElementById("pastSection");

    function setActiveTab(tab) {
      const isUpcoming = tab === "upcoming";

      // show/hide sections
      upcomingSection.classList.toggle("hidden", !isUpcoming);
      pastSection.classList.toggle("hidden", isUpcoming);

      // active styles (match your pill)
      btnUpcoming.classList.toggle("bg-[#8b0000]", isUpcoming);
      btnUpcoming.classList.toggle("text-white", isUpcoming);
      btnUpcoming.classList.toggle("text-white/70", !isUpcoming);

      btnPast.classList.toggle("bg-[#8b0000]", !isUpcoming);
      btnPast.classList.toggle("text-white", !isUpcoming);
      btnPast.classList.toggle("text-white/70", isUpcoming);
    }

    function openRescheduleModal() {
      document.getElementById('rescheduleModal').classList.remove('hidden');
    }

    function closeRescheduleModal() {
      document.getElementById('rescheduleModal').classList.add('hidden');
    }

    function confirmReschedule() {
      // redirect or open date-time picker page
      window.location.href = "/dentist/reschedule";
      // or show another modal
    }

    function openStartProcedureModal() {
      document.getElementById('startProcedureModal').classList.remove('hidden');
      document.getElementById('patientNameInput').focus();
    }

    function closeStartProcedureModal() {
      document.getElementById('startProcedureModal').classList.add('hidden');
      document.getElementById('patientNameInput').value = '';
    }

    function confirmStartProcedure() {
      const patientName = document.getElementById('patientNameInput').value.trim();

      if (!patientName) {
        alert("Please enter the patient name.");
        return;
      }

      // 🔧 Replace this with real logic (API / redirect / form submit)
      alert("Starting procedure for: " + patientName);
    }

    function openCancelAppointmentModal() {
      document.getElementById('cancelAppointmentModal').classList.remove('hidden');
    }

    function closeCancelAppointmentModal() {
      document.getElementById('cancelAppointmentModal').classList.add('hidden');
    }

    function confirmCancelAppointment() {
      // Replace with real cancel logic (API / Laravel route)
      alert("Appointment cancelled.");
      closeCancelAppointmentModal();
    }
    btnUpcoming.addEventListener("click", () => setActiveTab("upcoming"));
    btnPast.addEventListener("click", () => setActiveTab("past"));

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