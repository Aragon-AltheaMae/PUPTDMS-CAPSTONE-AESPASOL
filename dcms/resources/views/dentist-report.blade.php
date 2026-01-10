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
<header class="bg-gradient-to-r from-primaryDark to-primaryMain text-white px-8 py-4 flex justify-between items-center">
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
    <a href="{{ route('dentist.dashboard') }}" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-chart-line text-lg"></i>
      <span>Dashboard</span>
    </a>

    <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-users text-lg"></i>
      <span>Patients</span>
    </a>

    <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>
    
    <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-box text-lg"></i>
      <span>Inventory</span>
    </a>

    <a href="{{ route('dentist.report') }}" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>

  </nav>
</header>

<!-- ================= MAIN ================= -->
<main class="p-8">

  <!-- CREATE REPORT BUTTON -->
    <div class="flex justify-center mb-8">
    <button
        onclick="createReportModal.showModal()"
        class="w-full max-w-4xl 
                bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                text-white py-4 rounded-xl
                flex items-center justify-center gap-4
                text-lg font-semibold shadow">
        <span>Create New Report</span>
        <span class="bg-white text-[#8B0000] w-8 h-8 rounded-full flex items-center justify-center leading-none text-xl font-bold">
            +
        </span>
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

    <!-- DENTAL CASES STATISTICS (NO WRAPPER CARD) -->
    <div class="col-span-4">

    <!-- TITLE ROW -->
    <div class="flex justify-between items-center mb-3">
        <h2 class="text-sm font-semibold text-red-700">
        Dental Cases Statistics
        </h2>
        <span class="bg-red-700 text-white text-xs px-4 py-1 rounded-full">
        Dec
        </span>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-2 gap-4">

        <!-- STUDENT -->
        <div class="bg-white rounded-xl shadow border-2 border-orange-400 p-3">
        <p class="text-xs text-[#8B0000] mb-1">Student</p>
        <div id="studentChart" class="h-32"></div>
        </div>

        <!-- FACULTY -->
        <div class="bg-white rounded-xl shadow border-2 border-orange-400 p-3">
        <p class="text-xs text-[#8B0000] mb-1">Faculty</p>
        <div id="facultyChart" class="h-32"></div>
        </div>

        <!-- ADMINISTRATIVE -->
        <div class="bg-white rounded-xl shadow border-2 border-orange-400 p-3">
        <p class="text-xs text-[#8B0000] mb-1">Administrative</p>
        <div id="adminChart" class="h-32"></div>
        </div>

        <!-- DEPENDENT -->
        <div class="bg-white rounded-xl shadow border-2 border-orange-400 p-3">
        <p class="text-xs text-[#8B0000] mb-1">Dependent</p>
        <div id="dependentChart" class="h-32"></div>
        </div>

    </div>
    </div>

    
    <!-- INVENTORY ANALYTICS -->
    <div class="col-span-12 bg-white rounded-xl shadow border-2 border-orange-400 p-6">

    <h2 class="text-lg font-semibold text-red-700 underline mb-4">
        Inventory Analytics
    </h2>

    <div class="grid grid-cols-12 gap-6 items-center">

        <!-- PIE CHARTS -->
        <div class="col-span-7 grid grid-cols-2 gap-6">

        <!-- MEDICINE PIE -->
        <div>
            <h3 class="text-center font-semibold text-red-700 mb-2">
            Medicine Inventory
            </h3>
            <div id="medicinePieChart" class="h-[260px]"></div>
        </div>

        <!-- SUPPLIES PIE -->
        <div>
            <h3 class="text-center font-semibold text-red-700 mb-2">
            Medical Supplies Inventory
            </h3>
            <div id="suppliesPieChart" class="h-[260px]"></div>
        </div>

        </div>

        <!-- LOW STOCK LIST -->
        <div class="col-span-5">

        <!-- MEDICINE -->
        <h2 class="text-red-700 font-semibold mb-2">Medicine</h2>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Amoxicillin 500mg</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Paracetamol 500mg</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Chlorhexidine Mouthwash</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <hr class="my-4 border-yellow-400">

        <!-- MEDICAL SUPPLIES -->
        <h2 class="text-red-700 font-semibold mb-2">Medical Supplies</h>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Disposable Dental Needles</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Disposable Mouth Mirrors</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        </div>
    </div>
    </div>



  </div>
