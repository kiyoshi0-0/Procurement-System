@extends('layouts.app')

@section('content')

      <main class="p-8 space-y-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Purchase Requisition & Approval</h1>
            <p class="text-xs text-gray-400 mt-0.5">Submit and track computer parts purchase requests</p>
          </div>
       
        </div>

        <!-- Dashboard Stats Row Layout -->
       
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

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02] shadow-sm ring-2 ring-blue-500">
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

          <button class="bg-white p-4 rounded-xl border border-gray-200 text-left transition hover:scale-[1.02]">
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
            <h3 class="text-lg font-bold text-[#1E3A8A]">Pending Request History</h3>
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
                  <th class="p-4 pl-6">Req. ID</th>
                  <th class="p-4">Department</th>
                  <th class="p-4">Items</th>
                  <th class="p-4">Priority</th>
                  <th class="p-4">Submitted</th>
                  <th class="p-4">Requestor</th>
                  <th class="p-4">Status</th>
                  <th class="p-4 text-center">Actions</th>
                </tr>
              </thead>
              <tbody id="request-table-rows" class="divide-y divide-gray-200 text-xs font-medium text-gray-600">
                @foreach($requests as $req)
                <tr id="row-req-{{ $req->id }}" data-status="{{ strtolower($req->status) }}" class="hover:bg-gray-50/50 transition">
                  <td class="p-4 pl-6 font-bold text-gray-900">REQ-{{ $req->id }}</td>
                  <td class="p-4 text-gray-500">{{ $req->department ?? $req->dept ?? 'N/A' }}</td>
                  <td class="p-4 text-gray-800">{{ $req->item_name }}</td>
                  <td class="p-4">
                    @php 
                      $prio = strtolower($req->priority ?? 'low');
                      $prioClasses = $prio === 'high' ? 'bg-red-50 border-red-200 text-red-500' : ($prio === 'medium' ? 'bg-amber-50 border-amber-200 text-amber-500' : 'bg-emerald-50 border-emerald-200 text-emerald-500');
                    @endphp
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $prioClasses }}">{{ ucfirst($prio) }}</span>
                  </td>
                  <td class="p-4 text-gray-400">{{ $req->created_at->format('Y-m-d') }}</td>
                  <td class="p-4 text-gray-500">{{ $req->requestor ?? 'Staff Member' }}</td>
                  <td class="p-4 dynamic-status-cell">
                    @php
                      $stat = strtolower($req->status);
                      $statClasses = $stat === 'approved' ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : ($stat === 'revision' ? 'border-amber-200 bg-amber-50 text-amber-600' : ($stat === 'rejected' ? 'border-rose-200 bg-rose-50 text-rose-600' : 'border-blue-200 bg-blue-50 text-blue-500'));
                    @endphp
                    <span class="status-pill-text px-2.5 py-0.5 rounded-full border font-bold text-[10px] uppercase tracking-wide {{ $statClasses }}">{{ $req->status }}</span>
                  </td>
                  <td class="p-4 text-center flex items-center justify-center space-x-2">
                    <button type="button" 
                            data-request="{{ json_encode([
                                'id' => $req->id,
                                'item_name' => $req->item_name,
                                'supplier' => $req->supplier ?? 'CDW Corp',
                                'requestor' => $req->requestor ?? 'Staff Member',
                                'dept' => $req->department ?? $req->dept ?? 'N/A',
                                'priority' => $req->priority ?? 'Low',
                                'qty' => $req->qty ?? 1,
                                'items_count' => $req->items_count ?? 1,
                                'total_estimated' => $req->total_estimated ?? $req->price ?? 0.00,
                                'item_price' => $req->price ?? $req->total_estimated ?? 0.00,
                                'estimated_delivery' => $req->estimated_delivery ?? $req->created_at->format('Y-m-d'),
                                'created_at' => $req->created_at->format('Y-m-d'),
                                'justification' => $req->justification,
                                'status' => $req->status,
                                'supporting_docs' => $req->supporting_docs ?? [] 
                            ]) }}"
                            onclick="prepareAndOpenDrawer(this)"
                            class="text-gray-400 hover:text-blue-700 cursor-pointer transition">
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                    <form action="{{ route('requests.destroy', $req->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this requisition request?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-gray-400 hover:text-red-700 p-1 text-sm"> <i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Create Request Modal (Multi-step Form) -->
  <div id="newRequestModal" class="fixed inset-0 bg-black/50 z-60 hidden items-center justify-center p-4">
    <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl w-full max-w-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
      @csrf
      <div class="p-6 border-b border-gray-100 bg-[#1E3A8A] text-white shrink-0">
        <div class="flex justify-between items-center mb-6">
          <div>
            <h2 class="text-xl font-bold" id="modal-title">New Purchase Request</h2>
            <p id="step-label" class="text-xs text-blue-200 mt-1">Step 1 of 4 — What do you need?</p>
          </div>
          <button type="button" onclick="closeNewRequestModal()" class="text-white/70 hover:text-white"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>

        <div class="flex items-center justify-between px-2 mb-6">
          <div id="line-0" class="flex-1 h-1 bg-blue-950"></div>
          <div id="step-1-indicator" class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-sm mx-2">1</div>
          <div id="line-1" class="flex-1 h-1 bg-blue-950 mx-2"></div>
          <div id="step-2-indicator" class="w-8 h-8 rounded-full bg-blue-800 text-blue-400 flex items-center justify-center font-bold text-sm mx-2">2</div>
          <div id="line-2" class="flex-1 h-1 bg-blue-950 mx-2"></div>
          <div id="step-3-indicator" class="w-8 h-8 rounded-full bg-blue-800 text-blue-400 flex items-center justify-center font-bold text-sm mx-2">3</div>
          <div id="line-3" class="flex-1 h-1 bg-blue-950 mx-2"></div>
          <div id="step-4-indicator" class="w-8 h-8 rounded-full bg-blue-800 text-blue-400 flex items-center justify-center font-bold text-sm mx-2">4</div>
        </div>
      </div>

      <div class="overflow-y-auto p-8 flex-1">
        <!-- Step 1 -->
        <div id="step-1-form" class="space-y-4">
          <div><label class="block text-sm font-semibold text-gray-700 mb-1">Employee Name *</label><input type="text" id="emp_name" name="emp_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
          <div><label class="block text-sm font-semibold text-gray-700 mb-1">Department *</label><select id="emp_dept" name="emp_dept" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Select Department</option>
            <option value="Finance">Finance & Accounting</option>
            <option value="HR">Human Resources (HR)</option>
            <option value="Sales">Sales & Customer Management</option>
            <option value="Supply">Supply Chain & Operations</option></select></div>
        </div>

        <!-- Step 2 -->
        <div id="step-2-form" class="hidden space-y-4">
          <div class="flex justify-between items-center mb-2"><h3 class="font-bold text-gray-800">Add the items you need</h3><button type="button" onclick="addItemRow()" class="text-sm bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg font-bold">+ Add Another Item</button></div>
          <div id="items-wrapper" class="space-y-4"></div>
          <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex justify-between items-center">
            <span class="text-sm font-bold text-blue-900">Total Estimated Price:</span>
            <span id="grand-total" class="text-xl font-black text-blue-900">₱0.00</span>
          </div>
        </div>

        <!-- Step 3 -->
        <div id="step-3-form" class="hidden space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Supplier *</label>
            <select name="supplier" id="supplier" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
              <option value="">Select a supplier</option>
              <option value="tech_hub">Tech Hub Solutions</option>
              <option value="global_office">Global Office Supplies</option>
              <option value="data_systems">Data Systems Inc.</option>
              <option value="prime_logistics">Prime Logistics Group</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Expected Delivery Date *</label>
            <input type="date" name="estimated_delivery" id="estimated_delivery" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Priority Level *</label>
            <div class="grid grid-cols-3 gap-3" id="priority-options">
              <input type="hidden" name="priority" id="hidden-priority" value="Low">
              <button type="button" onclick="selectPriority(this, 'Low')" class="py-2.5 rounded-lg border border-gray-200 bg-gray-100 text-gray-600 font-bold text-sm transition hover:bg-gray-200 ring-2 ring-blue-500">Low</button>
              <button type="button" onclick="selectPriority(this, 'Medium')" class="py-2.5 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-600 font-bold text-sm transition hover:bg-yellow-100">Medium</button>
              <button type="button" onclick="selectPriority(this, 'High')" class="py-2.5 rounded-lg border border-rose-200 bg-rose-50 text-rose-600 font-bold text-sm transition hover:bg-rose-100">High</button>
            </div>
          </div>
        </div>

        <!-- Step 4 -->
        <div id="step-4-form" class="hidden space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Why do you need this? *</label>
            <textarea rows="3" id="justification" name="justification" placeholder="Describe layout details..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none mb-4"></textarea>
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Supporting Documents / Quotation Layout</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition cursor-pointer relative bg-gray-50">
              <input type="file" name="supporting_doc" id="supporting_doc" class="absolute inset-0 opacity-0 cursor-pointer" onchange="handleFileSelected(this)">
              <div id="upload-placeholder" class="space-y-2">
                <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400"></i>
                <p class="text-xs font-medium text-gray-600">Click to upload or drag files here</p>
                <p class="text-[10px] text-gray-400">PDF, PNG, JPG layout up to 5MB</p>
              </div>
              <div id="file-badge-preview" class="hidden items-center justify-center space-x-2 bg-blue-50 text-blue-700 p-2 rounded-lg border border-blue-200 max-w-xs mx-auto">
                <i class="fa-solid fa-file-lines text-sm"></i>
                <span id="selected-file-name" class="text-xs truncate font-bold"></span>
                <button type="button" onclick="clearSelectedFile(event)" class="text-red-500 hover:text-red-700 ml-2"><i class="fa-solid fa-trash-can"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="p-6 border-t flex justify-end gap-3 shrink-0">
        <button type="button" id="back-btn" onclick="goBack()" class="hidden px-6 py-2 text-gray-600 font-medium">Back</button>
        <button type="button" id="submit-btn" onclick="handleContinue()" class="px-6 py-2 bg-[#1E3A8A] text-white rounded-lg font-medium">Continue</button>
      </div>
    </form>
  </div>


  <!-- Manager Evaluation Details Drawer/Modal Overlay -->
  <div id="drawerBackdrop" class="fixed inset-0 bg-black/40 backdrop-blur-[1px] z-40 transition-opacity duration-300 hidden" onclick="closeDetailsDrawer()"></div>

  <div id="detailsDrawer" class="fixed right-0 top-0 bottom-0 w-125 bg-white shadow-2xl border-l border-gray-200 z-50 flex flex-col justify-between transition-transform duration-300 ease-in-out transform translate-x-full overflow-hidden">
    
    <!-- Dynamic Header Area Container Layout -->
    <div class="p-5 border-b border-gray-100 shrink-0 relative bg-white">
      <div class="flex items-center space-x-2 mb-3">
        <span id="drawer-req-id" class="px-2 py-0.5 border border-gray-200 text-gray-500 bg-gray-50 rounded text-[10px] font-bold tracking-wide">REQ-012</span>
        <span id="drawer-priority-pill" class="px-2 py-0.5 rounded text-[10px] font-bold border bg-red-50 border-red-200 text-red-500">High</span>
        <span id="drawer-status-pill" class="px-2 py-0.5 text-[10px] font-bold rounded bg-blue-50 border-blue-200 text-blue-500 uppercase border">PENDING</span>
        <span id="drawer-auth-pill" class="text-[10px] font-bold text-red-500 flex items-center gap-1 ml-2">
          <i class="fa-solid fa-ban text-[9px]"></i> Not Yet Authorized
        </span>
      </div>
      
      <button onclick="closeDetailsDrawer()" class="absolute right-5 top-5 w-7 h-7 rounded-lg border border-gray-200 text-gray-400 hover:text-gray-600 flex items-center justify-center transition cursor-pointer">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>
      
      <h2 id="drawer-item-name" class="text-xl font-bold text-gray-900 leading-tight">adadada</h2>
      <p id="drawer-meta-subtext" class="text-xs text-gray-400 mt-0.5">Marcus Chen · Engineering · CDW Corp</p>
    </div>

    <!-- Scrollable Body Metrics Cards Box -->
    <div class="p-5 overflow-y-auto flex-1 space-y-5 bg-white text-xs">
      
      <!-- Upper dynamic Metrics Layout -->
      <div class="grid grid-cols-5 gap-1.5">
        <div class="bg-[#F8FAFC] border border-gray-100 p-2 rounded-lg text-center shadow-sm">
          <span class="block text-[9px] font-bold text-gray-400 uppercase">Items</span>
          <span id="box-items" class="text-sm font-black text-slate-700">1</span>
        </div>
        <div class="bg-[#F8FAFC] border border-gray-100 p-2 rounded-lg text-center shadow-sm">
          <span class="block text-[9px] font-bold text-gray-400 uppercase">Qty</span>
          <span id="box-qty" class="text-sm font-black text-slate-700">1</span>
        </div>
        <div class="bg-[#F8FAFC] border border-gray-100 p-2 rounded-lg text-center shadow-sm">
          <span class="block text-[9px] font-bold text-gray-400 uppercase">Total</span>
          <span id="box-total" class="text-sm font-black text-slate-700">329.00</span>
        </div>
        <div class="bg-[#F8FAFC] border border-gray-100 p-2 rounded-lg text-center shadow-sm">
          <span class="block text-[9px] font-bold text-gray-400 uppercase">Submitted</span>
          <span id="box-submitted" class="text-[10px] font-bold text-amber-600 leading-5 block truncate mt-0.5">2026-07-13</span>
        </div>
        <div class="bg-[#F8FAFC] border border-gray-100 p-2 rounded-lg text-center shadow-sm">
          <span class="block text-[9px] font-bold text-gray-400 uppercase">Delivery</span>
          <span id="box-delivery" class="text-[10px] font-bold text-amber-600 leading-5 block truncate mt-0.5">2026-07-13</span>
        </div>
      </div>

      <!-- DYNAMIC STATUS BANNER -->
      <div id="status-banner-desc" class="p-3.5 rounded-xl flex items-start space-x-2.5 border border-blue-200 bg-blue-50/50 text-blue-900 transition-all duration-200">
        <div id="banner-icon-container" class="mt-0.5 text-blue-600 text-xs">
          <i class="fa-solid fa-lock"></i>
        </div>
        <div>
          <h4 id="banner-title" class="text-xs font-bold">Purchase Not Yet Authorized</h4>
          <p id="banner-body" class="text-[11px] mt-0.5 text-blue-700/90 leading-relaxed">Awaiting Procurement Manager. No PO can be issued until all approvers sign off.</p>
        </div>
      </div>

      <!-- Items Specifications Box Layout -->
      <div>
        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Items</h3>
        <div class="border border-gray-200 rounded-lg p-3 bg-white flex justify-between items-center shadow-sm">
          <div>
            <p id="item-title-bold" class="text-xs font-bold text-gray-800">NVIDIA RTX 4080 GPU</p>
            <p id="item-sub-brand" class="text-[11px] text-gray-400 mt-0.5">NVIDIA · GPU</p>
          </div>
          <div class="text-right">
            <p id="item-price-bold" class="text-xs font-bold text-gray-800">$1,199.99</p>
            <p id="item-calc-qty" class="text-[11px] text-gray-400 mt-0.5">1 × $1,199.99</p>
          </div>
        </div>
        
        <div class="mt-1.5 border border-gray-200 rounded-lg p-3 bg-white flex justify-between items-center shadow-sm">
          <span class="text-xs font-bold text-gray-600">Total Estimated Price</span>
          <span id="item-grand-total" class="text-xs font-bold text-gray-900">$1,199.99</span>
        </div>
      </div>

      <!-- Remarks/Justification Box Display Layout Area -->
      <div>
        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Remarks</h3>
        <div id="drawer-justification" class="border border-gray-200 bg-gray-50/50 rounded-lg p-3 text-xs text-gray-600 min-h-10 leading-relaxed shadow-sm"></div>
      </div>

      <!-- Attached Files Layout Lists Module -->
      <div>
        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Supporting Documents</h3>
        <div id="drawer-files-container" class="space-y-1.5"></div>
        <p id="no-docs-msg" class="text-[11px] italic text-gray-400 pl-0.5">No files attached.</p>
      </div>
    </div>

    <!-- Scaled Down Action Dashboard Footer Area -->
    <div class="p-4 border-t border-gray-200 bg-white space-y-3 shrink-0">
      <div>
        <label class="text-xs font-bold text-gray-700">Your Decision as <span class="text-[#1E3A8A] font-bold">Procurement Manager</span></label>
        <textarea id="decision-comment" oninput="handleCommentInput()" placeholder="Add a comment (optional)..." class="w-full mt-1.5 p-2 border border-gray-300 rounded-lg text-xs h-14 resize-none focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white text-gray-800 placeholder-gray-400 shadow-sm"></textarea>
      </div>

      <!-- Decision State Filter Button Row Layout Selection Grid -->
      <div class="grid grid-cols-3 gap-2">
        <button id="btn-approve" type="button" onclick="selectDecision('approved')" class="py-1.5 px-2 border border-emerald-500 bg-emerald-500 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer">
          <i class="fa-regular fa-circle-check text-[11px]"></i> Approved
        </button>
        <button id="btn-revision" type="button" onclick="selectDecision('revision')" class="py-1.5 px-2 border border-amber-500 bg-white text-amber-600 font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer hover:bg-amber-50">
          <i class="fa-solid fa-arrows-rotate text-[11px]"></i> Revision
        </button>
        <button id="btn-reject" type="button" onclick="selectDecision('rejected')" class="py-1.5 px-2 border border-rose-200 bg-rose-50 text-rose-600 font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer hover:bg-rose-100/50">
          <i class="fa-regular fa-circle-xmark text-[11px]"></i> Rejected
        </button>
      </div>

      <button id="btn-confirm-action" type="button" onclick="submitManagerDecision()" class="w-full py-2 bg-[#00A86B] text-white font-bold rounded-lg text-xs tracking-wide transition-all focus:outline-none shadow shadow-emerald-700/10 cursor-pointer">
        Confirm: Approved
      </button>
    </div>
  </div>

  <script>

   let activeDecision = null; 
    let activeRequestId = null;
    const itemsWrapper = document.getElementById('items-wrapper');
    window.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        refreshPendingCardCounter(); // Initialize dynamic sync count on launch
    });

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

    function updateStatusBannerAndPills(statusText) {
      const banner = document.getElementById('status-banner-desc');
      const iconWrap = document.getElementById('banner-icon-container');
      const title = document.getElementById('banner-title');
      const body = document.getElementById('banner-body');
      const statusPill = document.getElementById('drawer-status-pill');
      const authPill = document.getElementById('drawer-auth-pill');
      statusPill.innerText = statusText.toUpperCase();

      if(statusText === 'pending') {
        statusPill.className = "px-2 py-0.5 text-[10px] font-bold rounded bg-blue-50 border-blue-200 text-blue-500 uppercase border";
        authPill.className = "text-[10px] font-bold text-red-500 flex items-center gap-1 ml-2";
        banner.className = "p-3.5 rounded-xl flex items-start space-x-2.5 border border-blue-200 bg-blue-50/50 text-blue-900";
        iconWrap.innerHTML = `<i class="fa-solid fa-lock"></i>`;
        title.innerText = "Purchase Not Yet Authorized";
        body.innerText = "Awaiting Procurement Manager. No PO can be issued until all approvers sign off.";
      } else if(statusText === 'approved') {
        statusPill.className = "px-2 py-0.5 text-[10px] font-bold rounded bg-emerald-50 border-emerald-200 text-emerald-600 uppercase border";
        authPill.className = "text-[10px] font-bold text-emerald-600 flex items-center gap-1 ml-2";
        banner.className = "p-3.5 rounded-xl flex items-start space-x-2.5 border border-emerald-200 bg-emerald-50/50 text-emerald-900";
        iconWrap.innerHTML = `<i class="fa-regular fa-circle-check"></i>`;
        title.innerText = "Purchase Requisition Approved";
        body.innerText = "This procurement order query status has been checked and verified by the manager team layout.";
      } else if(statusText === 'revision') {
        statusPill.className = "px-2 py-0.5 text-[10px] font-bold rounded bg-amber-50 border-amber-200 text-amber-600 uppercase border";
        authPill.className = "text-[10px] font-bold text-amber-600 flex items-center gap-1 ml-2";
        banner.className = "p-3.5 rounded-xl flex items-start space-x-2.5 border border-amber-200 bg-amber-50/50 text-amber-900";
        iconWrap.innerHTML = `<i class="fa-solid fa-arrows-rotate"></i>`;
        title.innerText = "Returned for Layout Revision";
        body.innerText = "Document modifications requested. Feedback statement input comments are mandatory before re-evaluating.";
      } else if(statusText === 'rejected') {
        statusPill.className = "px-2 py-0.5 text-[10px] font-bold rounded bg-rose-50 border-rose-200 text-rose-600 uppercase border";
        authPill.className = "text-[10px] font-bold text-rose-600 flex items-center gap-1 ml-2";
        banner.className = "p-3.5 rounded-xl flex items-start space-x-2.5 border border-rose-200 bg-rose-50/50 text-rose-900";
        iconWrap.innerHTML = `<i class="fa-regular fa-circle-xmark"></i>`;
        title.innerText = "Requisition Request Denied";
        body.innerText = "The processing operation context has been canceled and marked permanently declined by procurement rules.";
      }
    }

    function selectDecision(decision) {
      activeDecision = decision;
      document.getElementById('btn-approve').className = "py-1.5 px-2 border border-emerald-500 bg-white text-emerald-600 font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer hover:bg-emerald-50/50";
      document.getElementById('btn-revision').className = "py-1.5 px-2 border border-amber-500 bg-white text-amber-600 font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer hover:bg-amber-50/50";
      document.getElementById('btn-reject').className = "py-1.5 px-2 border border-rose-200 bg-white text-rose-600 font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer hover:bg-rose-50";
      if (decision === 'approved') {
        document.getElementById('btn-approve').className = "py-1.5 px-2 border border-emerald-500 bg-emerald-500 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer shadow-sm";
      } else if (decision === 'revision') {
        document.getElementById('btn-revision').className = "py-1.5 px-2 border border-amber-500 bg-amber-500 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer shadow-sm";
      } else if (decision === 'rejected') {
        document.getElementById('btn-reject').className = "py-1.5 px-2 border border-rose-500 bg-rose-500 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-1 transition-all cursor-pointer shadow-sm";
      }

      updateStatusBannerAndPills(decision);
      validateDynamicConfirmationState();
    }

    function handleCommentInput() {
      validateDynamicConfirmationState();
    }

    function validateDynamicConfirmationState() {
      const commentText = document.getElementById('decision-comment').value.trim();
      const masterBtn = document.getElementById('btn-confirm-action');
      if (activeDecision === 'approved') {
        masterBtn.disabled = false;
        masterBtn.innerText = "Confirm: Approved";
        masterBtn.className = "w-full py-2 bg-[#00A86B] text-white font-bold rounded-lg text-xs transition-all focus:outline-none shadow cursor-pointer opacity-100";
      } else {
        if (commentText.length > 0) {
          masterBtn.disabled = false;
          if (activeDecision === 'revision') {
            masterBtn.innerText = "Confirm: Revision";
            masterBtn.className = "w-full py-2 bg-amber-500 text-white font-bold rounded-lg text-xs transition-all focus:outline-none shadow cursor-pointer opacity-100";
          } else {
            masterBtn.innerText = "Confirm: Rejected";
            masterBtn.className = "w-full py-2 bg-rose-500 text-white font-bold rounded-lg text-xs transition-all focus:outline-none shadow cursor-pointer opacity-100";
          }
        } else {
          masterBtn.disabled = true;
          if(activeDecision === 'revision') {
            masterBtn.innerText = "Confirm: Revision (Comment Required)";
          } else {
            masterBtn.innerText = "Confirm: Rejected (Comment Required)";
          }
          masterBtn.className = "w-full py-2 bg-gray-200 text-gray-400 font-bold rounded-lg text-xs transition-all cursor-not-allowed opacity-70";
        }
      }
    }

    function submitManagerDecision() {
      const commentText = document.getElementById('decision-comment').value.trim();
      
      // Mandatory ang comment kapag 'revision' o 'rejected'
      if ((activeDecision === 'revision' || activeDecision === 'rejected') && commentText.length === 0) {
        alert("Please provide a comment before confirming.");
        return;
      }
      
      // I-disable muna natin ang button para maiwasan ang double-click habang naglo-load
      const masterBtn = document.getElementById('btn-confirm-action');
      if(masterBtn) masterBtn.disabled = true;

      // IPADALA NA ANG DATA SA LARAVEL CONTROLLER VIA AJAX FETCH
      const baseUrl = "{{ url('') }}";
      fetch(`${baseUrl}/requests/${activeRequestId}/update-status`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Siguraduhing tama ang blade syntax mo rito
        },
        body: JSON.stringify({ 
          status: activeDecision, 
          comment: commentText 
        })
      })
      .then(res => res.json())
      .then(data => {
        if(data.success) {
          // Kapag matagumpay na pumasok sa database, i-update ang UI row
          const targetRow = document.getElementById(`row-req-${activeRequestId}`);
          if(targetRow) {
            targetRow.setAttribute('data-status', activeDecision);
            
            // I-update ang status pill cell
            const cell = targetRow.querySelector('.dynamic-status-cell');
            if(cell) {
              const colors = {
                'approved': 'border-emerald-200 bg-emerald-50 text-emerald-600',
                'revision': 'border-amber-200 bg-amber-50 text-amber-600',
                'rejected': 'border-rose-200 bg-rose-50 text-rose-600'
              };
              cell.innerHTML = `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border ${colors[activeDecision]} uppercase tracking-wide">${activeDecision}</span>`;
            }

            // I-update din ang data-request object ng eye button para kung sakaling buksan ulit, updated na ang status nito
            const eyeBtn = targetRow.querySelector('button[onclick="prepareAndOpenDrawer(this)"]');
            if(eyeBtn) {
              let currentData = JSON.parse(eyeBtn.getAttribute('data-request'));
              currentData.status = activeDecision;
              currentData.manager_comment = commentText; // Kasama na ang comment!
              eyeBtn.setAttribute('data-request', JSON.stringify(currentData));
            }
          }
          
          // Mag-refresh ng browser para makita ang counter updates (Opsyonal, pero pinakasigurado)
          window.location.reload();
        } else {
          alert("Nagkaroon ng problema: " + data.message);
          if(masterBtn) masterBtn.disabled = false;
        }
      })
      .catch(err => {
        console.error("Database connection error: ", err);
        alert("Hindi makakonekta sa server. Pakisuri kung umaandar ang iyong server o tama ang iyong Route.");
        if(masterBtn) masterBtn.disabled = false;
      });
    }

    function closeDetailsDrawer() {
      document.getElementById('detailsDrawer').classList.add('translate-x-full');
      setTimeout(() => {
        document.getElementById('drawerBackdrop').classList.add('hidden');
      }, 300);
    }
    
    function refreshPendingCardCounter() {
      const counterEl = document.getElementById('pending-counter-card');
      if (counterEl) {
        const pendingCount = document.querySelectorAll('#request-table-rows tr[data-status="pending"]').length;
        counterEl.innerText = pendingCount;
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
      const rows = tbody.querySelectorAll('tr');
      const normalizedQuery = query.trim().toLowerCase();

      rows.forEach(row => {
        const rowText = row.innerText.toLowerCase();
        row.style.display = rowText.includes(normalizedQuery) ? '' : 'none';
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
  <script>lucide.createIcons();</script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
@endsection