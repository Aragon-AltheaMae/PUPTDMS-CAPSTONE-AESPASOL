<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Patient Profile</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + DaisyUI CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css"/>

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
          colors: { primary: '#8B0000' }
        }
      }
    }
  </script>

  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>

<body class="bg-gray-100 min-h-screen">

<!-- ===== APP SHELL ===== -->
<div class="flex min-h-screen">

  <!-- ===== TOP HEADER ===== -->
  <div class="flex-1 flex flex-col">
    <header class="bg-gradient-to-r from-[#660000] to-[#8B0000] text-white 
      px-8 py-3 flex justify-between items-center sticky top-0 z-30">
      <div class="flex items-center gap-3 font-bold text-sm">
        <img src="{{ asset('images/PUP.png') }}" 
          alt="PUP Logo" 
          class="w-8 h-8 object-contain">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" 
          alt="DMS Logo" 
          class="w-8 h-8 object-contain">
        <span class="tracking-wide">PUP TAGUIG DENTAL CLINIC</span>
      </div>

      <div class="flex items-center gap-6">
        @php
          $notifications = collect($notifications ?? []);
          $notifCount = $notifications->count();
        @endphp

        <!-- Bell -->
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle indicator text-white">
            @if($notifCount > 0)
              <span class="indicator-item badge badge-sm bg-yellow-400 
                border-none text-[#660000] font-bold">{{ $notifCount }}
              </span>
            @endif
            <i class="fa-regular fa-bell text-lg"></i>
          </label>
          <div tabindex="0" class="dropdown-content z-50 mt-3 w-80 
            rounded-2xl bg-white shadow-xl border border-gray-100">
            <div class="p-4 border-b flex items-center justify-between">
              <span class="font-bold text-[#8B0000]">Notifications</span>
            </div>
            <div class="max-h-80 overflow-y-auto">

              @forelse($notifications as $n)
                <a href="{{ $n['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
                  <div class="text-sm font-semibold text-gray-900">{{ $n['title'] ?? 'Notification' }}</div>
                  @if(!empty($n['message']))<div class="text-xs text-gray-400 mt-0.5">{{ $n['message'] }}</div>@endif
                </a>
              @empty
              
                <div class="px-4 py-10 text-center">
                  <div class="text-sm font-semibold text-gray-800">No notifications</div>
                  <div class="text-xs text-gray-500 mt-1">You're all caught up.</div>
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Divider -->
        <div class="h-8 w-px bg-white/30"></div>

        <!-- User -->
        <div class="flex items-center gap-3">
          <img src="https://i.pravatar.cc/40" class="rounded-full w-9 h-9 object-cover border-2 border-white/40">
          <div class="text-sm leading-tight">
            <p class="font-semibold">Dr. Nelson Angeles</p>
            <p class="text-xs opacity-75">Dentist</p>
          </div>
        </div>
      </div>
    </header>

    <!-- ===== PAGE CONTENT ===== -->
    <main class="flex-1 px-8 py-6 space-y-6">

      <!-- Breadcrumb + Title -->
      <div>
        <p class="text-xs text-gray-400 mb-2">
          <a href="{{ route('dentist.appointments') }}" class="hover:underline">Appointments</a>
          <span class="mx-1">›</span>
          <span class="text-gray-600 font-medium">Patient Profile</span>
        </p>
        <div class="flex items-center gap-3">
          <a href="/dentist/patients"
             class="flex items-center gap-1 text-sm text-gray-600 border 
              border-gray-300 rounded-md px-3 py-1.5 hover:bg-gray-100 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back
          </a>
          <h1 class="text-2xl font-bold text-[#8B0000]">Patient Profile</h1>
        </div>
      </div>

      <!-- ===== STAT CARDS ===== -->
      <div class="grid grid-cols-3 gap-4">
        <!-- Total Visits -->
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
          <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500">
            <i class="fa-regular fa-calendar text-lg"></i>
          </div>
          <div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Visits</p>
            <p class="text-2xl font-bold text-gray-900 leading-tight">{{ $totalVisits ?? 6 }}</p>
            <p class="text-[11px] text-gray-400">Since Jan 2024</p>
          </div>
        </div>

        <!-- Last Visit -->
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
          <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-500">
            <i class="fa-regular fa-calendar-check text-lg"></i>
          </div>
          <div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Last Visit</p>
            <p class="text-2xl font-bold text-gray-900 leading-tight">Mar 29</p>
            <p class="text-[11px] text-gray-400">2025 · Tooth Extraction</p>
          </div>
        </div>

        <!-- Next Appointment -->
        <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
          <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-400">
            <i class="fa-regular fa-calendar text-lg"></i>
          </div>
          <div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Next Appointment</p>
            <p class="text-2xl font-bold text-gray-900 leading-tight">Dec 29</p>
            <p class="text-[11px] text-gray-400">2025 · Dental Surgery</p>
          </div>
        </div>
      </div>

      <!-- ===== PATIENT CARD + ODONTOGRAM ===== -->
      <div class="grid grid-cols-[380px,1fr] gap-4">

        <!-- Patient Card -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
          <!-- Maroon top with avatar -->
          <div class="bg-gradient-to-b from-[#8B0000] to-[#660000] px-8 pt-8 pb-6 flex flex-col items-center text-white">
            @php
              $age = $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->age : null;
              $birthdateFormatted = $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('F d, Y') : 'N/A';
            @endphp
            <img src="https://i.pravatar.cc/180" class="w-28 h-28 rounded-full object-cover border-4 border-white/30 shadow-md mb-4">
            <p class="font-bold text-xl text-center leading-tight">{{ $patient->name }}</p>
            <p class="text-sm opacity-75 mt-1">BSIT 3-1</p>
            <!-- ID badge -->
            <span class="mt-3 bg-yellow-500 text-white text-xs font-bold px-4 py-1 rounded-full tracking-wide">
              {{ $patient->student_id ?? '2023-0010-TO-S' }}
            </span>
          </div>

          <!-- Patient Details -->
          <div class="divide-y divide-gray-100 text-sm">
            <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
              <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Date of Birth</span>
              <span class="text-gray-800 font-medium">{{ $birthdateFormatted }}</span>
            </div>
            <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
              <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Age</span>
              <span class="text-gray-800 font-medium">{{ $age ? $age . ' years old' : 'N/A' }}</span>
            </div>
            <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
              <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Gender</span>
              <span class="text-gray-800 font-medium">{{ $patient->gender ?? 'Female' }}</span>
            </div>
            <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
              <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Address</span>
              <span class="text-gray-800 font-medium">{{ $patient->address ?? '10-A Tindalo St. North Signal Village, Taguig City' }}</span>
            </div>
            <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
              <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Contact</span>
              <span class="text-gray-800 font-medium">{{ $patient->phone ?? '09162903429' }}</span>
            </div>
            <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
              <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Email</span>
              <span class="text-gray-800 font-medium break-all">{{ $patient->email ?? 'limgraceannef@gmail.com' }}</span>
            </div>
          </div>
        </div>

        <!-- Odontogram Panel -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col">
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-[#8B0000]">Odontogram</h2>
            <a href="{{ route('dentist.viewOdontogram') }}"
               class="text-xs border border-gray-300 rounded-md px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition">
              Full View
            </a>
          </div>
          <div class="flex-1 p-6">
            {{-- Odontogram component renders here --}}
          </div>
        </div>
      </div>

      <!-- ===== MEDICAL HISTORY + CLINICAL NOTES ===== -->
      <div class="grid grid-cols-2 gap-4">

        <!-- Medical History -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
          <h2 class="text-base font-bold text-[#8B0000] mb-5">Medical History</h2>

          <div class="space-y-5">
            <div>
              <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Allergies</p>
              <hr class="border-gray-200 mb-3">
              <div class="flex flex-wrap gap-2">
                @php $allergies = $patient->allergies ?? ['Foods', 'Medicine', 'Peanut']; @endphp
                @foreach((is_array($allergies) ? $allergies : explode(',', $allergies)) as $allergy)
                  <span class="bg-red-50 border border-red-200 text-red-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ trim($allergy) }}
                  </span>
                @endforeach
              </div>
            </div>

            <div>
              <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Current Medication</p>
              <hr class="border-gray-200 mb-3">
              <div class="flex flex-wrap gap-2">
                @php $meds = $patient->medications ?? ['Ferrous Sulfate', 'Folic Acid']; @endphp
                @foreach((is_array($meds) ? $meds : explode(',', $meds)) as $med)
                  <span class="bg-gray-50 border border-gray-200 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ trim($med) }}
                  </span>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <!-- Clinical Notes -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
          <h2 class="text-base font-bold text-[#8B0000] mb-5">Clinical Notes</h2>
          <div class="text-sm text-gray-400 italic">No clinical notes yet.</div>
        </div>
      </div>

      <!-- ===== CLINIC VISITS ===== -->
      <div>
        <h2 class="text-xl font-bold text-[#8B0000] mb-4">Clinic Visits</h2>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">

          <!-- Tabs -->
          <div class="flex gap-8 border-b border-gray-200 mb-5">
            <button id="futureTab" onclick="showFuture()"
              class="visit-tab pb-3 text-sm font-semibold text-[#8B0000] border-b-2 border-[#8B0000] -mb-px transition">
              Future Visits ({{ $futureVisits->count() ?? 1 }})
            </button>
            <button id="pastTab" onclick="showPast()"
              class="visit-tab pb-3 text-sm font-semibold text-gray-400 border-b-2 border-transparent -mb-px transition">
              Past Visits ({{ $pastVisits->count() ?? 3 }})
            </button>
          </div>

          <!-- Future Visits -->
          <div id="futureContent">
            @forelse($futureVisits ?? [] as $visit)
              <div class="border border-gray-200 rounded-lg flex items-center gap-0 overflow-hidden mb-3 hover:shadow-sm transition-shadow">
                <div class="w-1 self-stretch bg-[#8B0000] rounded-l-lg flex-shrink-0"></div>
                <div class="flex items-center gap-0 flex-1 px-4 py-4">
                  <div class="min-w-[150px]">
                    <p class="font-semibold text-[#8B0000] text-sm">{{ \Carbon\Carbon::parse($visit->appointment_date)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($visit->appointment_time)->format('g:i A') }}</p>
                    <span class="mt-1.5 inline-block text-[11px] font-bold text-blue-500 uppercase">{{ $visit->status }}</span>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="min-w-[130px]">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Service</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">{{ $visit->service_type }}</p>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="flex-1">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Dentist</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">Dr. Nelson Angeles</p>
                  </div>
                  <button onclick="openStartModal()"
                    class="ml-auto flex items-center gap-2 bg-[#8B0000] hover:bg-[#7a0000] text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    <i class="fa-regular fa-eye text-xs"></i>
                    Details
                  </button>
                </div>
              </div>
            @empty
              {{-- Static demo row --}}
              <div class="border border-gray-200 rounded-lg flex items-center overflow-hidden mb-3 hover:shadow-sm transition-shadow">
                <div class="w-1 self-stretch bg-[#8B0000] rounded-l-lg flex-shrink-0"></div>
                <div class="flex items-center flex-1 px-4 py-4">
                  <div class="min-w-[150px]">
                    <p class="font-semibold text-[#8B0000] text-sm">29 Dec 2025</p>
                    <p class="text-xs text-gray-500 mt-0.5">1:30 PM - 2:30 PM</p>
                    <span class="mt-1.5 inline-block text-[11px] font-bold text-blue-500 uppercase">Scheduled</span>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="min-w-[130px]">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Service</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">Dental Surgery</p>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="flex-1">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">
                      Dentist
                    </p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">
                      Dr. Nelson Angeles
                    </p>
                  </div>
                  <button onclick="openStartModal()"
                    class="ml-auto flex items-center gap-2 bg-[#8B0000] 
                      hover:bg-[#7a0000] text-white text-xs font-semibold 
                      px-4 py-2 rounded-lg transition">
                    <i class="fa-regular fa-eye text-xs"></i>
                    Details
                  </button>
                </div>
              </div>
            @endforelse
          </div>

          <!-- Past Visits -->
          <div id="pastContent" class="hidden">
            @forelse($pastVisits ?? [] as $visit)
              <div class="border border-gray-200 rounded-lg flex items-center 
                overflow-hidden mb-3 hover:shadow-sm transition-shadow">
                <div class="w-1 self-stretch bg-gray-400 rounded-l-lg flex-shrink-0"></div>
                <div class="flex items-center flex-1 px-4 py-4">
                  <div class="min-w-[150px]">

                    <p class="font-semibold text-gray-700 text-sm">{{ \Carbon\Carbon::parse($visit->appointment_date)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($visit->appointment_time)->format('g:i A') }}</p>
                    <span class="mt-1.5 inline-block text-[11px] font-bold text-gray-500 uppercase">{{ $visit->status }}</span>

                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="min-w-[130px]">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Service</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">{{ $visit->service_type }}</p>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="flex-1">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">
                      Dentist
                    </p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">
                      Dr. Nelson Angeles
                    </p>
                  </div>
                  <button class="ml-auto flex items-center gap-2 bg-[#8B0000] 
                    hover:bg-[#7a0000] text-white text-xs font-semibold px-4 
                      py-2 rounded-lg transition">
                    <i class="fa-regular fa-eye text-xs"></i>
                    Details
                  </button>
                </div>
              </div>
            @empty
              <div class="text-center text-gray-400 py-10 text-sm">
                No past visits recorded.
              </div>
            @endforelse
          </div>

        </div>
      </div>

    </main><!-- /main -->

    <!-- ===== FOOTER ===== -->
    <footer class="bg-[#660000] text-[#F4F4F4] px-10 
      py-6 text-xs text-center opacity-90">
      © {{ date('Y') }} PUP Taguig Dental Clinic. All rights reserved.
    </footer>

  </div><!-- /right column -->
</div><!-- /app shell -->


<!-- ===== START PROCEDURE MODAL ===== -->
<div id="startModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
  <div class="bg-white w-[480px] rounded-2xl p-8 relative shadow-2xl">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Confirm the start of procedure?</h2>
    <div class="flex items-center gap-4 mb-8">
      <span class="text-[#8B0000] font-medium text-sm w-20">Patient:</span>
      <div class="bg-[#8B0000] h-9 flex-1 rounded-lg"></div>
    </div>
    <div class="flex gap-3">
      <button onclick="confirmStart()" 
      class="bg-green-500 hover:bg-green-600 text-white 
      font-semibold px-8 py-2.5 rounded-lg transition text-sm">
        START</button>
      <button onclick="closeStartModal()" 
      class="bg-gray-200 hover:bg-gray-300 text-gray-700 
      font-semibold px-8 py-2.5 rounded-lg transition text-sm">
        BACK</button>
    </div>
  </div>
</div>


<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
  function showFuture() {
    document.getElementById('futureContent').classList.remove('hidden');
    document.getElementById('pastContent').classList.add('hidden');
    document.getElementById('futureTab').classList.add('text-[#8B0000]', 'border-[#8B0000]');
    document.getElementById('futureTab').classList.remove('text-gray-400', 'border-transparent');
    document.getElementById('pastTab').classList.add('text-gray-400', 'border-transparent');
    document.getElementById('pastTab').classList.remove('text-[#8B0000]', 'border-[#8B0000]');
  }

  function showPast() {
    document.getElementById('pastContent').classList.remove('hidden');
    document.getElementById('futureContent').classList.add('hidden');
    document.getElementById('pastTab').classList.add('text-[#8B0000]', 'border-[#8B0000]');
    document.getElementById('pastTab').classList.remove('text-gray-400', 'border-transparent');
    document.getElementById('futureTab').classList.add('text-gray-400', 'border-transparent');
    document.getElementById('futureTab').classList.remove('text-[#8B0000]', 'border-[#8B0000]');
  }

  function openStartModal() {
    document.getElementById('startModal').classList.remove('hidden');
  }
  function clo