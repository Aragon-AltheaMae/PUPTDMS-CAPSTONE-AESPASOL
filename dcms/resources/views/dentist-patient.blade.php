<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Patient List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
          colors: { primaryDark: "#7a0000", primaryMain: "#8b0000" }
        }
      }
    }
  </script>

  <style>
    body { font-family: 'Inter'; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }
  </style>
</head>

<body class="bg-gray-100 font-sans">

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
      <i class="fa-solid fa-right-from-bracket cursor-pointer"></i>
    </div>
  </div>
</header>

<!-- ================= NAV HEADER ================= -->
<header class="bg-primaryMain text-white px-8 py-3">
  <nav class="flex justify-around text-sm">
    <a href="#" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-chart-line text-lg"></i>
      <span>Dashboard</span>
    </a>
    <a href="#" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-users text-lg"></i>
      <span>Patients</span>
    </a>
    <a href="#" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>
    <a href="#" class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-box text-lg"></i>
      <span>Inventory</span>
    </a>
    <a class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>
  </nav>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-6 py-10 fade-in">

  <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#8B0000]/30">

    <!-- Title + Search / Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
      <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 to-orange-400 bg-clip-text text-transparent">
        Patient List
      </h2>

      <div class="flex items-center gap-3 w-full md:w-auto">

        <!-- Search Input -->
        <div class="flex items-center rounded-full bg-gradient-to-r from-red-800 via-orange-500 to-yellow-400 p-[2px] flex-1 md:flex-none">
          <div class="flex items-center w-full h-full bg-white rounded-2xl">
            <div class="flex items-center justify-center ml-3 w-7 h-7 rounded-full bg-red-800">
              <i class="fa-solid fa-magnifying-glass text-white text-xs"></i>
            </div>
            <input id="searchInput" type="text" placeholder="Search patient..." 
                   class="flex-1 ml-3 bg-transparent text-gray-700 text-sm placeholder:text-gray-300 focus:outline-none rounded-r-2xl px-2"/>
          </div>
        </div>

        <!-- Filter Button -->
        <button id="openFilter" class="flex items-center gap-2 text-red-800 font-medium text-sm px-4 py-2 rounded-full border border-red-800 hover:bg-red-50">
          <i class="fa-solid fa-sliders"></i> Filter
        </button>

      </div>
    </div>

    <!-- Filter Stats -->
    <div class="flex gap-4 mb-6 flex-wrap">
      <button class="filter-btn bg-[#8B0000] text-white rounded-t-xl px-6 py-5 w-[180px] text-left" data-filter="today">
        <h3 class="text-3xl font-medium leading-none mb-2">5</h3>
        <p class="text-sm opacity-90">Scheduled Today</p>
      </button>
      <button class="filter-btn bg-[#8B0000] text-white rounded-t-xl px-6 py-5 w-[180px] text-left" data-filter="rescheduled">
        <h3 class="text-3xl font-medium leading-none mb-2">10</h3>
        <p class="text-sm opacity-90">Rescheduled</p>
      </button>
      <button class="filter-btn bg-[#8B0000] text-white rounded-t-xl px-6 py-5 w-[180px] text-left" data-filter="all">
        <h3 class="text-3xl font-medium leading-none mb-2">50</h3>
        <p class="text-sm opacity-90">All</p>
      </button>
    </div>

   <!-- Patient List -->
