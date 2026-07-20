<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;

class DeliveryIssueController extends Controller
{

    public function index()
    {
        $deliveryIssues = Receipt::whereIn('match_status', [
            'QTY MISMATCH',
            'PRICE MISMATCH'
        ])->get();


        return view(
            'receipts.deliveryissues',
            compact('deliveryIssues')
        );
    }

}