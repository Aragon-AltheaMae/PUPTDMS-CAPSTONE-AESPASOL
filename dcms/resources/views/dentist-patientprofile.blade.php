<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Patient Profile</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + DaisyUI CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css"/>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'ui-sans-serif'] },
          colors: {
            primary: '#8B0000'
          }
        }
      }
    }
  </script>
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
        $notifications = collect($notifications ?? []);
        $notifCount = $notifications->count();
      @endphp

      <!-- Notification Dropdown -->
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

      <!-- User Info Section -->
      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
        <div class="text-sm">
          <p class="font-semibold">Dr. Nelson Angeles</p>
          <p class="text-xs opacity-80">Dentist</p>
        </div>

        <!-- Logout Form -->
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
        <span class="font-bold">Patients</span>
      </a>
      <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-calendar-check text-lg"></i>
        <span>Appointments</span>
      </a>
      <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-box text-lg"></i>
        <span>Inventory</span>
      </a>
      <a href="{{ route('dentist.report') }}" class="flex flex-col items-center ">
        <i class="fa-solid fa-file text-lg"></i>
        <span>Reports</span>
      </a>
    </nav>
  </header>

<!-- ================= MAIN ================= -->
<main class=" mx-auto px-10 py-8 space-y-10">

  <!-- Page Title with Back Arrow -->
  <div class="flex items-center gap-4 mb-6">
    <a href="/dentist/patients" class="w-10 h-10 flex items-center justify-center rounded-full border border-orange-400 text-orange-500 hover:bg-orange-100 transition">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-medium text-primary ml-4">Patient Profile</h1>
  </div>

    <!-- ================= PATIENT PROFILE ================= -->
    <section>
      <div class="max-w-5xl mx-auto bg-gradient-to-r from-[#8B0000] to-[#5e0000] rounded-2xl text-white px-14 py-10 shadow-xl">
        <div class="flex items-center gap-2">
          <img src="https://i.pravatar.cc/180" class="w-36 h-36 rounded-full object-cover border-4 border-[#7a0000] mt-3" />
          <div class="shrink-0 w-[400px] mt-2 pl-4">
            <p class="text-3xl font-bold leading-tight mt-1">Capilitan, Beyonce</p>
            <p class="text-base font-semibold mt-2">2023-00099-TG-0</p>
            <p class="text-base font-semibold mt-0.5 leading-tight">BSIT 3-1</p>
          </div>
          <div class="grid grid-cols-[auto,1fr] gap-x-3 gap-y-2 text-sm mt-14">
            <span class="font-semibold">Age:</span>
            <span class="font-semibold">18</span>
            <span class="font-semibold">Birthdate:</span>
            <span class="font-semibold">January 01, 2004</span>
            <span class="font-semibold">Sex:</span>
            <span class="font-semibold">Female</span>
          </div>
        </div>
        <div class="flex justify-center mt-8">
          <button class="px-10 py-3 rounded-lg border border-yellow-400 text-yellow-300 hover:bg-yellow-400 hover:text-[#5e0000] transition font-medium">
            View Odontogram
          </button>
        </div>
      </div>
    </section>

     <!-- ================= HISTORY ================= -->
    <section class="max-w-6xl mx-auto px-14 py-10 space-y-8">
      <div class="text-center">
        <h2 class="text-3xl font-bold text-[#660000]">History</h2>
      </div>

      <div class="flex gap-8 justify-start mb-6">
        <button id="dentalTab" onclick="showDental()" class="tab-btn text-primary font-semibold text-lg border-b-2 border-[#8B0000] pb-3 px-4 transition">Dental</button>
        <button id="medicalTab" onclick="showMedical()" class="tab-btn text-gray-400 hover:text-primary font-semibold text-lg pb-3 px-4 transition">Medical</button>
      </div>

      <!-- ================= DENTAL CONTENT ================= -->
      <div id="dentalContent" class="max-w-6xl mx-auto bg-white rounded-2xl border-2 border-[#8B0000] p-10 shadow-lg">
        <div class="space-y-6">
          <div class="flex gap-10 items-center">
            <div class="h-[120px] w-[3px] bg-gradient-to-b from-[#800000] via-[#FF4500] to-[#FFA500] rounded"></div>
            <div class="space-y-2 text-sm ml-4">
              <p class="text-primary font-extrabold text-lg">Previous Dentist:</p>
              <p class="text-gray-800 text-lg">Dr. Abby Salle</p>
              <p class="text-primary font-extrabold text-lg mt-2">Last Dental Visit:</p>
              <p class="text-gray-700 text-lg">April 23, 2024</p>
            </div>
          </div>

          <div class="flex gap-10 items-center">
            <div class="h-[120px] w-[3px] bg-gradient-to-b from-[#800000] via-[#FF4500] to-[#FFA500] rounded"></div>
            <div class="space-y-3 text-sm ml-4">
              <p class="text-primary font-extrabold text-lg">Previous Treatment</p>
              <p class="text-gray-800 text-lg flex items-center gap-2">
                <span class="text-orange-500 text-xl leading-none">•</span>
                Dental Restoration & Prosthesis
              </p>
              <p class="text-gray-600 text-xs">
              <span class="text-[#8B0000] text-lg font-semibold">Diagnosis:</span> 
              <span class="text-lg font-semibold">AB - Abutment</span>
              </p>
            <p class="text-primary text-lg font-semibold mt-2">Dr. Nelson Angeles</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= MEDICAL CONTENT (Hidden Initially) ================= -->
      <div id="medicalContent" class="hidden max-w-6xl mx-auto bg-white rounded-2xl border-2 border-[#8B0000] p-10 shadow-lg">
        <div class="space-y-6">
          <div class="flex gap-10 items-center">
            <div class="h-[120px] w-[3px] bg-gradient-to-b from-[#800000] via-[#FF4500] to-[#FFA500] rounded"></div>
            <div class="space-y-2 text-sm ml-4">
              <p class="text-primary font-extrabold text-lg">Medical Condition:</p>
              <p class="text-gray-800 text-lg">No known medical conditions</p>

              <p class="text-primary font-extrabold text-lg mt-2">Allergies:</p>
              <p class="text-gray-700 text-lg">None reported</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<!-- ================= CLINIC VISITS ================= -->
