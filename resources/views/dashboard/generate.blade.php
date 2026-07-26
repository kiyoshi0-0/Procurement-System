@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-6xl font-bold text-gray-900 pb-3">Reports</h1>
            <div class="flex items-center space-x-3 pl-1 text-sm text-gray-500 mt-1">
                <a href="{{ route('dashboard.index') }}"><span>Dashboard</span></a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <b><span>Generate Reports</span></b>
            </div>
            <div class="flex items-center pl-1 space-x-3 text-sm text-gray-500 mt-1">
                <span>Generate and analyze procurement data and performance</span>
            </div>

        </div>

        <div class="flex items-center gap-3 self-end md:self-auto relative z-20">
            <div class="relative">
                <button onclick="toggleDropdown('dateDropdown')"
                    class="flex items-center gap-3 bg-white border border-slate-300 rounded-full px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                    <i class="fa-regular fa-calendar text-slate-500"></i>
                    <span id="selectedDateRange">June 01 - June 31</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                </button>
                <div id="dateDropdown"
                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2">
                    <button onclick="selectDateRange('June 01 - June 31')"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 text-slate-700 font-medium">June 01
                        - June 31</button>
                    <button onclick="selectDateRange('May 01 - May 31')"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 text-slate-700">May 01 - May
                        31</button>
                    <button onclick="selectDateRange('Last 90 Days')"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 text-slate-700">Last 90
                        Days</button>
                </div>
            </div>

            <button id="exportBtn" onclick="toggleExportModal(true)"
                class="bg-[#00B67A] hover:bg-[#009c68] text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-sm transition-all flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-download"></i>
                <span>Export</span>
            </button>
        </div>
    </div>

    <br>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#FCE7F3] rounded-2xl p-6 border border-pink-200/60 shadow-md flex items-start justify-between">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Spending</span>
                <h3 class="text-2xl font-bold text-slate-800">₱{{ number_format($totalSpending, 2) }}</h3>
                <p class="text-xs font-semibold text-rose-500 flex items-center gap-1">
                    <span>Live spend total</span>
                </p>
            </div>
            <div class="bg-[#EF4444] p-3 rounded-xl text-white shadow-inner">
                <i class="fa-solid fa-wallet text-lg"></i>
            </div>
        </div>

        <div class="bg-[#FEF3C7] rounded-2xl p-6 border border-amber-200/60 shadow-md flex items-start justify-between">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Purchase Orders</span>
                <h3 class="text-2xl font-bold text-slate-800">{{ $purchaseOrdersCount }}</h3>
                <p class="text-xs font-semibold text-[#0284C7] flex items-center gap-1">
                    <span>Live PO count</span>
                </p>
            </div>
            <div class="bg-[#D97706] p-3 rounded-xl text-white shadow-inner">
                <i class="fa-solid fa-cart-flatbed text-lg"></i>
            </div>
        </div>

        <div class="bg-[#F3E8FF] rounded-2xl p-6 border border-purple-200/60 shadow-md flex items-start justify-between">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Invoices Matched</span>
                <h3 class="text-2xl font-bold text-slate-800">{{ $invoicesMatched }}</h3>
                <p class="text-xs font-medium text-[#2563EB] bg-blue-50 px-2 py-0.5 rounded-md inline-block">
                    Live match total
                </p>
            </div>
            <div class="bg-[#8B5CF6] p-3 rounded-xl text-white shadow-inner">
                <i class="fa-solid fa-receipt text-lg"></i>
            </div>
        </div>

        <div class="bg-[#DCFCE7] rounded-2xl p-6 border border-emerald-200/60 shadow-md flex items-start justify-between">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Department Count</span>
                <h3 class="text-2xl font-bold text-slate-800">{{ $departmentCount }}</h3>
                <p class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                    <span>Departments in requests</span>
                </p>
            </div>
            <div class="bg-[#5B8FB9] p-3 rounded-xl text-white shadow-inner">
                <i class="fa-solid fa-building text-lg"></i>
            </div>
        </div>
    </div>

    <div class="pt-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Fixed Scrolling & Overlap Issues -->
        <div
            class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-md space-y-6 max-h-130 overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 bg-white">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Budget Spending Overview</h3>
                    <p class="text-xs text-slate-400 font-medium">Department expenditure rate allocations</p>
                </div>
                <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">Updated Daily</span>
            </div>

            <div class="space-y-5 pr-2">
                <!-- Procurement -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Procurement</span>
                        <span class="font-bold text-slate-800">PHP 6,500 / <span
                                class="text-slate-400 text-xs font-medium">PHP 10,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 65%"></div>
                    </div>
                </div>

                <!-- Finance and Accounting -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Finance and Accounting</span>
                        <span class="font-bold text-slate-800">PHP 5,440 / <span
                                class="text-slate-400 text-xs font-medium">PHP 10,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 54.4%"></div>
                    </div>
                </div>

                <!-- Customer Service -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Customer Service</span>
                        <span class="font-bold text-slate-800">PHP 2,100 / <span
                                class="text-slate-400 text-xs font-medium">PHP 5,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 42%"></div>
                    </div>
                </div>

                <!-- Inventory and Warehouse Management System -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Inventory and Warehouse Management System</span>
                        <span class="font-bold text-slate-800">PHP 11,200 / <span
                                class="text-slate-400 text-xs font-medium">PHP 15,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 74.6%"></div>
                    </div>
                </div>

                <!-- Supply Chain Management -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Supply Chain Management</span>
                        <span class="font-bold text-slate-800">PHP 8,900 / <span
                                class="text-slate-400 text-xs font-medium">PHP 12,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 74.1%"></div>
                    </div>
                </div>

                <!-- E-Commerce Integration -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">E-Commerce Integration</span>
                        <span class="font-bold text-slate-800">PHP 4,800 / <span
                                class="text-slate-400 text-xs font-medium">PHP 8,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 60%"></div>
                    </div>
                </div>

                <!-- Business Intelligence -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Business Intelligence</span>
                        <span class="font-bold text-slate-800">PHP 7,150 / <span
                                class="text-slate-400 text-xs font-medium">PHP 10,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 71.5%"></div>
                    </div>
                </div>

                <!-- Sales and Customer Support Management -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Sales and Customer Support Management</span>
                        <span class="font-bold text-slate-800">PHP 3,200 / <span
                                class="text-slate-400 text-xs font-medium">PHP 6,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 53.3%"></div>
                    </div>
                </div>

                <!-- Project Management Module -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Project Management Module</span>
                        <span class="font-bold text-slate-800">PHP 9,400 / <span
                                class="text-slate-400 text-xs font-medium">PHP 12,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 78.3%"></div>
                    </div>
                </div>

                <!-- Human Resources -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Human Resources</span>
                        <span class="font-bold text-slate-800">PHP 4,120 / <span
                                class="text-slate-400 text-xs font-medium">PHP 10,000</span></span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 41.2%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-md flex flex-col justify-between max-h-130">
            <div class="pb-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg">Purchase Order Distribution</h3>
                <p class="text-xs text-slate-400 font-medium">Active statuses within this date segment</p>
            </div>

            <div class="flex justify-center my-6 relative">
                <canvas id="poDistributionChart" class="w-48 h-48"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black text-slate-800">{{ $purchaseOrdersCount }}</span>
                    <span class="text-[10px] font-bold text-slate-700 uppercase tracking-wider">Total POs</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2 text-center border-t border-slate-100 pt-4">
                <div>
                    <div class="flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-500">
                        <span class="inline-block w-3 h-3 rounded-full bg-[#6F79A8]"></span>
                        <span>Delivered</span>
                    </div>
                    <span class="text-base font-bold text-slate-800">{{ $chartData['delivered'] }}</span>
                </div>
                <div>
                    <div class="flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-500">
                        <span class="inline-block w-3 h-3 rounded-full bg-[#A7AD57]"></span>
                        <span>Pending</span>
                    </div>
                    <span class="text-base font-bold text-slate-800">{{ $chartData['pending'] }}</span>
                </div>
                <div>
                    <div class="flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-500">
                        <span class="inline-block w-3 h-3 rounded-full bg-[#C4524D]"></span>
                        <span>Cancelled</span>
                    </div>
                    <span class="text-base font-bold text-slate-800">{{ $chartData['cancelled'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-10 grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Category Spend (Text Centered Perfectly - Now Wider) -->
        <div
            class="lg:col-span-5 bg-white rounded-3xl p-8 border border-slate-100 shadow-md flex flex-col justify-between h-90 relative">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Spending by Category</h3>
                <p class="text-xs text-slate-400 font-medium">Categorized inventory costs distribution</p>
            </div>
            <div class="relative flex-1 flex items-center justify-center max-h-55">

                <canvas id="categoryDoughnutChart" class="max-h-47.5"></canvas>
                <!-- PERFECTLY BALANCED AND CENTERED ABSOLUTE CONTAINER -->
                <div
                    class="absolute top-[35%] left-28px -translate-x-30px flex flex-col items-center justify-center pointer-events-none text-center">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider leading-none">Total</span>
                    <span class="text-xl font-black text-slate-800 leading-none block">₱30.9K</span>
                </div>
            </div>
        </div>

        <!-- Supplier Spend (Horizontal Bar Graph) -->
        <div
            class="lg:col-span-7 bg-white rounded-3xl p-8 border border-slate-100 shadow-md flex flex-col justify-between h-90">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Spending by Supplier</h3>
                <p class="text-xs text-slate-400 font-medium">Fulfillment capital shares per vendor</p>
            </div>
            <div class="flex-1 flex items-center justify-center pt-4">
                <canvas id="supplierBarChart" class="w-full max-h-55"></canvas>
            </div>
        </div>

    </div>

    <!-- mt-8 adds margin-top, which pushes the entire box away from the element above it -->
    <div class="mt-10 bg-white rounded-3xl p-8 border border-slate-100 shadow-md space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Supplier Performance Directory Index</h3>
                <p class="text-xs text-slate-400 font-medium">Evaluation metrics mapping core fulfillment speeds</p>
            </div>
            <button class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">See Complete
                Index</button>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full border-collapse text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Supplier Corporate Entity</th>
                        <th class="px-6 py-4">On-Time Delivery Rate</th>
                        <th class="px-6 py-4">Quality Rating Index</th>
                        <th class="px-6 py-4">Order Accuracy Metrics</th>
                        <th class="px-6 py-4 text-right">Overall Calculated Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 font-bold flex items-center justify-center text-xs">
                                IC</div>
                            <span class="font-bold text-slate-800">ICTO Corp.</span>
                        </td>
                        <td class="px-6 py-4">95.4%</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-amber-500">
                                <i class="fa-solid fa-star text-xs"></i>
                                <span class="font-bold text-slate-800 text-xs">4.6</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">98.2%</td>
                        <td class="px-6 py-4 text-right">
                            <span class="bg-emerald-50 text-emerald-700 font-extrabold text-xs px-2.5 py-1 rounded-full">92%
                                Outstanding</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 font-bold flex items-center justify-center text-xs">
                                SL</div>
                            <span class="font-bold text-slate-800">Starlink</span>
                        </td>
                        <td class="px-6 py-4">94.1%</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-amber-500">
                                <i class="fa-solid fa-star text-xs"></i>
                                <span class="font-bold text-slate-800 text-xs">3.6</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">96.0%</td>
                        <td class="px-6 py-4 text-right">
                            <span class="bg-blue-50 text-blue-700 font-extrabold text-xs px-2.5 py-1 rounded-full">90%
                                Verified</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 font-bold flex items-center justify-center text-xs">
                                SB</div>
                            <span class="font-bold text-slate-800">Space Bang</span>
                        </td>
                        <td class="px-6 py-4">94.0%</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-amber-500">
                                <i class="fa-solid fa-star text-xs"></i>
                                <span class="font-bold text-slate-800 text-xs">4.6</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">92.1%</td>
                        <td class="px-6 py-4 text-right">
                            <span class="bg-emerald-50 text-emerald-700 font-extrabold text-xs px-2.5 py-1 rounded-full">91%
                                Outstanding</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-xs">
                                AC</div>
                            <span class="font-bold text-slate-800">ACER</span>
                        </td>
                        <td class="px-6 py-4">95.0%</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-amber-500">
                                <i class="fa-solid fa-star text-xs"></i>
                                <span class="font-bold text-slate-800 text-xs">3.6</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">95.0%</td>
                        <td class="px-6 py-4 text-right">
                            <span class="bg-emerald-50 text-emerald-700 font-extrabold text-xs px-2.5 py-1 rounded-full">94%
                                Outstanding</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

<!-- Export Modal Structure -->
<div id="exportModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
    <div
        class="bg-white rounded-3xl p-8 w-full max-w-sm shadow-2xl border border-slate-100 transform transition-all duration-150 scale-95">
        <!-- Header -->
        <div class="text-center mb-6">
            <h3 class="font-bold text-slate-800 text-xl">Export Report</h3>
            <p class="text-xs text-slate-400 font-medium mt-1">Choose your preferred document format</p>
        </div>

        <!-- Options -->
        <div class="flex flex-col gap-3">
            <button onclick="triggerActualDownload('pdf')"
                class="flex items-center gap-4 px-4 py-3 bg-slate-50 hover:bg-rose-50 border border-slate-100 hover:border-rose-200 rounded-2xl transition-all group">
                <i class="fa-solid fa-file-pdf text-rose-500 text-lg"></i>
                <span class="text-sm font-bold text-slate-700 group-hover:text-rose-700">Export as PDF</span>
            </button>

            <button onclick="triggerActualDownload('excel')"
                class="flex items-center gap-4 px-4 py-3 bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 rounded-2xl transition-all group">
                <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                <span class="text-sm font-bold text-slate-700 group-hover:text-emerald-700">Export as Excel</span>
            </button>

            <button onclick="triggerActualDownload('docx')"
                class="flex items-center gap-4 px-4 py-3 bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 rounded-2xl transition-all group">
                <i class="fa-solid fa-file-word text-blue-600 text-lg"></i>
                <span class="text-sm font-bold text-slate-700 group-hover:text-blue-700">Export as DOCX</span>
            </button>
        </div>

        <!-- Cancel -->
        <button onclick="toggleExportModal(false)"
            class="w-full mt-6 text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">
            Cancel
        </button>
    </div>
</div>

@push('scripts')
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Date picker drop selector
        function selectDateRange(range) {
            document.getElementById('selectedDateRange').innerText = range;
            document.getElementById('dateDropdown').classList.add('hidden');
        }

        window.addEventListener('click', function (e) {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileContainer = document.getElementById('profileDropdownContainer');
            const dateDropdown = document.getElementById('dateDropdown');
            const dateBtn = document.querySelector('[onclick="toggleDropdown(\'dateDropdown\')"]');

            if (profileContainer && !profileContainer.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }

            if (dateBtn && !dateBtn.contains(e.target) && dateDropdown && !dateDropdown.contains(e.target)) {
                dateDropdown.classList.add('hidden');
            }
        });

        // --- MODAL CONTROLLER & DOWNLOAD TRIGGER ENGINE ---
        function toggleExportModal(show) {
            const modal = document.getElementById('exportModal');
            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => modal.firstElementChild.classList.remove('scale-95'), 10);
            } else {
                modal.firstElementChild.classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 150);
            }
        }

        function triggerActualDownload(format) {
            // Smoothly close the modal layout immediately 
            toggleExportModal(false);

            // Pass format directly to Laravel backend route stream configuration
            window.location.href = "{{ route('dashboard.reports.export') }}?format=" + format;
        }

        // ==========================================
        // CHART RENDERING ENGINE (CHART.JS)
        // ==========================================
        document.addEventListener("DOMContentLoaded", () => {
            const poDistributionCounts = @json(array_values($chartData));
            const ctxPoDistribution = document.getElementById('poDistributionChart').getContext('2d');
            new Chart(ctxPoDistribution, {
                type: 'doughnut',
                data: {
                    labels: ['Delivered', 'Pending', 'Cancelled'],
                    datasets: [{
                        data: poDistributionCounts,
                        backgroundColor: ['#727CA3', '#AAB06C', '#B44A4A'],
                        borderWidth: 0,
                        cutout: '72%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const total = poDistributionCounts.reduce((sum, value) => sum + value, 0);
                                    const percent = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${context.raw} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // --- 1. Category Spending (Vibrant Rounded Doughnut) ---
            const ctxCategory = document.getElementById('categoryDoughnutChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: ['Hardware', 'Software', 'Office Supplies', 'Utilities'],
                    datasets: [{
                        data: [15800, 8500, 4200, 2410],
                        backgroundColor: ['#334155', '#6366F1', '#F59E0B', '#10B981'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { family: 'Inter', size: 10, weight: '600' },
                                color: '#475569'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return ` ₱${context.raw.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    cutout: '75%'
                }
            });

            // --- 2. Supplier Spending (Sleek Horizontal Rounded Bar Chart) ---
            const ctxSupplier = document.getElementById('supplierBarChart').getContext('2d');
            new Chart(ctxSupplier, {
                type: 'bar',
                data: {
                    labels: ['ICTO Corp.', 'Starlink', 'Space Bang', 'ACER'],
                    datasets: [{
                        label: 'Spent Amount',
                        data: [14250, 8900, 5440, 2320],
                        backgroundColor: '#2563EB',
                        hoverBackgroundColor: '#1D4ED8',
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 14
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 9 },
                                color: '#94A3B8',
                                callback: value => '₱' + value / 1000 + 'k'
                            }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 10, weight: '600' },
                                color: '#475569'
                            }
                        }
                    }
                }
            });
        });
    </script>

@endpush

@push('styles')
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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }

            < style >
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
                body { font - family: 'Inter', sans - serif; }
                /* Custom scrollbar to match sleek UI look */
                :: -webkit - scrollbar { width: 6px; height: 6px; }
                :: -webkit - scrollbar - track { background: #DBDBDB; }
                :: -webkit - scrollbar - thumb { background: #A5A5A5; border - radius: 3px; }
            </style >
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar to match sleek UI look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #DBDBDB;
        }

        ::-webkit-scrollbar-thumb {
            background: #A5A5A5;
            border-radius: 3px;
        }
    </style>

@endpush