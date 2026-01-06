<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUP Taguig Dental Clinic</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script type="module" src="https://unpkg.com/cally"></script>

  <script>
    tailwind.config = {
      daisyui: {
        themes: false,
      },
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
    }

    /* Fade-in animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }

    /* Subtle pulse for icon */
    @keyframes softPulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
    }

    .pulse-icon {
      animation: softPulse 2s ease-in-out infinite;
    }

    /* Skeleton shimmer */
    @keyframes shimmer {
      0% {
        background-position: -400px 0;
      }
      100% {
        background-position: 400px 0;
      }
    }

    .skeleton {
      background: linear-gradient(
        90deg,
        #e5e7eb 25%,
        #f3f4f6 37%,
        #e5e7eb 63%
      );
      background-size: 800px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 0.75rem;
    }

    /* Fade-up after skeleton loading */
    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.6s ease-out forwards;
  }
</style>

<body class="bg-white text-[#333333] font-normal">

          <!-- <form method="POST" action="{{ url('/homepage') }}"> -->


  <!-- HEADER (TOP BAR) -->
  <div class="bg-gradient-to-r from-red-900 to-red-700 text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-12 rounded-full ml-5">
          <img src="images/PUP.png" alt="PUP Logo" />
      </div>
      <div class="w-12 rounded-full">
          <img src="images/PUPT-DMS-Logo.png" alt="PUPT DMS Logo" />
      </div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
  </div>

  <div class="flex items-center gap-4">
      <div class="indicator">
        <span class="indicator-item badge badge-secondary text-s text-[#F4F4F4] bg-[#660000] border-none">12</span>
        <button class="btn btn-ghost btn-circle text-[#F4F4F4]">
          <img src="images/notifications.png" alt="Notification" />
        </button>
        </div>
        <div class="avatar">
        <div class="w-8 rounded-full bg-white"></div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="btn btn-ghost btn-circle text-[#F4F4F4]">
            <img src="images/Log-out.png" alt="Log Out" />
        </button>
        </form>
      </div>
  </div>

