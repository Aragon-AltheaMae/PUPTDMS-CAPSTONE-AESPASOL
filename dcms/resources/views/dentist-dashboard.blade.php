<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Dentist Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Cally Calendar -->
  <script type="module" src="https://unpkg.com/cally"></script>

  <!-- Highcharts -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  

  <!-- Tailwind config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primaryDark: "#7a0000",
            primaryMain: "#8b0000"
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-100">

<!-- ================= TOP HEADER ================= -->
<header class="bg-gradient-to-r from-primaryDark to-primaryMain text-white px-8 py-4 flex justify-between items-center">
  <div class="flex items-center gap-3 font-bold">
    <i class="fa-solid fa-tooth text-xl"></i>
    <span>PUP TAGUIG DENTAL CLINIC</span>
  </div>

  <div class="flex items-center gap-6">
    <i class="fa-regular fa-bell text-lg cursor-pointer"></i>

    <div class="flex items-center gap-3">
      <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
      <div class="text-sm">
        <p class="font-semibold">Dr. Nelson Angeles</p>
        <p class="text-xs opacity-80">Dentist</p>
      </div>
      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="cursor-pointer text-red-600 hover:text-red-800">
            <i class="fa-solid fa-right-from-bracket text-lg"></i>
        </button>
      </form>

    </div>
  </div>
</header>

<!-- ================= NAV HEADER ================= -->
<header class="bg-primaryMain text-white px-8 py-3">
  <nav class="flex justify-around text-sm">
    <a class="flex flex-col items-center opacity-100">
      <i class="fa-solid fa-chart-line text-lg"></i>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('dentist.patients') }}"
      class="flex flex-col items-center opacity-80 hover:opacity-100">
      <i class="fa-solid fa-users text-lg"></i>
      <span>Patients</span>
    </a>

    <a href="{{ route('dentist.appointments') }}"
      class="flex flex-col items-center opacity-80 hover:opacity-100">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>

    <a class="flex flex-col items-center opacity-80 hover:opacity-100">
      <i class="fa-solid fa-box text-lg"></i>
      <span>Inventory</span>
    </a>
    <a class="flex flex-col items-center opacity-80 hover:opacity-100">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>
  </nav>
</header>

