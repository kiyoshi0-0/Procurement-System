<?php

namespace App\Exports;

use App\Models\Receipt; // Use the correct class name here
use Maatwebsite\Excel\Concerns\FromCollection;

class GoodsReceiptsExport implements FromCollection
{
    public function collection()
    {
        return Receipt::all(); // Use the correct class name here
    }
}