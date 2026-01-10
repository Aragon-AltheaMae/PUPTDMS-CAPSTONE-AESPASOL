<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PUP Taguig Dental Clinic | About Us</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

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

    /* Custom FAQ */
    .faq-content {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.5s ease, opacity 0.5s ease;
  }

  .faq-item.open .faq-content {
    max-height: 500px; /* adjust to content */
    opacity: 1;
  }

  /* Fade-up animation */
  .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
  }

  .fade-up.show {
    opacity: 1;
    transform: translateY(0);
  }
  </style>
</head>
<body class="bg-white text-[#333333] font-normal">

  <!-- HEADER (TOP BAR) -->
  <div class="bg-gradient-to-r from-red-900 to-red-700 text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
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
            {{ $patient->name }}
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

  <!-- NAVIGATION -->
  <div class="bg-red-800 text-[#F4F4F4] px-6">
  <div class="max-w-7xl mx-auto flex justify-center gap-8 py-3">
    
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
              after:absolute after:left-0 after:bottom-0
              after:h-[2px] after:w-full
              after:bg-[#FFD700]
              after:opacity-0
              after:transition-opacity after:duration-300
              hover:after:opacity-100">
      Record
    </a>

    <a href="{{ route('about.us') }}"
    class=   "font-bold
             relative pb-1
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

  <!-- BANNER -->
  <section class="relative bg-gray-50 py-24 text-center fade-up">
    <img src="{{ asset('images/PUP TAGUIG CAMPUS.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none"
    />
    <h2 class="relative z-10 font-extrabold text-4xl text-[#8B0000] fade-up">About Us</h2>
  </section>

  <!-- MAIN CONTENT -->
  <main class="max-w-5xl mx-auto px-6 mb-12 space-y-12">

    <p class="text-[#8B0000] text-lg leading-relaxed text-justify text-wrap mt-8 fade-up">
      The Polytechnic University of the Philippines – Taguig Campus is committed to promoting the 
      health and well-being of its academic community by providing free dental services to students, 
      alumni, faculty, and staff. These services aim to support overall wellness and ensure access to 
      basic dental care within the campus.
    </p>

    <!-- CARD -->
    <div class="bg-gradient-to-br from-[#8B0000] to-[#660000] text-[#F4F4F4]
    rounded-2xl pl-12 flex flex-col md:flex-row items-center gap-4 shadow-lg fade-up">
        <div class="flex-1 font-normal text-2xl leading-relaxed">
            The dental clinic is headed by <span class="font-bold text-2xl">Dr. Nelson P. Angeles</span>,
            <br>the campus dentist, who delivers professional, safe, and reliable dental care.
        </div>
        <img src="images/Nelson-Angeles.png" alt="Dr. Nelson P. Angeles" class="w-1/3 object-contain" />
    </div>

    <!-- FAQs Title -->
    <h3 class="font-extrabold text-[#8B0000] text-center mt-8 mb-4 text-3xl fade-up">Frequently Asked Questions</h3>
    <section class="max-w-3xl mx-auto mt-2 rounded-2xl bg-gradient-to-br from-[#660000] to-[#FFD700] p-1 fade-up">
    <div class="bg-white rounded-2xl p-4">

    <!-- FAQ 1 -->
    <div id="faq1" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
            aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
        <span class="text-yellow-500 mr-2">•</span>
        <span class="text-[#8B0000]">Who can avail of the dental services at the University Dental Clinic?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
            stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div id="faq1-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
        All students, alumni, faculty, and staff of the University are eligible for free dental services.
    </div>
    </div>

    <!-- FAQ 2 -->
    <div id="faq2" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">How do I book an appointment?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq2-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      You can book an appointment through the Dental Management System online portal.
    </div>
    </div>

    <!-- FAQ 3 -->
    <div id="faq3" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">Will the dentist prescribe medications during my visit?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq3-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      Yes, depending on your dental condition, the dentist may prescribe 
      antibiotics, pain relievers, or other medications.
    </div>
    </div>

    <!-- FAQ 4 -->
    <div id="faq4" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">Can I make an appointment anytime?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq4-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      Appointments are subject to availability. Since the clinic has limited 
      slots and only one dentist, early booking is recommended.
    </div>
    </div>

    <!-- FAQ 5 -->
     <div id="faq5" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">How can I cancel or reschedule my appointment?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq5-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      Appointments can be canceled or rescheduled through the Dental Management System 
      or by contacting the clinic directly at least three (3) days before the scheduled appointment.
    </div>
    </div>

    <!-- FAQ 6 -->
    <div id="faq6" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">What happens if the University Dentist is unavailable on my scheduled day?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq6-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      If the dentist is unavailable, your confirmed schedule will be rescheduled to the next available slot.
    </div>
    </div>

    <!-- FAQ 7 -->
    <div id="faq7" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]"> What services are offered at the University Dental Clinic?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq7-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      The clinic provides basic dental check-ups, cleaning, fillings, extractions, 
      oral health advice, and other preventive care services.
    </div>
    </div>

    <!-- FAQ 8 -->
    <div id="faq8" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">Is there a priority system for urgent dental cases?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq8-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      Yes, urgent cases may be given priority, but it depends on the daily schedule and the dentist’s discretion.
    </div>
    </div>

    <!-- FAQ 9 -->
    <div id="faq9" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">Are there any restrictions for certain treatments?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq9-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-regular rounded-b-lg">
      Some advanced dental procedures may not be available due to the clinic’s resources. 
      The dentist will provide guidance on alternatives if needed.
    </div>
    </div>

    <!-- FAQ 10 -->
    <div id="faq10" class="faq-item rounded-lg mb-3 shadow-lg overflow-hidden border border-gray-300">
    <button class="w-full flex justify-between items-center p-4 bg-white font-semibold cursor-pointer
                    text-left rounded-t-lg"
        aria-expanded="false" onclick="toggleFAQ(this)">
        <span>
            <span class="text-yellow-500 mr-2">•</span>
            <span class="text-[#8B0000]">Are follow-up appointments required?</span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8B0000]" fill="none" viewBox="0 0 24 24" 
        stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
        </button>
    <div id="faq10-content" class="faq-content bg-red-900 text-[#F4F4F4] p-3 font-semibold rounded-b-lg">
      Some treatments may require follow-up visits. The dentist will advise if a follow-up is necessary.
    </div>
    </div>
