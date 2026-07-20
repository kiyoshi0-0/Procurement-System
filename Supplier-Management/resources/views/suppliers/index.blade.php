@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Supplier[] $suppliers */
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Supplier List</h1>
        <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Supplier Management</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Supplier List</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Suppliers -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 flex items-start space-x-4 shadow-xs">
            <div class="p-3 bg-emerald-50 text-[#10B981] rounded-lg text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Suppliers</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $suppliers->total() }}</h3>
            </div>
        </div>

        <!-- Average Rating -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 flex items-start space-x-4 shadow-xs">
            <div class="p-3 bg-amber-50 text-amber-500 rounded-lg text-xl">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Avg. Rating</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">
                    {{ number_format($suppliers->avg('rating'), 1) }}
                </h3>
                <span class="text-xs text-amber-500 font-medium flex items-center mt-1">
                    <i class="fa-solid fa-chart-line mr-1"></i> Across {{ $suppliers->total() }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row gap-3 items-center justify-between">
            <!-- Replace the search section in your index.blade.php -->
            <form action="{{ route('suppliers.index') }}" method="GET" class="relative w-full md:max-w-md">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search suppliers..." 
                    class="w-full border border-gray-300 rounded-lg pl-10 pr-12 py-2 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                >
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                
                <!-- Changed to flex items-center justify-center and set explicit height -->
                <button type="submit" class="absolute right-0 top-0 h-full px-3.5 flex items-center justify-center text-gray-400 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </form>
            <div class="flex items-center space-x-3 w-full md:w-auto justify-end">
                <a href="{{ route('suppliers.create') }}" class="flex items-center space-x-2 bg-[#10B981] hover:bg-emerald-600 text-white rounded-lg px-4 py-2 text-sm font-medium transition shadow-xs">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add New Supplier</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-3 px-6">Supplier Details</th>
                        <th class="py-3 px-6">Category</th>
                        <th class="py-3 px-6">Contact Representative</th>
                        <th class="py-3 px-6">Payment Terms</th>
                        <th class="py-3 px-6">Delivery Cycle</th>
                        <th class="py-3 px-6">Rating</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="py-4 px-6 flex items-center space-x-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 {{ $supplier->category_icon_color }}">
                                <i class="fa-solid {{ $supplier->category_icon }}"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $supplier->name }}</h4>
                                <p class="text-xs text-gray-400">{{ $supplier->address }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded text-xs font-medium {{ $supplier->category_color }}">
                                {{ $supplier->category }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-medium text-gray-800 text-xs">{{ $supplier->contact_person }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $supplier->phone }}</p>
                        </td>
                        <td class="py-4 px-6 text-gray-600 text-xs font-medium">
                            {{ $supplier->payment_terms ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-gray-600 text-xs font-medium">
                            {{ $supplier->delivery_schedule ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-xs">
                            <div class="flex items-center text-yellow-400">
                                <i class="fa-solid fa-star"></i>
                                <span class="ml-1.5 font-bold text-gray-700">{{ number_format($supplier->rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-3 text-gray-400">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="hover:text-blue-500 transition"><i class="fa-regular fa-eye"></i></a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="hover:text-amber-500 transition"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="hover:text-red-500 transition focus:outline-none">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">No active suppliers found in database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-white border-t border-gray-200">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection