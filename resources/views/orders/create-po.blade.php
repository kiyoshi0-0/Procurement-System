@extends('layouts.app')

@section('content')
<section id="create-po-view" class="view-panel max-w-5xl mx-auto p-6 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Create New Purchase Order</h1>
            <p class="text-xs text-gray-500 mt-1 font-medium">Dashboard &gt; Orders &gt; <span class="text-emerald-600 font-semibold">Create</span></p>
        </div>
        <a href="{{ route('orders.list') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>
    
    <!-- Form Container -->
    <form action="{{ route('orders.store') }}" method="POST" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Supplier & Delivery (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-emerald-600"></i> General Information
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Select supplier and destination details.</p>
                </div>

                <!-- Supplier Select -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Supplier <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="supplier_id" id="supplier_id" required class="w-full bg-gray-50/50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                            <option value="">-- Select Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Delivery Address <span class="text-red-500">*</span></label>
                    <textarea name="delivery_address" rows="5" required placeholder="Enter complete delivery destination address..." class="w-full bg-gray-50/50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition resize-none"></textarea>
                </div>
            </div>

            <!-- Right Column: Line Items (7 Cols) -->
            <div class="lg:col-span-7 bg-gray-50/70 border border-gray-200/80 rounded-2xl p-6 space-y-4 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                                <i class="fa-solid fa-boxes-stacked text-emerald-600"></i> Line Items
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">Add products, quantities, and unit pricing.</p>
                        </div>
                        <button type="button" onclick="addItem()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold hover:bg-emerald-100 transition shadow-xs">
                            <i class="fa-solid fa-plus text-[10px]"></i> Add Item
                        </button>
                    </div>
                    
                    <div id="itemsContainer" class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                        <!-- Default Row -->
                        <div class="item-row bg-white p-4 rounded-xl border border-gray-200 shadow-xs space-y-3 relative group">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Item #1</span>
                            </div>
                            <input type="text" name="items[0][name]" placeholder="Item Name / Description" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50/30 focus:bg-white focus:border-emerald-500 outline-none transition">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Quantity</label>
                                    <input type="number" name="items[0][qty]" placeholder="0" min="1" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50/30 focus:bg-white focus:border-emerald-500 outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Unit Price (₱)</label>
                                    <input type="number" step="0.01" name="items[0][price]" placeholder="0.00" min="0" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50/30 focus:bg-white focus:border-emerald-500 outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-6">
            <a href="{{ route('orders.list') }}" class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">Cancel</a>
            <button type="submit" class="bg-emerald-600 text-white px-8 py-3 rounded-xl text-sm font-semibold hover:bg-emerald-700 transition shadow-md shadow-emerald-200 flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Save Purchase Order
            </button>
        </div>
    </form>
</section>

<script>
    let i = 1;
    function addItem() {
        const container = document.getElementById('itemsContainer');
        const itemNumber = container.children.length + 1;
        container.insertAdjacentHTML('beforeend', `
            <div class="item-row bg-white p-4 rounded-xl border border-gray-200 shadow-xs space-y-3 relative group animate-fadeIn">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Item #${itemNumber}</span>
                    <button type="button" onclick="this.closest('.item-row').remove()" class="text-gray-400 hover:text-red-600 text-xs font-bold transition"><i class="fa-solid fa-trash-can"></i></button>
                </div>
                <input type="text" name="items[${i}][name]" placeholder="Item Name / Description" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50/30 focus:bg-white focus:border-emerald-500 outline-none transition">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Quantity</label>
                        <input type="number" name="items[${i}][qty]" placeholder="0" min="1" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50/30 focus:bg-white focus:border-emerald-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Unit Price (₱)</label>
                        <input type="number" step="0.01" name="items[${i}][price]" placeholder="0.00" min="0" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50/30 focus:bg-white focus:border-emerald-500 outline-none transition">
                    </div>
                </div>
            </div>
        `);
        i++;
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>
@endsection