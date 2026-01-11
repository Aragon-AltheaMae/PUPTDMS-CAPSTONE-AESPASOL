<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dentist – Patient Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'ui-sans-serif'] },
          colors: {
            primary: '#8B0000'
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-100">

<!-- ================= HEADER ================= -->
<header class="bg-[#8B0000] h-16 shadow">
</header>

<!-- ================= MAIN ================= -->
<main class="max-w-6xl mx-auto px-10 py-8 space-y-10">

<!-- Page Title with Back Arrow -->
<div class="flex items-center gap-4 mb-6">
  <a href="{{ route('dentist.patients') }}" class="w-10 h-10 flex items-center justify-center
       rounded-full border border-orange-400 text-orange-500 hover:bg-orange-100 transition">
    <i class="fa-solid fa-arrow-left"></i>
  </a>

  <h1 class="text-2xl font-medium text-primary">
    Patient Profile
  </h1>
</div>

<!-- ================= PATIENT PROFILE ================= -->
<section>
  <div class="bg-gradient-to-r from-[#8B0000] to-[#5e0000]
              rounded-2xl text-white
              px-14 py-10 shadow-xl">

    <div class="flex items-center gap-12">

      <!-- Avatar -->
      <img src="https://i.pravatar.cc/180"
           class="w-36 h-36 rounded-full object-cover border-4 border-[#7a0000]" />

      <!-- LEFT INFO -->
      <div class="flex-1">
        <p class="text-3xl font-semibold leading-tight">
          Capilitan, Beyonce
        </p>

        <p class="text-base opacity-90 mt-1">
          2023-00099
        </p>

        <p class="text-base mt-4 leading-tight">
          TG-0<br>
          BSIT 3-1
        </p>
      </div>

      <!-- RIGHT INFO -->
      <div class="grid grid-cols-2 gap-x-10 gap-y-4 text-base">
        <span class="opacity-80">Age</span>
        <span>18</span>

        <span class="opacity-80">Birthdate</span>
        <span>January 01, 2004</span>

        <span class="opacity-80">Sex</span>
        <span>F</span>
      </div>
    </div>

    <!-- BUTTON -->
    <div class="flex justify-center mt-8">
      <button
        class="px-10 py-3 rounded-lg
               border border-yellow-400 text-yellow-300
               hover:bg-yellow-400 hover:text-[#5e0000]
               transition font-medium">
        View Odontogram
      </button>
    </div>

  </div>
</section>


<!-- Tabs for History -->
<div class="flex gap-16 justify-start px-6 mb-4">
  <button
    id="tabDental"
    class="tab-btn text-primary font-semibold text-lg
           border-b-2 border-primary
           pb-3 px-3
           transition"
    onclick="showHistoryTab('dental')"
  >
    Dental
  </button>

  <button
    id="tabMedical"
    class="tab-btn text-gray-400 hover:text-primary
           font-semibold text-lg
           pb-3 px-3
           transition"
    onclick="showHistoryTab('medical')"
  >
    Medical
  </button>
</div>


  <!-- ================= DENTAL CONTENT ================= -->
  <div id="dentalTab" class="border border-red-600 rounded-xl p-6 bg-white space-y-8">

    <!-- Previous Dentist -->
    <div class="flex gap-4">
      <div class="w-[3px] bg-red-600 rounded"></div>

      <div class="space-y-1 text-sm">
        <p class="text-primary font-medium">Previous Dentist:</p>
        <p class="text-gray-800">Dr. Abby Salle</p>

        <p class="text-primary font-medium mt-2">Last Dental Visit:</p>
        <p class="text-gray-700">April 23, 2024</p>
      </div>
    </div>

    <!-- Previous Treatment -->
    <div class="flex gap-4">
      <div class="w-[3px] bg-yellow-500 rounded"></div>

      <div class="space-y-2 text-sm">
        <p class="text-primary font-medium">Previous Treatment</p>

        <p class="text-gray-800 flex items-center gap-2">
          <span class="text-orange-500 text-lg leading-none">•</span>
          Dental Restoration &amp; Prosthesis
        </p>

        <p class="text-gray-600 text-xs">
          Diagnosis: AB - Abutment
        </p>

        <p class="text-primary text-xs mt-2">
          Dr. Nelson Angeles
        </p>
      </div>
    </div>
  </div>

  <!-- ================= MEDICAL CONTENT ================= -->
  <div
    id="medicalTab"
    class="border border-red-600 rounded-xl p-6 bg-white space-y-6 hidden"
  >
    <div class="flex gap-4">
      <div class="w-[3px] bg-red-600 rounded"></div>

      <div class="space-y-1 text-sm">
        <p class="text-primary font-medium">Medical Condition:</p>
        <p class="text-gray-800">No known medical conditions</p>

        <p class="text-primary font-medium mt-2">Allergies:</p>
        <p class="text-gray-700">None reported</p>
      </div>
    </div>
  </div>
</section>

<!-- ================= CLINIC VISITS ================= -->
<section class="mt-10">

  <!-- Title -->
  <p class="text-center text-primary font-medium text-2xl mb-6">
    Clinic Visits
  </p>

  <!-- Gray Container -->
  <div class="bg-gray-200 rounded-xl px-16 py-12 w-full max-w-full mx-auto">

    <!-- Tabs (Future and Past Visits) -->
    <div class="flex justify-center gap-20 mb-6 text-sm">
      <button
        id="futureVisitsBtn"
        class="text-[#8B0000] font-medium border-b-2 border-[#8B0000] pb-2"
        onclick="showVisitTab('future')">
        Future Visits (1)
      </button>
      <button
        id="pastVisitsBtn"
        class="text-gray-400 font-medium"
        onclick="showVisitTab('past')">
        Past Visits (0)
      </button>
    </div>

    <!-- Future Visits Tab Content -->
    <div id="futureVisitsTab" class="tab-content">
      <div class="relative bg-[#FFF1F1] rounded-2xl px-16 py-14">
        <!-- Left red bar -->
        <div class="absolute left-0 top-0 h-full w-1 bg-[#8B0000] rounded-l-2xl"></div>

        <!-- Single Line Flex Layout -->
        <div class="flex items-center gap-4">
          <!-- Date -->
          <div class="flex-1">
            <p class="font-semibold text-gray-900">
              29 Dec 2025
            </p>
            <p class="text-xs text-gray-600">
              1:30 PM – 2:30 PM
            </p>
          </div>

          <!-- Long Red Divider -->
          <div class="h-14 w-px bg-red-500 mx-4"></div>

          <!-- Service -->
          <div class="flex-1">
            <p class="text-sm text-gray-500">Service</p>
            <p class="font-medium text-gray-900">
              Dental Surgery
            </p>
          </div>

          <!-- Long Red Divider -->
          <div class="h-14 w-px bg-red-500 mx-4"></div>

          <!-- Dentist -->
          <div class="flex-1">
            <p class="text-sm text-gray-500">Dentist</p>
            <p class="font-medium text-gray-900">
              Dr. Nelson Angeles
            </p>
          </div>

          <!-- Long Red Divider -->
          <div class="h-14 w-px bg-red-500 mx-4"></div>

          <!-- Status -->
          <div class="flex-1 text-left">
            <p class="text-sm text-gray-500">Status</p>
            <span class="inline-block bg-blue-200 text-blue-700 text-xs font-semibold px-3 py-1 rounded">
              SCHEDULED
            </span>
          </div>
        </div>

        <!-- Button (aligned to the bottom-right of the container) -->
        <div class="absolute bottom-2 right-5">
          <button
            class="bg-green-600 text-white text-xs px-4 py-1.5 rounded-md hover:bg-green-700 transition">
            Start Procedure
          </button>
        </div>
      </div>
    </div>

    <!-- Past Visits Tab Content (hidden by default) -->
    <div id="pastVisitsTab" class="tab-content hidden">
      <div class="relative bg-[#FFF1F1] rounded-2xl px-16 py-14">
        <!-- Left red bar -->
        <div class="absolute left-0 top-0 h-full w-1 bg-[#8B0000] rounded-l-2xl"></div>

        <!-- Single Line Flex Layout -->
        <div class="flex items-center gap-4">
          <!-- Date -->
          <div class="flex-1">
            <p class="font-semibold text-gray-900">
              20 Dec 2024
            </p>
            <p class="text-xs text-gray-600">
              2:00 PM – 3:00 PM
            </p>
          </div>

          <!-- Long Red Divider -->
          <div class="h-14 w-px bg-red-500 mx-4"></div>

          <!-- Service -->
          <div class="flex-1">
            <p class="text-sm text-gray-500">Service</p>
            <p class="font-medium text-gray-900">
              Tooth Extraction
            </p>
          </div>

          <!-- Long Red Divider -->
          <div class="h-14 w-px bg-red-500 mx-4"></div>

          <!-- Dentist -->
          <div class="flex-1">
            <p class="text-sm text-gray-500">Dentist</p>
            <p class="font-medium text-gray-900">
              Dr. Sarah Cruz
            </p>
          </div>

          <!-- Long Red Divider -->
          <div class="h-14 w-px bg-red-500 mx-4"></div>

          <!-- Status -->
          <div class="flex-1 text-left">
            <p class="text-sm text-gray-500">Status</p>
            <span class="inline-block bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1 rounded">
              COMPLETED
            </span>
          </div>
        </div>

        <!-- Button (aligned to the bottom-right of the container) -->
        <div class="absolute bottom-2 right-5">
          <button
            class="bg-green-600 text-white text-xs px-4 py-1.5 rounded-md hover:bg-green-700 transition">
            View Details
          </button>
        </div>
      </div>
    </div>

  </div>
</section>
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

<!-- CONFIRM SAVE MODAL -->
<dialog id="confirmSaveModal" class="modal">
  <div class="modal-box rounded-2xl bg-[#F4F4F4]">
    <h3 class="font-bold text-lg mb-2">Confirm</h3>
    <p id="confirmSaveText" class="mb-6">Are you sure?</p>
    <div class="modal-action flex justify-between">
      <button onclick="confirmSaveModal.close()" class="btn">Cancel</button>
      <button onclick="submitConfirmedForm()" class="btn btn-error text-white">Yes, Submit</button>
    </div>
  </div>
</dialog>

<!-- SUBMITTED INFO MODAL -->
<dialog id="submittedInfoModal" class="modal">
  <div class="modal-box rounded-2xl bg-[#F4F4F4]">
    <h3 class="font-bold text-lg mb-2">Submitted!</h3>
    <p>Your request has been submitted.</p>
    <div class="modal-action">
      <button onclick="submittedInfoModal.close()" class="btn btn-error text-white">OK</button>
    </div>
  </div>
</dialog>



<script>
  function showHistoryTab(tab) {
  // Get references to the history tabs and buttons
  const dentalTab = document.getElementById("dentalTab");
  const medicalTab = document.getElementById("medicalTab");

  const tabDental = document.getElementById("tabDental");
  const tabMedical = document.getElementById("tabMedical");

  // Reset the active classes for both tabs
  tabDental.classList.remove("text-primary", "border-b-2", "border-primary");
  tabMedical.classList.remove("text-primary", "border-b-2", "border-primary");

  tabDental.classList.add("text-gray-400");
  tabMedical.classList.add("text-gray-400");

  // Hide both tabs by default
  dentalTab.classList.add("hidden");
  medicalTab.classList.add("hidden");

  // Show the selected tab and update the active button styles
  if (tab === "dental") {
    dentalTab.classList.remove("hidden");
    tabDental.classList.add("text-primary", "border-b-2", "border-primary");
    tabMedical.classList.remove("text-primary", "border-b-2", "border-primary");
    tabMedical.classList.add("text-gray-400");
  } else {
    medicalTab.classList.remove("hidden");
    tabMedical.classList.add("text-primary", "border-b-2", "border-primary");
    tabDental.classList.remove("text-primary", "border-b-2", "border-primary");
    tabDental.classList.add("text-gray-400");
  }
}

// Clinic visit tab functions should remain separate from history
function showVisitTab(tab) {
  const futureVisitsTab = document.getElementById("futureVisitsTab");
  const pastVisitsTab = document.getElementById("pastVisitsTab");

  const futureVisitsBtn = document.getElementById("futureVisitsBtn");
  const pastVisitsBtn = document.getElementById("pastVisitsBtn");

  futureVisitsBtn.classList.remove("text-[#8B0000]", "border-b-2", "border-[#8B0000]");
  pastVisitsBtn.classList.remove("text-[#8B0000]", "border-b-2", "border-[#8B0000]");

  futureVisitsBtn.classList.add("text-gray-400");
  pastVisitsBtn.classList.add("text-gray-400");

  futureVisitsTab.classList.add("hidden");
  pastVisitsTab.classList.add("hidden");

  if (tab === "future") {
    futureVisitsTab.classList.remove("hidden");
    futureVisitsBtn.classList.add("text-[#8B0000]", "border-b-2", "border-[#8B0000]");
    pastVisitsBtn.classList.remove("text-[#8B0000]", "border-b-2", "border-[#8B0000]");
    pastVisitsBtn.classList.add("text-gray-400");
  } else {
    pastVisitsTab.classList.remove("hidden");
    pastVisitsBtn.classList.add("text-[#8B0000]", "border-b-2", "border-[#8B0000]");
    futureVisitsBtn.classList.remove("text-[#8B0000]", "border-b-2", "border-[#8B0000]");
    futureVisitsBtn.classList.add("text-gray-400");
  }
}
</script>

</body>
</html>
