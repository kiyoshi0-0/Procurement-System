@extends('layouts.app')

@section('content')
<section class="view-panel space-y-6 max-w-7xl w-full mx-auto p-4 md:p-6">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Purchase Order Print</h1>
                <p class="text-sm text-gray-500 mt-1">PO Number: <strong>{{ $po->po_number }}</strong></p>
            </div>
            <div class="space-y-2 text-right">
                <button onclick="window.print()" class="inline-flex items-center justify-center bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">Print</button>
                <a href="{{ route('orders.details', $po->id) }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 px-4 py-2 rounded-xl text-xs font-semibold hover:bg-gray-50 transition">Back to Details</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border border-gray-100 rounded-2xl p-5 bg-gray-50">
            <div class="space-y-2 text-xs">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Supplier</h2>
                <p class="text-gray-700 font-semibold">{{ $po->supplier->name ?? 'N/A' }}</p>
                <p class="text-gray-500">{{ $po->supplier->address ?? 'N/A' }}</p>
                <p class="text-gray-500">{{ $po->supplier->contact_person ?? '' }}</p>
                <p class="text-gray-500">{{ $po->supplier->phone ?? '' }}{{ $po->supplier->phone && $po->supplier->email ? ' · ' : '' }}{{ $po->supplier->email ?? '' }}</p>
            </div>
            <div class="space-y-2 text-xs text-right">
                <p class="text-gray-500">Date: <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($po->date)->format('F d, Y') }}</span></p>
                <p class="text-gray-500">Status: <span class="font-semibold text-gray-900">{{ ucfirst($po->status) }}</span></p>
                <p class="text-gray-500">PO Number: <span class="font-semibold text-gray-900">{{ $po->po_number }}</span></p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-gray-100 text-gray-700 font-semibold uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Item</th>
                        <th class="px-4 py-3 text-center">Quantity</th>
                        <th class="px-4 py-3 text-right">Unit Price</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($po->items as $index => $item)
                        <tr class="border-t border-gray-100">
                            <td class="px-4 py-4 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-4 font-semibold">{{ $item->name }}</td>
                            <td class="px-4 py-4 text-center">{{ $item->qty }}</td>
                            <td class="px-4 py-4 text-right">₱{{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-4 text-right font-semibold">₱{{ number_format($item->qty * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @php
            $subtotal = $po->items->sum(fn($item) => $item->qty * $item->price);
            $tax = 0;
            $shipping = 0;
            $total = $subtotal + $tax + $shipping;
        @endphp

        <div class="flex flex-col items-end gap-2 text-xs text-gray-700">
            <div class="w-full max-w-sm bg-gray-50 rounded-2xl border border-gray-100 p-4">
                <div class="flex justify-between mb-2"><span>Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
                <div class="flex justify-between mb-2"><span>Tax</span><span>₱{{ number_format($tax, 2) }}</span></div>
                <div class="flex justify-between mb-2"><span>Shipping</span><span>₱{{ number_format($shipping, 2) }}</span></div>
                <div class="flex justify-between font-bold text-gray-900 text-sm border-t border-gray-200 pt-3"><span>Total</span><span>₱{{ number_format($total, 2) }}</span></div>
            </div>
        </div>

        <div class="text-xs text-gray-500 pt-2">
            <p>This document is generated for printing. Please verify the order details before submitting.</p>
        </div>
    </div>
</section>
@endsection
