<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Inventory</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter';
    }
  </style>
</head>

<body class="bg-gray-200">

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
      <span>Patients</span>
    </a>

    <a href="{{ route('dentist.appointments') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span>Appointments</span>
    </a>
    
    <a href="{{ route('dentist.inventory') }}" class="flex flex-col items-center ">
      <i class="fa-solid fa-box text-lg"></i>
      <span class="font-bold">Inventory</span>
    </a>

    <a href="{{ route('dentist.report') }}" class="flex flex-col items-center">
      <i class="fa-solid fa-file text-lg"></i>
      <span>Reports</span>
    </a>
  </nav>
</header>

<main class="p-6">
<div class="bg-white rounded-xl shadow p-6">

<!-- TOOLBAR -->
<div class="flex justify-between items-center mb-4 flex-wrap gap-3">

    <!-- Gradient Border Wrapper -->
    <div class="p-[2px] rounded-full bg-gradient-to-r from-[#660000] to-[#FFD700] w-72">
    
    <!-- Inner Container -->
    <div class="flex items-center bg-white rounded-full px-4 py-2">
        <i class="fa fa-search text-[#660000]"></i>
        
        <input
        id="searchInput"
        class="ml-3 outline-none w-full text-sm bg-white text-gray-800 placeholder-gray-400"
        placeholder="Search Stock No., Name"
        oninput="renderTable()"
        />
    </div>

    </div>

  <div class="flex gap-2">

    <!-- SHOW SELECT -->
    <div class="rounded-full p-[2px] bg-gradient-to-r from-[#660000] to-[#FFD700]">
    <select
        id="showSelect"
        class="select select-sm rounded-full bg-white text-[#660000] w-full focus:outline-none"
        onchange="renderTable()"
    >
        <option value="all">Show: All Products</option>
        <option value="medicine">Medicine</option>
        <option value="supplies">Supplies</option>
    </select>
    </div>

    <!-- SORT SELECT -->
    <div class="rounded-full p-[2px] bg-gradient-to-r from-[#660000] to-[#FFD700]">
    <select
        id="sortSelect"
        class="select select-sm rounded-full bg-white text-[#660000] w-full focus:outline-none"
        onchange="renderTable()"
    >
        <option value="">Sort: Default</option>
        <option value="qty_asc">Quantity (Lowest to Highest)</option>
        <option value="alphabetical">Alphabetical (A–Z)</option>
        <option value="date_received">Date Received</option>
    </select>
    </div>


    <button onclick="resetAddForm(); addModal.showModal()"
      class="btn btn-sm hover:bg-[#660000] rounded-full border-none bg-[#8B0000] text-white">
      <i class="fa fa-plus mr-1"></i> Add Item
    </button>

  </div>
</div>

<!-- TABLE -->
<div class="overflow-x-auto">
<table class="table table-sm w-full">
<thead>
<tr class="text-[#8B0000] text-xs uppercase">
  <th>Date</th>
  <th>Stock No.</th>
  <th>Supplies</th>
  <th>Unit</th>
  <th>Qty</th>
  <th>Used</th>
  <th>Balance</th>
  <th class="text-center">Action</th>
</tr>
</thead>
<tbody id="tableBody"></tbody>
</table>
</div>

</div>
</main>

<!-- ADD MODAL -->
<dialog id="addModal" class="modal">
  <div class="modal-box max-w-xl bg-white rounded-lg">

    <h3 class="font-bold text-lg text-[#8B0000] mb-6">
      Add Inventory Item
    </h3>

    <div class="grid grid-cols-[150px_1fr] gap-y-4 items-center">
    
      <!-- CATEGORY -->
      <label class="text-sm text-[#8B0000]">Category</label>
      <select id="addCategory" class="select select-bordered w-48 bg-white border-[#D9D9D9] text-[#333333]">
        <option disabled selected>Select Category</option>
        <option value="Medicine">Medicine</option>
        <option value="Supplies">Supplies</option>
      </select>

      <!-- DATE (AUTO / DROPDOWN) -->
      <label class="text-sm text-[#8B0000]">Date Received</label>
      <input
        id="addDate"
        type="date"
        class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]"
      />

      <!-- STOCK -->
      <label class="text-sm text-[#8B0000]">Stock Number</label>
      <input id="addStock" class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]" placeholder="00 - 000">

      <!-- NAME -->
      <label class="text-sm text-[#8B0000]">Supply Name</label>
      <input id="addName" class="input input-bordered w-100 bg-white border-[#D9D9D9] text-[#333333]"
        placeholder="ex. Nitrile Gloves Large">

      <!-- UNIT -->
      <label class="text-sm text-[#8B0000]">Units</label>
      <select id="addUnit"
        class="select select-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]">
        <option disabled selected>Select unit</option>
        <option value="Box">Box</option>
        <option value="Pack">Pack</option>
        <option value="Bottle">Bottle</option>
        <option value="Piece">Piece</option>
      </select>

      <!-- QTY -->
      <label class="text-sm text-[#8B0000]">Quantity</label>
      <input id="addQty" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeAddBalance()">

      <!-- USED -->
      <label class="text-sm text-[#8B0000]">Consumed</label>
      <input id="addUsed" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeAddBalance()">

      <!-- BALANCE -->
      <label class="text-sm text-[#8B0000]">Balance</label>
      <input id="addBalance"
        class="input input-bordered w-28 bg-[#F4F4F4] text-[#333333]"
        readonly>

    </div>

    <div class="modal-action mt-6">
      <button class="btn bg-[#F4F4F4] hover:bg-[#333333] hover:text-[#F4F4F4] text-[#333333] border-[#333333]" onclick="addModal.close()">Back</button>
      <button class="btn bg-[#8B0000] hover:bg-[#F55E5E] hover:text-[#8B0000] text-[#F4F4F4] border-none" onclick="addItem()">Save</button>
    </div>

  </div>
</dialog>

<!-- EDIT MODAL -->
<dialog id="editModal" class="modal">
  <div class="modal-box max-w-xl bg-white rounded-lg">

    <h3 class="font-bold text-lg text-[#8B0000] mb-6">
      Edit Inventory Item
    </h3>

    <div class="grid grid-cols-[150px_1fr] gap-y-4 items-center text-[#8B0000]">
      <label>Category</label>
      <select id="editCategory" class="select select-bordered w-48 bg-white text-[#333333]">
        <option value="Medicine">Medicine</option>
        <option value="Supplies">Supplies</option>
      </select>

      <label>Date Received</label>
      <input id="editDate" type="date"
        class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]">

      <label>Stock Number</label>
      <input id="editStock" class="input input-bordered bg-white border-[#D9D9D9] text-[#333333]">

      <label>Supply Name</label>
      <input id="editName" class="input input-bordered bg-white border-[#D9D9D9] text-[#333333]">

      <label>Units</label>
      <select id="editUnit"
        class="select select-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]">
        <option value="Box">Box</option>
        <option value="Pack">Pack</option>
        <option value="Bottle">Bottle</option>
        <option value="Piece">Piece</option>
      </select>


      <label>Quantity</label>
      <input id="editQty" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeEditBalance()">

      <label>Consumed</label>
      <input id="editUsed" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeEditBalance()">

      <label>Balance</label>
      <input id="editBalance"
        class="input input-bordered w-28 bg-[#F4F4F4] border-[#D9D9D9] text-[#333333]"
        readonly>

    </div>

    <div class="modal-action mt-6">
      <button class="btn bg-[#F4F4F4] hover:bg-[#333333] hover:text-[#F4F4F4] text-[#333333] border-[#333333]" onclick="editModal.close()">Back</button>
      <button class="btn bg-[#8B0000] hover:bg-[#F55E5E] hover:text-[#8B0000] text-[#F4F4F4] border-none" onclick="saveEdit()">Save</button>
    </div>

  </div>
</dialog>

