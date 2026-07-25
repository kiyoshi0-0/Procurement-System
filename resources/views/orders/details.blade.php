@extends('layouts.app')

@section('content')
@php
    $statusKey = ucfirst(strtolower($po->status));
    
    $statusColor = match($statusKey) {
        'Delivered' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
        'Sent' => 'bg-blue-50 text-blue-700 border border-blue-200/60',
        'Confirmed' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
        default => 'bg-rose-50 text-rose-700 border border-rose-200/60',
    };

    $dotColor = match($statusKey) {
        'Delivered' => 'bg-emerald-500',
        'Sent' => 'bg-blue-500',
        'Confirmed' => 'bg-amber-500',
        default => 'bg-rose-500',
    };

    $progressWidth = match($statusKey) {
        'Delivered' => '100%',
        'Sent' => '100%',
        'Confirmed' => '66%',
        default => '0%',
    };
@endphp

<section id="po-details-view" class="view-panel space-y-6 max-w-[98%] w-full mx-auto p-4 md:p-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Purchase Order Details</h1>
            <nav class="text-xs text-gray-400 mt-1 flex items-center gap-1.5 font-medium">
                <span>Dashboard</span>
                <span>/</span>
                <span>Orders</span>
                <span>/</span>
                <span class="text-gray-700 font-semibold">{{ $po->po_number }}</span>
            </nav>
        </div>
    </div>

    <!-- Enhanced Tracking Timeline -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-8">
        <!-- Status & Title -->
        <div class="shrink-0 space-y-2 text-center md:text-left">
            <div class="flex items-center justify-center md:justify-start gap-3">
                <span class="text-xs font-bold text-gray-500">PO # {{ $po->po_number }}</span>
                <span class="{{ $statusColor }} text-[10px] px-2.5 py-1 rounded-md font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                    {{ $po->status }}
                </span>
            </div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">{{ $po->po_number }}</h2>
        </div>
        
        <!-- Timeline: Extended and Larger Shapes -->
        <div class="flex-1 w-full max-w-xl mx-auto relative px-4">
            <!-- Progress Line Background -->
            <div class="absolute left-6 right-6 top-3.5 h-1 bg-gray-100 rounded-full"></div>
            <!-- Active Progress Line -->
            <div class="absolute left-6 top-3.5 h-1 bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $progressWidth }};"></div>
            
            <!-- Steps Container -->
            <div class="flex justify-between relative z-10 w-full">
                @foreach(['Timeline', 'Add Items', 'Add Documents', 'Review & Send'] as $index => $step)
                    @php
                        $isCompleted = match($statusKey) {
                            'Delivered' => true,
                            'Sent' => true,
                            'Confirmed' => $index <= 2,
                            default => $index === 0,
                        };
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-7 h-7 rounded-full border-2 border-white shadow-xs flex items-center justify-center text-[10px] font-bold transition-all {{ $isCompleted ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if($isCompleted) ✓ @else {{ $index + 1 }} @endif
                        </div>
                        <span class="text-[11px] font-semibold text-gray-500 mt-2.5 whitespace-nowrap">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Main Content -->
        <div class="lg:col-span-9 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Supplier Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div class="bg-gray-50/60 p-3.5 rounded-xl border border-gray-100">
                        <span class="font-semibold text-gray-400 block mb-1">Company Name</span>
                        <span class="font-bold text-gray-800 text-sm">{{ $po->supplier->name ?? 'N/A' }}</span>
                    </div>
                    <div class="bg-gray-50/60 p-3.5 rounded-xl border border-gray-100">
                        <span class="font-semibold text-gray-400 block mb-1">Address</span>
                        <span class="font-bold text-gray-800 text-sm">{{ $po->supplier->address ?? 'N/A' }}</span>
                    </div>
                    <div class="bg-gray-50/60 p-3.5 rounded-xl border border-gray-100">
                        <span class="font-semibold text-gray-400 block mb-1">Contact Info</span>
                        <span class="font-bold text-gray-800 text-sm block">{{ $po->supplier->contact_person ?? 'N/A' }}</span>
                        <span class="text-gray-500 text-[11px]">{{ $po->supplier->phone ?? '' }}{{ $po->supplier->phone && $po->supplier->email ? ' · ' : '' }}{{ $po->supplier->email ?? '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-5">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Itemized Purchase List</h3>
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="py-3.5 px-4">Item</th>
                                <th class="py-3.5 px-4 text-center">Quantity</th>
                                <th class="py-3.5 px-4 text-center">Unit Price</th>
                                <th class="py-3.5 px-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                            @foreach($po->items as $item)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">{{ $item->name }}</td>
                                <td class="py-4 px-4 text-center text-gray-600">{{ $item->qty }}</td>
                                <td class="py-4 px-4 text-center text-gray-600">₱{{ number_format($item->price, 2) }}</td>
                                <td class="py-4 px-4 text-right font-bold text-gray-900">₱{{ number_format($item->qty * $item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end pt-2">
                    <div class="bg-gray-50/80 px-5 py-3 rounded-xl border border-gray-100 text-right">
                        <span class="text-xs text-gray-500 font-semibold mr-3">Grand Total:</span>
                        <span class="text-sm font-extrabold text-gray-900">₱{{ number_format($po->items->sum(fn($i) => $i->qty * $i->price), 2) }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs space-y-2.5">
                @if(strtolower($po->status) === 'sent')
                    <a href="{{ route('orders.print', $po->po_number) }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 px-4 rounded-xl text-xs font-semibold shadow-xs hover:shadow-md transition flex items-center justify-center gap-2 text-center block">Re-print</a>
                @else
                    <form action="{{ route('orders.send', $po->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 px-4 rounded-xl text-xs font-semibold shadow-xs hover:shadow-md transition flex items-center justify-center gap-2 text-center block">Send to Supplier</button>
                    </form>
                @endif
                <a href="{{ route('orders.supplier', $po->po_number) }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 py-2.5 px-4 rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 text-center block">Supplier Preview</a>
                <a href="{{ route('orders.edit', $po->id) }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 py-2.5 px-4 rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 text-center block">Revise</a>
                <form action="{{ route('orders.cancel', $po->id) }}" method="POST" class="pt-1">
                    @csrf
                    <button type="submit" class="w-full bg-white hover:bg-rose-50 text-rose-600 border border-rose-200/80 py-2.5 px-4 rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 text-center cursor-pointer">Cancel Order</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection