@extends('layouts.app')

@section('content')
<section id="create-po-view" class="view-panel w-[95%] mx-auto p-4 space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Create New Purchase Order</h1>
        <p class="text-xs text-gray-400 mt-1">Dashboard &gt; Orders &gt; <span class="text-gray-700 font-semibold">Create</span></p>
    </div>
    
    <!-- Form Container -->
    <form action="{{ route('orders.store') }}" method="POST" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
        @csrf
        
        <!-- Main Form Section: Increased gap for wider layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-6">
                <!-- Supplier Select (Synced from Database) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Supplier</label>
                    <select name="supplier_id" id="supplier_id" required class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">-- Select Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Delivery Address -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Delivery Address</label>
                    <textarea name="delivery_address" rows="5" required class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Line Items -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Line Items</h4>
                    <button type="button" onclick="addItem()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">+ Add New</button>
                </div>
                
                <div id="itemsContainer" class="space-y-4 max-h-87.5 overflow-y-auto pr-2">
                    <!-- Default Row -->
                    <div class="item-row bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3">
                        <input type="text" name="items[0][name]" placeholder="Item Name" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-emerald-500 outline-none">
                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="items[0][qty]" placeholder="Qty" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-emerald-500 outline-none">
                            <input type="number" name="items[0][price]" placeholder="Price" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-emerald-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 border-t pt-6">
            <a href="{{ route('orders.list') }}" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">Cancel</a>
            <button type="submit" class="bg-emerald-600 text-white px-8 py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-700 transition shadow-md shadow-emerald-200">Save Purchase Order</button>
        </div>
    </form>
</section>

<script>
    let i = 1;
    function addItem() {
        const container = document.getElementById('itemsContainer');
        container.insertAdjacentHTML('beforeend', `
            <div class="item-row bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3 mt-4 animate-fadeIn">
                <input type="text" name="items[${i}][name]" placeholder="Item Name" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-emerald-500 outline-none">
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" name="items[${i}][qty]" placeholder="Qty" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-emerald-500 outline-none">
                    <input type="number" name="items[${i}][price]" placeholder="Price" required class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-emerald-500 outline-none">
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