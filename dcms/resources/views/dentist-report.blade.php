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
</head>

<body class="bg-gray-100">

<!-- ================= TOP HEADER ================= -->
<header class="bg-gradient-to-r from-red-900 to-red-700 text-white px-8 py-4 flex justify-between items-center">
  <div class="flex items-center gap-3 font-bold">
    <!-- University Logo -->
    <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" class="w-10 h-10 object-contain">
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
    <a class="flex flex-col items-center opacity-60">
      <i class="fa-solid fa-chart-line"></i>
      <span>Dashboard</span>
    </a>
    <a class="flex flex-col items-center opacity-60">
      <i class="fa-solid fa-users"></i>
      <span>Patients</span>
    </a>
    <a class="flex flex-col items-center opacity-60">
      <i class="fa-solid fa-calendar-check"></i>
      <span>Appointments</span>
    </a>
    <a class="flex flex-col items-center opacity-60">
      <i class="fa-solid fa-box"></i>
      <span>Inventory</span>
    </a>
    <a class="flex flex-col items-center opacity-100">
      <i class="fa-solid fa-file"></i>
      <span class="font-bold">Reports</span>
    </a>
  </nav>
</header>

<!-- ================= MAIN ================= -->
<main class="p-8">

  <!-- CREATE REPORT BUTTON -->
  <div class="flex justify-center mb-8">
    <button class="w-full max-w-4xl bg-gradient-to-r from-primaryDark to-primaryMain text-white py-4 rounded-xl flex items-center justify-center gap-4 text-lg font-semibold shadow">
      Create New Report
      <span class="bg-white text-primaryMain w-8 h-8 rounded-full flex items-center justify-center font-bold">+</span>
    </button>
  </div>

  <!-- ================= GRID ================= -->
  <div class="grid grid-cols-12 gap-6">

    <!-- GAD REPORT -->
    <div class="col-span-8 bg-white rounded-xl shadow border border-orange-400 p-4">
      <div class="flex justify-between items-center mb-2">
        <h2 class="text-sm font-semibold text-red-700">GAD Report</h2>
        <span class="text-xs bg-red-700 text-white px-3 py-1 rounded-full">Dec 2025</span>
      </div>
      <div id="gadChart" class="h-[320px]"></div>
    </div>

    <!-- DENTAL CASES STATS -->
    <div class="col-span-4 grid grid-cols-2 gap-4">

      <!-- STAT CARD -->
      <div class="bg-white rounded-xl shadow border border-orange-400 p-4">
        <div class="flex justify-between text-xs mb-2">
          <span>Student</span>
          <span class="bg-red-700 text-white px-2 py-0.5 rounded-full">Dec 2025</span>
        </div>
        <div id="studentChart" class="h-32"></div>
      </div>

      <div class="bg-white rounded-xl shadow border border-orange-400 p-4">
        <div class="flex justify-between text-xs mb-2">
          <span>Faculty</span>
          <span class="bg-red-700 text-white px-2 py-0.5 rounded-full">Dec 2025</span>
        </div>
        <div id="facultyChart" class="h-32"></div>
      </div>

      <div class="bg-white rounded-xl shadow border border-orange-400 p-4">
        <div class="flex justify-between text-xs mb-2">
          <span>Administrative</span>
          <span class="bg-red-700 text-white px-2 py-0.5 rounded-full">Dec 2025</span>
        </div>
        <div id="adminChart" class="h-32"></div>
      </div>

      <div class="bg-white rounded-xl shadow border border-orange-400 p-4">
        <div class="flex justify-between text-xs mb-2">
          <span>Dependent</span>
          <span class="bg-red-700 text-white px-2 py-0.5 rounded-full">Dec 2025</span>
        </div>
        <div id="dependentChart" class="h-32"></div>
      </div>

    </div>
  </div>
</main>

<!-- ================= SCRIPTS ================= -->
<script>
  // GAD STACKED BAR
  Highcharts.chart('gadChart', {
    chart: { type: 'column' },
    title: { text: null },
    xAxis: {
      categories: ['Student', 'Faculty', 'Administrative', 'Dependent']
    },
    yAxis: {
      min: 0,
      title: { text: null },
      stackLabels: { enabled: true }
    },
    legend: { align: 'center' },
    plotOptions: {
      column: { stacking: 'normal' }
    },
    series: [
      { name: 'Female', data: [30, 20, 25, 18], color: '#FFC0CB' },
      { name: 'Male', data: [28, 25, 30, 22], color: '#89CFF0' },
      { name: 'Senior Citizens', data: [5, 3, 6, 4], color: '#3B82F6' },
      { name: 'PWD', data: [2, 1, 3, 2], color: '#7A1F1F' }
    ],
    credits: { enabled: false }
  });

  // DONUT TEMPLATE
  function donut(id, value) {
    Highcharts.chart(id, {
      chart: { type: 'pie' },
      title: { text: null },
      plotOptions: {
        pie: {
          innerSize: '70%',
          dataLabels: { enabled: false }
        }
      },
      series: [{
        data: [
          { y: value, color: '#7a0000' },
          { y: 100 - value, color: '#f3f3f3' }
        ]
      }],
      credits: { enabled: false }
    });
  }

  donut('studentChart', 65);
  donut('facultyChart', 55);
  donut('adminChart', 70);
  donut('dependentChart', 60);
</script>

</body>
</html>
