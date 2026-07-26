<table class="min-w-full">
  <thead class="bg-slate-100 text-slate-700">
    <tr>
      <th class="px-5 py-4 text-left">PO Number</th>
      <th class="px-5 py-4 text-left">Supplier</th>
      <th class="px-5 py-4 text-left">Item</th>
      <th class="px-5 py-4 text-center">PO Qty</th>
      <th class="px-5 py-4 text-center">Received Qty</th>
      <th class="px-5 py-4 text-right">PO Price</th>
      <th class="px-5 py-4 text-right">Invoice Price</th>
      <th class="px-5 py-4 text-center">Inspection</th>
      <th class="px-5 py-4 text-center">Result</th>
      <th class="px-5 py-4 text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($receipts as $receipt)
    <tr class="border-b hover:bg-slate-50 transition">
      <td class="px-5 py-4 font-semibold">{{ $receipt->po_number }}</td>
      <td class="px-5 py-4">{{ $receipt->supplier }}</td>
      <td class="px-5 py-4">{{ $receipt->item_name }}</td>
      <td class="px-5 py-4 text-center">{{ $receipt->po_quantity }}</td>
      <td class="px-5 py-4 text-center">{{ $receipt->gr_quantity }}</td>
      <td class="px-5 py-4 text-right">₱{{ number_format($receipt->po_price, 2) }}</td>
      <td class="px-5 py-4 text-right">₱{{ number_format($receipt->invoice_price, 2) }}</td>
      <td class="px-5 py-4 text-center">
        @if($receipt->inspection_status=="Passed")
          <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">PASSED</span>
        @elseif($receipt->inspection_status=="Failed")
          <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">FAILED</span>
        @else
          <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">PENDING</span>
        @endif
      </td>
      <td class="px-5 py-4 text-center">
        @php $effectiveStatus = $receipt->effective_match_status; @endphp
        @if($effectiveStatus=="MATCHED")
          <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">MATCHED</span>
        @elseif($effectiveStatus=="PRICE MISMATCH")
          <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">PRICE MISMATCH</span>
        @elseif($effectiveStatus=="QTY MISMATCH")
          <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">QTY MISMATCH</span>
        @else
          <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">PENDING</span>
        @endif
      </td>
      <td class="px-5 py-4 text-center">
        <button onclick="viewDetails({{ $receipt->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold">
          <i class="fa-solid fa-eye mr-1"></i> View Details
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<!-- Pagination links -->
<div class="mt-4">
  {{ $receipts->appends(request()->query())->links() }}
</div>

<!-- Confirmation Script -->
<script>
function viewDetails(id) {
    if (confirm("Are you sure you want to view this 3-way matching?")) {
        window.location.href = "/receipts/" + id + "/details";
    }
}
</script>