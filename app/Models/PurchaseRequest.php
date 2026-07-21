<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;
use App\Models\Supplier;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requestor', 'dept', 'priority', 'justification', 'item_name', 
        'supplier', 'total_estimated', 'estimated_delivery', 'category', 
        'brand', 'qty', 'manager_comment', 'price', 'status' // Ensure status is here
    ];

    /**
     * The "booted" method of the model.
     * This acts as an automatic trigger every time a PurchaseRequest is touched.
     */
    protected static function booted(): void
    {
        $syncToHistory = function ($purchaseRequest) {
            // Check if the status is approved (converting to lowercase to be safe)
            if (strtolower($purchaseRequest->status) === 'approved') {
                
                // Since PurchaseRequest uses a string for supplier, we grab a random valid Supplier ID for the history
                $supplierId = Supplier::inRandomOrder()->value('id') ?? 1;

                Purchase::create([
                    'supplier_id' => $supplierId,
                    'item_name'   => $purchaseRequest->item_name,
                    'po_number'   => 'PO-2026-' . str_pad($purchaseRequest->id, 3, '0', STR_PAD_LEFT),
                    'quantity'    => $purchaseRequest->qty,
                    'total_price' => ($purchaseRequest->price ?? 1000) * $purchaseRequest->qty,
                    'status'      => 'Completed',
                ]);
            }
        };

        // Trigger 1: When the Seeder (or a user) creates a brand new request that is already 'approved'
        static::created($syncToHistory);

        // Trigger 2: When an existing request gets updated to 'approved' by a manager later
        static::updated(function ($purchaseRequest) use ($syncToHistory) {
            if ($purchaseRequest->isDirty('status')) {
                $syncToHistory($purchaseRequest);
            }
        });
    }
}