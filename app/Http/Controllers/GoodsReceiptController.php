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

        $shipmentsPending = Receipt::where('status', 'Pending')->count();

        $approvedCount = Receipt::where('status', 'Approved')->count();

        $discrepanciesCount = Receipt::whereIn('match_status', [
            'QTY MISMATCH',
            'PRICE MISMATCH'
        ])->count();

        $deliveryToday = Receipt::whereDate('created_at', today())->count();

        $itemsReceived = Receipt::sum('gr_quantity');

        $pendingInspection = Receipt::where('inspection_status', 'Pending')->count();

        $inspectionPassed = Receipt::where('inspection_status', 'Passed')->count();

        $matchedCount = Receipt::where('match_status', 'MATCHED')->count();

        $readyFinance = Receipt::where('status', 'Approved')->count();


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

        $receipt->status = 'Approved';
        $receipt->match_status = 'MATCHED';
        $receipt->approved_at = now();

        $receipt->save();

        return redirect()->back()
            ->with('success','Receipt approved successfully.');
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
        $receipt->warehouse = $request->warehouse;
        $receipt->inspection_status = $request->inspection_status;
        $receipt->match_status = $request->match_status;


        if($request->inspection_status == 'Failed'){

            $receipt->status = 'Pending';
            $receipt->approved_at = null;

        }
        elseif(
            $request->inspection_status == 'Passed'
            &&
            $request->match_status == 'MATCHED'
        ){

            $receipt->status = 'Approved';
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

        $pdf = Pdf::loadView(
            'exports.goods_receipts_pdf',
            compact('receipts')
        );

        return $pdf->download(
            'goods-receipts.pdf'
        );
    }

}