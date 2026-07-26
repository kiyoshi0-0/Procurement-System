<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Procurement Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Force uniformity for all nav items */
        /* Force every icon into a perfectly aligned column */
        .nav-item i {
            display: inline-block;
            width: 1.5rem;
            /* Exactly 24px wide */
            text-align: center;
            font-size: 1.125rem;
            margin-right: 0.75rem;
            /* Spacing between icon and text */
        }

        /* Ensure the main container flexes correctly */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        /* Active State for Modules */
        .module-active {
            background-color: #10B981 !important;
            color: white !important;
        }

        .module-active i {
            color: white !important;
        }

        /* Ensures icon stays white */

        /* Active State for Submodules */
        .sub-active {
            background-color: #ecfdf5 !important;
            color: #10B981 !important;
            font-weight: 600;
        }

        .sub-dot-active {
            background-color: #10B981 !important;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between h-full">
            <div>
                <!-- Update this div to center the logo and text -->
                <div class="bg-[#10B981] p-5 flex items-center justify-center space-x-3 text-white">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    <span class="text-xl font-bold tracking-wide">Procurement</span>
                </div>
                
                <nav class="p-4 space-y-1">
                
                    <div class="space-y-1">
                        <div onclick="toggleMenu(this, 'dash-submenu')" 
                            class="nav-item {{ request()->routeIs('dashboard.*') ? 'module-active' : 'hover:bg-gray-50' }}">
                            <i class="fa-solid fa-gauge"></i>
                            <span class="font-medium">Dashboard</span>
                        </div>
                        <div id="dash-submenu" class="{{ request()->routeIs('dashboard.*') ? 'block' : 'hidden' }} pl-6 space-y-1 mt-1">
                            <a href="{{ route('dashboard.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('dashboard.index') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('dashboard.index') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('dashboard.generate') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('dashboard.generate') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('dashboard.generate') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Reports</span>
                            </a>
                        </div>
                    </div>

                    <!-- Request Module -->
                    <div class="space-y-1">
                        <div onclick="toggleMenu(this, 'req-submenu')" 
                            class="nav-item {{ request()->routeIs('requests.*') ? 'module-active' : 'hover:bg-gray-50' }}">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span class="font-medium">Request</span>
                        </div>
                        <div id="req-submenu" class="{{ request()->routeIs('requests.*') ? 'block' : 'hidden' }} pl-6 space-y-1 mt-1">
                            <!-- All Requests (Assuming route name is requests.index) -->
                            <a href="{{ route('requests.main') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('requests.main') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('requests.main') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>All</span>
                            </a>

                            <!-- Pending -->
                            <a href="{{ route('requests.pending') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('requests.pending') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('requests.pending') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Pending</span>
                            </a>

                            <!-- Approved -->
                            <a href="{{ route('requests.approved') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('requests.approved') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('requests.approved') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Approved</span>
                            </a>

                            <!-- Revision -->
                            <a href="{{ route('requests.revision') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('requests.revision') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('requests.revision') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Revision</span>
                            </a>

                            <!-- Rejected -->
                            <a href="{{ route('requests.rejected') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('requests.rejected') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('requests.rejected') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Rejected</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Supplier Management -->
                    <div class="space-y-1">
                        <!-- Apply this same structure to all main modules -->
                        <!-- Update the span for Supplier Management -->
                        <div class="nav-item {{ request()->routeIs('suppliers.*') ? 'module-active' : 'hover:bg-gray-50' }}" 
                            onclick="toggleMenu(this, 'supplier-submenu')">
                            <i class="fa-solid fa-user-gear"></i>
                            <!-- Added text-sm to shrink the text so it stays on one line -->
                            <span class="font-medium text-sm">Supplier Management</span>
                        </div>
                        <div id="supplier-submenu" class="{{ request()->routeIs('suppliers.*') ? '' : 'hidden' }} pl-6 space-y-1 mt-1">
                            <a href="{{ route('suppliers.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.index') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.index') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Supplier List</span>
                            </a>
                            <a href="{{ route('suppliers.create') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.create') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.create') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Add / Edit Supplier</span>
                            </a>
                            <a href="{{ route('suppliers.show', ['id' => 1]) }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.show') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.show') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Supplier Details</span>
                            </a>
                            @php
                                $supplierId = isset($supplier) ? $supplier->id : null;
                                $evaluationRoute = $supplierId ? route('suppliers.evaluation', $supplierId) : '#';
                                $evaluationClass = $supplierId ? 'text-gray-500 hover:text-gray-800' : 'text-gray-400 cursor-not-allowed';
                                $evaluationPointer = $supplierId ? '' : 'pointer-events-none';
                            @endphp
                            <a href="{{ $evaluationRoute }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.evaluation') ? 'sub-active' : $evaluationClass }} {{ $evaluationPointer }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.evaluation') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Supplier Evaluation</span>
                            </a>
                            <!-- <a href="{{ route('suppliers.history') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.history') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.history') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Purchase History</span>
                            </a> -->
                            <a href="{{ route('suppliers.contracts') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.contracts') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.contracts') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Contracts</span>
                            </a>
                            <a href="{{ route('suppliers.search') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.search') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.search') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Search & Filters</span>
                            </a>
                        </div>
                    </div>

                    <!-- Orders Module -->
                    <div class="space-y-1">
                        <div onclick="toggleMenu(this, 'orders-submenu')" 
                            class="nav-item {{ request()->routeIs('orders.*') ? 'module-active' : 'hover:bg-gray-50' }}">
                            <i class="fa-solid fa-box"></i>
                            <span class="font-medium">Orders</span>
                        </div>
                        <div id="orders-submenu" class="{{ request()->routeIs('orders.*') ? 'block' : 'hidden' }} pl-6 space-y-1 mt-1">
                            <a href="{{ route('orders.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('orders.list') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('orders.list') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Purchase Order List</span>
                            </a>
                            <a href="{{ route('orders.orderhistory') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('orders.orderhistory') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('orders.orderhistory') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>Purchase History</span>
                            </a>
                            <a href="{{ route('orders.history') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('orders.history') ? 'sub-active' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('orders.history') ? 'sub-dot-active' : 'bg-gray-300' }}"></span>
                                <span>History</span>
                            </a>
                        </div>
                    </div>

                    <!-- Receipt Module -->
                    <div class="space-y-1">
                        <div onclick="toggleMenu(this, 'receipt-submenu')" 
                            class="nav-item {{ request()->routeIs('receipts.*') ? 'module-active' : 'hover:bg-gray-50' }}">
                            <i class="fa-solid fa-receipt"></i>
                            <span class="font-medium">Receipt</span>
                        </div>
                        <div id="receipt-submenu" 
                            class="{{ request()->routeIs('receipts.*') ? 'block' : 'hidden' }} pl-6 space-y-1 mt-1">


                            <a href="{{ route('receipts.index') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm 
                            {{ request()->routeIs('receipts.index') ? 'text-blue-700 font-bold bg-blue-50' : 'text-gray-500 hover:text-gray-800' }}">
                                
                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span>Goods Receipt</span>

                            </a>


                            <a href="{{ route('receipts.delivery') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm 
                            {{ request()->routeIs('receipts.delivery') ? 'text-blue-700 font-bold bg-blue-50' : 'text-gray-500 hover:text-gray-800' }}">

                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span>Delivery Issues</span>

                            </a>


                            <a href="{{ route('receipts.threeway') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm 
                            {{ request()->routeIs('receipts.threeway') ? 'text-blue-700 font-bold bg-blue-50' : 'text-gray-500 hover:text-gray-800' }}">

                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span>3-Way Matching</span>

                            </a>


                            <a href="{{ route('receipts.payment') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm 
                            {{ request()->routeIs('receipts.payment') ? 'text-blue-700 font-bold bg-blue-50' : 'text-gray-500 hover:text-gray-800' }}">

                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span>Payment Validation</span>

                            </a>


                        </div>
                    </div>

                    <!-- Settings Module -->
                    <div class="space-y-1">
                        <a href="{{ route('settings.index') }}"
                            class="nav-item {{ request()->routeIs('settings.*') ? 'module-active' : 'hover:bg-gray-50' }}">
                            <i class="fa-solid fa-gear"></i>
                            <span class="font-medium">Settings</span>
                        </a>
                    </div>

                    <!-- Profile (Kept as a simple link) -->
                    <a href="#" class="nav-item flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-user text-lg w-6 text-center"></i>
                        <span class="font-medium">Profile</span>
                    </a>
                </nav>
            </div>

            <div class="p-4">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-[#10B981] mb-2 text-2xl"><i class="fa-solid fa-headset"></i></div>
                    <h4 class="font-semibold text-sm text-gray-800">Need Help?</h4>
                    <p class="text-xs text-gray-500 mt-1 mb-3 leading-relaxed">Contact our support team for assistance</p>
                    <button class="w-full bg-[#10B981] text-white py-2 px-4 rounded-lg font-medium text-sm hover:bg-emerald-600 transition">Contact Support</button>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                <div class="flex items-center space-x-4 flex-1 max-w-xl">
                    <button class="text-gray-500 hover:text-gray-700 lg:hidden"><i class="fa-solid fa-bars text-xl"></i></button>
                    <div class="relative w-full">
                        <input type="text" placeholder="Search suppliers, products, contracts..." class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        <i class="fa-solid fa-magnifying-glass absolute right-3 top-2.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 relative p-1"><i class="fa-regular fa-bell text-xl"></i><span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span></button>
                    <button class="text-gray-500 hover:text-gray-700 p-1"><i class="fa-regular fa-circle-question text-xl"></i></button>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div class="flex items-center space-x-3 cursor-pointer">
                        <div class="text-right hidden sm:block"><p class="text-sm font-semibold text-gray-800">Admin</p><p class="text-xs text-gray-400">Personnel only</p></div>
                        <img src="https://robohash.org/admin?set=set4&size=40x40" 
                            alt="Admin Profile" 
                            class="w-10 h-10 rounded-full object-cover border border-gray-200 bg-white">
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMenu(element, submenuId) {
            // Remove active state from all main items
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('module-active'));
            // Add active state to clicked item
            element.classList.add('module-active');

            // Toggle submenu
            const targetSubmenu = document.getElementById(submenuId);
            if (targetSubmenu) {
                const isHidden = targetSubmenu.classList.contains('hidden');
                document.querySelectorAll('[id$="-submenu"]').forEach(s => s.classList.add('hidden'));
                if (isHidden) targetSubmenu.classList.remove('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>