@extends('layouts.app')

@section('content')

<div class="bg-[#f1f5f9] min-h-screen p-8 pb-24">
     <div class="mb-5">
        <h2 class="text-2xl font-black text-[#1E3A8A]">
            Payment Validation
        </h2>
        <p class="text-xs font-medium text-slate-400 mt-0.5">
             Receipt /
            <span class="text-slate-500">
                Payment Validation
            </span>
        </p>
    </div>

   <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Sent to Finance (Pinalitan ang Pending Validation) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Sent to Finance</p>
                    <h2 class="text-3xl font-bold text-emerald-600 mt-2">{{ $sentToFinanceCount ?? 0 }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-emerald-100 text-2xl">📤</div>
            </div>
        </div>

        <!-- Approved Payments -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Approved Payments</p>
                    <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $approvedPaymentsCount ?? 0 }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-2xl">✅</div>
            </div>
        </div>

        <!-- Payment Issues -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Payment Issues</p>
                    <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $paymentIssuesCount ?? 0 }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 text-2xl">⚠️</div>
            </div>
        </div>
    </div>

    <!-- Payment Validation Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">
            <h2 class="text-lg font-bold text-slate-800 mb-5">Validation Workflow</h2>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span>Invoice Received</span>
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">DONE</span>
                </div>
                <div class="flex justify-between">
                    <span>3-Way Match</span>
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">VERIFIED</span>
                </div>
                <div class="flex justify-between">
                    <span>Finance Review</span>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">IN PROGRESS</span>
                </div>
                <div class="flex justify-between">
                    <span>Payment Release</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">WAITING</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">
            <h2 class="text-lg font-bold text-slate-800 mb-5">Validation Summary</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span>Total Invoices</span>
                    <strong>{{ $totalInvoices ?? 0 }}</strong>
                </div>
                <div class="flex justify-between">
                    <span>Validated</span>
                    <strong class="text-green-600">{{ $approvedPaymentsCount ?? 0 }}</strong>
                </div>
                <div class="flex justify-between">
                    <span>Pending</span>
                    <strong class="text-yellow-600">{{ $pendingValidationCount ?? 0 }}</strong>
                </div>
                <div class="flex justify-between">
                    <span>Rejected/Issues</span>
                    <strong class="text-red-600">{{ $paymentIssuesCount ?? 0 }}</strong>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">
            <h2 class="text-lg font-bold text-slate-800 mb-5">Finance Alerts</h2>
            <div class="space-y-3 text-xs font-medium">
                <div class="bg-[#FFE5A5] rounded-xl p-3">💳 {{ $pendingValidationCount ?? 0 }} invoices awaiting approval</div>
                <div class="bg-[#BFE8FF] rounded-xl p-3">📄 {{ $approvedPaymentsCount ?? 0 }} validated invoices</div>
                <div class="bg-[#FFD4D4] rounded-xl p-3">⚠ {{ $paymentIssuesCount ?? 0 }} payment discrepancies</div>
                <div class="bg-[#D9FFE5] rounded-xl p-3">✔ Ready for payment release</div>
            </div>
        </div>
    </div>

    <!-- Payment Validation Table -->
    <div class="bg-white rounded-2xl border border-slate-300 shadow overflow-hidden mt-6">
        <div class="p-5 border-b border-slate-200 bg-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-slate-800">
                    Payment Validation Records
                </h3>
                <div class="flex flex-wrap items-center gap-2">
                    <input type="text" id="searchPayment" placeholder="Search payment..." class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    <select id="paymentFilter" class="px-3 py-2 text-sm border border-slate-300 rounded-lg">
                        <option value="">All Status</option>
                        <option value="MATCHED">Validated</option>
                        <option value="PENDING">Pending</option>
                        <option value="MISMATCH">Mismatch</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-100 uppercase text-slate-600 text-xs">
                    <tr>
                        <th class="px-5 py-3 text-left">PO Number</th>
                        <th class="px-5 py-3 text-left">Supplier</th>
                        <th class="px-5 py-3 text-left">Item</th>
                        <th class="px-5 py-3 text-right">PO Price</th>
                        <th class="px-5 py-3 text-right">Invoice Price</th>
                        <th class="px-5 py-3 text-center">Match Status</th>
                        <th class="px-5 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="paymentTable">
                    @forelse($receipts ?? [] as $receipt)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-5 py-4 font-bold text-blue-900">{{ $receipt->po_number ?? 'N/A' }}</td>
                        <td class="px-5 py-4">{{ $receipt->supplier ?? 'N/A' }}</td>
                        <td class="px-5 py-4">{{ $receipt->item_name ?? 'N/A' }}</td>
                        <td class="px-5 py-4 text-right">₱{{ number_format($receipt->po_price ?? 0, 2) }}</td>
                        <td class="px-5 py-4 text-right">₱{{ number_format($receipt->invoice_price ?? 0, 2) }}</td>
                     <td class="px-5 py-4 text-center">
    <span class="px-3 py-1 rounded-full text-xs font-bold
        @if(($receipt->match_status ?? '') == 'SENT TO FINANCE' || !empty($receipt->approved_at)) bg-green-100 text-green-700
        @elseif(($receipt->match_status ?? '') == 'MATCHED' || ($receipt->match_status ?? '') == 'COMPLETED') bg-green-100 text-green-700
        @elseif(str_contains($receipt->match_status ?? '', 'MISMATCH')) bg-red-100 text-red-700
        @else bg-yellow-100 text-yellow-700 @endif">
        {{ !empty($receipt->approved_at) ? 'SENT TO FINANCE' : ($receipt->match_status ?? 'PENDING') }}
    </span>
