<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Procurement Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between h-full">
            <div>
                <!-- Logo -->
                <div class="bg-[#10B981] p-5 flex items-center space-x-3 text-white">
                    <i class="fa-solid fa-cart-shopping-fast text-2xl"></i>
                    <span class="text-xl font-bold tracking-wide">Procurement</span>
                </div>
                
                <!-- Nav Links -->
                <nav class="p-4 space-y-1">
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-grid-2 text-lg w-6"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-file-invoice text-lg w-6"></i>
                        <span class="font-medium">Request</span>
                    </a>
                    
                    <!-- Active/Dropdown Track -->
                    <div class="space-y-1">
                        <a href="#" class="flex items-center space-x-3 px-4 py-3 bg-[#10B981] text-white rounded-lg transition">
                            <i class="fa-solid fa-user-gear text-lg w-6"></i>
                            <span class="font-medium">Supplier Management</span>
                        </a>
                        <div class="pl-6 space-y-1 mt-1">
                            <!-- Supplier List Link -->
                            <a href="{{ route('suppliers.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.index') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.index') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                <span>Supplier List</span>
                            </a>

                            <!-- Add / Edit Supplier Link -->
                            <a href="{{ route('suppliers.create') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.create') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.create') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                <span>Add / Edit Supplier</span>
                            </a>

                            <!-- Supplier Details Link -->
                            <a href="{{ route('suppliers.show', ['id' => 1]) }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.show') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.show') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                <span>Supplier Details</span>
                            </a>

                            <!-- Supplier Evaluation Link -->
                            <a href="{{ isset($supplier) ? route('suppliers.evaluation', $supplier->id ?? $supplier['id']) : '#' }}" 
                            class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm transition 
                            {{ request()->routeIs('suppliers.evaluation') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                
                                <!-- The icon dot -->
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.evaluation') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                
                                <!-- The label -->
                                <span>Supplier Evaluation</span>
                            </a>

                            <!-- Purchase History Link -->
                            <a href="{{ route('suppliers.history') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.history') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.history') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                <span>Purchase History</span>
                            </a>

                            <!-- Contracts Link -->
                            <a href="{{ route('suppliers.contracts') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.contracts') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.contracts') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                <span>Contracts</span>
                            </a>

                            <!-- Search Links -->
                            <a href="{{ route('suppliers.search') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md text-sm {{ request()->routeIs('suppliers.search') ? 'bg-emerald-50 text-[#10B981] font-semibold' : 'text-gray-500 hover:text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('suppliers.search') ? 'bg-[#10B981]' : 'bg-gray-300' }}"></span>
                                <span>Search & Filters</span>
                            </a>
                        </div>
                    </div>

                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-box text-lg w-6"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-receipt text-lg w-6"></i>
                        <span class="font-medium">Receipt</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-gear text-lg w-6"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                        <i class="fa-solid fa-user text-lg w-6"></i>
                        <span class="font-medium">Profile</span>
                    </a>
                </nav>
            </div>

            <!-- Need Help Box -->
            <div class="p-4">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-[#10B981] mb-2 text-2xl">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="font-semibold text-sm text-gray-800">Need Help?</h4>
                    <p class="text-xs text-gray-500 mt-1 mb-3 leading-relaxed">Contact our support team for assistance</p>
                    <button class="w-full bg-[#10B981] text-white py-2 px-4 rounded-lg font-medium text-sm hover:bg-emerald-600 transition">
                        Contact Support
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                <div class="flex items-center space-x-4 flex-1 max-w-xl">
                    <button class="text-gray-500 hover:text-gray-700 lg:hidden">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div class="relative w-full">
                        <input type="text" placeholder="Search suppliers, products, contracts..." class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                        <i class="fa-solid fa-magnifying-glass absolute right-3 top-2.5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Right Side User Menu -->
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 relative p-1">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <button class="text-gray-500 hover:text-gray-700 p-1">
                        <i class="fa-regular fa-circle-question text-xl"></i>
                    </button>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div class="flex items-center space-x-3 cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-gray-800">John Mark</p>
                            <p class="text-xs text-gray-400">Member 2</p>
                        </div>
                        <img src="https://placekitten.com/40/40" alt="User Profile" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                        <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
                    </div>
                </div>
            </header>

            <!-- Page Content View Injection -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>