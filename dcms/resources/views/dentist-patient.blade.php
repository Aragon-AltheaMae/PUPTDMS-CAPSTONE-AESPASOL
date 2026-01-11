<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Patient List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


  <style>
    body { font-family: 'Inter'; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }

  .radio-red {
    -webkit-appearance: none;
    appearance: none;
    width: 16px;
    height: 16px;
    border: 2px solid #8B0000;
    border-radius: 9999px;
    display: inline-grid;
    place-content: center;
    background: #fff;
  }
  .radio-red::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 9999px;
    transform: scale(0);
    transition: transform 120ms ease-in-out;
    background: #8B0000;
  }
  .radio-red:checked::before { transform: scale(1); }
</style>

</head>

<body class="bg-gray-100">

<!-- ================= TOP HEADER ================= -->
<header class="bg-gradient-to-r from-[#660000] to-[#8B0000] text-white px-8 py-4 flex justify-between items-center">
  <div class="flex items-center gap-3 font-bold">
    <!-- University Logo -->
    <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" class="w-10 h-10 object-contain">
    <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUP Logo" class="w-10 h-10 object-contain">
    <span>PUP TAGUIG DENTAL CLINIC</span>
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
      <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
      <div class="text-sm">
        <p class="font-semibold">Dr. Nelson Angeles</p>
        <p class="text-xs opacity-80">Dentist</p>
      </div>

      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="cursor-pointer text-[#F4F4F4] hover:text-[#660000]">
            <i class="fa-solid fa-right-from-bracket text-lg"></i>
        </button>
      </form>

    </div>
  </div>
</header>

<!-- ================= NAV HEADER ================= -->
<header class="bg-[#8B0000] text-white px-8 py-3">
  <nav class="flex justify-around text-sm">
    <a href="{{ route('dentist.dashboard') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-chart-line text-lg"></i>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-users text-lg"></i>
      <span class="font-bold">Patients</span>
    </a>
    <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>
    <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-box text-lg"></i>
      <span>Inventory</span>
    </a>
    <a href="{{ route('dentist.report') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>
  </nav>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-6 py-10 fade-in">

  <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#8B0000]/30">

    <!-- Title + Search / Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
      <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 to-orange-400 bg-clip-text text-transparent">
        Patient List
      </h2>

      <!-- ✅ UPDATED SEARCH BAR DESIGN (matches your screenshot) -->
      <div class="flex items-center gap-6 w-full md:w-auto">
        <div class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
          <div class="flex items-center bg-white rounded-full overflow-hidden w-full">

            <!-- left: search -->
            <div class="flex items-center gap-2 pl-3 pr-5 py-2 flex-1">
              <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
              </span>

              <input
                id="searchInput"
                type="text"
                placeholder="Search"
                class="w-full md:w-72 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none"
              />
            </div>

            <!-- divider -->
            <div class="w-[2px] self-stretch bg-[#F2C94C]"></div>

            <!-- right: filter -->
            <button
              id="openFilter"
              type="button"
              class="flex items-center gap-2 px-6 py-2 text-sm font-medium text-[#8B0000] bg-white hover:bg-[#FFF7E6] active:bg-[#FFEFC8]"
            >
              <i class="fa-solid fa-sliders text-[13px]"></i>
              <span>Filter</span>
            </button>

          </div>
        </div>

        <!-- Clear -->
        <button id="clearBtn" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
          Clear
        </button>
      </div>
    </div>

    <div class="w-full max-w-6xl mx-auto">

      <!-- Tabs -->
      <div class="mx-4">
        <div class="mx-4 border border-gray-200 rounded-2xl bg-white overflow-hidden">

          <div class="flex gap-4 flex-wrap px-4 pt-4 -mb-px">
            <button class="filter-btn bg-[#8B0000] text-white rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow"
              data-filter="today" type="button">
              <h3 class="text-4xl font-medium leading-none mb-2">5</h3>
              <p class="text-base opacity-90">Scheduled Today</p>
            </button>

            <button class="filter-btn bg-[#8B0000] text-white rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow"
              data-filter="rescheduled" type="button">
              <h3 class="text-4xl font-medium leading-none mb-2">10</h3>
              <p class="text-base opacity-90">Rescheduled</p>
            </button>

            <button class="filter-btn bg-[#8B0000] text-white rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow"
              data-filter="all" type="button">
              <h3 class="text-4xl font-medium leading-none mb-2">50</h3>
              <p class="text-base opacity-90">All</p>
            </button>
          </div>

          <div class="px-6 py-4 text-[22px] font-medium text-gray-700">
            Click to Access Patient Information
          </div>

          <!-- Patient Container -->
          <div id="patientContainer" class="space-y-4 px-6 pb-6">

            <!-- Patient Card 1 -->
            <div class="patient-item today relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
              <div class="absolute left-0 top-0 h-full w-2 bg-[#2E2E2E] rounded-l-md"></div>

              <div class="flex items-center w-full px-6 py-6 pl-10">
                <img src="https://i.pravatar.cc/51" class="w-20 h-20 rounded-full object-cover shadow" alt="Patient"/>

                <div class="ml-6 flex-1 grid grid-cols-12 gap-6 items-start">
                  <div class="col-span-4 leading-tight">
                    <p class="text-[#8B0000] font-semibold text-[16px]">Romero, Dianna</p>
                    <p class="text-[#8B0000] text-[13px]">2023-00010 · BSIT · 2nd Year · Section 1</p>
                    <span class="patient-info hidden">BSIT|2nd Year|1|2025-01-20</span>
                  </div>

                  <div class="col-span-4 space-y-2">
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-calendar text-[14px]"></i>
                      <span class="text-[14px] font-medium">January 20, 2025</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-clock text-[14px]"></i>
                      <span class="text-[14px] font-medium">9:00 AM</span>
                    </div>
                  </div>

                  <div class="col-span-3 space-y-2">
                    <p class="text-[#8B0000] text-[15px] font-medium">Dental Checkup</p>
                    <p class="text-green-700 text-[13px] flex items-center gap-2">
                      <span class="text-green-700 text-[18px] leading-none">•</span>
                      Appointment Today
                    </p>
                  </div>

                  <div class="col-span-1 flex justify-end items-center">
                    <span class="text-[#8B0000] text-2xl leading-none">→</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Patient Card 2 -->
            <div class="patient-item today relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
              <div class="absolute left-0 top-0 h-full w-2 bg-[#2E2E2E] rounded-l-md"></div>

              <div class="flex items-center w-full px-6 py-6 pl-10">
                <img src="https://i.pravatar.cc/52" class="w-20 h-20 rounded-full object-cover shadow" alt="Patient"/>

                <div class="ml-6 flex-1 grid grid-cols-12 gap-6 items-start">
                  <div class="col-span-4 leading-tight">
                    <p class="text-[#8B0000] font-semibold text-[16px]">Dela Cruz, Mark</p>
                    <p class="text-[#8B0000] text-[13px]">2023-00011 · BSECE · 1st Year · Section 2</p>
                    <span class="patient-info hidden">BSECE|1st Year|2|2025-01-20</span>
                  </div>

                  <div class="col-span-4 space-y-2">
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-calendar text-[14px]"></i>
                      <span class="text-[14px] font-medium">January 20, 2025</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-clock text-[14px]"></i>
                      <span class="text-[14px] font-medium">11:30 AM</span>
                    </div>
                  </div>

                  <div class="col-span-3 space-y-2">
                    <p class="text-[#8B0000] text-[15px] font-medium">Tooth Cleaning</p>
                    <p class="text-green-700 text-[13px] flex items-center gap-2">
                      <span class="text-green-700 text-[18px] leading-none">•</span>
                      Appointment Today
                    </p>
                  </div>

                  <div class="col-span-1 flex justify-end items-center">
                    <span class="text-[#8B0000] text-2xl leading-none">→</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Rescheduled -->
            <div class="patient-item rescheduled relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
              <div class="absolute left-0 top-0 h-full w-2 bg-orange-600 rounded-l-md"></div>

              <div class="flex items-center w-full px-6 py-6 pl-10">
                <img src="https://i.pravatar.cc/54" class="w-20 h-20 rounded-full object-cover shadow" alt="Patient"/>

                <div class="ml-6 flex-1 grid grid-cols-12 gap-6 items-start">
                  <div class="col-span-4 leading-tight">
                    <p class="text-[#8B0000] font-semibold text-[16px]">Reyes, Joshua</p>
                    <p class="text-[#8B0000] text-[13px]">2023-00013 · BSED - ENG · 2nd Year · Section 1</p>
                    <span class="patient-info hidden">BSED - ENG|2nd Year|1|2025-01-22</span>
                  </div>

                  <div class="col-span-4 space-y-2">
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-calendar text-[14px]"></i>
                      <span class="text-[14px] font-medium">January 22, 2025</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-clock text-[14px]"></i>
                      <span class="text-[14px] font-medium">10:00 AM</span>
                    </div>
                  </div>

                  <div class="col-span-3 space-y-2">
                    <p class="text-[#8B0000] text-[15px] font-medium">Tooth Extraction</p>
                    <p class="text-orange-600 text-[13px] flex items-center gap-2">
                      <span class="text-orange-600 text-[18px] leading-none">•</span>
                      Rescheduled
                    </p>
                  </div>

                  <div class="col-span-1 flex justify-end items-center">
                    <span class="text-[#8B0000] text-2xl leading-none">→</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="patient-item rescheduled relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
              <div class="absolute left-0 top-0 h-full w-2 bg-orange-600 rounded-l-md"></div>

              <div class="flex items-center w-full px-6 py-6 pl-10">
                <img src="https://i.pravatar.cc/55" class="w-20 h-20 rounded-full object-cover shadow" alt="Patient"/>

                <div class="ml-6 flex-1 grid grid-cols-12 gap-6 items-start">
                  <div class="col-span-4 leading-tight">
                    <p class="text-[#8B0000] font-semibold text-[16px]">Garcia, Nicole</p>
                    <p class="text-[#8B0000] text-[13px]">2023-00014 · BSOA · 1st Year · Section 2</p>
                    <span class="patient-info hidden">BSOA|1st Year|2|2025-01-23</span>
                  </div>

                  <div class="col-span-4 space-y-2">
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-calendar text-[14px]"></i>
                      <span class="text-[14px] font-medium">January 23, 2025</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-clock text-[14px]"></i>
                      <span class="text-[14px] font-medium">1:00 PM</span>
                    </div>
                  </div>

                  <div class="col-span-3 space-y-2">
                    <p class="text-[#8B0000] text-[15px] font-medium">Dental Surgery</p>
                    <p class="text-orange-600 text-[13px] flex items-center gap-2">
                      <span class="text-orange-600 text-[18px] leading-none">•</span>
                      Rescheduled
                    </p>
                  </div>

                  <div class="col-span-1 flex justify-end items-center">
                    <span class="text-[#8B0000] text-2xl leading-none">→</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="patient-item rescheduled relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
              <div class="absolute left-0 top-0 h-full w-2 bg-orange-600 rounded-l-md"></div>

              <div class="flex items-center w-full px-6 py-6 pl-10">
                <img src="https://i.pravatar.cc/56" class="w-20 h-20 rounded-full object-cover shadow" alt="Patient"/>

                <div class="ml-6 flex-1 grid grid-cols-12 gap-6 items-start">
                  <div class="col-span-4 leading-tight">
                    <p class="text-[#8B0000] font-semibold text-[16px]">Lopez, Christian</p>
                    <p class="text-[#8B0000] text-[13px]">2023-00015 · BSPSYCH · 3rd Year · Section 1</p>
                    <span class="patient-info hidden">BSPSYCH|3rd Year|1|2025-01-24</span>
                  </div>

                  <div class="col-span-4 space-y-2">
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-calendar text-[14px]"></i>
                      <span class="text-[14px] font-medium">January 24, 2025</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-clock text-[14px]"></i>
                      <span class="text-[14px] font-medium">4:30 PM</span>
                    </div>
                  </div>

                  <div class="col-span-3 space-y-2">
                    <p class="text-[#8B0000] text-[15px] font-medium">Dental Consultation</p>
                    <p class="text-orange-600 text-[13px] flex items-center gap-2">
                      <span class="text-orange-600 text-[18px] leading-none">•</span>
                      Rescheduled
                    </p>
                  </div>

                  <div class="col-span-1 flex justify-end items-center">
                    <span class="text-[#8B0000] text-2xl leading-none">→</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Additional Patients (Today) -->
            <div class="patient-item today relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
              <div class="absolute left-0 top-0 h-full w-2 bg-[#2E2E2E] rounded-l-md"></div>

              <div class="flex items-center w-full px-6 py-6 pl-10">
                <img src="https://i.pravatar.cc/57" class="w-20 h-20 rounded-full object-cover shadow" alt="Patient"/>

                <div class="ml-6 flex-1 grid grid-cols-12 gap-6 items-start">
                  <div class="col-span-4 leading-tight">
                    <p class="text-[#8B0000] font-semibold text-[16px]">Villanueva, Emily</p>
                    <p class="text-[#8B0000] text-[13px]">2023-00016 · BSECE · 2nd Year · Section 1</p>
                    <span class="patient-info hidden">BSECE|2nd Year|1|2025-01-20</span>
                  </div>

                  <div class="col-span-4 space-y-2">
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-calendar text-[14px]"></i>
                      <span class="text-[14px] font-medium">January 20, 2025</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#8B0000]">
                      <i class="fa-regular fa-clock text-[14px]"></i>
                      <span class="text-[14px] font-medium">2:00 PM</span>
                    </div>
                  </div>

                  <div class="col-span-3 space-y-2">
                    <p class="text-[#8B0000] text-[15px] font-medium">Tooth Cleaning</p>
                    <p class="text-green-700 text-[13px] flex items-center gap-2">
                      <span class="text-green-700 text-[18px] leading-none">•</span>
                      Appointment Today
                    </p>
                  </div>

                  <div class="col-span-1 flex justify-end items-center">
                    <span class="text-[#8B0000] text-2xl leading-none">→</span>
                  </div>
                </div>
              </div>
            </div>

          </div> <!-- END #patientContainer -->
        </div> <!-- END tabs/card wrapper -->
      </div> <!-- END mx-4 -->
    </div> <!-- END w-full max-w-6xl -->
  </div> <!-- END main white card -->
