@extends('layouts.app')

@section('content')

<div class="bg-[#f1f5f9] min-h-screen p-8 pb-24">

    <!-- Header -->
    <div class="mb-5">
        <h2 class="text-2xl font-black text-[#1E3A8A]">
            Goods Receipt & Matching
        </h2>
        <p class="text-xs font-medium text-slate-400 mt-1">
            Inventory /
            <span class="text-slate-500">
                Goods Receipt & Matching
            </span>
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Pending Shipments</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $shipmentsPending ?? 0 }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">📦</div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Discrepancies</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $discrepanciesCount ?? 0 }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-100">⚠️</div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Approved</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $approvedCount ?? 0 }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100">✅</div>
        </div>
      </div>
    </div>

    <!-- Shipment Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-300 shadow overflow-hidden mt-6">
      <div class="p-5 border-b border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3">
          <h3 class="text-lg font-semibold text-slate-800">Shipment Logs</h3>
          <div class="flex flex-wrap items-center gap-2">
            <input type="text" id="searchReceipt" placeholder="Search receipt..." class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"/>
            <select id="matchFilter" class="px-3 py-2 text-sm border border-slate-300 rounded-lg">
              <option value="">All Match Status</option>
              <option value="MATCHED">MATCHED</option>
              <option value="QTY MISMATCH">QTY MISMATCH</option>
              <option value="PRICE MISMATCH">PRICE MISMATCH</option>
            </select>
            <select id="inspectionFilter" class="px-3 py-2 text-sm border border-slate-300 rounded-lg">
              <option value="">All Inspection</option>
              <option value="Passed">Passed</option>
              <option value="Partial">Partial</option>
              <option value="Failed">Failed</option>
              <option value="Pending">Pending</option>
            </select>
            <a href="{{ route('export.excel') }}" class="px-3 py-2 text-sm rounded-lg border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition">Excel</a>
            
            <!-- PDF Sign & Download Trigger Button -->
            <button type="button" onclick="openSignModal('ALL-RECEIPTS')" class="px-3 py-2 text-sm rounded-lg border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer">
                Sign & PDF
            </button>
          </div>
        </div>
      </div>

      <div class="table-container overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-slate-700">
          <thead>
            <tr class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">
              <th class="px-5 py-3 font-semibold text-left">Receipt #</th>
              <th class="py-4 px-5 text-left">PO Number</th>
              <th class="py-4 px-5 text-left">Supplier</th>
              <th class="py-4 px-5 text-left">Computer Part</th>
              <th class="py-4 px-5 text-center">Ordered</th>
              <th class="py-4 px-5 text-center">Received</th>
              <th class="py-4 px-5 text-left">Warehouse</th>
              <th class="py-4 px-5 text-left">Inspection</th>
              <th class="py-4 px-5 text-left">3-Way Match</th>
              <th class="py-4 px-5 text-center">Action</th>
            </tr>
          </thead>
          <tbody id="receiptTable">
            @forelse($receipts ?? [] as $receipt)
            <tr class="hover:bg-slate-50 border-b">
                <td class="px-5 py-4 font-semibold text-slate-500">{{ $receipt->gr_number }}</td>
                <td class="px-5 py-4 font-bold text-blue-900">{{ $receipt->po_number }}</td>
                <td class="px-5 py-4">{{ $receipt->supplier }}</td>
                <td class="px-5 py-4">{{ $receipt->item_name }}</td>
                <td class="px-5 py-4 text-center">{{ $receipt->po_quantity }}</td>
                <td class="px-5 py-4 text-center">{{ $receipt->gr_quantity }}</td>
                <td class="px-5 py-4">{{ $receipt->warehouse }}</td>
                <td class="px-5 py-4">
                    <span class="px-2 py-1 text-xs font-bold rounded
                    @if($receipt->inspection_status=='Passed') bg-green-100 text-green-700
                    @elseif($receipt->inspection_status=='Pending') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ $receipt->inspection_status }}
                    </span>
                </td>
                <td class="px-5 py-4">
                    @php $status = $receipt->effective_match_status; @endphp
                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                    @if($status=='MATCHED') bg-green-100 text-green-700
                    @elseif($status=='PRICE MISMATCH') bg-yellow-100 text-yellow-700
                    @elseif($status=='QTY MISMATCH') bg-red-100 text-red-700
                    @else bg-slate-100 text-slate-700 @endif">
                    {{ $status }}
                    </span>
                </td>
                <td class="px-5 py-4">
                    <div class="flex justify-center gap-2">
                        <button type="button" onclick="openReceiptModal({{ $receipt->id }})" class="px-3 py-2 bg-blue-600 text-white rounded text-xs cursor-pointer">View</button>
                        <button type="button" onclick="openEditModal({{ $receipt->id }})" class="px-3 py-2 bg-yellow-500 text-white rounded text-xs cursor-pointer">Edit</button>
                        <form action="{{ route('receipts.approve', $receipt->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded text-xs cursor-pointer">Approve</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center py-6 text-slate-400">No goods receipts found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