<section class="max-w-5xl mx-auto fade-up mt-16">
  <div class="flex justify-center items-center mb-4 mt-28">
    <h2 class="text-3xl font-bold text-[#660000]">Clinic Visits</h2>
  </div>

  <!-- Add a div to wrap the whole section and apply the background -->
  <div class="bg-gray-200 p-10 rounded-2xl">
    <!-- Tabs for History -->
    <div class="tabs tabs-bordered mb-6">
      <a id="futureTab" class="tab tab-active font-bold text-[#660000] cursor-pointer" onclick="showFuture()">Future Visits</a>
      <a id="pastTab" class="tab text-[#660000] cursor-pointer" onclick="showPast()">Past Visits</a>
    </div>

<!-- ================= FUTURE VISITS ================= -->
<div id="futureContent" class="text-center py-10 text-[#333333]">
  <div class="border-l-4 border-[#8B0000] bg-[#FFECEC] p-6 rounded-2xl"> <!-- Left border set to #8B0000 -->
    <img src="{{ asset('images/future-visit.png') }}" class="w-24 h-24 mx-auto mb-4" alt="No Upcoming Visits">
    <p class="text-lg font-semibold text-[#660000]">No Upcoming Visits</p>
    <p class="text-sm text-[#ADADAD]">You currently have no scheduled appointments.</p>
  </div>
</div>



    <!-- ================= PAST VISITS ================= -->
    <div id="pastContent" class="text-center py-10 text-[#333333] hidden">
  <div class="border-l-4 border-[#8B0000] bg-[#FFECEC] p-6 rounded-2xl"> <!-- Left border set to #8B0000 -->
      <img src="{{ asset('images/past-visit.png') }}" class="w-24 h-24 mx-auto mb-4" alt="No Past Visits">
      <p class="text-lg font-semibold text-[#660000]">No Past Visits Yet</p>
      <p class="text-sm text-[#ADADAD]">Your completed appointments will appear here.</p>
    </div>
  </div>
</section>



<script>
  // Tailwind configuration
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: { sans: ['Inter', 'ui-sans-serif'] },
        colors: {
          primary: '#8B0000'
        }
      }
    }
  }

  

  // Show Future Visits content
  function showFuture() {
    document.getElementById('futureContent').classList.remove('hidden');
    document.getElementById('pastContent').classList.add('hidden');
    document.getElementById('futureTab').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
    document.getElementById('pastTab').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
  }

  // Show Past Visits content
  function showPast() {
    document.getElementById('pastContent').classList.remove('hidden');
    document.getElementById('futureContent').classList.add('hidden');
    document.getElementById('pastTab').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
    document.getElementById('futureTab').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
  }

    // Show Dental History content
  function showDental() {
    document.getElementById('dentalContent').classList.remove('hidden');
    document.getElementById('medicalContent').classList.add('hidden');
    document.getElementById('dentalTab').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
    document.getElementById('medicalTab').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
  }

  // Show Medical History content
  function showMedical() {
    document.getElementById('medicalContent').classList.remove('hidden');
    document.getElementById('dentalContent').classList.add('hidden');
    document.getElementById('medicalTab').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
    document.getElementById('dentalTab').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
  }
  // Initialize the view to show future visits by default
  showFuture(); // By default, it will show future visits.
  showDental(); // By default, it will show the dental tab.
  </script>
