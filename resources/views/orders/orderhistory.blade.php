@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold text-gray-900">Purchase History</h1>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                {{ $purchases->count() }} Purchases
            </span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-4">
        <div class="space-y-3">
            @forelse($purchases as $item)
            @php
                $total = $item->items->sum(fn($line) => $line->qty * $line->price);
            @endphp
            <div class="border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-gray-50/30 hover:bg-gray-50/80 transition">
                <div class="flex items-center space-x-4">
                    {{-- Dynamic Icon Section --}}
                    @if($item->supplier)
                        <div class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center text-xl {{ $item->supplier->category_icon_color }}">
                            <i class="fa-solid {{ $item->supplier->category_icon }}"></i>
                        </div>
                    @else
                        <div class="w-12 h-12 bg-white rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 text-xl">
                            <i class="fa-solid fa-question"></i>
                        </div>
                    @endif
                    
                    <div>
                        <h4 class="font-bold text-gray-900 text-base leading-snug">
                            PO {{ $item->po_number }}
                        </h4>

                        <p class="text-xs text-gray-500 font-medium mt-0.5">
                            <span class="text-gray-400">Supplier:</span> {{ $item->supplier->name ?? 'Unknown Supplier' }}
                        </p>

                        <p class="text-[11px] text-gray-400 mt-0.5 font-mono">Created: {{ $item->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto space-x-12 text-xs">
                    <div class="text-right">
                        <span class="text-gray-400">Items:</span>
                        <span class="font-semibold text-gray-800">{{ $item->items->count() }}</span>
                    </div>
                    <div class="text-right">
                        <span class="font-extrabold text-gray-900 text-sm block">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 {{ $item->status === 'Sent' ? 'bg-blue-100 text-blue-700' : ($item->status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700') }} font-bold rounded text-[10px] uppercase">{{ $item->status }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-10">No Purchase Orders found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection