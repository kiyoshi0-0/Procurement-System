<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    // 1. Ipakita ang lahat ng POs
    public function list()
    {
        $purchaseOrders = PurchaseOrder::with('items')->orderBy('id', 'desc')->get();
        $activityLogs = ActivityLog::orderBy('id', 'desc')->take(20)->get();

        return view('orders.list', compact('purchaseOrders', 'activityLogs'));
    }

    public function create()
    {
        return view('orders.create-po');
    }

    // 2. Mag-save ng Bagong Purchase Order
    // 2. Mag-save ng Bagong Purchase Order
public function store(Request $request)
{
    $request->validate([
        'supplier' => 'required|string',
        'delivery_address' => 'required|string',
        'items' => 'required|array|min:1',
        'items.*.name' => 'required|string',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {
        $lastPo = PurchaseOrder::orderBy('id', 'desc')->first();
        $nextNumber = $lastPo ? ((int) str_replace('PO-', '', $lastPo->po_number)) + 1 : 101;
        $poNumber = 'PO-' . $nextNumber;

        $po = PurchaseOrder::create([
            'po_number' => $poNumber,
            'date' => now()->format('Y-m-d'),
            'supplier' => $request->supplier,
            'status' => 'Confirmed',
            'delivery_address' => $request->delivery_address,
        ]);

        foreach ($request->items as $item) {
            $po->items()->create([
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        ActivityLog::create([
            'po_number' => $po->po_number,
            'activity' => 'Created',
            'details' => "Created Purchase Order {$po->po_number} for supplier {$po->supplier}.",
            'user_name' => 'Admin'
        ]);
    });

    return redirect()->route('orders.list')->with('success', 'Purchase Order successfully created!');
}

    // 3. I-update ang PO
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier' => 'required|string',
            'delivery_address' => 'required|string',
            'items' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {
            $po = PurchaseOrder::findOrFail($id);
            $po->update([
                'supplier' => $request->supplier,
                'delivery_address' => $request->delivery_address,
            ]);

            $po->items()->delete();
            foreach ($request->items as $item) {
                $po->items()->create($item);
            }

            ActivityLog::create([
                'po_number' => $po->po_number,
                'activity' => 'Updated',
                'details' => "Updated Purchase Order {$po->po_number}.",
                'user_name' => 'Admin'
            ]);
        });

        return redirect()->route('orders.list')->with('success', 'Purchase Order updated!');
    }

    // 4. I-cancel ang Purchase Order
    public function cancel($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->update(['status' => 'Cancelled']);

        ActivityLog::create([
            'po_number' => $po->po_number,
            'activity' => 'Cancelled',
            'details' => "Cancelled Purchase Order {$po->po_number}.",
            'user_name' => 'Admin'
        ]);

        return redirect()->route('orders.list')->with('success', 'Purchase Order cancelled.');
    }

    // 5. History Log
    public function history()
    {
        $activityLogs = ActivityLog::orderBy('id', 'desc')->paginate(20);
        return view('orders.history', compact('activityLogs'));
    }

    // 6. Permanenteng Burahin ang PO
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
   public function show($poNumber)
{
    // Siguraduhing ang file na ito ay nage-exist sa resources/views/orders/details.blade.php
    $po = PurchaseOrder::where('po_number', $poNumber)->with('items')->firstOrFail();
    return view('orders.details', compact('po')); 
}
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