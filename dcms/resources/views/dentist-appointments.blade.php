<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointments</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Inter Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
          colors: {
            primaryDark: "#7a0000",
            primaryMain: "#8b0000",
          }
        }
      }
    }
  </script>

  <!-- ✅ SCALE WHOLE UI -->
  <style>
    :root { --uiScale: 1.18; }
    .ui-scale{
      transform: scale(var(--uiScale));
      transform-origin: top center;
      width: calc(100% / var(--uiScale));
      margin: 0 auto;
    }
  </style>
</head>

<body class="bg-white font-sans">
  <div class="ui-scale">

    <!-- ================= TOP HEADER ================= -->
    <header class="bg-gradient-to-r from-primaryDark to-primaryMain text-white px-8 py-4 flex justify-between items-center">
      <div class="flex items-center gap-3 font-bold text-sm">
        <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" class="w-8 h-8 object-contain">
        <i class="fa-solid fa-tooth text-base"></i>
        <span class="tracking-wide">PUP TAGUIG DENTAL CLINIC</span>
      </div>

      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full w-8 h-8">
        <div class="text-xs leading-tight">
          <p class="font-semibold">Dr. Nelson Angeles</p>
          <p class="opacity-80">Dentist</p>
        </div>
      </div>
    </header>

    <!-- ================= NAV ================= -->
    <header class="bg-primaryMain text-white px-8 py-3">
      <nav class="flex justify-center gap-24 text-[11px]">
        <a href="{{ route('dentist.dashboard') }}" class="flex flex-col items-center opacity-70 hover:opacity-100">
          <i class="fa-solid fa-chart-line text-base mb-1"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center opacity-70 hover:opacity-100">
          <i class="fa-solid fa-users text-base mb-1"></i>
          <span>Patients</span>
        </a>

        <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center opacity-100">
          <i class="fa-solid fa-calendar-check text-base mb-1"></i>
          <span>Appointments</span>
        </a>

        <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center opacity-70 hover:opacity-100">
          <i class="fa-solid fa-box text-base mb-1"></i>
          <span>Inventory</span>
        </a>

        <a href="#" class="flex flex-col items-center opacity-70 hover:opacity-100">
          <i class="fa-solid fa-file text-base mb-1"></i>
          <span>Reports</span>
        </a>
      </nav>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="max-w-6xl mx-auto px-6">

      <!-- Toggle pill -->
      <div class="flex justify-center mt-12">
        <div class="w-[620px] h-12 bg-[#7a0000] rounded-full p-1 flex shadow-sm">
          <button id="btnUpcoming"
            class="flex-1 rounded-full bg-[#8b0000] text-white text-xs font-medium transition">
            Upcoming Appointments
          </button>
          <button id="btnPast"
            class="flex-1 rounded-full text-white/70 text-xs font-medium transition">
            Past Appointments
          </button>
        </div>
      </div>

      <!-- ========== UPCOMING SECTION ========== -->
      <section id="upcomingSection" class="mt-14 flex justify-center">
        <div class="w-[760px] flex gap-10">

          <!-- Timeline left -->
          <div class="relative w-[160px]">
            <div class="absolute left-[22px] top-1 w-4 h-4 bg-orange-400 rounded-full"></div>
            <div class="absolute left-[28px] top-5 w-[6px] h-[320px] bg-[#8b0000] rounded-full"></div>

            <div class="pl-14 pt-0">
              <p class="text-[20px] font-semibold text-[#8b0000]">January 29</p>
            </div>
          </div>

          <!-- Card -->
          <div class="flex-1">
            <div class="bg-[#f3f3f3] rounded-2xl border border-gray-200 shadow-md px-10 py-7">
              <div class="grid grid-cols-4 text-center text-[12px] font-semibold text-[#b46b6b]">
                <p>Date</p>
                <p>Service</p>
                <p>Name</p>
                <p>Program</p>
              </div>

              <div class="mt-4 grid grid-cols-4 text-center text-[11px] text-[#8b0000]">
                <div class="leading-tight">
                  <p>February 2,</p>
                  <p>2025</p>
                </div>
                <p>Dental Cleaning</p>
                <p>Alilah Gomez</p>
                <p>BSME</p>
              </div>

              <div class="mt-5 h-px w-full bg-gray-300/70"></div>

              <div class="mt-3 flex justify-end gap-2">
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-white bg-green-600">
                  Start Procedure
                </button>
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-[#5a3b00] bg-yellow-300">
                  RESCHEDULE
                </button>
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-white bg-red-600">
                  CANCEL
                </button>
              </div>
            </div>
          </div>

        </div>
      </section>

      <!-- ========== PAST SECTION ========== -->
      <section id="pastSection" class="mt-14 flex justify-center hidden">
        <div class="w-[760px] flex gap-10">

          <!-- Timeline left -->
          <div class="relative w-[160px]">
            <div class="absolute left-[22px] top-1 w-4 h-4 bg-orange-400 rounded-full"></div>
            <div class="absolute left-[28px] top-5 w-[6px] h-[320px] bg-[#8b0000] rounded-full"></div>

            <div class="pl-14 pt-0">
              <p class="text-[20px] font-semibold text-[#8b0000]">January 10</p>
            </div>
          </div>

          <!-- Card -->
          <div class="flex-1">
            <div class="bg-[#f3f3f3] rounded-2xl border border-gray-200 shadow-md px-10 py-7">
              <div class="grid grid-cols-4 text-center text-[12px] font-semibold text-[#b46b6b]">
                <p>Date</p>
                <p>Service</p>
                <p>Name</p>
                <p>Program</p>
              </div>

              <div class="mt-4 grid grid-cols-4 text-center text-[11px] text-[#8b0000]">
                <div class="leading-tight">
                  <p>January 10,</p>
                  <p>2025</p>
                </div>
                <p>Tooth Extraction</p>
                <p>Juan Dela Cruz</p>
                <p>BSIT</p>
              </div>

              <div class="mt-5 h-px w-full bg-gray-300/70"></div>

              <div class="mt-3 flex justify-end gap-2">
                <button class="h-5 px-3 rounded-[4px] text-[10px] font-semibold text-white bg-gray-500">
                  Done
                </button>
              </div>
            </div>
          </div>

        </div>
      </section>

      <div class="h-40"></div>
    </main>

  </div>

  <!-- ✅ TOGGLE SCRIPT -->
  <script>
    const btnUpcoming = document.getElementById("btnUpcoming");
    const btnPast = document.getElementById("btnPast");
    const upcomingSection = document.getElementById("upcomingSection");
    const pastSection = document.getElementById("pastSection");

    function setActiveTab(tab) {
      const isUpcoming = tab === "upcoming";

      // show/hide sections
      upcomingSection.classList.toggle("hidden", !isUpcoming);
      pastSection.classList.toggle("hidden", isUpcoming);

      // active styles (match your pill)
      btnUpcoming.classList.toggle("bg-[#8b0000]", isUpcoming);
      btnUpcoming.classList.toggle("text-white", isUpcoming);
      btnUpcoming.classList.toggle("text-white/70", !isUpcoming);

      btnPast.classList.toggle("bg-[#8b0000]", !isUpcoming);
      btnPast.classList.toggle("text-white", !isUpcoming);
      btnPast.classList.toggle("text-white/70", isUpcoming);
    }

    btnUpcoming.addEventListener("click", () => setActiveTab("upcoming"));
    btnPast.addEventListener("click", () => setActiveTab("past"));
  </script>
</body>
</html>
