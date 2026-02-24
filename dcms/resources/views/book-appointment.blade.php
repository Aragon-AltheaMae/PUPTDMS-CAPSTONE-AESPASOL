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
      Select Date and Time</h2>

      <label class="text-l font-bold text-[#8B0000]">Date</label>
      <input type="text" id="datePicker" name="appointment_date"
       class="input input-bordered text-l w-full mt-2 mb-10"
       placeholder="Select date" readonly>
      
      <label class="text-l font-bold text-[#8B0000]">Time Slot</label>
      <select name="appointment_time" id="timeSlot" required class="select select-bordered text-l mt-2 w-full">
        <option value="">Select time</option>
      </select>
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
        <span>Have you had a medical examination in the past year?</span>
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

  <!-- STEP 5 -->
<div class="step-content hidden">
  <div class="bg-[#F4F4F4] shadow-xl rounded-xl p-8">

    <!-- TITLE -->
    <h2 class="text-xl font-bold mb-2 text-[#660000]">
      Confirmation Summary
    </h2>

    <div id="summaryBox" class="bg-[#F4F4F4] p-4 rounded mb-4"></div>

    <label class="flex items-center gap-2 mt-3 cursor-pointer">
      <input type="checkbox" required class="checkbox checkbox-sm border-[#8B0000]">
      <span class="text-sm text-[#660000]">I confirm all information is correct.</span>
    </label>

  </div>
</div>

<!-- MINI TAB WARNING -->
<div id="miniTab" 
  class="hidden fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-4 py-2 rounded shadow-md text-sm z-50">
  Please complete all required fields before proceeding.
</div>

