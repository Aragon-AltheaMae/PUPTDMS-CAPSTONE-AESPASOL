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
      background-color: #F4F4F4;
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
      background-color: #2563eb; /* Blue */
    }

    .step.step-success::before {
      background-color: #16a34a; /* Green */
    }

    /* Blue color for the current step */
    .step.in-progress-step::before {
      background-color: #2563eb !important; /* Blue circle */
    }

    /* Blue text for the current step */
    .step.in-progress-step {
      color: #2563eb !important;
    }

    .step-card {
    background-color: #ffffff;
    border: 2px solid #8B0000;
    border-radius: 1rem;
    padding: 2rem;
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
    color: #8B0000;
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

  .cal-grid .day-cell.disabled { color: #ccc; cursor: not-allowed; }
  .cal-grid .day-cell.other-month { color: #ddd; cursor: default; }
  .cal-grid .day-cell.today { font-weight: 800; color: #8B0000; }
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

  .cal-nav-btn:hover { background: #f0d6d6; }
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

  .slot-chip:hover:not(.full) { background: #f0d6d6; }
  .slot-chip.selected { background: #8B0000; color: #fff; }
  .slot-chip.full { border-color: #ccc; color: #999; cursor: not-allowed; text-decoration: line-through; }
  .date-banner {
    background: #8B0000;
    color: #fff;
    border-radius: 0.6rem;
    padding: 0.6rem 1.2rem;
    font-size: 0.9rem;
    font-weight: 600;
    display: none;
  }
  .date-banner.show { display: block; }

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
  border: 2px solid #16a34a !important; /* green */
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
  .delay-1 { animation-delay: 0.1s; }
  .delay-2 { animation-delay: 0.2s; }
  .delay-3 { animation-delay: 0.3s; }
  .delay-4 { animation-delay: 0.4s; }

  @keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    50% { transform: translateX(4px); }
    75% { transform: translateX(-4px); }
    100% { transform: translateX(0); }
  }

  .shake {
    animation: shake 0.3s ease-in-out;
  }
  </style>
</head>

<body class="bg-white">

<!-- HEADER -->
<div class="bg-gradient-to-r from-red-900 to-red-700 text-white px-6 py-4 flex items-center justify-between">
  <a href="{{ route('homepage') }}" class="flex items-center gap-3">
    <div class="w-12 ml-5">
      <img src="images/PUP.png" alt="PUP Logo">
    </div>
    <div class="w-12">
      <img src="images/PUPT-DMS-Logo.png" alt="Clinic Logo">
    </div>
    <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
  </a>

  <a href="{{ route('homepage') }}" class="flex items-center gap-2 bg-white text-red-700 px-3 py-1 rounded-lg hover:bg-gray-100 transition">
    <span class="font-semibold text-sm">Back to Home</span>
  </a>
</div>

<h1 class="text-4xl font-extrabold m-12 text-[#660000] text-center">
  Book an Appointment
</h1>

<!-- MAIN FORM -->
<div class="max-w-4xl mx-auto p-8 bg-[#ECECEC] rounded-xl mt-5 mb-12 shadow-xl">
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
  <h2 class="text-2xl font-extrabold mb-6 text-[#660000] border-b-2 border-[#660000] pb-2 mb-10">
    Select Date and Time
  </h2>

  <!-- Hidden inputs keep same names for form submission -->
  <input type="hidden" id="appointment_date" name="appointment_date">
  <input type="hidden" id="appointment_time" name="appointment_time">

  <div class="flex flex-col gap-6">

    <!-- CALENDAR -->
    <div class="bg-white border-2 border-[#8B0000] rounded-2xl p-4 flex-shrink-0 mx-auto" style="width: 650px;">
      <div class="flex items-center justify-between mb-4">
        <button class="cal-nav-btn" id="prevMonth" type="button">&#8249;</button>
        <span id="monthLabel" class="font-bold text-[#8B0000] text-base tracking-wide"></span>
        <button class="cal-nav-btn" id="nextMonth" type="button">&#8250;</button>
      </div>
      <div class="cal-grid mb-1">
        <div class="day-header">Sun</div>
        <div class="day-header">Mon</div>
        <div class="day-header">Tue</div>
        <div class="day-header">Wed</div>
        <div class="day-header">Thu</div>
        <div class="day-header">Fri</div>
        <div class="day-header">Sat</div>
      </div>
      <div class="cal-grid" id="calDays"></div>
    </div>

    <!-- TIME SLOTS -->
    <div class="flex-1 w-full">
      <label class="text-sm font-bold text-[#8B0000] block mb-3">Available Time Slots</label>
      <div class="date-banner mb-4" id="dateBanner"></div>
      <div id="slotContainer" class="hidden">
        <p class="text-xs text-gray-500 mb-3 italic">Click a slot to select your preferred time.</p>
        <div class="flex flex-wrap gap-2" id="slotGrid"></div>
        <div id="selectedSlotDisplay" class="mt-4 text-sm font-semibold text-[#8B0000] hidden">
          <i class="fa-regular fa-clock mr-1"></i> Selected: <span id="selectedSlotText"></span>
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

  <div class="grid grid-cols-1 md:grid-cols-2 pt-6 gap-6">

    <!-- Card 1 -->
    <label class="cursor-pointer group">
      <input type="radio" name="service_type" value="Oral Check-up" class="hidden peer" required>
      <div class="bg-[#ECECEC] rounded-xl p-6 border-2 border-[#8B0000]
                  peer-checked:bg-[#8B0000] peer-checked:text-[#F4F4F4]
                  hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  shadow-md hover:shadow-xl
                  transition-all duration-200 ease-in
                  animate-fade-up delay-1">
        <div class="flex flex-col items-center text-center gap-3">
          <div class="w-24 h-24 bg-transparent flex items-center justify-center">
            <img src="images/oral-checkup.png"/>
          </div>
          <h3 class="font-bold text-xl text-[#660000] text-current">Oral Check-Up</h3>
          <p class="text-sm text-current">
            Routine oral examination • Dental Consultation
          </p>
        </div>
      </div>
    </label>

    <!-- Card 2 -->
    <label class="cursor-pointer group">
      <input type="radio" name="service_type" value="Dental Cleaning" class="hidden peer">
      <div class="bg-[#ECECEC] rounded-xl p-6 border-2 border-[#8B0000]
                  peer-checked:bg-[#8B0000] peer-checked:text-[#F4F4F4]
                  hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  shadow-md hover:shadow-xl
                  transition-all duration-200 ease-in
                  animate-fade-up delay-2">
        <div class="flex flex-col items-center text-center gap-3">
          <div class="w-24 h-24 rounded-full flex items-center justify-center">
            <img src="images/dental-cleaning.png"/>
          </div>
          <h3 class="font-bold text-xl text-[#660000] text-current">Dental Cleaning</h3>
          <p class="text-sm text-current">
            Oral hygiene treatment • Removing surface buildup
          </p>
        </div>
      </div>
    </label>

    <!-- Card 3 -->
    <label class="cursor-pointer group">
      <input type="radio" name="service_type" value="Restoration & Prosthesis" class="hidden peer">
      <div class="bg-[#ECECEC] rounded-xl p-6 border-2 border-[#8B0000]
                  peer-checked:bg-[#8B0000] peer-checked:text-[#F4F4F4]
                  hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  shadow-md hover:shadow-xl
                  transition-all duration-200 ease-in
                  animate-fade-up delay-3">
        <div class="flex flex-col items-center text-center gap-3">
          <div class="w-24 h-24 rounded-full flex items-center justify-center">
            <img src="images/restoration-prosthesis.png"/>
          </div>
          <h3 class="font-bold text-xl text-[#660000] text-current">Restoration & Prosthesis</h3>
          <p class="text-sm text-current">
           Repairs/replaces damaged teeth • Fillings<br>• Crowns • Bridges
          </p>
        </div>
      </div>
    </label>

    <!-- Card 4 -->
    <label class="cursor-pointer group">
      <input type="radio" name="service_type" value="Dental Surgery" class="hidden peer">
      <div class="bg-[#ECECEC] rounded-xl p-6 border-2 border-[#8B0000]
                  peer-checked:bg-[#8B0000] peer-checked:text-[#F4F4F4]
                  hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  shadow-md hover:shadow-xl
                  transition-all duration-200 ease-in
                  animate-fade-up delay-4">
        <div class="flex flex-col items-center text-center gap-3">
          <div class="w-24 h-24 rounded-full flex items-center justify-center">
            <img src="images/dental-surgery.png"/>
          </div>
          <h3 class="font-bold text-xl text-[#660000] text-current">Dental Surgery</h3>
          <p class="text-sm text-current">
            Treating dental issues surgically<br>• Extraction • Implants
          </p>
        </div>
      </div>
    </label>

    <!-- Card 5 -->
    <div class="col-span-1 md:col-span-2 flex justify-center">
    <label class="cursor-pointer group w-1/2">
      <input type="radio" name="service_type" value="Others" class="hidden peer">
      <div class="bg-[#ECECEC] rounded-xl p-6 border-2 border-[#8B0000]
                  peer-checked:bg-[#8B0000] peer-checked:text-[#F4F4F4]
                  hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  shadow-md hover:shadow-xl
                  transition-all duration-200 ease-in
                  animate-fade-up delay-4">
        <div class="flex flex-col items-center text-center gap-3">
          <div class="w-32 h-32 rounded-full flex items-center justify-center">
            <img src="images/dental-others.png"/>
          </div>
          <h3 class="font-bold text-xl text-[#660000] text-current">Others</h3>
          <p class="text-sm text-current">
            Can't find your service? Let us know what you need.
          </p>
        </div>
      </div>
    </label>
    </div>
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
            required
          >
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
      readonly
    >
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
      readonly
    >
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
      readonly
    >
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
          placeholder="Input here"
      >
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
          readonly
        >
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
          placeholder="Input here"
        >
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
          placeholder="Input here"
        >
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
          class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto"required>
        <input type="radio" name="allergy_food" value="No"
          class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
      </div>

      <div class="ml-8">
        <label class="text-xs italic text-[#8B0000]">Others (please specify):</label>
        <input 
          type="text" 
          name="allergy_others" 
          class="input input-sm border-[#8B0000] w-60"
          placeholder="Input here"
        >
      </div>
    </div>

    <!-- MEDICATION -->
    <div class="grid grid-cols-[1fr_60px_60px] items-center gap-4 text-sm mt-4">
      <span>Are you taking any prescription or non-prescription medication?</span>
      <input type="radio" name="medication" value="Yes"
        class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto"required>
      <input type="radio" name="medication" value="No"
        class="appearance-none w-4 h-4 border-2 border-[#8B0000] rounded-sm checked:bg-[#8B0000] mx-auto">
    </div>

    <div class="ml-8 hidden" id="medication_box">
      <label class="text-xs italic text-[#8B0000]">If YES, please specify:</label>
      <input 
        type="text" 
        name="medication_details" 
        class="input input-sm border-[#8B0000] w-full"
        placeholder="Input here" 
      >
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
      required
    >
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
      required
    >
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
      required
    >
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
      placeholder="Please specify relation"
      >
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
          required
        >
      </label>

      <p id="signature_filename" class="text-gray-600 text-xs truncate hidden"></p>

    </div>
  </div>
</div>

  </div>
</div>

 <!-- STEP 5 (CONFIRMATION) -->
<div class="step-content hidden" id="step5">
  <div class="bg-[#D9D9D9] shadow-xl rounded-xl p-10">

    <h2 class="text-3xl font-normal text-[#660000] mb-4">Confirmation</h2>
    <div class="h-[2px] w-full bg-[#8B0000] mb-8"></div>
    <div id="summaryBox" class="mb-8"></div>
    <label class="flex items-start gap-3 cursor-pointer select-none">
     
      <input
        id="finalConfirm"
        type="checkbox"
        class="mt-1 w-5 h-5 border border-[#8B0000] rounded bg-white accent-[#8B0000]"
        required
      />
      <span class="text-gray-700 text-sm leading-5">
        I hereby confirm that I have reviewed my dental and medical information and accepted
        the
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
        class="min-w-[110px] px-6 py-2 rounded border border-gray-500 bg-gray-200 text-[#8B0000] hover:bg-gray-300 transition shadow relative z-10"
      >
        &lsaquo; Back
      </button>

      <button
        type="button"
        id="finalSubmitBtn"
        class="min-w-[110px] px-6 py-2 rounded bg-[#8B0000] text-white hover:bg-[#7A0000] transition shadow"
      >
        Submit
      </button>
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
        maxlength="100"
      >
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

  <div class="bg-[#8B0000] text-white rounded-2xl p-10 max-w-md mx-auto text-center shadow-2xl">

    <h2 class="text-2xl font-semibold mb-6">
      Appointment Confirmed
    </h2>

    <p class="text-sm leading-6 mb-6" id="confirmMessage">
      <!-- JS will insert message here -->
    </p>

    <p class="mb-6">Thank you!</p>

     <!-- OK BUTTON WITH LARAVEL ROUTE -->
    <a href="{{ route('homepage') }}"
       class="inline-block bg-gray-200 text-[#8B0000] px-8 py-2 rounded shadow hover:bg-gray-300 transition">
       OK
    </a>

  </div>

</dialog>



<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script>
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

/* =========================
   DATA
========================= */
const holidays = ["2026-01-01", "2026-04-09"];
const allSlots = [
  { t: "9:00 AM", available: true },
  { t: "10:00 AM", available: true },
  { t: "11:00 AM", available: false },
  { t: "12:00 PM", available: true },
  { t: "1:00 PM", available: true },
  { t: "2:00 PM", available: true },
  { t: "3:00 PM", available: true },
];

/* -------- Calendar -------- */
let currentYear, currentMonth, selectedDate = null, selectedTime = null;
const todayDate = new Date(); todayDate.setHours(0,0,0,0);
currentYear  = todayDate.getFullYear();
currentMonth = todayDate.getMonth();

function pad(n) { return String(n).padStart(2, "0"); }
function formatISO(y, m, d) { return `${y}-${pad(m+1)}-${pad(d)}`; }

function isDisabled(date) {
  const day = date.getDay();
  const iso = formatISO(date.getFullYear(), date.getMonth(), date.getDate());
  return day === 0 || day === 6 || holidays.includes(iso) || date < todayDate;
}

function renderCalendar() {
  const MONTHS = ["January","February","March","April","May","June",
                  "July","August","September","October","November","December"];
  document.getElementById("monthLabel").textContent = `${MONTHS[currentMonth]} ${currentYear}`;
  const calDays = document.getElementById("calDays");
  calDays.innerHTML = "";

  const firstDay    = new Date(currentYear, currentMonth, 1).getDay();
  const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
  const prevDays    = new Date(currentYear, currentMonth, 0).getDate();

  for (let i = 0; i < firstDay; i++) {
    const cell = document.createElement("div");
    cell.className = "day-cell other-month";
    cell.textContent = prevDays - firstDay + 1 + i;
    calDays.appendChild(cell);
  }

  for (let d = 1; d <= daysInMonth; d++) {
    const date = new Date(currentYear, currentMonth, d);
    const iso  = formatISO(currentYear, currentMonth, d);
    const cell = document.createElement("div");
    cell.className = "day-cell";
    cell.textContent = d;

    if (isDisabled(date)) {
      cell.classList.add("disabled");
    } else {
      cell.addEventListener("click", () => selectDate(iso, cell));
    }

    const todayISO = formatISO(todayDate.getFullYear(), todayDate.getMonth(), todayDate.getDate());
    if (iso === todayISO) cell.classList.add("today");
    if (iso === selectedDate) cell.classList.add("selected");

    calDays.appendChild(cell);
  }

  const total = firstDay + daysInMonth;
  const trailing = total % 7 === 0 ? 0 : 7 - (total % 7);
  for (let i = 1; i <= trailing; i++) {
    const cell = document.createElement("div");
    cell.className = "day-cell other-month";
    cell.textContent = i;
    calDays.appendChild(cell);
  }
}

function selectDate(iso) {
  selectedDate = iso;
  selectedTime = null;
  document.getElementById("appointment_date").value = iso;
  document.getElementById("appointment_time").value = "";

  const [y, m, d] = iso.split("-");
  const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
  const banner = document.getElementById("dateBanner");
  banner.innerHTML = `<i class="fa-regular fa-calendar mr-2"></i>${months[parseInt(m)-1]} ${parseInt(d)}, ${y}`;
  banner.classList.add("show");

  renderCalendar();
  renderSlots();
}

function renderSlots() {
  document.getElementById("slotPlaceholder").classList.add("hidden");
  document.getElementById("slotContainer").classList.remove("hidden");
  document.getElementById("selectedSlotDisplay").classList.add("hidden");
  document.getElementById("selectedSlotText").textContent = "";

  const slotGrid = document.getElementById("slotGrid");
  slotGrid.innerHTML = "";

  const slotsForDate = allSlots.slice(0, 5);
  slotsForDate.forEach(slot => {
    const chip = document.createElement("div");
    chip.className = "slot-chip" + (slot.available ? "" : " full");
    chip.textContent = slot.available ? slot.t : `${slot.t} – Full`;

    if (slot.available) {
      chip.addEventListener("click", () => {
        slotGrid.querySelectorAll(".slot-chip").forEach(c => c.classList.remove("selected"));
        chip.classList.add("selected");
        selectedTime = slot.t;
        document.getElementById("appointment_time").value = slot.t;
        document.getElementById("selectedSlotText").textContent = slot.t;
        document.getElementById("selectedSlotDisplay").classList.remove("hidden");
      });
    }
    slotGrid.appendChild(chip);
  });
}

document.getElementById("prevMonth").addEventListener("click", () => {
  currentMonth--;
  if (currentMonth < 0) { currentMonth = 11; currentYear--; }
  renderCalendar();
});
document.getElementById("nextMonth").addEventListener("click", () => {
  currentMonth++;
  if (currentMonth > 11) { currentMonth = 0; currentYear++; }
  renderCalendar();
});

renderCalendar();
// Others modal
const othersModal = document.getElementById("othersModal");
const othersInput = document.getElementById("service_others_text");
const othersRadio = document.querySelector('input[name="service_type"][value="Others"]');

othersRadio.addEventListener("change", function() {
  othersInput.required = true;
  othersModal.showModal();
  setTimeout(() => othersInput.focus(), 100);
});

document.getElementById("othersConfirmBtn").addEventListener("click", () => {
  if (!othersInput.value.trim()) {
    othersInput.classList.add("input-error", "shake");
    setTimeout(() => othersInput.classList.remove("shake"), 300);
    return;
  }
  othersModal.close();
});

document.getElementById("othersCancelBtn").addEventListener("click", () => {
  othersInput.value = "";
  othersInput.required = false;
  othersModal.close();
  // Uncheck the Others radio
  othersRadio.checked = false;
});

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

/* -------- Step Logic with "In Progress" & Checkmarks -------- */
let step = 0;
const steps = document.querySelectorAll(".step-content");
const indicators = document.querySelectorAll(".step");

const navBtns = document.getElementById("navBtns");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

const confirmBackBtn = document.getElementById("confirmBackBtn");
const finalSubmitBtn = document.getElementById("finalSubmitBtn");
const finalConfirm = document.getElementById("finalConfirm");

let completedSteps = [];

// Initialize stepper on page load
  showStep(0);
  renderCalendar();
  setTimeout(() => {
    steps[0].classList.add("show");
  }, 50);


function showStep(i) {
  // show/hide content
  steps.forEach((s, idx) => {
    if (idx === i) {
      s.classList.remove("hidden");
      setTimeout(() => s.classList.add("show"), 50);
    } else {
      s.classList.remove("show");
      s.classList.add("hidden");
    }
  });

  // Stepper indicators (Completed / In Progress)
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

  // ✅ Hide bottom nav on Step 5
  const isLast = i === steps.length - 1;
  if (navBtns) navBtns.style.display = isLast ? "none" : "flex";

  // ✅ Bottom buttons only for Steps 1–4
  if (prevBtn) prevBtn.style.display = i === 0 ? "none" : "inline-flex";
  if (nextBtn) nextBtn.style.display = isLast ? "none" : "inline-flex";

  // build summary on last step
  if (isLast) buildSummary();

  // scroll
  const formWrap = document.querySelector(".max-w-4xl");
  if (formWrap) formWrap.scrollIntoView({ behavior: "smooth" });

  // keep step value synced
  step = i;
}

/* =========================
   VALIDATION
========================= */
function isStepComplete(currentStep) {
  const stepEl = steps[currentStep];
  if (!stepEl) return true;

  // Required text/select/textarea
  const fields = stepEl.querySelectorAll(
    "input[required]:not([type='radio']):not([type='checkbox']), select[required], textarea[required]"
  );
  for (const input of fields) {
    if (!input.value || !input.value.trim()) return false;
  }

  // Required checkboxes
  const requiredCheckboxes = stepEl.querySelectorAll("input[type='checkbox'][required]");
  for (const cb of requiredCheckboxes) {
    if (!cb.checked) return false;
  }

  // Radios grouped
  const radios = stepEl.querySelectorAll("input[type='radio']");
  if (radios.length) {
    const groups = [...new Set([...radios].map((r) => r.name))];
    for (const name of groups) {
      if (!stepEl.querySelector(`input[name="${name}"]:checked`)) return false;
    }
  }

  // Emergency Contact validation (digits only 1–11)
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
   NEXT / PREV HANDLERS
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

// Step 5 Back button (go back to Step 4)
if (confirmBackBtn) {
  confirmBackBtn.addEventListener("click", () => {
    const prevIndex = Math.max(step - 1, 0);
    showStep(prevIndex);
  });
}

/* =========================
   SUMMARY BUILDER
========================= */
function buildSummary() {
  const form = document.getElementById("appointmentForm");
  if (!form) return;

  const data = new FormData(form);

  const date = document.getElementById("appointment_date").value;
  const time = document.getElementById("appointment_time").value;

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
   MODAL (Step 5 Submit)
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
        Your dental appointment at PUP Taguig Dental Clinic
        has been successfully scheduled on <b>${date}</b> at <b>${time}</b>.
        Please arrive on time and bring your school or office ID.
      `;
    }

    confirmModal?.showModal();
  });
}

// OK button redirect
if (okBtn) {
  okBtn.addEventListener("click", () => {
    // ✅ Change this to your Blade route if you prefer:
    // window.location.href = "{{ route('homepage') }}";
    window.location.href = "/patient/dashboard";
  });
}

// prevent default form submit refresh
const form = document.getElementById("appointmentForm");
if (form) {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
  });
}

/* =========================
   EXTRA TOGGLES (kept)
========================= */
const questions = [
  { name: "difficult_extraction", boxId: "extraction_date_box" },
  { name: "dentures", boxId: "dentures_date_box" },
  { name: "ortho_treatment", boxId: "ortho_date_box" },
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

medicalExamRadios.forEach((radio) => {
  radio.addEventListener("change", () => {
    if (!medicalExamBox) return;
    if (radio.value === "Yes" && radio.checked) medicalExamBox.classList.remove("hidden");
    if (radio.value === "No" && radio.checked) medicalExamBox.classList.add("hidden");
  });
});

const relationSelect = document.getElementById("emergency_relation");
const otherInput = document.getElementById("relation_other");

if (relationSelect && otherInput) {
  relationSelect.addEventListener("change", function () {
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

const medicalToggles = [
  { name: "good_health", boxId: "good_health_box", showOn: "No" },
  { name: "under_treatment", boxId: "treatment_box", showOn: "Yes" },
  { name: "hospitalized", boxId: "hospital_box", showOn: "Yes" },
  { name: "medication", boxId: "medication_box", showOn: "Yes" },
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
</script>
</body>
</html>