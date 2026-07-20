<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        // Eager load the supplier and retrieve all records instead of paginating
        $purchases = Purchase::with('supplier')->latest()->get();
        
        return view('suppliers.history', compact('purchases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'item_name' => 'required|string',
            'po_number' => 'required|string',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
        ]);

        \App\Models\Purchase::create($validated);

        return redirect()->route('suppliers.history')->with('success', 'Purchase recorded successfully!');
    }
}