</div>

<!-- Edit Receipt Modal (Naayos ang flex class) -->
<div id="editReceiptModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-[600px] max-h-[90vh] overflow-y-auto shadow-xl">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h2 class="text-lg font-semibold">Edit Receipt</h2>
        <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-xl font-bold">✕</button>
    </div>
    <form id="editReceiptForm" method="POST">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">Supplier</label>
          <input type="text" id="edit_supplier" name="supplier" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">Item</label>
          <input type="text" id="edit_item_name" name="item_name" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">PO Quantity</label>
          <input type="number" id="edit_po_quantity" name="po_quantity" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">Received Quantity</label>
          <input type="number" id="edit_gr_quantity" name="gr_quantity" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">Warehouse</label>
          <input type="text" id="edit_warehouse" name="warehouse" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">PO Unit Price</label>
          <input type="number" step="0.01" id="edit_po_price" name="po_price" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">Invoice Price</label>
          <input type="number" step="0.01" id="edit_invoice_price" name="invoice_price" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-500 mb-1">Inspection</label>
          <select id="edit_inspection_status" name="inspection_status" class="w-full border rounded p-2">
            <option value="Passed">Passed</option>
            <option value="Failed">Failed</option>
            <option value="Pending">Pending</option>
          </select>
        </div>
        <div class="col-span-2">
          <label class="block text-xs font-medium text-slate-500 mb-1">Computed Match Status</label>
          <input type="text" id="edit_computed_match_status" class="w-full border rounded p-2 bg-slate-100" readonly />
        </div>
      </div>
      <div class="mt-6 flex justify-end gap-2">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-slate-700 rounded text-sm">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded text-sm font-semibold">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- Receipt Details Modal (Naayos ang flex class) -->
<div id="receiptDetailsModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-[500px] max-h-[80vh] overflow-y-auto shadow-xl">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
      <h2 class="text-lg font-semibold">Receipt Details</h2>
      <button type="button" onclick="closeReceiptDetails()" class="text-gray-500 hover:text-gray-700 text-xl font-bold">✕</button>
    </div>
    <div id="receiptDetailsContent" class="bg-slate-50 p-4 rounded text-sm">Loading...</div>
    <div class="mt-6 text-right">
        <button type="button" onclick="closeReceiptDetails()" class="px-4 py-2 bg-gray-200 rounded text-sm">Close</button>
    </div>
  </div>
</div>

<!-- ================= DIGITAL SIGNATURE & PDF MODAL ================= -->
<div id="signModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
    <div class="bg-white rounded-xl w-[600px] p-6 shadow-xl">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="font-bold text-lg">E-Sign Goods Receipt Document</h3>
            <button type="button" onclick="closeSignModal()" class="text-slate-400 hover:text-red-500 font-bold text-xl">✕</button>
        </div>
        <p class="text-xs text-slate-500 mb-2">Lumagda sa kahon sa ibaba gamit ang iyong mouse bago i-download ang signed PDF.</p>
        
        <div class="border-2 border-dashed border-slate-300 rounded-lg bg-slate-50 flex justify-center items-center">
            <canvas id="signatureCanvas" width="540" height="180" class="cursor-crosshair bg-white rounded"></canvas>
        </div>
        <div class="mt-2">
            <button type="button" onclick="clearSignature()" class="px-3 py-1 bg-gray-200 text-xs rounded text-slate-700">Clear Signature</button>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <button type="button" onclick="closeSignModal()" class="px-4 py-2 bg-gray-200 rounded text-sm">Cancel</button>
            <button type="button" onclick="downloadSignedPDF()" class="px-4 py-2 bg-red-600 text-white rounded text-sm font-semibold">Download Signed PDF</button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// View Modal
