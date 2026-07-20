@extends('layouts.app')

@section('content')

<div class="bg-[#f1f5f9] min-h-screen p-8 pb-24">
     <div class="mb-5">

        <h2 class="text-2xl font-black text-[#1E3A8A]">
            Payment Validation
        </h2>

        <p class="text-xs font-medium text-slate-400 mt-0.5">
            Inventory /
            <span class="text-slate-500">
                Payment Validation
            </span>
        </p>

    </div>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Pending Validation -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Pending Validation
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                        12
                    </h2>

                </div>

                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-100 text-2xl">

                    💳

                </div>

            </div>

        </div>

        <!-- Approved Payments -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Approved Payments
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        86
                    </h2>

                </div>

                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-2xl">

                    ✅

                </div>

            </div>

        </div>

        <!-- Payment Issues -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Payment Issues
                    </p>

                    <h2 class="text-3xl font-bold text-red-600 mt-2">
                        4
                    </h2>

                </div>

                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 text-2xl">

                    ⚠️

                </div>

            </div>

        </div>

    </div>

    <!-- Payment Validation Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">

            <h2 class="text-lg font-bold text-slate-800 mb-5">

                Validation Workflow

            </h2>

            <div class="space-y-4">

                <div class="flex justify-between">

                    <span>Invoice Received</span>

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                        DONE
                    </span>

                </div>

                <div class="flex justify-between">

                    <span>3-Way Match</span>

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                        VERIFIED
                    </span>

                </div>

                <div class="flex justify-between">

                    <span>Finance Review</span>

                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                        IN PROGRESS
                    </span>

                </div>

                <div class="flex justify-between">

                    <span>Payment Release</span>

                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                        WAITING
                    </span>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">

            <h2 class="text-lg font-bold text-slate-800 mb-5">

                Validation Summary

            </h2>

            <div class="space-y-3 text-sm">

                <div class="flex justify-between">
                    <span>Total Invoices</span>
                    <strong>90</strong>
                </div>

                <div class="flex justify-between">
                    <span>Validated</span>
                    <strong class="text-green-600">74</strong>
                </div>

                <div class="flex justify-between">
                    <span>Pending</span>
                    <strong class="text-yellow-600">12</strong>
                </div>

                <div class="flex justify-between">
                    <span>Rejected</span>
                    <strong class="text-red-600">4</strong>
                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl p-6 shadow border border-slate-200">

            <h2 class="text-lg font-bold text-slate-800 mb-5">

                Finance Alerts

            </h2>

            <div class="space-y-3">

                <div class="bg-[#FFE5A5] rounded-xl p-3">
                    💳 12 invoices awaiting approval
                </div>

                <div class="bg-[#BFE8FF] rounded-xl p-3">
                    📄 74 validated invoices
                </div>

                <div class="bg-[#FFD4D4] rounded-xl p-3">
                    ⚠ 4 payment discrepancies
                </div>

                <div class="bg-[#D9FFE5] rounded-xl p-3">
                    ✔ Ready for payment release
                </div>

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

                <input
                    type="text"
                    id="searchPayment"
                    placeholder="Search payment..."
                    class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

                <select
                    id="paymentFilter"
                    class="px-3 py-2 text-sm border border-slate-300 rounded-lg">

                    <option value="">All Status</option>
                    <option>Validated</option>
                    <option>Pending</option>
                    <option>Mismatch</option>

                </select>

                <button class="px-4 py-2 bg-[#00B074] text-white rounded-lg text-sm font-semibold">
                    Validate Payment
                </button>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-slate-100 uppercase text-slate-600 text-xs">

                <tr>

                    <th class="px-5 py-3 text-left">Payment #</th>
                    <th class="px-5 py-3 text-left">Invoice #</th>
                    <th class="px-5 py-3 text-left">PO Number</th>
                    <th class="px-5 py-3 text-left">Supplier</th>
                    <th class="px-5 py-3 text-right">Amount</th>
                    <th class="px-5 py-3 text-left">Validation</th>
                    <th class="px-5 py-3 text-left">Payment Status</th>
                    <th class="px-5 py-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody id="paymentTable">

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-5 py-4 font-bold">PAY-0001</td>
                    <td class="px-5 py-4">INV-2026-001</td>
                    <td class="px-5 py-4">PO-2026-0001</td>
                    <td class="px-5 py-4">ASUS Philippines</td>
                    <td class="px-5 py-4 text-right">₱125,000.00</td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Validated
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                            Pending
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-xs">View</button>
                            <button class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">Validate</button>
                            <button class="px-3 py-2 bg-green-600 text-white rounded text-xs">Approve</button>
                        </div>
                    </td>

                </tr>

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-5 py-4 font-bold">PAY-0002</td>
                    <td class="px-5 py-4">INV-2026-002</td>
                    <td class="px-5 py-4">PO-2026-0002</td>
                    <td class="px-5 py-4">Corsair PH</td>
                    <td class="px-5 py-4 text-right">₱89,500.00</td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                            Pending
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                            Pending
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-xs">View</button>
                            <button class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">Validate</button>
                            <button class="px-3 py-2 bg-green-600 text-white rounded text-xs">Approve</button>
                        </div>
                    </td>

                </tr>

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-5 py-4 font-bold">PAY-0003</td>
                    <td class="px-5 py-4">INV-2026-003</td>
                    <td class="px-5 py-4">PO-2026-0003</td>
                    <td class="px-5 py-4">Kingston Technology</td>
                    <td class="px-5 py-4 text-right">₱56,750.00</td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Validated
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Approved
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-xs">View</button>
                            <button class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">Validate</button>
                            <button class="px-3 py-2 bg-green-600 text-white rounded text-xs">Approve</button>
                        </div>
                    </td>

                </tr>

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-5 py-4 font-bold">PAY-0004</td>
                    <td class="px-5 py-4">INV-2026-004</td>
                    <td class="px-5 py-4">PO-2026-0004</td>
                    <td class="px-5 py-4">Samsung Electronics</td>
                    <td class="px-5 py-4 text-right">₱132,000.00</td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                            Mismatch
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                            On Hold
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-xs">View</button>
                            <button class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">Validate</button>
                            <button class="px-3 py-2 bg-green-600 text-white rounded text-xs">Approve</button>
                        </div>
                    </td>

                </tr>

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-5 py-4 font-bold">PAY-0005</td>
                    <td class="px-5 py-4">INV-2026-005</td>
                    <td class="px-5 py-4">PO-2026-0005</td>
                    <td class="px-5 py-4">Logitech Inc.</td>
                    <td class="px-5 py-4 text-right">₱48,900.00</td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Validated
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Approved
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-xs">View</button>
                            <button class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">Validate</button>
                            <button class="px-3 py-2 bg-green-600 text-white rounded text-xs">Approve</button>
                        </div>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>


<div class="flex items-center justify-between px-6 py-4 border-t border-slate-200 bg-slate-50">

    <div class="text-sm text-slate-500">

        Showing
        <span class="font-semibold text-slate-700">1</span>
        to
        <span class="font-semibold text-slate-700">5</span>
        of
        <span class="font-semibold text-slate-700">5</span>
        payment records

    </div>

    <div class="flex items-center gap-2">

        <button
            class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-100">

            Previous

        </button>

        <button
            class="px-4 py-2 rounded-lg bg-[#00B074] text-white font-semibold">

            1

        </button>

        <button
            class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-100">

            Next

        </button>

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

        const searchMatch =
            searchValue === "" || text.includes(searchValue);

        const filterMatch =
            filterValue === "" || text.includes(filterValue);

        row.style.display =
            (searchMatch && filterMatch) ? "" : "none";

    });

}

searchPayment.addEventListener("keyup", filterPaymentTable);

paymentFilter.addEventListener("change", filterPaymentTable);

</script>
@endsection