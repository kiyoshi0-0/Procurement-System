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
      <span class="text-3xl font-bold text-gray-800">{{ $allCount }}</span>
      <div class="p-1.5 bg-blue-50 text-blue-600 rounded-md">
        <i data-lucide="file-text" class="w-4 h-4"></i></div>
    </div>
    <p class="text-sm font-bold text-gray-700 mt-2">All</p>
    <p class="text-[11px] text-gray-400">Total requests</p>
  </button>

  <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
    <div class="flex justify-between items-start">
      <span class="text-3xl font-bold text-gray-800">{{ $pendingCount }}</span>
      <div class="p-1.5 bg-blue-50 text-blue-500 rounded-md"><i data-lucide="clock" class="w-4 h-4"></i></div>
    </div>
    <p class="text-sm font-bold text-gray-700 mt-2">Pending</p>
    <p class="text-[11px] text-gray-400">Awaiting Review</p>
  </button>

  <button class="bg-white p-4 rounded-xl border border-gray-200 text-left ring-2 ring-emerald-500 shadow-sm">
    <div class="flex justify-between items-start">
      <span class="text-3xl font-bold text-gray-800">{{ $approvedCount }}</span>
      <div class="p-1.5 bg-emerald-50 text-emerald-500 rounded-md"><i data-lucide="check-circle" class="w-4 h-4"></i></div>
    </div>
    <p class="text-sm font-bold text-gray-700 mt-2">Approved</p>
    <p class="text-[11px] text-gray-400">Ready for PO</p>
  </button>

  <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
    <div class="flex justify-between items-start">
      <span class="text-3xl font-bold text-gray-800">{{ $revisionCount }}</span>
      <div class="p-1.5 bg-orange-50 text-orange-500 rounded-md"><i data-lucide="refresh-cw" class="w-4 h-4"></i></div>
    </div>
    <p class="text-sm font-bold text-gray-700 mt-2">Revision</p>
    <p class="text-[11px] text-gray-400">Needs update</p>
  </button>

  <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm">
    <div class="flex justify-between items-start">
      <span class="text-3xl font-bold text-gray-800">{{ $rejectedCount }}</span>
      <div class="p-1.5 bg-rose-50 text-rose-500 rounded-md"><i data-lucide="x-circle" class="w-4 h-4"></i></div>
    </div>
    <p class="text-sm font-bold text-gray-700 mt-2">Rejected</p>
    <p class="text-[11px] text-gray-400">Not approved</p>
  </button>
  
</div>

