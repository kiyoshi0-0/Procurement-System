@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Title Breadcrumb Area Header row -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Search & Filters</h1>
        <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Supplier Management</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Search & Filters</span>
        </div>
    </div>

    <!-- Main Core Master Workspace container block element layout -->
    <div class="space-y-4">
        <!-- Input row with cross close clear button feature tag -->
        <!-- Wrap in a form or ensure the search input is part of the existing one -->
        <form action="{{ route('suppliers.search') }}" method="GET" class="bg-white p-4 border border-gray-200 rounded-xl shadow-xs">
            <div class="relative w-full">
                <!-- Added name="search" and value attribute to persist query -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search supplier..." class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>
            </div>
        </form>

        <!-- Advanced Filters Box Dropdown Card Block Panel layout -->
        <!-- Wrap your entire filter section in a form -->
        <!-- Advanced Filters Form -->
        <form action="{{ route('suppliers.search') }}" method="GET">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
                <div class="p-5 space-y-4">
                    <!-- The Grid (3 columns for dropdowns) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Category</label>
                            <select name="category" class="w-full border border-gray-300 rounded-lg p-2 bg-white text-xs text-gray-700">
                                <option value="">All Categories</option>
                                @foreach(['Components', 'Graphics', 'Power Supply', 'Storage', 'Cooling'] as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum Rating</label>
                            <select name="min_rating" class="w-full border border-gray-300 rounded-lg p-2 bg-white text-xs text-gray-700">
                                <option value="">Any</option>
                                <option value="4" {{ request('min_rating') == 4 ? 'selected' : '' }}>4 Stars & Up</option>
                                <option value="3" {{ request('min_rating') == 3 ? 'selected' : '' }}>3 Stars & Up</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Delivery Time</label>
                            <select name="delivery_time" class="w-full border border-gray-300 rounded-lg p-2 bg-white text-xs text-gray-700">
                                <option value="">Any</option>
                                @foreach(['1-2 Days', '3-5 Days', '1 Week+'] as $time)
                                    <option value="{{ $time }}" {{ request('delivery_time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Button Container (Separate from the grid to align right) -->
                    <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('suppliers.search') }}" class="px-6 py-2 border border-gray-300 text-gray-600 rounded-lg text-xs font-semibold hover:bg-gray-50">Clear</a>
                        <button type="submit" class="px-6 py-2 bg-[#10B981] text-white rounded-lg text-xs font-semibold hover:bg-emerald-600">Apply Filters</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table Data Search Results Card container block layout structure component -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
            <!-- Locate this section and update the header -->
            <div class="p-4 border-b border-gray-100 font-bold text-sm text-gray-800 bg-gray-50/20">
                Search Results ({{ $supplierCount }})
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-200 font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3 px-6">Suppliers</th>
                            <th class="py-3 px-6">Rating</th>
                            <th class="py-3 px-6">Delivery Time</th>
                            <th class="py-3 px-6">Price Level</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <!-- ... (Keep your table header <thead> as is) ... -->
                    <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                        @forelse($suppliers as $supplier)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3 px-6 flex items-center space-x-3">
                                {{-- Dynamic Icon --}}
                                <div class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center text-sm {{ $supplier->category_icon_color }}">
                                    <i class="fa-solid {{ $supplier->category_icon }}"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-gray-800 text-sm">{{ $supplier->name }}</h5>
                                    <p class="text-[10px] text-gray-400 font-normal mt-0.5">{{ $supplier->category }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex items-center space-x-1">
                                    <i class="fa-solid fa-star text-yellow-400"></i> 
                                    <span class="font-bold text-gray-800">{{ $supplier->rating }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-gray-500">{{ $supplier->delivery_schedule }}</td>
                            <td class="py-3 px-6 font-bold text-gray-800">{{ $supplier->payment_terms }}</td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="px-4 py-1.5 border border-emerald-600 text-emerald-600 rounded-md font-semibold hover:bg-emerald-50 text-[11px]">View Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-500">No suppliers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card Result Table Footer Pagination element component link block structure -->
            <div class="p-4 bg-white border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0 text-xs text-gray-400 font-medium">
                <div>Showing 1 to 3 of 128 results</div>
                <div class="flex items-center space-x-1">
                    <button class="p-2 border border-gray-200 rounded hover:bg-gray-50 text-gray-400"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                    <button class="px-3 py-1 bg-[#10B981] text-white font-semibold rounded">1</button>
                    <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50">3</button>
                    <span class="px-1 text-gray-300">...</span>
                    <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50">26</button>
                    <button class="p-2 border border-gray-200 rounded hover:bg-gray-50 text-gray-400"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection