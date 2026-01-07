<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + daisyUI CDN -->
    <script type="module" src="https://unpkg.com/cally"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css"
        rel="stylesheet"
        type="text/css"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
        theme: {
            extend: {
            colors: {
                pupred: "#660000",
                pupgold: "#FFD700",
            },
            },
        },
        };
    </script>

  <style>
      body {
      font-family: 'Inter';
    }
      /* Smooth underline animation */
      .tabs-bordered .tab {
        transition: color 0.5s ease, font-weight 0.5s ease;
      }

      .tabs-bordered .tab::after {
        transition: width 0.5s ease, left 0.5s ease;
      }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

<!-- ================= HEADER ================= -->
<div class="bg-gradient-to-r from-red-900 to-red-700 text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
  <div class="flex items-center gap-3">
    <div class="w-12 rounded-full ml-5">
      <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" />
    </div>
    <div class="w-12 rounded-full">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
    </div>
    <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
  </div>

  <div class="flex items-center gap-4">
    <div class="indicator">
      <span class="indicator-item badge bg-pupred text-[#F4F4F4] border-none">12</span>
      <button class="btn btn-ghost btn-circle text-[#F4F4F4]">
        <img src="{{ asset('images/notifications.png') }}" alt="Notification" />
      </button>
    </div>
    <div class="avatar">
      <div class="w-8 rounded-full bg-[#F4F4F4]"></div>
    </div>
    <button class="btn btn-ghost btn-circle text-[#F4F4F4]">
      <img src="{{ asset('images/Log-out.png') }}" alt="Log Out" />
    </button>
  </div>
</div>