<!-- NAVIGATION (BELOW HEADER) -->
<div class="bg-red-800 text-[#F4F4F4] px-6">
  <div class="max-w-7xl mx-auto flex justify-center gap-8 py-3">
    
    <a href=""
    class="relative pb-1
              font-bold
              after:absolute after:left-0 after:bottom-0
              after:h-[2px] after:w-full
              after:bg-[#FFD700]
              after:opacity-0
              after:transition-opacity after:duration-300
              hover:after:opacity-100">
      Home
    </a>

<a href="{{ route('appointment') }}"
    class="relative pb-1
              after:absolute after:left-0 after:bottom-0
              after:h-[2px] after:w-full
              after:bg-[#FFD700]
              after:opacity-0
              after:transition-opacity after:duration-300
              hover:after:opacity-100">
      Appointment
    </a>

  <a href="{{ route('record') }}"
    class="relative pb-1
              after:absolute after:left-0 after:bottom-0
              after:h-[2px] after:w-full
              after:bg-[#FFD700]
              after:opacity-0
              after:transition-opacity after:duration-300
              hover:after:opacity-100">
      Record
    </a>

    <a href="{{ route('about.us') }}"
    class="relative pb-1
              after:absolute after:left-0 after:bottom-0
              after:h-[2px] after:w-full
              after:bg-[#FFD700]
              after:opacity-0
              after:transition-opacity after:duration-300
              hover:after:opacity-100">
      About Us
    </a>
    
  </div>
</div>

  <!-- CONTENT -->
  <div class="max-w-7xl mx-auto px-6 py-10">

    <!-- WELCOME -->
        <h1 class="text-4xl font-extrabold mb-6 bg-gradient-to-r
    from-[#660000] to-[#FFD700] bg-clip-text text-transparent inline-block">
      Welcome, {{ ucwords(strtolower($patient->name)) }}
    </h1>


    <!-- HERO CARD -->
    <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] text-[#F4F4F4] rounded-2xl p-10 flex justify-between items-center mb-20">
      <div>
        <h2 class="text-4xl font-semibold mb-10 text-[#F4F4F4]">Book a dental appointment at your convenience</h2>
        <button
        class="btn btn-soft bg-[#660000] hover:bg-[#333333]
              transition-colors duration-300
              border-none text-base rounded-2xl text-[#F4F4F4]">
              <a href="{{ route('book.appointment') }}">
        Book Appointment
        </a>
      </button>

      </div>
      <div class="w-1/5">
        <img src="images/home-tooth.png" alt="Tooth Icon" />
      </div>
    </div>

    <!-- PROFILE + CALENDAR SECTION -->
    <section class="max-w-7xl mx-auto px-2 mb-10">
      <div class="flex flex-col md:flex-row gap-8">

      <!-- PROFILE CARD -->
      <div id="profileSkeletonContainer" class="bg-gradient-to-t from-[#FFD700] to-[#660000] p-0.5 rounded-2xl md:w-1/3">
        <div id="profileInnerContainer" class="bg-[#F4F4F4] rounded-2xl p-5 text-center">
          <div class="avatar mb-2 flex justify-center">
            <div class="w-[210px] rounded-full">
              <img src="images/hsh.jpg" alt="Profile Image" />
            </div>
          </div>

          <h3 class="font-bold text-2xl">Grace Anne Lim</h3>
          <p class="text-sm italic mb-8">Patient</p>

          <p class="text-[#8B0000] text-lg font-bold mt-4">2023-00112-TG-0</p>
          <p class="text-sm font-bold mt-2">09162903429</p>
          <p class="text-sm mt-2">limgraceanne@gmail.com</p>
        </div>
      </div>

        <!-- Calendar Section -->
        <div id="calendarSkeletonContainer" class="flex flex-col gap-2 md:w-2/3">
          <!-- Title outside the card -->
          <h2 class="text-2xl font-extrabold text-[#8B0000]">Upcoming Schedule</h2>

          <!-- Calendar Card -->
          <div class="bg-white border shadow rounded-2xl p-6 h-[390px] w-full">
            <calendar-date class="cally w-full h-full flex flex-col p-2 ">
              <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
                <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
              </svg>

              <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
                <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
              </svg>

              <calendar-month class="w-full flex-1"></calendar-month>
            </calendar-date>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================= -->
    <!-- DENTAL RECORDS SECTION -->
    <!-- ========================= -->
    <h2 class="text-2xl font-extrabold text-[#8B0000] mb-4">
      My Dental Records
    </h2>

    <div id="recordsContainer" class="bg-gradient-to-l from-[#FFD700] to-[#660000] p-0.5 rounded-2xl mb-10">
      <div class="bg-white rounded-2xl p-6 space-y-4">

        <!-- Records will be injected here -->
        <div id="recordsInnerContainer" class="space-y-4"></div>

        <!-- View All -->
        <div id="viewAllContainer" class="text-center pt-2">
        <button class="btn btn-soft bg-[#8B0000] hover:bg-[#333333]
          transition-colors duration-300
          border-none text-sm rounded-2xl text-[#F4F4F4]">
          <a href="records.html">View Full Record </a>
        </button>
      </div>
    </div>
  </div>

    <!-- REQUEST DOCUMENTS -->
    <h2 class="text-3xl font-extrabold text-[#8B0000] mb-6">Request Documents</h2>

    <div id="requestDocsContainer" class="space-y-4">
      <a href="#"
      class="flex border rounded-2xl overflow-hidden
            hover:border-red-800 hover:shadow-lg
            transition cursor-pointer">

    <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
      <img src="images/dental-clearance.png"/>
    </div>

    <div class="p-4">
      <p class="font-extrabold text-xl text-[#8B0000] pb-2">
        Request Dental Clearance
      </p>
      <p class="text-sm text-gray-600">
        Dental Clearance • Annual Dental Clearance
      </p>
    </div>
  </a>

  <a href="#" class="flex border rounded-2xl overflow-hidden
          hover:border-red-800 hover:shadow-lg
          transition cursor-pointer">
          
          <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
            <img src="images/dental-health-record.png"/> </div>
            
            <div class="p-4">
              <p class="font-extrabold text-xl text-[#8B0000] pb-2">
                Request Dental Health Record </p>
                
                <p class="text-sm text-gray-600">
                  All Dental Records • Medical Record • Diagnosis & Treatments
                </p>
              </div>
    </a>
          </div>
        </div>

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

  <!-- ========================= -->
  <!-- FETCH DENTAL RECORDS -->
  <!-- ========================= -->

<script>
  document.addEventListener("DOMContentLoaded", () => {

    // Show all skeletons first
    showSkeletons();

    // Simulate fetching data after 2 seconds
    setTimeout(() => {
      // Profile
      document.getElementById("profileInnerContainer").innerHTML = `
        <div class="bg-[#F4F4F4] rounded-2xl p-5 text-center fade-up">
          <div class="avatar mb-2 flex justify-center">
            <div class="w-[210px] rounded-full">
              <img src="images/hsh.jpg" alt="Profile Image" />
            </div>
          </div>
          <h3 class="font-bold text-2xl">Grace Anne Lim</h3>
          <p class="text-sm italic mb-8">Patient</p>
          <p class="text-[#8B0000] text-lg font-bold mt-4">2023-00112-TG-0</p>
          <p class="text-sm font-bold mt-2">09162903429</p>
          <p class="text-sm mt-2">limgraceanne@gmail.com</p>
        </div>
      `;

      // Calendar
      document.getElementById("calendarSkeletonContainer").innerHTML = `
        <div class="bg-white border shadow rounded-2xl p-6 h-[390px] w-full fade-up">
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
      `;

      // Dental Records
      fetch("get_records.php")
        .then(res => res.json())
        .then(records => renderRecords(records))
        .catch(() => showRecordsError());

      // Request Documents
      document.getElementById("requestDocsContainer").innerHTML = `
        <a href="#" class="flex border rounded-2xl overflow-hidden hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
          <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
            <img src="images/dental-clearance.png"/>
          </div>
          <div class="p-4">
            <p class="font-extrabold text-xl text-[#8B0000] pb-2">Request Dental Clearance</p>
            <p class="text-sm text-gray-600">Dental Clearance • Annual Dental Clearance</p>
          </div>
        </a>
        <a href="#" class="flex border rounded-2xl overflow-hidden hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
          <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
            <img src="images/dental-health-record.png"/>
          </div>
          <div class="p-4">
            <p class="font-extrabold text-xl text-[#8B0000] pb-2">Request Dental Health Record</p>
            <p class="text-sm text-gray-600">All Dental Records • Medical Record • Diagnosis & Treatments</p>
          </div>
        </a>
      `;
    }, 2000);

  });

  // =========================
  // Functions
  // =========================
  function showSkeletons() {
    // Hide the "View Full Record" button while loading
    const viewAll = document.getElementById("viewAllContainer");
    if (viewAll) viewAll.style.display = "none";

    // Profile Skeleton
    document.getElementById("profileInnerContainer").innerHTML = `
      <div class="animate-pulse bg-[#F4F4F4] rounded-2xl p-5 text-center">
        <div class="w-[210px] h-[210px] rounded-full mx-auto skeleton mb-4"></div>
        <div class="h-6 w-32 mx-auto skeleton mb-2"></div>
        <div class="h-4 w-20 mx-auto skeleton mb-2"></div>
        <div class="h-5 w-24 mx-auto skeleton"></div>
      </div>
    `;

    // Calendar Skeleton
    document.getElementById("calendarSkeletonContainer").innerHTML = `
      <div class="bg-white border shadow rounded-2xl p-6 h-[390px] w-full animate-pulse">
        <div class="h-6 w-24 skeleton mb-4"></div>
        <div class="grid grid-cols-7 gap-2">
          ${Array(35).fill('<div class="h-8 w-8 skeleton"></div>').join('')}
        </div>
      </div>
    `;

    // Dental Records Skeleton
    document.getElementById("recordsInnerContainer").innerHTML = `
      <div class="space-y-4 animate-pulse">
        ${[1,2,3].map(() => `
          <div class="bg-white rounded-2xl p-5 space-y-3 shadow-sm">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 skeleton"></div>
              <div class="flex-1 space-y-2">
                <div class="h-4 w-1/2 skeleton"></div>
                <div class="h-3 w-1/3 skeleton"></div>
              </div>
            </div>
            <div class="h-3 w-full skeleton"></div>
            <div class="h-3 w-5/6 skeleton"></div>
          </div>
        `).join("")}
      </div>
    `;

    // Request Documents Skeleton
    document.getElementById("requestDocsContainer").innerHTML = `
      ${[1,2].map(() => `
        <div class="flex border rounded-2xl overflow-hidden animate-pulse">
          <div class="w-24 p-4 skeleton"></div>
          <div class="p-4 flex-1 space-y-2">
            <div class="h-6 w-32 skeleton"></div>
            <div class="h-4 w-1/2 skeleton"></div>
          </div>
        </div>
      `).join("")}
    `;
  }

  // Dental Records Rendering
  function renderRecords(records) {
    const container = document.getElementById("recordsInnerContainer");
    const viewAll = document.getElementById("viewAllContainer");
    viewAll.style.display = records && records.length ? "block" : "none";

    if (!records || records.length === 0) {
      container.innerHTML = `
        <div class="flex flex-col items-center justify-center py-14 text-center space-y-5 fade-in">
          <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-r from-[#FFD700] to-[#8B0000] pulse-icon">
            <img src="images/nodental-record.png" class="w-10 h-10">
          </div>
          <p class="text-2xl font-extrabold text-[#8B0000]">Nothing here yet…</p>
          <p class="text-sm text-gray-600 max-w-sm">Time to book that first visit.</p>
          <a href="{{ route('book.appointment') }}" class="btn btn-soft bg-[#8B0000] hover:bg-[#333333] border-none text-sm rounded-2xl text-[#F4F4F4] px-6">
            Book Appointment
          </a>
        </div>
      `;
      // hide button if no records
      viewAll.style.display = "none";
      return;
    }

    container.innerHTML = "";
    records.forEach(record => {
      container.innerHTML += `
        <div class="flex justify-between items-center border rounded-xl p-4 fade-up">
          <div>
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-[#FFD700] to-[#8B0000]"></span>
              <p class="font-semibold">${record.procedure_name}</p>
            </div>
            <p class="text-sm">Last Visit: ${formatDate(record.visit_date)}</p>
          </div>
          <div class="text-right">
            <p class="text-sm mb-2">${formatTime(record.time_start)} - ${formatTime(record.time_end)}</p>
            <button onclick="viewRecord(${record.record_id})" class="btn btn-soft bg-[#8B0000] hover:bg-[#333333] border-none text-sm rounded-2xl text-[#F4F4F4]">
              View Details
            </button>
          </div>
        </div>
      `;
    });

    // show "View Full Record" button with fade-up animation
    viewAll.style.display = "block";
    viewAll.classList.add("fade-up");
  }

  function showRecordsError() {
    const container = document.getElementById("recordsInnerContainer");
    document.getElementById("viewAllContainer").style.display = "none";
    container.innerHTML = `
      <div class="flex flex-col items-center justify-center py-14 text-center space-y-5 fade-in">
        <img src="images/error-records.png" alt="Error" class="w-24 h-24">
        <p class="text-2xl font-extrabold text-[#8B0000]">Oops! Something went wrong</p>
        <p class="text-sm text-gray-600 max-w-sm">Unable to fetch your records.</p>
      </div>
    `;
  }

  // Helpers
  function viewRecord(id) { window.location.href = `record-details.php?id=${id}`; }
  function formatDate(dateStr) { return new Date(dateStr).toLocaleDateString(); }
  function formatTime(timeStr) { return timeStr.substring(0,5); }
</script>

</body>
</html>