<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>PUP Taguig Dental Clinic | Dental Services Record</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- Tailwind & DaisyUI -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

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
        .radio-red {
          appearance: none;
          -webkit-appearance: none;

          width: 16px;
          height: 16px;
          min-width: 16px;
          min-height: 16px;

          border: 2px solid #8B0000;
          border-radius: 50%;

          display: inline-flex;
          align-items: center;
          justify-content: center;

          background-color: #fff;
          cursor: pointer;
          flex-shrink: 0;       /* 🚀 prevents oval distortion */
        }

        .radio-red::before {
          content: "";
          width: 8px;
          height: 8px;
          border-radius: 50%;
          background-color: #8B0000;
          transform: scale(0);
          transition: transform 0.15s ease-in-out;
        }

        .radio-red:checked::before {
          transform: scale(1);
        }

        .checkbox-red {
          appearance: none;
          -webkit-appearance: none;

          width: 16px;
          height: 16px;
          min-width: 16px;
          min-height: 16px;

          border: 2px solid #8B0000;
          border-radius: 50%; /* 👈 makes it round like radio */

          display: inline-flex;
          align-items: center;
          justify-content: center;

          background-color: #fff;
          cursor: pointer;
          flex-shrink: 0;
        }

        .checkbox-red::before {
          content: "";
          width: 8px;
          height: 8px;
          border-radius: 50%;
          background-color: #8B0000;
          transform: scale(0);
          transition: transform 0.15s ease-in-out;
        }

        .checkbox-red:checked::before {
          transform: scale(1);
        }

        /* Disabled radio + label styling */
        .filter-disabled {
          opacity: 0.4;
          cursor: not-allowed;
        }

        .filter-disabled input {
          cursor: not-allowed;
        }

        /* Active state – EXACT SAME SHAPE */
        .filter-active {
          background-color: #8B0000 !important;
          color: white !important;
        }

        .filter-active i,
        .filter-active span {
          color: white !important;
        }

        /* remove hover light bg when active */
        .filter-active:hover {
          background-color: #400000 !important;
        }

</style>
</head>

<body class="bg-gray-200">

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

<!-- ================= NAV ================= -->
<header class="bg-primaryMain text-white px-8 py-3">
  <nav class="flex justify-end items-center">


    <a href="{{ route('dentist.report') }}"
       class="bg-white text-[#8B0000] px-5 py-2 rounded-lg text-sm font-semibold shadow hover:bg-gray-100">
      ← Back to Report Dashboard
    </a>
  </nav>
</header>