<!-- DELETE CONFIRMATION MODAL -->
<dialog id="deleteModal" class="modal">
    <div class="modal-box max-w-md bg-white rounded-lg text-center">

      <h3 class="font-bold text-lg text-[#8B0000] mb-4">Confirm Deletion</h3>
      <p class="mb-6">Are you sure you want to delete this item? This action cannot be undone.</p>

      <div class="modal-action justify-center gap-4">
        <button class="btn bg-gray-200 text-gray-700 hover:bg-gray-300" onclick="deleteModal.close()">Cancel</button>
        <button id="confirmDeleteBtn" class="btn bg-[#8B0000] text-white">Delete</button>
      </div>

    </div>
</dialog>

<!-- Footer -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">
  <!-- Footer content here (unchanged) -->
</footer>

<script>
/*let inventory = [
  {
    category: "Supplies",
    date: "01/20/25",
    stock: "18-001",
    name: "Disposable Dental Needles",
    unit: "Piece",
    qty: 42,
    used: 8
  },
  {
    category: "Medicine",
    date: "01/21/25",
    stock: "18-002",
    name: "Amoxicillin 500mg",
    unit: "Box",
    qty: 30,
    used: 5
  },
  {
    category: "Supplies",
    date: "01/22/25",
    stock: "18-003",
    name: "Latex Examination Gloves",
    unit: "Box",
    qty: 50,
    used: 12
  },
  {
    category: "Medicine",
    date: "01/23/25",
    stock: "18-004",
    name: "Paracetamol 500mg",
    unit: "Box",
    qty: 40,
    used: 10
  },
  {
    category: "Supplies",
    date: "01/24/25",
    stock: "18-005",
    name: "Dental Cotton Rolls",
    unit: "Pack",
    qty: 60,
    used: 15
  },
  {
    category: "Supplies",
    date: "01/25/25",
    stock: "18-006",
    name: "Disposable Mouth Mirrors",
    unit: "Piece",
    qty: 25,
    used: 5
  },
  {
    category: "Medicine",
    date: "01/26/25",
    stock: "18-007",
    name: "Ibuprofen 400mg",
    unit: "Box",
    qty: 35,
    used: 7
  },
  {
    category: "Supplies",
    date: "01/27/25",
    stock: "18-008",
    name: "Cotton Swabs",
    unit: "Pack",
    qty: 80,
    used: 20
  },
  {
    category: "Medicine",
    date: "01/28/25",
    stock: "18-009",
    name: "Chlorhexidine Mouthwash 0.12%",
    unit: "Bottle",
    qty: 20,
    used: 4
  },
  {
    category: "Supplies",
    date: "01/29/25",
    stock: "18-010",
    name: "Dental Floss Packs",
    unit: "Pack",
    qty: 50,
    used: 10
  }
];*/

let inventory = [];

async function loadInventory() {
  const res = await fetch('/dentist/inventory/data');
  inventory = await res.json();
  renderTable();
}
loadInventory();

let deleteId = null;

function deleteItem(id) {
  deleteId = id;
  deleteModal.showModal();
}

document.getElementById("confirmDeleteBtn").onclick = async () => {
  if (!deleteId) return;

  await fetch(`/dentist/inventory/${deleteId}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')
    }
  });

  deleteModal.close();
  deleteId = null;
  loadInventory();
};

let editIndex = null;

function renderTable() {
  const tbody = document.getElementById("tableBody");
  tbody.innerHTML = "";

  let data = [...inventory];
  
  const show = showSelect.value;

  if (show === "medicine") {
    data = data.filter(item => item.category === "Medicine");
  }

  if (show === "supplies") {
    data = data.filter(item => item.category === "Supplies");
  }

  const search = searchInput.value.toLowerCase();
  if (search) {
    data = data.filter(i =>
      i.stock_no.toLowerCase().includes(search) ||
      i.name.toLowerCase().includes(search)
    );
  }

  const sort = sortSelect.value;
    switch (sort) {
    case "qty_asc":
        // Quantity (lowest → highest)
        data.sort((a, b) => Number(a.qty) - Number(b.qty));
        break;

    case "alphabetical":
        // Alphabetical by supply / medicine name
        data.sort((a, b) => a.name.localeCompare(b.name));
        break;

    case "date_received":
        // Date received (oldest → newest)
        data.sort((a, b) => new Date(a.date_received) - new Date(b.date_received));
        break;

    default:
        // Default order (do nothing)
        break;
    }   

  data.forEach((item, index) => {
    const balance = item.qty - item.used;
    tbody.innerHTML += `
    <tr class="text-gray-800"> <!-- sets the font color -->
        <td class="text-[#333333]">${item.formatted_date}</td>
        <td class="text-[#333333]">${item.stock_no}</td>
        <td class="text-[#333333]">${item.name}</td>
        <td class="text-[#333333]">${item.unit}</td>
        <td class="text-[#333333]">${item.qty}</td>
        <td class="text-[#333333]">${item.used}</td>
        <td class="text-[#333333]">${balance}</td>
        <td class="flex justify-center gap-2">
          <button class="btn btn-xs bg-[#8B0000] text-white hover:bg-[#660000] border-none"
            onclick="openEdit(${item.id})">
            <i class="fa fa-pen"></i>
          </button>
          <button class="btn btn-xs bg-[#8B0000] text-white hover:bg-[#660000] border-none"
            onclick="deleteItem(${item.id})">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>`;
  });
}

function resetAddForm() {
  addCategory.selectedIndex = 0;
  addDate.value = '';
  addStock.value = '';
  addName.value = '';
  addUnit.selectedIndex = 0;
  addQty.value = '';
  addUsed.value = '';
  addBalance.value = '';
}

async function addItem() {
  if (
    addCategory.selectedIndex === 0 ||
    addUnit.selectedIndex === 0 ||
    !addDate.value ||
    !addStock.value ||
    !addName.value ||
    addQty.value === ''
  ) {
    alert('Please complete all required fields.');
    return;
  }

  const res = await fetch('/dentist/inventory', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')
    },
    body: JSON.stringify({
      category: addCategory.value,
      date_received: addDate.value,
      stock_no: addStock.value.trim(),
      name: addName.value.trim(),
      unit: addUnit.value,
      qty: Number(addQty.value),
      used: Number(addUsed.value || 0)
    })
  });

  if (!res.ok) {
    const err = await res.json();
    console.error(err);
    alert(Object.values(err.errors).join('\n'));
    return;
  }

  addModal.close();
  resetAddForm();
  loadInventory();
}


let editId = null;

function openEdit(id) {
  editId = id;
  const i = inventory.find(item => item.id === id);
  if (!i) return;

  editCategory.value = i.category;
  editStock.value = i.stock_no;
  editName.value = i.name;
  editUnit.value = i.unit;
  editQty.value = i.qty;
  editUsed.value = i.used;
  editDate.value = i.date_received?.slice(0, 10);

  computeEditBalance();
  editModal.showModal();
}

async function saveEdit() {
  if (!editId) return;

  const res = await fetch(`/dentist/inventory/${editId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')
    },
    body: JSON.stringify({
      category: editCategory.value,
      date_received: editDate.value,
      stock_no: editStock.value,
      name: editName.value,
      unit: editUnit.value,
      qty: Number(editQty.value),
      used: Number(editUsed.value)
    })
  });

  if (!res.ok) {
    const err = await res.text();
    console.error(err);
    alert('EDIT FAILED — check console');
    return;
  }

  editModal.close();
  editId = null;
  loadInventory();
}

function computeAddBalance() {
  const qty = Number(addQty.value || 0);
  const used = Number(addUsed.value || 0);
  addBalance.value = qty - used;
}

function computeEditBalance() {
  editBalance.value =
    Number(editQty.value || 0) - Number(editUsed.value || 0);
}

function formatDateMMDDYY(dateStr) {
  const d = new Date(dateStr);
  const mm = String(d.getMonth() + 1).padStart(2, "0");
  const dd = String(d.getDate()).padStart(2, "0");
  const yy = String(d.getFullYear()).slice(-2);
  return `${mm}/${dd}/${yy}`;
}

</script>

</body>
</html>