<div id="patientContainer" class="space-y-4">

  <!-- Scheduled Today -->
  <div class="patient-item today flex items-center justify-between bg-gray-50 hover:bg-[#FDF1D6] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/51" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Romero, Dianna</p>
        <p class="text-xs text-gray-500">2023-00010 · BSIT · 2nd Year · Section 1</p>
        <span class="patient-info hidden">BSIT|2nd Year|1|2025-01-20</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 20, 2025 · 9:00 AM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Dental Checkup</p>
      <p class="text-xs text-green-600">Appointment Today</p>
    </div>
  </div>

  <div class="patient-item today flex items-center justify-between bg-gray-50 hover:bg-[#FDF1D6] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/52" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Dela Cruz, Mark</p>
        <p class="text-xs text-gray-500">2023-00011 · BSECE · 1st Year · Section 2</p>
        <span class="patient-info hidden">BSECE|1st Year|2|2025-01-20</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 20, 2025 · 11:30 AM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Tooth Cleaning</p>
      <p class="text-xs text-green-600">Appointment Today</p>
    </div>
  </div>

  <div class="patient-item today flex items-center justify-between bg-gray-50 hover:bg-[#FDF1D6] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/53" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Santos, Alyssa</p>
        <p class="text-xs text-gray-500">2023-00012 · BSBA - HRM · 3rd Year · Section 1</p>
        <span class="patient-info hidden">BSBA - HRM|3rd Year|1|2025-01-20</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 20, 2025 · 3:00 PM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Dental Restoration</p>
      <p class="text-xs text-green-600">Appointment Today</p>
    </div>
  </div>

  <!-- Rescheduled -->
  <div class="patient-item rescheduled flex items-center justify-between bg-gray-50 hover:bg-[#FFF4E0] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/54" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Reyes, Joshua</p>
        <p class="text-xs text-gray-500">2023-00013 · BSED - ENG · 2nd Year · Section 1</p>
        <span class="patient-info hidden">BSED - ENG|2nd Year|1|2025-01-22</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 22, 2025 · 10:00 AM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Tooth Extraction</p>
      <p class="text-xs text-orange-600">Rescheduled</p>
    </div>
  </div>

  <div class="patient-item rescheduled flex items-center justify-between bg-gray-50 hover:bg-[#FFF4E0] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/55" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Garcia, Nicole</p>
        <p class="text-xs text-gray-500">2023-00014 · BSOA · 1st Year · Section 2</p>
        <span class="patient-info hidden">BSOA|1st Year|2|2025-01-23</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 23, 2025 · 1:00 PM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Dental Surgery</p>
      <p class="text-xs text-orange-600">Rescheduled</p>
    </div>
  </div>

  <div class="patient-item rescheduled flex items-center justify-between bg-gray-50 hover:bg-[#FFF4E0] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/56" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Lopez, Christian</p>
        <p class="text-xs text-gray-500">2023-00015 · BSPSYCH · 3rd Year · Section 1</p>
        <span class="patient-info hidden">BSPSYCH|3rd Year|1|2025-01-24</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 24, 2025 · 4:30 PM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Dental Consultation</p>
      <p class="text-xs text-orange-600">Rescheduled</p>
    </div>
  </div>

  <!-- Additional Patients -->
  <div class="patient-item today flex items-center justify-between bg-gray-50 hover:bg-[#FDF1D6] transition p-4 rounded-xl cursor-pointer">
    <div class="flex items-center gap-4">
      <img src="https://i.pravatar.cc/57" class="w-10 h-10 rounded-full" />
      <div>
        <p class="font-semibold">Villanueva, Emily</p>
        <p class="text-xs text-gray-500">2023-00016 · BSECE · 2nd Year · Section 1</p>
        <span class="patient-info hidden">BSECE|2nd Year|1|2025-01-20</span>
      </div>
    </div>
    <div class="hidden md:block text-sm text-gray-600">January 20, 2025 · 2:00 PM</div>
    <div class="text-right">
      <p class="font-medium text-[#8B0000]">Tooth Cleaning</p>
      <p class="text-xs text-green-600">Appointment Today</p>
    </div>
  </div>

</div>


