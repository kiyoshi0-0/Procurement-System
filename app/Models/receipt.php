<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'computed_match_status',
        'effective_match_status',
        'display_match_status',
        'payment_validation_state',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function getComputedMatchStatusAttribute()
    {
        if ($this->inspection_status !== 'Passed') {
            return 'PENDING';
        }

        $poQuantity = (int) ($this->po_quantity ?? 0);
        $grQuantity = (int) ($this->gr_quantity ?? 0);

        if ($poQuantity !== $grQuantity) {
            return 'QTY MISMATCH';
        }

        $poPrice = (float) ($this->po_price ?? 0);
        $invoicePrice = (float) ($this->invoice_price ?? 0);

        if (number_format($poPrice, 2) !== number_format($invoicePrice, 2)) {
            return 'PRICE MISMATCH';
        }

        return 'MATCHED';
    }

    public function getEffectiveMatchStatusAttribute()
    {
        $status = strtoupper((string) ($this->match_status ?? $this->computed_match_status ?? 'PENDING'));

        if ($this->status === 'Sent to Finance' || $this->status === 'Approved') {
            return 'SENT TO FINANCE';
        }

        if (!empty($this->approved_at) && strtoupper((string) $status) === 'MATCHED') {
            return 'SENT TO FINANCE';
        }

        if ($status === 'PENDING' && $this->inspection_status === 'Passed') {
            return 'MATCHED';
        }

        return $status;
    }

    public function getDisplayMatchStatusAttribute()
    {
        $status = strtoupper((string) ($this->effective_match_status ?? $this->match_status ?? $this->computed_match_status ?? 'PENDING'));

        return $status;
    }

    public function getPaymentValidationStateAttribute()
    {
        $status = strtoupper((string) ($this->display_match_status ?? $this->effective_match_status ?? $this->match_status ?? $this->computed_match_status ?? 'PENDING'));

        if ($status === 'SENT TO FINANCE') {
            return 'sent_to_finance';
        }

        if ($status === 'COMPLETED') {
            return 'validated';
        }

        if (str_contains($status, 'MISMATCH')) {
            return 'payment_issue';
        }

        return 'pending_validation';
    }

    public function getDisplayPoNumberAttribute()
    {
        if ($this->relationLoaded('purchaseOrder') && $this->purchaseOrder) {
            return $this->purchaseOrder->po_number;
        }

        if (preg_match('/^PO-(\d{1,3})$/', $this->po_number, $matches)) {
            return 'PO-2026-' . str_pad($matches[1], 3, '0', STR_PAD_LEFT);
        }

        return $this->po_number;
    }
}
