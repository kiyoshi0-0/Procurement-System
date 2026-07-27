@extends('layouts.app')

@section('content')

<!-- ========================================================================= -->
<!-- 1. CREATE / EDIT PO VIEW                                                  -->
<!-- ========================================================================= -->
<section id="create-po-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto hidden">
    <div>
        <h1 id="createPoTitle" class="text-2xl font-bold text-gray-900">Create / Edit PO</h1>
        <nav class="text-xs text-gray-400 mt-1">Dashboard &gt; Orders &gt; <span id="createPoBreadcrumb" class="text-gray-700 font-semibold">Create/Edit PO</span></nav>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-8">
       
        
        <div class="bg-[#f0f1f3] rounded-2xl border border-gray-300 p-6 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <label class="text-sm font-bold text-gray-800 min-w-20">Supplier</label>
                <select id="wizardSupplierSelect" class="flex-1 bg-white border border-gray-300 rounded-full px-4 py-2 text-sm text-gray-700 focus:outline-none">
                    <option value="TicTac PC">Supplier No. 1 (TicTac PC)</option>
                    <option value="MasterPc">Supplier No. 2 (MasterPc)</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-7 space-y-4 text-xs font-bold text-gray-700">
                    <div>
                        <label class="block mb-1">Delivery Address</label>
                        <select id="wizardDeliveryAddress" class="w-full bg-white border rounded-md px-3 py-2 font-medium text-gray-600">
                            <option value="4120: Maglabe drive, purok 26, Gulnhawa South">4120: Maglabe drive, purok 26, Gulnhawa South</option>
                            <option value="Building 4, Industrial Zone, Calamba, Laguna">Building 4, Industrial Zone, Calamba, Laguna</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1">PO Template</label>
                        <select class="w-full bg-white border rounded-md px-3 py-2 font-medium text-gray-600"><option>Standard Template Corporate Layout</option></select>
                    </div>
                    <div>
                        <label class="block mb-1">Automated PO Numbering</label>
                        <select class="w-full bg-white border rounded-md px-3 py-2 font-medium text-gray-600"><option>Automated numbering rule alpha-numeric</option></select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block mb-1">PO numbering rule</label><select class="w-full bg-white border rounded-md px-3 py-2 font-medium text-gray-600"><option>PO - 2026</option></select></div>
                        <div><label class="block mb-1">PO Number</label><input type="text" id="wizardPoNumberInput" readonly class="w-full bg-gray-100 border rounded-md px-3 py-2 font-bold text-gray-600" value="PO-104"></div>
                    </div>
                </div>

                <div class="md:col-span-5 bg-gray-55 border border-gray-200 rounded-xl p-4 space-y-3">
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Line Items Container</h4>
                    <div id="wizardLineItemsList" class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        <div class="bg-white p-3 rounded-lg border border-gray-200 text-xs space-y-2 relative item-entry-row">
                            <div><label class="text-[10px] text-blue-500 font-bold block mb-0.5">Item Name</label><input type="text" value="Enterprise Computer Set" class="w-full border rounded px-2 py-0.5 font-semibold item-name-field"></div>
                            <div class="grid grid-cols-3 gap-2">
                                <div><label class="text-[10px] text-blue-500 font-bold block">Qty</label><input type="number" value="1" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-qty"></div>
                                <div><label class="text-[10px] text-blue-500 font-bold block">Price</label><input type="number" value="50000" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-price"></div>
                                <div><label class="text-[10px] text-gray-400 font-bold block">Amount</label><input type="text" value="₱50,000" readonly class="w-full bg-gray-50 border rounded px-2 py-0.5 text-gray-500 font-bold item-total-box"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between border-t pt-4">
            <button onclick="addWizardRowItem()" class="text-xs font-bold text-blue-600 hover:underline">+ Add Items</button>
            <div class="flex gap-2">
                <button onclick="switchView('po-list-view')" class="border border-gray-400 px-6 py-2 rounded-lg text-xs font-semibold hover:bg-gray-55">Cancel</button>
                <button onclick="saveNewPurchaseOrder()" class="bg-[#00b074] text-white px-8 py-2 rounded-lg text-xs font-semibold hover:bg-emerald-600 transition shadow">Save</button>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 2. PURCHASE ORDER DETAILS VIEW                                            -->
<!-- ========================================================================= -->
<section id="po-details-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto hidden">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Purchase Order Details</h1>
        <nav class="text-xs text-gray-400 mt-1">Dashboard &gt; Orders &gt; <span class="text-gray-700 font-semibold">Purchase Order Details</span></nav>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-gray-800">PO # <span id="detailsPoNumberLabel">PO-101</span></span>
                <span id="detailsStatusBadge" class="bg-green-100 text-green-500 text-[10px] px-2.5 py-0.5 rounded-full font-bold">Delivered</span>
            </div>
            <h2 id="detailsPoHeader" class="text-xl font-black text-gray-900">PO-101</h2>
        </div>
        <div class="flex-1 max-w-2xl w-full relative px-4">
            <div class="absolute left-4 right-4 top-2 h-0.5 bg-gray-200"></div>
            <div class="absolute left-4 w-1/4 top-2 h-0.5 bg-emerald-500"></div>
            <div class="flex justify-between text-[10px] font-bold text-gray-400 relative z-10">
                <div class="text-center space-y-2"><div class="w-4 h-4 bg-emerald-500 rounded-full mx-auto border-4 border-white shadow-sm"></div><span>timeline</span></div>
                <div class="text-center space-y-2"><div class="w-4 h-4 bg-gray-300 rounded-full mx-auto border-4 border-white shadow-sm"></div><span>Add Items</span></div>
                <div class="text-center space-y-2"><div class="w-4 h-4 bg-gray-300 rounded-full mx-auto border-4 border-white shadow-sm"></div><span>Add Documents</span></div>
                <div class="text-center space-y-2"><div class="w-4 h-4 bg-gray-300 rounded-full mx-auto border-4 border-white shadow-sm"></div><span>Review & Send</span></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-9 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-2 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-900">Supplier Information</h3>
                    <div class="text-xs text-gray-600 space-y-1 pt-1">
                        <p class="font-semibold text-gray-800">Company Name: <span id="detailsSupplierCompany" class="font-normal text-gray-500">TicTac PC</span></p>
                        <p class="font-semibold text-gray-800">Contact Person: <span id="detailsSupplierContact" class="font-normal text-gray-500">Dabby</span></p>
                        <p class="font-semibold text-gray-800">Email: <span id="detailsSupplierEmail" class="font-normal text-gray-500">a******e@yahoo.com</span></p>
                        <p class="font-semibold text-gray-800">Phone: <span id="detailsSupplierPhone" class="font-normal text-gray-500">09553051025</span></p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-1 shadow-sm text-xs text-gray-500 leading-relaxed">
                    <h3 class="text-sm font-bold text-gray-900 mb-2">Registered Branch Address</h3>
                    <div id="detailsSupplierAddress">
                        <p>BLK 51 Lot 12A</p><p>Barangay San Andres 1</p><p>Dasmariñas, Cavite</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-gray-900">Itemized Purchase List</h3>
                <table class="w-full text-left text-xs border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 font-bold">
                            <th class="p-3 rounded-l-xl">Image</th><th class="p-3">Item</th><th class="p-3 text-center">Quantity</th><th class="p-3 text-center">Unit Price</th><th class="p-3 text-center rounded-r-xl">Total</th>
                        </tr>
                    </thead>
                    <tbody id="detailsItemizedList" class="font-semibold text-gray-700">
                        <!-- Dynamic content -->
                    </tbody>
                </table>
                <div id="detailsGrandTotalLabel" class="text-right text-xs font-extrabold text-gray-900 pt-2 border-t border-dashed">
                    Total: ₱150,000
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-3">
                    <div class="flex justify-between items-center"><h4 class="text-xs font-bold text-gray-900">Match Invoice</h4><span class="bg-green-100 text-green-500 text-[9px] font-bold px-2 py-0.5 rounded">Status</span></div>
                    <div class="flex items-center gap-2 text-xs font-bold text-gray-700">
                        <span class="text-green-500">✓</span> Match PO's as delivered
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-3">
                    <div class="flex justify-between items-center"><h4 class="text-xs font-bold text-gray-900">Match Delivery Receipt</h4><span class="bg-green-100 text-green-500 text-[9px] font-bold px-2 py-0.5 rounded">Status</span></div>
                    <div class="space-y-2 text-xs font-bold text-gray-700">
                        <div class="flex items-center gap-2"><span class="text-green-500">✓</span> Match Invoice</div>
                        <div class="flex items-center gap-2"><span class="text-green-500">✓</span> Match Delivery Receipt</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-2 text-xs font-bold text-center">
                <button id="sendToSupplierBtn" class="w-full bg-[#82ecbe] text-gray-800 py-2.5 rounded-xl transition hover:opacity-90">Send to Supplier</button>
                <button onclick="window.print()" class="w-full bg-white border text-gray-700 py-2.5 rounded-xl hover:bg-gray-55 transition shadow-sm">Re-print</button>
                <button id="revisePoBtn" class="w-full bg-white border text-gray-700 py-2.5 rounded-xl hover:bg-gray-55 transition shadow-sm">Revise</button>
                <button id="cancelPoBtn" class="w-full bg-white border border-red-200 text-red-500 py-2.5 rounded-xl hover:bg-red-50 transition">Cancel</button>
                <button onclick="switchView('po-list-view')" class="w-full bg-gray-100 border text-gray-600 py-2.5 rounded-xl hover:bg-gray-200 transition">Back to List</button>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-4">
                <h4 class="text-[11px] font-extrabold text-gray-900">Attached Documents</h4>
                <div class="grid grid-cols-2 gap-3 text-[9px] font-bold text-center text-gray-400">
                    <div class="border rounded-xl p-3 bg-gray-50 space-y-2 flex flex-col items-center justify-center">
                        <span class="text-red-500 text-xl font-black">📄</span><p class="text-gray-700">PDF routine</p>
                    </div>
                    <div class="border rounded-xl p-3 bg-gray-50 space-y-2 flex flex-col items-center justify-center">
                        <span class="text-emerald-500 text-xl">🖼️</span><p class="text-gray-700">image receipt</p>
                    </div>
                </div>
                <button onclick="alert('Upload file dialogue triggered')" class="w-full border-2 border-dashed rounded-xl p-4 flex flex-col items-center justify-center gap-1 text-[9px] font-bold text-gray-400 hover:bg-gray-55 transition">
                    <span class="text-lg text-gray-800 font-light">+</span><span>image receipt</span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 3. PURCHASE ORDER LIST VIEW                                               -->
