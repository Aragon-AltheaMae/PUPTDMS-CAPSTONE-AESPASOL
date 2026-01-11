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
    </style>
</head>

<body class="bg-gray-200">

<!-- ================= TOP HEADER ================= -->
<header class="bg-gradient-to-r from-red-900 to-red-700 text-white px-8 py-4 flex justify-between items-center">
    <div class="flex items-center gap-3 font-bold">
        <img src="{{ asset('images/PUP.png') }}" class="w-10 h-10">
        <i class="fa-solid fa-tooth text-xl"></i>
        <span>PUP TAGUIG DENTAL CLINIC</span>
    </div>

    <div class="flex items-center gap-6">
        <i class="fa-regular fa-bell text-lg"></i>
        <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
            <div class="text-sm">
                <p class="font-semibold">Dr. Nelson Angeles</p>
                <p class="text-xs opacity-80">Dentist</p>
            </div>
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
<main class="p-8">

    <!-- HEADER ROW -->
    <div class="flex justify-between items-center mb-6">

        <!-- LEFT: TITLE -->
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                      bg-clip-text text-transparent">
                Daily Treatment Record
            </h1>
            <p class="text-red-700 mt-1">December 2025</p>
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
                  class="flex items-center gap-2 px-6 py-2 text-sm font-medium text-[#8B0000] bg-white hover:bg-[#FFF7E6] active:bg-[#FFEFC8]"
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


        <!-- INNER TABLE BORDER -->
        <div class="border-2 border-gray-300 rounded-xl p-4 overflow-x-auto">

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
const dailyRecords = [
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
];

function renderDailyRecords() {
  const tbody = document.getElementById("dailyTableBody");
  tbody.innerHTML = "";

  dailyRecords.forEach(record => {
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
}

renderDailyRecords();

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
