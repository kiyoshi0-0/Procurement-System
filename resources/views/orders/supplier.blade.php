@extends('layouts.app')

<section id="supplier-view" class="view-panel space-y-6 max-w-7xl w-full mx-auto hidden">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6 space-y-6">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Live print-view preview</h1>
            <button id="backToPoDetailsFromSupplierBtn" class="text-gray-400 hover:text-gray-600 text-sm font-semibold">✕ Close Preview</button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="lg:col-span-8 border border-gray-300 rounded-xl p-8 space-y-8 bg-white shadow-sm">
                <div class="flex justify-between items-start text-xs">
                    <div class="space-y-1">
                        <h2 class="text-sm font-extrabold text-gray-900">ABC Company</h2>
                        <p class="text-gray-500 leading-relaxed">Blk 51 Lot 12A,<br>Barangay. San Andres 1,<br>Dasmariñas, Cavite</p>
                    </div>
                    <div class="text-right space-y-1">
                        <h2 id="supplierViewPoNum" class="text-2xl font-black text-gray-950">PO - 101</h2>
                        <p class="text-gray-700 font-bold"><span class="text-gray-400 font-normal">Date:</span> <span id="supplierViewDate">June 28, 2026</span></p>
                        <p class="text-gray-700 font-bold"><span class="text-gray-400 font-normal">Reference:</span> <span id="supplierViewRef">PO - 101</span></p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div class="grid grid-cols-2 gap-8 text-xs">
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px]">Supplier:</h3>
                        <p id="supplierViewCompName" class="text-gray-500">(Company NAME)</p>
                        <p class="text-gray-500">Contract: Active Agreement</p>
                        <p class="text-gray-700 font-semibold">Email: <span id="supplierViewEmail" class="font-normal text-gray-500">su*****23@yahoo.com</span></p>
                        <p class="text-gray-700 font-semibold">Phone: <span id="supplierViewPhone" class="font-normal text-gray-500">09224238767</span></p>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px]">Delivery Address:</h3>
                        <p id="supplierViewDeliveryAddress" class="text-gray-500 leading-relaxed">Blk 51 Lot 12A,<br>Barangay. San Andres 1,<br>Dasmariñas, Cavite</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-separate border-spacing-y-1.5">
                        <thead class="bg-[#9ae3ca] text-gray-800 font-bold">
                            <tr>
                                <th class="p-2.5 rounded-l-md border border-r-0 border-emerald-300">#</th>
                                <th class="p-2.5 border-y border-emerald-300 text-center">Supplier Item</th>
                                <th class="p-2.5 border-y border-emerald-300 text-center">Quantity</th>
                                <th class="p-2.5 border-y border-emerald-300 text-center">Unit Price</th>
                                <th class="p-2.5 rounded-r-md border border-l-0 border-emerald-300 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody id="supplierViewItemTable" class="text-gray-700 font-semibold">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start pt-2">
                    <div class="md:col-span-6 space-y-1 text-xs">
                        <h4 class="font-bold text-gray-900">Notes:</h4>
                        <p class="text-gray-500">Thank you for your business!</p>
                    </div>
                    <div class="md:col-span-6 text-xs space-y-2">
                        <div class="flex justify-between text-gray-500"><span>Subtotal</span><span id="supplierViewSubtotal" class="font-bold text-gray-800">₱150,000</span></div>
                        <div class="flex justify-between text-gray-500"><span>Tax</span><span class="font-bold text-gray-800">₱0</span></div>
                        <div class="flex justify-between text-gray-500 border-b pb-2"><span>Shipping</span><span class="font-bold text-gray-800">₱0</span></div>
                        <div class="flex justify-between font-black text-sm text-gray-900 pt-1"><span>TOTAL</span><span id="supplierViewTotal">₱150,000</span></div>
                    </div>
                </div>

                <div class="text-[10px] text-gray-400 pt-4 border-t border-gray-100">
                    This is a system generated document. No signature required.
                </div>
            </div>

            <div class="lg:col-span-4 border border-gray-200 rounded-2xl p-5 bg-white space-y-5">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Recipients</label>
                    <div class="border border-gray-300 rounded-xl p-3 bg-white text-xs space-y-1.5 text-gray-600 font-medium">
                        <div class="flex items-center gap-1"><span class="text-gray-400">email:</span><span id="supplierEmailBox1">da***y@yahoo.com</span></div>
                        <div class="flex items-center gap-1"><span class="text-gray-400">email:</span><span id="supplierEmailBox2">jo**a@gmail.com</span></div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Subject</label>
                    <input type="text" id="supplierEmailSubjectInput" value="Purchase Order PO - 101" class="w-full bg-white border border-gray-300 shadow-sm rounded-xl px-4 py-2 text-xs text-gray-700 font-semibold focus:outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800 block">Email Message</label>
                    <div class="w-full bg-white border border-gray-300 shadow-sm rounded-xl p-4 text-xs text-gray-600 space-y-4 leading-relaxed font-medium">
                        <p>Hello,<br>Please find attached Purchase Order <span id="supplierEmailMsgPoNum">PO - 101</span>.</p>
                        <p>Thank you,<br>ABC Company</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    <button onclick="alert('Email dispatch successfully initiated!')" class="w-full bg-[#00b074] text-white font-semibold py-2.5 px-4 rounded-xl text-xs hover:bg-emerald-600 transition shadow-sm">
                        Send via Email
                    </button>
                    <button onclick="alert('Downloading PDF instance...')" class="w-full bg-white border border-gray-300 py-2.5 px-4 rounded-xl text-xs hover:bg-gray-55 text-gray-700 font-semibold transition shadow-sm">
                        Download PDF
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>



