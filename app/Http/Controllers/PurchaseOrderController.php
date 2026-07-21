<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\ActivityLog;
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
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'nullable|string',
            'delivery_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'po_number' => $validated['po_number'],
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'],
            'status' => $validated['status'] ?? 'Confirmed',
            'delivery_address' => $validated['delivery_address'],
        ]);

        foreach ($validated['items'] as $item) {
            $purchaseOrder->items()->create([
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // Log the creation activity
        ActivityLog::create([
            'po_number' => $validated['po_number'],
            'activity' => 'Created',
            'details' => "Created Purchase Order {$validated['po_number']}.",
            'user_name' => 'Admin'
        ]);

        return redirect()->route('orders.list')->with('success', 'Purchase Order created successfully.');
    }
    /**
     * Update the specified purchase order in storage.
     */
    public function update(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number,' . $purchaseOrder->id,
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|string',
            'delivery_address' => 'required|string',
        ]);

        $purchaseOrder->update([
            'po_number' => $validated['po_number'],
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'],
            'status' => $validated['status'],
            'delivery_address' => $validated['delivery_address'],
        ]);

        // Log the update activity
        ActivityLog::create([
            'po_number' => $validated['po_number'],
            'activity' => 'Updated',
            'details' => "Updated Purchase Order {$validated['po_number']}.",
            'user_name' => 'Admin'
        ]);

        return redirect()->route('orders.list')->with('success', 'Purchase Order updated successfully.');
    }

    /**
     * Display the specified purchase order details.
     */
    public function show($po_number)
    {
        $po = PurchaseOrder::with(['supplier', 'items'])
            ->where('po_number', $po_number)
            ->firstOrFail();

        return view('orders.details', compact('po'));
    }

    /**
     * Cancel the specified purchase order.
     */
    public function cancel($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        $purchaseOrder->update([
            'status' => 'Cancelled',
        ]);

        // Log the cancellation activity
        ActivityLog::create([
            'po_number' => $purchaseOrder->po_number,
            'activity' => 'Cancelled',
            'details' => "Cancelled Purchase Order {$purchaseOrder->po_number}.",
            'user_name' => 'Admin'
        ]);

        return redirect()->route('orders.list')->with('success', 'Purchase order cancelled successfully.');
    }

    /**
     * Display the purchase order history.
     */
    public function history()
    {
        // Fetch paginated activity logs for the view
        $activityLogs = ActivityLog::latest()->paginate(10);
        
        return view('orders.history', compact('activityLogs'));
    }

    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po_number = $po->po_number;
        $po->delete();

        ActivityLog::create([
            'po_number' => $po_number,
            'activity' => 'Deleted',
            'details' => "Permanently deleted Purchase Order {$po_number}.",
            'user_name' => 'Admin'
        ]);

        return redirect()->route('orders.list')->with('success', 'Purchase Order deleted.');
    }

    // 7. Show PO Details
   
    // Idagdag ang method na ito sa loob ng iyong PurchaseOrderController class
    public function edit($id)
    {
        // Hanapin ang PO sa database
        $po = PurchaseOrder::with('items')->findOrFail($id);
        
        // Ibalik ang edit view kasama ang PO data
        return view('orders.edit', compact('po'));
    }
    public function print($poNumber)
    {
        // Hanapin ang PO gamit ang po_number string
        $po = PurchaseOrder::where('po_number', $poNumber)->with('items')->firstOrFail();
        
        // I-return ang view at ipasa ang $po object
        return view('orders.print', compact('po')); 
    }
    public function supplierPreview($poNumber)
    {
        // Hanapin ang PO sa database kasama ang mga items nito
        $po = PurchaseOrder::where('po_number', $poNumber)->with('items')->firstOrFail();
        
        // I-pass ang $po sa supplier.blade.php
        return view('orders.supplier', compact('po'));
    }
}