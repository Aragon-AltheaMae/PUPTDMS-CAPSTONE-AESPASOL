@extends('layouts.app')

@section('layout-role', 'dentist')

@section('title', 'Add Existing Record')

@vite('resources/css/app.css')

@section('content')
<main id="mainContent" class="dentist-page-shell existing-record-page">
    <div class="w-full animate-fade-up pt-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="existing-record-title text-2xl sm:text-3xl font-extrabold text-[#660000]">
                <i class="fa-solid fa-folder-open mr-2 text-[#8B0000]"></i>
                Add Existing Record
            </h1>
            <span class="existing-record-chip text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                Select a patient to import a paper record
            </span>
        </div>

        <div class="section-card existing-record-search-card mb-6">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass existing-record-search-icon absolute left-4 top-1/2 -translate-y-1/2 text-[#9e9690] text-sm"></i>
                <input type="text" id="patientSearchInput"
                    class="existing-record-search-input w-full border border-[#e8e2dd] rounded-xl bg-white outline-none pl-10 pr-10 py-3 text-sm"
                    placeholder="Search by name, ID, email, or program..."
                    autocomplete="off">
                <button type="button" id="clearSearch" class="existing-record-clear-btn absolute right-3 top-1/2 -translate-y-1/2 text-[#9e9690] hover:text-[#8B0000] hidden">
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

        <div id="noResults" class="hidden empty-state py-12" hidden>
            <i class="fa-solid fa-magnifying-glass text-3xl text-[#e8e2dd] mb-3"></i>
            <p class="text-sm text-[#9e9690]">No matching patients found.</p>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('patientSearchInput');
    const clearBtn = document.getElementById('clearSearch');
    const patientGrid = document.getElementById('patientGrid');
    const initialMarkup = patientGrid ? patientGrid.innerHTML : '';
    const initialCards = patientGrid ? Array.from(patientGrid.querySelectorAll('.patient-select-card')) : [];
    const noResults = document.getElementById('noResults');
    const searchEndpoint = @json(route('dentist.walk-in.search-patient'));
    const recordUrlTemplate = @json(route('dentist.odontogram.historical.create', ['patient' => '__PATIENT__']));
    let activeRequestId = 0;
    let searchTimer = null;
    let latestAllPatients = null;

    function escapeHtml(value) {
        return String(value || '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function buildRecordUrl(patient) {
        if (patient.record_url) {
            return patient.record_url;
        }

        return recordUrlTemplate.replace('__PATIENT__', encodeURIComponent(String(patient.id || '')));
    }

    function patientMatchesQuery(patient, normalizedQuery) {
        const haystack = [
            patient.name || '',
            patient.email || '',
            patient.student_number || '',
            patient.program || '',
            patient.type || '',
        ].join(' ').toLowerCase();

        return haystack.includes(normalizedQuery);
    }

    function renderEmptyState(message) {
        if (!patientGrid) return;

        patientGrid.innerHTML = '';
        noResults.classList.remove('hidden');
        noResults.removeAttribute('hidden');
        noResults.querySelector('p').textContent = message;
    }

    function renderInitialPatients() {
        if (!patientGrid) return;

        if (Array.isArray(latestAllPatients)) {
            renderPatients(latestAllPatients);
            return;
        }

        patientGrid.innerHTML = initialMarkup;
        noResults.classList.add('hidden');
        noResults.setAttribute('hidden', 'hidden');
    }

    function filterInitialPatients(query) {
        if (!patientGrid) return false;

        const normalizedQuery = String(query || '').trim().toLowerCase();

        if (!normalizedQuery) {
            renderInitialPatients();
            return true;
        }

        if (Array.isArray(latestAllPatients)) {
            const filteredPatients = latestAllPatients.filter(function (patient) {
                return patientMatchesQuery(patient, normalizedQuery);
            });

            if (!filteredPatients.length) {
                return false;
            }

            renderPatients(filteredPatients);
            return true;
        }

        const filteredCards = initialCards.filter(function (card) {
            const haystack = [
                card.dataset.name || '',
                card.dataset.email || '',
                card.dataset.student || '',
                card.dataset.program || '',
            ].join(' ');

            return haystack.includes(normalizedQuery);
        });

        if (!filteredCards.length) {
            return false;
        }

        patientGrid.innerHTML = filteredCards.map(function (card) {
            return card.outerHTML;
        }).join('');

        noResults.classList.add('hidden');
        noResults.setAttribute('hidden', 'hidden');

        return true;
    }

    function renderPatients(patients) {
        if (!patientGrid) return;

        if (!patients.length) {
            renderEmptyState('No matching patients found.');
            return;
        }

        noResults.classList.add('hidden');
        noResults.setAttribute('hidden', 'hidden');

        patientGrid.innerHTML = patients.map(function (patient) {
            const patientName = patient.name || 'Patient';
            const patientEmail = patient.email || '';
            const badge = patient.student_number || patient.type || 'Patient';
            const tags = [];

            if (patient.program) {
                tags.push(`<span class="patient-select-tag"><i class="fa-solid fa-graduation-cap text-[10px] mr-1"></i>${escapeHtml(patient.program)}</span>`);
            }

            if (patient.type) {
                tags.push(`<span class="patient-select-tag"><i class="fa-solid fa-id-badge text-[10px] mr-1"></i>${escapeHtml(patient.type)}</span>`);
            }

            return `
                <div class="patient-select-card" data-name="${escapeHtml(String(patientName).toLowerCase())}" data-email="${escapeHtml(String(patientEmail).toLowerCase())}">
                    <div class="patient-select-card-body">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="patient-select-name">${escapeHtml(patientName)}</p>
                                <p class="patient-select-meta">${escapeHtml(patientEmail)}</p>
                            </div>
                            <span class="patient-select-badge">${escapeHtml(badge)}</span>
                        </div>
                        <div class="patient-select-details">
                            ${tags.join('')}
                        </div>
                    </div>
                    <div class="patient-select-actions">
                        <a href="${escapeHtml(buildRecordUrl(patient))}" class="select-patient-btn">
                            <i class="fa-solid fa-arrow-right"></i>
                            Continue
                        </a>
                    </div>
                </div>
            `;
        }).join('');
    }

    async function loadPatients(query = '', showAll = false, options = {}) {
        if (!patientGrid) return;

        const showLoading = options.showLoading !== false;
        const requestId = ++activeRequestId;
        const params = new URLSearchParams();

        if (query) {
            params.set('q', query);
        }

        if (showAll) {
            params.set('show_all', '1');
        }

        params.set('limit', '80');

        if (showLoading) {
            patientGrid.innerHTML = `
                <div class="col-span-full empty-state py-12">
                    <i class="fa-solid fa-rotate text-3xl text-[#e8e2dd] mb-3"></i>
                    <p class="text-sm text-[#9e9690]">Loading patient records...</p>
                </div>
            `;
            noResults.classList.add('hidden');
            noResults.setAttribute('hidden', 'hidden');
        }

        try {
            const response = await fetch(`${searchEndpoint}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`Search failed with status ${response.status}`);
            }

            const patients = await response.json();

            if (requestId !== activeRequestId) {
                return;
            }

            const normalizedPatients = Array.isArray(patients) ? patients : [];

            if (showAll && query === '') {
                latestAllPatients = normalizedPatients;
            }

            renderPatients(normalizedPatients);
        } catch (error) {
            if (requestId !== activeRequestId) {
                return;
            }

            console.error(error);

            if (showLoading) {
                renderEmptyState('Unable to load patient records right now.');
            }
        }
    }

    input.addEventListener('input', function () {
        const query = input.value.trim();

        clearBtn.classList.toggle('hidden', !query);

        if (searchTimer) {
            clearTimeout(searchTimer);
        }

        searchTimer = setTimeout(function () {
            if (query === '') {
                renderInitialPatients();
                return;
            }

            if (filterInitialPatients(query)) {
                return;
            }

            loadPatients(query, false);
        }, 120);
    });

    clearBtn.addEventListener('click', function () {
        input.value = '';
        clearBtn.classList.add('hidden');
        renderInitialPatients();
        input.focus();
    });

    renderInitialPatients();
    loadPatients('', true, { showLoading: false });
    input.focus();
});
</script>
@endsection
