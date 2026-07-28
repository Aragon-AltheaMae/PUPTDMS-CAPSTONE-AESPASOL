@extends('layouts.app')

@section('layout-role', 'dentist')

@section('title', 'Add Existing Record')

@vite('resources/css/pages/dentist/add-existing-record.css')

@section('content')
<main id="mainContent" class="dentist-page-shell">
    <div class="w-full animate-fade-up pt-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#660000]">
                <i class="fa-solid fa-folder-open mr-2 text-[#8B0000]"></i>
                Add Existing Record
            </h1>
            <span class="text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                Select a patient to import a paper record
            </span>
        </div>

        <div class="section-card mb-6">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#9e9690] text-sm"></i>
                <input type="text" id="patientSearchInput"
                    class="w-full border border-[#e8e2dd] rounded-xl bg-white outline-none pl-10 pr-10 py-3 text-sm"
                    placeholder="Search by name, ID, email, or program..."
                    autocomplete="off">
                <button type="button" id="clearSearch" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9e9690] hover:text-[#8B0000] hidden">
                    <i class="fa-solid fa-circle-xmark text-lg"></i>
                </button>
            </div>
        </div>

        <div id="patientGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($patients as $patient)
            <div class="patient-select-card" data-name="{{ strtolower($patient->name) }}" data-email="{{ strtolower($patient->email) }}" data-student="{{ strtolower($patient->student_no ?? '') }}" data-program="{{ strtolower($patient->course_name ?? '') }}">
                <div class="patient-select-card-body">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="patient-select-name">{{ $patient->name }}</p>
                            <p class="patient-select-meta">{{ $patient->email }}</p>
                        </div>
                        <span class="patient-select-badge">{{ $patient->student_no ?: ($patient->gender ?? 'Patient') }}</span>
                    </div>
                    <div class="patient-select-details">
                        @if($patient->course_name)
                        <span class="patient-select-tag"><i class="fa-solid fa-graduation-cap text-[10px] mr-1"></i>{{ $patient->course_name }}</span>
                        @endif
                        @if($patient->year_level)
                        <span class="patient-select-tag"><i class="fa-solid fa-layer-group text-[10px] mr-1"></i>Year {{ $patient->year_level }}</span>
                        @endif
                        @if($patient->section)
                        <span class="patient-select-tag"><i class="fa-solid fa-users text-[10px] mr-1"></i>Section {{ $patient->section }}</span>
                        @endif
                    </div>
                </div>
                <div class="patient-select-actions">
                    <a href="{{ route('dentist.odontogram.historical.create', ['patient' => $patient->id]) }}" class="select-patient-btn">
                        <i class="fa-solid fa-arrow-right"></i>
                        Continue
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full empty-state py-12">
                <i class="fa-solid fa-folder-open text-4xl text-[#e8e2dd] mb-3"></i>
                <p class="text-sm text-[#9e9690]">No patients recorded yet.</p>
            </div>
            @endforelse
        </div>

        <div id="noResults" class="hidden empty-state py-12">
            <i class="fa-solid fa-magnifying-glass text-3xl text-[#e8e2dd] mb-3"></i>
            <p class="text-sm text-[#9e9690]">No matching patients found.</p>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('patientSearchInput');
    const clearBtn = document.getElementById('clearSearch');
    const cards = document.querySelectorAll('.patient-select-card');
    const noResults = document.getElementById('noResults');

    function filterCards() {
        const query = input.value.trim().toLowerCase();
        let visibleCount = 0;

        clearBtn.classList.toggle('hidden', !query);

        cards.forEach(function (card) {
            const name = card.getAttribute('data-name') || '';
            const email = card.getAttribute('data-email') || '';
            const student = card.getAttribute('data-student') || '';
            const program = card.getAttribute('data-program') || '';
            const match = !query || name.includes(query) || email.includes(query) || student.includes(query) || program.includes(query);

            card.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        noResults.classList.toggle('hidden', visibleCount > 0);
    }

    input.addEventListener('input', filterCards);
    clearBtn.addEventListener('click', function () {
        input.value = '';
        filterCards();
        input.focus();
    });

    if (cards.length > 0) {
        input.focus();
    }
});
</script>
@endsection
