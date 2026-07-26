<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
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
    // Eager load supplier and items to prevent N+1 issues and ensure live data sync
    $purchaseOrders = PurchaseOrder::with(['supplier', 'items'])->latest()->get();
    
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

        // 1. Create the parent Purchase Order header record[cite: 5]
        $purchaseOrder = PurchaseOrder::create([
            'po_number' => $validated['po_number'],
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'],
            'status' => $validated['status'] ?? 'Confirmed',
            'delivery_address' => $validated['delivery_address'],
        ]);

        // 2. Save each line item directly into your flat purchases table using the Purchase model[cite: 3]
        foreach ($validated['items'] as $item) {
            \App\Models\Purchase::create([
                'po_number' => $validated['po_number'],
                'supplier_id' => $validated['supplier_id'],
                'item_name' => $item['name'],          // Matches Purchase model[cite: 3]
                'quantity' => $item['qty'],             // Matches Purchase model[cite: 3]
                'total_price' => $item['qty'] * $item['price'], // Matches Purchase model[cite: 3]
                'status' => $validated['status'] ?? 'Confirmed',
            ]);
        }

        // Log the creation activity[cite: 5]
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
            'status' => 'nullable|string',
        ]);

        $purchaseOrder->update([
            'po_number' => $validated['po_number'],
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'],
            'status' => $validated['status'] ?? $purchaseOrder->status,
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
    public function show($id)
    {
        $po = PurchaseOrder::with(['supplier', 'items'])
            ->findOrFail($id);

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
        // Fetch paginated activity logs for the view, excluding only Purchase Order create/edit records
        $activityLogs = ActivityLog::where(function ($query) {
            $query->whereNot(function ($subQuery) {
                $subQuery->whereIn('activity', ['Created', 'Updated'])
                    ->where('details', 'like', '%Purchase Order%');
            });
        })
        ->latest()
        ->paginate(10);
        
        return view('orders.history', compact('activityLogs'));
    }

    public function orderHistory()
{
    // Fetch the purchases (include any relationships like supplier if needed)
    $purchases = Purchase::with('supplier')->get();

    // Pass the variable into the view
    return view('orders.orderhistory', compact('purchases'));
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
        $suppliers = Supplier::all();
        
        // Ibalik ang edit view kasama ang PO data
        return view('orders.edit', compact('po', 'suppliers'));
    }
    public function print($id)
    {
        $po = PurchaseOrder::with(['items', 'supplier'])->findOrFail($id);

        return view('orders.print', compact('po'));
    }
    public function sendToSupplier($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->update(['status' => 'Sent']);

        ActivityLog::create([
            'po_number' => $po->po_number,
            'activity' => 'Sent',
            'details' => "Sent Purchase Order {$po->po_number} to supplier.",
            'user_name' => 'Admin'
        ]);

        return redirect()->route('orders.supplier', $po->id)->with('success', 'Purchase Order sent to supplier.');
    }

    public function supplierPreview($id)
    {
        $po = PurchaseOrder::with(['items', 'supplier'])->findOrFail($id);

        return view('orders.supplier', compact('po'));
    }

    /**
     * Mark the specified purchase order as delivered and generate its goods receipt.
     */
    public function markAsDelivered($id)
    {
        $po = PurchaseOrder::with(['supplier', 'items'])->findOrFail($id);
        
        // Update PO status to Delivered
        $po->update(['status' => 'Delivered']);

        // Pull the first item details (or handle collection items accordingly)
        $firstItem = $po->items->first();

        // Automatically create the Goods Receipt tied to this Purchase Order
        \App\Models\Receipt::firstOrCreate(
            ['purchase_order_id' => $po->id],
            [
                'gr_number' => 'GR-' . strtoupper(\Illuminate\Support\Str::random(5)),
                'po_number' => $po->po_number,
                'supplier' => $po->supplier->name ?? 'Default Supplier',
                'item_name' => $firstItem->item_name ?? ($firstItem->name ?? 'Computer Part'),
                'po_quantity' => $firstItem->qty ?? 1,
                'gr_quantity' => $firstItem->qty ?? 1, // Default to full count, editable later
                'warehouse' => 'Main Warehouse',
                'inspection_status' => 'Pending',
                'match_status' => 'MATCHED',
                'status' => 'Pending',
                'approved_at' => null, // Starts unapproved until explicitly approved in Goods Receipt view
            ]
        );

        // Log the activity[cite: 5, 7]
        ActivityLog::create([
            'po_number' => $po->po_number,
            'activity' => 'Delivered',
            'details' => "Marked Purchase Order {$po->po_number} as Delivered and generated Goods Receipt.",
            'user_name' => 'Admin'
        ]);

        return redirect()->back()->with('success', 'Purchase order marked as delivered and receipt generated.');
    }
}