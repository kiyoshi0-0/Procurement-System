@extends('layouts.app')

@section('content')
<section id="po-list-view" class="view-panel space-y-6 max-w-[98%] w-full mx-auto p-4 md:p-6">
    
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Purchase Order List</h1>
            <nav class="text-xs text-gray-400 mt-1 flex items-center gap-1.5 font-medium">
                <span>Dashboard</span> 
                <span>/</span> 
                <span>Orders</span> 
                <span>/</span> 
                <span class="text-gray-700 font-semibold">Purchase Order List</span>
            </nav>
        </div>
        
        <div class="relative">
            <button onclick="toggleFilterMenu(event)" class="bg-white border border-gray-200/80 shadow-xs rounded-xl px-4 py-2.5 text-xs font-semibold flex items-center gap-6 text-gray-700 hover:bg-gray-50 transition cursor-pointer">
                <span>Filter By: <span id="activeFilterText" class="text-emerald-600 font-bold">All</span></span>
                <span id="filterArrow" class="text-gray-400 text-[10px] transition-transform duration-200">&#9656;</span>
            </button>
            <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-xl py-1.5 z-30 text-xs font-medium text-gray-700 divide-y divide-gray-50">
                <div class="py-1">
                    <button onclick="setStatusFilter('All')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center transition cursor-pointer">All Statuses <span id="chk-All" class="text-emerald-600 font-bold">✓</span></button>
                </div>
                <div class="py-1">
                    <button onclick="setStatusFilter('Delivered')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center transition cursor-pointer">Delivered <span id="chk-Delivered" class="text-emerald-600 font-bold hidden">✓</span></button>
                    <button onclick="setStatusFilter('Sent')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center transition cursor-pointer">Sent <span id="chk-Sent" class="text-emerald-600 font-bold hidden">✓</span></button>
                    <button onclick="setStatusFilter('Confirmed')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center transition cursor-pointer">Confirmed <span id="chk-Confirmed" class="text-emerald-600 font-bold hidden">✓</span></button>
                </div>
                <div class="py-1">
                    <button onclick="setStatusFilter('Cancelled')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center text-red-600 font-medium transition cursor-pointer">Cancelled <span id="chk-Cancelled" class="text-red-500 font-bold hidden">✓</span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- METRICS FOR ALL STATUSES -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Orders</p>
                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 font-bold text-xs">📦</div>
            </div>
            <p id="metric-total" class="text-3xl font-bold text-gray-900 mt-3 tracking-tight">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Delivered</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 font-bold text-xs">✓</div>
            </div>
            <p id="metric-delivered" class="text-3xl font-bold text-emerald-600 mt-3 tracking-tight">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Sent</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs">↗</div>
            </div>
            <p id="metric-sent" class="text-3xl font-bold text-blue-600 mt-3 tracking-tight">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Confirmed</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 font-bold text-xs">⏳</div>
            </div>
            <p id="metric-confirmed" class="text-3xl font-bold text-amber-600 mt-3 tracking-tight">0</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">Cancelled</p>
                <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600 font-bold text-xs">✕</div>
            </div>
            <p id="metric-cancelled" class="text-3xl font-bold text-rose-600 mt-3 tracking-tight">0</p>
        </div>
    </div>

    <!-- TABLE AREA -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-5">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[240px] max-w-md">
                <input type="text" id="tableRowSearch" oninput="filterTableRows()" placeholder="Search suppliers, products..." class="w-full pl-9 pr-4 py-2.5 text-xs border border-gray-200 rounded-xl bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                <span class="absolute left-3 top-3 text-gray-400 text-xs">🔍</span>
            </div>
            <input type="date" id="tableDateFilter" onchange="filterTableRows()" class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
            <select id="tableSupplierFilter" onchange="filterTableRows()" class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                <option value="">All Suppliers</option>
                @foreach(\App\Models\Supplier::all() as $s)
                    <option value="{{ $s->name }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3.5 px-4">PO#</th>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4">Supplier</th>
                        <th class="py-3.5 px-4">Total</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="poTableBody" class="divide-y divide-gray-100 text-gray-700 font-medium">
                    @forelse($purchaseOrders as $po)
                        @php
                            $total = $po->items->sum(fn($item) => $item->qty * $item->price);
                            $statusKey = ucfirst(strtolower($po->status));
                            
                            $statusColor = match($statusKey) {
                                'Delivered' => 'bg-emerald-50 text-emerald-700',
                                'Sent' => 'bg-blue-50 text-blue-700',
                                'Confirmed' => 'bg-amber-50 text-amber-700',
                                default => 'bg-rose-50 text-rose-700',
                            };

                            $dotColor = match($statusKey) {
                                'Delivered' => 'bg-emerald-500',
                                'Sent' => 'bg-blue-500',
                                'Confirmed' => 'bg-amber-500',
                                default => 'bg-rose-500',
                            };
                        @endphp
                        <tr data-status="{{ $statusKey }}" class="po-table-row hover:bg-gray-50/60 transition group">
                            <td class="py-4 px-4 font-bold text-gray-900 target-po">{{ $po->po_number }}</td>
                            <td class="py-4 px-4 text-gray-500 target-date">{{ $po->created_at?->format('Y-m-d') }}</td>
                            <td class="py-4 px-4 target-supplier">
                                <div class="flex items-center space-x-3">
                                    @if($po->supplier)
                                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 {{ $po->supplier->category_icon_color ?? 'text-gray-500' }}">
                                            <i class="fa-solid {{ $po->supplier->category_icon ?? 'fa-building' }}"></i>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-gray-400">
                                            <i class="fa-solid fa-building"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-semibold text-gray-800 block">{{ $po->supplier->name ?? 'No Supplier' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-semibold text-gray-900">₱ {{ number_format($total, 2) }}</td>
                            <td class="py-4 px-4">
                                <span class="{{ $statusColor }} text-[11px] px-3 py-1 rounded-full font-bold uppercase tracking-wider inline-flex items-center gap-1.5 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $po->status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-center gap-3 text-sm">
                                    <a href="{{ route('orders.details', $po->po_number) }}" title="View Details" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition"><i class="fa fa-eye text-xs"></i></a>
                                    <a href="{{ route('orders.edit', $po->id) }}" title="Edit Order" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-amber-50 hover:text-amber-600 flex items-center justify-center transition"><i class="fa fa-edit text-xs"></i></a>
                                    <form action="{{ route('orders.destroy', $po->id) }}" method="POST" onsubmit="return confirm('Delete this order?');" class="m-0 inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Delete Order" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition cursor-pointer"><i class="fa fa-trash text-xs"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-12 text-center text-gray-400 font-medium">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <button onclick="window.location.href='{{ route('orders.create') }}'" class="fixed bottom-8 right-8 w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl shadow-xl hover:bg-blue-700 hover:scale-105 transition-all active:scale-95 z-10 cursor-pointer">&#43;</button>
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
            const matchSupplier = (!sp || row.querySelector('.target-supplier').innerText.includes(sp)); 
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