<!-- NAVIGATION BUTTONS -->
<div class="flex justify-center mt-8 gap-6">
  <button
  type="button"
  id="prevBtn"
  class="flex items-center gap-2 px-6 py-2
         rounded-lg
         border border-gray-400
         bg-[#F4F4F4]
         text-[#660000]
         font-medium
         hover:bg-[#ECECEC]
         shadow
         transition">
    <span class="text-xl leading-none">&lsaquo;</span>
    <span>Previous</span>
  </button>

  <button
  type="button"
  id="nextBtn"
  class="btn btn-primary
        shadow
        pr-10
        pl-10">
  <span>Next</span>
  <span class="text-xl leading-none">&rsaquo;</span>
  </button>
  <button 
      type="button" 
      class="btn btn-success hidden" 
      id="submitBtn"
      onclick="document.getElementById('confirmModal').showModal()"
    >
      Submit
  </button>
  </div>


<!-- CONFIRMATION MODAL -->
<dialog id="confirmModal" class="modal">
  <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-md">

    <!-- Top Accent Bar -->
    <div class="h-2 bg-[#8B0000] w-full"></div>

    <!-- Body -->
    <div class="px-10 py-10 text-center">

      <!-- Title -->
      <h3 class="text-2xl font-bold text-[#8B0000] mb-4">
        Appointment Confirmed
      </h3>

      <!-- Message -->
      <p class="text-gray-600 text-base leading-relaxed mb-8">
        Your appointment has been successfully scheduled.
      </p>

      <!-- Button -->
      <div class="flex justify-center">
        <a href="{{ route('homepage') }}"
           class="px-8 py-3 rounded-xl bg-[#8B0000] hover:bg-[#7A0000] 
                  text-white font-semibold tracking-wide 
                  shadow-md hover:shadow-lg 
                  transition-all duration-300">
          Back to Home
        </a>
      </div>

    </div>
  </div>
</dialog>







<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script>

const miniTab = document.getElementById("miniTab");

/* -------- Data -------- */
const holidays = ["2026-01-01","2026-04-09"];
const allSlots = [
  { t: "9:00 AM", available: true },
  { t: "10:00 AM", available: true },
  { t: "11:00 AM", available: false },
  { t: "12:00 PM", available: true },
  { t: "1:00 PM", available: true },
  { t: "2:00 PM", available: true },
  { t: "3:00 PM", available: true },
];

const timeSlot = document.getElementById('timeSlot');
timeSlot.disabled = true;

/* -------- Pikaday Calendar -------- */
const picker = new Pikaday({
  field: document.getElementById('datePicker'),
  format: 'YYYY-MM-DD',   // ✅ THIS IS THE FIX
  minDate: new Date(),
  disableDayFn: function(date) {
    const day = date.getDay();
    const formatted = date.toISOString().split('T')[0];
    return day === 0 || day === 6 || holidays.includes(formatted);
  },
onSelect: function(date) {
  const formattedDate = date.toISOString().split('T')[0];
  document.getElementById('datePicker').value = formattedDate;
  loadTimeSlots(formattedDate);
}
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

/* -------- Load 5 slots per date -------- */
function loadTimeSlots(date) {
  timeSlot.innerHTML = '<option value="">Select time</option>';
  timeSlot.disabled = false;

  const slotsForDate = allSlots.slice(0,5);
  slotsForDate.forEach(s => {
    const opt = document.createElement('option');
    opt.value = s.t;
    opt.textContent = s.available ? `${s.t} – Available` : `${s.t} – FULL`;
    if (!s.available) opt.disabled = true;
    timeSlot.appendChild(opt);
  });

  // Clear previous selection
  timeSlot.value = "";
}

/* -------- Step Logic with "In Progress" & Checkmarks -------- */
let step = 0;
const steps = document.querySelectorAll(".step-content");
const indicators = document.querySelectorAll(".step");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const submitBtn = document.getElementById("submitBtn");

let completedSteps = [];

// Initialize stepper on page load
document.addEventListener("DOMContentLoaded", () => {
  showStep(0);
});

function showStep(i) {
  // Show step content
  steps.forEach((s, idx) => {
    s.classList.toggle("hidden", idx !== i);
    if(idx === i){
      s.classList.add("show");
    } else {
      s.classList.remove("show");
    }
  });

  indicators.forEach((ind, idx) => {
    // Remove old in-progress text
    ind.querySelectorAll(".in-progress").forEach(el => el.remove());

    // Remove completed text if step is not completed
    if(idx >= i) {
      const completedText = ind.querySelector(".completed-text");
      if(completedText) completedText.remove();
    }

    // Reset styles
    ind.classList.remove("step-success", "step-primary", "in-progress-step");
    ind.style.color = "";
    ind.style.fontWeight = "";

    if(idx < i && completedSteps.includes(idx)){
      // Completed → green, bold
      ind.classList.add("step-success");
      ind.style.color = "#16a34a";
      ind.style.fontWeight = "700";

      if(!ind.querySelector(".completed-text")){
        const completedText = document.createElement("span");
        completedText.className = "completed-text";
        completedText.textContent = "Completed";
        ind.appendChild(completedText);
        setTimeout(() => completedText.classList.add("show"), 50);
      }
    }

    if(idx === i){
      // Current → blue, bold
      ind.classList.add("step-primary", "in-progress-step");
      ind.style.color = "#2563eb";
      ind.style.fontWeight = "700";

      const span = document.createElement("span");
      span.className = "in-progress";
      span.textContent = "In Progress";
      ind.appendChild(span);
      setTimeout(() => span.classList.add("show"), 50); // fade-in animation
    }
  });

  prevBtn.style.display = i === 0 ? "none" : "inline-flex";
  nextBtn.style.display = i === steps.length - 1 ? "none" : "inline-flex";
  submitBtn.style.display = i === steps.length - 1 ? "inline-flex" : "none";

  if(i === steps.length - 1) buildSummary();

  // Scroll to top of form with fade
  document.querySelector(".max-w-4xl").scrollIntoView({ behavior: "smooth" });
}

// CHECKER //
function isStepComplete(currentStep) {
  const stepEl = steps[currentStep];

  // Required fields check
  const inputs = stepEl.querySelectorAll(
    "input[required]:not([type='radio']):not([type='checkbox']), select[required], textarea[required]"
  );

  for (const input of inputs) {
    if (!input.value.trim()) return false;
  }

  // Emergency Contact validation
  const contactInput = stepEl.querySelector("#emergency_number");
  if (contactInput) {
    const value = contactInput.value.trim();
    if (!/^\d{1,11}$/.test(value)) {
      showMiniTab("Emergency Contact must be 1–11 digits only!");
      contactInput.focus();
      return false;
    }
  }

  // Radio validation
  const radios = stepEl.querySelectorAll("input[type='radio']");
  if (radios.length) {
    const groups = [...new Set([...radios].map(r => r.name))];
    for (const name of groups) {
      if (!stepEl.querySelector(`input[name="${name}"]:checked`)) return false;
    }
  }

  return true;
}


function showMiniTab(message) {
  miniTab.textContent = message;
  miniTab.classList.remove("hidden");
  miniTab.classList.add("show");

  setTimeout(() => {
    miniTab.classList.add("hidden");
    miniTab.classList.remove("show");
  }, 3000);
}

function showInputError(input) {
  input.classList.add("input-error", "shake");
  setTimeout(() => input.classList.remove("shake"), 300);
}

// Next button
nextBtn.onclick = () => {
  if (!isStepComplete(step)) {
    // Show mini tab notification
    miniTab.classList.remove("hidden");
    miniTab.classList.add("show");

    // Hide after 3 seconds
    setTimeout(() => {
      miniTab.classList.add("hidden");
      miniTab.classList.remove("show");
    }, 3000);

    const firstEmpty = steps[step].querySelector("input[required]:invalid, select[required]:invalid, textarea[required]:invalid");
    if (firstEmpty) {
      firstEmpty.focus();
      return;
    }

    // For radios, focus first unanswered group
    if (step === 3) {
      const radios = steps[step].querySelectorAll("input[type='radio']");
      const groups = [...new Set([...radios].map(r => r.name))];
      for (let name of groups) {
        if (!steps[step].querySelector(`input[name="${name}"]:checked`)) {
          // Focus first radio in that group
          const firstRadio = steps[step].querySelector(`input[name="${name}"]`);
          if (firstRadio) firstRadio.focus();
          break;
        }
      }
    }

    return; 
  }

  // Mark current step as completed
  if (!completedSteps.includes(step)) completedSteps.push(step);

  step++;
  showStep(step);
};

// Previous button
prevBtn.onclick = () => {
  if(step > 0) step--;
  showStep(step);
};

/* -------- Build Summary (Polished) -------- */
function yn(val) {
  return val ? val : "N/A";
}

function buildSummary() {
  const form = document.getElementById("appointmentForm");
  const data = new FormData(form);

  const date = document.getElementById("datePicker").value;
  const time = document.getElementById("timeSlot").value;

  const get = name => data.get(name) || "N/A";
  const getAll = name => data.getAll(name);

  const selectedRelation = data.get("emergency_relation") || "";
  const typedRelation = (data.get("relation_other") || "").trim();

  const emergencyRelation =
    selectedRelation === "Others"
      ? (typedRelation || "Others")
      : (selectedRelation || "N/A");

  const signatureFile = data.get("patient_signature");
  let signatureHTML = "Not uploaded";

  if (signatureFile && signatureFile.size > 0) {
    // Create a temporary URL for the uploaded image file
    const imageUrl = URL.createObjectURL(signatureFile);
    signatureHTML = `<img src="${imageUrl}" alt="Signature" style="max-width: 250px; max-height: 150px; border: 1px solid #8B0000; border-radius: 8px;">`;
  }

  const card = (title, body) => `
    <div class="border-2 border-[#8B0000] rounded-xl p-4 bg-white">
      <h3 class="font-bold text-[#8B0000] mb-3">${title}</h3>
      <div class="space-y-1 text-sm">${body}</div>
    </div>
  `;

  let html = `
    <div class="space-y-6">

      ${card("Appointment Details", `
        <p><b>Date:</b> ${date}</p>
        <p><b>Time:</b> ${time}</p>
      `)}

      ${card("Service", `
        <p>${get("service_type")}</p>
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

  document.getElementById("summaryBox").innerHTML = html;
}

/* -------- Modal Close + Redirect -------- */
function closeModal() {
  const modal = document.getElementById("confirmModal");
  modal.close();
  window.location.href = "index.html";
}



/* -------- Date Dental History Boxes -------- */
const questions = [
    { name: 'difficult_extraction', boxId: 'extraction_date_box' },
    { name: 'dentures', boxId: 'dentures_date_box' },
    { name: 'ortho_treatment', boxId: 'ortho_date_box' }
  ];

questions.forEach(q => {
  const radios = document.getElementsByName(q.name);
  const box = document.getElementById(q.boxId);
  const input = box.querySelector("input");

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked && radio.value === "Yes") {
        box.classList.remove("hidden");
        input.required = true;
      } else if (radio.checked) {
        box.classList.add("hidden");
        input.required = false;
        input.value = "";
      }
    });
  });
});

