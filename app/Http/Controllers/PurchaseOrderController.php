<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Show the form for creating a new purchase order.
     */
    public function list()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'items'])->get();
        return view('orders.list', compact('purchaseOrders'));
    }
    public function create()
    {
        $suppliers = Supplier::all();
        return view('orders.create-po', compact('suppliers'));
    }

    /**
     * Store a newly created purchase order in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id', // Validates that the supplier exists
            'status' => 'nullable|string',
            'delivery_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // 2. Create the Purchase Order using supplier_id
        $purchaseOrder = PurchaseOrder::create([
            'po_number' => $validated['po_number'],
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'], // Correct foreign key mapping
            'status' => $validated['status'] ?? 'Confirmed',
            'delivery_address' => $validated['delivery_address'],
        ]);

        // 3. Save related line items if applicable
        foreach ($validated['items'] as $item) {
            $purchaseOrder->items()->create([
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('orders.list')->with('success', 'Purchase Order created successfully.');
    }

    /**
     * Update the specified purchase order in storage.
     */
    public function update(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        // 1. Validate the incoming request data
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number,' . $purchaseOrder->id,
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|string',
            'delivery_address' => 'required|string',
        ]);

        // 2. Update the Purchase Order with supplier_id
        $purchaseOrder->update([
            'po_number' => $validated['po_number'],
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'], // Correct foreign key mapping
            'status' => $validated['status'],
            'delivery_address' => $validated['delivery_address'],
        ]);

        return redirect()->route('orders.list')->with('success', 'Purchase Order updated successfully.');
    }
}