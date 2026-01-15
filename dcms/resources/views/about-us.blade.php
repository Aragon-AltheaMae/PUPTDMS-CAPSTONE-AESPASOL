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

    /* Custom FAQ */
    .faq-content {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.5s ease, opacity 0.5s ease;
    }

    .faq-item.open .faq-content {
      max-height: 500px; /* adjust to content */
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
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
  }

  .float-bg {
    animation: floatVerySlow 14s ease-in-out infinite;
  }
  .float-delay {
    animation-delay: 4s;
  }

  /* Shimmer effect */
  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }

  .shimmer {
    background: linear-gradient(
      110deg,
      rgba(255,255,255,0.05) 25%,
      rgba(255,255,255,0.22) 37%,
      rgba(255,255,255,0.05) 63%
    );
    background-size: 200% 100%;
    animation: shimmer 10s linear infinite;
  }

  /* === BACKGROUND BLOOBS === */
  @keyframes blobFloat {
    0%   { transform: translate(0, 0) scale(1); }
    50%  { transform: translate(40px, -30px) scale(1.08); }
    100% { transform: translate(0, 0) scale(1); }
  }

  @keyframes blobPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
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

<!-- MAIN LAYOUT -->
<main
  id="mainContent"
  class="pt-[80px]
         transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]
         min-h-screen"
>

  <!-- FULL-WIDTH BANNER (NOT padded) -->
  <section class="relative w-full py-24 text-center fade-up">
    <img
      src="{{ asset('images/PUP TAGUIG CAMPUS.jpg') }}"
      class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none"
    />
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
               drop-shadow-xl"
      />
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
    },
    { threshold: 0.15 }
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
    },
    { threshold: 0.1 }
  );
  blobObserver.observe(footer);

</script>
</div>
</body>
</html>