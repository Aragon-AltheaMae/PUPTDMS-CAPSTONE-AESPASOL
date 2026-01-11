<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
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

  @keyframes float {
  0%, 100% {
    transform: translateY(0) rotate(0deg);
  }
  50% {
    transform: translateY(-14px) rotate(2deg);
  }
}

.float-slow {
  animation: float 4.5s ease-in-out infinite;
  will-change: transform;
}

  /* Shimmer effect */
@keyframes shimmer {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}

  .shimmer-btn {
    background: linear-gradient(
      110deg,
      #660000 25%,
      rgba(255, 80, 80, 0.87) 37%,
      #660000 63%
    );
    background-size: 200% 100%;
    animation: shimmer 10s linear infinite;
  }

  @keyframes wave {
  0% { transform: rotate(0deg); }
  20% { transform: rotate(14deg); }
  40% { transform: rotate(-8deg); }
  60% { transform: rotate(14deg); }
  80% { transform: rotate(-4deg); }
  100% { transform: rotate(0deg); }
}

.wave-hand {
  transform-origin: 70% 70%;
  animation: wave 2.5s ease-in-out infinite;
}
</style>

<body class="bg-white text-[#333333] font-normal">

<!-- <form method="POST" action="{{ url('/homepage') }}"> -->

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
      
      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="cursor-pointer text-[#F4F4F4] hover:text-[#660000]">
            <i class="fa-solid fa-right-from-bracket text-lg"></i>
        </button>
      </form>
      
      </div>
  </div>

