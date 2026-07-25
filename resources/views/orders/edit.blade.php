@extends('layouts.app')

@section('content')
<section id="edit-po-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto p-6">
    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Purchase Order: {{ $po->po_number }}</h1>
        <nav class="text-xs text-gray-400 mt-1">Dashboard &gt; Orders &gt; Edit &gt; <span class="text-gray-700 font-semibold">{{ $po->po_number }}</span></nav>
    </div>

    <!-- Edit Form Container -->
    <form action="{{ route('orders.update', $po->id) }}" method="POST" class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="po_number" value="{{ $po->po_number }}">
        <input type="hidden" name="date" value="{{ $po->date }}">
        <input type="hidden" name="status" value="{{ $po->status }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Left Side: Supplier -->
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700">Supplier</label>
                    <select name="supplier_id" class="w-full mt-2 p-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Select supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $po->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Right Side: Line Items Container -->
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <h3 class="text-xs font-bold text-gray-900 mb-4">LINE ITEMS CONTAINER</h3>
                <div class="space-y-4">
                    @foreach($po->items as $index => $item)
                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase">Item Name</label>
                        <input type="text" name="items[{{ $index }}][name]" value="{{ $item->name }}" class="w-full p-2 border border-gray-300 rounded-lg text-sm bg-white">
                        
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Qty</label>
                                <input type="number" name="items[{{ $index }}][qty]" value="{{ $item->qty }}" class="w-full p-2 border border-gray-300 rounded-lg text-sm bg-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Price</label>
                                <input type="number" name="items[{{ $index }}][price]" value="{{ $item->price }}" class="w-full p-2 border border-gray-300 rounded-lg text-sm bg-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Amount</label>
                                <input type="text" value="₱{{ number_format($item->qty * $item->price, 2) }}" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-gray-100 font-bold" disabled>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-4 border-t border-gray-100">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Update PO</button>
            <a href="{{ route('orders.details', $po->po_number) }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition">Cancel</a>
        </div>
    </form>
</section>
@endsection