@extends('layouts.app')

@section('content')

<div class="bg-[#f1f5f9] min-h-screen p-8 pb-24">

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
            {{ $receipts->filter(fn($r) => ($r->match_status ?? 'MATCHED') == 'MATCHED')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5 border">
        <p class="text-sm text-slate-500">Qty Mismatch</p>
        <h2 class="text-3xl font-bold text-red-600">
            {{ $receipts->filter(fn($r) => str_contains($r->match_status ?? '', 'QTY'))->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5 border">
        <p class="text-sm text-slate-500">Price Mismatch</p>
        <h2 class="text-3xl font-bold text-yellow-500">
            {{ $receipts->filter(fn($r) => str_contains($r->match_status ?? '', 'PRICE'))->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5 border">
        <p class="text-sm text-slate-500">Pending</p>
        <h2 class="text-3xl font-bold text-blue-600">
            {{ $receipts->where('status','Pending')->count() }}
        </h2>
    </div>
</div>

    <!-- 3-Way Matching Process -->
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
                <h4 class="font-bold text-lg mb-2">Purchase Order</h4>
                <p class="text-sm text-slate-500">Verify ordered quantity, agreed supplier and unit price.</p>
            </div>

            <!-- Goods Receipt -->
            <div class="relative bg-green-50 border border-green-200 rounded-xl p-6">
                <div class="w-14 h-14 rounded-full bg-green-600 text-white flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h4 class="font-bold text-lg mb-2">Goods Receipt</h4>
                <p class="text-sm text-slate-500">Validate received quantity and inspection status.</p>
            </div>

            <!-- Supplier Invoice -->
            <div class="relative bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="w-14 h-14 rounded-full bg-yellow-500 text-white flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <h4 class="font-bold text-lg mb-2">Supplier Invoice</h4>
                <p class="text-sm text-slate-500">Validate invoice amount before payment approval.</p>
            </div>
        </div>
    </div>

    <!-- Recent Matching Activity -->
    <div class="mt-8 bg-white rounded-xl shadow">
        <div class="px-6 py-5 border-b">
            <h3 class="text-xl font-bold text-slate-800">Recent Matching Activity</h3>
            <p class="text-sm text-slate-500">Latest comparison processed by the system.</p>
        </div>

        <div>
            @foreach($receipts->take(5) as $receipt)
            <div class="flex items-center justify-between px-6 py-5 border-b hover:bg-slate-50">
                <div>
                    <h4 class="font-bold text-slate-700">{{ $receipt->po_number }}</h4>
                    <p class="text-sm text-slate-500">{{ $receipt->supplier }}</p>
                </div>
                <div>
                    @php $effectiveStatus = $receipt->effective_match_status; @endphp

                    @if($effectiveStatus=="MATCHED")
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">MATCHED</span>
                    @elseif($effectiveStatus=="PRICE MISMATCH")
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">PRICE MISMATCH</span>
                    @elseif($effectiveStatus=="QTY MISMATCH")
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">QTY MISMATCH</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                            {{ $effectiveStatus }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-4 gap-6 mt-8">
        <!-- Total Purchase Orders -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Total Purchase Orders</p>
                    <h2 class="text-4xl font-black mt-2">{{ $receipts->count() }}</h2>
                </div>
                <i class="fa-solid fa-file-lines text-5xl opacity-30"></i>
            </div>
        </div>

        <!-- Successful Matching -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Successful Matching</p>
                    <h2 class="text-4xl font-black mt-2">{{ $receipts->where('match_status','MATCHED')->count() }}</h2>
                </div>
                <i class="fa-solid fa-circle-check text-5xl opacity-30"></i>
            </div>
        </div>

        <!-- Need Review -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Need Review</p>
                    <h2 class="text-4xl font-black mt-2">{{ $receipts->filter(fn($receipt) => $receipt->effective_match_status !== 'MATCHED')->count() }}</h2>
                </div>
                <i class="fa-solid fa-triangle-exclamation text-5xl opacity-30"></i>
            </div>
        </div>

        <!-- Ready for Finance -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Ready for Finance</p>
                    <h2 class="text-4xl font-black mt-2">{{ $receipts->where('status','Approved')->count() }}</h2>
                </div>
                <i class="fa-solid fa-money-check-dollar text-5xl opacity-30"></i>
            </div>
        </div>
    </div>

</div>

<!-- Unified Master 3-Way Matching & Order List Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200 mt-8">
    <div class="flex items-center justify-between px-6 py-4 border-b bg-slate-50">
        <div>
            <h3 class="text-lg font-bold text-slate-800">
                Unified 3-Way Matching & Purchase Order Records
            </h3>
            <p class="text-sm text-slate-500">
                Comprehensive audit trail combining Receipts and Master Order Data
            </p>
        </div>
        <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold">
            {{ $receipts->count() }} Matching Records
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-100 text-slate-700 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-5 py-4 text-left">PO Number</th>
                    <th class="px-5 py-4 text-left">Supplier</th>
                    <th class="px-5 py-4 text-left">Item / Product</th>
                    <th class="px-5 py-4 text-center">PO Qty</th>
                    <th class="px-5 py-4 text-center">Received Qty</th>
                    <th class="px-5 py-4 text-right">PO Price / Total</th>
                    <th class="px-5 py-4 text-right">Invoice Price</th>
                    <th class="px-5 py-4 text-center">Inspection</th>
                    <th class="px-5 py-4 text-center">Result / Status</th>
                    <th class="px-5 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="matchingTable" class="divide-y divide-gray-100 text-xs">
            @foreach($receipts as $receipt)
                @php
                    // Retrieve linked purchase order items if available to pull full list details cleanly
                    $poModel = $receipt->purchaseOrder;
                    $firstItem = $poModel?->items->first();
                    $calculatedTotal = $poModel ? $poModel->items->sum(fn($i) => $i->qty * $i->price) : 0;
                @endphp
                <tr class="border-b hover:bg-slate-50 transition">
                    <!-- PO Number -->
                    <td class="px-5 py-4 font-bold text-gray-900">
                        {{ $receipt->po_number }}
                    </td>

                    <!-- Supplier Name -->
                    <td class="px-5 py-4 font-medium text-gray-800">
                        {{ $receipt->supplier }}
                    </td>

                    <!-- Item Name -->
                    <td class="px-5 py-4 text-gray-600">
                        {{ $receipt->item_name }}
                    </td>

                    <!-- PO Qty -->
                    <td class="px-5 py-4 text-center font-semibold text-gray-700">
                        {{ $receipt->po_quantity }}
                    </td>

                    <!-- Received Qty -->
                    <td class="px-5 py-4 text-center font-semibold text-gray-700">
                        {{ $receipt->gr_quantity }}
                    </td>

                    <!-- PO Price & Computed Total (combining list and receipts data) -->
                    <td class="px-5 py-4 text-right">
                        <div class="font-bold text-gray-900">₱{{ number_format($receipt->po_price, 2) }}</div>
                        @if($calculatedTotal > 0)
                            <div class="text-[10px] text-slate-400 font-medium">Total: ₱{{ number_format($calculatedTotal, 2) }}</div>
                        @endif
                    </td>

                    <!-- Invoice Price -->
                    <td class="px-5 py-4 text-right font-bold text-gray-900">
                        ₱{{ number_format($receipt->invoice_price, 2) }}
                    </td>

                    <!-- Inspection Status -->
                    <td class="px-5 py-4 text-center">
                        @if($receipt->inspection_status == "Passed")
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">PASSED</span>
                        @elseif($receipt->inspection_status == "Failed")
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">FAILED</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">PENDING</span>
                        @endif
                    </td>

                    <!-- Result / Matching Status -->
                    <td class="px-5 py-4 text-center">
                        @php $effectiveStatus = $receipt->effective_match_status; @endphp
                        @if($effectiveStatus == "MATCHED")
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">MATCHED</span>
                        @elseif($effectiveStatus == "PRICE MISMATCH")
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">PRICE MISMATCH</span>
                        @elseif($effectiveStatus == "QTY MISMATCH")
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">QTY MISMATCH</span>
                        @else
                            <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">{{ $effectiveStatus }}</span>
                        @endif
                    </td>

                    <!-- Actions (combining View Details from matching & options from list) -->
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('receipts.details', $receipt->id) }}" title="View Matching Details" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold inline-flex items-center">
                                <i class="fa-solid fa-eye mr-1"></i> Details
                            </a>
                            @if($poModel)
                                <a href="{{ route('orders.edit', $poModel->id) }}" title="Edit Master Order" class="w-7 h-7 rounded-lg bg-gray-100 text-gray-600 hover:bg-amber-50 hover:text-amber-600 flex items-center justify-center transition">
                                    <i class="fa fa-edit text-xs"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection