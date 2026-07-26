<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GoodsReceiptController extends Controller
{

    public function index()
    {
        $receipts = Receipt::latest()->get();

        $shipmentsPending = $receipts->where('inspection_status', 'Pending')->count();
        $approvedCount = $receipts->where('inspection_status', 'Approved')->count();

        $discrepanciesCount = $receipts->filter(fn($receipt) => in_array($receipt->effective_match_status, [
            'QTY MISMATCH',
            'PRICE MISMATCH'
        ]))->count();

        $deliveryToday = $receipts->whereBetween('created_at', [today()->startOfDay(), today()->endOfDay()])->count();

        $itemsReceived = $receipts->sum('gr_quantity');

        $pendingInspection = $receipts->where('inspection_status', 'Pending')->count();

        $inspectionPassed = $receipts->where('inspection_status', 'Passed')->count();

        $matchedCount = $receipts->filter(fn($receipt) => $receipt->effective_match_status === 'MATCHED')->count();

        $readyFinance = $receipts->where('inspection_status', 'Approved')->count();


        return view('receipts.goodreceipt', compact(
            'receipts',
            'shipmentsPending',
            'approvedCount',
            'discrepanciesCount',
            'deliveryToday',
            'itemsReceived',
            'pendingInspection',
            'inspectionPassed',
            'matchedCount',
            'readyFinance'
        ));
    }


    public function approve($id)
{
    $receipt = Receipt::findOrFail($id);
    $receipt->inspection_status = 'Approved';
    $receipt->po_price = $receipt->po_price ?? $receipt->po_price;
    $receipt->invoice_price = $receipt->invoice_price ?? $receipt->invoice_price;
    $receipt->match_status = $receipt->computed_match_status;
    $receipt->status = $receipt->computed_match_status === 'MATCHED' ? 'Approved' : 'Pending';
    $receipt->approved_at = $receipt->computed_match_status === 'MATCHED' ? now() : null;
    $receipt->save();

    return redirect()->route('receipts.index')->with('success', 'Receipt approved successfully!');
}


    public function edit($id)
    {
        return response()->json(
            Receipt::findOrFail($id)
        );
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

        $receipt->status = $receipt->computed_match_status === 'MATCHED' ? 'Approved' : 'Pending';
        $receipt->approved_at = $receipt->computed_match_status === 'MATCHED' ? now() : null;

        $receipt->save();

        return redirect()
            ->route('receipts.index')
            ->with('success','Receipt updated.');
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
        $receipts = Receipt::with('purchaseOrder')
            ->latest()
            ->get();

        return view('receipts.threewaymatching', compact('receipts'));
    }


    public function paymentValidation()
    {
        $receipts = Receipt::latest()->get();

     return view(
    'receipts.paymentvalidation',
    compact('receipts')
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