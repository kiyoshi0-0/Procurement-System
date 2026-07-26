@extends('layouts.app')

@section('content')

<div class="bg-[#f1f5f9] min-h-screen p-8 pb-24">


    <!-- Header -->
    <div class="mb-5 flex justify-between items-center">

<div class="mb-5">

    <h2 class="text-2xl font-black text-[#1E3A8A]">
        3-Way Matching
    </h2>

    <p class="text-xs font-medium text-slate-400 mt-0.5">
        Inventory /
        <span class="text-slate-500">
            3-Way Matching
        </span>
    </p>


</div>

    <!-- Summary Cards -->

    <div class="grid grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow p-5 border">
            <p class="text-sm text-slate-500">Matched</p>
            <h2 class="text-3xl font-bold text-green-600">
                {{ $receipts->where('effective_match_status','MATCHED')->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border">
            <p class="text-sm text-slate-500">Qty Mismatch</p>
            <h2 class="text-3xl font-bold text-red-600">
                {{ $receipts->where('effective_match_status','QTY MISMATCH')->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border">
            <p class="text-sm text-slate-500">Price Mismatch</p>
            <h2 class="text-3xl font-bold text-yellow-500">
                {{ $receipts->where('effective_match_status','PRICE MISMATCH')->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border">
            <p class="text-sm text-slate-500">Pending</p>
            <h2 class="text-3xl font-bold text-blue-600">
                {{ $receipts->where('status','Pending')->count() }}
            </h2>
        </div>

    </div>


    <div class="mt-8 bg-white rounded-xl shadow p-6">

    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-slate-800">
            3-Way Matching Process
        </h3>

        <span class="text-sm text-slate-500">
            ERP Validation Workflow
        </span>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- Purchase Order -->
        <div class="relative bg-blue-50 border border-blue-200 rounded-xl p-6">

            <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-file-lines"></i>
            </div>

            <h4 class="font-bold text-lg mb-2">
                Purchase Order
            </h4>

            <p class="text-sm text-slate-500">
                Verify ordered quantity, agreed supplier and unit price.
            </p>

        </div>

        <!-- Goods Receipt -->

        <div class="relative bg-green-50 border border-green-200 rounded-xl p-6">

            <div class="w-14 h-14 rounded-full bg-green-600 text-white flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-box-open"></i>
            </div>

            <h4 class="font-bold text-lg mb-2">
                Goods Receipt
            </h4>

            <p class="text-sm text-slate-500">
                Validate received quantity and inspection status.
            </p>

        </div>

        <!-- Supplier Invoice -->

        <div class="relative bg-yellow-50 border border-yellow-200 rounded-xl p-6">

            <div class="w-14 h-14 rounded-full bg-yellow-500 text-white flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>

            <h4 class="font-bold text-lg mb-2">
                Supplier Invoice
            </h4>

            <p class="text-sm text-slate-500">
                Validate invoice amount before payment approval.
            </p>

        </div>

    </div>

</div>

<div class="mt-8 bg-white rounded-xl shadow">

    <div class="px-6 py-5 border-b">

        <h3 class="text-xl font-bold text-slate-800">
            Recent Matching Activity
        </h3>

        <p class="text-sm text-slate-500">
            Latest comparison processed by the system.
        </p>

    </div>

    <div>

        @foreach($receipts->take(5) as $receipt)

        <div class="flex items-center justify-between px-6 py-5 border-b hover:bg-slate-50">

            <div>

                <h4 class="font-bold text-slate-700">
                    {{ $receipt->po_number }}
                </h4>

                <p class="text-sm text-slate-500">
                    {{ $receipt->supplier }}
                </p>

            </div>

            <div>
                    @php $effectiveStatus = $receipt->effective_match_status; @endphp

                    @if($effectiveStatus=="MATCHED")

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            MATCHED
                        </span>

                    @elseif($effectiveStatus=="PRICE MISMATCH")

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                            PRICE MISMATCH
                        </span>

                    @elseif($effectiveStatus=="QTY MISMATCH")

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                            QTY MISMATCH
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                            {{ $effectiveStatus }}

                @endif

            </div>

        </div>

        @endforeach

    </div>

</div>

<div class="grid grid-cols-4 gap-6 mt-8">

    <!-- Total Purchase Orders -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Total Purchase Orders
                </p>

                <h2 class="text-4xl font-black mt-2">
                    {{ $receipts->count() }}
                </h2>
            </div>

            <i class="fa-solid fa-file-lines text-5xl opacity-30"></i>

        </div>

    </div>

    <!-- Successful Matching -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Successful Matching
                </p>

                <h2 class="text-4xl font-black mt-2">
                    {{ $receipts->where('match_status','MATCHED')->count() }}
                </h2>
            </div>

            <i class="fa-solid fa-circle-check text-5xl opacity-30"></i>

        </div>

    </div>

    <!-- Need Review -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl p-6 text-white shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Need Review
                </p>

                <h2 class="text-4xl font-black mt-2">
                    {{ $receipts->filter(fn($receipt) => $receipt->effective_match_status !== 'MATCHED')->count() }}
                </h2>
            </div>

            <i class="fa-solid fa-triangle-exclamation text-5xl opacity-30"></i>

        </div>

    </div>

    <!-- Ready for Finance -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-6 text-white shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Ready for Finance
                </p>

                <h2 class="text-4xl font-black mt-2">
                    {{ $receipts->where('status','Approved')->count() }}
                </h2>
            </div>

            <i class="fa-solid fa-money-check-dollar text-5xl opacity-30"></i>

        </div>

    </div>

</div>





   <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">

    <div class="flex items-center justify-between px-6 py-4 border-b bg-slate-50">


        <div>
            <h2 class="text-2xl font-black text-[#1E3A8A]">
                3-Way Matching Control Center
            </h2>
            <p class="text-xs font-medium text-slate-400 mt-1">
                Receipt /
                <span class="text-slate-500">
                    3-Way Matching
                </span>
            </p>
        </div>
        <!-- Quick Action Trigger -->
      <button type="button" onclick="runAutomaticMatch()" class="px-4 py-2.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-xs font-bold rounded-xl shadow-xs transition cursor-pointer flex items-center border border-emerald-200">
    <i class="fa-solid fa-wand-magic-sparkles mr-2 text-emerald-700"></i> Run Automated 3-Way Check
</button>s
    </div>

    <!-- Stats Cards (Ginayang pareho ang istilo ng Goods Receipt) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Total Matched</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $receipts->where('match_status','MATCHED')->count() }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100">✅</div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Qty Mismatch</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $receipts->where('match_status','QTY MISMATCH')->count() }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">📦</div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Price Mismatch</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $receipts->where('match_status','PRICE MISMATCH')->count() }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-100">⚠️</div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Pending Review</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $receipts->where('match_status','!=','MATCHED')->count() }}</h2>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100">⏳</div>
        </div>
      </div>
    </div>

    <!-- Workflow Banner -->
<!-- Interactive 3-Way Matching Process Workflow -->
<div class="mb-8 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-base font-bold text-slate-800">
                ERP 3-Way Matching Workflow
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">
                Automatic audit of PO, Goods Receipt, and Supplier Invoice.
            </p>
        </div>
        <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">
            Active Protocol
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Box 1 -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-slate-800 text-xs tracking-wide">1. Purchase Order (PO)</span>
                    <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold">Verified</span>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Validates expected quantity and unit price.
                </p>
            </div>
            <div class="mt-3 pt-2 border-t border-slate-100 text-[11px] text-slate-400 flex justify-between items-center">
                <span>Ready</span>
                <i class="fa-solid fa-circle-check text-blue-600"></i>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-slate-800 text-xs tracking-wide">2. Goods Receipt (GR)</span>
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] font-bold">Audited</span>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Compares received inventory with inspection status.
                </p>
            </div>
            <div class="mt-3 pt-2 border-t border-slate-100 text-[11px] text-slate-400 flex justify-between items-center">
                <span>Checked</span>
                <i class="fa-solid fa-circle-check text-green-600"></i>
            </div>
        </div>


        <!-- Box 3 -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-slate-800 text-xs tracking-wide">3. Supplier Invoice</span>
                    <span class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-[10px] font-bold">Pending</span>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Verifies billing cost against the original PO.
                </p>
            </div>
            <div class="mt-3 pt-2 border-t border-slate-100 text-[11px] text-slate-400 flex justify-between items-center">
                <span>Reviewing</span>
                <i class="fa-solid fa-clock text-amber-500"></i>
            </div>
        </div>
    </div>
</div>
    <!-- Main Records Table -->
    <div class="bg-white rounded-2xl border border-slate-300 shadow overflow-hidden mt-6">
      <div class="p-5 border-b border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3">
          <h3 class="text-lg font-semibold text-slate-800">3-Way Matching Master Records</h3>
          <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-xs font-bold border border-slate-200">
              {{ $receipts->count() }} Total Items
          </span>
        </div>
      </div>

            <thead class="bg-slate-100 text-slate-700">

                <tr>

                    <th class="px-5 py-4 text-left">PO Number</th>

                    <th class="px-5 py-4 text-left">Supplier</th>

                    <th class="px-5 py-4 text-left">Item</th>

                    <th class="px-5 py-4 text-center">PO Qty</th>

                    <th class="px-5 py-4 text-center">Received Qty</th>

                    <th class="px-5 py-4 text-right">PO Price</th>

                    <th class="px-5 py-4 text-right">Invoice Price</th>

                    <th class="px-5 py-4 text-center">Inspection</th>

                    <th class="px-5 py-4 text-center">Result</th>

                    <th class="px-5 py-4 text-center">Action</th>

                </tr>

            </thead>
<tbody id="matchingTable">
            @foreach($receipts as $receipt)

                <tr class="border-b hover:bg-slate-50 transition">

                    <td class="px-5 py-4 font-semibold">
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

                    <td class="px-5 py-4 text-right">
                        ₱{{ number_format($receipt->po_price,2) }}
                    </td>

                    <td class="px-5 py-4 text-right">
                        ₱{{ number_format($receipt->invoice_price,2) }}
                    </td>

                    <td class="px-5 py-4 text-center">

                        @if($receipt->inspection_status=="Passed")

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                PASSED
                            </span>

                        @elseif($receipt->inspection_status=="Failed")

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                FAILED
                            </span>

                        @else

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                PENDING
                            </span>

                        @endif

                    </td>

                    <td class="px-5 py-4 text-center">
                        @php $effectiveStatus = $receipt->effective_match_status; @endphp
                        @if($effectiveStatus=="MATCHED")

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                MATCHED
                            </span>

                        @elseif($effectiveStatus=="PRICE MISMATCH")

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                PRICE MISMATCH
                            </span>

                        @elseif($effectiveStatus=="QTY MISMATCH")

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                QTY MISMATCH
                            </span>

                        @else

                            <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">
                                PENDING
                            </span>

                        @endif

                    </td>

                    <td class="px-5 py-4 text-center">
                        <a href="{{ route('receipts.details', $receipt->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold inline-flex items-center">
                            <i class="fa-solid fa-eye mr-1"></i>
                            View Details
                        </a>
                    </td>

                </tr>

            @endforeach

            </tbody>


      <div class="table-container overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-slate-700">
          <thead>
            <tr class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">
              <th class="px-5 py-3 font-semibold text-left">PO Number</th>
              <th class="py-4 px-5 text-left">Supplier</th>
              <th class="py-4 px-5 text-left">Item</th>
              <th class="py-4 px-5 text-center">PO Qty</th>
              <th class="py-4 px-5 text-center">Received Qty</th>
              <th class="py-4 px-5 text-right">PO Price</th>
              <th class="py-4 px-5 text-right">Invoice Price</th>
              <th class="py-4 px-5 text-center">Inspection</th>
              <th class="py-4 px-5 text-center">Result Match</th>
              <th class="py-4 px-5 text-center">Action</th>
            </tr>
          </thead>
          <tbody id="receiptTable">
            @forelse($receipts ?? [] as $receipt)
            <tr class="hover:bg-slate-50 border-b">
                <td class="px-5 py-4 font-bold text-blue-900">{{ $receipt->po_number }}</td>
                <td class="px-5 py-4 text-slate-600">{{ $receipt->supplier }}</td>
                <td class="px-5 py-4 text-slate-600">{{ $receipt->item_name }}</td>
                <td class="px-5 py-4 text-center font-medium">{{ $receipt->po_quantity }}</td>
                <td class="px-5 py-4 text-center font-medium">{{ $receipt->gr_quantity }}</td>
                <td class="px-5 py-4 text-right">₱{{ number_format($receipt->po_price ?? 0, 2) }}</td>
                <td class="px-5 py-4 text-right">₱{{ number_format($receipt->invoice_price ?? 0, 2) }}</td>
                <td class="px-5 py-4 text-center">
                    <span class="px-2.5 py-1 text-[10px] font-bold rounded
                    @if($receipt->inspection_status=='Passed') bg-green-100 text-green-700
                    @elseif($receipt->inspection_status=='Pending') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ strtoupper($receipt->inspection_status) }}
                    </span>
                </td>
                <td class="px-5 py-4 text-center">
                    <span class="px-2.5 py-1 text-[10px] font-bold rounded
                    @if($receipt->match_status=='MATCHED') bg-green-100 text-green-700
                    @elseif($receipt->match_status=='PRICE MISMATCH') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ $receipt->match_status }}
                    </span>
                </td>
                <td class="px-5 py-4">
                    <div class="flex justify-center items-center gap-2">
                        <!-- Square Icon Action Button (Pareho na ng itsura sa Goods Receipt) -->
                        <button type="button" onclick="viewDetails({{ $receipt->id }})" title="View Details" class="w-9 h-9 flex items-center justify-center bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 rounded-xl transition shadow-xs cursor-pointer">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center py-6 text-slate-400">No 3-way matching records found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