<!-- ================= MAIN ================= -->
<main class="p-8 min-h-[calc(100vh-200px)]">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">

  <!-- LEFT: TITLE -->
  <div>
    <h1 class="text-3xl font-bold bg-gradient-to-r from-[#8B0000] to-[#FFD700] bg-clip-text text-transparent">
      Dental Services Record
    </h1>
    <div class="mt-2 flex items-center gap-3">
      <label class="text-sm text-gray-600">Select Month & Year:</label>

      <input
          type="month"
          id="monthPicker"
          class="border border-gray-300 rounded-md
                px-6 py-2 text-sm text-gray-700
                bg-white dark:bg-neutral-900 dark:text-gray-100
                focus:outline-none"
        />
    </div>
  </div>

  <!-- RIGHT: CREATE NEW REPORT BUTTON -->
  <button 
    onclick="createReportModal.showModal()"
    class="flex items-center gap-4 px-6 py-3 rounded-xl
                  bg-gradient-to-r from-[#8B0000] to-[#660000]
                  text-white font-semibold shadow hover:opacity-90">
      <span>Create New Report</span>

      <!-- PLUS ICON -->
      <span class="w-8 h-8 rounded-full bg-white text-[#8B0000]
                  flex items-center justify-center text-xl font-bold">+</span>
    </button>
</div>

    <!-- ================= TABLE CARD ================= -->
    <div class="bg-white rounded-2xl shadow border-1 border-red-300 p-6">

      <!-- SEARCH BAR CONTAINER (RIGHTMOST) -->
      <div class="w-full flex justify-end mb-4">

        <!-- SEARCH BAR + CLEAR -->
        <div class="flex items-center gap-6">

          <!-- Search + Filter -->
          <div class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full">
            <div class="flex items-center bg-white rounded-full overflow-hidden">

              <!-- Left: Search -->
              <div class="flex items-center gap-2 pl-3 pr-5 py-2 w-[320px]">
                <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                  <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
                </span>

                <input
                  id="searchInput"
                  type="text"
                  placeholder="Search"
                  class="w-full bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none"
                />
              </div>

              <!-- Divider -->
              <div class="w-[2px] self-stretch bg-[#D9D9D9]"></div>

              <!-- Right: Filter -->
              <button
                id="openFilter"
                type="button"
                class="flex items-center gap-2 px-6 py-3 text-sm font-medium text-[#8B0000] hover:bg-[#e5ae2d]"
              >
                <i class="fa-solid fa-sliders text-[13px]"></i>
                <span>Filter</span>
              </button>

            </div>
          </div>

          <!-- Clear -->
          <button
            id="clearBtn"
            type="button"
            class="text-[#8B0000] text-sm font-medium hover:underline"
          >
            Clear
          </button>

        </div>
      </div>

      <!-- TABLE -->
      <div class="border-2 border-gray-300 rounded-xl p-4 overflow-x-auto min-h-[280px] flex flex-col items-start">
          <table class="table table-sm w-full">
            <thead>
              <tr class="text-xs uppercase text-red-700 border-b text-center">
                <th>Date</th>
                <th>Time In</th>
                <th>Name of Patient</th>
                <th>Course / Yr & Section / Dept</th>
                <th>Age</th>
                <th>Male</th>
                <th>Female</th>
                <th>Senior</th>
                <th>PWD</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Time Processed</th>
                <th>Processing Time</th>
                <th>Emergency</th>
                <th>Non-Emergency</th>
                <th>Signature</th>
              </tr>
            </thead>
          <tbody id="dentalServicesTableBody"></tbody>
          </table>
      </div>

    </div>
</main>

<!-- FILTER MODAL -->
<div id="filterModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-[760px] rounded-2xl shadow-2xl overflow-hidden border border-gray-200">

    <!-- Header -->
    <div class="px-6 py-4 flex items-center gap-3">
      <i class="fa-solid fa-sliders text-[#8B0000]"></i>
      <h2 class="text-xl font-medium text-[#8B0000]">Filter</h2>
    </div>
    <div class="h-px bg-gray-200"></div>

    <!-- BODY -->
    <div class="px-6 py-5 space-y-5 max-h-[76vh] overflow-y-auto scroll-smooth">

      <!-- SORT -->
      <div class="space-y-3">
        <p class="text-sm text-gray-500">Sort</p>
        <div class="space-y-2">
        <label class="flex items-center gap-3 text-sm text-gray-700">
          <input type="radio" name="sort" value="az" class="radio-red" />
          A–Z
        </label>
        <label class="flex items-center gap-3 text-sm text-gray-700">
          <input type="radio" name="sort" value="za" class="radio-red" />
          Z–A
        </label>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- DATE RANGE -->
      <div class="space-y-1">
        <p class="text-sm text-gray-500">Date Range</p>

        <div class="grid grid-cols-12 gap-4 items-start">

          <div class="col-span-4 space-y-2 pt-2">
            <label class="flex items-center gap-3 text-sm text-gray-700">
              <input type="radio" name="dateOrder" value="asc" class="radio-red" />
              Ascending
            </label>
            <label class="flex items-center gap-3 text-sm text-gray-700">
              <input type="radio" name="dateOrder" value="desc" class="radio-red" />
              Descending
            </label>
          </div>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- GAD: GENDER -->
      <p class="text-sm text-gray-500">GAD (Gender)</p>
        <div class="grid grid-cols-3 gap-5 text-sm">
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="checkbox" name="gender" value="Male" class="checkbox-red gadGender"> Male</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="checkbox" name="gender" value="Female" class="checkbox-red gadGender"> Female</label>
        </div>

      <div class="h-px bg-gray-200"></div>

      <!-- GAD: PRIORITY -->
      <p class="text-sm text-gray-500">GAD (Priority) </p>
        <div class="grid grid-cols-3 gap-5 text-sm">
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="checkbox" name="gad" value="PWD" class="checkbox-red gadPriority"> PWD</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="checkbox" name="gad" value="Senior" class="checkbox-red gadPriority"> Senior</label>
        </div>

      <div class="h-px bg-gray-200"></div>

      <!-- TYPE -->
       <p class="text-sm text-gray-500">Type</p>
        <div class="grid grid-cols-3 gap-5 text-sm">
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="type" value="Emergency" class="radio-red"> Emergency</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="type" value="Non-Emergency" class="radio-red"> Non-Emergency</label>
        </div>

      <div class="h-px bg-gray-200"></div>

      <!-- DEPARTMENT -->
      <p class="text-sm text-gray-500">Department</p>
        <div class="grid grid-cols-3 gap-5 text-sm">
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="department" value="Administrative" class="radio-red departmentRadio"> Administrative</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="department" value="Faculty" class="radio-red departmentRadio"> Faculty</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="department" value="Dependent" class="radio-red departmentRadio"> Dependent</label>
        </div>

      <div class="h-px bg-gray-200"></div>

      <!-- COURSES-->
      <div class="space-y-3">
        <p class="text-sm text-gray-500">Course</p>

        <div class="grid grid-cols-6 gap-x-8 gap-y-4 text-sm">
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSIT"> BSIT</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSECE"> BSECE</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSBA - HRM"> BSBA - HRM</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSED - ENG"> BSED - ENG</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSOA"> BSOA</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSPSYCH"> BSPSYCH</label>

          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="DIT"> DIT</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSME"> BSME</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSBA - MM"> BSBA - MM</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="BSED - MATH"> BSED - MATH</label>
          <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="course" class="radio-red programRadio" value="DOMT"> DOMT</label>
        </div>
      </div>

      <!-- Year + Section -->
      <div class="grid grid-cols-12 gap-10">
        <!-- Year -->
        <div class="col-span-6 space-y-3">
          <p class="text-sm text-gray-500">Year</p>
          <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="year" value="1" class="filter-input radio-red studentyearRadio"/> 1st Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="3" class="filter-input radio-red studentyearRadio"/> 3rd Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="2" class="filter-input radio-red studentyearRadio"/> 2nd Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="4" class="filter-input radio-red studentyearRadio"/> 4th Year</label>
          </div>
        </div>

        <!-- Section -->
        <div class="col-span-6 space-y-3">
          <p class="text-sm text-gray-500">Section</p>
          <div class="space-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="section" value="1" class="filter-input radio-red sectionRadio"/> 1</label>
            <label class="flex items-center gap-3"><input type="radio" name="section" value="2" class="filter-input radio-red sectionRadio"/> 2</label>
          </div>
        </div>
      </div>

    </div>
    <!-- FOOTER -->
    <div class="h-px bg-gray-200"></div>
    <div class="px-6 py-4 flex items-center justify-between">
      <button id="clearFilterBtn" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
        Clear
      </button>

      <button id="applyFiltersBtn" type="button"
        class="bg-[#8B0000] text-white px-8 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000]">
        Save
      </button>
    </div>
  </div>
</div>

<!-- REPORT MODAL -->
<dialog id="createReportModal" class="modal">
  <div class="modal-box max-w-4xl border-2 border-blue-400 bg-white">

    <h2 class="text-2xl font-semibold text-[#8B0000] mb-8">
      Create New Report
    </h2>

    <form class="space-y-6" id="reportForm">

      <!-- REPORT NAME -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Report Name</label>
        <input
          type="text"
          placeholder="Enter Report Name"
          class="col-span-3 input input-bordered w-full border-yellow-400 bg-white focus:outline-none" />
      </div>

      <!-- REPORT TYPE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Report Type</label>
        <select
          class="col-span-3 select select-bordered w-full border-yellow-400 bg-white focus:outline-none">
          <option disabled selected>Select Report Type</option>
          <option>Dental Services Report</option>
        </select>
      </div>

      <!-- DATE RANGE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Date Range</label>
        <div class="col-span-3 flex gap-4">
          <input
            type="date"
            class="input input-bordered border-yellow-400 bg-white w-full" />
          <input
            type="date"
            class="input input-bordered border-yellow-400 bg-white w-full" />
        </div>
      </div>

      <!-- QUANTITY -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Quantity</label>
        <input
          type="number"
          value="0"
          class="col-span-1 input input-bordered border-yellow-400 bg-white w-full" />
      </div>

      <!-- ACTION BUTTONS -->
      <div class="flex justify-end gap-4 pt-6">
        <button
          type="button"
          id="downloadReportBtn"
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

    <!-- Mini Tab: Download Complete Notification -->
    <div id="downloadCompleteTab" class="hidden fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-green-600 text-white py-2 px-8 rounded-lg shadow-lg">
      Download Complete
    </div>


  </div>
</dialog>

<!-- ================= FOOTER ================= -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">
  <!-- Footer content here (unchanged) -->
</footer>

<!-- ================= JS DATA ================= -->
<script>

const records = [
  {
    date: "12/01/25",
    timeIn: "08:30 AM",
    name: "Dela Cruz, Juan M.",
    program: "BSIT 3-1",
    age: 21,
    gad: { gender: "Male", priority: ["PWD"] },
    email: "juan@gmail.com",
    contact: "0917-123-4567",
    timeOut: "09:00 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/01/25",
    timeIn: "09:10 AM",
    name: "Santos, Maria L.",
    program: "Faculty",
    age: 45,
    gad: { gender: "Female", priority: [] },
    email: "maria@gmail.com",
    contact: "0998-456-7890",
    timeOut: "10:00 AM",
    duration: "50 mins",
    type: "Emergency",
    department: "Faculty"
  },
  {
    date: "12/02/25",
    timeIn: "08:45 AM",
    name: "Reyes, Paul A.",
    program: "Administrative",
    age: 38,
    gad: { gender: "Male", priority: [] },
    email: "paul@gmail.com",
    contact: "0920-888-1234",
    timeOut: "09:15 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Administrative"
  },
  {
    date: "12/02/25",
    timeIn: "10:30 AM",
    name: "Lopez, Ana C.",
    program: "BSBA - HRM 2-2",
    age: 20,
    gad: { gender: "Female", priority: [] },
    email: "ana@gmail.com",
    contact: "0916-555-7891",
    timeOut: "11:05 AM",
    duration: "35 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/03/25",
    timeIn: "09:00 AM",
    name: "Torres, Elaine C.",
    program: "Dependent",
    age: 62,
    gad: { gender: "Female", priority: ["Senior"] },
    email: "elaine@gmail.com",
    contact: "0999-332-4488",
    timeOut: "09:50 AM",
    duration: "50 mins",
    type: "Non-Emergency",
    department: "Dependent"
  },
  {
    date: "12/03/25",
    timeIn: "10:40 AM",
    name: "Castillo, Brian R.",
    program: "BSECE 2-2",
    age: 20,
    gad: { gender: "Male", priority: ["PWD"] },
    email: "brian@gmail.com",
    contact: "0908-777-5566",
    timeOut: "11:15 AM",
    duration: "35 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/04/25",
    timeIn: "08:20 AM",
    name: "Mendoza, Joshua P.",
    program: "BSPSYCH 3-1",
    age: 21,
    gad: { gender: "Male", priority: [] },
    email: "josh@gmail.com",
    contact: "0917-889-3342",
    timeOut: "08:50 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/04/25",
    timeIn: "09:45 AM",
    name: "Navarro, Rhea T.",
    program: "Faculty",
    age: 41,
    gad: { gender: "Female", priority: [] },
    email: "rhea@gmail.com",
    contact: "0995-441-2098",
    timeOut: "10:30 AM",
    duration: "45 mins",
    type: "Emergency",
    department: "Faculty"
  },
  {
    date: "12/05/25",
    timeIn: "08:10 AM",
    name: "Cruz, Daniel S.",
    program: "BSIT 4-1",
    age: 22,
    gad: { gender: "Male", priority: [] },
    email: "daniel@gmail.com",
    contact: "0928-334-8899",
    timeOut: "08:40 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/05/25",
    timeIn: "09:30 AM",
    name: "Ramos, Angela D.",
    program: "BSED - ENG 2-1",
    age: 19,
    gad: { gender: "Female", priority: [] },
    email: "angela@gmail.com",
    contact: "0915-223-7781",
    timeOut: "10:00 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/06/25",
    timeIn: "10:15 AM",
    name: "Tan, Michael K.",
    program: "Administrative",
    age: 36,
    gad: { gender: "Male", priority: [] },
    email: "mike@gmail.com",
    contact: "0991-667-9900",
    timeOut: "10:55 AM",
    duration: "40 mins",
    type: "Non-Emergency",
    department: "Administrative"
  },
  {
    date: "12/06/25",
    timeIn: "01:20 PM",
    name: "Lim, Samantha J.",
    program: "DOMT 1-2",
    age: 18,
    gad: { gender: "Female", priority: [] },
    email: "sam@gmail.com",
    contact: "0922-889-4455",
    timeOut: "01:45 PM",
    duration: "25 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/07/25",
    timeIn: "08:40 AM",
    name: "Bautista, Kevin A.",
    program: "BSME 3-1",
    age: 21,
    gad: { gender: "Male", priority: [] },
    email: "kevin@gmail.com",
    contact: "0919-556-1123",
    timeOut: "09:10 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/07/25",
    timeIn: "10:05 AM",
    name: "Flores, Christine M.",
    program: "BSBA - MM 4-1",
    age: 22,
    gad: { gender: "Female", priority: [] },
    email: "cflores@gmail.com",
    contact: "0918-774-9921",
    timeOut: "10:50 AM",
    duration: "45 mins",
    type: "Non-Emergency",
    department: "Student"
  },
  {
    date: "12/09/25",
    timeIn: "08:25 AM",
    name: "Perez, John R.",
    program: "BSIT 2-1",
    age: 19,
    gad: { gender: "Male", priority: [] },
    email: "john@gmail.com",
    contact: "0927-888-1122",
    timeOut: "08:55 AM",
    duration: "30 mins",
    type: "Non-Emergency",
    department: "Student"
  }
];


let searchKeyword = "";
let selectedProgram = null;
let nameSort = null;
let dateSort = null;

let selectedMonth = null;
let selectedCalendarYear = null;

let selectedYearLevel = null;   // "1st Year", "2nd Year", etc
let selectedSection = null;

let selectedGender=null;
let selectedPriority=[];
let selectedType = null;
let selectedDepartment = null; //selectedOffice


const filterModal = document.getElementById("filterModal");

document.getElementById("openFilter").addEventListener("click", () => {
  filterModal.classList.remove("hidden");
});

filterModal.addEventListener("click", e => {
  if (e.target === filterModal) {
    filterModal.classList.add("hidden");
  }
});

document.getElementById("applyFiltersBtn").addEventListener("click", () => {
  filterModal.classList.add("hidden");
});

// For Hardcoded Data (Subjected to Change)
function renderRecords(data) {
  const tbody = document.getElementById("dentalServicesTableBody");
  tbody.innerHTML = "";

  if (!data.length) {
    tbody.innerHTML = `
      <tr>
        <td colspan="16" class="text-center text-gray-400 py-24">
          No Records.
        </td>
      </tr>
    `;
    return;
  }

  data.forEach(r => {
    tbody.innerHTML += `
      <tr class="text-center text-[11px] text-black">
        <td>${r.date}</td>
        <td>${r.timeIn}</td>
        <td class="text-left">${r.name}</td>
        <td>${r.program}</td>
        <td>${r.age}</td>
        <td>${r.gad.gender==="Male"?"✔":""}</td>
        <td>${r.gad.gender==="Female"?"✔":""}</td>
        <td>${r.gad.priority.includes("Senior")?"✔":""}</td>
        <td>${r.gad.priority.includes("PWD")?"✔":""}</td>
        <td>${r.email}</td>
        <td>${r.contact}</td>
        <td>${r.timeOut}</td>
        <td>${r.duration}</td>
        <td>${r.type === "Emergency" ? "✔" : ""}</td>
        <td>${r.type === "Non-Emergency" ? "✔" : ""}</td>
        <td>✔</td>
      </tr>
    `;
  });
}


/* ================= FILTER LOGIC ================= */
function applyFilters() {
  let data = [...records];

  // 🔍 SEARCH (name, program, treatment, contact)
  if (searchKeyword) {
    data = data.filter(r =>
      `${r.name} ${r.program} ${r.type} ${r.contact}`
        .toLowerCase()
        .includes(searchKeyword)
    );
  }

  // 🎓 PROGRAM
  if (selectedProgram) {
    data = data.filter(r =>
      r.program.startsWith(selectedProgram)
    );
  }

  // 🎓 YEAR & SECTION (FIXED)
  if (selectedYearLevel || selectedSection) {
    data = data.filter(r => {
      if (!r.program) return false;

      // Get last part only → "2-1"
      const lastPart = r.program.trim().split(" ").pop();

      if (!lastPart.includes("-")) return false;

      const [year, section] = lastPart.split("-");

      if (selectedYearLevel && year !== selectedYearLevel) return false;
      if (selectedSection && section !== selectedSection) return false;

      return true;
    });
  }

  /* 👤 GAD
  if (selectedGAD.length > 0) {
    data = data.filter(r => selectedGAD.includes(r.gad));
  }*/

  // GAD: GENDER
  if(selectedGender){
    data=data.filter(r=>r.gad.gender===selectedGender);
  }

  // GAD: PRIORITY
  if(selectedPriority.length){
    data=data.filter(r=>
    selectedPriority.every(p=>r.gad.priority.includes(p))
    );
  }

  // 🚑 TYPE
  if (selectedType) {
    data = data.filter(r => r.type === selectedType);
  }

  // 🏢 DEPARTMENT
  if (selectedDepartment) {
    data = data.filter(r => r.department === selectedDepartment);
  }

  // 📆 DATE SORT
  if (dateSort === "asc") {
    data.sort((a, b) =>
      new Date(`20${a.date.split("/").reverse().join("-")}`) -
      new Date(`20${b.date.split("/").reverse().join("-")}`)
    );
  }

  if (dateSort === "desc") {
    data.sort((a, b) =>
      new Date(`20${b.date.split("/").reverse().join("-")}`) -
      new Date(`20${a.date.split("/").reverse().join("-")}`)
    );
  }

  // 📆 MONTH & YEAR FILTER
  if (selectedMonth && selectedCalendarYear) {
    data = data.filter(r => {
      const [m, d, y] = r.date.split("/");
      const fullYear = `20${y}`;

      return m === selectedMonth && fullYear === selectedCalendarYear;
    });
  }

  // 🔤 NAME SORT
  if (nameSort === "az") data.sort((a, b) => a.name.localeCompare(b.name));
  if (nameSort === "za") data.sort((a, b) => b.name.localeCompare(a.name));

  renderRecords(data);
  updateFilterButtonState();

}


/* ================= EVENTS ================= */

// Search
document.getElementById("searchInput").addEventListener("input", e => {
  searchKeyword = e.target.value.trim().toLowerCase();
  applyFilters();
});

const programRadios = document.querySelectorAll(".programRadio");
const departmentRadios = document.querySelectorAll(".departmentRadio");
const studentyearRadios = document.querySelectorAll(".studentyearRadio");
const sectionRadios = document.querySelectorAll(".sectionRadio");

// Helper: disable a group
function disableRadios(radios) {
  radios.forEach(r => {
    r.disabled = true;
    r.closest("label")?.classList.add("filter-disabled");
  });
}

// Helper: enable a group
function enableRadios(radios) {
  radios.forEach(r => {
    r.disabled = false;
    r.closest("label")?.classList.remove("filter-disabled");
  });
}

// PROGRAM selected → disable DEPARTMENT
programRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    selectedProgram = radio.value;
    selectedDepartment = null;

    // reset office radios
    departmentRadios.forEach(o => o.checked = false);

    disableRadios(departmentRadios);
    enableRadios(programRadios);
    enableRadios(studentyearRadios);
    enableRadios(sectionRadios);


    updateFilterButtonState();

    applyFilters();
  });
});

