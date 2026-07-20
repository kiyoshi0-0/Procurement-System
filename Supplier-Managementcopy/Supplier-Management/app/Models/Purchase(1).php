<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'item_name', 'po_number', 'quantity', 'total_price', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}