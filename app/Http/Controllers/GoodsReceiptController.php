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

        $shipmentsPending = Receipt::where('inspection_status', 'Pending')->count();
        $approvedCount = Receipt::where('inspection_status', 'Approved')->count();

        $discrepanciesCount = Receipt::whereIn('match_status', [
            'QTY MISMATCH',
            'PRICE MISMATCH'
        ])->count();

        $deliveryToday = Receipt::whereDate('created_at', today())->count();

        $itemsReceived = Receipt::sum('gr_quantity');

        $pendingInspection = Receipt::where('inspection_status', 'Pending')->count();

        $inspectionPassed = Receipt::where('inspection_status', 'Passed')->count();

        $matchedCount = Receipt::where('match_status', 'MATCHED')->count();

        $readyFinance = Receipt::where('inspection_status', 'Approved')->count();


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
    $receipt->match_status = 'MATCHED';
    $receipt->approved_at = now();
    $receipt->save();

  return redirect()->back()->with('success', 'Receipt successfully sent to Finance!');
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
        $receipt->warehouse = $request->warehouse;
        $receipt->inspection_status = $request->inspection_status;
        $receipt->match_status = $request->match_status;


        if($request->inspection_status == 'Failed'){

        //  $receipt->status = 'Pending';
            $receipt->approved_at = null;

        }
        elseif(
            $request->inspection_status == 'Passed'
            &&
            $request->match_status == 'MATCHED'
        ){

           
            $receipt->approved_at = now();

        }


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


    public function threeWayMatching()
    {
        $receipts = Receipt::latest()->get();

      return view(
    'receipts.threewaymatching',
    compact('receipts')
);
    }


    public function validatePayment($id)
{
    try {
        $receipt = Receipt::findOrFail($id);
        $receipt->match_status = 'COMPLETED';
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
    $receipts = Receipt::all();

    // Bilangin ang mga na-send na sa finance
    $sentToFinanceCount = Receipt::where('match_status', 'SENT TO FINANCE')->orWhereNotNull('approved_at')->count();
    $approvedPaymentsCount = Receipt::where('match_status', 'MATCHED')->orWhere('match_status', 'COMPLETED')->count();
    $paymentIssuesCount = Receipt::where('match_status', 'LIKE', '%MISMATCH%')->count();
    $totalInvoices = $receipts->count();

    return view('receipts.paymentvalidation', compact(
        'receipts', 
        'sentToFinanceCount', 
        'approvedPaymentsCount', 
        'paymentIssuesCount', 
        'totalInvoices'
    ));
}


public function exportPdf()
{
    $receipts = Receipt::all();
    
    // I-load ang view at i-download agad bilang PDF file
    $pdf = Pdf::loadView('receipts-pdf', compact('receipts'));
    
    return $pdf->download('goods-receipts.pdf');
}

}