</main>

<!-- FILTER MODAL  -->

<div id="filterModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-[760px] rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
    <!-- Header -->
    <div class="px-6 py-4 flex items-center gap-3">
      <i class="fa-solid fa-sliders text-[#8B0000]"></i>
      <h2 class="text-xl font-medium text-[#8B0000]">Filter</h2>
    </div>
    <div class="h-px bg-gray-200"></div>

    <div class="px-6 py-5 space-y-5">

      <!-- Sort -->
      <div class="space-y-3">
        <p class="text-sm text-gray-500">Sort</p>
        <div class="space-y-2">
          <label class="flex items-center gap-3 text-sm text-gray-700">
            <input type="radio" name="sort" value="A-Z" class="filter-input radio-red" />
            A-Z
          </label>
          <label class="flex items-center gap-3 text-sm text-gray-700">
            <input type="radio" name="sort" value="Z-A" class="filter-input radio-red" />
            Z-A
          </label>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- Date Range + (Ascending/Descending on the right like screenshot) -->
      <div class="space-y-3">
        <p class="text-sm text-gray-500">Date Range</p>

        <div class="grid grid-cols-12 gap-6 items-start">
          <!-- From/To -->
          <div class="col-span-8">
            <div class="grid grid-cols-2 gap-10">
              <div class="space-y-2">
                <label class="text-sm text-gray-700">From:</label>
                <input
                  type="date"
                  id="fromDate"
                  class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200"
                />
              </div>

              <div class="space-y-2">
                <label class="text-sm text-gray-700">To:</label>
                <input
                  type="date"
                  id="toDate"
                  class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200"
                />
              </div>
            </div>
          </div>

          <!-- Right radios (visual only; DOES NOT affect your JS unless you want it to) -->
          <div class="col-span-4 space-y-2 pt-6">
            <label class="flex items-center gap-3 text-sm text-gray-700">
              <input type="radio" name="dateOrder" value="Ascending" class="radio-red" />
              Ascending
            </label>
            <label class="flex items-center gap-3 text-sm text-gray-700">
              <input type="radio" name="dateOrder" value="Descending" class="radio-red" />
              Descending
            </label>
          </div>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- Course -->
      <div class="space-y-3">
        <p class="text-sm text-gray-500">Course</p>

        <div class="grid grid-cols-6 gap-x-8 gap-y-4 text-sm text-gray-700">
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSIT" class="filter-input radio-red"/> BSIT</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSECE" class="filter-input radio-red"/> BSECE</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSBA - HRM" class="filter-input radio-red"/> BSBA - HRM</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSED - ENG" class="filter-input radio-red"/> BSED - ENG</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSOA" class="filter-input radio-red"/> BSOA</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSPSYCH" class="filter-input radio-red"/> BSPSYCH</label>

          <label class="flex items-center gap-3"><input type="radio" name="course" value="DIT" class="filter-input radio-red"/> DIT</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSME" class="filter-input radio-red"/> BSME</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSBA - MM" class="filter-input radio-red"/> BSBA - MM</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSED - MATH" class="filter-input radio-red"/> BSED - MATH</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="DOMT" class="filter-input radio-red"/> DOMT</label>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- Year + Section -->
      <div class="grid grid-cols-12 gap-10">
        <!-- Year -->
        <div class="col-span-6 space-y-3">
          <p class="text-sm text-gray-500">Year</p>
          <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="year" value="1st Year" class="filter-input radio-red"/> 1st Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="3rd Year" class="filter-input radio-red"/> 3rd Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="2nd Year" class="filter-input radio-red"/> 2nd Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="4th Year" class="filter-input radio-red"/> 4th Year</label>
          </div>
        </div>

        <!-- Section -->
        <div class="col-span-6 space-y-3">
          <p class="text-sm text-gray-500">Section</p>
          <div class="space-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="section" value="1" class="filter-input radio-red"/> 1</label>
            <label class="flex items-center gap-3"><input type="radio" name="section" value="2" class="filter-input radio-red"/> 2</label>
          </div>
        </div>
      </div>

    </div>

    <div class="h-px bg-gray-200"></div>

    <!-- Footer actions -->
    <div class="px-6 py-4 flex items-center justify-between">
      <button id="clearFiltersModal" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
        Clear
      </button>

      <!-- keep id="applyFilters" so your JS still works -->
      <button id="applyFilters" type="button"
        class="bg-[#8B0000] text-white px-8 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000]">
        Save
      </button>
    </div>
  </div>
</div>


<!-- Footer -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">
  <!-- Footer content here (unchanged) -->
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const patientContainer = document.getElementById("patientContainer");
  if (!patientContainer) return;

  const allPatients = Array.from(patientContainer.querySelectorAll(".patient-item"));

  const filterModal = document.getElementById("filterModal");
  const openFilter = document.getElementById("openFilter");
  const clearFiltersModal = document.getElementById("clearFiltersModal");
  const applyFilters = document.getElementById("applyFilters");
  const searchInput = document.getElementById("searchInput");
  const clearBtn = document.getElementById("clearBtn");
  const filterButtons = document.querySelectorAll(".filter-btn");

  const scheduledBtnCount = document.querySelector('.filter-btn[data-filter="today"] h3');
  const rescheduledBtnCount = document.querySelector('.filter-btn[data-filter="rescheduled"] h3');
  const allBtnCount = document.querySelector('.filter-btn[data-filter="all"] h3');

  // --- State
  let activeTab = "all";
  let activeSearch = "";
  let activeSort = null;
  let activeCourse = null;
  let activeYear = null;
  let activeSection = null;
  let activeFromDate = "";
  let activeToDate = "";

  // Modal open/close
  openFilter?.addEventListener("click", (e) => {
    e.preventDefault();
    filterModal.classList.remove("hidden");
  });

  filterModal?.addEventListener("click", (e) => {
    if (e.target === filterModal) filterModal.classList.add("hidden");
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") filterModal.classList.add("hidden");
  });

  // Clear button next to search (clears ONLY search text)
  clearBtn?.addEventListener("click", () => {
    if (!searchInput) return;
    searchInput.value = "";
    searchInput.dispatchEvent(new Event("input"));
  });

  function getInfo(p) {
    const raw = p.querySelector(".patient-info")?.textContent?.trim() || "";
    const parts = raw.split("|");
    return {
      course: parts[0] || "",
      year: parts[1] || "",
      section: parts[2] || "",
      dateStr: parts[3] || ""
    };
  }

  function getName(p) {
    return (p.querySelector(".font-semibold")?.textContent || "").trim();
  }

  function passesFilters(p, tabOverride = null) {
    const tabToUse = tabOverride ?? activeTab;

    if (tabToUse !== "all" && !p.classList.contains(tabToUse)) return false;

    if (activeSearch) {
      const name = getName(p).toLowerCase();
      if (!name.includes(activeSearch)) return false;
    }

    const info = getInfo(p);

    if (activeCourse && !info.course.includes(activeCourse)) return false;
    if (activeYear && !info.year.includes(activeYear)) return false;
    if (activeSection && info.section !== activeSection) return false;

    if (activeFromDate || activeToDate) {
      const d = info.dateStr ? new Date(info.dateStr) : null;
      if (!d || isNaN(d.getTime())) return false;

      if (activeFromDate && d < new Date(activeFromDate)) return false;
      if (activeToDate && d > new Date(activeToDate)) return false;
    }

    return true;
  }

  function applyAll() {
    let filtered = allPatients.filter(p => passesFilters(p));

    if (activeSort) {
      filtered.sort((a, b) => {
        const nameA = getName(a).toUpperCase();
        const nameB = getName(b).toUpperCase();
        return activeSort === "A-Z"
          ? nameA.localeCompare(nameB)
          : nameB.localeCompare(nameA);
      });
    }

    patientContainer.innerHTML = "";
    filtered.forEach(p => patientContainer.appendChild(p));

    updateCounts();
  }

  function updateCounts() {
    const todayCount = allPatients.filter(p => passesFilters(p, "today")).length;
    const rescheduledCount = allPatients.filter(p => passesFilters(p, "rescheduled")).length;

    const prevTab = activeTab;
    activeTab = "all";
    const allCount = allPatients.filter(p => passesFilters(p, "all")).length;
    activeTab = prevTab;

    if (scheduledBtnCount) scheduledBtnCount.textContent = todayCount;
    if (rescheduledBtnCount) rescheduledBtnCount.textContent = rescheduledCount;
    if (allBtnCount) allBtnCount.textContent = allCount;
  }

  // Tabs
  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      activeTab = btn.dataset.filter;
      applyAll();
    });
  });

  // Live search
  searchInput?.addEventListener("input", () => {
    activeSearch = searchInput.value.trim().toLowerCase();
    applyAll();
  });

  // Apply filters in modal
  applyFilters?.addEventListener("click", () => {
    activeSort = filterModal.querySelector('input[name="sort"]:checked')?.value || null;
    activeCourse = filterModal.querySelector('input[name="course"]:checked')?.value || null;
    activeYear = filterModal.querySelector('input[name="year"]:checked')?.value || null;
    activeSection = filterModal.querySelector('input[name="section"]:checked')?.value || null;
    activeFromDate = document.getElementById("fromDate").value || "";
    activeToDate = document.getElementById("toDate").value || "";

    filterModal.classList.add("hidden");
    applyAll();
  });

  // Clear filters in modal
  clearFiltersModal?.addEventListener("click", () => {
    filterModal.querySelectorAll(".filter-input").forEach(i => i.checked = false);
    document.getElementById("fromDate").value = "";
    document.getElementById("toDate").value = "";

    activeSort = null;
    activeCourse = null;
    activeYear = null;
    activeSection = null;
    activeFromDate = "";
    activeToDate = "";

    filterModal.classList.add("hidden");
    applyAll();
  });

  // Initial render
  applyAll();
});
</script>

</body>
</html>