// DEPARTMENT selected → disable PROGRAM
departmentRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    selectedDepartment = radio.value;
    selectedProgram = null;
    selectedYearLevel = null;
    selectedSection = null;

    // reset program radios
    programRadios.forEach(p => p.checked = false);
    studentyearRadios.forEach(r => r.checked = false);
    sectionRadios.forEach(r => r.checked = false);

    disableRadios(programRadios);
    disableRadios(studentyearRadios);
    disableRadios(sectionRadios);
    enableRadios(departmentRadios);

    applyFilters();
    updateFilterButtonState();
  });
});

studentyearRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    selectedYearLevel = radio.value;

    selectedDepartment = null;
    departmentRadios.forEach(r => r.checked = false);

    disableRadios(departmentRadios);
    enableRadios(programRadios);
    enableRadios(studentyearRadios);
    enableRadios(sectionRadios);

    applyFilters();
    updateFilterButtonState();
  });
});


sectionRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    selectedSection = radio.value;

    selectedDepartment = null;
    departmentRadios.forEach(r => r.checked = false);

    disableRadios(departmentRadios);
    enableRadios(programRadios);
    enableRadios(studentyearRadios);
    enableRadios(sectionRadios);

    applyFilters();
    updateFilterButtonState();
  });
});


/* GAD
const gadCheckboxes = document.querySelectorAll(".gadCheckbox");

gadCheckboxes.forEach(cb => {
  cb.addEventListener("change", () => {
    selectedGAD = Array.from(gadCheckboxes)
      .filter(c => c.checked)
      .map(c => c.value);

    applyFilters();
    updateFilterButtonState();
  });
}); */

