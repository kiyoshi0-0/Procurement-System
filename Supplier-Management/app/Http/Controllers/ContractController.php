<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        // Fetches all records from your 'contracts' table
        $contracts = Contract::all();
        
        return view('contracts', compact('contracts'));
    }
}