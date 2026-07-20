@extends('layouts.app')

@section('content')

<main class="flex-1 overflow-y-auto p-8 bg-[#f1f5f9] pb-24">
    <!-- Delivery Issues Dashboard -->

<div class="mb-6">
    <h2 class="text-2xl font-black text-[#1E3A8A]">
        Delivery Issues
    </h2>

    <p class="text-xs font-medium text-slate-400 mt-1">
        Inventory /
        <span class="text-slate-500">
            Delivery Issues
        </span>
    </p>
</div>


<!-- Summary Cards -->

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">
                    Total Issues
                </p>

                <h2 class="text-3xl font-black text-red-600 mt-2">

                    {{ count($deliveryIssues ?? []) }}

                </h2>
            </div>

            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-2xl">
                🚚
            </div>
        </div>
    </div>


    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">
        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Pending
                </p>

                <h2 class="text-3xl font-black text-yellow-500 mt-2">

                    {{ collect($deliveryIssues ?? [])->where('status','Pending')->count() }}

                </h2>

            </div>

            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-2xl">
                ⏳
            </div>

        </div>
    </div>


    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">

                    Resolved

                </p>

                <h2 class="text-3xl font-black text-green-600 mt-2">

                    {{ collect($deliveryIssues ?? [])->where('status','Resolved')->count() }}

                </h2>

            </div>

            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-2xl">
                ✅
            </div>

        </div>

    </div>


    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">

                    High Priority

                </p>

                <h2 class="text-3xl font-black text-blue-600 mt-2">

                    {{ collect($deliveryIssues ?? [])->where('priority','High')->count() }}

                </h2>

            </div>

            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                ⚠️
            </div>

        </div>

    </div>

</div>



<!-- Delivery Status -->

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">

        <h2 class="font-bold text-lg mb-5">

            Delivery Status

        </h2>

        <div class="space-y-4">

            <div class="flex justify-between">

                <span>Received</span>

                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">

                    Completed

                </span>

            </div>

            <div class="flex justify-between">

                <span>Inspection</span>

                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">

                    Ongoing

                </span>

            </div>

            <div class="flex justify-between">

                <span>Issue Investigation</span>

                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">

                    Active

                </span>

            </div>

            <div class="flex justify-between">

                <span>Finance Hold</span>

                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">

                    Waiting

                </span>

            </div>

        </div>

    </div>



    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">

        <h2 class="font-bold text-lg mb-5">

            Issue Categories

        </h2>

        <div class="space-y-3">

            <div class="flex justify-between">

                <span>Damaged Items</span>

                <strong>5</strong>

            </div>

            <div class="flex justify-between">

                <span>Late Deliveries</span>

                <strong>3</strong>

            </div>

            <div class="flex justify-between">

                <span>Missing Items</span>

                <strong>2</strong>

            </div>

            <div class="flex justify-between">

                <span>Wrong Items</span>

                <strong>1</strong>

            </div>

        </div>

    </div>



    <div class="bg-white rounded-2xl shadow border border-slate-200 p-6">

        <h2 class="font-bold text-lg mb-5">

            Alerts

        </h2>

        <div class="space-y-3">

            <div class="bg-red-100 rounded-xl p-3">

                🚚 Delayed shipment detected.

            </div>

            <div class="bg-yellow-100 rounded-xl p-3">

                📦 Quantity mismatch reported.

            </div>

            <div class="bg-blue-100 rounded-xl p-3">

                🔍 Waiting for warehouse inspection.

            </div>

            <div class="bg-green-100 rounded-xl p-3">

                ✔ Ready for resolution.

            </div>

        </div>

    </div>

</div>

<!-- Delivery Issues Table -->