// GAD: Priority
document.querySelectorAll(".gadPriority").forEach(cb=>{
cb.addEventListener("change",()=>{
selectedPriority=[...document.querySelectorAll(".gadPriority:checked")].map(c=>c.value);
applyFilters();
updateFilterButtonState();
});
});

// GAD: Gender
document.querySelectorAll("input[name='gender']").forEach(r=>{
r.addEventListener("change",()=>{
selectedGender=r.value;
applyFilters();
updateFilterButtonState();
});
});


// Type
document.querySelectorAll("input[name='type']").forEach(r =>
  r.addEventListener("change", () => {
    selectedType = r.value;
    applyFilters();
    updateFilterButtonState();
  })
);


// Date Range Sort
document.querySelectorAll("input[name='dateOrder']").forEach(radio => {
  radio.addEventListener("change", () => {
    dateSort = radio.value; // asc | desc
    applyFilters();
    updateFilterButtonState();
  });
});

// Sort
document.querySelectorAll("input[name='sort']").forEach(radio => {
  radio.addEventListener("change", () => {
    nameSort = radio.value;
    dateSort = null;
    applyFilters();
    updateFilterButtonState();
  });
});


// Filter Activity
const filterPill = document.getElementById("openFilter");

function updateFilterButtonState() {
  const hasActiveFilters =
    selectedProgram ||
    selectedYearLevel ||
    selectedSection ||
    selectedType ||
    selectedDepartment ||
    nameSort ||
    dateSort ||
    selectedGender || 
    selectedPriority.length > 0

  filterPill.classList.toggle("filter-active", !!hasActiveFilters);
}

