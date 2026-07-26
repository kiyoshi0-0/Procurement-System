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
            <h3 class="text-lg font-bold text-slate-800">
                3-Way Matching Records
            </h3>

            <p class="text-sm text-slate-500">
                Compare Purchase Order, Goods Receipt and Supplier Invoice
            </p>
        </div>

        <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold">
            {{ $receipts->count() }} Records
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full">

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

        </table>

    </div>
<script>
@endsection