<!-- ========================================================================= -->
<section id="po-list-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto">
    <div class="flex justify-between items-start relative">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Purchase Order List</h1>
            <nav class="text-xs text-gray-400 mt-1">Dashboard &gt; Orders &gt; <span class="text-gray-700 font-semibold">Purchase Order List</span></nav>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="relative">
                <button onclick="toggleFilterMenu(event)" class="bg-white border border-gray-200 shadow-sm rounded-xl px-5 py-2 text-xs font-bold flex items-center gap-8 text-gray-700 hover:bg-gray-55 transition">
                    <span>Filter By: <span id="activeFilterText" class="text-emerald-600">All</span></span>
                    <span id="filterArrow" class="text-gray-400 text-[10px] transition-transform duration-200">&gt;</span>
                </button>
                <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-xl shadow-lg py-1.5 z-30 text-xs font-semibold text-gray-700">
                    <button onclick="setStatusFilter('All')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">All Statuses <span id="chk-All" class="text-emerald-500">✓</span></button>
                    <button onclick="setStatusFilter('Delivered')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">Delivered <span id="chk-Delivered" class="text-emerald-500 hidden">✓</span></button>
                    <button onclick="setStatusFilter('Sent')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">Sent <span id="chk-Sent" class="text-emerald-500 hidden">✓</span></button>
                    <button onclick="setStatusFilter('Confirmed')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center">Confirmed <span id="chk-Confirmed" class="text-emerald-500 hidden">✓</span></button>
                    <!-- INILAGAY NA ANG "CANCELLED" SA BABA NG DROPDOWN -->
                    <button onclick="setStatusFilter('Cancelled')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex justify-between items-center text-red-600">Cancelled <span id="chk-Cancelled" class="text-red-500 hidden">✓</span></button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm"><p class="text-xs font-bold text-gray-700">Total Active PO's</p><p id="metric-active" class="text-4xl font-extrabold text-gray-900 mt-2">0</p></div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm"><p class="text-xs font-bold text-gray-700">Pending Sent</p><p id="metric-sent" class="text-4xl font-extrabold text-gray-900 mt-2">0</p></div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm"><p class="text-xs font-bold text-gray-700">Requires Revision</p><p id="metric-revision" class="text-4xl font-extrabold text-gray-900 mt-2">0</p></div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-md">
                <input type="text" id="tableRowSearch" oninput="filterTableRows()" placeholder="Search suppliers, products..." class="w-full pl-8 pr-4 py-1.5 text-xs border border-gray-300 rounded-md bg-gray-55 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                <span class="absolute left-2.5 top-2.5 text-gray-400 text-xs">🔍</span>
            </div>
            <input type="date" id="tableDateFilter" onchange="filterTableRows()" class="bg-white border rounded-md px-3 py-1 text-xs text-gray-600 focus:outline-none">
            <select id="tableSupplierFilter" onchange="filterTableRows()" class="bg-white border rounded-md px-3 py-1 text-xs text-gray-600 focus:outline-none">
                <option value="">All Suppliers</option>
                <option value="TicTac PC">TicTac PC</option>
                <option value="MasterPc">MasterPc</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 font-bold">
                        <th class="p-3 rounded-l-lg">PO#</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Supplier</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center rounded-r-lg">Actions</th>
                    </tr>
                </thead>
                <tbody id="poTableBody" class="font-semibold text-gray-700">
                    @forelse($purchaseOrders as $po)
                        @php
                            $total = $po->items->sum(function($item) {
                                return $item->qty * $item->price;
                            });

                            $statusColor = 'bg-red-100 text-red-600';
                            if ($po->status === 'Delivered') {
                                $statusColor = 'bg-green-100 text-green-700';
                            } elseif ($po->status === 'Sent') {
                                $statusColor = 'bg-blue-100 text-blue-700';
                            } elseif ($po->status === 'Confirmed') {
                                $statusColor = 'bg-orange-100 text-orange-700';
                            }
                        @endphp
                        
                        <tr data-status="{{ $po->status }}" class="po-table-row bg-gray-50 rounded-lg hover:bg-gray-100 transition shadow-sm cursor-pointer" onclick="viewPoDetails('{{ $po->po_number }}')">
                            <td class="p-3 rounded-l-lg text-blue-600 hover:underline target-po">{{ $po->po_number }}</td>
                            <td class="p-3 target-date">{{ $po->created_at ? $po->created_at->format('Y-m-d') : '' }}</td>
                            <td class="p-3 target-supplier">{{ $po->supplier }}</td>
                            <td class="p-3">₱ {{ number_format($total) }}</td>
                            <td class="p-3"><span class="{{ $statusColor }} text-[10px] px-2 py-0.5 rounded font-bold">{{ $po->status }}</span></td>
                            <td class="p-3 rounded-r-lg text-center space-x-3 text-gray-400" onclick="event.stopPropagation()">
                                <button onclick="viewPoDetails('{{ $po->po_number }}')" class="hover:text-gray-900" title="View details">👁️</button>
                                <button onclick="editPurchaseOrder('{{ $po->po_number }}')" class="hover:text-blue-600" title="Edit row">📝</button>
                                <button onclick="deleteTableRow(this, {{ $po->id }})" class="hover:text-red-500" title="Delete row">🗑️</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                No purchase orders found in history. Click the "+" button to create one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <button onclick="openCreatePoView()" class="fixed bottom-8 right-8 w-14 h-14 bg-blue-500 text-white rounded-full flex items-center justify-center text-3xl shadow-xl hover:bg-blue-600 transition-transform active:scale-95 z-10">+</button>
</section>

