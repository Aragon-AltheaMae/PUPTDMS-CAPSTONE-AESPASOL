<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PUP Taguig Dental Clinic | Daily Treatment Record</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

<body class="bg-gray-200 min-h-screen flex flex-col">

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
  <nav class="flex justify-end items-center">

    <!-- BACK TO DASHBOARD BUTTON (RIGHTMOST) -->
    <a
      href="{{ route('dentist.report') }}"
      class="bg-white text-[#8B0000] px-5 py-2 rounded-lg text-sm font-semibold
             hover:bg-gray-100 transition shadow">
      ← Back to Report Dashboard
    </a>

  </nav>
</header>

<!-- ================= MAIN ================= -->
<main class="p-8 min-h-[calc(100vh-200px)]">

    <!-- HEADER ROW -->
    <div class="flex justify-between items-center mb-6">

        <!-- LEFT: TITLE -->
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                      bg-clip-text text-transparent">
                Daily Treatment Record
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
            onclick="createReportModal.showModal()" type="button"
            class="flex items-center gap-4 px-6 py-3 rounded-xl
                  bg-gradient-to-r from-[#8B0000] to-[#660000]
                  text-white font-semibold shadow
                  hover:opacity-90 transition">

            <span>Create New Report</span>

            <!-- PLUS ICON -->
            <span
                class="w-8 h-8 rounded-full bg-white
                      text-[#8B0000] flex items-center justify-center
                      text-xl font-bold leading-none">
                +
            </span>
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
              <div id="filterWrapper" class="flex items-center bg-white rounded-full overflow-hidden transition">


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

                <!-- Right: Filter (OWN WRAPPER) -->
                <div id="filterPill"
                    class="flex items-center transition">

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


        <!-- INNER TABLE BORDER -->
        <div class="border-2 border-gray-300 rounded-xl p-4 overflow-x-auto min-h-[280px] flex flex-col items-start">

            <table class="table table-sm w-full">
                <thead>
                    <tr class="text-xs uppercase text-red-700 border-b">
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Email / Contact Number</th>
                        <th>Office / Program</th>
                        <th>Gender</th>
                        <th>Treatment Done</th>
                        <th>Number of Minutes Processed</th>
                        <th>Patient Signature</th>
                    </tr>
                </thead>

                <tbody id="dailyTableBody"></tbody>

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
    <div class="px-6 py-5 space-y-5">

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

      <!-- OFFICE -->
      <div class="space-y-3">
        <p class="text-sm text-gray-500">Office</p>
        <div class="grid grid-cols-3 gap-6 text-sm">
          <label class="flex items-center gap-3 text-sm text-gray-700">
            <input type="radio" name="office" class="radio-red officeRadio" value="Administrative">
            Administrative
          </label>
          <label class="flex items-center gap-3 text-sm text-gray-700">
            <input type="radio" name="office" class="radio-red officeRadio" value="Faculty">
            Faculty
          </label>
          <label class="flex items-center gap-3 text-sm text-gray-700">
            <input type="radio" name="office" class="radio-red officeRadio" value="Dependent">
            Dependent
          </label>
        </div>
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
          <option>Daily Treatment Record</option>
        </select>
      </div>

      <!-- DATE RANGE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Date Range</label>
        <div class="col-span-3 flex gap-4">
          <input
            type="month"
            id="fromMonth"
            class="input input-bordered w-full"
            placeholder="From (Month & Year)"
          />
          <input
            type="month"
            id="toMonth"
            class="input input-bordered w-full"
            placeholder="To (Month & Year)"
          />
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

<!-- Footer -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">
  <!-- Footer content here (unchanged) -->
</footer>


<script>
const DTR_LIST_URL = "{{ route('dentist.reports.daily-treatment-record.list') }}";
/*const dailyRecords = [
  {
    date: "12/01/25",
    name: "Juan Dela Cruz",
    contact: "juan.delacruz@gmail.com / 0917-123-4567",
    program: "BSIT",
    gender: "Male",
    treatment: "Dental Cleaning",
    minutes: 30
  },
  {
    date: "12/02/25",
    name: "Maria Santos",
    contact: "maria.santos@gmail.com / 0998-456-7890",
    program: "Faculty",
    gender: "Female",
    treatment: "Tooth Extraction",
    minutes: 45
  },
  {
    date: "12/03/25",
    name: "Paul Reyes",
    contact: "paul.reyes@gmail.com / 0920-888-1234",
    program: "Administrative",
    gender: "Male",
    treatment: "Dental Consultation",
    minutes: 20
  },
  {
    date: "12/04/25",
    name: "Ana Lopez",
    contact: "ana.lopez@gmail.com / 0916-555-7891",
    program: "BSBA",
    gender: "Female",
    treatment: "Tooth Filling",
    minutes: 40
  },
  {
    date: "12/05/25",
    name: "Mark Villanueva",
    contact: "mark.v@gmail.com / 0909-222-3344",
    program: "Dependent",
    gender: "Male",
    treatment: "Dental Check-up",
    minutes: 15
  },
  {
    date: "12/06/25",
    name: "Christine Flores",
    contact: "cflores@gmail.com / 0918-774-9921",
    program: "BSA",
    gender: "Female",
    treatment: "Dental Cleaning",
    minutes: 30
  },
  {
    date: "12/07/25",
    name: "Joshua Mendoza",
    contact: "jmendoza@gmail.com / 0917-889-3342",
    program: "BSCS",
    gender: "Male",
    treatment: "Dental Consultation",
    minutes: 25
  },
  {
    date: "12/08/25",
    name: "Rhea Navarro",
    contact: "rhea.n@gmail.com / 0995-441-2098",
    program: "Faculty",
    gender: "Female",
    treatment: "Tooth Extraction",
    minutes: 50
  },
  {
    date: "12/09/25",
    name: "Daniel Cruz",
    contact: "daniel.cruz@gmail.com / 0928-334-8899",
    program: "BSIT",
    gender: "Male",
    treatment: "Dental Cleaning",
    minutes: 35
  },
  {
    date: "12/10/25",
    name: "Angela Ramos",
    contact: "angela.r@gmail.com / 0915-223-7781",
    program: "BSED",
    gender: "Female",
    treatment: "Dental Check-up",
    minutes: 20
  },
  {
    date: "12/11/25",
    name: "Michael Tan",
    contact: "michael.tan@gmail.com / 0991-667-9900",
    program: "Administrative",
    gender: "Male",
    treatment: "Tooth Filling",
    minutes: 45
  },
  {
    date: "12/12/25",
    name: "Samantha Lim",
    contact: "sam.lim@gmail.com / 0922-889-4455",
    program: "BSHM",
    gender: "Female",
    treatment: "Dental Consultation",
    minutes: 20
  },
  {
    date: "12/13/25",
    name: "Kevin Bautista",
    contact: "kevin.b@gmail.com / 0919-556-1123",
    program: "BSME",
    gender: "Male",
    treatment: "Dental Cleaning",
    minutes: 30
  },
  {
    date: "12/14/25",
    name: "Elaine Torres",
    contact: "elaine.t@gmail.com / 0999-332-4488",
    program: "Dependent",
    gender: "Female",
    treatment: "Tooth Extraction",
    minutes: 55
  },
  {
    date: "12/15/25",
    name: "Brian Castillo",
    contact: "b.castillo@gmail.com / 0908-777-5566",
    program: "BSCE",
    gender: "Male",
    treatment: "Dental Check-up",
    minutes: 15
  }
];*/

let searchKeyword = "";
let selectedOffice = null;
let selectedProgram = null;
let nameSort = null;
let dateSort = null;
let selectedMonth = null;
let selectedYear = null;


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
/*function renderDailyRecords(data) {
  const tbody = document.getElementById("dailyTableBody");
  tbody.innerHTML = "";

  if (data.length === 0) {
    tbody.innerHTML = `
    <tr class="border-none">
    <td colspan="8"
        class="text-center text-gray-400 py-24 align-middle">
      No Records.
    </td>
  </tr>
  `;
    return;
  }

  data.forEach(record => {
    tbody.innerHTML += `
      <tr class="text-sm text-gray-800">
        <td>${record.date}</td>
        <td>${record.name}</td>
        <td>${record.contact}</td>
        <td>${record.program}</td>
        <td>${record.gender}</td>
        <td>${record.treatment}</td>
        <td class="text-center">${record.minutes}</td>
        <td class="text-center">✔</td>
      </tr>
    `;
  });
}*/

function formatDateToMMDDYY(dateStr) {
  // dateStr is typically "YYYY-MM-DD"
  const d = new Date(dateStr);
  if (isNaN(d)) return dateStr;

  const mm = String(d.getMonth() + 1).padStart(2, "0");
  const dd = String(d.getDate()).padStart(2, "0");
  const yy = String(d.getFullYear()).slice(-2);

  return `${mm}/${dd}/${yy}`;
}

function renderDailyRecords(data) {
  const tbody = document.getElementById("dailyTableBody");
  tbody.innerHTML = "";

  if (!data || data.length === 0) {
    tbody.innerHTML = `
      <tr class="border-none">
        <td colspan="8" class="text-center text-gray-400 py-24 align-middle">
          No Records.
        </td>
      </tr>
    `;
    return;
  }

  data.forEach(record => {
    const contact = [
      record.patient_email ? record.patient_email : null,
      record.patient_phone ? record.patient_phone : null
    ].filter(Boolean).join(" / ");

    // your table has one column "Office / Program"
    // show office_type if present, else program_code, else blank
    const officeOrProgram = record.office_type || record.program_code || "";

    const signature = record.has_signature ? "✔" : "";

    tbody.innerHTML += `
      <tr class="text-sm text-gray-800">
        <td>${formatDateToMMDDYY(record.treatment_date)}</td>
        <td>${record.patient_name ?? ""}</td>
        <td>${contact}</td>
        <td>${officeOrProgram}</td>
        <td>${record.gender ?? ""}</td>
        <td>${record.treatment_done ?? ""}</td>
        <td class="text-center">${record.minutes_processed ?? 0}</td>
        <td class="text-center">${signature}</td>
      </tr>
    `;
  });
}



/* ================= FILTER LOGIC ================= */
/*function applyFilters() {
  let data = [...dailyRecords];

  // 🔍 SEARCH (name, program, treatment, contact)
  if (searchKeyword) {
    data = data.filter(r =>
      `${r.name} ${r.program} ${r.treatment} ${r.contact}`
        .toLowerCase()
        .includes(searchKeyword)
    );
  }

  // 🏢 OFFICE
  if (selectedOffice) {
    data = data.filter(r => r.program === selectedOffice);
  }

  // 🎓 PROGRAM
  if (selectedProgram) {
    data = data.filter(r => r.program === selectedProgram);
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
  if (selectedMonth && selectedYear) {
    data = data.filter(r => {
      const [m, d, y] = r.date.split("/");
      const fullYear = `20${y}`;

      return m === selectedMonth && fullYear === selectedYear;
    });
  }

  // 🔤 NAME SORT
  if (nameSort === "az") data.sort((a, b) => a.name.localeCompare(b.name));
  if (nameSort === "za") data.sort((a, b) => b.name.localeCompare(a.name));

  renderDailyRecords(data);
  updateFilterButtonState();

}*/

async function applyFilters() {
  const params = new URLSearchParams();

  // Month picker -> "YYYY-MM"
  if (selectedYear && selectedMonth) {
    params.set("month", `${selectedYear}-${selectedMonth}`);
  }

  // Search
  if (searchKeyword) {
    params.set("search", searchKeyword);
  }

  // Office or Program (mutually exclusive in your UI logic)
  if (selectedOffice) {
    params.set("office_type", selectedOffice);
  }
  if (selectedProgram) {
    params.set("program_code", selectedProgram);
  }

  // Sorting
  if (nameSort) params.set("sort_name", nameSort); // "az" | "za"
  if (dateSort) params.set("sort_date", dateSort); // "asc" | "desc"

  try {
    const res = await fetch(`${DTR_LIST_URL}?${params.toString()}`, {
      headers: { "Accept": "application/json" }
    });

    if (!res.ok) throw new Error("Failed to load records");

    const json = await res.json();
    renderDailyRecords(json.data || []);
    updateFilterButtonState();
  } catch (err) {
    console.error(err);
    renderDailyRecords([]); // show "No Records."
    updateFilterButtonState();
  }
}

/* ================= EVENTS ================= */

// Search
document.getElementById("searchInput").addEventListener("input", e => {
  searchKeyword = e.target.value.trim().toLowerCase();
  applyFilters();
});

const officeRadios = document.querySelectorAll(".officeRadio");
const programRadios = document.querySelectorAll(".programRadio");

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

// OFFICE selected → disable PROGRAM
officeRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    selectedOffice = radio.value;
    selectedProgram = null;

    // reset program radios
    programRadios.forEach(p => p.checked = false);

    disableRadios(programRadios);
    enableRadios(officeRadios);

    updateFilterButtonState();

    applyFilters();
  });
});