// Handle month selection
document.getElementById("monthPicker").addEventListener("change", e => {
  if (!e.target.value) {
    selectedMonth = null;
    selectedCalendarYear = null;
  } else {
    const [year, month] = e.target.value.split("-");
    selectedMonth = month;
    selectedCalendarYear = year;
  }

  applyFilters();
});

// Clear filters
// Clear Filter Button
document.getElementById("clearFilterBtn").addEventListener("click", () => {
  searchKeyword = "";
  selectedProgram = null;
  selectedYearLevel = null;   // ✅ ADD
  selectedSection = null;     // ✅ ADD
  selectedGender = null;
  selectedPriority = [];
  selectedType = null;
  selectedDepartment = null;
  nameSort = null;
  dateSort = null;


  document.getElementById("searchInput").value = "";

  // clear ALL radios
  document.querySelectorAll("input[type=radio], input[type=checkbox]").forEach(r => {
    r.checked = false;
    r.disabled = false;
  });

  enableRadios(programRadios);
  enableRadios(departmentRadios);
  enableRadios(studentyearRadios);
  enableRadios(sectionRadios);


  updateFilterButtonState();
  applyFilters();
});

// Search Bar Clear Button
document.getElementById("clearBtn").addEventListener("click", () => {
  // clear search state
  searchKeyword = "";

  // clear input field
  document.getElementById("searchInput").value = "";

  // re-apply filters (shows all again)
  applyFilters();
  updateFilterButtonState();

});

