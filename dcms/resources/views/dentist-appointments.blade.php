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
        January 29
      </p>
    </div>

    <!-- APPOINTMENT CARD -->
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
          <p>Alliah Gomez</p>
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

<!-- ================= FOOTER ================= -->
<footer class="bg-primaryDark text-white mt-12">
  <div class="max-w-6xl mx-auto p-6 grid grid-cols-3 text-sm">
    <div>
      <p class="font-semibold mb-2">PUP Taguig Dental Clinic</p>
      <p>Gen. Santos Ave, Upper Bicutan</p>
      <p>Taguig City</p>
    </div>

    <div>
      <p class="font-semibold mb-2">Navigation</p>
      <p>Dashboard</p>
      <p>Appointments</p>
      <p>Patients</p>
    </div>

    <div>
      <p class="font-semibold mb-2">Services</p>
      <p>Dental Check-up</p>
      <p>Tooth Cleaning</p>
      <p>Dental Restoration</p>
    </div>
  </div>
</footer>

</body>
</html>
