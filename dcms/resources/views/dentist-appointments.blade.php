<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointments</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

      <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            colors: {
              primaryDark: "#7a0000",
              primaryMain: "#8b0000"
            }
          }
        }
      }
    </script>

</head>

<body class="bg-gray-100 font-sans">

<!-- ================= TOP HEADER ================= -->
<header class="bg-gradient-to-r from-primaryDark to-primaryMain text-white px-8 py-4 flex justify-between items-center">
  <div class="flex items-center gap-3 font-bold">
    <i class="fa-solid fa-tooth text-xl"></i>
    <span>PUP TAGUIG DENTAL CLINIC</span>
  </div>

  <div class="flex items-center gap-3">
    <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
    <div class="text-sm">
      <p class="font-semibold">Dr. Nelson Angeles</p>
      <p class="text-xs opacity-80">Dentist</p>
    </div>
  </div>
</header>

<!-- ================= NAV ================= -->
<header class="bg-primaryMain text-white px-8 py-3">
  <nav class="flex justify-around text-sm">
    <a href="{{ route('dentist.dashboard') }}" class="flex flex-col items-center opacity-80 hover:opacity-100">
      <i class="fa-solid fa-chart-line text-lg"></i>
      <span>Dashboard</span>
    </a>

    <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center opacity-80 hover:opacity-100">
      <i class="fa-solid fa-users text-lg"></i>
      <span>Patients</span>
    </a>

    <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center opacity-100">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>

    <a class="flex flex-col items-center opacity-80">
      <i class="fa-solid fa-box text-lg"></i>
      <span>Inventory</span>
    </a>

    <a class="flex flex-col items-center opacity-80">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>
  </nav>
</header>

<!-- ================= MAIN ================= -->
<main class="p-8 max-w-5xl mx-auto">

  <!-- TITLE + FILTER -->
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-red-800">Appointments</h1>

    <div class="flex gap-2">
      <a href="#" class="btn btn-sm btn-error rounded-full px-6">
        Upcoming Appointments
      </a>
      <a href="#" class="btn btn-sm btn-outline btn-error rounded-full px-6">
        Past Appointments
      </a>
    </div>
  </div>

  <!-- ================= TIMELINE ================= -->
  <div class="relative pl-10">

    <!-- Vertical Line -->
    <div class="absolute left-4 top-0 h-full w-1 bg-red-300 rounded"></div>

    <!-- DATE -->
    <div class="mb-6 relative">
      <div class="absolute -left-[6px] top-1 w-4 h-4 bg-orange-400 rounded-full"></div>
      <p class="text-sm font-semibold text-gray-600 ml-6">
        January 7
      </p>
    </div>

    <!-- APPOINTMENT CARD 1-->
    <div class="bg-white rounded-xl shadow p-6 ml-6 mb-8 border border-red-200">

      <div class="grid grid-cols-5 gap-4 text-sm items-center">

        <div>
          <p class="font-semibold text-gray-500">Date</p>
          <p>February 2, 2025</p>
          <p class="text-xs text-gray-400">10:00 AM</p>
        </div>

        <div>
          <p class="font-semibold text-gray-500">Service</p>
          <p>Dental Cleaning</p>
        </div>

        <div>
          <p class="font-semibold text-gray-500">Name</p>
          <p>Beyonce Capilitan</p>
        </div>

        <div>
          <p class="font-semibold text-gray-500">Program</p>
          <p>BSIT</p>
        </div>

        <div class="flex flex-col gap-2">
          <button class="btn btn-xs btn-success">Start Procedure</button>
          <button class="btn btn-xs btn-warning">Reschedule</button>
          <button class="btn btn-xs btn-error">Cancel</button>
        </div>

      </div>
    </div>


    <!-- APPOINTMENT CARD 2 -->
    <div class="bg-white rounded-xl shadow p-6 ml-6 mb-8 border border-red-200">
      <div class="grid grid-cols-5 gap-4 text-sm items-center">

        <div>
          <p class="font-semibold text-gray-500">Date</p>
          <p>February 2, 2025</p>
          <p class="text-xs text-gray-400">11:30 AM</p>
        </div>

        <div>
          <p class="font-semibold text-gray-500">Service</p>
          <p>Tooth Extraction</p>
        </div>

        <div>
          <p class="font-semibold text-gray-500">Name</p>
          <p>Britney Caculitan</p>
        </div>

        <div>
          <p class="font-semibold text-gray-500">Program</p>
          <p>BSME</p>
        </div>

        <div class="flex flex-col gap-2">
          <button class="btn btn-xs btn-success">Start Procedure</button>
          <button class="btn btn-xs btn-warning">Reschedule</button>
          <button class="btn btn-xs btn-error">Cancel</button>
        </div>

      </div>
    </div>

  </div>
</main>

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

</body>
</html>