</div>

<!-- ================= UPGRADED VIEW DETAILS MODAL ================= -->
<div id="matchingDetailsModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-xs items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl border border-slate-100">
    
    <!-- Modal Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b border-slate-100 bg-slate-50/50">
      <div>
          <h3 class="text-base font-black text-slate-800">3-Way Matching Enterprise Audit</h3>
          <p class="text-xs text-slate-400">Comprehensive documentation of PO, Goods Receipt, and Invoice.</p>
      </div>
      <button type="button" onclick="closeMatchingModal()" class="w-8 h-8 rounded-full bg-slate-200/60 hover:bg-red-100 hover:text-red-600 text-slate-500 flex items-center justify-center font-bold text-sm cursor-pointer transition">✕</button>
    </div>

    <!-- Modal Content -->
    <div id="matchingModalContent" class="p-6 space-y-5">
        <div class="text-center py-8 text-slate-400 text-xs">Loading details...</div>
    </div>

    <!-- Modal Footer -->
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
        <button type="button" onclick="closeMatchingModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold cursor-pointer transition shadow-sm">Close</button>
    </div>
  </div>
</div>

<script>
function runAutomaticMatch() {
    fetch('/receipts/run-matching', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(" Automated 3-way matching audit successfully completed!");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("can't connect to server.");
    });
}