<!-- NAVIGATION (BELOW HEADER) -->
<div class="bg-[#8B0000] text-[#F4F4F4] px-6">
  <div class="max-w-7xl mx-auto flex justify-center gap-14 py-3 text-sm">

    <!-- Home -->
    <a href="{{ route('homepage') }}"
      class="group flex flex-col items-center gap-1 px-4 py-2 rounded-lg
             transition-all duration-500 ease-out
             hover:scale-[1.08]
             hover:bg-gradient-to-br hover:from-[#8B0000] hover:to-[#660000]
             hover:shadow-[0_0_8px_rgba(255,60,60,0.9),_0_0_18px_rgba(139,0,0,0.85)]
             text-[#F4F4F4]">
      <i class="fa-solid fa-house text-xl"></i>
      <span class="font-bold">Home</span>
    </a>

    <!-- Appointment -->
    <a href="{{ route('appointment.index') }}"
      class="group flex flex-col items-center gap-1 px-4 py-2 rounded-lg
             transition-all duration-500 ease-out
             hover:scale-[1.08]
             hover:bg-gradient-to-br hover:from-[#8B0000] hover:to-[#660000]
             hover:shadow-[0_0_8px_rgba(255,60,60,0.9),_0_0_18px_rgba(139,0,0,0.85)]
             text-[#F4F4F4]">
      <i class="fa-solid fa-calendar-check text-xl"></i>
      <span>Appointment</span>
    </a>

    <!-- Record -->
    <a href="{{ route('record') }}"
      class="group flex flex-col items-center gap-1 px-4 py-2 rounded-lg
             transition-all duration-500 ease-out
             hover:scale-[1.08]
             hover:bg-gradient-to-br hover:from-[#8B0000] hover:to-[#660000]
             hover:shadow-[0_0_8px_rgba(255,60,60,0.9),_0_0_18px_rgba(139,0,0,0.85)]
             text-[#F4F4F4]">
      <i class="fa-solid fa-folder-open text-xl"></i>
      <span>Record</span>
    </a>

    <!-- About Us -->
    <a href="{{ route('about.us') }}"
      class="group flex flex-col items-center gap-1 px-4 py-2 rounded-lg
             transition-all duration-500 ease-out
             hover:scale-[1.08]
             hover:bg-gradient-to-br hover:from-[#8B0000] hover:to-[#660000]
             hover:shadow-[0_0_8px_rgba(255,60,60,0.9),_0_0_18px_rgba(139,0,0,0.85)]
             text-[#F4F4F4]">
      <i class="fa-solid fa-circle-info text-xl"></i>
      <span>About Us</span>
    </a>
  </div>
</div>

  <!-- CONTENT -->
  <div class="max-w-7xl mx-auto px-6 py-10">

    <!-- WELCOME -->
    <h1 class="text-4xl font-extrabold mb-6 flex items-center gap-3 fade-up">
      <span class="bg-gradient-to-r from-[#660000] to-[#FFD700] bg-clip-text text-transparent">
        Welcome, {{ ucwords(strtolower($patient->name)) }}!
      </span>

      <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
    </h1>


    <!-- HERO CARD -->
    <div class="bg-gradient-to-r from-[#8B0000] to-[#660000]
            text-[#F4F4F4] rounded-2xl p-20
            flex justify-between items-center
            mb-20 fade-up relative overflow-visible">

      <div>
        <h1 class="text-5xl font-bold mb-4 text-[#F4F4F4] fade-up">
          Your smile starts here!
        </h1>
        <h2 class="text-xl font-normal mb-10 text-[#F4F4F4] fade-up">
          Book a dental appointment at your convenience.
        </h2>

        <button
          class="btn btn-soft shimmer-btn
                px-6 py-3 rounded-2xl
                border-none text-base font-semibold
                text-[#F4F4F4]
                transition-transform duration-300
                hover:-translate-y-0.5
                hover:shadow-[0_0_10px_rgba(255,255,255,0.4)]">

          <a href="{{ route('book.appointment') }}" class="flex items-center gap-2">
            <i class="fa-solid fa-calendar-plus"></i>
            Book Appointment
          </a>
        </button>
      </div>

      <!-- IMAGE (ABSOLUTE) -->
      <div class="absolute right-7 top-1/2 -translate-y-1/2 pointer-events-none">
        <img
          src="images/home-tooth.png"
          alt="Tooth Icon"
          class="float-slow w-[360px] max-w-none
                drop-shadow-[0_14px_26px_rgba(255,255,255,0.25)]"
        />
      </div>

    </div>

    <!-- PROFILE + CALENDAR SECTION -->
    <section class="max-w-7xl mx-auto px-2 mb-10">
      <div class="flex flex-col md:flex-row gap-8">

      <!-- PROFILE CARD -->
      <div id="profileSkeletonContainer" class="bg-gradient-to-t from-[#FFD700] to-[#660000] p-0.5 rounded-2xl md:w-1/3">
        <!-- content will be injected by JS -->
      </div>
      
      <!-- Calendar Section -->
      <div class="md:w-2/3 flex flex-col gap-2">

        <!-- Title outside the card -->
        <h2 class="text-3xl font-extrabold text-[#8B0000] mb-6">Upcoming Schedule</h2>

        <!-- Calendar Card (content injected by JS) -->
        <div
          id="calendarSkeletonContainer"
          class="bg-white border shadow rounded-2xl p-6 h-[390px] w-full">
          <!-- Skeleton OR real calendar goes here -->
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
          <a href="{{ route('record') }}">View Full Record </a>
        </button>
      </div>
    </div>
  </div>

    <!-- REQUEST DOCUMENTS -->
    <h2 class="text-3xl font-extrabold text-[#8B0000] mb-6">Request Documents</h2>

    <div id="requestDocsContainer" class="space-y-4">
      <a onclick="dentalClearanceModal.showModal()"
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
      <p class="text-sm text-[#333333]">
        Dental Clearance • Annual Dental Clearance
      </p>
    </div>
  </a>

  <a onclick="dentalHealthRecordModal.showModal()"
      class="flex border rounded-2xl overflow-hidden
          hover:border-red-800 hover:shadow-lg
          transition cursor-pointer">
          
          <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
            <img src="images/dental-health-record.png"/> </div>
            
            <div class="p-4">
              <p class="font-extrabold text-xl text-[#8B0000] pb-2">
                Request Dental Health Record </p>
                
                <p class="text-sm text-[#333333]">
                  All Dental Records • Medical Record • Diagnosis & Treatments
                </p>
              </div>
            </a>
          </div>
        </div>
<!-- REQUEST CLEARANCE MODAL -->
<dialog id="dentalClearanceModal" class="modal">
  <form
    id="clearanceRequestForm"
    class="modal-box rounded-2xl bg-[#F4F4F4] relative"
    novalidate
  >

    <!-- MINI WARNING -->
    <div
      id="clearanceWarning"
      class="hidden absolute top-4 left-1/2 -translate-x-1/2
            px-4 py-1.5 rounded-full bg-red-600 text-white
            text-xs font-semibold shadow-lg">
      Please complete all required fields
    </div>


    <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">
      Request Clearance
    </h3>

    <p class="text-sm text-[#333333] mb-5">
      Please allow up to three (3) working days for processing.
    </p>

    <!-- TYPE -->
    <div class="mb-5">
      <label class="block text-sm font-bold text-[#8B0000] mb-1">Type of Clearance</label>
      <select required
        class="select select-bordered w-full rounded-xl
               bg-[#F4F4F4] text-[#333333]
               focus:outline-none focus:ring-0 focus:border-[#8B0000]">
        <option value="" disabled selected>Select type of clearance</option>
        <option>Dental Clearance</option>
        <option>Annual Dental Clearance</option>
      </select>
    </div>

    <!-- PURPOSE -->
    <div class="mb-5">
      <label class="block text-sm font-bold text-[#8B0000] mb-1">Purpose</label>
      <select required
        class="select select-bordered w-full rounded-xl
               bg-[#F4F4F4] text-[#333333]
               focus:outline-none focus:ring-0 focus:border-[#8B0000]">
        <option value="" disabled selected>Select purpose</option>
        <option>On-the-Job Training (OJT)</option>
        <option>Employment Requirement</option>
        <option>Academic Requirement</option>
      </select>
    </div>

    <!-- ACTIONS -->
    <div class="modal-action flex justify-between">
      <button type="button"
        onclick="dentalClearanceModal.close()"
        class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">
        Back
      </button>

      <button type="button"
        onclick="validateAndConfirm('clearanceRequestForm','Submit Dental Clearance request?','dentalClearanceModal')"
        class="px-6 py-2 rounded-xl bg-[#8B0000] text-white font-semibold">
        Save
      </button>
    </div>
  </form>
</dialog>

<!-- REQUEST DENTAL HEALTH RECORD MODAL -->
<dialog id="dentalHealthRecordModal" class="modal">
  <form
    id="healthRecordRequestForm"
    class="modal-box rounded-2xl bg-[#F4F4F4] relative"
    novalidate
  >

    <!-- MINI WARNING -->
      <div
      id="healthRecordWarning"
      class="hidden absolute top-4 left-1/2 -translate-x-1/2
            px-4 py-1.5 rounded-full bg-red-600 text-white
            text-xs font-semibold shadow-lg">
      Please complete all required fields
    </div>


    <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">
      Request Dental Health Record
    </h3>

    <p class="text-sm mb-5 text-[#333333]">
      Please allow up to three (3) working days for processing.
    </p>

    <!-- TYPE -->
    <div class="mb-5">
      <label class="block text-sm font-bold text-[#8B0000] mb-1">Type</label>
      <select required
        class="select select-bordered w-full rounded-xl
               bg-[#F4F4F4] text-[#333333]
               focus:outline-none focus:ring-0 focus:border-[#8B0000]">
        <option value="" disabled selected>Select type</option>
        <option>All Dental Records</option>
        <option>Medical Records</option>
        <option>Diagnosis and Treatment</option>
      </select>
    </div>

    <!-- PURPOSE -->
    <div class="mb-5">
      <label class="block text-sm font-bold text-[#8B0000] mb-1">Purpose</label>
      <select required
        class="select select-bordered w-full rounded-xl
               bg-[#F4F4F4] text-[#333333]
               focus:outline-none focus:ring-0 focus:border-[#8B0000]">
        <option value="" disabled selected>Select purpose</option>
        <option>Personal Record</option>
        <option>Academic Requirement</option>
        <option>Employment Requirement</option>
      </select>
    </div>

    <!-- ACTIONS -->
    <div class="modal-action flex justify-between">
      <button type="button"
        onclick="dentalHealthRecordModal.close()"
        class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">
        Back
      </button>

      <button type="button"
        onclick="validateHealthRecord('healthRecordRequestForm','Submit Dental Health Record request?','dentalHealthRecordModal')"
        class="px-6 py-2 rounded-xl bg-[#8B0000] text-white font-semibold">
        Save
      </button>
    </div>
  </form>
</dialog>

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

  <!-- ========================= -->
  <!-- FETCH DENTAL RECORDS -->
  <!-- ========================= -->

<script>

  // Request Clearance Confirmation
    let _pendingFormId = null;
  let _pendingModalIdToClose = null;

  // Call this from Save buttons
  function openConfirm(formId, message, modalIdToClose) {
    _pendingFormId = formId;
    _pendingModalIdToClose = modalIdToClose || null;

    document.getElementById('confirmSaveText').textContent = message;
    confirmSaveModal.showModal();
  }

  function submitConfirmedForm() {
    // close confirm modal
    confirmSaveModal.close();

    // close the request modal (clearance/record)
    if (_pendingModalIdToClose) {
      const reqModal = document.getElementById(_pendingModalIdToClose);
      if (reqModal) reqModal.close();
      
    _pendingFormId = null;
    _pendingModalIdToClose = null;
    }

    // show submitted modal
    submittedInfoModal.showModal();

    // actually submit
    if (_pendingFormId) {
      document.getElementById(_pendingFormId).submit();
    }
  }

    // validate submit request
function validateAndConfirm(formId, message, modalId) {
  const form = document.getElementById(formId);
  const warn = document.getElementById('clearanceWarning');
  warn.classList.add('hidden');
  if (!form.checkValidity()) { warn.classList.remove('hidden'); return; }
  openConfirm(formId, message, modalId);
}

function validateHealthRecord(formId, message, modalId) {
  const form = document.getElementById(formId);
  const warn = document.getElementById('healthRecordWarning');
  warn.classList.add('hidden');
  if (!form.checkValidity()) { warn.classList.remove('hidden'); return; }
  openConfirm(formId, message, modalId);
}

  // Skeleton Loading
  document.addEventListener("DOMContentLoaded", () => {
    
     document.querySelectorAll('#clearanceRequestForm select')
    .forEach(select => {
      select.addEventListener('change', () => {
        document.getElementById('clearanceWarning').classList.add('hidden');
      });
    });

  document.querySelectorAll('#healthRecordRequestForm select')
    .forEach(select => {
      select.addEventListener('change', () => {
        document.getElementById('healthRecordWarning').classList.add('hidden');
      });
    });

    // Show all skeletons first
    showSkeletons();

    // Simulate fetching data after 2 seconds
    setTimeout(() => {
      // Profile

      // Calendar
     document.getElementById("calendarSkeletonContainer").innerHTML = `
      <calendar-date class="cally w-full h-full flex flex-col p-2 fade-up">
        <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
          <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
        </svg>

        <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
          <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>

        <calendar-month class="w-full flex-1"></calendar-month>
      </calendar-date>
    `;

      // Dental Records
      fetch("get_records.php")
        .then(res => res.json())
        .then(records => renderRecords(records))
        .catch(() => showRecordsError());

      // Request Documents
      document.getElementById("requestDocsContainer").innerHTML = `
        <a onclick="dentalClearanceModal.showModal()" class="flex border rounded-2xl overflow-hidden hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
          <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
            <img src="images/dental-clearance.png"/>
          </div>
          <div class="p-4">
            <p class="font-extrabold text-xl text-[#8B0000] pb-2">Request Dental Clearance</p>
            <p class="text-sm text-[#333333]">Dental Clearance • Annual Dental Clearance</p>
          </div>
        </a>
        <a onclick="dentalHealthRecordModal.showModal()" class="flex border rounded-2xl overflow-hidden hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">
          <div class="bg-[#8B0000] w-24 p-4 flex items-center justify-center">
            <img src="images/dental-health-record.png"/>
          </div>
          <div class="p-4">
            <p class="font-extrabold text-xl text-[#8B0000] pb-2">Request Dental Health Record</p>
            <p class="text-sm text-[#333333]">All Dental Records • Medical Record • Diagnosis & Treatments</p>
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

    // Add skeleton animation to profile container
    const profileContainer = document.getElementById("profileSkeletonContainer");
    profileContainer.innerHTML = `
    <div class="bg-[#FAFAFA] rounded-2xl p-5 text-center animate-pulse">
      <div class="w-[210px] h-[210px] rounded-full mx-auto skeleton mb-4"></div>
      <div class="h-6 w-32 mx-auto skeleton mb-2"></div>
      <div class="h-4 w-20 mx-auto skeleton mb-2"></div>
      <div class="h-5 w-24 mx-auto skeleton"></div>
    </div>
  `;

  // 2️replace skeleton with real profile after 2s
  setTimeout(() => {
    profileContainer.innerHTML = `
      <div class="bg-[#F4F4F4] rounded-2xl p-5 text-center fade-up">
        <div class="avatar mb-4 flex justify-center">
          <div class="w-[210px] rounded-full">
            <img
              src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=660000&color=FFFFFF&rounded=true&size=128"
              alt="Profile" />
          </div>
        </div>
        <h3 class="font-bold text-2xl mb-1">{{ isset($patient->name) ? ucwords($patient->name) : 'Guest' }}</h3>
        <p class="text-sm italic mb-4">Patient</p>
        <p class="text-[#8B0000] text-lg font-bold mt-2">{{ $patient->patient_id ?? 'N/A' }}</p>
        <p class="text-sm font-semibold mt-2">{{ $patient->email ?? '-' }}</p>
        <p class="text-sm font-semibold mt-1">{{ $patient->phone ?? '-' }}</p>
        <p class="text-sm mt-2">{{ $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('F d, Y') : '-' }}</p>
        <p class="text-sm mt-1">{{ $patient->gender ?? '-' }}</p>
      </div>
    `;
  }, 2000);

    // Calendar Skeleton
     setTimeout(() => {
    loadCalendar();
  }, 2000);

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

  function showCalendarSkeleton() {
  document.getElementById("calendarSkeletonContainer").innerHTML = `
    <div class="grid grid-cols-7 gap-2 animate-pulse">
      ${Array(35).fill('<div class="h-8 w-8 skeleton rounded"></div>').join("")}
    </div>
  `;
}

function loadCalendar() {
  document.getElementById("calendarSkeletonContainer").innerHTML = `
    <calendar-date class="cally w-full h-full flex flex-col p-2 fade-up">
      <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
        <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
      </svg>

      <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
        <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
      </svg>

      <calendar-month class="w-full flex-1"></calendar-month>
    </calendar-date>
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
          <p class="text-sm text-[#ADADAD] max-w-sm">Time to book that first visit.</p>
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
        <p class="text-sm text-[#ADADAD] max-w-sm">Unable to fetch your records.</p>
      </div>
    `;
  }

  // Helpers
  function viewRecord(id) { window.location.href = `record.php?id=${id}`; }
  function formatDate(dateStr) { return new Date(dateStr).toLocaleDateString(); }
  function formatTime(timeStr) { return timeStr.substring(0,5); }
</script>

</body>
</html>