<!-- Dynamic Loop Rows Content Section -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
          <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-[#1E3A8A]">Approved Request History</h3>
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
                @foreach($requests as $request)
                  @if(strtolower($request->status) === 'approved')
                    <tr id="row-req-{{ $request->id }}" class="hover:bg-gray-50">
                     <td class="p-4 font-bold text-gray-800">REQ-{{ $request->id }}</td>
                      <td class="p-4">{{ $request->dept }}</td>
                      <td class="p-4">
                        {{ $request->item_name }}
                        @if($request->qty > 1)
                          <span class="text-gray-400 font-normal"> × {{ $request->qty }}</span>
                        @endif
                      </td>
                      <td class="p-4">
                        @if(strtolower($request->priority) === 'high')
                          <span class="px-2.5 py-0.5 bg-rose-50 text-rose-500 rounded-full border border-rose-200 font-semibold text-[10px]">High</span>
                        @elseif(strtolower($request->priority) === 'med' || strtolower($request->priority) === 'medium')
                          <span class="px-2.5 py-0.5 bg-amber-50 text-amber-500 rounded-full border border-amber-200 font-semibold text-[10px]">Med</span>
                        @else
                          <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-500 rounded-full border border-emerald-200 font-semibold text-[10px]">Low</span>
                        @endif
                      </td>
                      <td class="p-4">{{ $request->created_at ? $request->created_at->format('Y-m-d') : '2024-10-29' }}</td>
                      <td class="p-4">{{ $request->requestor }}</td>
                      <td class="p-4">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200 font-semibold">Approved</span>
                      </td>
                      <td class="p-4 flex items-center justify-center space-x-4 text-gray-400">
                        <button data-request="{{ json_encode($request) }}" onclick="openDrawer(this)" class="hover:text-blue-500 transition-colors cursor-pointer">
                          <i data-lucide="eye" class="w-4 h-4"></i>
                      </button>
                        
                        <form action="{{ route('requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this approved request?');" class="inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="hover:text-rose-500 transition-colors cursor-pointer">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>


            </div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <div id="drawerBackdrop" class="fixed inset-0 bg-black/25 backdrop-blur-[1px] z-40 transition-opacity duration-300 hidden" onclick="closeDrawer()"></div>

  <div id="sideDrawer" class="fixed top-0 right-0 w-full max-w-145 h-full bg-white shadow-2xl z-50 flex flex-col justify-between border-l border-gray-200 transition-transform duration-300 ease-in-out transform translate-x-full">
    
    <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-white shrink-0">
      <div class="flex items-center space-x-2">
        <span id="modal-req-id" class="px-2.5 py-1 border border-gray-300 text-gray-500 font-bold rounded-md text-xs tracking-wide bg-white">REQ-000</span>
        <span id="modal-priority-badge" class="px-2.5 py-1 rounded-md font-bold text-xs">High</span>
        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-md font-bold text-xs flex items-center space-x-1">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 inline-block"></span>
          <span>Approved</span>
        </span>
        <span class="px-2 py-1 text-emerald-600 font-bold text-xs flex items-center space-x-1">
          <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
          <span>Authorized</span>
        </span>
      </div>
      <button onclick="closeDrawer()" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition cursor-pointer">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <div class="p-6 flex-1 overflow-y-auto space-y-5 bg-white">
      <div>
        <h2 id="modal-item-title" class="text-xl font-extrabold text-gray-800 tracking-tight">Item Title</h2>
        <p id="modal-sub-meta" class="text-xs text-gray-400 font-medium mt-1">Requestor · Department · Brand</p>
      </div>

      <div class="grid grid-cols-5 gap-2 bg-white pt-1">
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Items</span>
          <span class="text-base font-extrabold text-gray-700">1</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Qty</span>
          <span id="modal-stat-qty" class="text-base font-extrabold text-gray-700">0</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total</span>
          <span id="modal-stat-total" class="text-base font-extrabold text-gray-700">0.00</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Submitted</span>
          <span id="modal-stat-date" class="text-xs font-extrabold text-gray-700 block mt-1">0000-00-00</span>
        </div>
        <div class="bg-gray-100 p-2 rounded-xl text-center">
          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Delivery</span>
          <span class="text-xs font-extrabold text-gray-700 block mt-1">As Scheduled</span>
        </div>
      </div>

      <hr class="border-gray-200 my-4">

      <div class="bg-emerald-50 border border-emerald-400 rounded-xl p-4 flex items-start space-x-3.5">
        <div class="p-2 bg-white text-emerald-500 rounded-lg border border-emerald-200 shadow-xs mt-0.5">
          <i data-lucide="lock" class="w-5 h-5"></i>
        </div>
        <div>
          <h4 class="text-sm font-bold text-emerald-800">Purchase Fully Authorized</h4>
          <p class="text-xs text-emerald-600 mt-0.5 font-medium leading-relaxed">Approved through all required steps. PO may now be issued.</p>
        </div>
      </div>

      <div class="space-y-2">
        <h5 class="text-sm font-bold text-gray-500 tracking-wide">Items Breakdown</h5>
        <div class="p-4 border border-gray-300 rounded-xl bg-white flex items-center justify-between shadow-xs">
          <div>
            <p id="modal-breakdown-title" class="text-sm font-extrabold text-gray-800">Item Name</p>
            <p id="modal-breakdown-meta" class="text-xs text-gray-400 font-semibold mt-0.5">Brand · Category</p>
          </div>
          <div class="text-right">
            <p id="modal-breakdown-total" class="text-sm font-extrabold text-gray-800">$0.00</p>
            <p id="modal-breakdown-calc" class="text-[11px] text-gray-400 font-semibold mt-0.5">0 × $0.00</p>
          </div>
        </div>
      </div>

      <div class="p-4 border border-gray-300 bg-white rounded-xl flex items-center justify-between shadow-xs">
        <span class="text-sm font-extrabold text-gray-700">Total Estimated Budget</span>
        <span id="modal-grand-total" class="text-base font-extrabold text-gray-800">$0.00</span>
      </div>

      <div class="space-y-2">
        <h5 class="text-sm font-bold text-gray-500 tracking-wide">Remarks / Justification</h5>
        <div id="modal-remarks" class="w-full min-h-11 p-3 border border-gray-300 rounded-xl bg-gray-50 text-xs text-gray-600 font-medium">
          No remarks written.
        </div>
      </div>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function openDrawer(buttonElement) {
    // Read and parse the data string from the button element
    const request = JSON.parse(buttonElement.getAttribute('data-request'));
    if (!request) return;

      // Match display structural constraints (REQ-002 format)
     const formattedId = 'REQ-' + request.id;
      document.getElementById('modal-req-id').innerText = formattedId;

      // Handle Component Priorities Dynamically
      const priorityBadge = document.getElementById('modal-priority-badge');
      priorityBadge.innerText = request.priority.toUpperCase();
      priorityBadge.className = "px-2.5 py-1 rounded-md font-bold text-xs ";
      if(request.priority.toLowerCase() === 'high') {
         priorityBadge.classList.add('bg-rose-100', 'text-rose-600');
      } else if (request.priority.toLowerCase() === 'med' || request.priority.toLowerCase() === 'medium') {
         priorityBadge.classList.add('bg-amber-100', 'text-amber-600');
      } else {
         priorityBadge.classList.add('bg-emerald-100', 'text-emerald-600');
      }

      // Compute Total Calculations
      const itemPrice = parseFloat(request.price) || 0;
      const itemQty = parseInt(request.qty) || 1;
      const calculatedTotal = (itemPrice * itemQty).toFixed(2);
      
      // Map properties to components
      document.getElementById('modal-item-title').innerText = request.item_name;
      document.getElementById('modal-sub-meta').innerText = `${request.requestor} · ${request.dept} · ${request.brand || 'Generic'}`;
      
      document.getElementById('modal-stat-qty').innerText = itemQty;
      document.getElementById('modal-stat-total').innerText = calculatedTotal;
      document.getElementById('modal-stat-date').innerText = request.created_at ? request.created_at.substring(0, 10) : '2024-10-29';
      
      document.getElementById('modal-breakdown-title').innerText = request.item_name;
      document.getElementById('modal-breakdown-meta').innerText = `${request.brand || 'N/A'} · ${request.category || 'N/A'}`;
      document.getElementById('modal-breakdown-total').innerText = '$' + calculatedTotal;
      document.getElementById('modal-breakdown-calc').innerText = `${itemQty} × $${itemPrice.toFixed(2)}`;
      document.getElementById('modal-grand-total').innerText = '$' + calculatedTotal;

      // Display manager comment if set, fallback to requestor justification
      document.getElementById('modal-remarks').innerText = request.manager_comment || request.justification || 'No explicit tracking remarks noted.';

      // Transition elements layout
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