</td>
                        <td class="px-5 py-4 text-center">
    <div class="flex justify-center items-center gap-1.5">
        <!-- View Button -->
        <button type="button" onclick="viewDetails({{ $receipt->id }})" title="View Details" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 rounded-xl transition shadow-xs cursor-pointer">
            <i class="fa-solid fa-eye text-xs"></i>
        </button>

        @php
            $status = strtoupper($receipt->match_status ?? 'PENDING');
        @endphp

        {{-- If Pending or Mismatch: Show Validate Button --}}
        @if($status == 'PENDING' || str_contains($status, 'MISMATCH'))
            <button type="button" onclick="validatePaymentRecord({{ $receipt->id }})" title="Validate Payment" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-yellow-50 text-slate-500 hover:text-yellow-600 border border-slate-200 rounded-xl transition shadow-xs cursor-pointer">
                <i class="fa-solid fa-check text-xs"></i>
            </button>
        
        {{-- If Completed/Validated: Show Approve Button (Send to Finance) --}}
        @elseif($status == 'COMPLETED' || $status == 'MATCHED')
            @if(!empty($receipt->approved_at))
                {{-- Kapag na-approve na at may approved_at na, itabi ang badge na parang sa taas --}}
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200">Sent to Finance</span>
            @else
                <form action="{{ route('receipts.approve', $receipt->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" title="Approve & Send to Finance" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-green-50 text-slate-500 hover:text-green-600 border border-slate-200 rounded-xl transition shadow-xs cursor-pointer">
                        <i class="fa-solid fa-thumbs-up text-xs"></i>
                    </button>
                </form>
            @endif
        
        {{-- If Already Approved / Sent to Finance --}}
        @else
            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200">Sent to Finance</span>
        @endif
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-slate-400">No payment records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const searchPayment = document.getElementById("searchPayment");
const paymentFilter = document.getElementById("paymentFilter");

function filterPaymentTable() {
    const searchValue = searchPayment.value.toLowerCase();
    const filterValue = paymentFilter.value.toLowerCase();
    const rows = document.querySelectorAll("#paymentTable tr");

    rows.forEach(function(row) {
        const text = row.textContent.toLowerCase();
        const searchMatch = searchValue === "" || text.includes(searchValue);
        const filterMatch = filterValue === "" || text.includes(filterValue);
        row.style.display = (searchMatch && filterMatch) ? "" : "none";
    });
}

searchPayment.addEventListener("keyup", filterPaymentTable);
paymentFilter.addEventListener("change", filterPaymentTable);

function validatePaymentRecord(id) {
    if(confirm('Do you want to validate this payment? Status will be marked as Completed.')) {
        fetch('/receipts/validate-payment/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error validating payment.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Can't connect to server.");
        });
    }
}

function viewDetails(id) {
    fetch('/receipts/' + id)
        .then(response => response.json())
        .then(data => {
            const modal = document.getElementById('matchingDetailsModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('matchingModalContent').innerHTML = `
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">PO Number</label>
                        <div class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                            ${data.po_number ?? 'N/A'}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Supplier</label>
                        <div class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 truncate">
                            ${data.supplier ?? 'N/A'}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Item</label>
                        <div class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 truncate">
                            ${data.item_name ?? 'N/A'}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Match Status</label>
                        <div class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                            ${data.match_status ?? 'PENDING'}
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeMatchingModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold cursor-pointer transition">
                        Close
                    </button>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to retrieve receipt details.');
        });
}

function closeMatchingModal() {
    const modal = document.getElementById('matchingDetailsModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>

<!-- View Details Modal -->
<div id="matchingDetailsModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg border border-slate-200 overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h3 class="text-base font-bold text-slate-800">Payment Validation Details</h3>
            <button type="button" onclick="closeMatchingModal()" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-200 transition cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6" id="matchingModalContent">
            <!-- Dynamic Content -->
        </div>
    </div>
</div>
@endsection