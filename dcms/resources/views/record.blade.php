<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUP Taguig Dental Clinic | Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter';
        }

         /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity:0; transform:translateY(6px); }
            to { opacity:1; transform:translateY(0); } 
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Subtle pulse for icon */
        @keyframes softPulse {
            0%,100%{transform:scale(1);}
            50%{transform:scale(1.05);}
        
        }
        .pulse-icon {
            animation: softPulse 2s ease-in-out infinite;
        }

        /* Skeleton shimmer */
        @keyframes shimmer {
            0% {background-position:-400px 0;}
            100% {background-position:400px 0;}
        }

        .skeleton {
            background: linear-gradient(90deg,#e5e7eb 25%,#f3f4f6 37%,#e5e7eb 63%);
            background-size: 800px 100%;
            animation: shimmer 1.4s infinite linear;
            border-radius:0.75rem;
        }

        @keyframes fadeUp {
            0% { opacity:0; transform:translateY(10px); }
            100% { opacity:1; transform:translateY(0); }
        }

        .fade-up {
            animation: fadeUp 0.6s ease-out forwards;
        }

        /* Modal styles */
        .modal-bg {
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: rgba(0,0,0,0.5);
            display:none;
            justify-content:center;
            align-items:center;
            z-index:50;
        }

        .modal-content {
            background:white;
            padding:2rem;
            border-radius:1rem;
            max-width:600px;
            width:90%;
            max-height:80vh;
            overflow-y:auto;
        }

    </style>
</head>
<body class="bg-white text-[#333333] font-normal">

<!-- HEADER (TOP BAR) -->
  <div class="bg-gradient-to-r from-[#660000] to-[#8B0000] text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-12 rounded-full ml-5">
          <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" />
      </div>
      <div class="w-12 rounded-full">
          <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
      </div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
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

      <img src="{{ asset('images/notifications.png') }}" alt="Notification" class="w-7 h-7" />
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
              <div class="text-xs text-gray-600 mt-0.5">
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
            <img src="images/no-notifications.png" alt="No Notification">
            <div class="text-sm font-semibold text-gray-800">No notifications</div>
            <div class="text-xs text-gray-500 mt-1">You’re all caught up.</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
        <div class="flex items-center gap-3">
        {{-- Avatar --}}
        <div class="avatar">
          <div class="w-10 rounded-full overflow-hidden">
            <img
              src="{{ $patient->profile_image
                    ? asset('storage/'.$patient->profile_image)
                    : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=128' }}"
              alt="Profile"
            />
          </div>
        </div>

        {{-- Name + Role --}}
        <div class="leading-tight">
          <div class="text-l font-semibold text-[#F4F4F4]">
            {{ ucwords(strtolower($patient->name)) }}
          </div>
          <div class="italic text-xs text-[#F4F4F4]/80">
            Patient
          </div>
        </div>
      </div>
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="btn btn-ghost btn-circle text-[#F4F4F4]">
            <img src="{{ asset('images/Log-out.png') }}" alt="Log Out" />
        </button>
        </form>
      </div>
  </div>

<!-- NAVIGATION (BELOW HEADER) -->
<div class="bg-[#8B0000] text-[#F4F4F4] px-6">
  <div class="max-w-7xl mx-auto flex justify-center gap-12 py-3">
    
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
    <a href="{{ route('appointment.index') }}"
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
                font-bold
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

    <!-- TITLE -->
    <h2 class="text-3xl font-extrabold flex justify-center mt-2 mb-10 
           bg-gradient-to-r from-[#660000] to-[#FFD700] 
           bg-clip-text text-transparent fade-up">
            My Dental Records
    </h2>

    <!-- RECORDS CONTAINER -->
    <div id="recordsContainer" class="bg-gradient-to-l from-[#FFD700] to-[#660000] p-0.5 rounded-2xl mb-10 fade-up">
      <div class="bg-white rounded-2xl p-6 space-y-4">
        <div id="recordsInnerContainer" class="space-y-4"></div>
      </div>
    </div>

  </div>

  <!-- FOOTER -->
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
      <img src="images/footer-location.png" class="w-4 h-5 mt-0.5" />
      <p>Gen. Santos Ave., Upper Bicutan, Taguig City</p>
    </div>

    <!-- Email -->
    <div class="flex items-center gap-3 text-sm">
      <img src="images/footer-email.png" class="w-5 h-4" />
      <p>pupdental@pup.edu.ph</p>
    </div>

    <!-- Phone -->
    <div class="flex items-center gap-3 text-sm">
      <img src="images/footer-phone.png" class="w-4 h-4" />
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
    showSkeletons(); // Show skeletons

    setTimeout(() => {
      fetch("get_records.php")
        .then(res => res.json())
        .then(records => renderRecords(records))
        .catch(() => showRecordsError());
    }, 1500);
  });

  function showSkeletons() {
    document.getElementById("recordsInnerContainer").innerHTML = `
      <div class="space-y-4 animate-pulse">
        ${[1,2,3,4,5,6].map(() => `
          <div class="flex justify-between items-center border rounded-xl p-4">
            <div class="flex-1 space-y-2">
              <div class="h-4 w-1/2 skeleton"></div>
              <div class="h-3 w-1/3 skeleton"></div>
            </div>
            <div class="w-24 h-8 skeleton"></div>
          </div>
        `).join('')}
      </div>
    `;
  }

  function renderRecords(records) {
    const container = document.getElementById("recordsInnerContainer");
    if (!records || records.length === 0) return showRecordsError();

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
            <button onclick="viewRecordDetails(${record.record_id})" class="btn btn-soft bg-[#8B0000] hover:bg-[#333333] border-none text-sm rounded-2xl text-[#F4F4F4]">
              View Details
            </button>
          </div>
        </div>
      `;
    });
  }

  function showRecordsError() {
    document.getElementById("recordsInnerContainer").innerHTML = `
      <div class="flex flex-col items-center justify-center py-14 text-center space-y-5 fade-in">
        <img src="images/error-records.png" alt="Error" class="w-24 h-24">
        <p class="text-2xl font-extrabold text-[#8B0000]">Oops! Something went wrong</p>
        <p class="text-sm text-gray-600 max-w-sm">Unable to fetch your records.</p>
      </div>
    `;
  }

  // Helpers
  function formatDate(dateStr) { return new Date(dateStr).toLocaleDateString(); }
  function formatTime(timeStr) { return timeStr.substring(0,5); }

  // Modal logic
  function viewRecordDetails(id) {
    fetch(`get_records.php?id=${id}`)
      .then(res => res.json())
      .then(record => {
        const modal = document.getElementById("recordModal");
        const content = document.getElementById("modalContent");
        content.innerHTML = `
          <h3 class="text-xl font-bold mb-4">${record.procedure_name}</h3>
          <p><strong>Date:</strong> ${formatDate(record.visit_date)}</p>
          <p><strong>Time:</strong> ${formatTime(record.time_start)} - ${formatTime(record.time_end)}</p>
          <p><strong>Details:</strong> ${record.details || "No additional details."}</p>
        `;
        modal.style.display = "flex";
      })
      .catch(() => alert("Failed to load record details"));
  }

  function closeModal() {
    document.getElementById("recordModal").style.display = "none";
  }
</script>

</body>
</html>