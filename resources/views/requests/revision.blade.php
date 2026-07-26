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

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm ring-2 ring-orange-500">
            <div class="flex justify-between items-start">
              <span class="text-3xl font-bold text-gray-800">{{ $revisionCount ?? 0 }}</span>
              <div class="p-1.5 bg-orange-50 text-orange-500 rounded-md">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
              </div>
            </div>
            <p class="text-sm font-bold text-gray-700 mt-2">Revision</p>
            <p class="text-[11px] text-gray-400">needs update</p>
          </button>

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
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
            <h3 class="text-lg font-bold text-[#1E3A8A]">Revision Request History</h3>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
              <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Search Request..." class="w-full pl-8 pr-4 py-1.5 bg-white border border-gray-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-[#00A86B]">
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
              <tbody class="divide-y divide-gray-200 text-gray-600 font-medium">
                
                @php
                  $revisionRequests = $requests->filter(function($item) {
                      return strtolower($item->status) === 'revision';
                  });
                @endphp

                @forelse($revisionRequests as $request)
                <tr class="hover:bg-gray-50">
                  <td class="p-4 font-bold text-gray-800">REQ-{{ $request->id }}</td>
                  <td class="p-4">{{ $request->dept }}</td>
                  <td class="p-4 text-ellipsis overflow-hidden max-w-45 whitespace-nowrap">{{ $request->item_name }}</td>
                  <td class="p-4">
                    @if(strtolower($request->priority) === 'high')
                      <span class="px-2.5 py-0.5 bg-rose-50 text-rose-500 rounded-full border border-rose-200 font-semibold text-[10px]">High</span>
                    @elseif(strtolower($request->priority) === 'med' || strtolower($request->priority) === 'medium')
                      <span class="px-2.5 py-0.5 bg-amber-50 text-amber-500 rounded-full border border-amber-200 font-semibold text-[10px]">Med</span>
                    @else
                      <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-500 rounded-full border border-emerald-200 font-semibold text-[10px]">Low</span>
                    @endif
                  </td>
                  <td class="p-4">{{ $request->created_at ? $request->created_at->format('Y-m-d') : 'N/A' }}</td>
                  <td class="p-4">{{ $request->requestor }}</td>
                  <td class="p-4">
                    <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-full border border-orange-200 font-semibold capitalize">{{ $request->status }}</span>
                  </td>
                  <td class="p-4 flex items-center justify-center space-x-4 text-gray-400">
                    
                    <button type="button" 
                            onclick="openDrawer(this)"
                            data-id="{{ $request->id }}"
                            data-priority="{{ $request->priority }}"
                            data-item_name="{{ $request->item_name }}"
                            data-requestor="{{ $request->requestor }}"
                            data-dept="{{ $request->dept }}"
                            data-brand="{{ $request->brand }}"
                            data-qty="{{ $request->qty }}"
                            data-price="{{ $request->price }}"
                            data-created_at="{{ $request->created_at ? $request->created_at->format('Y-m-d') : '' }}"
                            data-manager_comment="{{ $request->manager_comment }}"
                            data-category="{{ $request->category }}"
                            data-justification="{{ $request->justification }}"
                            class="hover:text-blue-500 transition-colors">
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                    
                    <form action="{{ route('requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase request?');" class="inline m-0 p-0">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="hover:text-rose-500 transition-colors align-middle">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="p-8 text-center text-gray-400 font-medium">No revision requests found in the database.</td>
                </tr>
                @endforelse

              </tbody>
            </table>
          </div>
        </div>

      </main>
    </div>
  </div>

  <div id="drawerBackdrop" class="fixed inset-0 bg-black/25 backdrop-blur-[1px] z-40 transition-opacity duration-300 hidden" onclick="closeDrawer()"></div>

  <div id="sideDrawer" class="fixed top-0 right-0 w-full max-w-145 h-full bg-white shadow-2xl z-50 flex flex-col justify-between border-l border-gray-200 transition-transform duration-300 ease-in-out transform translate-x-full">
    
    <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-white shrink-0">
      <div class="flex items-center space-x-2">
        <span id="drawer-id-badge" class="px-2.5 py-1 border border-gray-300 text-gray-500 font-bold rounded-md text-xs tracking-wide bg-white">REQ-000</span>
        <span id="drawer-priority-badge" class="px-2.5 py-1 bg-rose-100 text-rose-600 rounded-md font-bold text-xs capitalize">High</span>
        
        <span class="px-2.5 py-1 bg-orange-100 text-orange-600 rounded-md font-bold text-xs flex items-center space-x-1">
          <span class="w-1.5 h-1.5 rounded-full bg-orange-500 inline-block"></span>
          <span>Revision Needed</span>
        </span>
      </div>
      <button onclick="closeDrawer()" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <div class="p-6 flex-1 overflow-y-auto space-y-5 bg-white">
      <div>
        <h2 id="drawer-item-title" class="text-xl font-extrabold text-gray-800 tracking-tight">Item Column Name</h2>
        <p id="drawer-meta-subtitle" class="text-xs text-gray-400 font-medium mt-1">Requestor Name · Assigned Dept · Target Brand</p>
      </div>

      <div class="grid grid-cols-5 gap-2 bg-white pt-1">
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Items</span>
          <span class="text-base font-extrabold text-gray-700">1</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Qty</span>
          <span id="drawer-metrics-qty" class="text-base font-extrabold text-gray-700">0</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total</span>
          <span id="drawer-metrics-total" class="text-base font-extrabold text-gray-700">0.00</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Submitted</span>
          <span id="drawer-metrics-submitted" class="text-xs font-extrabold text-gray-700 block mt-1">YYYY-MM-DD</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Delivery</span>
          <span id="drawer-metrics-delivery" class="text-xs font-extrabold text-gray-700 block mt-1">YYYY-MM-DD</span>
        </div>
      </div>

      <hr class="border-gray-200 my-4">

      <div class="bg-orange-50 border border-orange-400 rounded-xl p-4 flex items-start space-x-3.5">
        <div class="p-2 bg-white text-orange-500 rounded-lg border border-orange-200 shadow-xs mt-0.5">
          <i data-lucide="refresh-cw" class="w-5 h-5"></i>
        </div>
        <div>
          <h4 class="text-sm font-bold text-orange-800">Revision Needed Remarks</h4>
          <p id="drawer-manager-comment" class="text-xs text-orange-600 mt-0.5 font-medium leading-relaxed">No custom comments specified.</p>
        </div>
      </div>

      <div class="space-y-2">
        <h5 class="text-sm font-bold text-gray-500 tracking-wide">Items</h5>
        <div class="p-4 border border-gray-300 rounded-xl bg-white flex items-center justify-between shadow-xs">
          <div>
            <p id="drawer-card-item-name" class="text-sm font-extrabold text-gray-800">Dynamic Item Name Tag</p>
            <p id="drawer-card-brand-category" class="text-xs text-gray-400 font-semibold mt-0.5">Brand · Category Descriptor</p>
          </div>
          <div class="text-right">
            <p id="drawer-card-unit-price" class="text-sm font-extrabold text-gray-800">$0.00</p>
            <p id="drawer-card-calculation" class="text-[11px] text-gray-400 font-semibold mt-0.5">0 × $0.00</p>
          </div>
        </div>
      </div>

      <div class="p-4 border border-gray-300 bg-white rounded-xl flex items-center justify-between shadow-xs">
        <span class="text-sm font-extrabold text-gray-700">Total Estimated Budget</span>
        <span id="drawer-card-total-budget" class="text-base font-extrabold text-gray-800">$0.00</span>
      </div>

      <div class="space-y-2">
        <h5 class="text-sm font-bold text-gray-500 tracking-wide">Justification</h5>
        <div id="drawer-justification" class="w-full p-3 text-xs text-gray-600 border border-gray-300 rounded-xl bg-gray-50 min-h-11 whitespace-pre-wrap"></div>
      </div>
    </div>

    <div class="p-4 border-t border-gray-200 bg-white flex items-center justify-between px-6 shrink-0">
      <button onclick="closeDrawer()" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition px-2 py-2">
        Cancel
      </button>
      <button class="bg-orange-50 text-orange-600 border border-orange-200 font-bold text-xs px-6 py-2.5 rounded-full hover:bg-orange-100 transition shadow-xs">
        Edit Requisition
      </button>
    </div>

  </div>

  <script>
    lucide.createIcons();

    function openDrawer(button) {
      if (!button) return;

      const id = button.getAttribute('data-id');
      const priority = button.getAttribute('data-priority') || 'Low';
      const item_name = button.getAttribute('data-item_name') || 'N/A';
      const requestor = button.getAttribute('data-requestor') || 'Unknown';
      const dept = button.getAttribute('data-dept') || 'N/A';
      const brand = button.getAttribute('data-brand') || 'Generic';
      const category = button.getAttribute('data-category') || 'N/A';
      const qty = parseFloat(button.getAttribute('data-qty')) || 0;
      const price = parseFloat(button.getAttribute('data-price')) || 0;
      const created_at = button.getAttribute('data-created_at') || 'N/A';
      const manager_comment = button.getAttribute('data-manager_comment') || 'Please review information updates requested.';
      const justification = button.getAttribute('data-justification') || 'No custom justification notes attached.';

      const paddedId = 'REQ-' + id;
      const totalAmount = (qty * price).toFixed(2);

      document.getElementById('drawer-id-badge').innerText = paddedId;
      document.getElementById('drawer-priority-badge').innerText = priority;
      document.getElementById('drawer-item-title').innerText = item_name;
      document.getElementById('drawer-meta-subtitle').innerText = `${requestor} · ${dept} · ${brand}`;
      
      document.getElementById('drawer-metrics-qty').innerText = qty;
      document.getElementById('drawer-metrics-total').innerText = parseFloat(totalAmount).toLocaleString(undefined, {minimumFractionDigits: 2});
      document.getElementById('drawer-metrics-submitted').innerText = created_at;
      document.getElementById('drawer-metrics-delivery').innerText = created_at;

      document.getElementById('drawer-manager-comment').innerText = manager_comment;
      
      document.getElementById('drawer-card-item-name').innerText = item_name;
      document.getElementById('drawer-card-brand-category').innerText = `${brand} · ${category}`;
      document.getElementById('drawer-card-unit-price').innerText = '$' + price.toLocaleString(undefined, {minimumFractionDigits: 2});
      document.getElementById('drawer-card-calculation').innerText = `${qty} × $${price.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
      document.getElementById('drawer-card-total-budget').innerText = '$' + parseFloat(totalAmount).toLocaleString(undefined, {minimumFractionDigits: 2});
      
      document.getElementById('drawer-justification').innerText = justification;

      const drawer = document.getElementById('sideDrawer');
      const backdrop = document.getElementById('drawerBackdrop');
      
      backdrop.classList.remove('hidden');
      setTimeout(() => {
        drawer.classList.remove('translate-x-full');
      }, 20);
    }

    function closeDrawer() {
      const drawer = document.getElementById('sideDrawer');
      const backdrop = document.getElementById('drawerBackdrop');
      drawer.classList.add('translate-x-full');
      setTimeout(() => {
        backdrop.classList.add('hidden');
      }, 300);
    }
    
    function toggleDropdown() {
      const dropdown = document.getElementById('request-dropdown');
      const arrow = document.getElementById('dropdown-arrow');
      dropdown.classList.toggle('hidden');
      arrow.classList.toggle('rotate-180');
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

    // Optional: Close filter dropdown when clicking outside
    window.addEventListener('click', function(e) {
      const dropdown = document.getElementById('filter-dropdown');
      const filterBtn = dropdown.previousElementSibling;
      if (!dropdown.contains(e.target) && !filterBtn.contains(e.target)) {
        dropdown.classList.add('hidden');
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