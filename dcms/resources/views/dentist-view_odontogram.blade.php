<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Highcharts -->
  <script src="https://code.highcharts.com/highcharts.js"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primaryDark: "#7a0000",
            primaryMain: "#8b0000",
            gold: "#FFD700"
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-100">


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
<header class="bg-primaryMain text-white px-8 py-3">
  <nav class="flex justify-around text-sm">
    <a href="{{ route('dentist.dashboard') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-chart-line text-lg"></i>
      <span>Dashboard</span>
    </a>

    <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-users text-lg"></i>
      <span>Patients</span>
    </a>

    <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>
    
    <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-box text-lg"></i>
      <span>Inventory</span>
    </a>

    <a href="{{ route('dentist.report') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-file text-lg"></i>
      <span class="font-bold">Reports</span>
    </a>

  </nav>
</header>

<body class="bg-gray-100">

<!-- ================= MAIN ================= -->
<main class="max-w-6xl mx-auto mt-10 px-6">

  <!-- ================= PATIENT HEADER ================= -->
  <div class="bg-gradient-to-r from-[#8B0000] to-[#5e0000]
              rounded-2xl text-white px-10 py-6 shadow-lg mb-10">

    <div class="flex items-center gap-6">
      <img src="https://i.pravatar.cc/120"
           class="w-24 h-24 rounded-full border-4 border-[#7a0000] object-cover">

      <div class="flex-1">
        <p class="text-2xl font-bold">Capilitan, Beyonce</p>
        <p class="text-sm font-semibold mt-1">2023-00099-TG-0</p>
        <p class="text-sm font-semibold">BSIT 3-1</p>
      </div>

      <div class="text-sm space-y-1">
        <p><span class="font-semibold">Age:</span> 18</p>
        <p><span class="font-semibold">Sex:</span> Female</p>
      </div>
    </div>
  </div>

  <!-- ================= ODONTOGRAM RECORDS ================= -->
  <div class="space-y-6">

    <!-- ================= DONE RECORD ================= -->
    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">

      <div class="flex justify-between items-start">
        <!-- LEFT INFO -->
        <div class="flex items-center gap-6">

          <!-- DATE -->
          <div class="text-center w-14">
            <p class="text-xs text-gray-400">MAY</p>
            <p class="text-2xl font-bold text-[#8B0000]">03</p>
          </div>

          <!-- CONDITION -->
          <div>
            <p class="text-xs text-gray-400 uppercase">Condition</p>
            <p class="font-semibold">Caries</p>
          </div>

          <!-- TOOTH NUMBER -->
          <div>
            <p class="text-xs text-gray-400 uppercase">Tooth #</p>
            <p class="font-semibold">14</p>
          </div>

          <!-- TREATMENT -->
          <div>
            <p class="text-xs text-gray-400 uppercase">Treatment</p>
            <p class="font-semibold">Tooth Filling</p>
          </div>
        </div>

        <!-- STATUS -->
        <span class="flex items-center gap-1 text-green-600 font-semibold text-sm">
          <i class="fa-solid fa-circle-check"></i> Done
        </span>
      </div>

      <!-- NOTES -->
      <div class="mt-4 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm flex items-center gap-2">
        <i class="fa-solid fa-tooth text-[#8B0000]"></i>
        Advanced Decay
      </div>
    </div>

    <!-- ================= PENDING RECORD ================= -->
    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">

      <div class="flex justify-between items-start">
        <div class="flex items-center gap-6">

          <!-- DATE -->
          <div class="text-center w-14">
            <p class="text-xs text-gray-400">APR</p>
            <p class="text-2xl font-bold text-[#8B0000]">12</p>
          </div>

          <!-- CONDITION -->
          <div>
            <p class="text-xs text-gray-400 uppercase">Condition</p>
            <p class="font-semibold">Caries</p>
          </div>

          <!-- TOOTH NUMBER -->
          <div>
            <p class="text-xs text-gray-400 uppercase">Tooth #</p>
            <p class="font-semibold">14</p>
          </div>

          <!-- TREATMENT -->
          <div>
            <p class="text-xs text-gray-400 uppercase">Treatment</p>
            <p class="font-semibold">Tooth Filling</p>
          </div>
        </div>

        <!-- STATUS -->
        <span class="flex items-center gap-1 text-yellow-500 font-semibold text-sm">
          <i class="fa-solid fa-hourglass-half"></i> Pending
        </span>
      </div>

      <!-- REASON -->
      <div class="mt-4 space-y-2 text-sm">
        <p class="text-gray-600">
          <span class="font-semibold text-[#8B0000]">Reason:</span>
          Not enough time
        </p>

        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 flex items-center gap-2">
          <i class="fa-solid fa-tooth text-[#8B0000]"></i>
          Decay in pulp
        </div>
      </div>
    </div>

  </div>

    <div class="h-20"></div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">

  <!-- ASIDE: CLINIC INFO -->
  <aside class="space-y-4">
    <div class="flex items-center gap-3">

      <div class="w-12">
        <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" class="w-12 h-auto">
      </div>

      <div class="w-12">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" class="w-full h-auto" />
      </div>

      <div>
        <p class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</p>
        <p class="text-sm whitespace-nowrap">
          Polytechnic University of the Philippines – Taguig Campus
        </p>
      </div>
    </div>

    <div class="flex items-start gap-3 text-sm">
      <img src="{{ asset('images/footer-location.png') }}" class="w-4 h-5 mt-0.5" />
      <p>Gen. Santos Ave., Upper Bicutan, Taguig City</p>
    </div>

    <div class="flex items-center gap-3 text-sm">
      <img src="{{ asset('images/footer-email.png') }}" class="w-5 h-4" />
      <p>pupdental@pup.edu.ph</p>
    </div>

    <div class="flex items-center gap-3 text-sm">
      <img src="{{ asset('images/footer-phone.png') }}" class="w-4 h-4" />
      <p>(02) 123-4567</p>
    </div>
  </aside>

  <nav>
    <h6 class="footer-title text-[#F4F4F4]">Navigation</h6>
    <a class="link link-hover text-[#F4F4F4]">Home</a>
    <a class="link link-hover text-[#F4F4F4]">Appointment</a>
    <a class="link link-hover text-[#F4F4F4]">Record</a>
    <a class="link link-hover text-[#F4F4F4]">About Us</a>
  </nav>

  <nav>
    <h6 class="footer-title text-[#F4F4F4]">Services</h6>
    <a class="link link-hover text-[#F4F4F4]">Oral Check-up</a>
    <a class="link link-hover text-[#F4F4F4]">Tooth Cleaning</a>
    <a class="link link-hover text-[#F4F4F4]">Tooth Extraction</a>
    <a class="link link-hover text-[#F4F4F4]">Dental Consultation</a>
  </nav>

</footer>

</body>
</html>
