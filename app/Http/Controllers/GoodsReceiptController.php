<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GoodsReceiptController extends Controller
{

    public function index()
{
    // Fetch all active receipts with order relations
    $receipts = Receipt::with('purchaseOrder')
        ->latest()
        ->get();

    // Use actual receipt status values for dashboard cards
    $shipmentsPending = $receipts->where('status', 'Pending')->count();
    
    $discrepanciesCount = $receipts->filter(function ($receipt) {
        return $receipt->inspection_status !== 'Passed'
            || $receipt->effective_match_status !== 'MATCHED';
    })->count();

    $approvedCount = $receipts->where('status', 'Approved')->count();

    return view('receipts.goodreceipt', compact(
        'receipts', 
        'shipmentsPending', 
        'discrepanciesCount', 
        'approvedCount'
    ));
}


    public function approve($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->invoice_price = $receipt->invoice_price ?? $receipt->invoice_price;
        $receipt->match_status = $receipt->computed_match_status;
        $receipt->status = $receipt->computed_match_status === 'MATCHED' ? 'Sent to Finance' : 'Pending';
        $receipt->approved_at = $receipt->computed_match_status === 'MATCHED' ? now() : null;
        $receipt->save();

        if ($receipt->purchase_order_id) {
            $purchaseOrder = PurchaseOrder::find($receipt->purchase_order_id);
            if ($purchaseOrder) {
                $purchaseOrder->status = $receipt->computed_match_status === 'MATCHED' ? 'Delivered' : $purchaseOrder->status;
                $purchaseOrder->save();
            }
        }

        return redirect()->route('receipts.index')->with('success', 'Receipt approved successfully!');
    }


    public function edit($id)
    {
        return response()->json(
            Receipt::findOrFail($id)
        );
    }
    public function runMatching()
{
    // Kunin ang lahat ng receipts
    $receipts = \App\Models\Receipt::all();

    foreach ($receipts as $receipt) {
        $status = 'MATCHED';

        // Check kung nag-match ang quantity (PO qty vs GR qty)
        $isQtyMatch = (int) $receipt->po_quantity === (int) $receipt->gr_quantity;
        
        // Check kung nag-match ang price (kung may field kang po_price at invoice_price)
        $isPriceMatch = true;
        if (isset($receipt->po_price) && isset($receipt->invoice_price)) {
            $isPriceMatch = (float) $receipt->po_price === (float) $receipt->invoice_price;
        }

        // Mag-assign ng tamang status base sa resulta
        if (!$isQtyMatch && !$isPriceMatch) {
            $status = 'QTY & PRICE MISMATCH';
        } elseif (!$isQtyMatch) {
            $status = 'QTY MISMATCH';
        } elseif (!$isPriceMatch) {
            $status = 'PRICE MISMATCH';
        }

        // I-save ang match status sa database
        $receipt->match_status = $status;
        $receipt->save();
    }

    return response()->json([
        'success' => true,
        'message' => 'Matagumpay na naisagawa ang automated 3-way matching audit!'
    ]);
}


    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        $receipt->supplier = $request->supplier;
        $receipt->item_name = $request->item_name;
        $receipt->po_quantity = $request->po_quantity;
        $receipt->gr_quantity = $request->gr_quantity;
        $receipt->po_price = $request->po_price;
        $receipt->invoice_price = $request->invoice_price;
        $receipt->warehouse = $request->warehouse;
        $receipt->inspection_status = $request->inspection_status;
        $receipt->match_status = $receipt->computed_match_status;

        $receipt->status = $receipt->computed_match_status === 'MATCHED' ? 'Sent to Finance' : 'Pending';
        $receipt->approved_at = $receipt->computed_match_status === 'MATCHED' ? now() : null;

        $receipt->save();

        if ($receipt->purchase_order_id) {
            $purchaseOrder = PurchaseOrder::find($receipt->purchase_order_id);
            if ($purchaseOrder) {
                $purchaseOrder->status = $receipt->computed_match_status === 'MATCHED' ? 'Delivered' : $purchaseOrder->status;
                $purchaseOrder->save();
            }
        }

        return redirect()->route('orders.list')->with('success', 'Receipt updated and synced successfully.');
    }


    public function show($id)
    {
        return response()->json(
            Receipt::findOrFail($id)
        );
    }

    public function details($id)
    {
        $receipt = Receipt::with('purchaseOrder')->findOrFail($id);

        return view('receipts.details', compact('receipt'));
    }
