<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PUP Taguig Dental Clinic | Records</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
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
      from { opacity:0; transform:translateY(6px); }
      to { opacity:1; transform:translateY(0); } 
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }

    /* Subtle pulse for icon */
    @keyframes softPulse {
      0%,100%{transform:scale(1);}
      50%{transform:scale(1.05);}
    }

    .pulse-icon {
      animation: softPulse 2s ease-in-out infinite;
    }

    /* Skeleton shimmer */
    @keyframes shimmer {
      0% {background-position:-400px 0;}
      100% {background-position:400px 0;}
    }

    .skeleton {
      background: linear-gradient(90deg,#e5e7eb 25%,#f3f4f6 37%,#e5e7eb 63%);
      background-size: 800px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius:0.75rem;
    }

    @keyframes fadeUp {
      0% { opacity:0; transform:translateY(10px); }
      100% { opacity:1; transform:translateY(0); }
    }

    .fade-up {
      animation: fadeUp 0.6s ease-out forwards;
    }

    /* Modal styles */
    .modal-bg {
      position: fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      background: rgba(0,0,0,0.5);
      display:none;
      justify-content:center;
      align-items:center;
      z-index:50;
    }

    .modal-content {
      background:white;
      padding:2rem;
      border-radius:1rem;
      max-width:600px;
      width:90%;
      max-height:80vh;
      overflow-y:auto;
    }

    /* Sidebar icon centering fix */
  .sidebar-link {
    justify-content: center;
    transition: background-color 0.2s ease,
              transform 0.2s ease;
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

  /* Icon spacing only when expanded */
  #sidebar[style*="16rem"] .sidebar-link i {
    margin-right: 1rem;
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

  <div class="dropdown dropdown-end">
    <label tabindex="0" class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">
      @if($notifCount > 0)
        <span class="indicator-item badge badge-secondary text-s text-[#F4F4F4] bg-[#660000] border-none">
          {{ $notifCount }}
        </span>
      @endif

      <i class="fa-regular fa-bell text-lg cursor-pointer"></i>
      </label>

      <div tabindex="0" class="dropdown-content z-[50] mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100">
        <div class="p-4 border-b flex items-center justify-between">
          <span class="font-bold text-[#8B0000]">Notifications</span>

          {{-- Optional "View all" (only if you have this route) --}}
          {{-- <a href="{{ route('notifications.index') }}" class="text-xs text-[#8B0000] hover:underline">View all</a> --}}
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
              <div class="text-xs text-gray-500 mt-1">You’re all caught up.</div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
        <div class="flex items-center gap-3">
        {{-- Avatar --}}
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

        {{-- Name + Role --}}
        <div class="leading-tight">
          <div class="text-l font-semibold text-[#F4F4F4]">
            {{ ucwords(strtolower($patient->name)) }}
          </div>
          <div class="italic text-xs text-[#F4F4F4]/80">
            Patient
          </div>
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
      <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
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
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
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

<!-- CONTENT -->
<main
  id="mainContent"
  class="pt-[100px]
         px-6 py-10
         w-full
         transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

  <!-- CONTENT -->
  <div class="max-w-7xl mx-auto py-10">

    <!-- TITLE -->
    <h2 class="text-3xl font-extrabold flex justify-center mt-2 mb-10 
           bg-gradient-to-r from-[#660000] to-[#FFD700] 
           bg-clip-text text-transparent fade-up">
            My Dental Records
    </h2>

    <!-- RECORDS CONTAINER -->
    <div id="recordsContainer" class="bg-gradient-to-l from-[#FFD700] to-[#660000] p-0.5 rounded-2xl mb-10 fade-up">
      <div class="bg-white rounded-2xl p-6 space-y-4">
        <div id="recordsInnerContainer" class="space-y-4"></div>
      </div>
    </div>

  </div>
</main>

<script>
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
    sidebarOpen = false;        // ensure state is correct
    applyLayout('72px');        // collapsed layout on load
  });

  document.addEventListener("DOMContentLoaded", () => {
    showSkeletons(); // Show skeletons

    setTimeout(() => {
      fetch("get_records.php")
        .then(res => res.json())
        .then(records => renderRecords(records))
        .catch(() => showRecordsError());
    }, 1500);
  });

  function showSkeletons() {
    document.getElementById("recordsInnerContainer").innerHTML = `
      <div class="space-y-4 animate-pulse">
        ${[1,2,3,4,5,6].map(() => `
          <div class="flex justify-between items-center border rounded-xl p-4">
            <div class="flex-1 space-y-2">
              <div class="h-4 w-1/2 skeleton"></div>
              <div class="h-3 w-1/3 skeleton"></div>
            </div>
            <div class="w-24 h-8 skeleton"></div>
          </div>
        `).join('')}
      </div>
    `;
  }

  function renderRecords(records) {
    const container = document.getElementById("recordsInnerContainer");
    if (!records || records.length === 0) return showRecordsError();

    container.innerHTML = "";
    records.forEach(record => {
      container.innerHTML += `
        <div class="flex justify-between items-center border rounded-xl p-4 fade-up">
          <div>
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-[#FFD700] to-[#8B0000]"></span>
              <p class="font-semibold">${record.procedure_name}</p>
            </div>
            <p class="text-sm">Last Visit: ${formatDate(record.visit_date)}</p>
          </div>
          <div class="text-right">
            <p class="text-sm mb-2">${formatTime(record.time_start)} - ${formatTime(record.time_end)}</p>
            <button onclick="viewRecordDetails(${record.record_id})" class="btn btn-soft bg-[#8B0000] hover:bg-[#333333] border-none text-sm rounded-2xl text-[#F4F4F4]">
              View Details
            </button>
          </div>
        </div>
      `;
    });
  }

  function showRecordsError() {
    document.getElementById("recordsInnerContainer").innerHTML = `
      <div class="flex flex-col items-center justify-center py-14 text-center space-y-5 fade-in">
        <img src="images/error-records.png" alt="Error" class="w-24 h-24">
        <p class="text-2xl font-extrabold text-[#8B0000]">Oops! Something went wrong</p>
        <p class="text-sm text-gray-600 max-w-sm">Unable to fetch your records.</p>
      </div>
    `;
  }

  // Helpers
  function formatDate(dateStr) { return new Date(dateStr).toLocaleDateString(); }
  function formatTime(timeStr) { return timeStr.substring(0,5); }

  // Modal logic
  function viewRecordDetails(id) {
    fetch(`get_records.php?id=${id}`)
      .then(res => res.json())
      .then(record => {
        const modal = document.getElementById("recordModal");
        const content = document.getElementById("modalContent");
        content.innerHTML = `
          <h3 class="text-xl font-bold mb-4">${record.procedure_name}</h3>
          <p><strong>Date:</strong> ${formatDate(record.visit_date)}</p>
          <p><strong>Time:</strong> ${formatTime(record.time_start)} - ${formatTime(record.time_end)}</p>
          <p><strong>Details:</strong> ${record.details || "No additional details."}</p>
        `;
        modal.style.display = "flex";
      })
      .catch(() => alert("Failed to load record details"));
  }

  function closeModal() {
    document.getElementById("recordModal").style.display = "none";
  }
</script>

</body>
</html>