<div class="bg-white rounded-2xl border border-slate-300 shadow overflow-hidden">

    <div class="p-5 border-b border-slate-200 bg-white">

        <div class="flex flex-wrap items-center justify-between gap-3">

            <h3 class="text-lg font-semibold text-slate-800">

                Delivery Issue Records

            </h3>

            <div class="flex flex-wrap items-center gap-2">

                <input
                    type="text"
                    id="searchIssue"
                    placeholder="Search issue..."
                    class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

                <select
                    id="statusFilter"
                    class="px-3 py-2 text-sm border border-slate-300 rounded-lg">

                    <option value="">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Investigating">Investigating</option>

                </select>

                <button
                    class="px-4 py-2 bg-[#00B074] text-white rounded-lg text-sm font-semibold">

                    Add Issue

                </button>

            </div>

        </div>

    </div>



    <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-slate-100 uppercase text-slate-600 text-xs">

                <tr>

                    <th class="px-5 py-3 text-left">Issue #</th>

                    <th class="px-5 py-3 text-left">Receipt #</th>

                    <th class="px-5 py-3 text-left">Supplier</th>

                    <th class="px-5 py-3 text-left">Item</th>

                    <th class="px-5 py-3 text-left">Issue Type</th>

                    <th class="px-5 py-3 text-left">Priority</th>

                    <th class="px-5 py-3 text-left">Status</th>

                    <th class="px-5 py-3 text-left">Reported Date</th>

                    <th class="px-5 py-3 text-center">Action</th>

                </tr>

            </thead>



            <tbody id="issueTable">

            @forelse($deliveryIssues as $issue)

            <tr class="border-b hover:bg-slate-50">

                <td class="px-5 py-4 font-semibold">

                    {{ $issue->id }}

                </td>

                <td class="px-5 py-4">

                    {{ $issue->receipt_number ?? '-' }}

                </td>

                <td class="px-5 py-4">

                    {{ $issue->supplier ?? '-' }}

                </td>

                <td class="px-5 py-4">

                    {{ $issue->item_name ?? '-' }}

                </td>

                <td class="px-5 py-4">

                    {{ $issue->issue_type ?? '-' }}

                </td>

                <td class="px-5 py-4">

                    @if(($issue->priority ?? '') == 'High')

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">

                            High

                        </span>

                    @elseif(($issue->priority ?? '') == 'Medium')

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">

                            Medium

                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">

                            Low

                        </span>

                    @endif

                </td>

                <td class="px-5 py-4">

                    @if(($issue->status ?? '') == 'Resolved')

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">

                            Resolved

                        </span>

                    @elseif(($issue->status ?? '') == 'Investigating')

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">

                            Investigating

                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">

                            Pending

                        </span>

                    @endif

                </td>

                <td class="px-5 py-4">

                    {{ $issue->created_at ?? '-' }}

                </td>

                <td class="px-5 py-4">

                    <div class="flex justify-center gap-2">

                        <button
                            class="px-3 py-2 bg-blue-600 text-white rounded text-xs">

                            View

                        </button>

                        <button
                            class="px-3 py-2 bg-yellow-500 text-white rounded text-xs">

                            Edit

                        </button>

                        <button
                            class="px-3 py-2 bg-green-600 text-white rounded text-xs">

                            Resolve

                        </button>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center py-10 text-slate-400">

                    No delivery issues found.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>
<!-- ===========================
Delivery Issue Details Modal
=========================== -->

<div id="viewIssueModal"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl w-[650px] max-h-[90vh] overflow-y-auto shadow-xl">

        <div class="flex items-center justify-between border-b p-5">
            <h2 class="text-lg font-bold">
                Delivery Issue Details
            </h2>

            <button onclick="closeViewModal()"
                    class="text-slate-500 hover:text-red-600 text-xl">
                ✕
            </button>
        </div>

        <div class="p-6">

            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="text-xs text-slate-500">
                        Receipt Number
                    </label>

                    <div class="mt-1 border rounded-lg p-3 bg-slate-50">
                        GR-2026-0001
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-500">
                        Supplier
                    </label>

                    <div class="mt-1 border rounded-lg p-3 bg-slate-50">
                        Sample Supplier
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-500">
                        Item
                    </label>

                    <div class="mt-1 border rounded-lg p-3 bg-slate-50">
                        Computer Part
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-500">
                        Issue Type
                    </label>

                    <div class="mt-1 border rounded-lg p-3 bg-slate-50">
                        Quantity Mismatch
                    </div>
                </div>

                <div class="col-span-2">

                    <label class="text-xs text-slate-500">
                        Remarks
                    </label>

                    <div class="mt-1 border rounded-lg p-3 bg-slate-50 h-24">

                        Dummy remarks here...

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ===========================
Dummy Edit Modal
=========================== -->

<div id="editIssueModal"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl w-[650px] shadow-xl">

        <div class="flex justify-between items-center border-b p-5">

            <h2 class="text-lg font-bold">

                Edit Delivery Issue

            </h2>

            <button onclick="closeEditModal()">

                ✕

            </button>

        </div>

        <div class="p-6">

            <div class="grid grid-cols-2 gap-4">

                <input
                    class="border rounded-lg p-3"
                    placeholder="Supplier">

                <input
                    class="border rounded-lg p-3"
                    placeholder="Item">

                <input
                    class="border rounded-lg p-3"
                    placeholder="Issue Type">

                <select class="border rounded-lg p-3">

                    <option>Pending</option>

                    <option>Investigating</option>

                    <option>Resolved</option>

                </select>

            </div>

            <div class="mt-6 flex justify-end gap-3">

                <button
                    onclick="closeEditModal()"
                    class="px-4 py-2 rounded bg-slate-200">

                    Cancel

                </button>

                <button
                    class="px-4 py-2 rounded bg-[#00B074] text-white">

                    Save

                </button>

            </div>

        </div>

    </div>

</div>


<script>

document
.getElementById("searchIssue")
.addEventListener("keyup", function(){

    let value=this.value.toLowerCase();

    let rows=document.querySelectorAll("#issueTable tr");

    rows.forEach(function(row){

        row.style.display=
        row.innerText.toLowerCase().includes(value)
        ? ""
        : "none";

    });

});


document
.getElementById("statusFilter")
.addEventListener("change",function(){

    let value=this.value.toLowerCase();

    let rows=document.querySelectorAll("#issueTable tr");

    rows.forEach(function(row){

        if(value===""){

            row.style.display="";

        }

        else{

            row.style.display=
            row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";

        }

    });

});


function closeViewModal(){

    document
    .getElementById("viewIssueModal")
    .classList
    .add("hidden");

}


function closeEditModal(){

    document
    .getElementById("editIssueModal")
    .classList
    .add("hidden");

}

</script>


@endsection