</main>


<dialog id="createReportModal" class="modal">
  <div class="modal-box max-w-4xl border-2 border-blue-400 bg-white">

    <h2 class="text-2xl font-semibold text-[#8B0000] mb-8">
      Create New Report
    </h2>

    <form class="space-y-6">

      <!-- REPORT NAME -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Report Name</label>
        <input
          type="text"
          placeholder="Enter Report Name"
          class="col-span-3 input input-bordered w-full border-yellow-400 focus:outline-none" />
      </div>

      <!-- REPORT TYPE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Report Type</label>
        <select
          class="col-span-3 select select-bordered w-full border-yellow-400 focus:outline-none">
          <option disabled selected>Select Report Type</option>
          <option>GAD Report</option>
          <option>Medicine Supply Report</option>
          <option>Medical Supplies Report</option>
          <option>Daily Treatment Record</option>
          <option>Dental Services Report</option>
        </select>
      </div>

      <!-- DATE RANGE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Date Range</label>
        <div class="col-span-3 flex gap-4">
          <input
            type="date"
            class="input input-bordered border-yellow-400 w-full" />
          <input
            type="date"
            class="input input-bordered border-yellow-400 w-full" />
        </div>
      </div>

      <!-- QUANTITY -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Quantity</label>
        <input
          type="number"
          value="0"
          class="col-span-1 input input-bordered border-yellow-400 w-full" />
      </div>

      <!-- ACTION BUTTONS -->
      <div class="flex justify-end gap-4 pt-6">
        <button
          type="button"
          class="btn bg-[#8B0000] text-white px-8">
          Download Report
        </button>

        <button
          type="button"
          onclick="createReportModal.close()"
          class="btn bg-gray-700 text-white px-8">
          Back
        </button>
      </div>

    </form>

  </div>
</dialog>






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

<!-- ================= SCRIPTS ================= -->
<script>
  // GAD STACKED BAR
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

  const inventory = [
    { category: "Supplies", name: "Disposable Dental Needles", qty: 42, used: 8 },
    { category: "Medicine", name: "Amoxicillin 500mg", qty: 30, used: 5 },
    { category: "Supplies", name: "Latex Examination Gloves", qty: 50, used: 12 },
    { category: "Medicine", name: "Paracetamol 500mg", qty: 40, used: 10 },
    { category: "Supplies", name: "Dental Cotton Rolls", qty: 60, used: 15 },
    { category: "Supplies", name: "Disposable Mouth Mirrors", qty: 25, used: 5 },
    { category: "Medicine", name: "Ibuprofen 400mg", qty: 35, used: 7 },
    { category: "Supplies", name: "Cotton Swabs", qty: 80, used: 20 },
    { category: "Medicine", name: "Chlorhexidine Mouthwash 0.12%", qty: 20, used: 4 },
    { category: "Supplies", name: "Dental Floss Packs", qty: 50, used: 10 }
  ];

  const medicineData = [];
  const suppliesData = [];

  inventory.forEach(item => {
    const remaining = item.qty - item.used;

    if (item.category === "Medicine") {
      medicineData.push({
        name: item.name,
        y: remaining
      });
    }

    if (item.category === "Supplies") {
      suppliesData.push({
        name: item.name,
        y: remaining
      });
    }
  });

  // MEDICINE PIE
  Highcharts.chart('medicinePieChart', {
    chart: { type: 'pie' },
    title: { text: null },
    tooltip: {
      pointFormat: '<b>{point.y}</b> remaining'
    },
    plotOptions: {
      pie: {
        dataLabels: {
          enabled: true,
          format: '{point.name}: {point.y}'
        }
      }
    },
    series: [{
      name: 'Medicine',
      data: medicineData
    }],
    credits: { enabled: false }
  });

  // SUPPLIES PIE
  Highcharts.chart('suppliesPieChart', {
    chart: { type: 'pie' },
    title: { text: null },
    tooltip: {
      pointFormat: '<b>{point.y}</b> remaining'
    },
    plotOptions: {
      pie: {
        dataLabels: {
          enabled: true,
          format: '{point.name}: {point.y}'
        }
      }
    },
    series: [{
      name: 'Medical Supplies',
      data: suppliesData
    }],
    credits: { enabled: false }
  });


</script>

</body>
</html>