document.addEventListener("DOMContentLoaded", () => {
  const monthPicker = document.getElementById("monthPicker");
  const now = new Date();

  const month = String(now.getMonth() + 1).padStart(2, "0");
  const year = now.getFullYear();

  // set input value
  monthPicker.value = `${year}-${month}`;

  // set filter values
  selectedMonth = month;
  selectedCalendarYear = String(year);

  applyFilters();
});

// Filter modal
document.getElementById("openFilter").addEventListener("click", () => {
  filterModal.classList.remove("hidden");
});


// Date Range - Report Modal
const now = new Date();
const month = String(now.getMonth() + 1).padStart(2, "0");
const year = now.getFullYear();


document.getElementById('downloadReportBtn').addEventListener('click', function() {
    // Simulate download (You can replace this with actual download logic)
    setTimeout(function() {
        // Show the "Download Complete" mini tab
        const downloadCompleteTab = document.getElementById('downloadCompleteTab');
        downloadCompleteTab.classList.remove('hidden');

        // Reset the form fields
        const form = document.getElementById('reportForm');
        form.reset(); // This will reset all input fields within the form

        // Hide the "Download Complete" mini tab after 3 seconds
        setTimeout(function() {
            downloadCompleteTab.classList.add('hidden');
        }, 3000); // Hide after 3 seconds
    }, 1000); // Simulating a 1-second download delay
});

</script>


</body>
</html>
