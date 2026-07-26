@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
            Purchase History
            <span class="text-xs font-bold px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full shadow-2xs">
                {{ $purchases->count() }}
            </span>
        </h1>
        <p class="text-sm text-gray-500 mt-1">Review all synchronized purchase records and order statuses.</p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-4">
        <div class="space-y-3">
            @forelse($purchases as $item)
            <div class="border border-gray-200/80 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white hover:bg-gray-50/60 hover:border-gray-300 transition-all duration-150 shadow-2xs">
                <div class="flex items-center space-x-4">
                    {{-- Dynamic Icon Section --}}
                    @if($item->supplier)
                        <div class="w-12 h-12 rounded-xl border border-gray-200/80 flex items-center justify-center text-xl bg-gray-50/50 shadow-2xs {{ $item->supplier->category_icon_color }}">
                            <i class="fa-solid {{ $item->supplier->category_icon }}"></i>
                        </div>
                    @else
                        <div class="w-12 h-12 bg-gray-50/50 rounded-xl border border-gray-200/80 flex items-center justify-center text-gray-400 text-xl shadow-2xs">
                            <i class="fa-solid fa-question"></i>
                        </div>
                    @endif
                    
                    <div>
                        {{-- 1. PRIMARY: Item Name --}}
                        <h4 class="font-bold text-gray-900 text-base leading-snug">
                            {{ $item->item_name }}
                        </h4>

                        {{-- 2. SECONDARY: Supplier Name --}}
                        <p class="text-xs text-gray-500 font-medium mt-0.5">
                            <span class="text-gray-400">Supplier:</span> <span class="text-gray-700 font-medium">{{ $item->supplier->name ?? 'Unknown Supplier' }}</span>
                        </p>

                        {{-- 3. TERTIARY: PO Number --}}
                        <p class="text-[11px] text-gray-400 mt-0.5 font-mono bg-gray-100/70 inline-block px-1.5 py-0.5 rounded">{{ $item->po_number }}</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto space-x-8 lg:space-x-12 text-xs pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                    <div class="text-left sm:text-right">
                        <span class="text-gray-400 block text-[10px] tracking-wider uppercase font-semibold">QTY</span> 
                        <span class="font-bold text-gray-800 text-sm">{{ $item->quantity }}</span>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-gray-400 block text-[10px] tracking-wider uppercase font-semibold">Total Price</span>
                        <span class="font-extrabold text-gray-900 text-sm block">₱{{ number_format($item->total_price, 2) }}</span>
                    </div>
                    <div class="text-right space-y-1">
                        <span class="block text-gray-400 text-[11px] font-medium">{{ $item->created_at->format('M d, Y') }}</span>
                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-full text-[10px] uppercase border border-emerald-200/60 inline-block tracking-wide">{{ $item->status }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400 space-y-2">
                <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
                <p class="text-sm font-medium text-gray-600">No purchase history records found.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection