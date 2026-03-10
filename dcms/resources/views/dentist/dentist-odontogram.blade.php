<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Procedure | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
          body {
          font-family: 'Inter';
        }

        .tooth {
            position: relative;
            width: 70px;
            height: 70px;
            border: 2px solid #111;
            border-radius: 50%;
            background: white;
        }

        .surface {
            position: absolute;
            cursor: pointer;
            transition: background 0.2s;
        }

        .surface:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .top {
            top: 0;
            left: 20%;
            width: 60%;
            height: 25%;
        }

        .bottom {
            bottom: 0;
            left: 20%;
            width: 60%;
            height: 25%;
        }

        .left {
            left: 0;
            top: 20%;
            width: 25%;
            height: 60%;
        }

        .right {
            right: 0;
            top: 20%;
            width: 25%;
            height: 60%;
        }

        .center {
            top: 25%;
            left: 25%;
            width: 50%;
            height: 50%;
            border-radius: 50%;
        }

        .surface.active {
            background: #ef4444;
        }

        .legend-btn.active {
            background-color: #fee2e2;
            border: 1px solid #8B0000;
            color: #8B0000;
            font-weight: 600;
        }

    </style>
</head>
<body class="bg-gray-100 font-inter">

@php
    $patientName = request('patient') ?? 'Capilitan, Beyonce';
@endphp

<div class="p-6">
<div id="odontogram-print">

<!-- ✅ ONE MAIN GRID -->
<div class="grid grid-cols-12 gap-6 items-start">

    <!-- LEFT SIDE -->
    <div class="col-span-8 space-y-6">

        <!-- TOP CARDS -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-6 bg-white p-5 rounded-xl shadow">
                <h2 class="text-2xl font-bold text-[#8B0000]">Tooth Chart</h2>
                <p class="italic text-gray-500">Oral Examination</p>
            </div>

            <div class="col-span-6 bg-white p-5 rounded-xl shadow">
                <h2 class="text-2xl font-bold text-[#8B0000]">{{ $patientName }}</h2>
                <p class="text-sm text-[#8B0000]">Patient</p>
                <div class="flex justify-between text-sm text-gray-500 mt-3">
                    <span>00:00</span>
                    <span>December 25, 2025</span>
                </div>
            </div>
        </div>

        <!-- ODONTOGRAM -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between text-[#8B0000] font-bold mb-4">
                <span>STATUS<br><b>RIGHT</b></span>
                <span><b>LEFT</b></span>
            </div>

            <div class="grid grid-cols-10 gap-6 justify-items-center">
                @php
                    $teeth = [
                        55,54,53,52,51,61,62,63,64,65,
                        18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28,
                        48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38,
                        85,84,83,82,81,71,72,73,74,75
                    ];
                @endphp

                @foreach ($teeth as $tooth)
                    <div class="flex flex-col items-center">
                        <div class="tooth" data-tooth="{{ $tooth }}">
                            <div class="surface top" data-surface="top"></div>
                            <div class="surface left" data-surface="left"></div>
                            <div class="surface center" data-surface="center"></div>
                            <div class="surface right" data-surface="right"></div>
                            <div class="surface bottom" data-surface="bottom"></div>
                        </div>
                        <span class="mt-2 text-xs">{{ $tooth }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL (PANTAY SA TOP CARDS) -->
    <div class="col-span-4 bg-white p-6 rounded-xl shadow space-y-5">

        <div>
            <h3 class="font-bold text-[#8B0000] mb-2">Treatment</h3>
            <div class="grid grid-cols-5 gap-2">
                @for ($i = 0; $i < 15; $i++)
                    <div class="h-6 border border-red-400 rounded"></div>
                @endfor
            </div>
        </div>

        <div>
            <h3 class="font-bold text-[#8B0000] mb-2">Oral Examination</h3>
            <textarea class="w-full h-24 bg-gray-100 text-[#333333] rounded p-3 resize-none"></textarea>
        </div>

        <div>
            <h3 class="font-bold text-[#8B0000] mb-2">Diagnosis</h3>
            <textarea class="w-full h-24 bg-gray-100 text-[#333333] rounded p-3 resize-none"></textarea>
        </div>

        <div>
            <h3 class="font-bold text-[#8B0000] mb-2">
                Prescriptions <span class="font-normal text-[#757575]">(Optional)</span>
            </h3>
            <textarea class="w-full h-20 bg-gray-100 text-[#333333] rounded p-3 resize-none"></textarea>
        </div>

        <!-- <button onclick="exportPDF()"
            class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
            <i class="fa-solid fa-file-pdf"></i>
            Export Odontogram (PDF)
        </button> -->

        <button class="w-full bg-orange-200 text-orange-700 py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
            <i class="fa-solid fa-calendar-plus"></i>
            Follow-Up Appointment
        </button>

        <button class="w-full bg-green-200 text-[#008440] py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            Finish Procedure
        </button>
    </div>

</div>
</div>
</div>

<!-- SIDEBAR -->
<div id="legendSidebar"
     class="fixed top-0 right-0 h-full w-100 bg-white shadow-xl
            transform translate-x-full transition-transform duration-300 z-50">
    <div class="p-5 border-b flex justify-between items-center">
        <h2 class="text-xl font-bold text-[#8B0000]">Legend Condition</h2>
        <button onclick="closeSidebar()"
                class="text-xl text-[#8B0000] hover:text-red-700 transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="legendContainer" class="p-4 grid grid-cols-2 gap-4 overflow-y-auto"></div>
    <div class="p-4 border-t flex gap-3">
        <button onclick="saveLegend()" class="flex-1 bg-green-200 text-[#008440] py-2 rounded">Save</button>
        <button onclick="closeSidebar()" class="flex-1 bg-gray-200 text-[#333333] py-2 rounded">Cancel</button>
    </div>
</div>


<script>
let selectedTooth = null;
let selectedSurface = null;
let selectedLegend = null;
let selectedSurfaceEl = null;

const legends = [
    { code: 'D', label: 'Decayed' },
    { code: 'M', label: 'Missing due to Caries' },
    { code: 'F', label: 'Filled' },
    { code: 'I', label: 'Indicated for Extraction' },
    { code: 'RF', label: 'Root Fragment' },
    { code: 'MO', label: 'Missing due to Other Causes' },
    { code: 'IM', label: 'Impacted Tooth' },
    { code: 'J', label: 'Jacket Crown' },
    { code: 'A', label: 'Amalgam Filling' },
    { code: 'AB', label: 'Abutment' },
    { code: 'P', label: 'Pontic' },
    { code: 'IN', label: 'Inlay' },
    { code: 'LC', label: 'Light Cure Composite' },
    { code: 'RM', label: 'Removable Denture' },
    { code: 'X', label: 'Extraction due to Caries' },
    { code: 'XO', label: 'Extraction due to Other Causes' },
    { code: 'PT', label: 'Present Tooth' },
    { code: 'CM', label: 'Congenitally Missing' },
    { code: 'SP', label: 'Supernumerary' }
];

const legendColors = {
    D:  '#ef4444', // Decayed - Red
    M:  '#9ca3af', // Missing - Gray
    F:  '#22c55e', // Filled - Green
    I:  '#f97316', // Extraction - Orange
    RF: '#7c2d12',
    MO: '#6b7280',
    IM: '#9333ea',

    J:  '#2563eb',
    A:  '#0f766e',
    AB: '#14b8a6',
    P:  '#6366f1',
    IN: '#10b981',
    LC: '#22d3ee',
    RM: '#94a3b8',

    X:  '#b91c1c',
    XO: '#7f1d1d',
    PT: '#000000',
    CM: '#a1a1aa',
    SP: '#c084fc'
};

const legendIcons = {
    D:  'fa-solid fa-bug',
    M:  'fa-solid fa-ban',
    F:  'fa-solid fa-square-check',
    I:  'fa-solid fa-syringe',
    RF: 'fa-solid fa-teeth-open',
    MO: 'fa-solid fa-circle-xmark',
    IM: 'fa-solid fa-triangle-exclamation',
    J:  'fa-solid fa-crown',
    A:  'fa-solid fa-fill-drip',
    AB: 'fa-solid fa-anchor',
    P:  'fa-solid fa-link',
    IN: 'fa-solid fa-puzzle-piece',
    LC: 'fa-solid fa-wand-magic-sparkles',
    RM: 'fa-solid fa-teeth',
    X:  'fa-solid fa-xmark',
    XO: 'fa-solid fa-skull-crossbones',
    PT: 'fa-solid fa-check',
    CM: 'fa-solid fa-question',
    SP: 'fa-solid fa-plus'
};

// CLICK TOOTH SURFACE
document.querySelectorAll('.surface').forEach(surface => {
    surface.addEventListener('click', () => {

        document.querySelectorAll('.surface.selected')
            .forEach(s => s.classList.remove('selected'));

        selectedSurface = surface.dataset.surface;
        selectedTooth = surface.closest('.tooth').dataset.tooth;
        selectedSurfaceEl = surface;

        surface.classList.add('selected');
        openSidebar();
    });
});

function openSidebar() {
    const sidebar = document.getElementById('legendSidebar');
    const container = document.getElementById('legendContainer');

    sidebar.classList.remove('translate-x-full');
    container.innerHTML = '';

    const prevLegend = selectedSurfaceEl?.dataset?.legend || null;
    selectedLegend = prevLegend; // keep it selected (so Save can re-save)

    legends.forEach(legend => {
        const btn = document.createElement('button');

        btn.className =
            'legend-btn border rounded p-2 text-sm text-[#333333] hover:bg-red-100 flex items-center gap-2';

        btn.innerHTML = `
            <i class="${legends[legend.code]} text-[#8B0000]"></i>
            <span>${legend.code} – ${legend.label}</span>
        `;

        if (prevLegend && prevLegend === legend.code) {
            btn.classList.add('active');
        }

        btn.onclick = () => selectLegend(btn, legend.code);
        container.appendChild(btn);
    });
}

function closeSidebar() {
    document.getElementById('legendSidebar')
        .classList.add('translate-x-full');

    if (selectedSurfaceEl) {
        selectedSurfaceEl.classList.remove('selected');
    }

    selectedLegend = null;
}

function selectLegend(button, code) {
    selectedLegend = code;

    document.querySelectorAll('.legend-btn')
        .forEach(btn => btn.classList.remove('active'));

    button.classList.add('active');
}

function saveLegend() {
    if (!selectedLegend) {
        alert('Please select a legend condition.');
        return;
    }

    const color = legendColors[selectedLegend] || '#ef4444';
    const legendObj = legends.find(l => l.code === selectedLegend);

    selectedSurfaceEl.classList.remove('selected');
    selectedSurfaceEl.classList.add('active');

    selectedSurfaceEl.style.backgroundColor = color;

    selectedSurfaceEl.dataset.legend = selectedLegend;

    selectedSurfaceEl.title = legendObj
        ? `${legendObj.code} – ${legendObj.label}`
        : selectedLegend;

    closeSidebar();
}

// function exportPDF() {
//     const element = document.getElementById('odontogram-print');

//     const opt = {
//         margin:       0.3,
//         filename:     'Dental_Odontogram.pdf',
//         image:        { type: 'jpeg', quality: 0.98 },
//         html2canvas:  { scale: 2 },
//         jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
//     };

//     html2pdf().set(opt).from(element).save();
// }
</script>


</body>
</html>