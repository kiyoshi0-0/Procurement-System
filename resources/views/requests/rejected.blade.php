@extends('layouts.app')

@section('content')

      <main class="p-8 space-y-6">
        
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Purchase Requisition & Approval</h1>
            <p class="text-sm text-gray-500 mt-0.5">Submit and track computer parts purchase requests</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
            <div class="flex justify-between items-start">
              <span class="text-3xl font-bold text-gray-800">{{ $allCount ?? 0 }}</span>
              <div class="p-1.5 bg-blue-50 text-blue-600 rounded-md">
                <i data-lucide="file-text" class="w-4 h-4"></i>
              </div>
            </div>
            <p class="text-sm font-bold text-gray-700 mt-2">All</p>
            <p class="text-[11px] text-gray-400">Total requests</p>
          </button>

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
            <div class="flex justify-between items-start">
              <span class="text-3xl font-bold text-gray-800">{{ $pendingCount ?? 0 }}</span>
              <div class="p-1.5 bg-blue-50 text-blue-500 rounded-md">
                <i data-lucide="clock" class="w-4 h-4"></i>
              </div>
            </div>
            <p class="text-sm font-bold text-gray-700 mt-2">Pending</p>
            <p class="text-[11px] text-gray-400">Awaiting Review</p>
          </button>

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
            <div class="flex justify-between items-start">
              <span class="text-3xl font-bold text-gray-800">{{ $approvedCount ?? 0 }}</span>
              <div class="p-1.5 bg-emerald-50 text-emerald-500 rounded-md">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
              </div>
            </div>
            <p class="text-sm font-bold text-gray-700 mt-2">Approved</p>
            <p class="text-[11px] text-gray-400">ready for PO</p>
          </button>

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
            <div class="flex justify-between items-start">
              <span class="text-3xl font-bold text-gray-800">{{ $revisionCount ?? 0 }}</span>
              <div class="p-1.5 bg-orange-50 text-orange-500 rounded-md">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
              </div>
            </div>
            <p class="text-sm font-bold text-gray-700 mt-2">Revision</p>
            <p class="text-[11px] text-gray-400">needs update</p>
          </button>

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm ring-2 ring-rose-500">
            <div class="flex justify-between items-start">
              <span class="text-3xl font-bold text-gray-800">{{ $rejectedCount ?? 0 }}</span>
              <div class="p-1.5 bg-rose-50 text-rose-500 rounded-md">
                <i data-lucide="x-circle" class="w-4 h-4"></i>
              </div>
            </div>
            <p class="text-sm font-bold text-gray-700 mt-2">Rejected</p>
            <p class="text-[11px] text-gray-400">not approved</p>
          </button>
        </div>

       <!-- Dynamic Loop Rows Content Section -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
          <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-[#1E3A8A]">Rejected History</h3>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
              <div class="relative w-full sm:w-64">
                <input id="requestSearchInput" type="search" autocomplete="off" placeholder="Search Request..." class="w-full pl-8 pr-4 py-1.5 bg-white border border-gray-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-[#00A86B]" oninput="filterRequests(this.value)">
                <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5"></i>
              </div>
             <!-- Filter Dropdown Container -->
              <div class="relative">
                <button type="button" onclick="toggleFilterDropdown()" class="flex items-center space-x-1.5 border border-gray-300 rounded-md px-3 py-1.5 text-xs text-gray-600 bg-white hover:bg-gray-50 focus:outline-none">
                  <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                  <span>Filter</span>
                </button>
                <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-20 text-xs">
                  <div class="py-1">
                    <button type="button" onclick="sortRequests('asc')" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                      <i data-lucide="arrow-up-narrow-wide" class="w-3.5 h-3.5"></i>
                      <span>ID: Ascending</span>
                    </button>
                    <button type="button" onclick="sortRequests('desc')" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                      <i data-lucide="arrow-down-wide-narrow" class="w-3.5 h-3.5"></i>
                      <span>ID: Descending</span>
                    </button>
                  </div>
                </div>
              </div>
              <button type="button" onclick="exportTableToCSV('purchase_requests.csv')" class="flex items-center space-x-1.5 border border-gray-300 rounded-md px-3 py-1.5 text-xs text-gray-600 bg-white hover:bg-gray-50">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Export</span>
              </button>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-xs">
              <thead class="bg-gray-300 text-gray-700 uppercase font-semibold border-b border-gray-200 tracking-wider">
                <tr>
                  <th class="p-4">Req. ID</th>
                  <th class="p-4">Department</th>
                  <th class="p-4">Items</th>
                  <th class="p-4">Priority</th>
                  <th class="p-4">Submitted</th>
                  <th class="p-4">Requestor</th>
                  <th class="p-4">Status</th>
                  <th class="p-4 text-center">Actions</th>
                </tr>
              </thead>
              <tbody id="request-table-rows" class="divide-y divide-gray-200 text-gray-600 font-medium">
                @php $hasRejected = false; @endphp
                @foreach($requests as $request)
                  @if(strtolower($request->status) === 'rejected')
                    @php $hasRejected = true; @endphp
                    <tr id="row-req-{{ $request->id }}" class="hover:bg-gray-50">
                      <td class="p-4 font-bold text-gray-800">REQ-{{ $request->id }}</td>
                      <td class="p-4">{{ $request->dept }}</td>
                      <td class="p-4">{{ $request->item_name }}</td>
                      <td class="p-4">
                        <span class="px-3 py-1 rounded-full border font-bold text-[11px] 
                          {{ strtolower($request->priority) === 'high' ? 'bg-rose-50 text-rose-500 border-rose-200' : (strtolower($request->priority) === 'medium' || strtolower($request->priority) === 'med' ? 'bg-amber-50 text-amber-500 border-amber-200' : 'bg-emerald-50 text-emerald-500 border-emerald-200') }}">
                          {{ ucfirst($request->priority) }}
                        </span>
                      </td>
                      <td class="p-4">{{ $request->created_at ? $request->created_at->format('Y-m-d') : '--' }}</td>
                      <td class="p-4">{{ $request->requestor }}</td>
                      <td class="p-4">
                        <span class="px-3 py-1 rounded-full border border-rose-200 bg-rose-50 text-rose-500 font-bold text-[12px]">Rejected</span>
                      </td>
                      <td class="p-4 flex items-center justify-center space-x-4 text-gray-400">
                        
                        <button 
                          onclick="handleViewClick(this)"
                          data-req-id="REQ-{{ $request->id }}"
                          data-priority="{{ ucfirst($request->priority) }}"
                          data-item-name="{{ $request->item_name }}"
                          data-qty="{{ $request->qty }}"
                          data-price="{{ number_format($request->price, 2, '.', '') }}"
                          data-total="{{ number_format($request->qty * $request->price, 2, '.', '') }}"
                          data-date="{{ $request->created_at ? $request->created_at->format('Y-m-d') : '--' }}"
                          
                          data-comment="{{ $request->manager_comment ?? 'No standard rejection grounds provided.' }}"
                          data-justification="{{ $request->justification ?? 'No custom details or remarks provided.' }}"
                          
                          data-meta="{{ $request->requestor }} · {{ $request->dept }} · {{ $request->brand ?? 'Generic' }}"
                          class="hover:text-blue-500 transition-colors bg-transparent border-0 p-0 cursor-pointer"
                        >
                          <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                        
                        <form action="{{ route('requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this requisition?');" class="inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="hover:text-rose-500 transition-colors bg-transparent border-0 p-0 cursor-pointer">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endif
                @endforeach
                
                @if(!$hasRejected)
                  <tr>
                    <td colspan="8" class="p-8 text-center text-gray-400 font-medium">No rejected request records found.</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>


  
  <div id="sideDrawer" class="fixed inset-0 z-50 flex justify-end hidden">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-xs transition-opacity" onclick="closeDrawer()"></div>
    
    <div class="bg-white w-full max-w-xl h-full shadow-2xl relative z-10 flex flex-col justify-between border-l border-gray-200">
      
      <div class="overflow-y-auto flex-1 p-6 space-y-6">
        <div class="flex justify-between items-start">
          <div class="space-y-2">
            <div class="flex items-center space-x-1.5 flex-wrap gap-y-1">
              <span id="drawerReqId" class="text-xs font-semibold text-gray-500 border border-gray-200 rounded px-2 py-0.5 bg-gray-50">REQ-000</span>
              <span id="drawerPriorityBadge" class="text-xs font-semibold px-2 py-0.5 rounded">High</span>
              <span class="text-xs font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-500">Rejected</span>
            </div>
            <div>
              <h2 id="drawerItemName" class="text-lg font-bold text-gray-900 leading-tight">Item Title</h2>
              <p id="drawerSubMeta" class="text-xs text-gray-400 mt-0.5">Author info details</p>
            </div>
          </div>
          
          <button onclick="closeDrawer()" class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:bg-gray-50 transition">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>

        <div class="grid grid-cols-5 gap-2">
          <div class="bg-[#E2E8F0] rounded-md p-2 text-center">
            <span class="block text-[9px] font-bold text-gray-500 uppercase tracking-wide">Items</span>
            <span id="badgeItems" class="text-sm font-bold text-gray-700 block mt-0.5">1</span>
          </div>
          <div class="bg-[#E2E8F0] rounded-md p-2 text-center">
            <span class="block text-[9px] font-bold text-gray-500 uppercase tracking-wide">Qty</span>
            <span id="badgeQty" class="text-sm font-bold text-gray-700 block mt-0.5">1</span>
          </div>
          <div class="bg-[#E2E8F0] rounded-md p-2 text-center">
            <span class="block text-[9px] font-bold text-gray-500 uppercase tracking-wide">Total</span>
            <span id="badgeTotal" class="text-sm font-bold text-gray-700 block mt-0.5">$0.00</span>
          </div>
          <div class="bg-[#E2E8F0] rounded-md p-2 text-center">
            <span class="block text-[9px] font-bold text-gray-500 uppercase tracking-wide">Submitted</span>
            <span id="badgeSubmitted" class="text-[10px] font-bold text-gray-700 block mt-1 truncate">--</span>
          </div>
          <div class="bg-[#E2E8F0] rounded-md p-2 text-center">
            <span class="block text-[9px] font-bold text-gray-500 uppercase tracking-wide">Delivery</span>
            <span id="badgeDelivery" class="text-[10px] font-bold text-gray-700 block mt-1 truncate">--</span>
          </div>
        </div>

        <div class="bg-[#FEE2E2] border border-rose-200 rounded-xl p-4 flex items-start space-x-3.5">
          <div class="bg-rose-500 text-white rounded-full p-1.5 shrink-0 mt-0.5">
            <i data-lucide="ban" class="w-4 h-4"></i>
          </div>
          <div>
            <h4 class="text-sm font-bold text-rose-900 leading-tight">Procurement Manager Comment</h4>
            <p id="drawerReasonText" class="text-xs text-rose-600 mt-1 font-medium">Rejection message details go here.</p>
          </div>
        </div>

        <div class="space-y-2.5">
          <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Items Breakdown</h3>
          <div class="border border-gray-200 rounded-xl p-4 flex justify-between items-center bg-white">
            <div>
              <h5 id="itemRowTitle" class="text-sm font-bold text-gray-800">Title</h5>
              <p class="text-xs text-gray-400 font-medium mt-0.5">Hardware / Parts Asset Line</p>
            </div>
            <div class="text-right">
              <span id="itemRowPrice" class="text-sm font-bold text-gray-900 block">$0.00</span>
              <span id="itemRowQtyCalc" class="text-[10px] text-gray-400 font-medium block mt-0.5">1 × $0.00</span>
            </div>
          </div>
          
          <div class="border border-gray-200 rounded-xl p-4 flex justify-between items-center bg-white">
            <span class="text-sm font-bold text-gray-800">Total Estimated Budget</span>
            <span id="itemRowTotalBudget" class="text-sm font-bold text-gray-900">$0.00</span>
          </div>
        </div>

        <div class="space-y-1.5">
          <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Remarks (Justification)</h3>
          <div id="drawerRemarksBlock" class="w-full min-h-11 border border-gray-200 rounded-xl bg-white p-3 text-xs text-gray-600 leading-relaxed font-medium">
            User remarks content.
          </div>
        </div>

        <div class="space-y-2">
          <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Supporting Documents</h3>
          <div class="space-y-1.5">
            <div class="border border-gray-200 rounded-xl p-3 flex justify-between items-center text-xs font-medium text-gray-600 bg-white hover:bg-gray-50/50 transition cursor-pointer">
              <div class="flex items-center space-x-2 truncate">
                <i data-lucide="paperclip" class="w-4 h-4 text-gray-400 shrink-0"></i>
                <span class="truncate"></span>
              </div>
              <i data-lucide="download" class="w-4 h-4 text-gray-400 ml-2 hover:text-gray-600"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="px-6 py-4 bg-white border-t border-gray-200 flex justify-between items-center">
        <button onclick="closeDrawer()" class="text-xs font-bold text-gray-500 hover:text-gray-700 transition">
          Cancel
        </button>
        <button class="bg-[#FEE2E2] border border-rose-200 text-rose-600 px-4 py-2 rounded-lg text-xs font-bold flex items-center space-x-1.5 shadow-2xs cursor-not-allowed">
          <i data-lucide="ban" class="w-3.5 h-3.5"></i>
          <span>Rejected</span>
        </button>
      </div>

    </div>
  </div>

  <script>
    lucide.createIcons();

    function toggleDropdown() {
      const dropdown = document.getElementById('request-dropdown');
      const arrow = document.getElementById('dropdown-arrow');
      dropdown.classList.toggle('hidden');
      arrow.classList.toggle('rotate-180');
    }

    function handleViewClick(buttonElement) {
      const data = buttonElement.dataset;
      
      document.getElementById('drawerReqId').innerText = data.reqId;
      document.getElementById('drawerItemName').innerText = data.itemName;
      document.getElementById('drawerSubMeta').innerText = data.meta;
      
      // Dynamic color styling matching the priority value
      document.getElementById('drawerPriorityBadge').innerText = data.priority;
      const priorityClass = data.priority.toLowerCase();
      if (priorityClass === 'high') {
         document.getElementById('drawerPriorityBadge').className = "text-xs font-semibold px-2 py-0.5 rounded-full border border-rose-200 bg-rose-50 text-rose-500";
      } else if (priorityClass === 'medium' || priorityClass === 'med') {
         document.getElementById('drawerPriorityBadge').className = "text-xs font-semibold px-2 py-0.5 rounded-full border border-amber-200 bg-amber-50 text-amber-500";
      } else {
         document.getElementById('drawerPriorityBadge').className = "text-xs font-semibold px-2 py-0.5 rounded-full border border-emerald-200 bg-emerald-50 text-emerald-500";
      }
      
      document.getElementById('badgeItems').innerText = "1";
      document.getElementById('badgeQty').innerText = data.qty;
      document.getElementById('badgeTotal').innerText = "$" + data.total;
      document.getElementById('badgeSubmitted').innerText = data.date;
      document.getElementById('badgeDelivery').innerText = data.date;
      
      // 1. Map dynamic Procurement Manager comments text area
      document.getElementById('drawerReasonText').innerText = data.comment;
      
      // 2. Map dynamic original justification/remarks content text block
      document.getElementById('drawerRemarksBlock').innerText = data.justification;
      
      document.getElementById('itemRowTitle').innerText = data.itemName;
      document.getElementById('itemRowPrice').innerText = "$" + parseFloat(data.price).toFixed(2);
      
      let individualPrice = parseFloat(data.price);
      document.getElementById('itemRowQtyCalc').innerText = data.qty + " × $" + individualPrice.toFixed(2);
      document.getElementById('itemRowTotalBudget').innerText = "$" + data.total;

      const drawer = document.getElementById('sideDrawer');
      drawer.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    }

    function closeDrawer() {
      const drawer = document.getElementById('sideDrawer');
      drawer.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }






     function prepareAndOpenDrawer(buttonElement) {
      try {
        const reqData = buttonElement.getAttribute('data-request');
        if (!reqData) return;
        
        const req = JSON.parse(reqData);
        activeRequestId = req.id;
        
        document.getElementById('drawer-req-id').innerText = 'REQ-' + req.id;
        document.getElementById('drawer-item-name').innerText = req.item_name || 'Purchase Request';
        document.getElementById('drawer-meta-subtext').innerText = `${req.requestor} · ${req.dept} · ${req.supplier}`;
        
        document.getElementById('drawer-justification').innerText = req.justification || 'No justification details recorded.';
        document.getElementById('box-items').innerText = req.items_count || 1;
        document.getElementById('box-qty').innerText = req.qty || 1;
        document.getElementById('box-total').innerText = parseFloat(req.total_estimated).toFixed(2);
        document.getElementById('box-submitted').innerText = req.created_at;
        document.getElementById('box-delivery').innerText = req.estimated_delivery;
        document.getElementById('item-title-bold').innerText = req.item_name;
        document.getElementById('item-sub-brand').innerText = req.supplier;
        document.getElementById('item-price-bold').innerText = '$' + parseFloat(req.item_price).toLocaleString(undefined, {minimumFractionDigits:2});
        document.getElementById('item-calc-qty').innerText = `${req.qty} × $` + parseFloat(req.item_price).toLocaleString(undefined, {minimumFractionDigits:2});
        document.getElementById('item-grand-total').innerText = '$' + parseFloat(req.total_estimated).toLocaleString(undefined, {minimumFractionDigits:2});

        const filesContainer = document.getElementById('drawer-files-container');
        const noDocsMsg = document.getElementById('no-docs-msg');
        filesContainer.innerHTML = '';
        let docsArray = Array.isArray(req.supporting_docs) ? req.supporting_docs : [];
        if (docsArray.length > 0) {
          noDocsMsg.classList.add('hidden');
          docsArray.forEach((docPath) => {
            const fileName = docPath.split('/').pop();
            const fileRow = document.createElement('div');
            fileRow.className = "border border-gray-200 rounded-lg p-2 flex items-center justify-between bg-gray-50 text-[11px]";
            fileRow.innerHTML = `
              <div class="flex items-center space-x-2">
                <i class="fa-solid fa-file-invoice text-blue-500"></i>
                <span class="font-medium text-gray-700 truncate max-w-[220px]">${fileName}</span>
              </div>
              <a href="/storage/${docPath}" target="_blank" class="text-blue-600 hover:underline font-bold">View</a>`;
            filesContainer.appendChild(fileRow);
          });
        } else {
          noDocsMsg.classList.remove('hidden');
        }

        const currentPrio = (req.priority || 'low').toLowerCase();
        const prioPill = document.getElementById('drawer-priority-pill');
        prioPill.innerText = req.priority || 'Low';
        if(currentPrio === 'high') {
          prioPill.className = "px-2 py-0.5 rounded text-[10px] font-bold border bg-red-50 border-red-200 text-red-500";
        } else if(currentPrio === 'medium') {
          prioPill.className = "px-2 py-0.5 rounded text-[10px] font-bold border bg-amber-50 border-amber-200 text-amber-500";
        } else {
          prioPill.className = "px-2 py-0.5 rounded text-[10px] font-bold border bg-slate-50 border-slate-200 text-slate-500";
        }

        selectDecision(req.status.toLowerCase() === 'pending' ? 'approved' : req.status.toLowerCase());
        document.getElementById('decision-comment').value = '';
        
        document.getElementById('drawerBackdrop').classList.remove('hidden');
        setTimeout(() => {
          document.getElementById('detailsDrawer').classList.remove('translate-x-full');
        }, 20);
      } catch(err) {
        console.error("Data processing layout sequence fault: ", err);
      }
    }






    //filter
    function toggleFilterDropdown() {
      const dropdown = document.getElementById('filter-dropdown');
      dropdown.classList.toggle('hidden');
    }

    function sortRequests(order) {
      const tbody = document.getElementById('request-table-rows');
      const rows = Array.from(tbody.querySelectorAll('tr'));

      rows.sort((a, b) => {
        // Extract ID numbers from 'REQ-XX' format for accurate numerical sorting
        const idA = parseInt(a.id.replace('row-req-', ''));
        const idB = parseInt(b.id.replace('row-req-', ''));

        if (order === 'asc') {
          return idA - idB;
        } else {
          return idB - idA;
        }
      });

      // Re-append sorted rows to the table body
      rows.forEach(row => tbody.appendChild(row));
      
      // Hide dropdown after clicking
      toggleFilterDropdown();
    }

    function filterRequests(query) {
      const tbody = document.getElementById('request-table-rows');
      if (!tbody) return;
      const normalized = query.trim().toLowerCase();
      const rows = Array.from(tbody.querySelectorAll('tr'));

      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = normalized === '' || text.includes(normalized) ? '' : 'none';
      });
    }

    // Optional: Close filter dropdown when clicking outside
    window.addEventListener('click', function(e) {
      const dropdown = document.getElementById('filter-dropdown');
      const filterBtn = dropdown.previousElementSibling;
      if (!dropdown.contains(e.target) && !filterBtn.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('requestSearchInput');
      if (searchInput) {
        searchInput.addEventListener('input', function(e) {
          filterRequests(e.target.value);
        });
      }
    });

    //export
    function exportTableToCSV(filename) {
      const csv = [];
      const rows = document.querySelectorAll("#request-table-rows tr");
      
      // Get table headers dynamically for the CSV header row
      const headers = [];
      document.querySelectorAll("table thead th").forEach(th => {
        // Exclude the 'Actions' column from export headers
        if (th.innerText.trim() !== "Actions") {
          headers.push('"' + th.innerText.trim() + '"');
        }
      });
      csv.push(headers.join(","));

      // Loop through each table row and extract text content
      rows.forEach(row => {
        const cols = row.querySelectorAll("td");
        const rowData = [];
        
        // Loop through columns except the last one (Actions column)
        for (let i = 0; i < cols.length - 1; i++) {
          // Clean up text content (replace line breaks and quotes)
          let data = cols[i].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/"/g, '""');
          rowData.push('"' + data + '"');
        }
        csv.push(rowData.join(","));
      });

      // Download the generated CSV file
      const csvFile = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
      const downloadLink = document.createElement("a");
      downloadLink.download = filename;
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.style.display = "none";
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }

  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
  <script>lucide.createIcons();</script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
@endsection