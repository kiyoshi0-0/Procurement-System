@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header with Breadcrumbs -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Evaluate Supplier</h1>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
                <span>Dashboard</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span>Supplier Management</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <a href="{{ route('suppliers.index') }}" class="hover:underline">Supplier List</a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <a href="{{ route('suppliers.show', $supplier->id ?? $supplier['id'] ?? 1) }}" class="hover:underline">{{ $supplier->name ?? $supplier['name'] ?? 'Supplier Details' }}</a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-gray-800 font-medium">Performance Evaluation</span>
            </div>
        </div>
    </div>

    <!-- Back Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('suppliers.show', $supplier->id ?? $supplier['id'] ?? 1) }}" class="inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg bg-white text-xs font-semibold text-gray-600 hover:bg-gray-50 shadow-xs transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Profile</span>
        </a>
    </div>

    <!-- Dynamic Supplier Header Panel -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100 flex items-center justify-center text-xl">
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Performance Assessment Framework</h2>
                <p class="text-xs text-gray-500 mt-0.5">Currently analyzing: <strong class="text-gray-700 font-semibold">{{ $supplier->name ?? $supplier['name'] ?? 'N/A' }}</strong> ({{ $supplier->category ?? $supplier['category'] ?? 'General' }})</p>
            </div>
        </div>
        <div class="text-left sm:text-right text-xs">
            <p class="text-gray-400 font-medium">Operational Terms</p>
            <p class="text-gray-800 font-bold mt-0.5">{{ $supplier->payment_terms ?? $supplier['payment_terms'] ?? 'None specified' }} • {{ $supplier->delivery_schedule ?? $supplier['delivery_schedule'] ?? 'Standard Schedule' }}</p>
        </div>
    </div>

    <!-- Evaluation Form Matrix -->
    <form action="{{ route('suppliers.storeEvaluation', $supplier->id ?? $supplier['id']) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        
        <!-- Left Forms Area: Evaluation Metrics -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Scorecard Parameters</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Grade each operational aspect on a scale of 1 to 5 stars.</p>
                </div>

                <!-- Metric 1: Delivery & Timeliness -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">1. Delivery & Timeliness</label>
                        <span class="text-[11px] text-gray-400">Baseline Target: {{ $supplier->delivery_schedule ?? $supplier['delivery_schedule'] ?? 'Standard' }}</span>
                    </div>
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-between">
                        <p class="text-xs text-gray-600 max-w-md">Assesses commitments to arrival estimates, lead times, and scheduling alignments.</p>
                        <div class="flex items-center space-x-1 rating-stars text-gray-300 text-lg cursor-pointer">
                            <input type="hidden" name="metrics[delivery]" value="0" id="metric-delivery">
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="1"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="2"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="3"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="4"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="5"></i>
                        </div>
                    </div>
                </div>

                <!-- Metric 2: Product Quality & Conformance -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block">2. Quality & Defect Rates</label>
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-between">
                        <p class="text-xs text-gray-600 max-w-md">Evaluates physical condition of component arrivals, packaging durability, and error exemptions.</p>
                        <div class="flex items-center space-x-1 rating-stars text-gray-300 text-lg cursor-pointer">
                            <input type="hidden" name="metrics[quality]" value="0" id="metric-quality">
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="1"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="2"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="3"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="4"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="5"></i>
                        </div>
                    </div>
                </div>

                <!-- Metric 3: Commercial & Pricing Agility -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block">3. Commercial Pricing & Terms</label>
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-between">
                        <p class="text-xs text-gray-600 max-w-md">Measures market price competitiveness, bulk discounts, and accuracy of transaction invoicing.</p>
                        <div class="flex items-center space-x-1 rating-stars text-gray-300 text-lg cursor-pointer">
                            <input type="hidden" name="metrics[pricing]" value="0" id="metric-pricing">
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="1"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="2"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="3"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="4"></i>
                            <i class="fa-solid fa-star transition hover:text-yellow-400" data-value="5"></i>
                        </div>
                    </div>
                </div>

                <!-- Comments & Action Items -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block">Operational Notes & Audit Summary</label>
                    <textarea name="notes" rows="4" class="w-full text-xs p-3 border border-gray-300 rounded-xl focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none" placeholder="Provide context regarding the scoring parameters, historical delays, or exceptional quality marks..."></textarea>
                </div>
            </div>
        </div>

        <!-- Right Forms Area: Control Panel & Submission -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Evaluation Registry</h3>
                
                <div class="space-y-3 text-xs border-b pb-4">
                    <div>
                        <p class="font-medium text-gray-400">Primary Contact</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $supplier->contact_person ?? $supplier['contact_person'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-400">Contact Line</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $supplier->phone ?? $supplier['phone'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition shadow-xs text-xs">
                        Commit Evaluation Matrix
                    </button>
                    <a href="{{ route('suppliers.show', $supplier->id ?? $supplier['id'] ?? 1) }}" class="w-full block text-center mt-2 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition text-xs">
                        Discard Changes
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.rating-stars').forEach(container => {
        const stars = container.querySelectorAll('i');
        const hiddenInput = container.querySelector('input[type="hidden"]');

        // Ensure this logic is inside your existing script block
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                // This ensures only the hidden input in the current metric row is updated
                hiddenInput.value = value; 
                
                // Visual feedback
                stars.forEach(s => {
                    s.classList.toggle('text-yellow-400', parseInt(s.getAttribute('data-value')) <= parseInt(value));
                    s.classList.toggle('text-gray-300', parseInt(s.getAttribute('data-value')) > parseInt(value));
                });
            });
        });
    });
</script>
@endsection