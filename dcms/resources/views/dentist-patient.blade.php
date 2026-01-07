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

  <!-- Cally Calendar -->
  <script type="module" src="https://unpkg.com/cally"></script>

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

  <style>
    body { font-family: 'Inter'; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }
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

    <a class="flex flex-col items-center opacity-60 hover:opacity-100">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>
  </nav>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-6 py-10 fade-in">

  <!-- Patient List Card -->
  <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#8B0000]/30">

    <!-- Title + Search / Filter -->
<div class="flex items-center justify-between mb-6">

  <!-- Title -->
  <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 to-orange-400 bg-clip-text text-transparent">
  Patient List
</h2>


  <!-- Search / Filter Group -->
  <div class="flex items-center">

    <div class="flex items-center">

<!-- SEARCH / FILTER GROUP -->
<div
  class="flex items-center rounded-full
         bg-gradient-to-r from-red-800 via-orange-500 to-yellow-400
         p-[2px]"
>

  <!-- Inner container (keeps original size) -->
<div class="flex items-center w-full h-full bg-white rounded-2xl">

    <!-- Search Icon Circle -->
  <div class="flex items-center justify-center ml-3 w-7 h-7 rounded-full bg-red-800">
    <i class="fa-solid fa-magnifying-glass text-white text-xs"></i>
  </div>


    <!-- Search Input -->
    <input
      type="text"
      placeholder="Search"
      class="flex-1 ml-3 bg-transparent
             text-gray-700 text-sm
             placeholder:text-gray-300
             focus:outline-none"
    />

    <!-- Divider -->
    <div class="relative z-20 flex items-center">

  <!-- Filter Button -->
      <button
        id="openFilter"
        class="flex items-center gap-2 mr-5 text-red-800 font-medium text-sm"
      >
        <i class="fa-solid fa-sliders"></i>
        Filter
      </button>
    </div>


    <!-- Overlay -->
<div
  id="filterModal"
  class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden"
>
  <!-- Modal Box -->
  <div class="bg-white w-[680px] rounded-xl shadow-lg p-6 font-['Inter']">
    
    <!-- Header -->
    <div class="flex items-center gap-2 mb-4 text-red-800">
      <i class="fa-solid fa-sliders"></i>
      <h2 class="text-lg font-medium">Filter</h2>
    </div>

    <hr class="mb-4" />

     <!-- Sort -->
              <p class="text-sm text-gray-500 mb-2">Sort</p>
              <div class="flex gap-6 mb-4">
                <label class="flex items-center gap-2 text-sm">
                  <input type="radio" name="sort" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" />
                  A-Z
                </label>
                <label class="flex items-center gap-2 text-sm">
                  <input type="radio" name="sort" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" />
                  Z-A
                </label>
              </div>

              <hr class="mb-4" />

              <!-- Date Range -->
              <p class="text-sm text-gray-500 mb-2">Date Range</p>
              <div class="flex items-center gap-6 mb-4">
                <div>
                  <label class="text-sm">From:</label>
                  <input type="date" class="bg-transparent border border-red-800 text-gray-700 rounded-md px-3 py-1 w-[160px] focus:outline-none focus:ring-1 focus:ring-red-300"/>
                </div>
                <div>
                  <label class="text-sm">To:</label>
                  <input type="date" class="bg-transparent border border-red-800 text-gray-700 rounded-md px-3 py-1 w-[160px] focus:outline-none focus:ring-1 focus:ring-red-300"/>
                </div>
                <div class="ml-6">
                  <label class="flex items-center gap-2 text-sm">
                    <input type="radio" name="order" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" />
                    Ascending
                  </label>
                  <label class="flex items-center gap-2 text-sm mt-1">
                    <input type="radio" name="order" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" />
                    Descending
                  </label>
                </div>
              </div>

              <hr class="mb-4" />

              <!-- Course -->
              <p class="text-sm text-gray-500 mb-2">Course</p>
              <div class="grid grid-cols-6 gap-3 mb-4 text-sm">
                <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> BSIT</label>
                <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> BSECE</label>
                <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> BSBA - HRM</label>
                <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> BSED - ENG</label>
                <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> BSOA</label>
                <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> BSPSYCH</label>
              </div>

              <hr class="mb-4" />

              <!-- Year & Section -->
              <div class="flex gap-20 mb-6">
                <div>
                  <p class="text-sm text-gray-500 mb-2">Year</p>
                  <div class="space-y-2 text-sm">
                    <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> 1st Year</label>
                    <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> 2nd Year</label>
                    <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> 3rd Year</label>
                    <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> 4th Year</label>
                  </div>
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-2">Section</p>
                  <div class="space-y-2 text-sm">
                    <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> 1</label>
                    <label class="flex items-center gap-2"><input type="radio" class="w-4 h-4 rounded-full border-2 border-red-800 appearance-none checked:bg-red-800 checked:border-red-800" /> 2</label>
                  </div>
                </div>
              </div>


    <!-- Footer -->
    <div class="flex justify-between items-center">
      <button
        id="closeFilter"
        class="text-sm text-red-700 hover:underline"
      >
        Clear
      </button>

      <button
        class="bg-[#8B0000] text-white px-6 py-2 rounded-md text-sm"
      >
        Save
      </button>
    </div>

  </div>