// PROGRAM selected → disable OFFICE
programRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    selectedProgram = radio.value;
    selectedOffice = null;

    // reset office radios
    officeRadios.forEach(o => o.checked = false);

    disableRadios(officeRadios);
    enableRadios(programRadios);

    updateFilterButtonState();

    applyFilters();
  });
});

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
    selectedOffice ||
    selectedProgram ||
    nameSort ||
    dateSort;

  filterPill.classList.toggle("filter-active", !!hasActiveFilters);
}

// Handle month selection
document.getElementById("monthPicker").addEventListener("change", e => {
  if (!e.target.value) {
    selectedMonth = null;
    selectedYear = null;
  } else {
    const [year, month] = e.target.value.split("-");
    selectedMonth = month;
    selectedYear = year;
  }

  applyFilters();
});

// Clear filters
// Clear Filter Button
document.getElementById("clearFilterBtn").addEventListener("click", () => {
  searchKeyword = "";
  selectedOffice = null;
  selectedProgram = null;
  nameSort = null;
  dateSort = null;


  document.getElementById("searchInput").value = "";

  // clear ALL radios
  document.querySelectorAll("input[type=radio]").forEach(r => {
    r.checked = false;
    r.disabled = false;
  });

  enableRadios(officeRadios);
  enableRadios(programRadios);

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
  selectedYear = String(year);

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

document.getElementById("fromMonth").value = `${year}-${month}`;
document.getElementById("toMonth").value = `${year}-${month}`;


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
