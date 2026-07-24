@extends('layouts.app')

@section('content')
<section class="view-panel space-y-6 w-full px-4 sm:px-6 lg:px-8 pt-3 pb-6">
    <!-- Header with Breadcrumbs & Back Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $supplier->name ?? 'Supplier Details' }}</h1>
            <nav class="text-xs text-gray-400 mt-1 flex items-center gap-1.5 font-medium">
                <span>Dashboard</span>
                <span>/</span>
                <span>Supplier Management</span>
                <span>/</span>
                <span class="text-gray-700 font-semibold">Supplier Details</span>
            </nav>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('suppliers.index') }}" class="inline-flex items-center space-x-2 px-3.5 py-2 border border-gray-200 rounded-xl bg-white text-xs font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition shadow-2xs">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Back to List</span>
            </a>
            <button class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition shadow-2xs">
                <i class="fa-solid fa-ellipsis text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Profile Summary Banner Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-gray-200/80 shadow-xs flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 relative overflow-hidden">
        <div class="flex items-start sm:items-center space-x-4">
            <!-- Dynamic Logo/Icon -->
            <div class="w-16 h-16 sm:w-18 sm:h-18 flex items-center justify-center rounded-2xl bg-gray-50 border border-gray-100 {{ $supplier->category_icon_color ?? 'text-emerald-600' }} shadow-xs text-2xl sm:text-3xl shrink-0">
                <i class="fa-solid {{ $supplier->category_icon ?? 'fa-building' }}"></i>
            </div>
            
            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">{{ $supplier->name }}</h2>
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 font-bold text-[10px] rounded-md uppercase tracking-wider">
                        {{ $supplier->status ?? 'Active' }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <!-- Dynamic Category Badge -->
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $supplier->category_color ?? 'bg-blue-50 text-blue-700' }}">
                        {{ $supplier->category }}
                    </span>
                    <span class="text-gray-300">•</span>
                    <span class="text-xs text-gray-500 font-medium flex items-center">
                        <i class="fa-solid fa-boxes-stacked mr-1.5 text-gray-400"></i> 
                        {{ $supplier->sub_categories ?? 'General Goods & Services' }}
                    </span>
                </div>

                <div class="flex items-center space-x-1.5 text-xs pt-1">
                    <div class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200/60 px-2 py-0.5 rounded-md font-bold">
                        <i class="fa-solid fa-star text-[10px]"></i>
                        <span>{{ number_format($supplier->rating ?? 4.5, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row lg:flex-col gap-2.5 w-full lg:w-48 shrink-0">
            <a href="{{ route('suppliers.evaluation', $supplier->id) }}" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-center rounded-xl text-xs font-semibold shadow-xs transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-clipboard-check text-[11px]"></i>
                <span>Evaluate Supplier</span>
            </a>
            <a href="#" onclick="window.openCallModal(); return false;" class="w-full py-2.5 border border-emerald-600 text-emerald-600 hover:bg-emerald-50 text-center rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-phone text-[11px]"></i>
                <span>Call Supplier</span>
            </a>
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="w-full py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 text-center rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5">
                <i class="fa-regular fa-pen-to-square text-[11px]"></i>
                <span>Edit Supplier</span>
            </a>
        </div>
    </div>

    <!-- Grid Profile Metrics Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Blocks Area -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Contact Details Block -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-xs space-y-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Contact Information</h3>
                <div class="space-y-4 text-xs">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0 mt-0.5">
                            <i class="fa-regular fa-id-badge text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-400 uppercase text-[10px] tracking-wider">Contact Person</p>
                            <p class="text-gray-900 font-bold mt-0.5 text-sm">{{ $supplier->contact_person ?? $supplier['contact_person'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3.5">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0 mt-0.5">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-400 uppercase text-[10px] tracking-wider">Phone Number</p>
                            <p class="text-gray-900 font-bold mt-0.5 text-sm">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3.5">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0 mt-0.5">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-400 uppercase text-[10px] tracking-wider">Email Address</p>
                            <p class="text-emerald-600 font-bold mt-0.5 text-sm hover:underline">{{ $supplier->email ?? $supplier['email'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3.5">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0 mt-0.5">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-400 uppercase text-[10px] tracking-wider">Location Address</p>
                            <p class="text-gray-900 font-semibold mt-0.5 leading-relaxed">{{ $supplier->address ?? $supplier['address'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Trend Mini Chart Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Supplier Performance Trend</h3>
                <div class="pt-2 h-36 w-full flex items-end">
                    <svg class="w-full h-full text-emerald-500" viewBox="0 0 100 40" preserveAspectRatio="none">
                        <path d="M 0 35 L 10 25 L 20 20 L 30 28 L 40 15 L 50 22 L 60 18 L 70 24 L 80 20 L 90 12 L 100 8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="flex justify-between text-[10px] text-gray-400 font-bold px-1">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                </div>
            </div>
        </div>

        <!-- Right Grid Metrics Blocks Area -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-xs space-y-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Performance Overview</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50/60 border border-gray-100 p-5 rounded-xl">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lead Time Estimate</span>
                        <h4 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">{{ $supplier->delivery_time ?? $supplier['delivery_time'] ?? 'N/A' }}</h4>
                    </div>
                    <div class="bg-gray-50/60 border border-gray-100 p-5 rounded-xl">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Delivery Schedule</span>
                        <h4 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">{{ $supplier->delivery_schedule ?? $supplier['delivery_schedule'] ?? 'Not specified' }}</h4>
                    </div>
                    <div class="bg-gray-50/60 border border-gray-100 p-5 rounded-xl">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Quality Score Rating</span>
                        <h4 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">{{ number_format($supplier->rating ?? $supplier['rating'] ?? 0.0, 1) }} <span class="text-base font-semibold text-gray-400">/ 5</span></h4>
                    </div>
                    <div class="bg-gray-50/60 border border-gray-100 p-5 rounded-xl">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Settlement Matrix</span>
                        <h4 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">{{ $supplier->payment_terms ?? $supplier['payment_terms'] ?? 'None specified' }}</h4>
                    </div>
                </div>
            </div>

            <!-- Radial Donut & Side Notes Grid Component -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Donut Progress Component -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-xs flex flex-col justify-between">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Compliance Status</h3>
                    <div class="flex items-center space-x-6 py-2">
                        <div class="relative w-28 h-28 rounded-full flex items-center justify-center bg-gray-100 shrink-0" style="background: conic-gradient(#10B981 100%, #f3f4f6 0);">
                            <div class="w-22 h-22 rounded-full bg-white flex items-center justify-center shadow-inner">
                                <span class="text-xl font-bold text-gray-900">100%</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-xs"></span>
                                <span class="text-gray-700 font-semibold">Active Record</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty state notes module -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Operational Notes</h3>
                        <div class="py-6 text-center">
                            <p class="text-xs text-gray-400 italic">No notes available for this contact</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- CALL SUPPLIER MODAL CONTAINER FRAMEWORK -->
<!-- ========================================== -->
<div id="callModal" class="fixed inset-0 bg-black/50 backdrop-blur-xs items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden relative mx-4 border border-gray-100">
        
        <!-- STEP 1: INITIATE CALL VIEW -->
        <div id="view-initiate" class="p-6 sm:p-8">
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-phone text-sm"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">Call Supplier</h3>
                </div>
                <button onclick="window.closeCallModal()" class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-3 border border-emerald-100">
                    <i class="fa-solid fa-building text-2xl text-emerald-600"></i>
                </div>
                <h4 class="text-lg font-bold text-gray-900">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</h4>
                <span class="mt-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[10px] font-bold rounded-md uppercase tracking-wider">Online</span>
            </div>

            <div class="space-y-3 mb-6 bg-gray-50/60 p-4 rounded-xl border border-gray-100 text-left">
                <div class="flex items-start gap-3">
                    <span class="p-2 bg-white border border-gray-200/80 rounded-lg text-gray-500 shadow-2xs"><i class="fa-solid fa-phone text-xs"></i></span>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Contact Number</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 pt-2 border-t border-gray-200/60">
                    <span class="p-2 bg-white border border-gray-200/80 rounded-lg text-gray-500 shadow-2xs"><i class="fa-regular fa-user text-xs"></i></span>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Contact Person</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $supplier->contact_person ?? $supplier['contact_person'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-3.5 flex items-start gap-3 mb-6 text-left text-xs">
                <i class="fa-solid fa-circle-info text-blue-500 mt-0.5 shrink-0"></i>
                <p class="text-blue-900">You are about to call <strong>{{ $supplier->name ?? $supplier['name'] ?? 'this supplier' }}</strong>. Ensure your audio device is connected.</p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button onclick="window.closeCallModal()" class="w-full py-2.5 border border-gray-200 text-gray-700 text-xs font-semibold rounded-xl hover:bg-gray-50 transition cursor-pointer">Cancel</button>
                <button onclick="window.startOutgoingCall()" class="w-full py-2.5 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition shadow-xs cursor-pointer">Start Call</button>
            </div>
        </div>

        <!-- STEP 2: CONNECTING VIEW -->
        <div id="view-connecting" class="p-8 flex-col items-center text-center hidden">
            <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center mb-5 animate-pulse shadow-lg shadow-emerald-200">
                <i class="fa-solid fa-phone text-2xl text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Calling Supplier...</h3>
            <p class="text-base font-bold text-gray-800 mb-1">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</p>
            <p class="text-xs text-gray-400 mb-6 font-medium">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
            
            <div class="flex space-x-1.5 justify-center mb-8">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-emerald-200 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
            </div>

            <button onclick="window.endActiveCall()" class="w-full max-w-xs py-2.5 border border-red-200 text-red-600 text-xs font-semibold rounded-xl hover:bg-red-50 transition flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-phone-slash text-xs"></i> End Call
            </button>
        </div>

        <!-- STEP 3: CONNECTED / ACTIVE TIMER VIEW -->
        <div id="view-connected" class="p-8 flex-col items-center text-center hidden">
            <div class="w-20 h-20 bg-emerald-600 rounded-full flex items-center justify-center mb-5 shadow-lg shadow-emerald-100">
                <i class="fa-solid fa-phone text-2xl text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Call Connected</h3>
            <p class="text-sm text-gray-600 font-semibold mb-1">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</p>
            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[10px] font-bold rounded-md uppercase tracking-wider mb-4">Live</span>
            
            <div id="liveTimer" class="text-3xl font-black text-gray-900 tracking-wider mb-6 font-mono">00:00</div>

            <div class="grid grid-cols-2 gap-3 w-full max-w-sm mb-6 text-xs">
                <button class="flex flex-col items-center justify-center border border-gray-200/80 p-3 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                    <i class="fa-solid fa-microphone-slash text-gray-500 text-base mb-1"></i>
                    <span class="font-semibold text-gray-700">Mute</span>
                </button>
                <button class="flex flex-col items-center justify-center border border-gray-200/80 p-3 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                    <i class="fa-solid fa-volume-high text-gray-500 text-base mb-1"></i>
                    <span class="font-semibold text-gray-700">Speaker</span>
                </button>
                <button class="flex flex-col items-center justify-center border border-gray-200/80 p-3 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                    <i class="fa-solid fa-table-cells text-gray-500 text-base mb-1"></i>
                    <span class="font-semibold text-gray-700">Keypad</span>
                </button>
                <button class="flex flex-col items-center justify-center border border-gray-200/80 p-3 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                    <i class="fa-regular fa-clipboard text-gray-500 text-base mb-1"></i>
                    <span class="font-semibold text-gray-700">Notes</span>
                </button>
            </div>

            <button onclick="window.endActiveCall()" class="w-full py-3 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                <i class="fa-solid fa-phone-slash text-xs"></i> End Call
            </button>
        </div>

        <!-- STEP 4: CALL ENDED SUMMARY -->
        <div id="view-ended" class="p-8 flex-col items-center text-center hidden">
            <div class="w-16 h-16 bg-emerald-50 border border-emerald-100 rounded-full flex items-center justify-center mb-4 text-emerald-600">
                <i class="fa-solid fa-check text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Call Ended</h3>
            <p class="text-xs text-gray-500 mb-1">Your call with</p>
            <p class="text-sm font-bold text-gray-900 mb-1">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</p>
            <p class="text-xs text-gray-500 mb-5">completed successfully.</p>
            
            <div class="border-t border-b border-gray-100 w-full py-3.5 mb-6">
                <p class="text-[10px] font-bold tracking-wider text-gray-400 uppercase mb-1">Duration</p>
                <div id="finalDuration" class="text-xl font-bold text-gray-900 font-mono">00:00</div>
            </div>

            <button onclick="window.closeCallModal()" class="w-full max-w-xs py-2.5 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition cursor-pointer shadow-xs">Done</button>
        </div>

    </div>
</div>

<script>
    var callTimerInterval = null;
    var secondsElapsed = 0;

    window.openCallModal = function() {
        var modal = document.getElementById('callModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            switchView('view-initiate');
        }
    }

    window.closeCallModal = function() {
        var modal = document.getElementById('callModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            resetCallTimer();
        }
    }

    function switchView(viewId) {
        var views = ['view-initiate', 'view-connecting', 'view-connected', 'view-ended'];
        views.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden');
                el.classList.remove('flex', 'block');
            }
        });
        
        var activeView = document.getElementById(viewId);
        if (activeView) {
            activeView.classList.remove('hidden');
            if (viewId === 'view-initiate') {
                activeView.classList.add('block');
            } else {
                activeView.classList.add('flex', 'flex-col', 'items-center');
            }
        }
    }

    window.startOutgoingCall = function() {
        switchView('view-connecting');
        setTimeout(function() {
            var connectingView = document.getElementById('view-connecting');
            if (connectingView && !connectingView.classList.contains('hidden')) {
                switchView('view-connected');
                startCallTimer();
            }
        }, 2000);
    }

    window.endActiveCall = function() {
        clearInterval(callTimerInterval);
        var syncTimeText = formatTime(secondsElapsed);
        var finalDurationEl = document.getElementById('finalDuration');
        if (finalDurationEl) finalDurationEl.innerText = syncTimeText;
        switchView('view-ended');
    }

    function startCallTimer() {
        resetCallTimer();
        callTimerInterval = setInterval(function() {
            secondsElapsed++;
            var liveTimerEl = document.getElementById('liveTimer');
            if (liveTimerEl) liveTimerEl.innerText = formatTime(secondsElapsed);
        }, 1000);
    }

    function resetCallTimer() {
        clearInterval(callTimerInterval);
        secondsElapsed = 0;
        var liveTimerEl = document.getElementById('liveTimer');
        if (liveTimerEl) liveTimerEl.innerText = "00:00";
    }

    function formatTime(totalSeconds) {
        var mins = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
        var secs = (totalSeconds % 60).toString().padStart(2, '0');
        return mins + ":" + secs;
    }
</script>
@endsection