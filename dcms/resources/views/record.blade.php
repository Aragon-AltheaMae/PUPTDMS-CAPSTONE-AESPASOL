<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PUP Taguig Dental Clinic | Dental Records</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #fff;
      min-height: 100vh;
    }

    .sidebar-link {
      justify-content: center;
      transition: background-color .2s ease, transform .2s ease;
    }

    #sidebar[style*="16rem"] .sidebar-link {
      justify-content: flex-start;
    }

    #sidebar[style*="16rem"] .sidebar-link i {
      margin-right: 1rem;
    }
  </style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="fixed top-0 left-0 right-0 z-50
            bg-gradient-to-r from-[#660000] to-[#8B0000]
            px-6 py-4 flex justify-between items-center text-white">

  <div class="flex items-center gap-3">
    <img src="{{ asset('images/PUP.png') }}" class="w-10">
    <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="w-10">
    <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
  </div>

  <div class="flex items-center gap-3">
    <img class="w-10 h-10 rounded-full"
         src="{{ $patient->profile_image
              ? asset('storage/'.$patient->profile_image)
              : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=fff' }}">
    <div>
      <div class="font-semibold">{{ ucwords(strtolower($patient->name)) }}</div>
      <div class="text-xs italic opacity-80">Patient</div>
    </div>
  </div>
</div>

<!-- ================= SIDEBAR ================= -->
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
              rounded-full text-gray-500 hover:text-[#8B0000]
              hover:bg-[#D9D9D9] transition-all duration-300">
        <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
      </button>
    </div>

  <!-- DIVIDER -->
  <hr class="my-3 border-t border-[#DADADA]">
  <!-- MENU -->
  <nav class="space-y-1 px-3 text-gray-600">

      <!-- HOME DASHBOARD -->
      <a href="{{ route('homepage') }}"
        class="sidebar-link relative flex items-center px-3 py-3 rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('homepage')
                  ? 'bg-[#8B0000] text-[#F4F4F4]'
                  : '' }}">
        
        <!-- ACTIVE INDICATOR -->
        <span
          class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000]
                transition-opacity duration-300
                {{ request()->routeIs('homepage') ? 'opacity-100' : 'opacity-0' }}">
        </span>

        <i class="fa-solid fa-house text-lg"></i>
        <span class="sidebar-text opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
          Home
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
          Home
        </span>
      </a>

    <!-- APPOINTMENT -->
    <a href="{{ route('appointment.index') }}"
      class="sidebar-link relative flex items-center px-3 py-3 rounded-xl
              transition-all duration-200
              hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('appointment.index*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('appointment.index*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
        Appointment
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
          Appointment
        </span>
    </a>

    <!-- RECORD -->
    <a href="{{ route('record') }}"
      class="sidebar-link relative flex items-center px-3 py-3 rounded-xl
              transition-all duration-200
              hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('record*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('record*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-folder-open text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
        Record
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
          Record
        </span>
    </a>

    <!-- ABOUT US -->
    <a href="{{ route('about.us') }}"
      class="sidebar-link relative flex items-center px-3 py-3 rounded-xl
              transition-all duration-200
              hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('about.us*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('about.us*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-circle-info text-lg"></i>
      <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
        About Us
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
          About Us
        </span>
    </a>
  </nav>
</div>

  <!-- BOTTOM -->
  <div class="px-3 pb-5 space-y-2">

    <a href="#"
       class="sidebar-link relative flex items-center px-3 py-3 rounded-xl hover:bg-gray-100
       transition-all duration-200">
      <i class="fa-regular fa-circle-question"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
        Help
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
          Help
        </span>
    </a>

  <!-- DARK MODE TOGGLE -->
  <button
    id="themeToggle"
    class="sidebar-link relative flex items-center justify-center
          w-full px-2 py-2 rounded-full
          bg-[#7B6CF6] text-[#F4F4F4]
          transition-all duration-200
          hover:scale-105"
    aria-label="Toggle dark mode">

    <i id="themeIcon" class="fa-regular fa-moon text-lg"></i>
    <span class="sidebar-text opacity-0 w-0 overflow-hidden
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
        class="sidebar-link w-full relative flex items-center px-3 py-3 rounded-xl
               text-red-600 hover:bg-red-50 transition-all duration-200">
        <i class="fa-solid fa-right-from-bracket"></i>
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

<!-- ================= MAIN CONTENT ================= -->
<main id="mainContent"
      class="pt-[110px] pl-[100px] pr-6 pb-20 min-h-screen">

  <h2 class="text-3xl font-extrabold text-center mb-12 text-[#660000]">
    Dental Records
  </h2>

 <!-- ================= TIMELINE ================= -->
<div class="max-w-6xl mx-auto
            bg-gradient-to-l from-[#FFD700] to-[#660000]
            p-0.5 rounded-2xl">

  <div class="bg-white rounded-2xl px-10 py-10">

    <!-- TIMELINE WRAPPER -->
    <div class="relative">

      <!-- ONE CONTINUOUS LINE -->
      <div class="absolute left-[28px] top-0 bottom-0 w-px bg-[#8B0000]/40"></div>

      <div class="space-y-8">

        @forelse($records as $record)
          <div class="relative flex items-center gap-6">

            <!-- DOT (CENTERED ON LINE) -->
            <div class="w-14 flex justify-center relative z-10">
              <span class="w-4 h-4 rounded-full bg-[#8B0000]"></span>
            </div>

            <!-- CARD -->
            <div class="flex-1 bg-white border rounded-xl px-6 py-4 shadow-sm">

              <div class="grid grid-cols-3 items-center">

                <!-- LEFT -->
                <div>
                  <p class="font-semibold text-[#8B0000]">
                    {{ $record->service_type }}
                  </p>
                  <p class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}
                  </p>
                </div>

                <!-- CENTER -->
                <div class="text-center text-sm text-gray-700">
                  {{ $record->appointment_time }}
                </div>

                <!-- RIGHT -->
                <div class="text-right">
                <button
                    class="inline-flex items-center gap-2
                          px-6 py-2
                          rounded-full
                          bg-[#7A0000]
                          text-white text-sm font-medium
                          shadow-md
                          hover:bg-[#660000]
                          transition">
                    <i class="fa-regular fa-eye text-sm"></i>
                    Details
                  </button>

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


</main>

<script>
  let sidebarOpen = false;

  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('mainContent');
    const icon = document.getElementById('sidebarIcon');

    sidebarOpen = !sidebarOpen;

    if (sidebarOpen) {
      sidebar.style.width = '16rem';
      main.style.marginLeft = '16rem';
      icon.classList.replace('fa-bars', 'fa-xmark');
    } else {
      sidebar.style.width = '72px';
      main.style.marginLeft = '72px';
      icon.classList.replace('fa-xmark', 'fa-bars');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('sidebar').style.width = '72px';
    document.getElementById('mainContent').style.marginLeft = '72px';
  });
</script>

</body>
</html>