</div>


  </div>
</div>


  <!-- Clear -->
  <button
    id="clearFilters"
   class="h-10 px-4 text-red-600 text-sm rounded-r-full hover:bg-red-50">
    Clear
  </button>

</div>


  </div>
</div>

   <!-- Filter Stats -->
<!-- Scheduled Today -->
<button class="filter-btn bg-[#8B0000] text-white rounded-t-xl px-6 py-5 w-[220px] text-left"
        data-filter="today">
  <h3 class="text-3xl font-medium leading-none mb-2">5</h3>
  <p class="text-sm opacity-90">Scheduled Today</p>
</button>

<!-- Rescheduled -->
<button class="filter-btn bg-[#8B0000] text-white rounded-t-xl px-6 py-5 w-[220px] text-left"
        data-filter="rescheduled">
  <h3 class="text-3xl font-medium leading-none mb-2">10</h3>
  <p class="text-sm opacity-90">Rescheduled</p>
</button>

<!-- All -->
<button class="filter-btn bg-[#8B0000] text-white rounded-t-xl px-6 py-5 w-[220px] text-left"
        data-filter="all">
  <h3 class="text-3xl font-medium leading-none mb-2">50</h3>
  <p class="text-sm opacity-90">All</p>
</button>
    </div>


  <div class="bg-[#F5F5F5] rounded-xl px-6 pt-10 pb-6 shadow-sm">
    <p class="text-[18px] text-[#333333] font-['Inter'] mb-4">
      Click to Access Patient Information
    </p>


    <!-- Patient Information Section -->

    <!-- Patient Rows -->
    <div class="space-y-4">

      <!-- Patient Item -->
<div class="patient-item today flex items-center justify-between bg-gray-50 hover:bg-[#FDF1D6] transition p-4 rounded-xl cursor-pointer">
  <div class="flex items-center gap-4">
    <img src="https://i.pravatar.cc/51" class="w-10 h-10 rounded-full" />
    <div>
      <p class="font-semibold">Romero, Dianna</p>
      <p class="text-xs text-gray-500">2023-00010</p>
    </div>
  </div>
  <div class="hidden md:block text-sm text-gray-600">
    January 20, 2025 · 9:00 AM
  </div>
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
      <p class="text-xs text-gray-500">2023-00011</p>
    </div>
  </div>
  <div class="hidden md:block text-sm text-gray-600">
    January 20, 2025 · 11:30 AM
  </div>
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
      <p class="text-xs text-gray-500">2023-00012</p>
    </div>
  </div>
  <div class="hidden md:block text-sm text-gray-600">
    January 20, 2025 · 3:00 PM
  </div>
  <div class="text-right">
    <p class="font-medium text-[#8B0000]">Dental Restoration</p>
    <p class="text-xs text-green-600">Appointment Today</p>
  </div>
</div>

<div class="patient-item rescheduled flex items-center justify-between bg-gray-50 hover:bg-[#FFF4E0] transition p-4 rounded-xl cursor-pointer">
  <div class="flex items-center gap-4">
    <img src="https://i.pravatar.cc/54" class="w-10 h-10 rounded-full" />
    <div>
      <p class="font-semibold">Reyes, Joshua</p>
      <p class="text-xs text-gray-500">2023-00013</p>
    </div>
  </div>
  <div class="hidden md:block text-sm text-gray-600">
    January 22, 2025 · 10:00 AM
  </div>
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
      <p class="text-xs text-gray-500">2023-00014</p>
    </div>
  </div>
  <div class="hidden md:block text-sm text-gray-600">
    January 23, 2025 · 1:00 PM
  </div>
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
      <p class="text-xs text-gray-500">2023-00015</p>
    </div>
  </div>
  <div class="hidden md:block text-sm text-gray-600">
    January 24, 2025 · 4:30 PM
  </div>
  <div class="text-right">
    <p class="font-medium text-[#8B0000]">Dental Consultation</p>
    <p class="text-xs text-orange-600">Rescheduled</p>
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