function viewDetails(id) {
    const modal = document.getElementById('matchingDetailsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('matchingModalContent').innerHTML = `<p class="text-center py-8 text-slate-400 text-xs">Loading details...</p>`;

    fetch('/receipts/' + id)
        .then(response => response.json())
        .then(data => {
            let isQtyMatch = Number(data.po_quantity) === Number(data.gr_quantity);
            let qtyStatus = isQtyMatch 
                ? '<span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-[11px]">Matched</span>' 
                : '<span class="text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded text-[11px]">Mismatch / Shortage</span>';
                
            let isPriceMatch = Number(data.po_price) === Number(data.invoice_price);
            let priceStatus = isPriceMatch 
                ? '<span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-[11px]">Matched</span>' 
                : '<span class="text-yellow-600 font-bold bg-yellow-50 px-2 py-0.5 rounded text-[11px]">Price Variance Detected</span>';

            let badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            if (data.match_status && data.match_status.includes('MISMATCH')) {
                badgeClass = 'bg-red-100 text-red-800 border-red-200';
            }

            document.getElementById('matchingModalContent').innerHTML = `
            <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-200/80 grid grid-cols-2 gap-4 text-xs">
                <div><span class="text-slate-400 block font-medium">PO Number:</span> <b class="text-blue-900 text-sm font-bold">${data.po_number ?? '-'}</b></div>
                <div><span class="text-slate-400 block font-medium">Supplier:</span> <b class="text-slate-800 text-sm">${data.supplier ?? '-'}</b></div>
                <div class="col-span-2 pt-1 border-t border-slate-200/60"><span class="text-slate-400 block font-medium">Item / Component:</span> <b class="text-slate-800 text-sm">${data.item_name ?? '-'}</b></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Quantity Box -->
                <div class="border border-slate-200 rounded-xl p-4 bg-blue-50/20 shadow-xs">
                    <h4 class="font-bold text-blue-900 text-xs mb-3 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-boxes-stacked mr-1.5 text-blue-600"></i> 1. Quantity Validation
                    </h4>
                    <div class="space-y-1 text-xs text-slate-600 mb-3">
                        <p class="flex justify-between">PO Quantity: <b class="text-slate-800">${data.po_quantity} pcs</b></p>
                        <p class="flex justify-between">Received Qty (GR): <b class="text-slate-800">${data.gr_quantity} pcs</b></p>
                    </div>
                    <div class="pt-2 border-t border-slate-200/60 text-xs flex justify-between items-center">
                        <span class="text-slate-400">Status:</span> ${qtyStatus}
                    </div>
                </div>

                <!-- Price Box -->
                <div class="border border-slate-200 rounded-xl p-4 bg-amber-50/20 shadow-xs">
                    <h4 class="font-bold text-amber-900 text-xs mb-3 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-peso-sign mr-1.5 text-amber-600"></i> 2. Price Validation
                    </h4>
                    <div class="space-y-1 text-xs text-slate-600 mb-3">
                        <p class="flex justify-between">PO Unit Price: <b class="text-slate-800">₱${Number(data.po_price || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</b></p>
                        <p class="flex justify-between">Invoice Price: <b class="text-slate-800">₱${Number(data.invoice_price || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</b></p>
                    </div>
                    <div class="pt-2 border-t border-slate-200/60 text-xs flex justify-between items-center">
                        <span class="text-slate-400">Status:</span> ${priceStatus}
                    </div>
                </div>
            </div>

            <!-- Final Evaluation Box -->
            <div class="p-4 rounded-xl border ${badgeClass} flex items-center justify-between text-xs shadow-xs">
                <div>
                    <span class="font-bold block text-[11px] uppercase tracking-wider opacity-75">Final System Evaluation & Recommendation:</span>
                    <span class="text-slate-700 mt-0.5 block">This transaction has been successfully audited by the ERP protocol.</span>
                </div>
                <span class="uppercase font-black px-3 py-1.5 rounded-lg bg-white shadow-xs tracking-wider text-sm">
                    ${data.match_status ?? 'PENDING'}
                </span>
            </div>`;
        })
        .catch(error => {
            document.getElementById('matchingModalContent').innerHTML = `<p class="text-center py-8 text-red-500 text-xs">Failed to fetch transaction details.</p>`;
        });
}

function closeMatchingModal() {
    const modal = document.getElementById('matchingDetailsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

@endsection