<!-- ===================== FILTER MODAL ===================== -->
<div id="filterModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-[680px] rounded-xl shadow-lg p-6">
    <div class="flex items-center gap-2 mb-4 text-red-800">
      <i class="fa-solid fa-sliders"></i>
      <h2 class="text-lg font-medium">Filter</h2>
    </div>

    <hr class="mb-4" />

    <!-- Sort -->
    <p class="text-sm text-gray-500 mb-2">Sort</p>
    <div class="flex gap-6 mb-4">
      <label class="flex items-center gap-2 text-sm">
        <input type="radio" name="sort" value="A-Z" class="filter-input" /> A-Z
      </label>
      <label class="flex items-center gap-2 text-sm">
        <input type="radio" name="sort" value="Z-A" class="filter-input" /> Z-A
      </label>
    </div>

    <hr class="mb-4" />

    <!-- Date Range -->
    <p class="text-sm text-gray-500 mb-2">Date Range</p>
    <div class="flex items-center gap-6 mb-4">
      <div>
        <label class="text-sm">From:</label>
        <input type="date" id="fromDate" class="bg-transparent border border-red-800 text-gray-700 rounded-md px-3 py-1 w-[160px] focus:outline-none focus:ring-1 focus:ring-red-300"/>
      </div>
      <div>
        <label class="text-sm">To:</label>
        <input type="date" id="toDate" class="bg-transparent border border-red-800 text-gray-700 rounded-md px-3 py-1 w-[160px] focus:outline-none focus:ring-1 focus:ring-red-300"/>
      </div>
    </div>

    <hr class="mb-4" />

    <!-- Course / Year / Section -->
    <p class="text-sm text-gray-500 mb-2">Course</p>
    <div class="grid grid-cols-6 gap-3 mb-4 text-sm">
      <label class="flex items-center gap-2"><input type="radio" name="course" value="BSIT" class="filter-input" /> BSIT</label>
      <label class="flex items-center gap-2"><input type="radio" name="course" value="BSECE" class="filter-input" /> BSECE</label>
      <label class="flex items-center gap-2"><input type="radio" name="course" value="BSBA - HRM" class="filter-input" /> BSBA - HRM</label>
      <label class="flex items-center gap-2"><input type="radio" name="course" value="BSED - ENG" class="filter-input" /> BSED - ENG</label>
      <label class="flex items-center gap-2"><input type="radio" name="course" value="BSOA" class="filter-input" /> BSOA</label>
      <label class="flex items-center gap-2"><input type="radio" name="course" value="BSPSYCH" class="filter-input" /> BSPSYCH</label>
    </div>

    <div class="flex gap-20 mb-6">
      <div>
        <p class="text-sm text-gray-500 mb-2">Year</p>
        <div class="space-y-2 text-sm">
          <label class="flex items-center gap-2"><input type="radio" name="year" value="1st Year" class="filter-input" /> 1st Year</label>
          <label class="flex items-center gap-2"><input type="radio" name="year" value="2nd Year" class="filter-input" /> 2nd Year</label>
          <label class="flex items-center gap-2"><input type="radio" name="year" value="3rd Year" class="filter-input" /> 3rd Year</label>
          <label class="flex items-center gap-2"><input type="radio" name="year" value="4th Year" class="filter-input" /> 4th Year</label>
        </div>
      </div>
      <div>
        <p class="text-sm text-gray-500 mb-2">Section</p>
        <div class="space-y-2 text-sm">
          <label class="flex items-center gap-2"><input type="radio" name="section" value="1" class="filter-input" /> 1</label>
          <label class="flex items-center gap-2"><input type="radio" name="section" value="2" class="filter-input" /> 2</label>
        </div>
      </div>
    </div>

    <div class="flex justify-between items-center">
      <button id="clearFiltersModal" class="text-sm text-red-700 hover:underline">Clear</button>
      <button id="applyFilters" class="bg-[#8B0000] text-white px-6 py-2 rounded-md text-sm">Apply</button>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">
  <!-- Footer content here (unchanged) -->
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const patientContainer = document.getElementById("patientContainer");
  const patients = Array.from(patientContainer.querySelectorAll(".patient-item"));
  const filterModal = document.getElementById("filterModal");
  const openFilter = document.getElementById("openFilter");
  const clearFiltersModal = document.getElementById("clearFiltersModal");
  const applyFilters = document.getElementById("applyFilters");
  const searchInput = document.getElementById("searchInput");
  const filterButtons = document.querySelectorAll(".filter-btn");
  const scheduledBtnCount = document.querySelector('.filter-btn[data-filter="today"] h3');
  const rescheduledBtnCount = document.querySelector('.filter-btn[data-filter="rescheduled"] h3');
  const allBtnCount = document.querySelector('.filter-btn[data-filter="all"] h3');

  // Modal open/close
  openFilter.addEventListener("click", () => filterModal.classList.remove("hidden"));
  filterModal.addEventListener("click", e => { if(e.target === filterModal) filterModal.classList.add("hidden"); });

  clearFiltersModal.addEventListener("click", () => {
    filterModal.querySelectorAll(".filter-input").forEach(i => i.checked = false);
    document.getElementById("fromDate").value = "";
    document.getElementById("toDate").value = "";
    filterModal.classList.add("hidden");
    showPatients("all");
  });

  applyFilters.addEventListener("click", () => {
    const sortOption = filterModal.querySelector('input[name="sort"]:checked')?.value;
    const selectedCourse = filterModal.querySelector('input[name="course"]:checked')?.value;
    const selectedYear = filterModal.querySelector('input[name="year"]:checked')?.value;
    const selectedSection = filterModal.querySelector('input[name="section"]:checked')?.value;
    const fromDate = document.getElementById("fromDate").value;
    const toDate = document.getElementById("toDate").value;

    let filtered = patients.slice();
    filtered = filtered.filter(p => {
      const info = p.querySelector(".patient-info").textContent;
      const date = new Date(info.split("|")[3]);
      if(selectedCourse && !info.includes(selectedCourse)) return false;
      if(selectedYear && !info.includes(selectedYear)) return false;
      if(selectedSection && !info.includes(selectedSection)) return false;
      if(fromDate && date < new Date(fromDate)) return false;
      if(toDate && date > new Date(toDate)) return false;
      return true;
    });

    if(sortOption) {
      filtered.sort((a,b) => {
        const nameA = a.querySelector(".font-semibold").textContent.toUpperCase();
        const nameB = b.querySelector(".font-semibold").textContent.toUpperCase();
        return sortOption==="A-Z"?nameA.localeCompare(nameB):nameB.localeCompare(nameA);
      });
    }

    patientContainer.innerHTML = "";
    filtered.forEach(p => patientContainer.appendChild(p));
    filterModal.classList.add("hidden");
    updateCounts();
  });

  // Live search
  searchInput.addEventListener("input", () => {
    const query = searchInput.value.toLowerCase();
    patients.forEach(p => {
      const name = p.querySelector(".font-semibold").textContent.toLowerCase();
      p.style.display = name.includes(query) ? "flex" : "none";
    });
    updateCounts();
  });

  // Filter buttons
  function showPatients(type) {
    patients.forEach(p => {
      p.style.display = (type==="all" || p.classList.contains(type)) ? "flex" : "none";
    });
    updateCounts();
  }

  filterButtons.forEach(btn => btn.addEventListener("click", () => showPatients(btn.dataset.filter)));

  // Update counts
  function updateCounts() {
    scheduledBtnCount.textContent = patients.filter(p=>p.classList.contains("today") && p.style.display!=="none").length;
    rescheduledBtnCount.textContent = patients.filter(p=>p.classList.contains("rescheduled") && p.style.display!=="none").length;
    allBtnCount.textContent = patients.filter(p=>p.style.display!=="none").length;
  }

  updateCounts();
});
</script>
</body>
</html>
