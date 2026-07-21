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
      <!-- Pending Shipments -->
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Pending Shipments</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $shipmentsPending }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">📦</div>
        </div>
      </div>
      <!-- Discrepancies -->
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Discrepancies</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $discrepanciesCount }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-100">⚠️</div>
        </div>
      </div>
      <!-- Approved -->
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Approved</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $approvedCount }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100">✅</div>
        </div>
      </div>
    </div>

    <!-- Workflow & Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
      <!-- Receiving Workflow -->
      <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">
        <h2 class="text-lg font-bold text-slate-800 mb-5">Receiving Workflow</h2>
        <div class="space-y-4">
          <div class="flex justify-between  items-center"><span>Delivery Received</span><span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">DONE</span></div>
          <div class="flex justify-between items-center"><span>Inspection</span><span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">PASSED</span></div>
          <div class="flex justify-between items-center"><span>3-Way Matching</span><span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">IN PROGRESS</span></div>
          <div class="flex justify-between items-center"><span>Finance Queue</span><span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">WAITING</span></div>
        </div>
      </div>
      <!-- Receiving Summary -->
      <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">
        <h2 class="text-lg font-bold text-slate-800 mb-5">Receiving Summary</h2>
        <div class="space-y-3 text-sm">
          <div class="flex justify-between"><span>Total Deliveries Today</span><strong>28</strong></div>
          <div class="flex justify-between"><span>Items Received</span><strong>214</strong></div>
          <div class="flex justify-between"><span>Pending Inspection</span><strong class="text-orange-500">5</strong></div>
          <div class="flex justify-between"><span>Approved</span><strong class="text-emerald-600">19</strong></div>
          <div class="flex justify-between"><span>Disputed</span><strong class="text-red-500">2</strong></div>
        </div>
      </div>
      <!-- Procurement Alerts -->
      <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">
        <h2 class="text-lg font-bold text-slate-800 mb-5">Procurement Alerts</h2>
        <div class="space-y-3">
          <div class="bg-[#FFD3A7] rounded-xl p-3">🚚 3 Deliveries waiting to receive</div>
          <div class="bg-[#A4CFFF] rounded-xl p-3">📦 5 Receipts pending inspection</div>
          <div class="bg-[#FFCACA] rounded-xl p-3">⚠ 2 Quantity mismatches detected</div>
          <div class="bg-[#BFF5FF] rounded-xl p-3">✔ Ready for Finance</div>
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
            <a href="{{ route('export.pdf') }}" class="px-3 py-2 text-sm rounded-lg border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition">PDF</a>
          </div>
        </div>
      </div>
      <div class="table-container">
        <table class="min-w-full table-auto text-sm text-slate-700 fixed-table">
          <thead>
            <tr class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">
              <th class="px-5 py-3 font-semibold">Receipt #</th>
              <th class="py-4 px-5">PO Number</th>
              <th class="py-4 px-5">Supplier</th>
              <th class="py-4 px-5">Computer Part</th>
              <th class="py-4 px-5 text-center">Ordered</th>
              <th class="py-4 px-5 text-center">Received</th>
              <th class="py-4 px-5">Warehouse</th>
              <th class="py-4 px-5">Inspection</th>
              <th class="py-4 px-5">3-Way Match</th>
              <th class="py-4 px-5">Action</th>
            </tr>
          </thead>



   
        <tbody id="receiptTable">

@foreach($receipts as $receipt)

<tr class="hover:bg-slate-50">
    <td class="px-5 py-4 font-semibold text-slate-500">
        {{ $receipt->gr_number }}
    </td>

    <td class="px-5 py-4 font-bold text-blue-900">
        {{ $receipt->po_number }}
    </td>

    <td class="px-5 py-4">
        {{ $receipt->supplier }}
    </td>

    <td class="px-5 py-4">
        {{ $receipt->item_name }}
    </td>

    <td class="px-5 py-4 text-center">
        {{ $receipt->po_quantity }}
    </td>

    <td class="px-5 py-4 text-center">
        {{ $receipt->gr_quantity }}
    </td>

    <td class="px-5 py-4">
        {{ $receipt->warehouse }}
    </td>

    <td class="px-5 py-4">
        <span class="px-2 py-1 text-xs font-bold rounded
        @if($receipt->inspection_status=='Passed')
            bg-green-100 text-green-700
        @elseif($receipt->inspection_status=='Pending')
            bg-yellow-100 text-yellow-700
        @else
            bg-red-100 text-red-700
        @endif">

        {{ $receipt->inspection_status }}

        </span>
    </td>

    <td class="px-5 py-4">
        <span class="px-3 py-1 text-xs font-semibold rounded-full

        @if($receipt->match_status=='MATCHED')
            bg-green-100 text-green-700
        @elseif($receipt->match_status=='PRICE MISMATCH')
            bg-yellow-100 text-yellow-700
        @else
            bg-red-100 text-red-700
        @endif">

        {{ $receipt->match_status }}

        </span>
    </td>

    <td class="px-5 py-4">
        <div class="flex gap-2">

            <button
                onclick="openReceiptModal({{ $receipt->id }})"
                class="px-3 py-2 bg-blue-600 text-white rounded text-xs">
                View
            </button>

            <button
                onclick="openEditModal({{ $receipt->id }})"
                class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">
                Edit
            </button>

            <form action="{{ route('receipts.approve',$receipt->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <button
                    class="px-3 py-2 bg-green-600 text-white rounded text-xs">
                    Approve
                </button>
            </form>

        </div>
    </td>

