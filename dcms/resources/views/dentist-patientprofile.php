<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dentist – Patient Profile</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  
  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
<header class="bg-[#8B0000] h-16">
</header>

<!-- ================= MAIN ================= -->
<main class="max-w-6xl mx-auto px-10 py-8 space-y-10">

<!-- Page Title with Back Arrow -->
<div class="flex items-center gap-4 mb-6">
  <!-- Back Arrow Button -->
<a href="/dentist/patients" class="w-10 h-10 flex items-center justify-center rounded-full border border-orange-400 text-orange-500 hover:bg-orange-100 transition">
    <i class="fa-solid fa-arrow-left"></i>
</a>




  <!-- Page Title -->
  <h1 class="text-2xl font-medium text-primary ml-4">  <!-- Added ml-4 to provide a little margin between the arrow and the title -->
    Patient Profile
  </h1>
</div>


<!-- ================= PATIENT PROFILE ================= -->
<section>
  <div class="bg-gradient-to-r from-[#8B0000] to-[#5e0000]
              rounded-2xl text-white
              px-14 py-10 shadow-xl">

    <div class="flex items-center gap-2">

      <!-- Avatar -->
      <img src="https://i.pravatar.cc/180"
           class="w-36 h-36 rounded-full object-cover border-4 border-[#7a0000] mt-3" />

      <!-- LEFT INFO -->
      <div class="shrink-0 w-[400px] mt-2 pl-4">
        <p class="text-3xl font-bold leading-tight mt-1">
          Capilitan, Beyonce
        </p>

        <p class="text-base font-semibold mt-2">
          2023-00099-TG-0
        </p>

        <p class="text-base font-semibold mt-0.5 leading-tight">
          BSIT 3-1
        </p>
      </div>

      <!-- RIGHT INFO -->
      <div class="grid grid-cols-[auto,1fr] gap-x-3 gap-y-2 text-sm mt-14">
        <span class="font-semibold">Age:</span>
        <span class="font-semibold">18</span>

        <span class="font-semibold">Birthdate:</span>
        <span class="font-semibold">January 01, 2004</span>

        <span class="font-semibold">Sex:</span>
        <span class="font-semibold">Female</span>
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
        Past Visits (1)
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

        <!-- Button to trigger the modal (only in future visits) -->
        <div class="absolute bottom-2 right-5 z-50">
          <button
            id="startButton"
            class="bg-green-600 text-white text-xs px-4 py-1.5 rounded-md hover:bg-green-700 transition"
            onclick="showModal()">
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

<!-- Modal Structure -->
<div id="modal" class="fixed inset-0 flex items-center justify-center hidden z-40">
  <div class="bg-white p-8 rounded-lg shadow-lg border border-[#8B0000] w-[500px] h-[300px] flex flex-col">
    
    <!-- Modal Content -->
    <div class="flex flex-col justify-center items-center flex-1 pr-6"> <!-- Centered content -->
      <!-- Header with Title -->
      <div class="mb-4 text-left">  <!-- Left aligned text -->
        <h3 class="text-lg font-semibold">Confirm the start of procedure?</h3>
      </div>

      <!-- Patient Input -->
      <div class="mt-8 flex items-center w-full justify-center">  <!-- Left-aligned input -->
        <label class="block text-lg text-[#8B0000] mr-2">Patient:</label>
        <span class="w-[80%] p-2 border-2 border-[#8B0000] bg-[#8B0000] text-white rounded-md">Capilitan, Beyonce</span>
      </div>
    </div>

    <!-- Buttons: Start and Back -->
    <div class="flex gap-2 mt-auto justify-center"> <!-- Centered the buttons -->
      <button id="startButtonModal" class="bg-green-600 text-white px-4 py-1 rounded-md hover:bg-green-700 text-sm">
        START
      </button>
      <button id="backButton" class="bg-gray-300 text-gray-700 px-4 py-1 rounded-md hover:bg-gray-400 text-sm">
        BACK
      </button>
    </div>
  </div>
</div>
</main>

<script>
  // Show the modal when the "Start Procedure" button is clicked
  function showModal() {
    const modal = document.getElementById("modal");
    modal.classList.remove("hidden");  // Show the modal
  }

  // Close the modal when the "Back" button is clicked
  document.getElementById("backButton").addEventListener("click", function() {
    const modal = document.getElementById("modal");
    modal.classList.add("hidden");  // Hide the modal
  });
  
  function showHistoryTab(tab) {
  // Get references to the history tabs and buttons
  const modal = document.getElementById('modal');
  const startButton = document.getElementById('startButton');
  const closeButton = document.getElementById('closeButton');
  const backButton = document.getElementById('backButton');
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

  // Reset the active styles for the buttons
  futureVisitsBtn.classList.remove("text-[#8B0000]", "border-b-2", "border-[#8B0000]");
  pastVisitsBtn.classList.remove("text-[#8B0000]", "border-b-2", "border-[#8B0000]");

  // Set the default styles (inactive buttons)
  futureVisitsBtn.classList.add("text-gray-400");
  pastVisitsBtn.classList.add("text-gray-400");

  // Hide both tabs by default
  futureVisitsTab.classList.add("hidden");
  pastVisitsTab.classList.add("hidden");

  // Show the selected tab and highlight the active button
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

        // Show the modal when the "Start Procedure" button is clicked
        startButton.addEventListener('click', () => {
            modal.classList.remove('hidden');  // Show the modal
        });

        // Close the modal when the "Back" button is clicked
        backButton.addEventListener('click', () => {
            modal.classList.add('hidden');  // Hide the modal
        });

        // Close the modal when the "X" button is clicked
        closeButton.addEventListener('click', () => {
            modal.classList.add('hidden');  // Hide the modal
        });
        </script>

</body>
</html>
