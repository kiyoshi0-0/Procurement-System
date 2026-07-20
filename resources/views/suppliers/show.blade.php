@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header with Breadcrumbs -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $supplier->name ?? 'Supplier Details' }}</h1>
                <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
                    <span>Dashboard</span>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span>Supplier Management</span>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium">Supplier Details</span>
                </div>
            </div>
        </div>

        <!-- Back Track Row -->
        <div class="flex items-center justify-between">
            <a href="{{ route('suppliers.index') }}" class="inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg bg-white text-xs font-semibold text-gray-600 hover:bg-gray-50">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <button class="p-2 bg-white border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50"><i class="fa-solid fa-ellipsis"></i></button>
        </div>

        <!-- Profile Summary Banner Card -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Dynamic Logo/Icon -->
                <div class="w-16 h-16 flex items-center justify-center rounded-2xl bg-gray-50 border border-gray-100 {{ $supplier->category_icon_color }} shadow-sm text-3xl">
                    <i class="fa-solid {{ $supplier->category_icon }}"></i>
                </div>
                
                <div>
                    <div class="flex items-center space-x-2">
                        <h2 class="text-xl font-bold text-gray-900">{{ $supplier->name }}</h2>
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 font-semibold text-[10px] rounded uppercase">
                            {{ $supplier->status ?? 'Active' }}
                        </span>
                    </div>
                    <!-- Dynamic Category Badge -->
                    <span class="inline-block mt-1 px-3 py-1 rounded text-xs font-medium {{ $supplier->category_color }}">
                        {{ $supplier->category }}
                    </span>
                    
                    <p class="text-xs text-gray-400 mt-1.5 flex items-center">
                        <i class="fa-solid fa-boxes-stacked mr-1.5"></i> 
                        {{ $supplier->sub_categories ?? 'No sub-categories defined' }}
                    </p>
                    <div class="flex items-center space-x-1.5 text-xs text-yellow-400 mt-1">
                        <i class="fa-solid fa-star"></i>
                        <span class="text-gray-700 font-semibold ml-1">{{ number_format($supplier->rating ?? 4.5, 1) }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons including restored Evaluate Button -->
            <div class="flex flex-col space-y-2 w-full md:w-48 text-center" style="position: relative; z-index: 40;">
                <a href="{{ route('suppliers.evaluation', $supplier->id) }}" class="w-full py-2 bg-[#10B981] hover:bg-emerald-600 text-white text-center rounded-lg text-xs font-semibold shadow-xs transition">
                    Evaluate Supplier
                </a>
                <a href="#" onclick="window.openCallModal(); return false;" class="w-full py-2 border border-emerald-600 text-emerald-600 text-center rounded-lg text-xs font-semibold hover:bg-emerald-50 block cursor-pointer">Call Supplier</a>
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="w-full py-2 border border-emerald-600 text-emerald-600 text-center rounded-lg text-xs font-semibold hover:bg-emerald-50">Edit Supplier</a>
            </div>
        </div>

        <!-- ... rest of your existing grid profile metrics ... -->
        
        <!-- (Modal logic remains unchanged as per your original file) -->
    </div>

    <!-- Grid Profile Metrics Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Blocks Area -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Contact Details Block -->
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Contact Information</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex items-start space-x-3">
                        <i class="fa-regular fa-id-badge text-gray-400 text-lg mt-0.5"></i>
                        <div>
                            <p class="font-medium text-gray-400">Contact Person</p>
                            <p class="text-gray-800 font-semibold mt-0.5">{{ $supplier->contact_person ?? $supplier['contact_person'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-phone text-gray-400 text-base mt-0.5"></i>
                        <div>
                            <p class="font-medium text-gray-400">Phone Number</p>
                            <p class="text-gray-800 font-semibold mt-0.5">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fa-regular fa-envelope text-gray-400 text-base mt-0.5"></i>
                        <div>
                            <p class="font-medium text-gray-400">Email</p>
                            <p class="text-emerald-600 font-semibold mt-0.5 underline">{{ $supplier->email ?? $supplier['email'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-location-dot text-gray-400 text-base mt-0.5"></i>
                        <div>
                            <p class="font-medium text-gray-400">Address</p>
                            <p class="text-gray-800 font-semibold mt-0.5 leading-relaxed">{{ $supplier->address ?? $supplier['address'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Trend Mini Chart Card -->
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-3">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Supplier Performance</h3>
                <div class="pt-2 h-36 w-full flex items-end">
                    <svg class="w-full h-full text-emerald-500" viewBox="0 0 100 40" preserveAspectRatio="none">
                        <path d="M 0 35 L 10 25 L 20 20 L 30 28 L 40 15 L 50 22 L 60 18 L 70 24 L 80 20 L 90 12 L 100 8" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                </div>
                <div class="flex justify-between text-[9px] text-gray-400 font-semibold px-1">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>June</span><span>July</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                </div>
            </div>
        </div>

        <!-- Right Grid Metrics Blocks Area -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-5">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Performance Overview</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="border border-gray-200 p-4 rounded-xl text-center sm:text-left">
                        <span class="text-xs font-medium text-gray-400">Lead Time Estimate</span>
                        <h4 class="text-2xl font-extrabold text-gray-800 mt-1">{{ $supplier->delivery_time ?? $supplier['delivery_time'] ?? 'N/A' }}</h4>
                    </div>
                    <div class="border border-gray-200 p-4 rounded-xl text-center sm:text-left">
                        <span class="text-xs font-medium text-gray-400">Delivery Schedule</span>
                        <h4 class="text-2xl font-extrabold text-gray-800 mt-1">{{ $supplier->delivery_schedule ?? $supplier['delivery_schedule'] ?? 'Not specified' }}</h4>
                    </div>
                    <div class="border border-gray-200 p-4 rounded-xl text-center sm:text-left">
                        <span class="text-xs font-medium text-gray-400">Quality Score Rating</span>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">{{ number_format($supplier->rating ?? $supplier['rating'] ?? 0.0, 1) }} / <span class="text-xl font-bold text-gray-400">5</span></h4>
                    </div>
                    <div class="border border-gray-200 p-4 rounded-xl text-center sm:text-left">
                        <span class="text-xs font-medium text-gray-400">Settlement Matrix</span>
                        <h4 class="text-2xl font-extrabold text-gray-800 mt-1">{{ $supplier->payment_terms ?? $supplier['payment_terms'] ?? 'None specified' }}</h4>
                    </div>
                </div>
            </div>

            <!-- Radial Donut & Side Notes Grid Component -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Donut Progress Component -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex flex-col justify-between">
                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Supplier Performance</h3>
                    <div class="flex items-center space-x-6">
                        <div class="relative w-28 h-28 rounded-full flex items-center justify-center bg-gray-100" style="background: conic-gradient(#10B981 100%, #f3f4f6 0);">
                            <div class="w-22 h-22 rounded-full bg-white flex items-center justify-center">
                                <span class="text-xl font-bold text-gray-800">100%</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center space-x-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span class="text-gray-500">Active Record</span></div>
                        </div>
                    </div>
                </div>

                <!-- Empty state notes module -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Operational Notes</h3>
                        <p class="text-xs text-gray-400 italic">No notes available for this contact</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- CALL SUPPLIER MODAL CONTAINER FRAMEWORK -->
<!-- ========================================== -->
<div id="callModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden relative mx-4">
        
        <!-- STEP 1: INITIATE CALL VIEW -->
        <div id="view-initiate" class="p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-phone-alt text-xl text-gray-700"></i>
                    <h3 class="text-2xl font-bold text-gray-900">Call Supplier</h3>
                </div>
                <button onclick="window.closeCallModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mb-3">
                    <i class="fa-solid fa-gears text-4xl text-emerald-600"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</h4>
                <span class="mt-1 px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">Online</span>
            </div>

            <div class="space-y-4 mb-6 border-t border-b py-4 text-left">
                <div class="flex items-start gap-4">
                    <span class="p-2 bg-gray-100 rounded-lg text-gray-500"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase">Contact Number</p>
                        <p class="text-lg font-bold text-gray-900">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="p-2 bg-gray-100 rounded-lg text-gray-500"><i class="fa-regular fa-user"></i></span>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase">Contact Person</p>
                        <p class="text-lg font-bold text-gray-900">{{ $supplier->contact_person ?? $supplier['contact_person'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 flex items-start gap-3 mb-6 text-left">
                <i class="fa-solid fa-circle-info text-gray-400 mt-1 shrink-0"></i>
                <p class="text-sm text-gray-600">You are about to call <strong>{{ $supplier->name ?? $supplier['name'] ?? 'this supplier' }}</strong>. Make sure your microphone is connected before continuing.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button onclick="window.closeCallModal()" class="w-full py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">Cancel</button>
                <button onclick="window.startOutgoingCall()" class="w-full py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition">Start Call</button>
            </div>
        </div>

        <!-- STEP 2: CONNECTING VIEW -->
        <div id="view-connecting" class="p-8 flex-col items-center text-center hidden">
            <div class="w-24 h-24 bg-emerald-500 rounded-full flex items-center justify-center mb-6 animate-pulse shadow-lg shadow-emerald-200">
                <i class="fa-solid fa-phone text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Calling Supplier...</h3>
            <p class="text-lg font-semibold text-gray-700 mb-2">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</p>
            <p class="text-sm text-gray-400 mb-6">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
            
            <div class="flex space-x-2 justify-center mb-10">
                <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2.5 h-2.5 bg-emerald-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-2.5 h-2.5 bg-emerald-200 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
            </div>

            <button onclick="window.endActiveCall()" class="w-full max-w-xs py-3 border border-red-500 text-red-500 font-semibold rounded-xl hover:bg-red-50 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-phone-slash"></i> End Call
            </button>
        </div>

        <!-- STEP 3: CONNECTED / ACTIVE TIMER VIEW -->
        <div id="view-connected" class="p-8 flex-col items-center text-center hidden">
            <div class="w-24 h-24 bg-emerald-600 rounded-full flex items-center justify-center mb-6 shadow-lg shadow-emerald-100">
                <i class="fa-solid fa-phone text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Call Connected</h3>
            <p class="text-lg text-gray-600 font-medium mb-1">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</p>
            <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full mb-4">Connected</span>
            
            <div id="liveTimer" class="text-3xl font-black text-gray-900 tracking-wider mb-8">00:00</div>

            <div class="grid grid-cols-2 gap-4 w-full max-w-sm mb-8">
                <button class="flex flex-col items-center justify-center border border-gray-200 p-4 rounded-xl hover:bg-gray-50">
                    <i class="fa-solid fa-microphone-slash text-gray-600 text-lg mb-1"></i>
                    <span class="text-xs font-semibold text-gray-700">Mute</span>
                </button>
                <button class="flex flex-col items-center justify-center border border-gray-200 p-4 rounded-xl hover:bg-gray-50">
                    <i class="fa-solid fa-volume-high text-gray-600 text-lg mb-1"></i>
                    <span class="text-xs font-semibold text-gray-700">Speaker</span>
                </button>
                <button class="flex flex-col items-center justify-center border border-gray-200 p-4 rounded-xl hover:bg-gray-50">
                    <i class="fa-solid fa-table-cells text-gray-600 text-lg mb-1"></i>
                    <span class="text-xs font-semibold text-gray-700">Keypad</span>
                </button>
                <button class="flex flex-col items-center justify-center border border-gray-200 p-4 rounded-xl hover:bg-gray-50">
                    <i class="fa-regular fa-clipboard text-gray-600 text-lg mb-1"></i>
                    <span class="text-xs font-semibold text-gray-700">Notes</span>
                </button>
            </div>

            <button onclick="window.endActiveCall()" class="w-full py-3.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition flex items-center justify-center gap-2 shadow-md shadow-red-100">
                <i class="fa-solid fa-phone-slash"></i> End Call
            </button>
        </div>

        <!-- STEP 4: CALL ENDED SUMMARY -->
        <div id="view-ended" class="p-8 flex-col items-center text-center hidden">
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mb-4 text-emerald-600">
                <i class="fa-solid fa-check text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Call Ended</h3>
            <p class="text-base text-gray-600 mb-1">Your call with</p>
            <p class="text-xl font-bold text-emerald-600 mb-1">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier' }}</p>
            <p class="text-base text-gray-600 mb-6">has ended successfully.</p>
            
            <div class="border-t border-b w-full py-4 mb-6">
                <p class="text-xs font-semibold tracking-wider text-gray-400 uppercase mb-1">Duration</p>
                <div id="finalDuration" class="text-2xl font-bold text-gray-900">00:00</div>
            </div>

            <button onclick="window.closeCallModal()" class="w-full max-w-xs py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition">Done</button>
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