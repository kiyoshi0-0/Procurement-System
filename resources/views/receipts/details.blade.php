@extends('layouts.app')

@section('content')
<div class="bg-[#f1f5f9] min-h-screen p-8 pb-24">
    <div class="mb-5">
        <h2 class="text-2xl font-black text-[#1E3A8A]">Receipt Matching Details</h2>
        <p class="text-xs font-medium text-slate-400 mt-0.5">Inventory / <span class="text-slate-500">Receipt Details</span></p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="bg-white rounded-xl shadow p-6 border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Receipt Summary</h3>
            <div class="space-y-3 text-sm text-slate-600">
                <div><strong>Receipt #:</strong> {{ $receipt->gr_number }}</div>
                <div><strong>PO Number:</strong> {{ $receipt->po_number }}</div>
                <div><strong>Supplier:</strong> {{ $receipt->supplier }}</div>
                <div><strong>Item:</strong> {{ $receipt->item_name }}</div>
                <div><strong>Warehouse:</strong> {{ $receipt->warehouse }}</div>
                <div><strong>Inspection:</strong> {{ $receipt->inspection_status }}</div>
                <div><strong>Status:</strong> {{ $receipt->status }}</div>
             <div><strong>Approved at:</strong> {{ $receipt->approved_at ? \Carbon\Carbon::parse($receipt->approved_at)->format('M d, Y H:i') : 'N/A' }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border border-slate-200 lg:col-span-2">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">3-Way Matching Details</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <p class="text-xs text-slate-500 uppercase tracking-wide mb-2">PO Quantity</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $receipt->po_quantity }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <p class="text-xs text-slate-500 uppercase tracking-wide mb-2">Received Quantity</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $receipt->gr_quantity }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <p class="text-xs text-slate-500 uppercase tracking-wide mb-2">PO Unit Price</p>
                    <p class="text-2xl font-bold text-slate-800">₱{{ number_format($receipt->po_price ?? 0, 2) }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <p class="text-xs text-slate-500 uppercase tracking-wide mb-2">Invoice Price</p>
                    <p class="text-2xl font-bold text-slate-800">₱{{ number_format($receipt->invoice_price ?? 0, 2) }}</p>
                </div>
            </div>

            <div class="mt-6 bg-white border border-slate-200 rounded-xl p-5">
                <h4 class="text-md font-semibold text-slate-800 mb-3">Match Result</h4>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-sm">Computed: {{ $receipt->computed_match_status }}</span>
                    <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm">Effective: {{ $receipt->effective_match_status }}</span>
                </div>
                @if($receipt->purchaseOrder)
                <div class="mt-4 text-sm text-slate-600">
                    <p><strong>Linked PO:</strong> {{ $receipt->purchaseOrder->po_number }}</p>
                    <p><strong>PO Status:</strong> {{ $receipt->purchaseOrder->status }}</p>
                </div>
                @endif
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('receipts.threeway') }}" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm">Back to Matching</a>
            </div>
        </div>
    </div>
</div>
@endsection