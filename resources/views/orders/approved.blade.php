<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procurement Dashboard - Approved Requests</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-hidden">

  <div class="flex h-screen overflow-hidden">
    
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shrink-0 h-full">
      <div class="bg-[#00A86B] p-4 flex items-center space-x-2 text-white font-bold text-xl shrink-0">
        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
        <span>Procurement</span>
      </div>

      <div class="flex-1 overflow-y-auto flex flex-col justify-between">
        <nav class="p-4 space-y-1">
          <a href="#" class="w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition block">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
          </a>
         
          <div>
            <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg bg-[#00A86B] text-white text-sm font-medium transition">
              <div class="flex items-center space-x-3">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span>Request</span>
              </div>
              <i id="dropdown-arrow" data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"></i>
            </button>
            
            <div id="request-dropdown" class="mt-1 ml-4 pl-2 border-l border-gray-200 space-y-1">
              <a href="{{ route('requests.main') }}" class="w-full flex items-center space-x-2 px-3 py-1.5 rounded-md text-xs {{ request()->routeIs('requests.main') ? 'bg-[#E6F6F0] text-[#00A86B] font-semibold' : 'text-gray-500 hover:bg-gray-50 font-medium' }} transition block">
                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('requests.main') ? 'bg-[#00A86B]' : 'bg-gray-300' }}"></span>
                <span>All Request</span>
              </a>
              <a href="{{ route('requests.pending') }}" class="w-full flex items-center space-x-2 px-3 py-1.5 rounded-md text-xs {{ request()->routeIs('requests.pending') ? 'bg-[#E6F6F0] text-[#00A86B] font-semibold' : 'text-gray-500 hover:bg-gray-50 font-medium' }} transition block">
                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('requests.pending') ? 'bg-[#00A86B]' : 'bg-gray-300' }}"></span>
                <span>Pending</span>
              </a>
              <a href="{{ route('requests.approved') }}" class="w-full flex items-center space-x-2 px-3 py-1.5 rounded-md text-xs {{ request()->routeIs('requests.approved') ? 'bg-[#E6F6F0] text-[#00A86B] font-semibold' : 'text-gray-500 hover:bg-gray-50 font-medium' }} transition block">
                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('requests.approved') ? 'bg-[#00A86B]' : 'bg-gray-300' }}"></span>
                <span>Approved</span>
              </a>
              <a href="{{ route('requests.revision') }}" class="w-full flex items-center space-x-2 px-3 py-1.5 rounded-md text-xs {{ request()->routeIs('requests.revision') ? 'bg-[#E6F6F0] text-[#00A86B] font-semibold' : 'text-gray-500 hover:bg-gray-50 font-medium' }} transition block">
                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('requests.revision') ? 'bg-[#00A86B]' : 'bg-gray-300' }}"></span>
                <span>Revision</span>
              </a>
              <a href="{{ route('requests.rejected') }}" class="w-full flex items-center space-x-2 px-3 py-1.5 rounded-md text-xs {{ request()->routeIs('requests.rejected') ? 'bg-[#E6F6F0] text-[#00A86B] font-semibold' : 'text-gray-500 hover:bg-gray-50 font-medium' }} transition block">
                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('requests.rejected') ? 'bg-[#00A86B]' : 'bg-gray-300' }}"></span>
                <span>Rejected</span>
              </a>
            </div>
          </div>

          <a href="#" class="w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition block">
            <i data-lucide="users" class="w-5 h-5"></i>
            <span>Supplier Management</span>
          </a>
          <a href="#" class="w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition block">
            <i data-lucide="package" class="w-5 h-5"></i>
            <span>Orders</span>
          </a>
          <a href="#" class="w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition block">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Receipt</span>
          </a>
          <a href="#" class="w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition block">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span>Settings</span>
          </a>
          <a href="#" class="w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition block">
            <i data-lucide="user" class="w-5 h-5"></i>
            <span>Profile</span>
          </a>
        </nav>

        <div class="p-4 bg-white border-t border-gray-200 flex flex-col items-center shrink-0">
          <div class="bg-gray-100 rounded-xl p-4 border border-gray-200 text-center flex flex-col items-center w-full">
            <i data-lucide="headset" class="w-8 h-8 text-[#00A86B] mb-2"></i>
            <h4 class="text-sm font-semibold text-gray-700">Need Help?</h4>
            <p class="text-[11px] text-gray-500 mt-1 mb-3">Contact our support team for assistance</p>
            <button class="w-full bg-[#00A86B] text-white text-xs font-semibold py-2 rounded-lg hover:bg-[#00945B] transition">
              Contact Support
            </button>
          </div>
        </div>
      </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-y-auto">
      
      <header class="h-16 bg-white border-b border-gray-200 px-8 flex items-center justify-between shrink-0">
        <div class="flex items-center space-x-4 w-1/3">
          <i data-lucide="menu" class="w-5 h-5 text-gray-500 cursor-pointer"></i>
          <div class="relative w-full">
            <input type="text" placeholder="Search suppliers, products, contracts..." class="w-full pl-4 pr-10 py-1.5 bg-gray-50 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-[#00A86B]">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute right-3 top-2.5"></i>
          </div>
        </div>

        <div class="flex items-center space-x-6">
          <i data-lucide="bell" class="w-5 h-5 text-gray-500 cursor-pointer"></i>
          <i data-lucide="help-circle" class="w-5 h-5 text-gray-500 cursor-pointer"></i>
          <div class="flex items-center space-x-2">
            <div class="text-right">
              <p class="text-xs font-bold text-gray-700">Ira Rojas</p>
              <p class="text-[10px] text-gray-400">Member 1</p>
            </div>
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Avatar" class="w-8 h-8 rounded-full border border-gray-300 object-cover">
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
          </div>
        </div>
      </header>

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
      <div class="p-1.5 bg-blue-50 text-blue-600 rounded-md"><i data-lucide="file-text" class="w-4 h-4"></i></div>
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

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
          <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-[#1E3A8A]">Approved Request History</h3>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
              <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Search Request..." class="w-full pl-8 pr-4 py-1.5 bg-white border border-gray-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-[#00A86B]">
                <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5"></i>
              </div>
              <button class="flex items-center space-x-1.5 border border-gray-300 rounded-md px-3 py-1.5 text-xs text-gray-600 bg-white hover:bg-gray-50">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
              </button>
              <button class="flex items-center space-x-1.5 border border-gray-300 rounded-md px-3 py-1.5 text-xs text-gray-600 bg-white hover:bg-gray-50">
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
                @foreach($requests as $request)
                  @if(strtolower($request->status) === 'approved')
                    <tr class="hover:bg-gray-50">
                      <td class="p-4 font-bold text-gray-800">REQ-{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}</td>
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

          <div class="p-4 bg-white border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 gap-4">
            <div>Showing filtered approved request list entries.</div>
            <div class="flex items-center space-x-1">
              <button class="p-1 border border-gray-200 rounded text-gray-400 hover:bg-gray-50 disabled:opacity-50" disabled>
                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
              </button>
              <button class="px-2.5 py-1 rounded bg-[#1E3A8A] text-white font-semibold">1</button>
              <button class="p-1 border border-gray-200 rounded text-gray-600 hover:bg-gray-50">
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
              </button>
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
      const formattedId = 'REQ-' + String(request.id).padStart(3, '0');
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
  </script>
</body>
</html>