<script>
document.addEventListener("DOMContentLoaded", () => {
  const openFilter = document.getElementById("openFilter");
  const filterModal = document.getElementById("filterModal");
  const clearInsideForm = document.getElementById("closeFilter"); // Clear inside modal
  const clearOutside = document.getElementById("clearFilters"); // Clear outside modal
  const filterButtons = document.querySelectorAll(".filter-btn");
  const patientItems = document.querySelectorAll(".patient-item");
  const scheduledBtnCount = document.querySelector('.filter-btn[data-filter="today"] h3');
  const rescheduledBtnCount = document.querySelector('.filter-btn[data-filter="rescheduled"] h3');
  const allBtnCount = document.querySelector('.filter-btn[data-filter="all"] h3');



  /* =====================
     OPEN FILTER MODAL
     ===================== */
  if (openFilter && filterModal) {
    openFilter.addEventListener("click", () => {
      filterModal.classList.remove("hidden");
    });
  }

  /* =====================
     CLEAR BUTTON (INSIDE MODAL)
     ===================== */
  if (clearInsideForm) {
    clearInsideForm.addEventListener("click", (e) => {
      e.preventDefault();
      resetFilters();
    });
  }

  /* =====================
     CLEAR BUTTON (OUTSIDE)
     ===================== */
  if (clearOutside) {
    clearOutside.addEventListener("click", () => {
      resetFilters();
    });
  }

  /* =====================
     CLICK OUTSIDE MODAL TO CLOSE
     ===================== */
  if (filterModal) {
    filterModal.addEventListener("click", (e) => {
      if (e.target === filterModal) {
        filterModal.classList.add("hidden");
      }
    });
  }

  /* =====================
     RESET FILTERS FUNCTION
     ===================== */
  function resetFilters() {

    /* RADIO GROUP RESET
       → Select FIRST option per group */
    const radioGroups = {};

    filterModal.querySelectorAll('input[type="radio"]').forEach(radio => {
      if (!radioGroups[radio.name]) {
        radioGroups[radio.name] = [];
      }
      radioGroups[radio.name].push(radio);
    });

    Object.values(radioGroups).forEach(group => {
      group.forEach(r => r.checked = false);
      if (group[0]) group[0].checked = true;
    });

    /* CHECKBOX RESET */
    filterModal.querySelectorAll('input[type="checkbox"]').forEach(cb => {
      cb.checked = false;
    });

    /* TEXT & DATE INPUTS */
    filterModal.querySelectorAll('input[type="text"], input[type="date"]').forEach(input => {
      input.value = "";
    });

    /* SELECT RESET */
    filterModal.querySelectorAll("select").forEach(select => {
      select.selectedIndex = 0;
    });
  }

   /* =====================
     FILTER PATIENTS
     ===================== */
  function filterPatients(type) {
    patientItems.forEach(patient => {
      if (type === "all") {
        patient.style.display = "flex";
      } else {
        patient.style.display = patient.classList.contains(type)
          ? "flex"
          : "none";
      }
    });
  }

  /* =====================
     FILTER BUTTON CLICK
     ===================== */
  filterButtons.forEach(button => {
    button.addEventListener("click", () => {
      const filterType = button.dataset.filter;
      filterPatients(filterType);
    });
      // Function to show patients based on filter
  const showPatients = (filter) => {
    patientItems.forEach(patient => {
      if (filter === "all") {
        patient.style.display = "flex";
      } else {
        patient.style.display = patient.classList.contains(filter) ? "flex" : "none";
      }
    });
  };

  // Function to update the numbers on the buttons
  const updateCounts = () => {
    scheduledBtnCount.textContent = document.querySelectorAll(".patient-item.today").length;
    rescheduledBtnCount.textContent = document.querySelectorAll(".patient-item.rescheduled").length;
    allBtnCount.textContent = patientItems.length;
  };

  // Add click events to filter buttons
  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      const filter = btn.dataset.filter;
      showPatients(filter);
      updateCounts(); // optional: update counts in case you dynamically change patients
    });
  });

  // Initialize counts on page load
  updateCounts();
});

  });

</script>

