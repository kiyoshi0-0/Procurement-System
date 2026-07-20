@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Contracts</h1>
        <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Supplier Management</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Contracts</span>
        </div>
    </div>

    <!-- Main Workspace -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-4">
        <!-- Toolbar -->
        <div class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <!-- Toolbar: Replace your existing div with this form -->
            <!-- Toolbar -->
            <form action="{{ route('suppliers.contracts') }}" method="GET" class="flex items-center w-full">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search contract by supplier name..." 
                        class="w-full border border-gray-300 rounded-lg pl-10 pr-12 py-2.5 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                    >
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                    
                    <!-- Aligned Arrow Button -->
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-gray-400 hover:text-emerald-600 transition">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Contracts List -->
        <div class="space-y-3">
            @forelse($contracts as $contract)
            <div class="border border-gray-200 rounded-xl p-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-gray-50/30 hover:bg-gray-50 transition">
                <div class="flex items-center space-x-4">
                    {{-- Dynamic Icon based on Supplier Category --}}
                    <div class="w-12 h-12 bg-white rounded-xl border border-gray-200 flex items-center justify-center text-xl {{ $contract->supplier->category_icon_color }}">
                        <i class="fa-solid {{ $contract->supplier->category_icon }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">{{ $contract->supplier->name }}</h4>
                        <p class="text-xs text-gray-700 font-mono font-medium mt-0.5">{{ $contract->contract_id }}</p>
                        <p class="text-[11px] text-gray-400 mt-1 font-medium">
                            {{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }} - 
                            {{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                    <button onclick="toggleBookmark(this)" class="p-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-amber-50/50 hover:text-amber-500 hover:border-amber-200 transition-all duration-200 shadow-xs">
                        <i class="fa-regular fa-bookmark"></i>
                    </button>
                    <button onclick="viewPdf('{{ $contract->supplier->name }}', '{{ $contract->contract_id }}')" class="px-4 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">View PDF</button>
                    <button onclick="triggerDownload('{{ $contract->supplier->name }}')" class="px-4 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">Download</button>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-bold text-xs rounded-lg uppercase tracking-wide">Active</span>
                </div>
            </div>
            @empty
                <p class="text-center text-gray-500 py-10">No contracts found.</p>
            @endforelse
        </div>
    </div>

    <!-- PDF MODAL WITH FAKE CONTRACT CONTENT -->
    <div id="pdfModal" class="fixed inset-0 bg-black/50 z-50 items-center justify-center p-4 hidden opacity-0 transition-all duration-300">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl h-[85vh] flex flex-col overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <div>
                    <h3 id="modalContractTitle" class="font-bold text-gray-900"></h3>
                    <p id="modalContractId" class="text-xs text-gray-500 font-mono"></p>
                </div>
                <button onclick="closePdf()" class="text-gray-500 hover:text-black"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <!-- PDF Canvas -->
            <!-- Added 'w-full' to the container and 'mx-auto' to the inner paper -->
            <div class="flex-1 bg-gray-200 p-6 overflow-y-auto flex justify-center w-full">
                <div class="bg-white max-w-2xl w-full mx-auto min-h-[800px] p-12 shadow-lg text-gray-800 space-y-6">
                    
                    <!-- Contract Content -->
                    <h1 class="text-center font-black text-2xl border-b-2 border-black pb-4">SERVICE LEVEL AGREEMENT</h1>
                    
                    <p class="text-sm">This agreement is entered into by <b>Procurement Corp</b> and <b><span id="modalSupplierLabel"></span></b>.</p>
                    
                    <div class="space-y-4 text-xs">
                        <p><b>1. SCOPE:</b> The Supplier agrees to provide all requested components with 99.9% uptime and standard industry quality.</p>
                        <p><b>2. PAYMENT:</b> Net-30 payment terms apply upon delivery and inspection of goods.</p>
                        <p><b>3. CONFIDENTIALITY:</b> All pricing and technical specifications remain strictly confidential between both parties.</p>
                        <p><b>4. TERM:</b> This contract remains valid for the duration specified in the database records associated with the Supplier ID.</p>
                    </div>
                    
                    <div class="pt-10 grid grid-cols-2 gap-8 text-xs border-t mt-10">
                        <div><p class="font-bold border-t border-black pt-1">Authorized Signature (Client)</p></div>
                        <div><p class="font-bold border-t border-black pt-1">Authorized Signature (Supplier)</p></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- DOWNLOAD TOAST -->
    <div id="downloadToast" class="fixed bottom-6 right-6 z-50 bg-white rounded-xl shadow-xl border border-gray-200 p-4 max-w-sm hidden transform translate-y-10 opacity-0 transition-all duration-300">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600"><i class="fa-solid fa-circle-check"></i></div>
            <div>
                <p class="text-sm font-bold text-gray-900">Download Complete</p>
                <p id="toastMessage" class="text-xs text-gray-500"></p>
            </div>
        </div>
    </div>
</div>

<script>
function toggleBookmark(button) {
    const icon = button.querySelector('i');
    
    // Check if it's currently in the default gray state
    if (icon.classList.contains('fa-regular')) {
        // Change to "Active" (Vibrant Purple)
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
        
        // Remove gray classes and add Purple classes
        button.classList.remove('text-gray-500', 'border-gray-300', 'bg-white');
        button.classList.add('text-purple-600', 'border-purple-400', 'bg-purple-50');
    } else {
        // Toggle back to "Inactive" (Gray)
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
        
        // Remove Purple classes and add Gray classes
        button.classList.remove('text-purple-600', 'border-purple-400', 'bg-purple-50');
        button.classList.add('text-gray-500', 'border-gray-300', 'bg-white');
    }
}

function viewPdf(name, id) {
    const modal = document.getElementById('pdfModal');
    document.getElementById('modalContractTitle').innerText = name;
    document.getElementById('modalContractId').innerText = id;
    document.getElementById('modalSupplierLabel').innerText = name;
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.remove('opacity-0'), 20);
}

function closePdf() {
    const modal = document.getElementById('pdfModal');
    modal.classList.add('opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

function triggerDownload(name) {
    const toast = document.getElementById('downloadToast');
    document.getElementById('toastMessage').innerText = `${name} contract file saved.`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.remove('translate-y-10', 'opacity-0'), 20);
    setTimeout(() => {
        toast.classList.add('translate-y-10', 'opacity-0');
        setTimeout(() => toast.classList.add('hidden'), 300);
    }, 4500);
}
</script>
@endsection