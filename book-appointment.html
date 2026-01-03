<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
  <style>
    body {
      background-color: #F4F4F4;
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
  </style>
</head>
<body>

<!-- HEADER -->
<div class="bg-gradient-to-r from-red-900 to-red-700 text-white px-6 py-4 flex items-center justify-between">
  <div class="flex items-center gap-3">
    <div class="w-12 ml-5"><img src="dcms/public/images/PUP.png" alt="PUP Logo"></div>
    <div class="w-12"><img src="dcms/public/images/PUPT-DMS-Logo.png" alt="Clinic Logo"></div>
    <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
  </div>
</div>

<h1 class="text-4xl font-extrabold m-12 text-[#660000] text-center">
  Book an Appointment
</h1>

<!-- MAIN FORM -->
<div class="max-w-4xl mx-auto p-8 bg-white rounded-xl mt-10 shadow">
  <ul class="steps w-full mb-10">
    <li class="step" id="s1">Date & Time</li>
    <li class="step" id="s2">Service</li>
    <li class="step" id="s3">Dental History</li>
    <li class="step" id="s4">Medical History</li>
    <li class="step" id="s5">Confirmation</li>
  </ul>

  <form id="appointmentForm">

    <!-- STEP 1 -->
    <div class="step-content">
      <h2 class="text-xl font-bold mb-4 text-[#660000] ">Select Date & Time</h2>
      <label>Date</label>
      <input type="text" id="datePicker" class="input input-bordered w-full mb-4" placeholder="Select date" readonly>
      
      <label>Time Slot</label>
      <select name="appointment_time" id="timeSlot" required class="select select-bordered w-full">
        <option value="">Select time</option>
      </select>
    </div>

    <!-- STEP 2 -->
    <div class="step-content hidden">
      <h2 class="text-xl font-bold mb-4 text-[#660000]">Select Service</h2>
      <label><input type="radio" name="service_type" value="Oral Check-up" required> Oral Check-up</label><br>
      <label><input type="radio" name="service_type" value="Dental Cleaning"> Dental Cleaning</label><br>
      <label><input type="radio" name="service_type" value="Restoration & Prosthesis"> Restoration & Prosthesis</label><br>
      <label><input type="radio" name="service_type" value="Dental Surgery"> Dental Surgery</label>
    </div>

    <!-- STEP 3 -->
    <div class="step-content hidden">
      <h2 class="text-xl font-bold mb-4 text-[#660000]">Dental History</h2>
      <label><input type="checkbox" name="dental_history[]" value="Tooth Pain"> Tooth Pain</label><br>
      <label><input type="checkbox" name="dental_history[]" value="Bleeding Gums"> Bleeding Gums</label><br>
      <label><input type="checkbox" name="dental_history[]" value="Previous Extraction"> Previous Extraction</label>

      <label class="block mt-4">Additional Concern</label>
      <input type="text" name="additional_concern" class="input input-bordered w-full">
    </div>

    <!-- STEP 4 -->
    <div class="step-content hidden">
    <h2 class="font-semibold mb-2 text-[#660000] ">Medical History</h2>

    <!-- Medical History -->
    <label><input type="checkbox" name="medical_history[]" value="Hypertension"> Hypertension</label><br>
    <label><input type="checkbox" name="medical_history[]" value="Diabetes"> Diabetes</label><br>
    <label><input type="checkbox" name="medical_history[]" value="Heart Condition"> Heart Condition</label>

    <hr class="my-4">

    <label><input type="checkbox" name="allergy" value="Yes"> Allergies</label><br>
    <label><input type="checkbox" name="pregnant"> Pregnant</label><br>
    <label><input type="checkbox" name="nursing"> Nursing</label><br>
    <label><input type="checkbox" name="birth_control"> Taking Birth Control Pills</label>

    <hr class="my-4">

    <!-- Emergency Contact -->
    <h2 class="font-semibold text-[#660000] mb-2">Emergency Contact</h2>
    <label>Person to contact</label>
    <input type="text" name="emergency_person" maxlength="50" required class="input input-bordered w-full mb-2">

    <label>Contact Number</label>
    <input type="text" name="emergency_number" maxlength="15" required class="input input-bordered w-full mb-2">

    <label>Relation to Patient</label>
    <input type="text" name="emergency_relation" maxlength="30" required class="input input-bordered w-full mb-2">

    <label>Patient's Signature</label>
    <input type="file" name="patient_signature" accept="image/*" required class="input input-bordered w-full mb-2">

    </div>

    <!-- STEP 5 -->
    <div class="step-content hidden">
    <h2 class="text-xl font-bold mb-4">Confirmation Summary</h2>

    <div id="summaryBox" class="bg-[#F4F4F4] p-4 rounded mb-4"></div>
    <label class="block mt-3">
        <input type="checkbox" required> I confirm all information is correct
    </label>
    </div>

    <div class="flex justify-between mt-8">
      <button type="button" class="btn" id="prevBtn">Previous</button>
      <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
      <button type="submit" class="btn btn-success hidden" id="submitBtn">Submit</button>
    </div>

  </form>
</div>

<!-- CONFIRMATION MODAL -->
<dialog id="confirmModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Appointment Confirmed</h3>
    <p class="py-4" id="modalText"></p>
    <div class="modal-action">
      <button class="btn" onclick="closeModal()">OK</button>
    </div>
  </div>
</dialog>

<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script>
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
  minDate: new Date(),
  disableDayFn: function(date) {
    const day = date.getDay();
    const formatted = date.toISOString().split('T')[0];
    return day === 0 || day === 6 || holidays.includes(formatted);
  },
  onSelect: function(date) {
    const formattedDate = date.toISOString().split('T')[0];
    loadTimeSlots(formattedDate);
  }
});

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

