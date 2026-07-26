<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['computed_match_status', 'effective_match_status'];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function getComputedMatchStatusAttribute()
{
    if ($this->inspection_status !== 'Passed') {
        return 'PENDING';
    }
    if ($this->po_quantity !== $this->gr_quantity) {
        return 'QTY MISMATCH';
    }
    if (number_format($this->po_price, 2) !== number_format($this->invoice_price, 2)) {
        return 'PRICE MISMATCH';
    }
    return 'MATCHED';
}

public function getEffectiveMatchStatusAttribute()
{
    return $this->match_status ?? $this->computed_match_status;
}
}
