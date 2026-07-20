<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'goods_receipts';

    protected $fillable = [
        'gr_number',
        'po_number',
        'supplier',
        'item_name',
        'po_quantity',
        'gr_quantity',
        'warehouse',
        'inspection_status',
        'match_status',
        'status',
        'approved_at',
        'invoice_number',
        'item_code',
        'po_price',
        'invoice_price',
        'resolution_notes',
    ];
}