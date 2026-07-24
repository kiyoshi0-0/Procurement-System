@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Supplier[] $suppliers */
@endphp

@extends('layouts.app')

@section('content')
<section class="view-panel space-y-6 w-full px-4 sm:px-6 lg:px-8 pt-0 pb-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Supplier List</h1>
            <nav class="text-xs text-gray-400 mt-1 flex items-center gap-1.5 font-medium">
                <span>Dashboard</span>
                <span>/</span>
                <span>Supplier Management</span>
                <span>/</span>
                <span class="text-gray-700 font-semibold">Supplier List</span>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200/80 text-emerald-700 p-4 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-circle-check text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- METRICS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Suppliers -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Suppliers</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 font-bold text-xs">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-3 tracking-tight">{{ $suppliers->total() }}</p>
        </div>

        <!-- Average Rating -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Avg. Rating</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500 font-bold text-xs">
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <p class="text-3xl font-bold text-gray-900 tracking-tight">
                    {{ number_format($suppliers->avg('rating'), 1) }}
                </p>
                <span class="text-[11px] text-amber-600 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-chart-line"></i> Across {{ $suppliers->total() }}
                </span>
            </div>
        </div>
    </div>

    <!-- TABLE AREA -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-5">
        <div class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <form action="{{ route('suppliers.index') }}" method="GET" class="relative w-full md:max-w-md">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search suppliers..." 
                    class="w-full border border-gray-200 rounded-xl pl-9 pr-12 py-2.5 text-xs bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition"
                >
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
                
                <button type="submit" class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-gray-400 hover:text-emerald-600 transition cursor-pointer">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
            <div class="flex items-center space-x-3 w-full md:w-auto justify-end">
                <a href="{{ route('suppliers.create') }}" class="flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 text-xs font-semibold transition shadow-xs hover:shadow-md">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add New Supplier</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3.5 px-4">Supplier Details</th>
                        <th class="py-3.5 px-4">Category</th>
                        <th class="py-3.5 px-4">Contact Representative</th>
                        <th class="py-3.5 px-4">Payment Terms</th>
                        <th class="py-3.5 px-4">Delivery Cycle</th>
                        <th class="py-3.5 px-4">Rating</th>
                        <th class="py-3.5 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50/60 transition group">
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 shrink-0 {{ $supplier->category_icon_color }}">
                                    <i class="fa-solid {{ $supplier->category_icon }}"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $supplier->name }}</h4>
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $supplier->address }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $supplier->category_color }}">
                                {{ $supplier->category }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-semibold text-gray-900 text-xs">{{ $supplier->contact_person }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $supplier->phone }}</p>
                        </td>
                        <td class="py-4 px-4 text-gray-600 font-semibold">
                            {{ $supplier->payment_terms ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-4 text-gray-600 font-semibold">
                            {{ $supplier->delivery_schedule ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center gap-1.5 bg-amber-50/60 border border-amber-200/60 px-2 py-0.5 rounded-md text-amber-700 font-bold">
                                <i class="fa-solid fa-star text-[10px]"></i>
                                <span>{{ number_format($supplier->rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" title="View Details" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition"><i class="fa-regular fa-eye text-xs"></i></a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" title="Edit Supplier" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-amber-50 hover:text-amber-600 flex items-center justify-center transition"><i class="fa-regular fa-pen-to-square text-xs"></i></a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete Supplier" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition cursor-pointer">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400 font-medium">No active suppliers found in database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION SECTION -->
        @if ($suppliers->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-gray-100 gap-3 text-xs">
                <div class="text-gray-500 font-medium">
                    Showing <span class="font-bold text-gray-800">{{ $suppliers->firstItem() }}</span> to <span class="font-bold text-gray-800">{{ $suppliers->lastItem() }}</span> of <span class="font-bold text-gray-800">{{ $suppliers->total() }}</span> results
                </div>
                <div class="flex items-center gap-1">
                    {{-- Previous Page Link --}}
                    @if ($suppliers->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-gray-50 text-gray-300 cursor-not-allowed border border-gray-100">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </span>
                    @else
                        <a href="{{ $suppliers->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition border border-gray-200 shadow-2xs">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($suppliers->getUrlRange(1, $suppliers->lastPage()) as $page => $url)
                        @if ($page == $suppliers->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-emerald-600 text-white font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition border border-gray-200 font-medium shadow-2xs">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($suppliers->hasMorePages())
                        <a href="{{ $suppliers->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition border border-gray-200 shadow-2xs">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-gray-50 text-gray-300 cursor-not-allowed border border-gray-100">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
@endsection