<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <title>Book Appointment</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Inter';
    }

    /* Primary color scheme */
    .primary-bg {
      background-color: #8B0000 !important;
      color: #F4F4F4 !important;
    }

    .primary-text {
      color: #8B0000;
    }

    /* All buttons */
    .btn,
    .btn-primary,
    .btn-success {
      background-color: #8B0000 !important;
      color: #F4F4F4 !important;
      border: none !important;
    }

    .btn:hover,
    .btn-primary:hover,
    .btn-success:hover {
      background-color: #6f0000 !important;
    }

    /* Disabled select */
    select:disabled {
      background-color: #eee;
      color: #999;
    }

    /* STEPPER COLORS */
    .step.step-primary::before {
      background-color: #2563eb;
      /* Blue */
    }

    .step.step-success::before {
      background-color: #16a34a;
      /* Green */
    }

    /* Blue color for the current step */
    .step.in-progress-step::before {
      background-color: #2563eb !important;
      /* Blue circle */
    }

    /* Blue text for the current step */
    .step.in-progress-step {
      color: #2563eb !important;
    }

    .step-card {
      background-color: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
    }

    .completed-text {
      opacity: 0;
      display: inline-block;
      margin-left: 0.5rem;
      font-weight: 600;
      transition: opacity 0.5s ease-in-out;
    }

    .completed-text.show {
      opacity: 1;
    }

    /*Calendar*/
    .cal-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 4px 0;
      text-align: center;
    }

    .cal-grid .day-header {
      font-size: 0.72rem;
      font-weight: 700;
      color: #333333;
      padding: 4px 0 8px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .cal-grid .day-cell {
      font-size: 0.85rem;
      padding: 6px 2px;
      border-radius: 0.4rem;
      cursor: pointer;
      transition: background 0.15s, color 0.15s;
      user-select: none;
      font-weight: 500;
    }

    .cal-grid .day-cell:hover:not(.disabled):not(.other-month) {
      background: #f0d6d6;
      color: #8B0000;
    }

    .cal-grid .day-cell.disabled {
      color: #ccc;
      cursor: not-allowed;
    }

    .cal-grid .day-cell.other-month {
      color: #ddd;
      cursor: default;
    }

    .cal-grid .day-cell.today {
      font-weight: 800;
      color: #8B0000;
    }

    .cal-grid .day-cell.selected {
      background: #8B0000 !important;
      color: #fff !important;
      font-weight: 700;
    }

    .cal-nav-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px 8px;
      border-radius: 6px;
      transition: background 0.15s;
      color: #8B0000;
      font-size: 1.1rem;
      font-weight: 700;
    }

    .cal-nav-btn:hover {
      background: #f0d6d6;
    }

    .slot-chip {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.45rem 1rem;
      border-radius: 9999px;
      border: 1.5px solid #8B0000;
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      background: #fff;
      color: #8B0000;
      transition: background 0.15s, color 0.15s;
      user-select: none;
    }

    .slot-chip:hover:not(.full) {
      background: #f0d6d6;
    }

    .slot-chip.selected {
      background: #8B0000;
      color: #fff;
    }

    .slot-chip.full {
      border-color: #ccc;
      color: #999;
      cursor: not-allowed;
      text-decoration: line-through;
    }

    .date-banner {
      background: linear-gradient(135deg, #8B0000, #660000);
      color: #fff;
      border-radius: 0.75rem;
      padding: 0.65rem 1.25rem;
      font-size: 0.875rem;
      font-weight: 600;
      display: none;
      box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
    }

    .date-banner.show {
      display: block;
    }

    /* Fade-in for in-progress text */
    .in-progress {
      opacity: 0;
      display: block;
      margin-top: 0.25rem;
      font-weight: 600;
      color: #2563eb;
      transition: opacity 0.5s ease-in-out;
    }

    .in-progress.show {
      opacity: 1;
    }

    /* Fade-in animation for step content */
    .step-content {
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }

    .step-content.show {
      opacity: 1;
    }

    #miniTab {
      transition: opacity 0.3s ease;
      opacity: 0;
      pointer-events: none;
    }

    #miniTab.show {
      opacity: 1;
      pointer-events: auto;
    }

    .input-error {
      border: 2px solid #d10101ff !important;
    }

    .input-valid {
      border: 2px solid #16a34a !important;
      /* green */
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-up {
      animation: fadeUp 0.5s ease-out both;
    }

    /* Optional stagger delay */
    .delay-1 {
      animation-delay: 0.1s;
    }

    .delay-2 {
      animation-delay: 0.2s;
    }

    .delay-3 {
      animation-delay: 0.3s;
    }

    .delay-4 {
      animation-delay: 0.4s;
    }

    @keyframes shake {
      0% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-4px);
      }

      50% {
        transform: translateX(4px);
      }

      75% {
        transform: translateX(-4px);
      }

      100% {
        transform: translateX(0);
      }
    }

    /* FORCE PERFECT CENTER */
    dialog.modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -40%);
      margin: 0;
      border: none;
      padding: 0;
    }

    /* Dark overlay */
    dialog.modal::backdrop {
      background: rgba(0, 0, 0, 0.6);
    }

    .shake {
      animation: shake 0.3s ease-in-out;
    }

    /* --- Calendar status colors --- */
    .day-cell.holiday {
      background: #FFFBEB;
      /* amber-50 */
      color: #B45309;
      /* amber-700 */
      font-weight: 700;
    }

    .day-cell.full-slot {
      background: #FFE4E6;
      /* rose-100 */
      color: #9F1239;
      /* rose-800 */
      font-weight: 700;
    }

    .day-cell.unavailable {
      color: #cfcfcf;
      cursor: not-allowed;
    }

    /* Dot indicator */
    .day-cell {
      position: relative;
    }

    .day-dot {
      position: absolute;
      bottom: 4px;
      left: 50%;
      transform: translateX(-50%);
      width: 6px;
      height: 6px;
      border-radius: 9999px;
    }

    .dot-holiday {
      background: #F59E0B;
    }

    .dot-full {
      background: #EF4444;
    }

    .dot-unavail {
      background: #9CA3AF;
    }

    label:has(input[name="service_type"]:checked) .service-row {
      background: #8B0000;
      border-color: #8B0000;
    }

    label:has(input[name="service_type"]:checked) .service-title {
      color: white;
    }

    label:has(input[name="service_type"]:checked) .service-desc {
      color: rgba(255, 255, 255, 0.75);
    }

    label:has(input[name="service_type"]:checked) .service-icon {
      background: rgba(255, 255, 255, 0.2);
    }

    label:has(input[name="service_type"]:checked) .service-arrow {
      color: white;
    }

    label:has(input[name="service_type"]) {
      transition: transform 0.2s ease;
    }

    label:has(input[name="service_type"]):hover {
      transform: scale(1.02);
    }
  </style>
</head>

<body class="bg-[#F4F4F4]">

  <!-- HEADER -->
  <div class="bg-gradient-to-r from-[#660000] to-[#8B0000] text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <a href="{{ route('homepage') }}" class="flex items-center gap-3">
      <div class="w-12 ml-5">
        <img src="images/PUP.png" alt="PUP Logo">
      </div>
      <div class="w-12">
        <img src="images/PUPT-DMS-Logo.png" alt="Clinic Logo">
      </div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </a>

    <a href="{{ route('homepage') }}" class="flex items-center gap-2 bg-white text-[#8B0000] px-3 py-1 rounded-lg hover:bg-gray-100 transition">
      <span class="font-semibold text-sm">Back to Home</span>
    </a>
  </div>

  <div class="max-w-4xl mx-auto px-6 pt-10 pb-4 text-center animate-fade-up">
    <h1 class="text-4xl font-extrabold text-[#660000] mt-4">Book an Appointment</h1>
    <p class="text-sm text-gray-400 mt-2 mb-6">Complete all steps to schedule your dental visit.</p>
  </div>

  <div class="max-w-4xl mx-auto px-6 pb-16">
    <div class="bg-white rounded-2xl shadow-xl p-8">

      <!-- MAIN FORM -->
      <ul class="steps w-full mb-10">
        <li class="step step-primary" id="s1">Date & Time</li>
        <li class="step" id="s2">Service</li>
        <li class="step" id="s3">Dental History</li>
        <li class="step" id="s4">Medical History</li>
        <li class="step" id="s5">Confirmation</li>
      </ul>

      <form id="appointmentForm" action="{{ route('book.appointment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- STEP 1 -->
        <div class="step-content hidden">
          <h2 class="text-2xl font-extrabold mb-6 text-[#660000] border-b-[1px] border-[#660000] pb-2 mb-10">
            Select Date and Time
          </h2>

          <!-- Hidden inputs keep same names for form submission -->
          <input type="hidden" id="appointment_date" name="appointment_date">
          <input type="hidden" id="appointment_time" name="appointment_time">

          <div class="flex flex-col gap-6">

            <div class="bg-white border-[1px] border-gray-300 rounded-2xl p-8 flex-shrink-0 mx-auto" style="width: 600px;">
              <div id="calendarSkeletonContainer"></div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-200 flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5">
              <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span class="text-sm text-[#333]">Full Slot</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span class="text-sm text-[#333]">Holiday</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                <span class="text-sm text-[#333]">Not Available</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-[#8B0000]">
                </span>
                <span class="text-sm text-[#333]">Today</span>
              </div>
            </div>

            <!-- TIME SLOTS -->
            <div class="flex-1 w-full">
              <label class="text-m font-bold text-[#8B0000] block mb-3">Available Time Slots</label>
              <div class="date-banner mb-4" id="dateBanner"></div>
              <div id="slotContainer" class="hidden">
                <p class="text-xs text-gray-500 mb-3 italic">Click a slot to select your preferred time.</p>
                <div class="flex flex-wrap gap-2" id="slotGrid"></div>
                <div id="selectedSlotDisplay" class="mt-4 text-m font-semibold text-[#8B0000] hidden">
                  <i class="fa-regular fa-clock mr-1"></i> Selected Time: <span id="selectedSlotText" class="text-[#333333]"></span>
                </div>
              </div>
              <div id="slotPlaceholder" class="text-sm text-gray-400 italic mt-2">
                <i class="fa-regular fa-calendar-xmark mr-1"></i> Please select a date first.
              </div>
            </div>

          </div>
        </div>

        <!-- STEP 2 -->
        <div class="step-content hidden">
          <h2 class="text-2xl font-extrabold mb-6 text-[#660000] border-b-2 border-[#660000] pb-2">
            Select Service Type
          </h2>

          <div class="flex flex-col gap-3 pt-4">

            <!-- Card 1 -->
            <label class="cursor-pointer">
              <input type="radio" name="service_type" value="Oral Check-up" class="hidden peer" required>
              <div class="service-row flex items-center gap-5 bg-[#FAFAFA] border-2 border-gray-200 rounded-xl px-6 py-4
                  hover:border-[#8B0000] hover:bg-[#FFF5F5]
                  transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="service-icon w-14 h-14 bg-[#8B0000] rounded-xl flex items-center justify-center flex-shrink-0">
                  <img src="images/oral-checkup.png" class="w-9 h-9 brightness-0 invert" />
                </div>
                <div class="flex-1">
                  <p class="service-title font-bold text-[#333333] text-base">Oral Check-Up</p>
                  <p class="service-desc text-sm text-gray-400 mt-0.5">Routine oral examination • Dental Consultation</p>
                </div>
                <i class="service-arrow fa-solid fa-chevron-right text-gray-300 text-sm flex-shrink-0"></i>
              </div>
            </label>

            <!-- Card 2 -->
            <label class="cursor-pointer">
              <input type="radio" name="service_type" value="Dental Cleaning" class="hidden peer">
              <div class="service-row flex items-center gap-5 bg-[#FAFAFA] border-2 border-gray-200 rounded-xl px-6 py-4
                  hover:border-[#8B0000] hover:bg-[#FFF5F5]
                  transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="service-icon w-14 h-14 bg-[#8B0000] rounded-xl flex items-center justify-center flex-shrink-0">
                  <img src="images/dental-cleaning.png" class="w-9 h-9 brightness-0 invert" />
                </div>
                <div class="flex-1">
                  <p class="service-title font-bold text-[#333333] text-base">Dental Cleaning</p>
                  <p class="service-desc text-sm text-gray-400 mt-0.5">Oral hygiene treatment • Removing surface buildup</p>
                </div>
                <i class="service-arrow fa-solid fa-chevron-right text-gray-300 text-sm flex-shrink-0"></i>
              </div>
            </label>

            <!-- Card 3 -->
            <label class="cursor-pointer">
              <input type="radio" name="service_type" value="Restoration & Prosthesis" class="hidden peer">
              <div class="service-row flex items-center gap-5 bg-[#FAFAFA] border-2 border-gray-200 rounded-xl px-6 py-4
                  hover:border-[#8B0000] hover:bg-[#FFF5F5]
                  transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="service-icon w-14 h-14 bg-[#8B0000] rounded-xl flex items-center justify-center flex-shrink-0">
                  <img src="images/restoration-prosthesis.png" class="w-9 h-9 brightness-0 invert" />
                </div>
                <div class="flex-1">
                  <p class="service-title font-bold text-[#333333] text-base">Restoration & Prosthesis</p>
                  <p class="service-desc text-sm text-gray-400 mt-0.5">Repairs/replaces damaged teeth • Fillings • Crowns • Bridges</p>
                </div>
                <i class="service-arrow fa-solid fa-chevron-right text-gray-300 text-sm flex-shrink-0"></i>
              </div>
            </label>

            <!-- Card 4 -->
            <label class="cursor-pointer">
              <input type="radio" name="service_type" value="Dental Surgery" class="hidden peer">
              <div class="service-row flex items-center gap-5 bg-[#FAFAFA] border-2 border-gray-200 rounded-xl px-6 py-4
                  hover:border-[#8B0000] hover:bg-[#FFF5F5]
                  transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="service-icon w-14 h-14 bg-[#8B0000] rounded-xl flex items-center justify-center flex-shrink-0">
                  <img src="images/dental-surgery.png" class="w-9 h-9 brightness-0 invert" />
                </div>
                <div class="flex-1">
                  <p class="service-title font-bold text-[#333333] text-base">Dental Surgery</p>
                  <p class="service-desc text-sm text-gray-400 mt-0.5">Treating dental issues surgically • Extraction • Implants</p>
                </div>
                <i class="service-arrow fa-solid fa-chevron-right text-gray-300 text-sm flex-shrink-0"></i>
              </div>
            </label>

            <!-- Card 5 -->
            <label class="cursor-pointer">
              <input type="radio" name="service_type" value="Others" class="hidden peer">
              <div class="service-row flex items-center gap-5 bg-[#FAFAFA] border-2 border-gray-200 rounded-xl px-6 py-4
                  hover:border-[#8B0000] hover:bg-[#FFF5F5]
                  transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="service-icon w-14 h-14 bg-[#8B0000] rounded-xl flex items-center justify-center flex-shrink-0">
                  <img src="images/dental-others.png" class="w-9 h-9 brightness-0 invert" />
                </div>
                <div class="flex-1">
                  <p class="service-title font-bold text-[#333333] text-base">Others</p>
                  <p class="service-desc text-sm text-gray-400 mt-0.5">Can't find your service? Let us know what you need.</p>
                </div>
                <i class="service-arrow fa-solid fa-chevron-right text-gray-300 text-sm flex-shrink-0"></i>
              </div>
            </label>

          </div>
        </div>

        <!-- STEP 3 -->
        <div class="step-content hidden">
          <div class="bg-[#F4F4F4] shadow-xl rounded-xl p-8">

            <!-- TITLE -->
            <h2 class="text-2xl font-bold text-[#8B0000] mb-1">Dental History</h2>
            <hr class="border-[#8B0000] border-2 w-full mb-4">

            <p class="text-sm text-gray-600 mb-6">
              Share your past dental records, treatments, or concerns for better assessment.
            </p>

            <!-- BASIC INFO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
              <div>
                <label class="text-sm font-semibold block mb-1">Last Dental Visit:</label>
                <div class="flex gap-2">
                  <input
                    type="text"
                    id="lastDentalVisit"
                    name="last_dental_visit"
                    class="input input-sm border-[#8B0000] w-60"
                    placeholder="Select date"
                    readonly
                    required>
                </div>
              </div>

              <div>
                <label class="text-sm font-semibold block mb-1">Previous Dentist: Dr.</label>
                <input
                  type="text"
                  name="previous_dentist"
                  class="input input-sm border-[#8B0000] w-full"
                  maxlength="50"
                  placeholder="Name">
              </div>
            </div>

            <div class="grid grid-cols-[1fr_60px_60px] gap-4 text-sm font-semibold mb-2 items-center">
              <span>
                Please indicate <span class="font-bold">YES</span> or <span class="font-bold">NO</span> to the following:
              </span>
              <span class="text-center">YES</span>
              <span class="text-center">NO</span>
            </div>

            <!-- QUESTIONS -->
            <div class="space-y-3 text-sm">

              <!-- REUSABLE FORMAT -->
              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Do your gums bleed while brushing/flossing?</span>
                <input type="radio" name="bleeding_gums" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="bleeding_gums" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Are your teeth sensitive to hot or cold?</span>
                <input type="radio" name="sensitive_temp" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="sensitive_temp" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Are your teeth sensitive to sweets or sour?</span>
                <input type="radio" name="sensitive_taste" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="sensitive_taste" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Do you feel any pain in your teeth?</span>
                <input type="radio" name="tooth_pain" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="tooth_pain" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Do you have any sores/lumps in or near your mouth?</span>
                <input type="radio" name="sores" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="sores" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Have you had any head,neck, or jaw injuries?</span>
                <input type="radio" name="injuries" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="injuries" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

            </div><!-- END QUESTIONS -->

            <hr class="border-[#8B0000] border-2 my-8">

            <!-- SECOND SECTION -->
            <p class="font-semibold mb-3 text-sm">
              Have you ever experienced any of the following?
            </p>

            <div class="space-y-3 text-sm">
              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Clicking</span>
                <input type="radio" name="clicking" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="clicking" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Pain (joint, side of the face)</span>
                <input type="radio" name="joint_pain" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="joint_pain" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Difficulty in opening/closing</span>
                <input type="radio" name="difficulty_moving" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="difficulty_moving" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Difficulty in chewing</span>
                <input type="radio" name="difficulty_chewing" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="difficulty_chewing" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Frequent headaches</span>
                <input type="radio" name="jaw_headaches" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="jaw_headaches" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Do you clench or grind your teeth?</span>
                <input type="radio" name="clench_grind" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="clench_grind" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Frequent lips/cheek biting</span>
                <input type="radio" name="biting" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="biting" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Have you noticed loosening your teeth?</span>
                <input type="radio" name="teeth_loosening" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="teeth_loosening" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Does food get caught between your teeth?</span>
                <input type="radio" name="food_teeth" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="food_teeth" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Have you ever had reaction to any kind of medicine or dental anesthetic?</span>
                <input type="radio" name="med_reaction" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="med_reaction" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>
            </div>

            <p class="text-xs text-[#8B0000] mt-3 mb-6 italic">
              <span class="text-xs italic text-[#8B0000]">If <b>YES</b>, please provide details during consultation.</span>
            </p>

            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mb-4">
              <span class="text-sm">Have you had any periodontal (gum) treatment?</span>
              <input type="radio" name="periodontal" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="periodontal" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mb-4">
              <span class="text-sm">Have you had a difficult tooth extraction?</span>
              <input type="radio" name="difficult_extraction" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="difficult_extraction" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <!-- DATE BOX - only shows if YES -->
            <div class="mt-2 ml-8 hidden" id="extraction_date_box">
              <label class="text-xs italic text-[#8B0000]">Date of extraction:</label>
              <div class="flex gap-2">
                <input
                  type="text"
                  id="extractionDate"
                  name="extraction_date"
                  class="input input-sm border-[#8B0000] w-60"
                  placeholder="Select date"
                  readonly>
              </div>
            </div>

            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mt-4">
              <span class="text-sm">Have you had prolonged bleeding following tooth extractions before?</span>
              <input type="radio" name="prolonged_bleeding" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="prolonged_bleeding" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mt-4 mb-4">
              <span class="text-sm">Do you wear complete or partial dentures?</span>
              <input type="radio" name="dentures" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="dentures" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <div class="mt-2 ml-8 hidden" id="dentures_date_box">
              <label class="text-xs italic text-[#8B0000]">If yes, date of placement:</label>
              <div class="flex gap-2">
                <input
                  type="text"
                  id="denturesDate"
                  name="dentures_date"
                  class="input input-sm border-[#8B0000] w-60"
                  placeholder="Select date"
                  readonly>
              </div>
            </div>

            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mt-4 mb-4">
              <span class="text-sm">Have you had orthodontic treatment?</span>
              <input type="radio" name="ortho_treatment" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="ortho_treatment" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <div class="mt-2 ml-8 hidden" id="ortho_date_box">
              <label class="text-xs italic text-[#8B0000]">If yes, date of completion:</label>
              <div class="flex gap-2">
                <input
                  type="text"
                  id="orthoDate"
                  name="ortho_date"
                  class="input input-sm border-[#8B0000] w-60"
                  placeholder="Select date"
                  readonly>
              </div>
            </div>

            <hr class="border-[#8B0000] border-2 my-8">

            <!-- THIRD SECTION -->
            <p class="font-bold mb-3 text-sm">
              Additional Concerns
            </p>

            <textarea
              name="additional_concerns"
              id="additional_concerns"
              class="w-full border-[#8B0000] rounded-md p-2 text-sm resize-none"
              placeholder="Write any additional concerns here..."
              rows="4">
  </textarea>

          </div><!-- END bg card -->
        </div><!-- END step-content -->

        <!-- STEP 4 -->
        <div class="step-content hidden">
          <div class="bg-[#F4F4F4] shadow-xl rounded-xl p-8">

            <!-- TITLE -->
            <h2 class="text-2xl font-bold text-[#8B0000] mb-1">Medical History</h2>
            <hr class="border-[#8B0000] border-2 w-full mb-4">

            <p class="text-sm text-gray-600 mb-6">
              Provide important medical information to help the dentist ensure safe and proper care.
            </p>

            <!-- YES / NO HEADER -->
            <div class="grid grid-cols-[1fr_60px_60px] gap-4 text-sm font-semibold mb-2 items-center">
              <span>Please indicate <b>YES</b> or <b>NO</b>:</span>
              <span class="text-center">YES</span>
              <span class="text-center">NO</span>
            </div>

            <!-- QUESTIONS -->
            <div class="space-y-4 text-sm">

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Are you in good health?</span>
                <input type="radio" name="good_health" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="good_health" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="ml-8 hidden" id="good_health_box">
                <label class="text-xs italic text-[#8B0000]">If NO, please provide details:</label>
                <input
                  type="text"
                  name="good_health_details"
                  class="input input-sm border-[#8B0000] w-full"
                  placeholder="Input here">
              </div>

              <!-- LAST MEDICAL EXAM -->
              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mt-4">
                <span>When was your last medical examination?</span>
                <input type="radio" name="had_medical_exam" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="had_medical_exam" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <!-- DATE FIELD (HIDDEN INITIALLY) -->
              <div class="ml-8 hidden" id="medical_exam_box">
                <label class="text-xs italic text-[#8B0000] mb-1 block">
                  If YES, when was your last medical examination?
                </label>
                <input
                  type="text"
                  id="medicalExamDate"
                  name="medical_exam_date"
                  class="input input-sm border-[#8B0000] w-60"
                  placeholder="Select date"
                  readonly>
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mt-4">
                <span>Are you currently receiving treatment for any illness?</span>
                <input type="radio" name="under_treatment" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="under_treatment" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="ml-8 hidden" id="treatment_box">
                <label class="text-xs italic text-[#8B0000]">If YES, please specify:</label>
                <input
                  type="text"
                  name="treatment_details"
                  class="input input-sm border-[#8B0000] w-full"
                  placeholder="Input here">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mt-4">
                <span>Have you ever been hospitalized?</span>
                <input type="radio" name="hospitalized" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="hospitalized" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="ml-8 hidden" id="hospital_box">
                <label class="text-xs italic text-[#8B0000]">If YES, please provide details:</label>
                <input
                  type="text"
                  name="hospital_details"
                  class="input input-sm border-[#8B0000] w-full"
                  placeholder="Input here">
              </div>

            </div>

            <hr class="border-[#8B0000] border-2 my-8">
            <p class="font-semibold mb-3 text-sm">Are you allergic to any of the following?</p>

            <div class="space-y-3 text-sm">
              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Medicines</span>
                <input type="radio" name="allergy_medicine" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="allergy_medicine" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Food</span>
                <input type="radio" name="allergy_food" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="allergy_food" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="ml-8">
                <label class="text-xs italic text-[#8B0000]">Others (please specify):</label>
                <input
                  type="text"
                  name="allergy_others"
                  class="input input-sm border-[#8B0000] w-60"
                  placeholder="Input here">
              </div>
            </div>

            <!-- MEDICATION -->
            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 text-sm mt-4">
              <span>Are you taking any prescription or non-prescription medication?</span>
              <input type="radio" name="medication" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="medication" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <div class="ml-8 hidden" id="medication_box">
              <label class="text-xs italic text-[#8B0000]">If YES, please specify:</label>
              <input
                type="text"
                name="medication_details"
                class="input input-sm border-[#8B0000] w-full"
                placeholder="Input here">
            </div>

            <hr class="border-[#8B0000] border-2 my-8">
            <p class="text-sm font-bold text-[#8B0000] mb-4">
              For WOMEN only:
            </p>

            <div class="grid grid-cols-[1fr_60px_60px] gap-4 text-sm font-semibold mb-2 items-center">
              <span></span>
              <span class="text-center">YES</span>
              <span class="text-center">NO</span>
            </div>

            <div class="space-y-3 text-sm">

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Are you pregnant?</span>
                <input type="radio" name="pregnant" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="pregnant" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Are you nursing?</span>
                <input type="radio" name="nursing" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="nursing" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Are you taking birth control pills?</span>
                <input type="radio" name="birth_control" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="birth_control" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>
            </div>

            <!-- MEDICAL CONDITIONS -->
            <hr class="border-[#8B0000] border-2 my-8">
            <p class="text-sm font-semibold mb-4">
              Please indicate below if you presently have or have ever had any of the following:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-10 text-sm">

              <!-- LEFT COLUMN -->
              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="AIDS/HIV" class="checkbox checkbox-sm border-[#8B0000]">
                AIDS / HIV
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Fainting/Dizzy Spells" class="checkbox checkbox-sm border-[#8B0000]">
                Fainting / Dizzy Spells
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Alcohol or Chemical Dependency" class="checkbox checkbox-sm border-[#8B0000]">
                Alcohol or Chemical Dependency
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="High/Low Blood Pressure" class="checkbox checkbox-sm border-[#8B0000]">
                High / Low Blood Pressure
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Arthritis/Rheumatism" class="checkbox checkbox-sm border-[#8B0000]">
                Arthritis / Rheumatism
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Hyper/Hypoglycemia" class="checkbox checkbox-sm border-[#8B0000]">
                Hyper / Hypoglycemia
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Artificial Joints or Valves" class="checkbox checkbox-sm border-[#8B0000]">
                Artificial Joints or Valves
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Kidney Disease" class="checkbox checkbox-sm border-[#8B0000]">
                Kidney Disease
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Asthma" class="checkbox checkbox-sm border-[#8B0000]">
                Asthma
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Liver Disease" class="checkbox checkbox-sm border-[#8B0000]">
                Liver Disease (Hepatitis / Jaundice)
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Blood Transfusion" class="checkbox checkbox-sm border-[#8B0000]">
                Blood Transfusion
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Mental/Nervous Disorder" class="checkbox checkbox-sm border-[#8B0000]">
                Mental / Nervous Disorder
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Cancer/Radiotherapy/Chemotherapy" class="checkbox checkbox-sm border-[#8B0000]">
                Cancer / Radiotherapy / Chemotherapy
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Stomach Ulcers" class="checkbox checkbox-sm border-[#8B0000]">
                Stomach Ulcers
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Diabetes" class="checkbox checkbox-sm border-[#8B0000]">
                Diabetes
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Stroke" class="checkbox checkbox-sm border-[#8B0000]">
                Stroke
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Eating Disorders" class="checkbox checkbox-sm border-[#8B0000]">
                Eating Disorders
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Tuberculosis" class="checkbox checkbox-sm border-[#8B0000]">
                Tuberculosis
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Epilepsy/Seizures" class="checkbox checkbox-sm border-[#8B0000]">
                Epilepsy / Seizures
              </label>

              <label class="flex items-center gap-2">
                <input type="checkbox" name="conditions[]" value="Venereal/Communicable Disease" class="checkbox checkbox-sm border-[#8B0000]">
                Venereal / Communicable Disease
              </label>
            </div>

            <hr class="border-[#8B0000] border-2 my-8">

            <div class="grid grid-cols-[1fr_60px_60px] gap-4 text-sm font-semibold mb-2 items-center">
              <span>Do use tobacco products or any derivatives?</span>
              <span class="text-center">YES</span>
              <span class="text-center">NO</span>
            </div>

            <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 mb-4 text-sm">
              <span></span>
              <input type="radio" name="tobacco_use" value="Yes"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
              <input type="radio" name="tobacco_use" value="No"
                class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
            </div>

            <div id="tobacco_details" class="ml-4 space-y-2 hidden text-sm">
              <div class="flex items-center gap-2">
                <span class="text-xs italic text-[#8B0000]">If yes, how much per day:</span>
                <input type="text" name="tobacco_per_day" placeholder="Input here"
                  class="input input-sm border-[#8B0000] w-40">
              </div>

              <div class="flex items-center gap-2">
                <span class="text-xs italic text-[#8B0000]">per week:</span>
                <input type="text" name="tobacco_per_week" placeholder="Input here"
                  class="input input-sm border-[#8B0000] w-40">
              </div>
            </div>

            <hr class="border-[#8B0000] border-2 my-8">

            <p class="text-sm font-semibold mb-4">Do you suffer from:</p>

            <div class="grid grid-cols-[1fr_60px_60px] gap-4 text-sm font-semibold mb-2 items-center">
              <span></span>
              <span class="text-center">YES</span>
              <span class="text-center">NO</span>
            </div>

            <div class="space-y-3 text-sm">

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Headaches</span>
                <input type="radio" name="headaches" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="headaches" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Earaches</span>
                <input type="radio" name="earaches" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="earaches" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>

              <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4">
                <span>Neck aches</span>
                <input type="radio" name="neck_aches" value="Yes"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto" required>
                <input type="radio" name="neck_aches" value="No"
                  class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
              </div>
            </div>

            <!-- EMERGENCY CONTACT -->
            <hr class="border-[#8B0000] border-2 my-8">
            <p class="text-sm font-bold text-[#8B0000] mb-6">
              Emergency Contact
            </p>

            <div class="space-y-4 text-sm">

              <!-- NAME -->
              <div class="flex items-center gap-4">
                <label class="w-64">Person to contact in case of emergency:</label>
                <input
                  type="text"
                  name="emergency_person"
                  maxlength="50"
                  class="input input-sm border-[#8B0000] w-80"
                  placeholder="Name"
                  required>
              </div>

              <!-- CONTACT NUMBER -->
              <div class="flex items-center gap-4">
                <label class="w-64">Contact Number:</label>
                <input
                  type="tel"
                  id="emergency_number"
                  name="emergency_number"
                  maxlength="11"
                  class="input input-sm border-[#8B0000] w-80 transition-all"
                  placeholder="09XXXXXXXXX"
                  required>
              </div>

              <!-- RELATION -->
              <div class="flex items-center gap-4 relative">
                <label class="w-64" for="emergency_relation">Relation to Patient:</label>
                <div class="flex flex-col w-80">
                  <div class="relative w-full">
                    <select
                      id="emergency_relation"
                      name="emergency_relation"
                      class="input input-sm border-[#8B0000] w-full appearance-none pr-8"
                      required>
                      <option value="" disabled selected>Select relation</option>
                      <option value="Mother">Mother</option>
                      <option value="Father">Father</option>
                      <option value="Guardian">Guardian</option>
                      <option value="Spouse">Spouse</option>
                      <option value="Others">Others</option>
                    </select>
                    <!-- Downward arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                      <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                      </svg>
                    </div>
                  </div>

                  <input
                    type="text"
                    id="relation_other"
                    name="relation_other"
                    maxlength="30"
                    class="input input-sm border-[#8B0000] mt-2 hidden"
                    placeholder="Please specify relation">
                </div>
              </div>

              <!-- SIGNATURE -->
              <div class="flex items-start gap-4">
                <label class="w-64 pt-2">Patient's Signature:</label>

                <div class="border-2 border-dashed border-gray-400 rounded-md p-4 w-72 text-center text-xs space-y-2">

                  <p>Select your file or drag and drop</p>
                  <p class="text-gray-500">JPG, PNG or PDF, up to 25 MB</p>

                  <label
                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-[#8B0000] text-white text-xs 
              rounded cursor-pointer hover:bg-[#6f0000]">
                    <span>Browse</span>

                    <input
                      type="file"
                      name="patient_signature"
                      id="patient_signature"
                      class="hidden"
                      accept=".jpg,.jpeg,.png,"
                      required>
                  </label>

                  <p id="signature_filename" class="text-gray-600 text-xs truncate hidden"></p>

                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- STEP 5 -->
        <div class="step-content hidden" id="step5">

          <!-- SUMMARY SECTION -->
          <div id="summarySection">
            <div class="bg-[#D9D9D9] shadow-xl rounded-xl p-10 mb-8">
              <h2 class="text-3xl font-normal text-[#660000] mb-4">Summary</h2>
              <div class="h-[2px] w-full bg-[#8B0000] mb-8"></div>
              <div id="summaryBox"></div>
            </div>

            <div class="flex justify-center gap-4">
              <button
                type="button"
                id="summaryBackBtn"
                class="min-w-[110px] px-6 py-2 rounded border border-gray-500 bg-gray-200 text-[#8B0000] hover:bg-gray-300 transition shadow">
                &lsaquo; Back
              </button>

              <!-- CHANGED TO NEXT -->
              <button
                type="button"
                id="goToConfirmationBtn"
                class="min-w-[110px] px-6 py-2 rounded bg-[#8B0000] text-white hover:bg-[#7A0000] transition shadow">
                Next
              </button>
            </div>
          </div>

          <!-- CONFIRMATION SECTION (HIDDEN FIRST) -->
          <div id="confirmationSection" class="hidden">

            <div class="bg-[#D9D9D9] shadow-xl rounded-xl p-10">
              <h2 class="text-3xl font-normal text-[#660000] mb-4">Confirmation</h2>
              <div class="h-[2px] w-full bg-[#8B0000] mb-8"></div>

              <label class="flex items-start gap-3 cursor-pointer select-none">

                <input
                  id="finalConfirm"
                  type="checkbox"
                  class="mt-1 w-5 h-5 border border-[#8B0000] rounded bg-white accent-[#8B0000]"
                  required />

                <span class="text-gray-700 text-sm leading-5">
                  I hereby confirm that I have reviewed my dental and medical information and accepted the
                  <a href="/privacy-policy" class="text-[#8B0000] hover:underline">Privacy Policy</a>
                  and
                  <a href="/terms-of-service" class="text-[#8B0000] hover:underline">Terms of Service</a>.
                </span>
              </label>

              <!-- BUTTONS (Back + Submit) -->
              <div class="flex justify-center gap-4 mt-10">
                <button
                  type="button"
                  id="confirmBackBtn"
                  class="min-w-[110px] px-6 py-2 rounded border border-gray-500
        bg-gray-200 text-[#8B0000] hover:bg-gray-300 transition shadow relative z-10">
                  &lsaquo; Back
                </button>

                <button
                  type="button"
                  id="finalSubmitBtn"
                  class="min-w-[110px] px-6 py-2 rounded bg-[#8B0000] text-white
        hover:bg-[#7A0000] transition shadow">
                  Submit
                </button>
              </div>
            </div>

          </div>

        </div>

        <!-- OTHERS SERVICE MODAL -->
        <dialog id="othersModal" class="modal">
          <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-md">
            <div class="h-2 bg-[#8B0000] w-full"></div>
            <div class="px-8 py-8">
              <h3 class="text-xl font-bold text-[#8B0000] mb-1">Other Service</h3>
              <p class="text-sm text-gray-500 mb-5">Please describe the service you need.</p>
              <input
                type="text"
                id="service_others_text"
                name="service_others_text"
                class="input input-bordered border-[#8B0000] w-full mb-6"
                placeholder="e.g. Teeth whitening, fluoride treatment..."
                maxlength="100">
              <div class="flex justify-end gap-3">
                <button type="button" id="othersCancelBtn"
                  class="px-5 py-2 rounded-lg border border-gray-400 text-[#660000] font-medium hover:bg-gray-100 transition">
                  Cancel
                </button>
                <button type="button" id="othersConfirmBtn"
                  class="px-5 py-2 rounded-lg bg-[#8B0000] text-white font-medium hover:bg-[#6f0000] transition">
                  Confirm
                </button>
              </div>
            </div>
          </div>
        </dialog>

        <!-- MINI TAB WARNING -->
        <div id="miniTab"
          class="hidden fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-4 py-2 rounded shadow-md text-sm z-50">
          Please complete all required fields before proceeding.
        </div>

        <!-- NAVIGATION BUTTONS (for Steps 1-4 only) -->
        <div class="flex justify-center mt-8 gap-6" id="navBtns">

          <!-- PREVIOUS -->
          <button
            type="button"
            id="prevBtn"
            class="flex items-center gap-2 px-6 py-2 rounded-lg border border-gray-400 bg-[#F4F4F4] text-[#660000]
           font-medium hover:bg-[#ECECEC] shadow transition">
            <span class="text-xl leading-none">&lsaquo;</span>
            <span>Previous</span>
          </button>

          <!-- NEXT -->
          <button
            type="button"
            id="nextBtn"
            class="btn btn-primary shadow pr-10 pl-10">
            <span>Next</span>
            <span class="text-xl leading-none">&rsaquo;</span>
          </button>

        </div>

        <!-- FINAL CONFIRMATION MODAL -->
        <dialog id="confirmModal" class="modal">
          <div class="modal-box p-0 rounded-2xl overflow-hidden shadow-2xl w-full max-w-[600px]">

            <!-- Top red panel -->
            <div class="bg-[#8B0000] text-white px-12 py-10 text-center">
              <h2 class="text-2xl font-semibold mb-6">Appointment Confirmed</h2>

              <p class="text-sm leading-6 mb-6" id="confirmMessage"></p>

              <p class="mb-6">Thank you!</p>

              <!-- OK BUTTON -->
              <button
                type="button"
                id="okBtn"
                class="inline-block bg-gray-200 text-[#8B0000] px-8 py-2 rounded shadow hover:bg-gray-300 transition">
                Back to Home
              </button>
            </div>

          </div>
        </dialog>

        <!-- LEAVE CONFIRM MODAL -->
        <dialog id="leaveModal" class="modal">
          <div class="modal-box p-0 rounded-2xl overflow-hidden shadow-2xl max-w-md">
            <div class="bg-[#8B0000] text-white px-6 py-4">
              <h3 class="text-lg font-bold">Unsaved changes</h3>
              <p class="text-sm opacity-90 mt-1">
                Save your progress as a draft, or discard changes and leave this page.
              </p>
            </div>

            <div class="px-6 py-5 bg-white">
              <div class="flex justify-end gap-3">
                <button type="button" id="discardDraftBtn"
                  class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                  Discard Changes
                </button>

                <button type="button" id="saveDraftBtn"
                  class="px-5 py-2 rounded-lg bg-[#8B0000] text-white hover:bg-[#6f0000] transition">
                  Save Draft
                </button>
              </div>
            </div>
          </div>
        </dialog>

        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script>
          /* =========================
     DRAFT SAVE / RESTORE
  ========================= */
          const DRAFT_KEY = "appointmentDraft:v1";

          function saveDraft() {
            const form = document.getElementById("appointmentForm");
            if (!form) return;

            const data = new FormData(form);

            // Build a plain object (supports multiple values like conditions[])
            const obj = {};
            for (const [key, value] of data.entries()) {
              // Skip file input (signature) — can't be restored for security reasons
              if (key === "patient_signature") continue;

              if (obj[key] === undefined) {
                obj[key] = value;
              } else if (Array.isArray(obj[key])) {
                obj[key].push(value);
              } else {
                obj[key] = [obj[key], value];
              }
            }

            // Also include step + selected date/time explicitly (safe)
            obj.__meta = {
              step: typeof step !== "undefined" ? step : 0,
              savedAt: new Date().toISOString(),
            };

            localStorage.setItem(DRAFT_KEY, JSON.stringify(obj));
          }

          function clearDraft() {
            localStorage.removeItem(DRAFT_KEY);
          }

          function restoreDraft() {
            const raw = localStorage.getItem(DRAFT_KEY);
            if (!raw) return;

            let obj;
            try {
              obj = JSON.parse(raw);
            } catch {
              return;
            }

            const form = document.getElementById("appointmentForm");
            if (!form) return;

            // restore simple inputs/select/textarea + radio/checkbox + hidden date/time
            Object.keys(obj).forEach((name) => {
              if (name === "__meta") return;

              const value = obj[name];

              // Checkboxes (multiple values)
              if (Array.isArray(value)) {
                // For groups like conditions[]
                const inputs = form.querySelectorAll(`[name="${CSS.escape(name)}"]`);
                inputs.forEach((el) => {
                  if (el.type === "checkbox") {
                    el.checked = value.includes(el.value);
                  }
                });
                return;
              }

              const elList = form.querySelectorAll(`[name="${CSS.escape(name)}"]`);
              if (!elList.length) return;

              elList.forEach((el) => {
                if (el.type === "radio") {
                  el.checked = (el.value === value);
                } else if (el.type === "checkbox") {
                  el.checked = (value === true || value === "on" || value === el.value);
                } else {
                  el.value = value;
                }
              });
            });

            // If relation is Others, show the textbox
            const relationSelect = document.getElementById("emergency_relation");
            const otherInput = document.getElementById("relation_other");
            if (relationSelect && otherInput) {
              if (relationSelect.value === "Others") {
                otherInput.classList.remove("hidden");
                otherInput.setAttribute("required", "true");
              }
            }

            // Re-render calendar selection + slots (if date exists)
            const restoredDate = document.getElementById("appointment_date")?.value;
            const restoredTime = document.getElementById("appointment_time")?.value;

            if (restoredDate) {
              selectedDate = restoredDate;
              // highlight date + render slots
              selectDate(restoredDate);

              // if time exists, select it visually (best-effort)
              if (restoredTime) {
                selectedTime = restoredTime;
                const slotGrid = document.getElementById("slotGrid");
                if (slotGrid) {
                  [...slotGrid.querySelectorAll(".slot-chip")].forEach(chip => {
                    if (chip.textContent.trim().startsWith(restoredTime)) {
                      chip.classList.add("selected");
                    }
                  });
                }
                const selectedSlotText = document.getElementById("selectedSlotText");
                const selectedSlotDisplay = document.getElementById("selectedSlotDisplay");
                if (selectedSlotText) selectedSlotText.textContent = restoredTime;
                if (selectedSlotDisplay) selectedSlotDisplay.classList.remove("hidden");
              }
            }

            // Mark as dirty since draft restored
            formIsDirty = true;
          }

          /* =========================
            MINI TAB
          ========================= */
          const miniTab = document.getElementById("miniTab");

          function showMiniTab(message) {
            if (!miniTab) return;
            miniTab.textContent = message || "Please complete all required fields before proceeding.";
            miniTab.classList.remove("hidden");
            miniTab.classList.add("show");

            clearTimeout(window.__miniTabTimer);
            window.__miniTabTimer = setTimeout(() => {
              miniTab.classList.add("hidden");
              miniTab.classList.remove("show");
            }, 3000);
          }

          function showInputError(input) {
            if (!input) return;
            input.classList.add("input-error", "shake");
            setTimeout(() => input.classList.remove("shake"), 300);
          }

          const allSlots = [{
              t: "9:00 AM",
              available: true
            },
            {
              t: "10:00 AM",
              available: true
            },
            {
              t: "11:00 AM",
              available: false
            },
            {
              t: "12:00 PM",
              available: false
            },
            {
              t: "1:00 PM",
              available: true
            },
            {
              t: "2:00 PM",
              available: true
            },
            {
              t: "3:00 PM",
              available: true
            },
            {
              t: "4:00 PM",
              available: true
            },
          ];

          /* =========================
            CALENDAR DATA
          ========================= */
          const MAX_PER_DAY = 5;

          const apptCounts = @json($appointmentCountsPerDay ?? []);
          const apptSlotCounts = @json($appointmentCountsPerSlot ?? []);
          const unavailableDates = @json($unavailableDates ?? []);
          const holidaysMap = @json($philippineHolidays ?? []);


          /* =========================
             CALENDAR
          ========================= */
          let selectedDate = null,
            selectedTime = null;

          function pad(n) {
            return String(n).padStart(2, "0");
          }

          function formatISO(y, m, d) {
            return `${y}-${pad(m + 1)}-${pad(d)}`;
          }

          // Returns status info for a date cell (what to show + if clickable)
          function getDateStatus(dateObj, iso) {
            // past
            if (dateObj < todayDate) {
              return {
                disabled: true,
                cls: ["disabled"],
                tip: "Booking Not Allowed for Past Dates",
                dot: null
              };
            }

            // weekend
            const dow = dateObj.getDay();
            if (dow === 0 || dow === 6) {
              return {
                disabled: true,
                cls: ["disabled", "unavailable"],
                tip: "Clinic Closed (Saturday & Sunday)",
                dot: "dot-unavail",
              };
            }

            // holiday
            if (holidaysMap?.[iso]) {
              return {
                disabled: true,
                cls: ["disabled", "holiday"],
                tip: holidaysMap[iso], // shows the holiday name
                dot: "dot-holiday",
              };
            }

            // admin-defined unavailable
            if (unavailableDates.includes(iso)) {
              return {
                disabled: true,
                cls: ["disabled", "unavailable"],
                tip: "Not available",
                dot: "dot-unavail",
              };
            }

            // full slot
            const count = apptCounts?.[iso] ?? 0;
            if (count >= MAX_PER_DAY) {
              return {
                disabled: true,
                cls: ["disabled", "full-slot"],
                tip: "Full Slot",
                dot: "dot-full",
              };
            }

            // selectable
            return {
              disabled: false,
              cls: [],
              tip: "",
              dot: null
            };
          }

          function loadCalendar() {
            const today = new Date();
            let currentYear = today.getFullYear();
            let currentMonth = today.getMonth();

            function pad(n) {
              return String(n).padStart(2, "0");
            }

            function isWeekend(year, month, day) {
              const dow = new Date(year, month, day).getDay();
              return dow === 0 || dow === 6;
            }

            function getHolidaysForMonth(year, month) {
              const filtered = {};
              Object.keys(holidaysMap || {}).forEach(dateStr => {
                const [y, m] = dateStr.split("-").map(Number);
                if (y === year && m === month + 1) filtered[dateStr] = holidaysMap[dateStr];
              });
              return filtered;
            }

            function renderCalendar(year, month) {
              const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
              const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

              const firstDow = new Date(year, month, 1).getDay();
              const totalDays = new Date(year, month + 1, 0).getDate();
              const leadingEmpties = firstDow;

              const holidays = getHolidaysForMonth(year, month);

              let cells = "";

              for (let i = 0; i < leadingEmpties; i++) cells += `<div></div>`;

              for (let d = 1; d <= totalDays; d++) {
                const dateStr = `${year}-${pad(month + 1)}-${pad(d)}`;

                const isToday = (d === today.getDate() && month === today.getMonth() && year === today.getFullYear());
                const weekend = isWeekend(year, month, d);
                const holiday = holidays[dateStr] || null;

                const count = apptCounts?.[dateStr] ?? 0;
                const isFull = count >= MAX_PER_DAY;

                const isUnavail = unavailableDates.includes(dateStr) || weekend;

                // ── Styling ────────────────────────────────────────
                let bgClass = "";
                let textClass = "text-[#333333]";
                let ringClass = "";
                let dotHtml = "";
                let tooltipTxt = "";

                // disable clicking if full/holiday/unavailable/weekend/past (optional: add past check if you want)
                const cellDate = new Date(year, month, d);
                cellDate.setHours(0, 0, 0, 0);

                const isPast = cellDate < todayDate; // uses your global todayDate (so add it back below)
                const isDisabled = isPast || isUnavail || isFull || !!holiday;

                if (isPast) {
                  textClass = "text-gray-300";
                  ringClass = "ring-1 ring-gray-200 ring-offset-1";
                  tooltipTxt = `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Booking Not Allowed for Past Dates`;
                }

                if (isToday) {
                  bgClass = "bg-[#8B0000]";
                  textClass = "text-white font-extrabold";
                  ringClass = "ring-2 ring-[#8B0000]/30 ring-offset-1";
                } else if (holiday) {
                  bgClass = "bg-blue-50 hover:bg-blue-100";
                  textClass = "text-blue-700 font-semibold";
                  ringClass = "ring-2 ring-blue-300/70 ring-offset-1";
                } else if (isFull && !isUnavail) {
                  bgClass = "bg-red-50 hover:bg-red-100";
                  textClass = "text-red-700 font-semibold";
                  ringClass = "ring-2 ring-red-300/70 ring-offset-1";
                } else if (isUnavail) {
                  bgClass = "";
                  textClass = "text-gray-300";
                  ringClass = "ring-1 ring-gray-200 ring-offset-1";
                } else {
                  bgClass = "hover:bg-[#FFF0F0]";
                }

                // ── Dots + Tooltip ───────────────────────────────
                if (isFull && !holiday && !isUnavail) {
                  dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
                  tooltipTxt = `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Full Slot`;
                }

                if (holiday) {
                  dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>`;
                  tooltipTxt = `<i class="fa-solid fa-star mr-1 text-blue-300"></i>${holiday}`;
                }

                if (isUnavail && !holiday) {
                  tooltipTxt = weekend ?
                    `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic Closed (Saturday & Sunday)` :
                    `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
                }

                const tooltipHtml = tooltipTxt ? `
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50
                            bg-[#1a1a1a] text-white text-[11px] font-medium
                            px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl
                            opacity-0 group-hover:opacity-100 pointer-events-none
                            transition-opacity duration-200">
                  ${tooltipTxt}
                  <div class="absolute top-full left-1/2 -translate-x-1/2
                              border-4 border-transparent border-t-[#1a1a1a]"></div>
                </div>` : "";

                cells += `
                <div class="relative group flex items-center justify-center">
                  ${tooltipHtml}
                  <div
                    class="relative w-9 h-9 flex items-center justify-center
                          text-sm rounded-full transition-all duration-150
                          ${bgClass} ${textClass} ${ringClass}
                          ${isDisabled ? "cursor-not-allowed" : "cursor-pointer"}"
                    data-date="${dateStr}"
                    data-disabled="${isDisabled ? 1 : 0}">
                    ${d}
                    ${dotHtml}
                  </div>
                </div>`;
              }

              const headerHtml = dayLabels.map((l, i) => {
                const labelColor = (i === 0 || i === 6) ? "text-[#8B0000]/40" : "text-[#333333]";
                return `<div class="text-center text-[10px] font-bold ${labelColor} uppercase tracking-widest">${l}</div>`;
              }).join("");

              document.getElementById("calendarSkeletonContainer").innerHTML = `
              <div class="h-full flex flex-col select-none">
                <div class="flex items-center justify-between mb-8">
                  <button onclick="changeMonth(-1)"
                    class="w-8 h-8 flex items-center justify-center rounded-full
                          hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                  </button>
                  <div class="text-center">
                    <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
                    <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
                  </div>
                  <button onclick="changeMonth(1)"
                    class="w-8 h-8 flex items-center justify-center rounded-full
                          hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                  </button>
                </div>
                <hr class="border-t border-gray-200 mb-4">

                <div class="grid grid-cols-7 gap-2 mt-4 mb-2">${headerHtml}</div>
                <div class="grid grid-cols-7 space-y-4 gap-2 flex-1 content-start">${cells}</div>
              </div>
            `;

              document.querySelectorAll('#calendarSkeletonContainer [data-date]').forEach(el => {
                el.addEventListener("click", () => {
                  if (el.dataset.disabled === "1") return;

                  const picked = el.dataset.date;
                  selectDate(picked); // uses your existing booking flow
                });
              });
            }

            window.changeMonth = function(dir) {
              currentMonth += dir;
              if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
              }
              if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
              }
              renderCalendar(currentYear, currentMonth);
            };

            renderCalendar(currentYear, currentMonth);
          }

          const todayDate = new Date();
          todayDate.setHours(0, 0, 0, 0);

          function selectDate(iso) {
            selectedDate = iso;
            selectedTime = null;

            const dateInput = document.getElementById("appointment_date");
            const timeInput = document.getElementById("appointment_time");
            if (dateInput) dateInput.value = iso;
            if (timeInput) timeInput.value = "";

            const banner = document.getElementById("dateBanner");
            if (banner) {
              const [y, m, d] = iso.split("-");
              const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
              banner.innerHTML = `<i class="fa-regular fa-calendar mr-2"></i>${months[parseInt(m) - 1]} ${parseInt(d)}, ${y}`;
              banner.classList.add("show");
            }

            document.querySelectorAll("#calendarSkeletonContainer [data-date]").forEach(el => {
              el.classList.remove("bg-[#8B0000]", "text-white", "font-extrabold");

              if (el.dataset.disabled !== "1") {
                el.classList.add("text-[#333333]");
                el.classList.add("hover:bg-[#FFF0F0]");
              }

              if (el.dataset.date === iso) {
                el.classList.add("bg-[#8B0000]", "text-white", "font-extrabold");
                el.classList.remove("text-[#333333]");
                el.classList.remove("hover:bg-[#FFF0F0]");
              }
            });

            renderSlots();
          }

          function renderSlots() {
            const slotPlaceholder = document.getElementById("slotPlaceholder");
            const slotContainer = document.getElementById("slotContainer");
            const selectedSlotDisplay = document.getElementById("selectedSlotDisplay");
            const selectedSlotText = document.getElementById("selectedSlotText");
            const slotGrid = document.getElementById("slotGrid");
            const banner = document.getElementById("dateBanner");

            if (!slotGrid) return;

            if (slotPlaceholder) slotPlaceholder.classList.add("hidden");
            if (slotContainer) slotContainer.classList.remove("hidden");
            if (selectedSlotDisplay) selectedSlotDisplay.classList.add("hidden");
            if (selectedSlotText) selectedSlotText.textContent = "";
            slotGrid.innerHTML = "";

            const takenToday = apptCounts?.[selectedDate] ?? 0;
            const remaining = Math.max(0, MAX_PER_DAY - takenToday);
            const dayIsFull = remaining <= 0;

            const takenTimes = apptSlotCounts?.[selectedDate] ?? {};

            /* =========================
               SHOW REMAINING IN BANNER
            ========================= */
            if (banner && selectedDate) {
              const [y, m, d] = selectedDate.split("-");
              const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

              let slotColorClass = "text-emerald-300";

              if (remaining <= 3) {
                slotColorClass = "text-yellow-300 font-semibold";
              }

              banner.innerHTML = `
            <i class="fa-regular fa-calendar mr-2"></i>
            ${months[parseInt(m) - 1]} ${parseInt(d)}, ${y}
            <span class="ml-2 text-sm ${slotColorClass}">
              (${remaining} / ${MAX_PER_DAY} slots left)
            </span>
          `;
              banner.classList.add("show");
            }

            /* =========================
               RENDER TIME CHIPS
            ========================= */
            allSlots.forEach(slot => {
              const chip = document.createElement("div");

              const timeIsTaken = (takenTimes?.[slot.t] ?? 0) >= 1;
              const chipIsDisabled = dayIsFull || timeIsTaken || !slot.available;

              chip.className = "slot-chip" + (chipIsDisabled ? " full" : "");
              chip.textContent = chipIsDisabled ? `${slot.t} – Full` : slot.t;

              if (!chipIsDisabled) {
                chip.addEventListener("click", () => {
                  slotGrid.querySelectorAll(".slot-chip").forEach(c => c.classList.remove("selected"));
                  chip.classList.add("selected");

                  selectedTime = slot.t;

                  const timeInput = document.getElementById("appointment_time");
                  if (timeInput) timeInput.value = slot.t;

                  if (selectedSlotText) selectedSlotText.textContent = slot.t;
                  if (selectedSlotDisplay) selectedSlotDisplay.classList.remove("hidden");
                });
              }

              slotGrid.appendChild(chip);
            });
          }

          /* =========================
             OTHERS MODAL (SAFE)
          ========================= */
          const othersModal = document.getElementById("othersModal");
          const othersInput = document.getElementById("service_others_text");
          const othersRadio = document.querySelector('input[name="service_type"][value="Others"]');

          if (othersRadio && othersModal && othersInput) {
            othersRadio.addEventListener("change", function() {
              othersInput.required = true;
              othersModal.showModal();
              setTimeout(() => othersInput.focus(), 100);
            });
          }

          const othersConfirmBtn = document.getElementById("othersConfirmBtn");
          if (othersConfirmBtn && othersModal && othersInput) {
            othersConfirmBtn.addEventListener("click", () => {
              if (!othersInput.value.trim()) {
                othersInput.classList.add("input-error", "shake");
                setTimeout(() => othersInput.classList.remove("shake"), 300);
                return;
              }
              othersModal.close();
            });
          }

          const othersCancelBtn = document.getElementById("othersCancelBtn");
          if (othersCancelBtn && othersModal && othersInput) {
            othersCancelBtn.addEventListener("click", () => {
              othersInput.value = "";
              othersInput.required = false;
              othersModal.close();
              if (othersRadio) othersRadio.checked = false;
            });
          }

          /* =========================
             DATE PICKERS
          ========================= */
          function initMiniDatePicker(id) {
            const el = document.getElementById(id);
            if (!el) return;

            new Pikaday({
              field: el,
              maxDate: new Date(),
              yearRange: [1950, new Date().getFullYear()],
              showMonthAfterYear: true,
              firstDay: 1,
              onSelect: function(date) {
                el.value = date.toISOString().split('T')[0];
              }
            });
          }

          initMiniDatePicker('lastDentalVisit');
          initMiniDatePicker('extractionDate');
          initMiniDatePicker('denturesDate');
          initMiniDatePicker('orthoDate');
          initMiniDatePicker('medicalExamDate');

          /* =========================
             STEPPER LOGIC
          ========================= */
          let step = 0;
          const steps = document.querySelectorAll(".step-content");
          const indicators = document.querySelectorAll(".step");

          const navBtns = document.getElementById("navBtns");
          const prevBtn = document.getElementById("prevBtn");
          const nextBtn = document.getElementById("nextBtn");

          /* ✅ Step 5 sections */
          const summarySection = document.getElementById("summarySection");
          const confirmationSection = document.getElementById("confirmationSection");

          /* ✅ Step 5 buttons */
          const summaryBackBtn = document.getElementById("summaryBackBtn");
          const goToConfirmationBtn = document.getElementById("goToConfirmationBtn");
          const confirmationBackBtn = document.getElementById("confirmationBackBtn");

          /* ✅ Final confirm + submit */
          const finalSubmitBtn = document.getElementById("finalSubmitBtn");
          const finalConfirm = document.getElementById("finalConfirm");

          let completedSteps = [];

          function resetStep5View() {
            if (summarySection) summarySection.classList.remove("hidden");
            if (confirmationSection) confirmationSection.classList.add("hidden");
          }

          // init
          showStep(0);
          setTimeout(() => steps[0]?.classList.add("show"), 50);

          function showStep(i) {
            steps.forEach((s, idx) => {
              if (idx === i) {
                s.classList.remove("hidden");
                setTimeout(() => s.classList.add("show"), 50);
              } else {
                s.classList.remove("show");
                s.classList.add("hidden");
              }
            });

            indicators.forEach((ind, idx) => {
              ind.querySelectorAll(".in-progress").forEach((el) => el.remove());
              if (idx >= i) {
                const completedText = ind.querySelector(".completed-text");
                if (completedText) completedText.remove();
              }

              ind.classList.remove("step-success", "step-primary", "in-progress-step");
              ind.style.color = "";
              ind.style.fontWeight = "";

              if (idx < i && completedSteps.includes(idx)) {
                ind.classList.add("step-success");
                ind.style.color = "#16a34a";
                ind.style.fontWeight = "700";

                if (!ind.querySelector(".completed-text")) {
                  const completedText = document.createElement("span");
                  completedText.className = "completed-text";
                  completedText.textContent = "Completed";
                  ind.appendChild(completedText);
                  setTimeout(() => completedText.classList.add("show"), 50);
                }
              }

              if (idx === i) {
                ind.classList.add("step-primary", "in-progress-step");
                ind.style.color = "#2563eb";
                ind.style.fontWeight = "700";

                const span = document.createElement("span");
                span.className = "in-progress";
                span.textContent = "In Progress";
                ind.appendChild(span);
                setTimeout(() => span.classList.add("show"), 50);
              }
            });

            const isLast = i === steps.length - 1;

            if (navBtns) navBtns.style.display = isLast ? "none" : "flex";
            if (prevBtn) prevBtn.style.display = i === 0 ? "none" : "inline-flex";
            if (nextBtn) nextBtn.style.display = isLast ? "none" : "inline-flex";

            if (isLast) {
              buildSummary();
              resetStep5View();
            }

            document.querySelector(".max-w-4xl")?.scrollIntoView({
              behavior: "smooth"
            });
            step = i;
          }

          /* =========================
             VALIDATION
          ========================= */
          function isStepComplete(currentStep) {
            const stepEl = steps[currentStep];
            if (!stepEl) return true;

            if (currentStep === 0) {
              const dateVal = document.getElementById("appointment_date")?.value;
              const timeVal = document.getElementById("appointment_time")?.value;

              if (!dateVal) {
                showMiniTab("Please select a date first.");
                return false;
              }
              if (!timeVal) {
                showMiniTab("Please select a time slot.");
                return false;
              }
            }

            const fields = stepEl.querySelectorAll(
              "input[required]:not([type='radio']):not([type='checkbox']), select[required], textarea[required]"
            );
            for (const input of fields) {
              if (!input.value || !input.value.trim()) return false;
            }

            const requiredCheckboxes = stepEl.querySelectorAll("input[type='checkbox'][required]");
            for (const cb of requiredCheckboxes) {
              if (!cb.checked) return false;
            }

            const radios = stepEl.querySelectorAll("input[type='radio']");
            if (radios.length) {
              const groups = [...new Set([...radios].map((r) => r.name))];
              for (const name of groups) {
                if (!stepEl.querySelector(`input[name="${name}"]:checked`)) return false;
              }
            }

            const contactInput = stepEl.querySelector("#emergency_number");
            if (contactInput) {
              const value = contactInput.value.trim();
              if (!/^\d{1,11}$/.test(value)) {
                showMiniTab("Emergency Contact must be 1–11 digits only!");
                contactInput.focus();
                return false;
              }
            }

            return true;
          }

          /* =========================
             NEXT / PREV (Steps 1-4)
          ========================= */
          if (nextBtn) {
            nextBtn.addEventListener("click", () => {
              if (!isStepComplete(step)) {
                showMiniTab("Please complete all required fields before proceeding.");
                return;
              }
              if (!completedSteps.includes(step)) completedSteps.push(step);

              const nextIndex = Math.min(step + 1, steps.length - 1);
              showStep(nextIndex);
            });
          }

          if (prevBtn) {
            prevBtn.addEventListener("click", () => {
              const prevIndex = Math.max(step - 1, 0);
              showStep(prevIndex);
            });
          }

          /* =========================
             STEP 5 FLOW
          ========================= */
          if (summaryBackBtn) {
            summaryBackBtn.addEventListener("click", () => {
              showStep(3); // back to step 4
            });
          }

          if (goToConfirmationBtn) {
            goToConfirmationBtn.addEventListener("click", () => {
              if (summarySection) summarySection.classList.add("hidden");
              if (confirmationSection) confirmationSection.classList.remove("hidden");
              confirmationSection?.scrollIntoView({
                behavior: "smooth",
                block: "start"
              });
            });
          }

          if (confirmationBackBtn) {
            confirmationBackBtn.addEventListener("click", () => {
              if (confirmationSection) confirmationSection.classList.add("hidden");
              if (summarySection) summarySection.classList.remove("hidden");
              summarySection?.scrollIntoView({
                behavior: "smooth",
                block: "start"
              });
            });
          }

          /* =========================
             SUMMARY BUILDER
          ========================= */
          function buildSummary() {
            const form = document.getElementById("appointmentForm");
            if (!form) return;

            const data = new FormData(form);

            const date = document.getElementById("appointment_date")?.value || "N/A";
            const time = document.getElementById("appointment_time")?.value || "N/A";

            const get = (name) => data.get(name) || "N/A";
            const getAll = (name) => data.getAll(name);

            const selectedRelation = data.get("emergency_relation") || "";
            const typedRelation = (data.get("relation_other") || "").trim();
            const emergencyRelation =
              selectedRelation === "Others" ? typedRelation || "Others" : selectedRelation || "N/A";

            const signatureFile = data.get("patient_signature");
            let signatureHTML = "Not uploaded";
            if (signatureFile && signatureFile.size > 0) {
              const imageUrl = URL.createObjectURL(signatureFile);
              signatureHTML = `<img src="${imageUrl}" alt="Signature" style="max-width: 250px; max-height: 150px; border: 1px solid #8B0000; border-radius: 8px;">`;
            }

            const card = (title, body) => `
    <div class="border-2 border-[#8B0000] rounded-xl p-4 bg-white">
      <h3 class="font-bold text-[#8B0000] mb-3">${title}</h3>
      <div class="space-y-1 text-sm">${body}</div>
    </div>
  `;

            const html = `
    <div class="space-y-6">
      ${card("Appointment Details", `
        <p><b>Date:</b> ${date}</p>
        <p><b>Time:</b> ${time}</p>
      `)}

      ${card("Service", `
        <p>${get("service_type") === "Others" ? "Others – " + (get("service_others_text") || "N/A") : get("service_type")}</p>
      `)}

      ${card("Dental History", `
        <p><b>Last Dental Visit:</b> ${get("last_dental_visit")}</p>
        <p><b>Bleeding Gums:</b> ${get("bleeding_gums")}</p>
        <p><b>Sensitive to Hot/Cold:</b> ${get("sensitive_temp")}</p>
        <p><b>Sensitive to Sweets:</b> ${get("sensitive_taste")}</p>
        <p><b>Tooth Pain:</b> ${get("tooth_pain")}</p>
        <p><b>Sores/Lumps:</b> ${get("sores")}</p>
        <p><b>Jaw Injuries:</b> ${get("injuries")}</p>
        <p><b>Clicking Jaw:</b> ${get("clicking")}</p>
        <p><b>Joint Pain:</b> ${get("joint_pain")}</p>
        <p><b>Difficulty Chewing:</b> ${get("difficulty_chewing")}</p>
        <p><b>Headaches:</b> ${get("jaw_headaches")}</p>
        <p><b>Grinding/Clenching:</b> ${get("clench_grind")}</p>
        <p><b>Food Caught Between Teeth:</b> ${get("food_teeth")}</p>
        <p><b>Medicine Reaction:</b> ${get("med_reaction")}</p>
        <p><b>Additional Concerns:</b><br>${get("additional_concerns")}</p>
      `)}

      ${card("Medical History", `
        <p><b>Good Health:</b> ${get("good_health")}</p>
        <p><b>Last Medical Exam Date:</b> ${get("medical_exam_date")}</p>
        <p><b>Under Treatment:</b> ${get("under_treatment")}</p>
        <p><b>Hospitalized:</b> ${get("hospitalized")}</p>
        <p><b>Allergy (Medicine):</b> ${get("allergy_medicine")}</p>
        <p><b>Allergy (Food):</b> ${get("allergy_food")}</p>
        <p><b>Medication:</b> ${get("medication")}</p>
        <p><b>Medical Conditions:</b><br>
          ${getAll("conditions[]").length ? getAll("conditions[]").join(", ") : "None"}
        </p>
        <p><b>Tobacco Use:</b> ${get("tobacco_use")}</p>
      `)}

      ${card("Emergency Contact", `
        <p><b>Name:</b> ${get("emergency_person")}</p>
        <p><b>Contact:</b> ${get("emergency_number")}</p>
        <p><b>Relation:</b> ${emergencyRelation}</p>
      `)}

      ${card("Signature", signatureHTML)}
    </div>
  `;

            const summaryBox = document.getElementById("summaryBox");
            if (summaryBox) summaryBox.innerHTML = html;
          }

          /* =========================
             MODAL (FINAL SUBMIT)
          ========================= */
          /* =========================
             MODAL (FINAL SUBMIT)
          ========================= */
          const confirmModal = document.getElementById("confirmModal");
          const confirmMessage = document.getElementById("confirmMessage");
          const okBtn = document.getElementById("okBtn");

          if (finalSubmitBtn) {
            finalSubmitBtn.addEventListener("click", () => {
              if (!finalConfirm || !finalConfirm.checked) {
                showMiniTab("Please confirm before submitting.");
                return;
              }

              const date = document.getElementById("appointment_date")?.value || "N/A";
              const time = document.getElementById("appointment_time")?.value || "N/A";

              if (confirmMessage) {
                confirmMessage.innerHTML = `
        Your dental appointment at PUP Taguig Dental Clinic has been successfully scheduled on 
        <b>${date}</b> at <b>${time}</b>.<br>
        Please arrive on time and bring your school or office ID.
        <br>
      `;
              }

              // show modal first
              confirmModal?.showModal();
            });
          }

          if (okBtn) {
            okBtn.addEventListener("click", () => {
              clearDraft();
              formSubmitting = true;
              document.getElementById("appointmentForm").submit();
            });
          }

          // prevent default form submit refresh (kept since you're using modal instead of real submit)
          //const appointmentForm = document.getElementById("appointmentForm");
          //if (appointmentForm) {
          //appointmentForm.addEventListener("submit", (e) => e.preventDefault());
          //}

          /* =========================
             EXTRA TOGGLES
          ========================= */
          const questions = [{
              name: "difficult_extraction",
              boxId: "extraction_date_box"
            },
            {
              name: "dentures",
              boxId: "dentures_date_box"
            },
            {
              name: "ortho_treatment",
              boxId: "ortho_date_box"
            },
          ];

          questions.forEach((q) => {
            const radios = document.getElementsByName(q.name);
            const box = document.getElementById(q.boxId);
            if (!box || !radios.length) return;

            const input = box.querySelector("input");

            radios.forEach((radio) => {
              radio.addEventListener("change", () => {
                if (radio.checked && radio.value === "Yes") {
                  box.classList.remove("hidden");
                  if (input) input.required = true;
                } else if (radio.checked) {
                  box.classList.add("hidden");
                  if (input) {
                    input.required = false;
                    input.value = "";
                  }
                }
              });
            });
          });

          const medicalExamRadios = document.querySelectorAll('input[name="had_medical_exam"]');
          const medicalExamBox = document.getElementById("medical_exam_box");

          if (medicalExamRadios.length && medicalExamBox) {
            medicalExamRadios.forEach((radio) => {
              radio.addEventListener("change", () => {
                if (radio.value === "Yes" && radio.checked) medicalExamBox.classList.remove("hidden");
                if (radio.value === "No" && radio.checked) medicalExamBox.classList.add("hidden");
              });
            });
          }

          const relationSelect = document.getElementById("emergency_relation");
          const otherInput = document.getElementById("relation_other");

          if (relationSelect && otherInput) {
            relationSelect.addEventListener("change", function() {
              if (this.value === "Others") {
                otherInput.classList.remove("hidden");
                otherInput.setAttribute("required", "true");
              } else {
                otherInput.classList.add("hidden");
                otherInput.removeAttribute("required");
                otherInput.value = "";
              }
            });
          }

          const medicalToggles = [{
              name: "good_health",
              boxId: "good_health_box",
              showOn: "No"
            },
            {
              name: "under_treatment",
              boxId: "treatment_box",
              showOn: "Yes"
            },
            {
              name: "hospitalized",
              boxId: "hospital_box",
              showOn: "Yes"
            },
            {
              name: "medication",
              boxId: "medication_box",
              showOn: "Yes"
            },
          ];

          medicalToggles.forEach((item) => {
            const radios = document.getElementsByName(item.name);
            const box = document.getElementById(item.boxId);
            if (!box || !radios.length) return;

            radios.forEach((radio) => {
              radio.addEventListener("change", () => {
                const selected = [...radios].find((r) => r.checked);
                const inputs = box.querySelectorAll("input");

                if (selected && selected.value === item.showOn) {
                  box.classList.remove("hidden");
                  inputs.forEach((i) => (i.required = true));
                } else {
                  box.classList.add("hidden");
                  inputs.forEach((i) => {
                    i.required = false;
                    i.value = "";
                  });
                }
              });
            });
          });

          // Tobacco details
          const tobaccoRadios = document.getElementsByName("tobacco_use");
          const tobaccoDetails = document.getElementById("tobacco_details");
          if (tobaccoDetails && tobaccoRadios.length) {
            tobaccoRadios.forEach((radio) => {
              radio.addEventListener("change", () => {
                if (radio.checked && radio.value === "Yes") tobaccoDetails.classList.remove("hidden");
                else tobaccoDetails.classList.add("hidden");
              });
            });
          }

          // Signature filename display
          const signatureInput = document.getElementById("patient_signature");
          const signatureFileName = document.getElementById("signature_filename");
          if (signatureInput && signatureFileName) {
            signatureInput.addEventListener("change", () => {
              if (signatureInput.files.length > 0) {
                signatureFileName.textContent = signatureInput.files[0].name;
                signatureFileName.classList.remove("hidden");
              } else {
                signatureFileName.textContent = "";
                signatureFileName.classList.add("hidden");
              }
            });
          }

          // Emergency number formatting
          const emergencyNumber = document.getElementById("emergency_number");
          if (emergencyNumber) {
            emergencyNumber.addEventListener("input", (e) => {
              const rawValue = e.target.value;

              if (/[^0-9]/.test(rawValue)) {
                showMiniTab("Contact number must contain digits only.");
                showInputError(emergencyNumber);
                emergencyNumber.classList.remove("input-valid");
              }

              let value = rawValue.replace(/\D/g, "");
              if (value.startsWith("9")) value = "0" + value;

              value = value.slice(0, 11);
              emergencyNumber.value = value;

              if (/^09\d{9}$/.test(value)) {
                emergencyNumber.classList.remove("input-error");
                emergencyNumber.classList.add("input-valid");
              } else {
                emergencyNumber.classList.remove("input-valid");
              }
            });

            emergencyNumber.addEventListener("blur", () => {
              if (emergencyNumber.value === "") {
                emergencyNumber.classList.remove("input-error", "input-valid");
              }
            });
          }

          /* =========================
  LEAVE / RELOAD WARNING (DRAFT MODAL)
========================= */
          let formIsDirty = false;
          let formSubmitting = false;

          const formEl = document.getElementById("appointmentForm");

          const leaveModal = document.getElementById("leaveModal");
          const saveDraftBtn = document.getElementById("saveDraftBtn");
          const discardDraftBtn = document.getElementById("discardDraftBtn");

          let pendingNavigation = null;

          function markDirty() {
            if (!formSubmitting) formIsDirty = true;
          }
          formEl?.addEventListener("change", markDirty);
          formEl?.addEventListener("input", markDirty);

          function openLeaveModal(onConfirm) {
            pendingNavigation = onConfirm;
            leaveModal?.showModal();
          }

          saveDraftBtn?.addEventListener("click", () => {
            saveDraft();
            leaveModal?.close();

            formSubmitting = true;
            formIsDirty = false;

            if (typeof pendingNavigation === "function") pendingNavigation();
            pendingNavigation = null;
          });

          discardDraftBtn?.addEventListener("click", () => {
            clearDraft();
            leaveModal?.close();

            formSubmitting = true;
            formIsDirty = false;

            if (typeof pendingNavigation === "function") pendingNavigation();
            pendingNavigation = null;
          });

          document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener("click", (e) => {
              const href = link.getAttribute("href") || "";
              if (href.startsWith("#") || href.startsWith("javascript:")) return;

              if (formIsDirty && !formSubmitting) {
                e.preventDefault();
                openLeaveModal(() => window.location.href = link.href);
              }
            });
          });

          (function trapBackButton() {
            history.pushState({
              page: "book-appointment"
            }, "", window.location.href);

            window.addEventListener("popstate", () => {
              if (formIsDirty && !formSubmitting) {
                openLeaveModal(() => history.back());
                history.pushState({
                  page: "book-appointment"
                }, "", window.location.href);
              }
            });
          })();

          window.addEventListener("beforeunload", (e) => {
            if (formIsDirty && !formSubmitting) {
              e.preventDefault();
              e.returnValue = "";
            }
          });

          document.addEventListener("DOMContentLoaded", () => {
            loadCalendar();
            restoreDraft();
          });
        </script>
</body>

</html>