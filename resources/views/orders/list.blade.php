@extends('layouts.app')

@section('content')
<section id="po-list-view" class="view-panel space-y-6 max-w-[98%] w-full mx-auto p-4">
    
    <!-- HEADER -->
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Purchase Order List</h1>
            <nav class="text-xs text-gray-400 mt-1">Dashboard &gt; Orders &gt; <span class="text-gray-700 font-semibold">Purchase Order List</span></nav>
        </div>
        
        <div class="relative">
            <button onclick="toggleFilterMenu(event)" class="bg-white border border-gray-200 shadow-sm rounded-xl px-5 py-2.5 text-xs font-bold flex items-center gap-8 text-gray-700 hover:bg-gray-50 transition">
                <span>Filter By: <span id="activeFilterText" class="text-emerald-600">All</span></span>
                <span id="filterArrow" class="text-gray-400 text-[10px] transition-transform duration-200">&gt;</span>
            </button>
            <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-xl shadow-lg py-1.5 z-30 text-xs font-semibold text-gray-700">
                <button onclick="setStatusFilter('All')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">All Statuses <span id="chk-All" class="text-emerald-500">✓</span></button>
                <button onclick="setStatusFilter('Delivered')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">Delivered <span id="chk-Delivered" class="text-emerald-500 hidden">✓</span></button>
                <button onclick="setStatusFilter('Sent')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">Sent <span id="chk-Sent" class="text-emerald-500 hidden">✓</span></button>
                <button onclick="setStatusFilter('Confirmed')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">Confirmed <span id="chk-Confirmed" class="text-emerald-500 hidden">✓</span></button>
                <button onclick="setStatusFilter('Cancelled')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center text-red-600">Cancelled <span id="chk-Cancelled" class="text-red-500 hidden">✓</span></button>
            </div>
        </div>
    </div>

    <!-- METRICS FOR ALL STATUSES -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Orders</p>
            <p id="metric-total" class="text-3xl font-extrabold text-gray-900 mt-2">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Delivered</p>
            <p id="metric-delivered" class="text-3xl font-extrabold text-green-700 mt-2">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Sent</p>
            <p id="metric-sent" class="text-3xl font-extrabold text-blue-700 mt-2">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-xs font-bold text-orange-600 uppercase tracking-wider">Confirmed</p>
            <p id="metric-confirmed" class="text-3xl font-extrabold text-orange-700 mt-2">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-xs font-bold text-red-600 uppercase tracking-wider">Cancelled</p>
            <p id="metric-cancelled" class="text-3xl font-extrabold text-red-700 mt-2">0</p>
        </div>
    </div>

    <!-- TABLE AREA -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-md">
                <input type="text" id="tableRowSearch" oninput="filterTableRows()" placeholder="Search suppliers, products..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
            </div>
            <input type="date" id="tableDateFilter" onchange="filterTableRows()" class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-600 focus:outline-none">
            <select id="tableSupplierFilter" onchange="filterTableRows()" class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-600 focus:outline-none">
                <option value="">All Suppliers</option>
                @foreach(\App\Models\Supplier::all() as $s)
                    <option value="{{ $s->name }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 font-bold">
                        <th class="p-4 rounded-l-lg">PO#</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Supplier</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center rounded-r-lg">Actions</th>
                    </tr>
                </thead>
                <tbody id="poTableBody" class="font-semibold text-gray-700">
                    @forelse($purchaseOrders as $po)
                        @php
                            $total = $po->items->sum(fn($item) => $item->qty * $item->price);
                            $statusColor = match(ucfirst(strtolower($po->status))) {
                                'Delivered' => 'bg-green-100 text-green-700',
                                'Sent' => 'bg-blue-100 text-blue-700',
                                'Confirmed' => 'bg-orange-100 text-orange-700',
                                default => 'bg-red-100 text-red-600',
                            };
                        @endphp
                        <tr data-status="{{ ucfirst(strtolower($po->status)) }}" class="po-table-row bg-gray-50 rounded-lg hover:bg-gray-100 transition shadow-sm">
                            <td class="p-4 rounded-l-lg font-bold text-gray-900 target-po">{{ $po->po_number }}</td>
                            <td class="p-4 target-date">{{ $po->created_at?->format('Y-m-d') }}</td>
                            <td class="p-4 target-supplier">{{ $po->supplier->name ?? 'No Supplier' }}</td>
                            <td class="p-4">₱ {{ number_format($total) }}</td>
                            <td class="p-4"><span class="{{ $statusColor }} text-[11px] px-3 py-1 rounded-full font-bold uppercase">{{ $po->status }}</span></td>
                            <td class="p-4 rounded-r-lg text-center" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-center gap-4 text-base">
                                    <a href="{{ route('orders.details', $po->po_number) }}" class="text-gray-500 hover:text-blue-600"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('orders.edit', $po->id) }}" class="text-gray-500 hover:text-yellow-600"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('orders.destroy', $po->id) }}" method="POST" onsubmit="return confirm('Delete this order?');" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-8 text-center text-gray-400">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <button onclick="window.location.href='{{ route('orders.create') }}'" class="fixed bottom-8 right-8 w-14 h-14 bg-blue-500 text-white rounded-full flex items-center justify-center text-3xl shadow-xl hover:bg-blue-600 transition-transform active:scale-95 z-10">+</button>
</section>

<script>
    function toggleFilterMenu(e) { e.stopPropagation(); const d = document.getElementById('filterDropdown'); const a = document.getElementById('filterArrow'); d.classList.toggle('hidden'); a.classList.toggle('rotate-90'); }
    function setStatusFilter(s) { selectedStatusFilter = s; document.getElementById('activeFilterText').innerText = s; ['All', 'Delivered', 'Sent', 'Confirmed', 'Cancelled'].forEach(i => { document.getElementById(`chk-${i}`)?.classList.toggle('hidden', i !== s); }); filterTableRows(); }
    function filterTableRows() { 
        const s = document.getElementById('tableRowSearch').value.toLowerCase(); 
        const d = document.getElementById('tableDateFilter').value; 
        const sp = document.getElementById('tableSupplierFilter').value; 
        document.querySelectorAll('.po-table-row').forEach(row => { 
            const matchStatus = (selectedStatusFilter === 'All' || row.getAttribute('data-status') === selectedStatusFilter); 
            const matchSearch = (!s || row.querySelector('.target-po').innerText.toLowerCase().includes(s) || row.querySelector('.target-supplier').innerText.toLowerCase().includes(s)); 
            const matchDate = (!d || row.querySelector('.target-date').innerText === d); 
            const matchSupplier = (!sp || row.querySelector('.target-supplier').innerText === sp); 
            row.classList.toggle('hidden', !(matchStatus && matchSearch && matchDate && matchSupplier)); 
        }); 
        updateActiveMetricsCounter(); 
    }
    function updateActiveMetricsCounter() { 
        const r = Object.values(purchaseOrdersState); 
        document.getElementById('metric-total').innerText = r.length;
        document.getElementById('metric-delivered').innerText = r.filter(p => p.status.toLowerCase() === 'delivered').length; 
        document.getElementById('metric-sent').innerText = r.filter(p => p.status.toLowerCase() === 'sent').length; 
        document.getElementById('metric-confirmed').innerText = r.filter(p => p.status.toLowerCase() === 'confirmed').length; 
        document.getElementById('metric-cancelled').innerText = r.filter(p => p.status.toLowerCase() === 'cancelled').length; 
    }
    function viewPoDetails(n) { window.location.href = `/orders/${n}`; }
    const purchaseOrdersState = @json($purchaseOrders->keyBy('po_number'));
    let selectedStatusFilter = 'All';
    document.addEventListener('DOMContentLoaded', updateActiveMetricsCounter);
</script>
@endsection