</tr>

@endforeach

</tbody>

<!-- Edit Receipt Modal -->
<div id="editReceiptModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-150 max-h-[90vh] overflow-y-auto">
    <h2 class="text-lg font-semibold mb-4">Edit Receipt</h2>
    <form id="editReceiptForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Supplier</label>
          <input type="text" id="edit_supplier" name="supplier" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Item</label>
          <input type="text" id="edit_item_name" name="item_name" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">PO Quantity</label>
          <input type="number" id="edit_po_quantity" name="po_quantity" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Received Quantity</label>
          <input type="number" id="edit_gr_quantity" name="gr_quantity" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Warehouse</label>
          <input type="text" id="edit_warehouse" name="warehouse" class="w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Inspection</label>
          <select id="edit_inspection_status" name="inspection_status" class="w-full border rounded p-2">
            <option>Passed</option>
            <option>Failed</option>
            <option>Pending</option>
          </select>
        </div>
        <div class="col-span-2">
          <label class="block text-sm font-medium mb-1">Match Status</label>
          <select id="edit_match_status" name="match_status" class="w-full border rounded p-2">
            <option>MATCHED</option>
            <option>QTY MISMATCH</option>
            <option>PRICE MISMATCH</option>
          </select>
        </div>
      </div>
      <div class="mt-6 flex justify-end space-x-2">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- Receipt Details Modal -->
<div id="receiptDetailsModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-125 max-h-[80vh] overflow-y-auto">
    <div class="flex justify-between mb-4">
      <h2 class="text-lg font-semibold">Receipt Details</h2>
      <button onclick="closeReceiptDetails()" class="text-gray-500 hover:text-gray-700">✕</button>
    </div>
    <div id="receiptDetailsContent" class="bg-gray-100 p-3 rounded">Loading...</div>
  </div>
</div>

<!-- Scripts -->
<script>
function openReceiptModal(id) {

    document.getElementById('receiptDetailsModal').classList.remove('hidden');

    fetch('/receipts/' + id)
        .then(response => response.json())
        .then(data => {

            document.getElementById('receiptDetailsContent').innerHTML = `

            <div class="grid grid-cols-2 gap-4 text-sm">

                <div>
                    <p class="text-xs text-slate-400">Receipt #</p>
                    <b>${data.gr_number ?? '-'}</b>
                </div>

                <div>
                    <p class="text-xs text-slate-400">PO Number</p>
                    <b>${data.po_number ?? '-'}</b>
                </div>

                <div>
                    <p class="text-xs text-slate-400">Supplier</p>
                    ${data.supplier ?? '-'}
                </div>

                <div>
                    <p class="text-xs text-slate-400">Item</p>
                    ${data.item_name ?? '-'}
                </div>

                <div>
                    <p class="text-xs text-slate-400">Ordered</p>
                    ${data.po_quantity ?? '-'}
                </div>

                <div>
                    <p class="text-xs text-slate-400">Received</p>
                    ${data.gr_quantity ?? '-'}
                </div>

                <div>
                    <p class="text-xs text-slate-400">Warehouse</p>
                    ${data.warehouse ?? '-'}
                </div>

                <div>
                    <p class="text-xs text-slate-400">Match</p>
                    ${data.match_status ?? '-'}
                </div>

                
            </div>

            `;

        })
        .catch(error => console.log(error));
}
function closeReceiptModal() {
  document.getElementById('receiptModal').classList.add('hidden');
}

function openEditModal(id) {
  const form = document.getElementById('editReceiptForm');
  form.action = '/goods-receipt/' + id;
  fetch('/goods-receipt/' + id + '/edit')
    .then(response => response.json())
    .then(data => {
      document.getElementById('edit_supplier').value = data.supplier ?? '';
      document.getElementById('edit_item_name').value = data.item_name;
      document.getElementById('edit_po_quantity').value = data.po_quantity;
      document.getElementById('edit_gr_quantity').value = data.gr_quantity;
      document.getElementById('edit_warehouse').value = data.warehouse ?? '';
      document.getElementById('edit_inspection_status').value = data.inspection_status;
      document.getElementById('edit_match_status').value = data.match_status;
      document.getElementById('editReceiptForm').action = '/goods-receipt/' + id;
      document.getElementById('editReceiptModal').classList.remove('hidden');
    })
    .catch(error => console.error(error));
}

function closeEditModal() {
  document.getElementById('editReceiptModal').classList.add('hidden');
}

function openReceiptDetails(id) {
  document.getElementById('receiptDetailsModal').classList.remove('hidden');
  fetch('/receipts/' + id)
    .then(response => response.json())
    .then(data => {
      document.getElementById('receiptDetailsContent').innerHTML = `
<div class="bg-gray-100 p-3 rounded mb-4">
<pre class="text-xs font-mono">${JSON.stringify(data, null, 2)}</pre>
</div>
`;
    })
    .catch(error => console.error(error));
}

function closeReceiptDetails() {
  document.getElementById('receiptDetailsModal').classList.add('hidden');
}
</script>

<!-- Filter Table Script -->
<script>
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