<!-- ========================================================================= -->
<!-- 4. SUPPLIER PRINT VIEW PREVIEW                                            -->
<!-- ========================================================================= -->
<section id="supplier-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto hidden">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6 space-y-6">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Live print-view preview</h1>
            <button id="backToPoDetailsFromSupplierBtn" class="text-gray-400 hover:text-gray-600 text-sm font-semibold">✕ Close Preview</button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="lg:col-span-8 border border-gray-300 rounded-xl p-8 space-y-8 bg-white shadow-sm">
                <div class="flex justify-between items-start text-xs">
                    <div class="space-y-1">
                        <h2 class="text-sm font-extrabold text-gray-900">ABC Company</h2>
                        <p class="text-gray-500 leading-relaxed">Blk 51 Lot 12A,<br>Barangay. San Andres 1,<br>Dasmariñas, Cavite</p>
                    </div>
                    <div class="text-right space-y-1">
                        <h2 id="supplierViewPoNum" class="text-2xl font-black text-gray-950">PO - 101</h2>
                        <p class="text-gray-700 font-bold"><span class="text-gray-400 font-normal">Date:</span> <span id="supplierViewDate">June 28, 2026</span></p>
                        <p class="text-gray-700 font-bold"><span class="text-gray-400 font-normal">Reference:</span> <span id="supplierViewRef">PO - 101</span></p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div class="grid grid-cols-2 gap-8 text-xs">
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px]">Supplier:</h3>
                        <p id="supplierViewCompName" class="text-gray-500">(Company NAME)</p>
                        <p class="text-gray-500">Contract: Active Agreement</p>
                        <p class="text-gray-700 font-semibold">Email: <span id="supplierViewEmail" class="font-normal text-gray-500">su*****23@yahoo.com</span></p>
                        <p class="text-gray-700 font-semibold">Phone: <span id="supplierViewPhone" class="font-normal text-gray-500">09224238767</span></p>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px]">Delivery Address:</h3>
                        <p id="supplierViewDeliveryAddress" class="text-gray-500 leading-relaxed">Blk 51 Lot 12A,<br>Barangay. San Andres 1,<br>Dasmariñas, Cavite</p>
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
                        <tbody id="supplierViewItemTable" class="text-gray-700 font-semibold">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start pt-2">
                    <div class="md:col-span-6 space-y-1 text-xs">
                        <h4 class="font-bold text-gray-900">Notes:</h4>
                        <p class="text-gray-500">Thank you for your business!</p>
                    </div>
                    <div class="md:col-span-6 text-xs space-y-2">
                        <div class="flex justify-between text-gray-500"><span>Subtotal</span><span id="supplierViewSubtotal" class="font-bold text-gray-800">₱150,000</span></div>
                        <div class="flex justify-between text-gray-500"><span>Tax</span><span class="font-bold text-gray-800">₱0</span></div>
                        <div class="flex justify-between text-gray-500 border-b pb-2"><span>Shipping</span><span class="font-bold text-gray-800">₱0</span></div>
                        <div class="flex justify-between font-black text-sm text-gray-900 pt-1"><span>TOTAL</span><span id="supplierViewTotal">₱150,000</span></div>
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
                        <div class="flex items-center gap-1"><span class="text-gray-400">email:</span><span id="supplierEmailBox1">da***y@yahoo.com</span></div>
                        <div class="flex items-center gap-1"><span class="text-gray-400">email:</span><span id="supplierEmailBox2">jo**a@gmail.com</span></div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Subject</label>
                    <input type="text" id="supplierEmailSubjectInput" value="Purchase Order PO - 101" class="w-full bg-white border border-gray-300 shadow-sm rounded-xl px-4 py-2 text-xs text-gray-700 font-semibold focus:outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Email Message</label>
                    <div class="w-full bg-white border border-gray-300 shadow-sm rounded-xl p-4 text-xs text-gray-600 space-y-4 leading-relaxed font-medium">
                        <p>Hello,<br>Please find attached Purchase Order <span id="supplierEmailMsgPoNum">PO - 101</span>.</p>
                        <p>Thank you,<br>ABC Company</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    <button onclick="alert('Email dispatch successfully initiated!')" class="w-full bg-[#00b074] text-white font-semibold py-2.5 px-4 rounded-xl text-xs hover:bg-emerald-600 transition shadow-sm">
                        Send via Email
                    </button>
                    <button onclick="alert('Downloading PDF instance...')" class="w-full bg-white border border-gray-300 py-2.5 px-4 rounded-xl text-xs hover:bg-gray-55 text-gray-700 font-semibold transition shadow-sm">
                        Download PDF
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- TIMELINE HISTORY DRAWER OVERLAY (DYNAMIC SYSTEM DATABASE LOGS)             -->
<!-- ========================================================================= -->
<div id="historyDrawerOverlay" class="fixed inset-0 z-50 flex justify-end bg-black/40 backdrop-blur-sm transition-opacity opacity-0 pointer-events-none duration-300">
    <div id="historyDrawerPanel" class="w-full max-w-sm bg-white h-screen shadow-2xl p-8 relative flex flex-col justify-start overflow-y-auto border-l border-gray-200 transform translate-x-full transition-transform duration-300">
        <button onclick="toggleHistoryDrawer(false)" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <h1 class="text-xl font-bold text-gray-800 mb-10 tracking-wide">History Log</h1>

        <div id="timelineContainer" class="relative pl-2 space-y-8 flex-1">
            <div class="absolute left-5.75 top-3 bottom-3 w-0.75 bg-[#10b981]"></div>
            
            @forelse($activityLogs as $log)
                <div class="flex items-start gap-6 relative z-10">
                    <div class="w-6 h-6 bg-[#10b981] rounded-full shrink-0 shadow-sm border-4 border-white"></div>
                    <div class="text-xs space-y-0.5 pt-0.5">
                        <p class="font-bold text-gray-500">{{ $log->created_at ? $log->created_at->format('M d, Y g:i A') : '' }}</p>
                        <p class="font-medium text-gray-600">{{ $log->details }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 text-xs py-8 font-semibold">
                    No activity logs recorded yet.
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
 // ==========================================
 // 1. DATABASE STATE
 // ==========================================
 const suppliersMockData = {
   "TicTac PC": {
     contact: "Dabby",
     email: "dabby@yahoo.com",
     altEmail: "jona@gmail.com",
     phone: "09553051025",
     address: "BLK 51 Lot 12A, Barangay San Andres 1, Dasmariñas, Cavite"
   },
   "MasterPc": {
     contact: "Alex",
     email: "alex.masterpc@yahoo.com",
     altEmail: "support.masterpc@gmail.com",
     phone: "09224238767",
     address: "Building 4, Industrial Zone, Calamba, Laguna"
   }
 };

 let purchaseOrdersState = {!! json_encode($purchaseOrders->keyBy('po_number')) !!};

 let selectedStatusFilter = 'All';
 let basePoIdCounter = Object.keys(purchaseOrdersState).length > 0 
    ? Math.max(...Object.values(purchaseOrdersState).map(po => {
        const match = po.po_number.match(/PO-2026-(\d+)/) || po.po_number.match(/PO-(\d+)/);
        return parseInt(match ? match[1] : '100', 10) || 100;
      })) 
    : 103; 
 let currentEditingPoNumber = null; 

 // ==========================================
 // 2. VIEW CONTROLLER AND ROUTING
 // ==========================================
 function switchView(targetViewId) {
   document.querySelectorAll('.view-panel').forEach(panel => panel.classList.add('hidden'));

   const activePanel = document.getElementById(targetViewId);
   if(activePanel) activePanel.classList.remove('hidden');

   const submenu = document.getElementById('dashboardSubmenu');
   if (submenu) {
     submenu.querySelectorAll('button').forEach(btn => {
       btn.classList.remove('subnav-active');
       btn.innerHTML = btn.innerHTML.replace('● ', '• ');
     });

     const targetButton = document.getElementById(`sub-${targetViewId}`);
     if(targetButton) {
       targetButton.classList.add('subnav-active');
       targetButton.innerHTML = targetButton.innerHTML.replace('• ', '● ');
     }
   }
 }

 // ==========================================
 // 3. ACTIONS: PO CREATION & WIZARD BUILDERS
 // ==========================================
 function openCreatePoView() {
   currentEditingPoNumber = null;
   document.getElementById('createPoTitle').innerText = "Create New PO";
   document.getElementById('createPoBreadcrumb').innerText = "Create PO";
   
   basePoIdCounter++;
   document.getElementById('wizardPoNumberInput').value = `PO-2026-${String(basePoIdCounter).padStart(3, '0')}`;
   
   document.getElementById('wizardSupplierSelect').selectedIndex = 0;
   document.getElementById('wizardLineItemsList').innerHTML = `
     <div class="bg-white p-3 rounded-lg border border-gray-200 text-xs space-y-2 relative item-entry-row">
       <div><label class="text-[10px] text-blue-500 font-bold block mb-0.5">Item Name</label><input type="text" value="Enterprise Computer Set" class="w-full border rounded px-2 py-0.5 font-semibold item-name-field"></div>
       <div class="grid grid-cols-3 gap-2">
         <div><label class="text-[10px] text-blue-500 font-bold block">Qty</label><input type="number" value="1" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-qty"></div>
         <div><label class="text-[10px] text-blue-500 font-bold block">Price</label><input type="number" value="50000" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-price"></div>
         <div><label class="text-[10px] text-gray-400 font-bold block">Amount</label><input type="text" value="₱50,000" readonly class="w-full bg-gray-50 border rounded px-2 py-0.5 text-gray-500 font-bold item-total-box"></div>
       </div>
     </div>
   `;
   switchView('create-po-view');
 }

 function editPurchaseOrder(poNum) {
   const po = purchaseOrdersState[poNum];
   if (!po) return;

   currentEditingPoNumber = poNum;
   document.getElementById('createPoTitle').innerText = `Edit ${poNum}`;
   document.getElementById('createPoBreadcrumb').innerText = `Edit PO ${poNum}`;
   document.getElementById('wizardPoNumberInput').value = poNum;

   const supSelect = document.getElementById('wizardSupplierSelect');
   supSelect.value = po.supplier;

   const addrSelect = document.getElementById('wizardDeliveryAddress');
   addrSelect.value = po.delivery_address; 

   const container = document.getElementById('wizardLineItemsList');
   container.innerHTML = '';
   
   po.items.forEach(item => {
     const itemBlock = document.createElement('div');
     itemBlock.className = "bg-white p-3 rounded-lg border border-gray-200 text-xs space-y-2 relative item-entry-row";
     itemBlock.innerHTML = `
       <div><label class="text-[10px] text-blue-500 font-bold block mb-0.5">Item Name</label><input type="text" value="${item.name}" class="w-full border rounded px-2 py-0.5 font-semibold item-name-field"></div>
       <div class="grid grid-cols-3 gap-2">
         <div><label class="text-[10px] text-blue-500 font-bold block">Qty</label><input type="number" value="${item.qty}" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-qty"></div>
         <div><label class="text-[10px] text-blue-500 font-bold block">Price</label><input type="number" value="${item.price}" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-price"></div>
         <div><label class="text-[10px] text-gray-400 font-bold block">Amount</label><input type="text" value="₱${(item.qty * item.price).toLocaleString()}" readonly class="w-full bg-gray-50 border rounded px-2 py-0.5 text-gray-500 font-bold item-total-box"></div>
       </div>
     `;
     container.appendChild(itemBlock);
   });

   switchView('create-po-view');
 }

 function saveNewPurchaseOrder() {
   const supplierSelect = document.getElementById('wizardSupplierSelect');
   const selectedSupplier = supplierSelect.options[supplierSelect.selectedIndex].value;
   const deliveryAddress = document.getElementById('wizardDeliveryAddress').value;

   const items = [];
   const rows = document.querySelectorAll('.item-entry-row');
   
   rows.forEach(row => {
     const name = row.querySelector('.item-name-field').value || "Unnamed Item";
     const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
     const price = parseFloat(row.querySelector('.item-price').value) || 0;
     
     if(qty > 0) {
       items.push({ name, qty, price });
     }
   });

   if (items.length === 0) {
     alert("Please add at least one line item with valid quantity!");
     return;
   }

   const form = document.createElement('form');
   form.method = 'POST';
   
   if (currentEditingPoNumber !== null) {
     const poId = purchaseOrdersState[currentEditingPoNumber].id;
     form.action = `/po/update/${poId}`;
     
     const methodInput = document.createElement('input');
     methodInput.type = 'hidden';
     methodInput.name = '_method';
     methodInput.value = 'PUT';
     form.appendChild(methodInput);
   } else {
     form.action = '/po/store';
   }

   const csrfInput = document.createElement('input');
   csrfInput.type = 'hidden';
   csrfInput.name = '_token';
   csrfInput.value = '{{ csrf_token() }}';
   form.appendChild(csrfInput);

   const inputs = {
     supplier: selectedSupplier,
     delivery_address: deliveryAddress
   };

   for (const [key, value] of Object.entries(inputs)) {
     const input = document.createElement('input');
     input.type = 'hidden';
     input.name = key;
     input.value = value;
     form.appendChild(input);
   }

   items.forEach((item, index) => {
     for (const [key, value] of Object.entries(item)) {
       const itemInput = document.createElement('input');
       itemInput.type = 'hidden';
       itemInput.name = `items[${index}][${key}]`;
       itemInput.value = value;
       form.appendChild(itemInput);
     }
   });

   document.body.appendChild(form);
   form.submit();
 }

 function addWizardRowItem() {
   const container = document.getElementById('wizardLineItemsList');
   const itemBlock = document.createElement('div');
   itemBlock.className = "bg-white p-3 rounded-lg border border-gray-200 text-xs space-y-2 relative item-entry-row";
   itemBlock.innerHTML = `
     <div><label class="text-[10px] text-blue-500 font-bold block mb-0.5">Item Name</label><input type="text" placeholder="Enter component title..." class="w-full border rounded px-2 py-0.5 font-semibold item-name-field"></div>
     <div class="grid grid-cols-3 gap-2">
       <div><label class="text-[10px] text-blue-500 font-bold block">Qty</label><input type="number" value="1" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-qty"></div>
       <div><label class="text-[10px] text-blue-500 font-bold block">Price</label><input type="number" value="0" oninput="calculateWizardRowAmount(this)" class="w-full border rounded px-2 py-0.5 item-price"></div>
       <div><label class="text-[10px] text-gray-400 font-bold block">Amount</label><input type="text" value="₱0" readonly class="w-full bg-gray-50 border rounded px-2 py-0.5 text-gray-500 font-bold item-total-box"></div>
     </div>
   `;
   container.appendChild(itemBlock);
 }

 function calculateWizardRowAmount(input) {
   const block = input.closest('.grid');
   const qty = parseFloat(block.querySelector('.item-qty').value) || 0;
   const price = parseFloat(block.querySelector('.item-price').value) || 0;
   const totalBox = block.querySelector('.item-total-box');
   totalBox.value = '₱' + (qty * price).toLocaleString();
 }

 // ==========================================
 // 4. ACTIONS: PO DETAILS VIEW COMPILER
 // ==========================================
 function viewPoDetails(poNum) {
   const po = purchaseOrdersState[poNum];
   if (!po) return;

   document.getElementById('detailsPoNumberLabel').innerText = poNum;
   document.getElementById('detailsPoHeader').innerText = poNum;
   
   const badge = document.getElementById('detailsStatusBadge');
   badge.innerText = po.status;
   badge.className = "text-[10px] px-2.5 py-0.5 rounded-full font-bold " + 
     (po.status === 'Delivered' ? 'bg-green-100 text-green-700' : 
      po.status === 'Sent' ? 'bg-blue-100 text-blue-700' : 
      po.status === 'Confirmed' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-600');

   const supData = suppliersMockData[po.supplier] || { contact: "N/A", email: "N/A", phone: "N/A", address: "N/A" };
   document.getElementById('detailsSupplierCompany').innerText = po.supplier;
   document.getElementById('detailsSupplierContact').innerText = supData.contact;
   document.getElementById('detailsSupplierEmail').innerText = supData.email;
   document.getElementById('detailsSupplierPhone').innerText = supData.phone;
   document.getElementById('detailsSupplierAddress').innerHTML = `<p>${supData.address.replace(/,/g, '</p><p>')}</p>`;

   const itemBody = document.getElementById('detailsItemizedList');
   itemBody.innerHTML = '';
   let totalAmount = 0;

   po.items.forEach(item => {
     const lineTotal = item.qty * item.price;
     totalAmount += lineTotal;
     
     const icon = item.name.toLowerCase().includes('computer') || item.name.toLowerCase().includes('deck') ? '🖥️' : '⚙️';
     
     const tr = document.createElement('tr');
     tr.className = "bg-gray-50 rounded-xl";
     tr.innerHTML = `
       <td class="p-3 rounded-l-xl"><div class="w-8 h-8 bg-gray-300 rounded-full shadow-inner flex items-center justify-center">${icon}</div></td>
       <td class="p-3"><div>${item.name}</div><span class="text-[10px] text-gray-400 font-normal">Component set modules</span></td>
       <td class="p-3 text-center">${item.qty}</td>
       <td class="p-3 text-center">₱${parseFloat(item.price).toLocaleString()}</td>
       <td class="p-3 text-center font-bold rounded-r-xl">₱${lineTotal.toLocaleString()}</td>
     `;
     itemBody.appendChild(tr);
   });

   document.getElementById('detailsGrandTotalLabel').innerText = `Total: ₱${totalAmount.toLocaleString()}`;

   document.getElementById('sendToSupplierBtn').onclick = () => viewSupplierPreview(poNum);
   document.getElementById('revisePoBtn').onclick = () => editPurchaseOrder(poNum);
   document.getElementById('cancelPoBtn').onclick = () => executeOrderCancellation(poNum);

   switchView('po-details-view');
 }

 function executeOrderCancellation(poNum) {
   const po = purchaseOrdersState[poNum];
   if (!po) return;

   if (confirm(`Are you sure you want to initialize system cancellation sequences for ${poNum}?`)) {
     const form = document.createElement('form');
     form.method = 'POST';
     form.action = `/po/cancel/${po.id}`;

     const csrfInput = document.createElement('input');
     csrfInput.type = 'hidden';
     csrfInput.name = '_token';
     csrfInput.value = '{{ csrf_token() }}';
     form.appendChild(csrfInput);

     document.body.appendChild(form);
     form.submit();
   }
 }

 // ==========================================
 // 5. ACTIONS: SUPPLIER PRINT & PREVIEWS
 // ==========================================
 function viewSupplierPreview(poNum) {
   const po = purchaseOrdersState[poNum];
   if(!po) return;

   const supData = suppliersMockData[po.supplier] || { contact: "N/A", email: "N/A", phone: "N/A", address: "N/A" };

   document.getElementById('supplierViewPoNum').innerText = poNum;
   document.getElementById('supplierViewRef').innerText = poNum;
   document.getElementById('supplierViewCompName').innerText = po.supplier;
   document.getElementById('supplierViewEmail').innerText = supData.email;
   document.getElementById('supplierViewPhone').innerText = supData.phone;
   document.getElementById('supplierViewDeliveryAddress').innerText = po.delivery_address;
   
   const printTable = document.getElementById('supplierViewItemTable');
   printTable.innerHTML = '';
   let subtotal = 0;
   
   po.items.forEach((item, index) => {
     const lineTotal = item.qty * item.price;
     subtotal += lineTotal;
     
     const tr = document.createElement('tr');
     tr.className = "bg-white hover:bg-gray-50 rounded-lg border shadow-sm";
     tr.innerHTML = `
       <td class="p-2.5 border border-r-0 border-gray-200 rounded-l-lg text-gray-400">${index + 1}</td>
       <td class="p-2.5 border-y border-gray-200 text-center text-gray-600 font-bold">${item.name}</td>
       <td class="p-2.5 border-y border-gray-200 text-center">${item.qty}</td>
       <td class="p-2.5 border-y border-gray-200 text-center">₱${parseFloat(item.price).toLocaleString()}</td>
       <td class="p-2.5 border border-l-0 border-gray-200 rounded-r-lg text-center font-bold">₱${lineTotal.toLocaleString()}</td>
     `;
     printTable.appendChild(tr);
   });

   document.getElementById('supplierViewSubtotal').innerText = `₱${subtotal.toLocaleString()}`;
   document.getElementById('supplierViewTotal').innerText = `₱${subtotal.toLocaleString()}`;

   document.getElementById('supplierEmailBox1').innerText = supData.email;
   document.getElementById('supplierEmailBox2').innerText = supData.altEmail || 'support@supplier.com';
   document.getElementById('supplierEmailSubjectInput').value = `Purchase Order ${poNum}`;
   document.getElementById('supplierEmailMsgPoNum').innerText = poNum;

   document.getElementById('backToPoDetailsFromSupplierBtn').onclick = () => viewPoDetails(poNum);

   switchView('supplier-view');
 }

 // ==========================================
 // 6. SEARCH & CRITERIA FILTER ENGINE
 // ==========================================
 function toggleFilterMenu(e) {
   e.stopPropagation();
   const dropdown = document.getElementById('filterDropdown');
   const arrow = document.getElementById('filterArrow');
   if (dropdown.classList.contains('hidden')) {
     dropdown.classList.remove('hidden');
     arrow.classList.add('rotate-90');
   } else {
     dropdown.classList.add('hidden');
     arrow.classList.remove('rotate-90');
   }
 }

 function setStatusFilter(status) {
   selectedStatusFilter = status;
   document.getElementById('activeFilterText').innerText = status;
   
   // DINAGDAG ANG 'Cancelled' SA LISTAHAN UPANG GUMANA ANG CHECKMARK NITO
   ['All', 'Delivered', 'Sent', 'Confirmed', 'Cancelled'].forEach(item => {
     const checkElement = document.getElementById(`chk-${item}`);
     if (checkElement) {
       checkElement.classList.toggle('hidden', item !== status);
     }
   });

   filterTableRows();
 }

 function filterTableRows() {
   const searchInput = document.getElementById('tableRowSearch').value.toLowerCase().trim();
   const dateInput = document.getElementById('tableDateFilter').value;
   const supplierInput = document.getElementById('tableSupplierFilter').value;
   const rows = document.querySelectorAll('.po-table-row');

   rows.forEach(row => {
     const rowStatus = row.getAttribute('data-status');
     const poNum = row.querySelector('.target-po').innerText.toLowerCase();
     const supplier = row.querySelector('.target-supplier').innerText.toLowerCase();
     const dateVal = row.querySelector('.target-date').innerText;

     const matchStatus = (selectedStatusFilter === 'All' || rowStatus === selectedStatusFilter);
     const matchSearch = (!searchInput || poNum.includes(searchInput) || supplier.includes(searchInput));
     const matchDate = (!dateInput || dateVal === dateInput);
     const matchSupplier = (!supplierInput || row.querySelector('.target-supplier').innerText === supplierInput);

     if (matchStatus && matchSearch && matchDate && matchSupplier) {
       row.classList.remove('hidden');
     } else {
       row.classList.add('hidden');
     }
   });
   updateActiveMetricsCounter();
 }

 function applyGlobalSearch(value) {
   const localSearch = document.getElementById('tableRowSearch');
   if (localSearch) {
     localSearch.value = value;
     filterTableRows();
   }
 }

 // ==========================================
 // 7. UI REBUILDERS & STATE EVENT LOGS
 // ==========================================
 function rebuildPoTableUI() {
   const poTableBody = document.getElementById('poTableBody');
   if (!poTableBody) return;
   
   poTableBody.innerHTML = '';

   const poList = Object.values(purchaseOrdersState);

   if (poList.length === 0) {
     poTableBody.innerHTML = `
       <tr>
         <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
           No purchase orders found in history. Click the "+" button to create one!
         </td>
       </tr>
     `;
     return;
   }

   poList.forEach(po => {
     let total = 0;
     if (po.items && Array.isArray(po.items)) {
       total = po.items.reduce((sum, item) => sum + (parseFloat(item.qty) * parseFloat(item.price)), 0);
     } else if (po.grand_total) {
       total = parseFloat(po.grand_total);
     }

     let statusColorClass = po.status === 'Delivered' ? 'bg-green-100 text-green-700' :
                            po.status === 'Sent' ? 'bg-blue-100 text-blue-700' :
                            po.status === 'Confirmed' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-600';

     let displayDate = po.date;
     if (!displayDate && po.created_at) {
       displayDate = po.created_at.split('T')[0]; 
     }
     if (!displayDate) displayDate = '';

     const tr = document.createElement('tr');
     tr.setAttribute('data-status', po.status);
     tr.className = "po-table-row bg-gray-50 rounded-lg hover:bg-gray-100 transition shadow-sm cursor-pointer";
     tr.onclick = () => viewPoDetails(po.po_number);
     
     tr.innerHTML = `
       <td class="p-3 rounded-l-lg text-blue-600 hover:underline target-po">${po.po_number}</td>
       <td class="p-3 target-date">${displayDate}</td>
       <td class="p-3 target-supplier">${po.supplier}</td>
       <td class="p-3">₱ ${total.toLocaleString()}</td>
       <td class="p-3"><span class="${statusColorClass} text-[10px] px-2 py-0.5 rounded font-bold">${po.status}</span></td>
       <td class="p-3 rounded-r-lg text-center space-x-3 text-gray-400" onclick="event.stopPropagation()">
         <button onclick="viewPoDetails('${po.po_number}')" class="hover:text-gray-900" title="View details">👁️</button>
         <button onclick="editPurchaseOrder('${po.po_number}')" class="hover:text-blue-600" title="Edit row">📝</button>
         <button onclick="deleteTableRow(this, ${po.id})" class="hover:text-red-500" title="Delete row">🗑️</button>
       </td>
     `;
     poTableBody.appendChild(tr);
   });
 }

 function deleteTableRow(button, poId) {
   if (confirm('Are you sure you want to permanently delete this Purchase Order?')) {
     const form = document.createElement('form');
     form.method = 'POST';
     form.action = `/po/delete/${poId}`;

     const methodInput = document.createElement('input');
     methodInput.type = 'hidden';
     methodInput.name = '_method';
     methodInput.value = 'DELETE';
     form.appendChild(methodInput);

     const csrfInput = document.createElement('input');
     csrfInput.type = 'hidden';
     csrfInput.name = '_token';
     csrfInput.value = '{{ csrf_token() }}';
     form.appendChild(csrfInput);

     document.body.appendChild(form);
     form.submit();
   }
 }

 function updateActiveMetricsCounter() {
   const rows = Object.values(purchaseOrdersState);
   const activePo = rows.filter(p => p.status !== 'Cancelled').length;
   const pendingSent = rows.filter(p => p.status === 'Sent').length;
   
   const activeElem = document.getElementById('metric-active');
   const sentElem = document.getElementById('metric-sent');
   
   if(activeElem) activeElem.innerText = activePo;
   if(sentElem) sentElem.innerText = pendingSent;
 }

 function toggleHistoryDrawer(show) {
   const overlay = document.getElementById('historyDrawerOverlay');
   const panel = document.getElementById('historyDrawerPanel');
   
   if (show) {
     overlay.classList.remove('pointer-events-none', 'opacity-0');
     overlay.classList.add('opacity-100');
     panel.classList.remove('translate-x-full');
     panel.classList.add('translate-x-0');
   } else {
     overlay.classList.remove('opacity-100');
     overlay.classList.add('pointer-events-none', 'opacity-0');
     panel.classList.remove('translate-x-0');
     panel.classList.add('translate-x-full');
   }
 }

 window.addEventListener('click', function() {
   const dropdown = document.getElementById('filterDropdown');
   const arrow = document.getElementById('filterArrow');
   if (dropdown) dropdown.classList.add('hidden');
   if (arrow) arrow.classList.remove('rotate-90');
 });

 rebuildPoTableUI();
 updateActiveMetricsCounter();
</script>
@endpush