public function threeWayMatching()
{
    // Fetch all Purchase Orders marked as Delivered from your master list
    $deliveredOrders = PurchaseOrder::with(['supplier', 'items'])
        ->where('status', 'LIKE', 'Delivered')
        ->latest()
        ->get();

    // Map them into matching receipts, generating fallback mock rows if missing
    $receipts = $deliveredOrders->map(function ($order) {
        $receipt = Receipt::where('po_number', $order->po_number)->first();
        
        $firstItem = $order->items->first();
        $totalQty = $order->items->sum('qty');
        $totalAmount = $order->items->sum(fn($i) => $i->qty * $i->price);

        if ($receipt) {
            $receipt->setRelation('purchaseOrder', $order);
            return $receipt;
        }

        // Construct mock fallback record connected to your delivered list
        $mockReceipt = new Receipt([
            'po_number'         => $order->po_number,
            'supplier'          => $order->supplier->name ?? 'N/A',
            'item_name'         => $firstItem->name ?? 'Standard Item Bundle',
            'po_quantity'       => $totalQty > 0 ? $totalQty : 1,
            'gr_quantity'       => $totalQty > 0 ? $totalQty : 1,
            'po_price'          => $firstItem->price ?? $totalAmount,
            'invoice_price'     => $firstItem->price ?? $totalAmount,
            'inspection_status' => 'Passed',
            'match_status'      => 'MATCHED',
            'status'            => 'Approved',
        ]);
        
        $mockReceipt->id = $order->id;
        $mockReceipt->setRelation('purchaseOrder', $order);

        return $mockReceipt;
    });

    return view('receipts.threewaymatching', compact('receipts'));
}


    public function validatePayment($id)
{
    try {
        $receipt = Receipt::findOrFail($id);
        $receipt->match_status = 'COMPLETED';
        $receipt->status = 'Validated';
        $receipt->approved_at = null;
        $receipt->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment successfully validated and marked as completed!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}


    public function paymentValidation()
    {
        $receipts = Receipt::latest()->get();

        $totalInvoices = $receipts->count();
        $approvedPaymentsCount = $receipts->filter(function ($receipt) {
            return strtoupper((string) ($receipt->effective_match_status ?? $receipt->match_status ?? $receipt->computed_match_status ?? 'PENDING')) === 'COMPLETED';
        })->count();
        $pendingValidationCount = $receipts->filter(function ($receipt) {
            $status = strtoupper((string) ($receipt->effective_match_status ?? $receipt->match_status ?? $receipt->computed_match_status ?? 'PENDING'));
            return $status === 'MATCHED' || $status === 'PENDING';
        })->count();
        $paymentIssuesCount = $receipts->filter(function ($receipt) {
            $status = strtoupper((string) ($receipt->effective_match_status ?? $receipt->match_status ?? $receipt->computed_match_status ?? 'PENDING'));
            return str_contains($status, 'MISMATCH');
        })->count();
        $sentToFinanceCount = $receipts->filter(function ($receipt) {
            return strtoupper((string) ($receipt->effective_match_status ?? $receipt->match_status ?? $receipt->computed_match_status ?? 'PENDING')) === 'SENT TO FINANCE';
        })->count();

        return view(
            'receipts.paymentvalidation',
            compact(
                'receipts',
                'totalInvoices',
                'approvedPaymentsCount',
                'pendingValidationCount',
                'paymentIssuesCount',
                'sentToFinanceCount'
            )
        );
    }


    public function exportPdf()
    {
        $receipts = Receipt::all();
        
        // I-load ang view at i-download agad bilang PDF file
        $pdf = Pdf::loadView('receipts-pdf', compact('receipts'));
        
        return $pdf->download('goods-receipts.pdf');
    }

}