// Initialize stepper on page load
showStep(step);

function showStep(i) {
  // Show the current step content
  steps.forEach((s, idx) => s.classList.toggle("hidden", idx !== i));

  indicators.forEach((ind, idx) => {
    // Remove previous in-progress text
    const existing = ind.querySelector(".in-progress");
    if (existing) existing.remove();

    // Remove previous checkmark icon
    const iconExisting = ind.querySelector(".check-icon");
    if (iconExisting) iconExisting.remove();

    if(idx < i) {
      // Completed steps → green checkmark
      ind.classList.add("step-success");
      const check = document.createElement("span");
      check.className = "check-icon text-green-600 ml-1";
      check.innerHTML = '<img src="dcms/public/images/check-icon.png" class="check-icon w-5 h-5 mx-auto" alt="Check">'; // ✓ symbol
      ind.appendChild(check);
    } else {
      ind.classList.remove("step-success");
    }

    if(idx === i) {
      // Current step → "In Progress" text
      const span = document.createElement("span");
      span.className = "in-progress text-sm text-gray-500 block mt-1";
      span.textContent = "In Progress";
      ind.appendChild(span);
    }
  });

  // Show/hide buttons
  prevBtn.style.display = i === 0 ? "none" : "inline-flex";
  nextBtn.style.display = i === steps.length - 1 ? "none" : "inline-flex";
  submitBtn.style.display = i === steps.length - 1 ? "inline-flex" : "none";

  if(i===4) buildSummary();
}

// Next button
nextBtn.onclick = () => {
  if(step === 0) {
    const date = document.getElementById("datePicker").value;
    const time = timeSlot.value;
    if(!date || !time) { alert("Please select both a date and a time slot."); return; }
  }

  const invalidField = steps[step].querySelector(":invalid");
  if(invalidField) { invalidField.focus(); return; }

  step++;
  showStep(step);
};

// Previous button
prevBtn.onclick = () => {
  step--;
  showStep(step);
};

/* -------- Build Summary (Polished) -------- */
function buildSummary() {
  const data = new FormData(document.getElementById("appointmentForm"));
  const grouped = {};

  for(let [k,v] of data.entries()) {
    if(grouped[k]) grouped[k].push(v);
    else grouped[k] = [v];
  }

  const date = document.getElementById("datePicker").value;
  const time = timeSlot.value;

  let html = `
    <h3 class="font-semibold mb-2">Appointment Details</h3>
    <p><strong>Date:</strong> ${date}</p>
    <p><strong>Time:</strong> ${time}</p>
    
    <h3 class="font-semibold mt-4 mb-2">Service</h3>
    <p>${grouped['service_type'] ? grouped['service_type'].join(", ") : "N/A"}</p>
    
    <h3 class="font-semibold mt-4 mb-2">Dental History</h3>
    <p>${grouped['dental_history[]'] ? grouped['dental_history[]'].join(", ") : "None"}</p>
    ${grouped['additional_concern'] ? `<p><strong>Additional Concern:</strong> ${grouped['additional_concern'].join(", ")}</p>` : ""}

    <h3 class="font-semibold mt-4 mb-2">Medical History</h3>
    <p>${grouped['medical_history[]'] ? grouped['medical_history[]'].join(", ") : "None"}</p>
    <p>${grouped['allergy'] ? "Allergies" : ""} ${grouped['pregnant'] ? "Pregnant" : ""} ${grouped['nursing'] ? "Nursing" : ""} ${grouped['birth_control'] ? "Birth Control" : ""}</p>

    <h3 class="font-semibold mt-4 mb-2">Emergency Contact</h3>
    <p><strong>Person to contact:</strong> ${grouped['emergency_person'] ? grouped['emergency_person'].join(", ") : ""}</p>
    <p><strong>Contact Number:</strong> ${grouped['emergency_number'] ? grouped['emergency_number'].join(", ") : ""}</p>
    <p><strong>Relation to Patient:</strong> ${grouped['emergency_relation'] ? grouped['emergency_relation'].join(", ") : ""}</p>
    <p><strong>Patient's Signature:</strong> ${grouped['patient_signature'] ? grouped['patient_signature'].join(", ") : ""}</p>
  `;

  document.getElementById("summaryBox").innerHTML = html;
}

/* -------- Modal Close + Redirect -------- */
function closeModal() {
  const modal = document.getElementById("confirmModal");
  modal.close();
  window.location.href = "index.html";
}

/* -------- Submit & Modal -------- */
document.getElementById("appointmentForm").onsubmit = function(e){
  e.preventDefault();
  const date = document.getElementById("datePicker").value;
  const time = timeSlot.value;

  const formData = new FormData(this);
  formData.append("appointment_date", date);

  fetch("save_appointment.php", { method:"POST", body: formData })
    .then(res => res.json())
    .then(data => {
      if(data.status === "success") {
        document.getElementById("modalText").innerHTML = `
          Your dental appointment at <b>PUP Taguig Dental Clinic</b> has been successfully scheduled on
          <b>${date}</b> at <b>${time}</b>.<br><br>
          Please arrive on time and bring your school or office ID.<br><br>
          Thank you!
        `;
        confirmModal.showModal();
      } else {
        alert(data.message);
        loadTimeSlots(date);
      }
    })
    .catch(()=> alert("Something went wrong. Please try again."));
};
</script>

</body>
</html>
