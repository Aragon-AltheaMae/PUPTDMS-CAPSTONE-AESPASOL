<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointments</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
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

        <a href="{{ route('dentist.report') }}" class="flex flex-col items-center opacity-70 hover:opacity-100">
          <i class="fa-solid fa-file text-base mb-1"></i>
          <span>Reports</span>
        </a>
      </nav>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="max-w-6xl mx-auto px-6">

     <!-- Toggle pill -->
<div class="flex justify-center mt-14">
  <div class="w-[760px] h-14 bg-[#7a0000] rounded-full p-1.5 flex shadow-md">

    <button
      id="btnUpcoming"
      class="flex-1 rounded-full bg-[#8b0000]
             text-white text-sm font-semibold
             transition-all duration-200">
      Upcoming Appointments
    </button>

    <button
      id="btnPast"
      class="flex-1 rounded-full
             text-white/80 text-sm font-semibold
             transition-all duration-200">
      Past Appointments
    </button>

  </div>
</div>


<!-- ========== UPCOMING SECTION ========== -->
<section id="upcomingSection" class="mt-14 flex justify-center">
  <div class="w-[1100px]">


    <!-- LEFT LINE + DOT + CONTENT -->
    <div class="relative pl-10">
      <!-- vertical line -->
      <div class="absolute left-[6px] top-[6px] w-[2px] h-[220px] bg-[#8b0000]"></div>

      <!-- orange dot -->
      <div class="absolute left-[0px] top-[0px] w-3 h-3 bg-orange-400 rounded-full"></div>

      <!-- Month label -->
      <h2 class="text-xl font-semibold text-[#8b0000] mb-6">February</h2>

    <!-- TABLE HEADER -->
          <div class="grid grid-cols-[36px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr_1.6fr]
                text-[13px] font-semibold text-[#8b0000]
                pb-3 border-b border-gray-400 mb-6 px-8">
        <div></div>
        <p>Date</p>
        <p>Time</p>
        <p>Service</p>
        <p>Name</p>
        <p>Program</p>
        <p class="text-right pr-2">Action</p>
      </div>
   <div class="bg-[#f3f3f3] rounded-xl shadow-md border border-gray-200 px-8 py-5">

  <div class="grid grid-cols-[36px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr_1.6fr]
              items-center text-[13px] text-[#8b0000]">

    <!-- dots -->
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
     <button
        onclick="openStartProcedureModal()"
        class="h-6 w-[130px] rounded-md text-[11px] font-semibold
              text-white bg-green-600
              cursor-pointer hover:bg-green-700 transition">
        Start Procedure
      </button>


     <button
        onclick="openRescheduleModal()"
        class="h-6 w-[130px] rounded-md text-[11px] font-semibold
              text-black bg-yellow-400
              cursor-pointer hover:bg-yellow-500 transition">
        Reschedule
      </button>


      <button
        onclick="openCancelAppointmentModal()"
        class="h-6 w-[130px] rounded-md text-[11px] font-semibold
              text-white bg-[#8b0000]
              cursor-pointer hover:bg-[#6f0000] transition">
        Cancel
      </button>

    </div>

    <!-- ================= RESCHEDULE MODAL ================= -->
<div id="rescheduleModal"
     class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">

  <div class="bg-white w-[520px] rounded-2xl p-10 text-center shadow-xl">

    <!-- Title -->
    <h2 class="text-2xl font-bold text-[#8b0000] mb-6">
      Reschedule Appointment
    </h2>

    <!-- Message -->
    <p class="text-lg font-semibold text-[#8b0000] mb-2">
      Are you sure you want to<br>
      reschedule this appointment?
    </p>

    <p class="text-sm text-gray-500 mb-10">
      You will be able to select a new date and time.
    </p>

    <!-- Buttons -->
    <div class="flex justify-center gap-6">
      <button
        onclick="closeRescheduleModal()"
        class="px-8 py-2 rounded-full border border-[#8b0000]
               text-[#8b0000] font-semibold
               hover:bg-[#8b0000] hover:text-white transition">
        Cancel
      </button>

      <button
        onclick="confirmReschedule()"
        class="px-10 py-2 rounded-full bg-[#8b0000]
               text-white font-semibold
               hover:bg-[#6f0000] transition">
        Yes
      </button>
    </div>

  </div>
</div>
  </div>
</section>

<!-- ================= START PROCEDURE MODAL ================= -->
<div id="startProcedureModal"
     class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">

  <div class="bg-white w-[620px] min-h-[320px] rounded-2xl p-10 shadow-xl">

    <!-- Title -->
    <h2 class="text-2xl font-semibold text-black mb-8">
      Confirm the start of procedure?
    </h2>

    <!-- Patient Row -->
    <div class="flex items-center gap-4 mb-10">
      <label class="text-[#8b0000] font-medium w-[80px]">
        Patient:
      </label>

      <!-- INPUT FIELD -->
      <input
        type="text"
        id="patientNameInput"
        placeholder="Enter patient name"
        class="h-10 w-[360px] rounded-md px-4
               bg-[#8b0000] text-white
               placeholder:text-white/70
               focus:outline-none focus:ring-2 focus:ring-[#8b0000]"
      />
    </div>

    <!-- Buttons -->
    <div class="flex gap-4">
      <button
        onclick="confirmStartProcedure()"
        class="bg-green-500 hover:bg-green-600
               text-white px-10 py-2 rounded-md
               font-semibold transition">
        START
      </button>

      <button
        onclick="closeStartProcedureModal()"
        class="bg-gray-400 hover:bg-gray-500
               text-white px-10 py-2 rounded-md
               font-semibold transition">
        BACK
      </button>
    </div>

  </div>
</div>

<!-- ================= CANCEL APPOINTMENT MODAL ================= -->
<div id="cancelAppointmentModal"
     class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">

  <div class="bg-white w-[520px] rounded-2xl p-10 text-center shadow-xl">

    <!-- Title -->
    <h2 class="text-2xl font-bold text-black mb-6">
      Cancel Appointment
    </h2>

    <!-- Message -->
    <p class="text-lg font-semibold text-[#8b0000] mb-2">
      Are you sure you want to<br>
      cancel this appointment?
    </p>

    <p class="text-sm text-gray-500 mb-10">
      This action cannot be undone.
    </p>

    <!-- Buttons -->
    <div class="flex justify-center gap-6">
      <button
        onclick="closeCancelAppointmentModal()"
        class="px-8 py-2 rounded-full border border-[#8b0000]
               text-[#8b0000] font-semibold
               hover:bg-[#8b0000] hover:text-white transition">
        No
      </button>

      <button
        onclick="confirmCancelAppointment()"
        class="px-10 py-2 rounded-full bg-[#8b0000]
               text-white font-semibold
               hover:bg-[#6f0000] transition">
        Yes
      </button>
    </div>

  </div>
</div>





   <!-- ========== PAST SECTION ========== -->
<section id="pastSection" class="mt-14 flex justify-center hidden">
  <div class="w-[1100px]">

    <!-- LEFT LINE + DOT + CONTENT -->
    <div class="relative pl-10">
      <!-- vertical line -->
      <div class="absolute left-[6px] top-[6px] w-[2px] h-[200px] bg-[#8b0000]"></div>

      <!-- orange dot -->
      <div class="absolute left-[0px] top-[0px] w-3 h-3 bg-orange-400 rounded-full"></div>

      <!-- Month label -->
      <h2 class="text-xl font-semibold text-[#8b0000] mb-6">January</h2>

      <!-- TABLE HEADER (NO ACTION) -->
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
      <div class="bg-[#f3f3f3] rounded-xl shadow-md border border-gray-200 px-8 py-5">

        <div class="grid grid-cols-[32px_1.8fr_1.2fr_1.8fr_1.8fr_1.2fr]
                    items-center text-[13px] text-[#8b0000]">

          <!-- dots -->
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


      <div class="h-40"></div>
    </main>

    <!-- ================= FOOTER ================= -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">

  <!-- ASIDE: CLINIC INFO -->
  <aside class="space-y-4">
    <div class="flex items-center gap-3">
      
      <!-- Logos -->
      <div class="w-12">
        <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" class="w-12 h-auto">
      </div>

      <div class="w-12">
    <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" class="w-full h-auto" />
      </div>

      <!-- Text -->
      <div>
        <p class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</p>
        <p class="text-sm whitespace-nowrap">
          Polytechnic University of the Philippines – Taguig Campus
        </p>
      </div>
    </div>

    <!-- Location -->
    <div class="flex items-start gap-3 text-sm">
      <img src="{{ asset('images/footer-location.png') }}" class="w-4 h-5 mt-0.5" />
      <p>Gen. Santos Ave., Upper Bicutan, Taguig City</p>
    </div>

    <!-- Email -->
    <div class="flex items-center gap-3 text-sm">
      <img src="{{ asset('images/footer-email.png') }}" class="w-5 h-4" />
      <p>pupdental@pup.edu.ph</p>
    </div>

    <!-- Phone -->
    <div class="flex items-center gap-3 text-sm">
      <img src="{{ asset('images/footer-phone.png') }}" class="w-4 h-4" />
      <p>(02) 123-4567</p>
    </div>
  </aside>

  <!-- NAVIGATION -->
  <nav>
    <h6 class="footer-title text-[#F4F4F4]">Navigation</h6>
    <a href="#" class="link link-hover text-[#F4F4F4]">Home</a>
    <a href="#" class="link link-hover text-[#F4F4F4]">Appointment</a>
    <a href="#" class="link link-hover text-[#F4F4F4]"> Record</a>
    <a href="#" class="link link-hover text-[#F4F4F4]">About Us</a>
  </nav>

  <!-- SERVICES -->
  <nav>
    <h6 class="footer-title text-[#F4F4F4]">Services</h6>
    <a class="link link-hover text-[#F4F4F4]">Oral Check-up</a>
    <a class="link link-hover text-[#F4F4F4]">Tooth Cleaning</a>
    <a class="link link-hover text-[#F4F4F4]">Tooth Extraction</a>
    <a class="link link-hover text-[#F4F4F4]">Dental Consultation</a>
  </nav>

</footer>

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
          // 🔧 Replace with real cancel logic (API / Laravel route)
          alert("Appointment cancelled.");
          closeCancelAppointmentModal();
        }
    btnUpcoming.addEventListener("click", () => setActiveTab("upcoming"));
    btnPast.addEventListener("click", () => setActiveTab("past"));
  </script>
</body>
</html>