<!-- ================= MAIN ================= -->
<main class="p-8">

  <!-- GREETING -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <p id="currentDate" class="text-sm text-gray-500 mb-1"></p>
      <h1 class="text-3xl font-bold">
        <span class="bg-gradient-to-r from-orange-400 to-red-700 bg-clip-text text-transparent">
             Good Morning,
          <span id="dentistName"></span>
        </span>
      </h1>
    </div>

    <div class="flex items-center gap-3">
      <span class="text-sm">The Dentist is</span>
      <button id="statusBtn" class="btn btn-success rounded-full px-6">IN</button>
    </div>
  </div>

  <!-- ================= GRID ================= -->
  <div class="grid grid-cols-12 gap-6">

    <!-- GAD ANALYTICS -->
    <div class="col-span-5 card bg-white shadow">
    <div class="card-body">
        <div id="gadChart" class="h-full w-full"></div>
      </div>
    </div>


    <!-- DENTAL STATS COLUMN -->
    <div class="col-span-2 flex flex-col gap-4 h-full">

    <!-- DENTAL CASES -->
    <div class="card bg-primaryMain text-white shadow flex-1">
        <div class="card-body p-6 text-center justify-center">
        <p class="text-s">Dental Cases</p>
        <p class="text-4xl font-bold">45</p>
        <p class="text-xs">December 2025</p>
        </div>
    </div>

    <!-- TOTAL APPOINTMENTS -->
    <div class="card bg-white text-red-700 shadow flex-1 border border-gray-200">
        <div class="card-body p-6 text-center justify-center">
        <p class="text-s">Total Appointments</p>
        <p class="text-4xl font-bold">62</p>
        <p class="text-xs">December 2025</p>
        </div>
    </div>

    </div>


    <!-- Calendar Section -->
    <div id="calendarSkeletonContainer" class="flex flex-col gap-2 col-span-5">

        <!-- Calendar Card -->
        <div class="bg-white border shadow rounded-2xl p-6 w-full">
            <calendar-date class="cally w-full h-full flex flex-col p-2">
            <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
                <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>

            <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
                <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>

            <calendar-month class="w-full flex-1"></calendar-month>
            </calendar-date>
        </div>

        <!-- Legend -->
        <div class="flex gap-6 mt-3 text-sm justify-center">
            <div class="flex items-center gap-2">
            <span class="w-4 h-4 bg-red-500 rounded"></span> Full Schedule
            </div>
            <div class="flex items-center gap-2">
            <span class="w-4 h-4 bg-orange-400 rounded"></span> Not Available
            </div>
            <div class="flex items-center gap-2">
            <span class="w-4 h-4 bg-blue-500 rounded"></span> Holiday
            </div>
        </div>
    </div>



    <!-- INVENTORY COLUMN -->
    <div class="col-span-5 flex flex-col gap-6">

    <!-- MEDICAL SUPPLY INVENTORY -->
    <div class="relative rounded-lg p-[2px]" style="background: linear-gradient(to bottom, #660000, #FFD700);">
        <div class="card bg-white shadow border border-transparent rounded-lg">
        <div class="card-body">
            <h3 class="font-semibold text-red-700 mb-2 flex items-center gap-2">
            <i class="fa-solid fa-boxes"></i> Medical Supply Inventory
            </h3>
            <table class="table table-sm">
            <thead>
                <tr class="text-red-700">
                <th>Supplies</th><th>Units</th><th>Qty</th><th>Consumed</th><th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>Disposable Dental Needles Short</td>
                <td>piece</td>
                <td>42</td>
                <td>8</td>
                <td>34</td>
                </tr>
            </tbody>
            </table>
            <button class="mt-3 px-6 py-2 rounded-lg font-semibold" style="background-color: #8B0000; color: white; width: fit;">Visit Inventory
            </button>
        </div>
        </div>
    </div>

    <!-- MEDICINE SUPPLY INVENTORY -->
    <div class="relative rounded-lg p-[2px]" style="background: linear-gradient(to bottom, #660000, #FFD700);">
        <div class="card bg-white shadow border border-transparent rounded-lg">
        <div class="card-body">
            <h3 class="font-semibold text-red-700 mb-2 flex items-center gap-2">
            <i class="fa-solid fa-pills"></i> Medicine Supply Inventory
            </h3>
            <table class="table table-sm">
            <thead>
                <tr class="text-red-700">
                <th>Medicine</th><th>Form</th><th>Qty</th><th>Used</th><th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>Amoxicillin</td>
                <td>Capsule</td>
                <td>120</td>
                <td>30</td>
                <td>90</td>
                </tr>
            </tbody>
            </table>
            <!-- CENTERED BUTTON -->
            <button class="mt-3 px-6 py-2 rounded-lg font-semibold" style="background-color: #8B0000; color: white; width: fit;"> Visit Inventory
            </button>
        </div>
        </div>
    </div>

    </div>


    <!-- SCHEDULE -->
    <div class="col-span-7 card bg-primaryMain text-white shadow">
      <div class="card-body">
        <h1 class="text-lg font-semibold mb-3">Scheduled Patients Today</h1>

        <div class="space-y-3">
          <div class="flex items-center gap-4 bg-red-800 p-3 rounded-lg">
            <img src="https://i.pravatar.cc/40" class="rounded-full">
            <div class="flex-1">
              <p class="font-semibold">Capilitan, Beyonce</p>
              <p class="text-xs opacity-80">Dental Cleaning • 10:00 AM</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
          </div>

          <div class="flex items-center gap-4 bg-red-800 p-3 rounded-lg">
            <img src="https://i.pravatar.cc/40" class="rounded-full">
            <div class="flex-1">
              <p class="font-semibold">Capilitan, Beyonce</p>
              <p class="text-xs opacity-80">Dental Cleaning • 10:00 AM</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>

      </div>
    </div>

  </div>
</main>

<!-- ================= SCRIPT ================= -->
<script>
  // Dentist data source (API-ready)
  const dentist = { name: "Dr. Nelson" };

  document.getElementById("dentistName").textContent = dentist.name + "!";

  document.getElementById("currentDate").textContent =
    new Date().toLocaleDateString("en-US", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric"
    });

  const statusBtn = document.getElementById("statusBtn");
  statusBtn.addEventListener("click", () => {
    if (statusBtn.textContent === "IN") {
      statusBtn.textContent = "OUT";
      statusBtn.classList.replace("btn-success", "btn-error");
    } else {
      statusBtn.textContent = "IN";
      statusBtn.classList.replace("btn-error", "btn-success");
    }
  });


  // ================= HIGHCHARTS BAR CHART =================
  Highcharts.chart('gadChart', {
    chart: {
      type: 'column',
      backgroundColor: '#ffffff'
    },
    title: {
      text: 'GAD Analytics'
    },
    xAxis: {
      categories: ['Student', 'Administrative', 'Faculty', 'Dependent'],
      title: { text: 'Category' }
    },
    yAxis: {
      min: 0,
      title: { text: 'Number of Cases' }
    },
    series: [
      {
        name: 'Female',
        data: [25, 10, 15, 8], // example data
        color: '#FFC0CB' // baby pink
      },
      {
        name: 'Male',
        data: [20, 15, 12, 10], // example data
        color: '#89CFF0' // baby blue
      }
    ],
    tooltip: {
      shared: true,
      valueSuffix: ' cases'
    },
    plotOptions: {
      column: {
        pointPadding: 0.2,
        borderWidth: 0
      }
    },
    credits: { enabled: false }
  });
</script>

</body>
</html>
