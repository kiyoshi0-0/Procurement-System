@extends('layouts.app')

@section('content')
<!-- Logic para sa Consistent Status Color at Tracker[cite: 3] -->
@php
    $statusColor = 'bg-red-100 text-red-600';
    $progressWidth = '0%';
    $step1Color = $step2Color = $step3Color = $step4Color = 'bg-gray-300';

    if ($po->status === 'Delivered') {
        $statusColor = 'bg-green-100 text-green-700';
        $progressWidth = '100%';
        $step1Color = $step2Color = $step3Color = $step4Color = 'bg-emerald-500';
    } elseif ($po->status === 'Confirmed') {
        $statusColor = 'bg-orange-100 text-orange-700';
        $progressWidth = '66%';
        $step1Color = $step2Color = $step3Color = 'bg-emerald-500';
    } elseif ($po->status === 'Sent') {
        $statusColor = 'bg-blue-100 text-blue-700';
        $progressWidth = '33%';
        $step1Color = $step2Color = 'bg-emerald-500';
    }
@endphp

<section id="po-details-view" class="view-panel space-y-6 max-w-[95%] w-full mx-auto p-6">
    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Purchase Order Details</h1>
        <nav class="text-sm text-gray-400 mt-1">Dashboard > Orders > <span class="text-gray-700 font-semibold">{{ $po->po_number }}</span></nav>
    </div>

    <!-- Enhanced Tracking Timeline -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 flex flex-col md:flex-row items-center justify-between gap-8">
        <!-- Status & Title -->
        <div class="shrink-0 space-y-2">
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-800">PO # {{ $po->po_number }}</span>
                <span class="{{ $statusColor }} text-xs px-4 py-1 rounded-full font-bold uppercase">{{ $po->status }}</span>
            </div>
            <h2 class="text-2xl font-black text-gray-900">{{ $po->po_number }}</h2>
        </div>
        
        <!-- Timeline: Extended and Larger Shapes -->
        <div class="flex-1 w-full max-w-2xl mx-auto relative px-4">
            <!-- Progress Line Background -->
            <div class="absolute left-10 right-10 top-4 h-1.5 bg-gray-200"></div>
            <!-- Active Progress Line -->
            <div class="absolute left-10 top-4 h-1.5 bg-emerald-500 transition-all duration-500" style="width: {{ $progressWidth }};"></div>
            
            <!-- Steps Container -->
            <div class="flex justify-between relative z-10 w-full">
                @foreach(['Timeline', 'Add Items', 'Add Documents', 'Review & Send'] as $step)
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full border-4 border-white shadow-sm {{ 
                            ($step === 'Timeline') || 
                            ($step === 'Add Items' && ($progressWidth === '66%' || $progressWidth === '100%')) ||
                            ($step === 'Add Documents' && ($progressWidth === '66%' || $progressWidth === '100%')) ||
                            ($step === 'Review & Send' && $progressWidth === '100%') 
                            ? 'bg-emerald-500' : 'bg-gray-300' 
                        }}"></div>
                        <span class="text-xs font-bold text-gray-500 mt-3 whitespace-nowrap">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Main Content -->
        <div class="lg:col-span-9 space-y-8">
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Supplier Information</h3>
                <div class="text-sm text-gray-600 space-y-2">
                    <p class="font-bold text-gray-800">Company Name: <span class="font-normal text-gray-500">{{ $po->supplier }}</span></p>
                    <p class="font-bold text-gray-800">Delivery Address: <span class="font-normal text-gray-500">{{ $po->delivery_address }}</span></p>
                    <p class="font-bold text-gray-800">Order Date: <span class="font-normal text-gray-500">{{ $po->created_at->format('M d, Y') }}</span></p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
                <h3 class="text-lg font-bold text-gray-900">Itemized Purchase List</h3>
                <table class="w-full text-left text-sm border-separate border-spacing-y-3">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 font-bold">
                            <th class="p-4 rounded-l-xl">Item</th>
                            <th class="p-4 text-center">Quantity</th>
                            <th class="p-4 text-center">Unit Price</th>
                            <th class="p-4 text-center rounded-r-xl">Total</th>
                        </tr>
                    </thead>
                    <tbody class="font-semibold text-gray-800">
                        @foreach($po->items as $item)
                        <tr class="bg-gray-50 rounded-xl">
                            <td class="p-4">{{ $item->name }}</td>
                            <td class="p-4 text-center">{{ $item->qty }}</td>
                            <td class="p-4 text-center">₱{{ number_format($item->price, 2) }}</td>
                            <td class="p-4 text-center font-bold">₱{{ number_format($item->qty * $item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right text-sm font-extrabold text-gray-900 pt-4 border-t border-dashed">
                    Grand Total: ₱{{ number_format($po->items->sum(fn($i) => $i->qty * $i->price), 2) }}
                </div>
            </div>

            <!-- Matching Cards Section[cite: 3] -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-bold text-gray-900">Match Invoice</h3>
                        <span class="bg-green-100 text-green-700 text-xs px-4 py-1 rounded-full font-bold uppercase">Matched</span>
                    </div>
                    <p class="text-sm text-green-600 font-bold flex items-center gap-2">✓ Match PO's as delivered</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-bold text-gray-900">Match Delivery Receipt</h3>
                        <span class="bg-green-100 text-green-700 text-xs px-4 py-1 rounded-full font-bold uppercase">Matched</span>
                    </div>
                    <div class="text-sm text-green-600 font-bold space-y-2">
                        <p class="flex items-center gap-2">✓ Match Invoice</p>
                        <p class="flex items-center gap-2">✓ Match Delivery Receipt</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4 text-md font-bold text-center">
                <a href="#" class="block w-full bg-emerald-500 text-white py-4 rounded-xl hover:bg-emerald-600 transition">Send to Supplier</a>
                <a href="{{ route('orders.details', $po->po_number) }}" class="block w-full bg-white border border-gray-200 text-gray-700 py-4 rounded-xl hover:bg-gray-50 transition">Re-print</a>
                <a href="{{ route('orders.edit', $po->id) }}" class="block w-full bg-white border border-gray-200 text-gray-700 py-4 rounded-xl hover:bg-gray-50 transition">Revise</a>
                <form action="{{ route('orders.cancel', $po->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full bg-white border border-red-200 text-red-500 py-4 rounded-xl hover:bg-red-50 transition">Cancel Order</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection