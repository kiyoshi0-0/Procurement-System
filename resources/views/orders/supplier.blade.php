@extends('layouts.app')

@section('content')
<section id="supplier-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6 space-y-6">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Supplier Print Preview</h1>
            <a href="{{ route('orders.details', $po->id) }}" class="text-gray-400 hover:text-gray-600 text-sm font-semibold">✕ Close Preview</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="lg:col-span-8 border border-gray-300 rounded-xl p-8 space-y-8 bg-white shadow-sm">
                <div class="flex justify-between items-start text-xs">
                    <div class="space-y-1">
                        <h2 class="text-sm font-extrabold text-gray-900">{{ $po->supplier->name ?? 'Supplier' }}</h2>
                        <p class="text-gray-500 leading-relaxed">{{ $po->supplier->address ?? 'No address available' }}</p>
                    </div>
                    <div class="text-right space-y-1">
                        <h2 class="text-2xl font-black text-gray-950">{{ $po->po_number }}</h2>
                        <p class="text-gray-700 font-bold"><span class="text-gray-400 font-normal">Date:</span> {{ \Carbon\Carbon::parse($po->date)->format('M d, Y') }}</p>
                        <p class="text-gray-700 font-bold"><span class="text-gray-400 font-normal">Status:</span> {{ ucfirst($po->status) }}</p>
                    </div>
                </div>

                <hr class="border-gray-200">

                @php
                    $supplierSubtotal = $po->items->sum(fn($item) => $item->qty * $item->price);
                    $supplierTax = 0;
                    $supplierShipping = 0;
                    $supplierTotal = $supplierSubtotal + $supplierTax + $supplierShipping;
                @endphp

                <div class="grid grid-cols-2 gap-8 text-xs">
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px]">Supplier Contact</h3>
                        <p class="text-gray-500">{{ $po->supplier->contact_person ?? 'Contact not set' }}</p>
                        <p class="text-gray-700 font-semibold">Email: <span class="font-normal text-gray-500">{{ $po->supplier->email ?? 'N/A' }}</span></p>
                        <p class="text-gray-700 font-semibold">Phone: <span class="font-normal text-gray-500">{{ $po->supplier->phone ?? 'N/A' }}</span></p>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px]">Supplier Address:</h3>
                        <p class="text-gray-500 leading-relaxed">{{ $po->supplier->address ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-separate border-spacing-y-1.5">
                        <thead class="bg-[#9ae3ca] text-gray-800 font-bold">
                            <tr>
                                <th class="p-2.5 rounded-l-md border border-r-0 border-emerald-300">#</th>
                                <th class="p-2.5 border-y border-emerald-300 text-center">Supplier Item</th>
                                <th class="p-2.5 border-y border-emerald-300 text-center">Quantity</th>
                                <th class="p-2.5 border-y border-emerald-300 text-center">Unit Price</th>
                                <th class="p-2.5 rounded-r-md border border-l-0 border-emerald-300 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 font-semibold">
                            @foreach($po->items as $index => $item)
                                <tr class="bg-white hover:bg-gray-50 rounded-lg border shadow-sm">
                                    <td class="p-2.5 border border-r-0 border-gray-200 rounded-l-lg text-gray-400">{{ $index + 1 }}</td>
                                    <td class="p-2.5 border-y border-gray-200 text-center text-gray-600 font-bold">{{ $item->name }}</td>
                                    <td class="p-2.5 border-y border-gray-200 text-center">{{ $item->qty }}</td>
                                    <td class="p-2.5 border-y border-gray-200 text-center">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="p-2.5 border border-l-0 border-gray-200 rounded-r-lg text-center font-bold">₱{{ number_format($item->qty * $item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start pt-2">
                    <div class="md:col-span-6 space-y-1 text-xs">
                        <h4 class="font-bold text-gray-900">Notes:</h4>
                        <p class="text-gray-500">Thank you for your business!</p>
                    </div>
                    <div class="md:col-span-6 text-xs space-y-2">
                        <div class="flex justify-between text-gray-500"><span>Subtotal</span><span id="supplierViewSubtotal" class="font-bold text-gray-800">₱{{ number_format($supplierSubtotal, 2) }}</span></div>
                        <div class="flex justify-between text-gray-500"><span>Tax</span><span class="font-bold text-gray-800">₱{{ number_format($supplierTax, 2) }}</span></div>
                        <div class="flex justify-between text-gray-500 border-b pb-2"><span>Shipping</span><span class="font-bold text-gray-800">₱{{ number_format($supplierShipping, 2) }}</span></div>
                        <div class="flex justify-between font-black text-sm text-gray-900 pt-1"><span>TOTAL</span><span id="supplierViewTotal">₱{{ number_format($supplierTotal, 2) }}</span></div>
                    </div>
                </div>

                <div class="text-[10px] text-gray-400 pt-4 border-t border-gray-100">
                    This is a system generated document. No signature required.
                </div>
            </div>

            <div class="lg:col-span-4 border border-gray-200 rounded-2xl p-5 bg-white space-y-5">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Recipients</label>
                    <div class="border border-gray-300 rounded-xl p-3 bg-white text-xs space-y-1.5 text-gray-600 font-medium">
                        <div class="flex items-center gap-1"><span class="text-gray-400">email:</span><span>{{ $po->supplier->email ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Subject</label>
                    <input type="text" value="Purchase Order {{ $po->po_number }}" class="w-full bg-white border border-gray-300 shadow-sm rounded-xl px-4 py-2 text-xs text-gray-700 font-semibold focus:outline-none" readonly>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Email Message</label>
                    <div class="w-full bg-white border border-gray-300 shadow-sm rounded-xl p-4 text-xs text-gray-600 space-y-4 leading-relaxed font-medium">
                        <p>Hello,<br>Please find attached Purchase Order <strong>{{ $po->po_number }}</strong>.</p>
                        <p>Thank you,<br>{{ $po->supplier->name ?? 'Supplier' }}</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    <a href="mailto:{{ $po->supplier->email ?? '' }}?subject={{ urlencode('Purchase Order ' . $po->po_number) }}&body={{ urlencode('Hello,%0D%0APlease find attached Purchase Order ' . $po->po_number . '.%0D%0A%0D%0AThank you,%0D%0A' . ($po->supplier->name ?? '')) }}" class="w-full inline-flex justify-center items-center bg-[#00b074] text-white font-semibold py-2.5 px-4 rounded-xl text-xs hover:bg-emerald-600 transition shadow-sm">
                        Send via Email
                    </a>
                    <a href="{{ route('orders.details', $po->id) }}" class="w-full inline-flex justify-center items-center bg-white border border-gray-300 py-2.5 px-4 rounded-xl text-xs hover:bg-gray-50 text-gray-700 font-semibold transition shadow-sm">
                        Back to PO Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
