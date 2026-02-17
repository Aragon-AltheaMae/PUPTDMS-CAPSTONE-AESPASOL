<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Document Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter'; }
    .fade-in { animation: fadeIn .4s ease-out both; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }
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
      <span class="font-bold">Dashboard</span>
    </a>

    <a href="{{ route('dentist.patients') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-users text-lg"></i>
      <span>Patients</span>
    </a>

    <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-calendar-check text-lg font-bold"></i>
      <span>Appointments</span>
    </a>

    <a href="{{ route('dentist.documentrequests') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-file-circle-check text-lg"></i>
      <span>Document Requests</span>
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

<!-- MAIN CONTENT -->
<main class="max-w-7xl mx-auto px-6 py-10 fade-in">

  <!-- MAIN WHITE CARD -->
  <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#8B0000]/30">

    <!-- HEADER ROW -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
      <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 to-orange-400 bg-clip-text text-transparent">
        Document Requests
      </h2>

      <!-- SEARCH / FILTER -->
      <div class="flex items-center gap-6 w-full md:w-auto">
        <div class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
          <div class="flex items-center bg-white rounded-full overflow-hidden w-full">

            <div class="flex items-center gap-2 pl-3 pr-5 py-2 flex-1">
              <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
              </span>

              <input
                type="text"
                placeholder="Search"
                class="w-full md:w-72 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none"
              />
            </div>

            <div class="w-[2px] self-stretch bg-[#F2C94C]"></div>

            <button
              type="button"
              class="flex items-center gap-2 px-6 py-2 text-sm font-medium text-[#8B0000] bg-white hover:bg-[#FFF7E6]"
            >
              <i class="fa-solid fa-sliders text-[13px]"></i>
              <span>Filter</span>
            </button>

          </div>
        </div>

        <button class="text-[#8B0000] text-sm font-medium hover:underline">
          Clear
        </button>
      </div>
    </div>

    <!-- TABS CONTAINER -->
    <div class="mx-4 border border-gray-200 rounded-2xl bg-white overflow-hidden">

      <div class="flex gap-4 flex-wrap px-4 pt-4 -mb-px">

        <!-- ALL -->
        <button class="bg-[#8B0000] text-white rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">9</h3>
          <p class="text-base">All Requests</p>
        </button>

        <!-- PENDING -->
        <button class="bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">3</h3>
          <p class="text-base">Pending Requests</p>
        </button>

        <!-- APPROVED -->
        <button class="bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">3</h3>
          <p class="text-base">Approved Requests</p>
        </button>

        <!-- REJECTED -->
        <button class="bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">3</h3>
          <p class="text-base">Rejected Requests</p>
        </button>

      </div>

      <!-- SECTION LABEL -->
      <div class="px-6 py-4 text-[22px] font-medium text-gray-700">
        Click to Access Document Request
      </div>

      <!-- REQUEST LIST -->
      <div class="space-y-4 px-6 pb-6">

        <!-- APPROVED -->
        <div class="relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
          <div class="absolute left-0 top-0 h-full w-2 bg-green-600 rounded-l-md"></div>

          <div class="flex items-center w-full px-6 py-6 pl-10">
            <div class="grid grid-cols-12 gap-6 items-center w-full">

              <div class="col-span-3">
                <p class="text-[#8B0000] font-semibold">Capilitan, Beyonce</p>
                <p class="text-sm text-gray-600">BSIT 3-1</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Date Requested</p>
                <p class="font-medium">December 25, 2025</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Document</p>
                <p class="font-medium">Dental Clearance</p>
              </div>

              <div class="col-span-2">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-semibold text-green-600">APPROVED</p>
              </div>

              <div class="col-span-1 flex justify-end">
                <button class="bg-[#8B0000] text-white px-4 py-1 rounded-md hover:bg-[#760000]">
                  View
                </button>
              </div>

            </div>
          </div>
        </div>

        <!-- PENDING -->
        <div class="relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
          <div class="absolute left-0 top-0 h-full w-2 bg-orange-500 rounded-l-md"></div>

          <div class="flex items-center w-full px-6 py-6 pl-10">
            <div class="grid grid-cols-12 gap-6 items-center w-full">

              <div class="col-span-3">
                <p class="text-[#8B0000] font-semibold">Romero, Dianna</p>
                <p class="text-sm text-gray-600">Faculty</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Date Requested</p>
                <p class="font-medium">December 25, 2025</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Document</p>
                <p class="font-medium">Annual Dental Clearance</p>
              </div>

              <div class="col-span-2">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-semibold text-orange-500">PENDING</p>
              </div>

              <div class="col-span-1 flex justify-end">
                <button class="bg-[#8B0000] text-white px-4 py-1 rounded-md hover:bg-[#760000]">
                  View
                </button>
              </div>

            </div>
          </div>
        </div>

        <!-- REJECTED -->
        <div class="relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
          <div class="absolute left-0 top-0 h-full w-2 bg-red-600 rounded-l-md"></div>

          <div class="flex items-center w-full px-6 py-6 pl-10">
            <div class="grid grid-cols-12 gap-6 items-center w-full">

              <div class="col-span-3">
                <p class="text-[#8B0000] font-semibold">Lopez, Hoshea</p>
                <p class="text-sm text-blue-600 underline">Administrative</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Date Requested</p>
                <p class="font-medium">December 25, 2025</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Document</p>
                <p class="font-medium">Dental Health Record</p>
              </div>

              <div class="col-span-2">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-semibold text-red-600">REJECTED</p>
              </div>

              <div class="col-span-1 flex justify-end">
                <button class="bg-[#8B0000] text-white px-4 py-1 rounded-md hover:bg-[#760000]">
                  View
                </button>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex items-center justify-center gap-4 mt-8 text-sm">
    <span class="text-gray-300">‹ Previous</span>
    <span class="text-[#8B0000] font-semibold">1</span>
    <span>2</span>
    <span>3</span>
    <span>…</span>
    <span>50</span>
    <button class="text-[#8B0000] hover:underline">Next ›</button>
  </div>

</main>

</body>
</html>