function openReceiptModal(id) {
    const modal = document.getElementById('receiptDetailsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    fetch('/receipts/' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('receiptDetailsContent').innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-xs text-slate-400">Receipt #</p><b>${data.gr_number ?? '-'}</b></div>
                <div><p class="text-xs text-slate-400">PO Number</p><b>${data.po_number ?? '-'}</b></div>
                <div><p class="text-xs text-slate-400">Supplier</p>${data.supplier ?? '-'}</div>
                <div><p class="text-xs text-slate-400">Item</p>${data.item_name ?? '-'}</div>
                <div><p class="text-xs text-slate-400">Ordered</p>${data.po_quantity ?? '-'}</div>
                <div><p class="text-xs text-slate-400">Received</p>${data.gr_quantity ?? '-'}</div>
                <div><p class="text-xs text-slate-400">Warehouse</p>${data.warehouse ?? '-'}</div>
                <div><p class="text-xs text-slate-400">Match</p>${data.effective_match_status ?? data.match_status ?? '-'}</div>
            </div>`;
        })
        .catch(error => console.log(error));
}

function closeReceiptDetails() {
    const modal = document.getElementById('receiptDetailsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Edit Modal
function openEditModal(id) {
    const modal = document.getElementById('editReceiptModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // Siguraduhing kasama ang ID sa URL patungong update route
    fetch('/receipts/' + id + '/edit')
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_supplier').value = data.supplier ?? '';
            document.getElementById('edit_item_name').value = data.item_name ?? '';
            document.getElementById('edit_po_quantity').value = data.po_quantity ?? '';
            document.getElementById('edit_gr_quantity').value = data.gr_quantity ?? '';
            document.getElementById('edit_warehouse').value = data.warehouse ?? '';
            document.getElementById('edit_po_price').value = data.po_price ?? '';
            document.getElementById('edit_invoice_price').value = data.invoice_price ?? '';
            document.getElementById('edit_inspection_status').value = data.inspection_status ?? 'Passed';
            document.getElementById('edit_computed_match_status').value = data.effective_match_status ?? data.match_status ?? 'PENDING';
            
            // Dito naise-set ang tamang action URL na may ID
            document.getElementById('editReceiptForm').action = '/receipts/' + id;
            updateComputedMatchStatus();
        })
        .catch(error => console.error(error));
}
function closeEditModal() {
    const modal = document.getElementById('editReceiptModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function updateComputedMatchStatus() {
    const inspection = document.getElementById('edit_inspection_status').value;
    const poQty = Number(document.getElementById('edit_po_quantity').value);
    const grQty = Number(document.getElementById('edit_gr_quantity').value);
    const poPrice = document.getElementById('edit_po_price').value;
    const invoicePrice = document.getElementById('edit_invoice_price').value;

    let status = 'MATCHED';
    if (inspection !== 'Passed') {
        status = 'PENDING';
    } else if (!Number.isNaN(poQty) && !Number.isNaN(grQty) && poQty !== grQty) {
        status = 'QTY MISMATCH';
    } else if (poPrice !== '' && invoicePrice !== '' && Number(poPrice).toFixed(2) !== Number(invoicePrice).toFixed(2)) {
        status = 'PRICE MISMATCH';
    }

    document.getElementById('edit_computed_match_status').value = status;
}

['edit_po_quantity','edit_gr_quantity','edit_po_price','edit_invoice_price','edit_inspection_status'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('change', updateComputedMatchStatus);
    }
});

// Signature Canvas Logic
let canvas = document.getElementById("signatureCanvas");
let ctx = canvas.getContext("2d");
let painting = false;

canvas.addEventListener("mousedown", startPosition);
canvas.addEventListener("mouseup", finishedPosition);
canvas.addEventListener("mousemove", draw);

function startPosition(e) {
    painting = true;
    draw(e);
}
function finishedPosition() {
    painting = false;
    ctx.beginPath();
}
function draw(e) {
    if (!painting) return;
    ctx.lineWidth = 2;
    ctx.lineCap = "round";
    ctx.strokeStyle = "#000";

    let rect = canvas.getBoundingClientRect();
    ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
}
function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function openSignModal(receiptNo) {
    const modal = document.getElementById('signModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    clearSignature();
}
function closeSignModal() {
    const modal = document.getElementById('signModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function downloadSignedPDF() {
    alert("Lagda matagumpay na nailapat! Nag-download na ang PDF.");
    closeSignModal();
    // Pwedeng i-redirect patungo sa export route kung kinakailangan:
    window.location.href = "{{ route('export.pdf') }}";
}

// Filter Table Script
const searchInput = document.getElementById('searchReceipt');
const matchFilter = document.getElementById('matchFilter');
const inspectionFilter = document.getElementById('inspectionFilter');

function filterTable() {
  const search = searchInput.value.toLowerCase();
  const matchVal = matchFilter.value.toLowerCase();
  const inspectionVal = inspectionFilter.value.toLowerCase();

  document.querySelectorAll('#receiptTable tr').forEach(row => {
    const text = row.textContent.toLowerCase();
    const searchMatch = search === '' || text.includes(search);
    const filterMatch = (matchVal === '' || text.includes(matchVal)) &&
                        (inspectionVal === '' || text.includes(inspectionVal));
    row.style.display = (searchMatch && filterMatch) ? '' : 'none';
  });
}

searchInput.addEventListener('keyup', filterTable);
matchFilter.addEventListener('change', filterTable);
inspectionFilter.addEventListener('change', filterTable);
</script>

@endsection