const medicalExamRadios = document.querySelectorAll('input[name="had_medical_exam"]');
  const medicalExamBox = document.getElementById("medical_exam_box");

  medicalExamRadios.forEach(radio => {
    radio.addEventListener("change", () => {
      if (radio.value === "Yes" && radio.checked) {
        medicalExamBox.classList.remove("hidden");
      } else if (radio.value === "No" && radio.checked) {
        medicalExamBox.classList.add("hidden");
      }
    });
  });

const relationSelect = document.getElementById("emergency_relation");
  const otherInput = document.getElementById("relation_other");

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

const medicalToggles = [
  { name: 'good_health', boxId: 'good_health_box', showOn: 'No' }, 
  { name: 'under_treatment', boxId: 'treatment_box', showOn: 'Yes' },
  { name: 'hospitalized', boxId: 'hospital_box', showOn: 'Yes' },
  { name: 'medication', boxId: 'medication_box', showOn: 'Yes' }
];

medicalToggles.forEach(item => {
  const radios = document.getElementsByName(item.name);
  const box = document.getElementById(item.boxId);

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      const selected = [...radios].find(r => r.checked);
      const inputs = box.querySelectorAll("input");

      if (selected && selected.value === item.showOn) {
        box.classList.remove('hidden');
        inputs.forEach(i => i.required = true);
      } else {
        box.classList.add('hidden');
        inputs.forEach(i => {
          i.required = false;
          i.value = "";
        });
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const tobaccoRadios = document.getElementsByName("tobacco_use");
  const details = document.getElementById("tobacco_details");

  tobaccoRadios.forEach(radio => {
    radio.addEventListener("change", () => {
      if (radio.checked && radio.value === "Yes") {
        details.classList.remove("hidden");
      } else {
        details.classList.add("hidden");
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("patient_signature");
  const fileNameDisplay = document.getElementById("signature_filename");

  input.addEventListener("change", () => {
    if (input.files.length > 0) {
      fileNameDisplay.textContent = input.files[0].name;
      fileNameDisplay.classList.remove("hidden");
    } else {
      fileNameDisplay.textContent = "";
      fileNameDisplay.classList.add("hidden");
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const contactInput = document.getElementById("emergency_number");

  if (!contactInput) return;

  // INPUT EVENT
  contactInput.addEventListener("input", (e) => {
    const rawValue = e.target.value;

    if (/[^0-9]/.test(rawValue)) {
      showMiniTab("Contact number must contain digits only.");
      showInputError(contactInput);
      contactInput.classList.remove("input-valid");
    }

    let value = rawValue.replace(/\D/g, "");

    if (value.startsWith("9")) value = "0" + value;
    if (value.length === 1 && value !== "0") value = "09" + value;

    value = value.slice(0, 11);
    contactInput.value = value;

    if (/^09\d{9}$/.test(value)) {
      contactInput.classList.remove("input-error");
      contactInput.classList.add("input-valid");
    } else {
      contactInput.classList.remove("input-valid");
    }
  });

  // BLUR EVENT
  contactInput.addEventListener("blur", () => {
    if (contactInput.value === "") {
      contactInput.classList.remove("input-error", "input-valid");
    }
  });
});

// confirmation modal 
  document.getElementById("appointmentForm").addEventListener("submit", function(e) {
      e.preventDefault(); // Prevent page reload
      
      // Show modal
      document.getElementById("confirmModal").showModal();
  });
</script>
</script>
</body>
</html>