<script>
function viewSupplierPreview(poNum) {
   const po = purchaseOrdersState[poNum];
   if(!po) return;

   const supData = suppliersMockData[po.supplier] || { contact: "N/A", email: "N/A", phone: "N/A", address: "N/A" };

   document.getElementById('supplierViewPoNum').innerText = poNum;
   document.getElementById('supplierViewRef').innerText = poNum;
   document.getElementById('supplierViewCompName').innerText = po.supplier;
   document.getElementById('supplierViewEmail').innerText = supData.email;
   document.getElementById('supplierViewPhone').innerText = supData.phone;
   document.getElementById('supplierViewDeliveryAddress').innerText = po.delivery_address;
   
   const printTable = document.getElementById('supplierViewItemTable');
   printTable.innerHTML = '';
   let subtotal = 0;
   
   po.items.forEach((item, index) => {
     const lineTotal = item.qty * item.price;
     subtotal += lineTotal;
     
     const tr = document.createElement('tr');
     tr.className = "bg-white hover:bg-gray-50 rounded-lg border shadow-sm";
     tr.innerHTML = `
       <td class="p-2.5 border border-r-0 border-gray-200 rounded-l-lg text-gray-400">${index + 1}</td>
       <td class="p-2.5 border-y border-gray-200 text-center text-gray-600 font-bold">${item.name}</td>
       <td class="p-2.5 border-y border-gray-200 text-center">${item.qty}</td>
       <td class="p-2.5 border-y border-gray-200 text-center">₱${parseFloat(item.price).toLocaleString()}</td>
       <td class="p-2.5 border border-l-0 border-gray-200 rounded-r-lg text-center font-bold">₱${lineTotal.toLocaleString()}</td>
     `;
     printTable.appendChild(tr);
   });

   document.getElementById('supplierViewSubtotal').innerText = `₱${subtotal.toLocaleString()}`;
   document.getElementById('supplierViewTotal').innerText = `₱${subtotal.toLocaleString()}`;

   document.getElementById('supplierEmailBox1').innerText = supData.email;
   document.getElementById('supplierEmailBox2').innerText = supData.altEmail || 'support@supplier.com';
   document.getElementById('supplierEmailSubjectInput').value = `Purchase Order ${poNum}`;
   document.getElementById('supplierEmailMsgPoNum').innerText = poNum;

   document.getElementById('backToPoDetailsFromSupplierBtn').onclick = () => viewPoDetails(poNum);

   switchView('supplier-view');
 }

</script>