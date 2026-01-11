<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointments</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter';
    }
  </style>
</head>

<body class="bg-white">

<!-- ================= TOP HEADER ================= -->
<header class="bg-gradient-to-r from-[#660000] to-[#8B0000] text-white px-8 py-4 flex justify-between items-center">
  <div class="flex items-center gap-3 font-bold">
    <!-- University Logo -->
    <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" class="w-10 h-10 object-contain">
    <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUP Logo" class="w-10 h-10 object-contain">
    <span>PUP TAGUIG DENTAL CLINIC</span>
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
      <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
      <div class="text-sm">
        <p class="font-semibold">Dr. Nelson Angeles</p>
        <p class="text-xs opacity-80">Dentist</p>
      </div>

      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="cursor-pointer text-[#F4F4F4] hover:text-[#660000]">
            <i class="fa-solid fa-right-from-bracket text-lg"></i>
        </button>
      </form>

    </div>
  </div>
</header>

<!-- ================= NAV HEADER ================= -->
  <header class="bg-[#8B0000] text-white px-8 py-3">
    <nav class="flex justify-around text-sm">
      <a href="{{ route('dentist.dashboard') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-chart-line text-lg"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-users text-lg"></i>
        <span>Patients</span>
      </a>

      <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-calendar-check text-lg font-bold"></i>
        <span class="font-bold">Appointments</span>
      </a>
      
      <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-box text-lg"></i>
        <span>Inventory</span>
      </a>

          <a href="#" class="flex flex-col items-center opacity-70 hover:opacity-100">
            <i class="fa-solid fa-file text-base mb-1"></i>
            <span>Reports</span>
          </a>
        </nav>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="max-w-6xl mx-auto px-6">

      <!-- Toggle pill -->
      <div class="flex justify-center mt-12">
        <div class="w-[620px] h-12 bg-[#7a0000] rounded-full p-1 flex shadow-sm">
          <button id="btnUpcoming"
            class="flex-1 rounded-full bg-[#8b0000] text-white text-xs font-medium transition">
            Upcoming Appointments
          </button>
          <button id="btnPast"
            class="flex-1 rounded-full text-white/70 text-xs font-medium transition">
            Past Appointments
          </button>
        </div>
      </div>

      <!-- ========== UPCOMING SECTION ========== -->
      <section id="upcomingSection" class="mt-14 flex justify-center">
        <div class="w-[760px] flex gap-10">

          <!-- Timeline left -->
          <div class="relative w-[160px]">
            <div class="absolute left-[22px] top-1 w-4 h-4 bg-orange-400 rounded-full"></div>
            <div class="absolute left-[28px] top-5 w-[6px] h-[320px] bg-[#8b0000] rounded-full"></div>

            <div class="pl-14 pt-0">
              <p class="text-[20px] font-semibold text-[#8b0000]">January 29</p>
            </div>
          </div>

          <!-- Card -->
          <div class="flex-1">
            <div class="bg-[#f3f3f3] rounded-2xl border border-gray-200 shadow-md px-10 py-7">
              <div class="grid grid-cols-4 text-center text-[12px] font-semibold text-[#b46b6b]">
                <p>Date</p>
                <p>Service</p>
                <p>Name</p>
                <p>Program</p>
              </div>

              <div class="mt-4 grid grid-cols-4 text-center text-[11px] text-[#8b0000]">
                <div class="leading-tight">
                  <p>February 2,</p>
                  <p>2025</p>
                </div>
                <p>Dental Cleaning</p>
                <p>Alilah Gomez</p>
                <p>BSME</p>
              </div>

              <div class="mt-5 h-px w-full bg-gray-300/70"></div>

              <div class="mt-3 flex justify-end gap-2">
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-white bg-green-600">
                  Start Procedure
                </button>
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-[#5a3b00] bg-yellow-300">
                  RESCHEDULE
                </button>
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-white bg-red-600">
                  CANCEL
                </button>
              </div>
            </div>
          </div>

        </div>
      </section>

      <!-- ========== PAST SECTION ========== -->
      <section id="pastSection" class="mt-14 flex justify-center hidden">
        <div class="w-[760px] flex gap-10">

          <!-- Timeline left -->
          <div class="relative w-[160px]">
            <div class="absolute left-[22px] top-1 w-4 h-4 bg-orange-400 rounded-full"></div>
            <div class="absolute left-[28px] top-5 w-[6px] h-[320px] bg-[#8b0000] rounded-full"></div>

            <div class="pl-14 pt-0">
              <p class="text-[20px] font-semibold text-[#8b0000]">January 10</p>
            </div>
          </div>

          <!-- Card -->
          <div class="flex-1">
            <div class="bg-[#f3f3f3] rounded-2xl border border-gray-200 shadow-md px-10 py-7">
              <div class="grid grid-cols-4 text-center text-[12px] font-semibold text-[#b46b6b]">
                <p>Date</p>
                <p>Service</p>
                <p>Name</p>
                <p>Program</p>
              </div>

              <div class="mt-4 grid grid-cols-4 text-center text-[11px] text-[#8b0000]">
                <div class="leading-tight">
                  <p>January 10,</p>
                  <p>2025</p>
                </div>
                <p>Tooth Extraction</p>
                <p>Juan Dela Cruz</p>
                <p>BSIT</p>
              </div>

              <div class="mt-5 h-px w-full bg-gray-300/70"></div>

              <div class="mt-3 flex justify-end gap-2">
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-white bg-gray-500">
                  Done
                </button>
              </div>
            </div>
          </div>

        </div>
      </section>

      <div class="h-40"></div>
    </main>

  <script>

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

    btnUpcoming.addEventListener("click", () => setActiveTab("upcoming"));
    btnPast.addEventListener("click", () => setActiveTab("past"));
  </script>
</body>
</html>