</section>

  <p class="text-[#8B0000] text-xl leading-relaxed text-justify text-wrap mt-10 fade-up">
      The PUPT Dental Management System was developed to manage records and appointments more effectively,
      ensuring an efficient dental service while supporting the University's commitment to quality and accessible care.
    </p>
    
    <!-- DEVELOPERS -->
    <section class="text-center text-2xl mt-12">
      <h3 class="font-extrabold text-[#8B0000] mb-4 fade-up">The Developers</h3>
      <div class="flex justify-center gap-6 fade-up">
        <img src="images/Althea-Aragon.png" alt="Althea Aragon" class="h-32 w-32 rounded-md shadow-lg border border-yellow-400 object-cover" />
        <img src="images/Grace-Lim.png" alt="Grace Lim" class="h-32 w-32 rounded-md border shadow-lg border-yellow-400 object-cover" />
        <img src="images/Hoshea-Lopez.png" alt="Hoshea Lopez" class="h-32 w-32 rounded-md shadow-lg border border-yellow-400 object-cover" />
        <img src="images/Rain-Romero.png" alt="Rain Romero" class="h-32 w-32 rounded-md shadow-lg border border-yellow-400 object-cover" />
      </div>
    </section>

  </main>

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

  <script>
    function toggleFAQ(button) {
    const item = button.parentElement;
    const content = item.querySelector('.faq-content');

    if (item.classList.contains('open')) {
        content.style.maxHeight = 0;
        content.style.opacity = 0;
        item.classList.remove('open');
        button.setAttribute('aria-expanded', 'false');
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
        content.style.opacity = 1;
        item.classList.add('open');
        button.setAttribute('aria-expanded', 'true');
    }
    }
  

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
        }
      });
    },
    { threshold: 0.15 }
  );

  document.querySelectorAll('.fade-up').forEach(el => {
    observer.observe(el);
  });
</script>
</body>
</html>