<!-- NAVIGATION (BELOW HEADER) -->
<div class="bg-red-800 text-[#F4F4F4] px-6">
  <div class="max-w-7xl mx-auto flex justify-center gap-8 py-3">
    
    <a href="{{ route('homepage') }}"
    class="relative pb-1
            after:absolute after:left-0 after:bottom-0
            after:h-[2px] after:w-full
            after:bg-[#FFD700]
            after:opacity-0
            after:transition-opacity after:duration-300
            hover:after:opacity-100">
      Home
    </a>

    <a href="appointment.html"
    class="relative pb-1
            font-bold
            after:absolute after:left-0 after:bottom-0
            after:h-[2px] after:w-full
            after:bg-[#FFD700]
            after:opacity-0
            after:transition-opacity after:duration-300
            hover:after:opacity-100">
      Appointment
    </a>

    <a href=""
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

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-7xl mx-auto px-6 py-10 space-y-16">

  <!-- ===== Dental Clinic Schedule ===== -->
  <!-- ===== CALENDAR ===== -->
<section class="flex justify-center">
  <div class="w-full max-w-3xl flex flex-col items-center gap-3">

    <h1 class="text-3xl font-bold text-pupred w-full text-left">
      Dental Clinic Schedule
    </h1>

    <div class="bg-[#F4F4F4] border shadow rounded-2xl p-6 h-[390px] w-full">
      <!-- Appointment date from DB -->
      <calendar-date
        class="cally w-full h-full flex flex-col p-2"
        data-selected-date="2025-12-29"
      >
        <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
          <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
        </svg>

        <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
          <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>

        <calendar-month class="w-full flex-1"></calendar-month>
      </calendar-date>
    </div>

    <!-- Legend -->
    <div class="flex gap-6 mt-4 text-sm">
      <div class="flex items-center gap-2">
        <span class="w-4 h-4 bg-red-500 rounded"></span> Full Schedule
      </div>
      <div class="flex items-center gap-2">
        <span class="w-4 h-4 bg-orange-400 rounded"></span> Not Available
      </div>
      <div class="flex items-center gap-2">
        <span class="w-4 h-4 bg-blue-500 rounded"></span> Holiday
      </div>
    </div>

  </div>
</section>


  <!-- ===== My Appointments ===== -->
  <section class="max-w-5xl mx-auto">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold text-pupred">My Appointments</h2>
    <button class="btn bg-red-400 hover:bg-red-500 text-[#F4F4F4]">
      <a href="{{ route('book.appointment') }}">+ Book Appointment</a>
    </button>
  </div>

  <div class="card bg-red-50 shadow-sm">
    <div class="card-body">

      <!-- Tabs -->
    <div class="tabs tabs-bordered mb-6">
      <a id="futureTab"
        class="tab tab-active font-bold text-pupred cursor-pointer"
        onclick="showFuture()">
        Future Visits
      </a>

      <a id="pastTab"
        class="tab cursor-pointer"
        onclick="showPast()">
        Past Visits
      </a>
    </div>

      <!-- ================= FUTURE VISITS ================= -->

      <!-- IF future_visits.count == 0 -->
    <div id="futureContent" class="text-center py-10 text-gray-500">
      <p class="text-lg font-semibold">No Upcoming Visits</p>
      <p class="text-sm">You currently have no scheduled appointments.</p>
    </div>

      <!-- ================= PAST VISITS ================= -->
      <!-- Show only when Past Visits tab is active -->

      <!-- IF past_visits.count == 0 -->
    <div id="pastContent" class="text-center py-10 text-gray-500 hidden">
      <p class="text-lg font-semibold">No Past Visits Yet</p>
      <p class="text-sm">Your completed appointments will appear here.</p>
    </div>
    </div>
  </div>
</section>


<!-- ===== Services Offered ===== -->
<section class="max-w-6xl mx-auto mt-16">
    <h2 class="text-3xl font-bold text-pupred mb-6">
    Services Offered
    </h2>

    <!-- Container -->
    <div
        class="grid md:grid-cols-2 rounded-2xl overflow-hidden bg-[#8B0000]">

        <!-- Oral Check-Up -->
        <div
          class="relative p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">Oral Check-Up</h3>
          <p class="text-sm  max-w-xs">
              Routine oral examination • Dental consultation
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/oral-checkup.png') }}" class="absolute right-1 top-1/2 -translate-y-1/2 w-28"
              alt="Oral Checkup" />
        </div>

        <!-- Dental Cleaning -->
        <div class="relative p-10 text-[#F4F4F4] border-b border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">Dental Cleaning</h3>
          <p class="text-sm  max-w-xs">
              Oral hygiene treatment • Removing surface buildup
          </p>

          <!-- Icon -->
            <img src="{{ asset('images/dental-cleaning.png') }}" class="absolute right-1 top-1/2 -translate-y-1/2 w-28"
              alt="Dental Cleaning" />
        </div>

        <!-- Dental Restoration -->
        <div class="relative p-10 text-[#F4F4F4] border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">
              Dental Restoration & Prosthesis
          </h3>
          <p class="text-sm  max-w-xs">
              Repairs/replaces damaged teeth • Fillings • Crowns • Inlay • etc.
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/restoration-prosthesis.png') }}" class="absolute right-1 top-1/2 -translate-y-1/2 w-28"
              alt="Restoration & Prosthesis" />
        </div>

        <!-- Dental Surgery -->
        <div class="relative p-10 text-[#F4F4F4] border-r border-[#F4F4F4]/60">
          <h3 class="text-2xl font-bold mb-2">Dental Surgery</h3>
          <p class="text-sm  max-w-xs">
              Treating dental issues surgically • Extraction • Supernumerary • etc.
          </p>

          <!-- Icon -->
          <img src="{{ asset('images/dental-surgery.png') }}" class="absolute right-1 top-1/2 -translate-y-1/2 w-28"
              alt="Dental Surgery" />
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

<script>
  function showFuture() {
    document.getElementById("futureTab").classList.add("tab-active", "font-bold", "text-pupred");
    document.getElementById("pastTab").classList.remove("tab-active", "font-bold", "text-pupred");

    document.getElementById("futureContent").classList.remove("hidden");
    document.getElementById("pastContent").classList.add("hidden");
  }

  function showPast() {
    document.getElementById("pastTab").classList.add("tab-active", "font-bold", "text-pupred");
    document.getElementById("futureTab").classList.remove("tab-active", "font-bold", "text-pupred");

    document.getElementById("pastContent").classList.remove("hidden");
    document.getElementById("futureContent").classList.add("hidden");
  }
</script>

</body>
</html>
