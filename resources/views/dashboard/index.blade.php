@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-6xl font-bold text-gray-900">Dashboard</h1>
        <div class="flex items-center pl-1 space-x-3 text-sm text-gray-500 mt-1">
            <span>See what's happening today</span>
        </div>
    </div>

    <!-- GRID BLOCK ONE: METRIC SUMMARY SCORECARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1: Pending Request -->
        <div class="bg-bg-cardGreen rounded-2xl p-5 shadow-md flex items-start space-x-4 border border-gray-200/40 relative">
            <div class="bg-[#789613]/20 p-3 rounded-xl text-[#627D08]">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-900 tracking-wide">Pending Request</p>
                <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $pendingRequestsCount }}</p>
            </div>
        </div>

        <!-- Card 2: Active Supplier -->
        <div class="bg-bg-cardLightGreen rounded-2xl p-5 shadow-md flex items-start space-x-4 border border-gray-200/40">
            <div class="bg-[#15803D]/20 p-3 rounded-xl text-[#15803D]">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-900 tracking-wide">Active Supplier</p>
                <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $activeSuppliersCount }}</p>
            </div>
        </div>

        <!-- Card 3: Purchase Orders -->
        <div class="bg-bg-cardBeige rounded-2xl p-5 shadow-md flex items-start space-x-4 border border-gray-200/40">
            <div class="bg-[#855D0A]/20 p-3 rounded-xl text-[#855D0A]">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-900 tracking-wide">Purchase Orders</p>
                <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $purchaseOrdersCount }}</p>
            </div>
        </div>

        <!-- Card 4: Total Spending -->
        <div class="bg-[#FCE2D6] rounded-3xl p-5 shadow-md flex items-start space-x-4 border border-gray-200/20">
            <div class="bg-[#EBC3B2] p-4 rounded-[20px] text-[#A73B11] flex items-center justify-center shrink-0 mt-1">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <div class="flex flex-col justify-start pt-1.5 leading-none">
                <span class="text-[15px] font-extrabold text-[#0F172A] tracking-tight">Total Spending</span>
                <div class="flex items-baseline space-x-1.5 mt-1">
                    <span class="text-[20px] font-black text-[#0F172A] tracking-tight uppercase">PHP</span>
                    <span class="text-[20px] font-black text-[#0F172A] tracking-tight">{{ number_format($totalSpending, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID BLOCK TWO: INFOGRAPHICS AND TIMELINES -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 lg:col-span-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900">Purchase Request Trend</h3>
            </div>
            <div class="flex items-center space-x-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-blue-600 inline-block"></span>
                <span class="text-xs font-semibold text-gray-600">Request</span>
            </div>
            <div class="h-44 w-full relative">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Pie Graph: Purchase Order Status -->
        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 lg:col-span-4 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-bold text-gray-900">Purchase Status</h3>
            </div>
            <div class="flex items-center h-full">
                <!-- Custom Left Legends -->
                <div class="space-y-3 w-1/2 pr-2">
                    <div class="flex items-center space-x-3">
                        <span class="w-4 h-4 rounded-full bg-chart-delivered inline-block"></span>
                        <span class="text-xs font-bold text-gray-800">Delivered</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-4 h-4 rounded-full bg-chart-pending inline-block"></span>
                        <span class="text-xs font-bold text-gray-800">Pending</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-4 h-4 rounded-full bg-chart-cancelled inline-block"></span>
                        <span class="text-xs font-bold text-gray-800">Cancelled</span>
                    </div>
                </div>
                <div class="w-1/2 h-36 relative flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Vertical Feed List: Recent Activity -->
        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 lg:col-span-3 flex flex-col">
            <h3 class="text-base font-bold text-gray-900 mb-5">Recent Activity</h3>
            <div class="relative border-l-2 border-brand-green ml-16 space-y-5 flex-1 max-h-47.5 pr-1">
                <div class="relative pl-6">
                    <span class="absolute -left-1.75 top-1 bg-brand-green w-3 h-3 rounded-full ring-4 ring-white"></span>
                    <span class="absolute -left-14 top-0.5 text-[11px] font-bold text-gray-500">{{ now()->format('H:i') }}</span>
                    <h4 class="text-xs font-bold text-gray-900 leading-tight">System Synchronized</h4>
                    <p class="text-[10px] text-gray-400 font-medium">Dashboard Active</p>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID BLOCK THREE: MASTER DATA TABLE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="bg-white rounded-2xl p-4 shadow-md border border-gray-100 lg:col-span-9 overflow-hidden">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Latest Purchase Orders</h3>
                <a href="{{ route('suppliers.history') }}" class="text-xs font-bold text-gray-400 hover:text-brand-green transition-colors">view all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-bold text-gray-900 border-b border-gray-100">
                            <th class="pb-3 font-bold text-center">PO Number</th>
                            <th class="pb-3 font-bold pl-4">Item / Supplier</th>
                            <th class="pb-3 font-bold text-center">Amount</th>
                            <th class="pb-3 font-bold text-center">Status</th>
                            <th class="pb-3 font-bold text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-800">
                        @forelse($latestOrders as $order)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-3 text-center font-medium">{{ $order->po_number }}</td>
                            <td class="py-3 pl-4 font-medium">
                                <span class="font-bold text-gray-900 block">{{ $order->item_name }}</span>
                                <span class="text-xs text-gray-500">{{ $order->supplier->name ?? 'Unknown Supplier' }}</span>
                            </td>
                            <td class="py-3 text-center font-medium">₱{{ number_format($order->total_price, 2) }}</td>
                            <td class="py-3 text-center font-medium text-gray-900">
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 font-bold rounded text-[10px] uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-3 text-center text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">No purchase records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Vertical Module Actions Blocks -->
        <div class="lg:col-span-3 flex flex-col gap-5">
            <a href="{{ route('orders.create') }}"
                class="w-full bg-bg-actionBlue hover:bg-bg-actionBlueHover text-slate-900 font-bold py-4 px-5 rounded-2xl flex items-center space-x-4 transition-all transform active:scale-[0.99] shadow-sm group">
                <div class="bg-white/40 p-2 rounded-xl text-slate-800 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <span class="text-[17px] tracking-tight">Create Order</span>
            </a>

            <a href="{{ route('suppliers.create') }}"
                class="w-full bg-bg-actionBlue hover:bg-bg-actionBlueHover text-slate-900 font-bold py-4 px-5 rounded-2xl flex items-center space-x-4 transition-all transform active:scale-[0.99] shadow-sm group">
                <div class="bg-white/40 p-2 rounded-xl text-slate-800 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="text-[17px] tracking-tight">New Supplier</span>
            </a>

            <a href="{{ route('receipts.index') }}"
                class="w-full bg-bg-actionBlue hover:bg-bg-actionBlueHover text-slate-900 font-bold py-4 px-5 rounded-2xl flex items-center space-x-4 transition-all transform active:scale-[0.99] shadow-sm group">
                <div class="bg-white/40 p-2 rounded-xl text-slate-800 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-[17px] tracking-tight">Goods Receipt</span>
            </a>

            <a href="{{ route('dashboard.generate') }}"
                class="w-full bg-bg-actionBlue hover:bg-bg-actionBlueHover text-slate-900 font-bold py-4 px-5 rounded-2xl flex items-center space-x-4 transition-all transform active:scale-[0.99] shadow-sm group">
                <div class="bg-white/40 p-2 rounded-xl text-slate-800 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="text-[17px] tracking-tight">Generate Report</span>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Tailwind CSS CDN (Loaded First) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js CDN (Loaded Second) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            green: '#00B67A',
                            dark: '#0F172A'
                        },
                        bg: {
                            main: '#DBDBDB',
                            sidebar: '#FFFFFF',
                            cardGreen: '#E9EFC0',
                            cardLightGreen: '#DCFCE7',
                            cardBeige: '#F1E4CE',
                            cardPeach: '#FCE2D6',
                            actionBlue: '#A2C2E8',
                            actionBlueHover: '#8EB5E0',
                            actionSlate: '#B5C4D4',
                            actionSlateHover: '#9FAFC0'
                        },
                        chart: {
                            delivered: '#727CA3',
                            pending: '#AAB06C',
                            cancelled: '#B44A4A'
                        }
                    },
                }
            }
        }

        // Toggle Global Layout Profile UI Window Box Dropdowns
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const arrow = document.getElementById('profileArrow');
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                if (arrow) arrow.classList.add('rotate-180');
            } else {
                dropdown.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        }

        // Toggle Sidebar Dropdowns
        function toggleSubmenu(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside window space bounds
        window.addEventListener('click', function (e) {
            const container = document.getElementById('profileDropdownContainer');
            const dropdown = document.getElementById('profileDropdown');
            const arrow = document.getElementById('profileArrow');
            if (container && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });

        // Initialize Purchase Request Trend Line Chart Graphic Elements
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['Jun 1', 'Jun 5', 'Jun 10', 'Jun 15', 'Jun 20', 'Jun 25'],
                datasets: [{
                    label: 'Request',
                    data: [13, 8, 17, 13, 21, 21],
                    borderColor: '#2563EB',
                    backgroundColor: '#2563EB',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563EB',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#64748B' } },
                    y: { min: 0, max: 30, ticks: { stepSize: 5, font: { size: 9 }, color: '#64748B' }, grid: { color: '#F1F5F9' } }
                }
            }
        });

        // Initialize Purchase Order Status Pie Chart Graphic Elements
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: ['Delivered', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [71.43, 20.41, 8.16],
                    backgroundColor: ['#727CA3', '#AAB06C', '#B44A4A'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: (context) => ` ${context.label}: ${context.raw}%` }
                    }
                }
            }
        });
    </script>
@endpush