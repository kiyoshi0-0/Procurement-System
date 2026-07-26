<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Purchase; // Make sure this is imported at the top of PurchaseRequest.php
use App\Models\Supplier;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requestor', 'dept', 'priority', 'justification', 'item_name', 
        'supplier', 'total_estimated', 'estimated_delivery', 'category', 
        'brand', 'qty', 'manager_comment', 'price', 'status' // Ensure status is here
    ];

    public static function syncApprovedRequestsToPurchaseOrders(): void
    {
        // Define the statuses you want to distribute across (excluding Cancelled)
        $statuses = ['Confirmed', 'Delivered', 'Sent'];

        static::whereIn('status', ['approved', 'Approved'])
            ->get()
            ->each(function (PurchaseRequest $purchaseRequest) use ($statuses) {
                $poNumber = 'PO-2026-' . str_pad($purchaseRequest->id, 3, '0', STR_PAD_LEFT);

                if (PurchaseOrder::where('po_number', $poNumber)->exists()) {
                    return;
                }

                $supplierId = Supplier::where('name', $purchaseRequest->supplier)->value('id')
                    ?? Supplier::inRandomOrder()->value('id')
                    ?? 1;

                // Dynamically scatter status based on ID (e.g., ID 1 -> Confirmed, ID 2 -> Delivered, ID 3 -> Sent)
                $assignedStatus = $statuses[$purchaseRequest->id % count($statuses)];

                $purchaseOrder = PurchaseOrder::firstOrCreate(
                    ['po_number' => $poNumber],
                    [
                        'date' => now()->toDateString(),
                        'supplier_id' => $supplierId,
                        'status' => $assignedStatus, // Scattered status
                        'delivery_address' => $purchaseRequest->estimated_delivery ?? 'Not specified',
                    ]
                );

                PurchaseOrderItem::firstOrCreate([
                    'purchase_order_id' => $purchaseOrder->id,
                    'name' => $purchaseRequest->item_name,
                ], [
                    'qty' => $purchaseRequest->qty,
                    'price' => $purchaseRequest->price ?? 0,
                ]);
            });
    }

    /**
     * The "booted" method of the model.
     * This acts as an automatic trigger every time a PurchaseRequest is touched.
     */
    protected static function booted(): void
{
    $syncToHistory = function ($purchaseRequest) {
        if (strtolower($purchaseRequest->status) === 'approved') {
            $poNumber = 'PO-2026-' . str_pad($purchaseRequest->id, 3, '0', STR_PAD_LEFT);

            // Avoid duplicate entries in the purchases table
            if (Purchase::where('po_number', $poNumber)->exists()) {
                return;
            }

            // Map supplier name to supplier_id
            $supplierId = Supplier::where('name', $purchaseRequest->supplier)->value('id')
                ?? Supplier::inRandomOrder()->value('id')
                ?? 1;

            $totalPrice = ($purchaseRequest->qty ?? 0) * ($purchaseRequest->price ?? 0);

            try {
                // Create the record in the purchases table using the Purchase model[cite: 2]
                Purchase::firstOrCreate(
                    ['po_number' => $poNumber],
                    [
                        'supplier_id' => $supplierId,
                        'item_name' => $purchaseRequest->item_name,
                        'quantity' => $purchaseRequest->qty ?? 1,
                        'total_price' => $totalPrice,
                        'status' => 'Completed', // Matches your export/history query filter
                    ]
                );
            } catch (\Illuminate\Database\QueryException $e) {
                if (str_contains($e->getMessage(), 'Duplicate entry')) {
                    return;
                }
                throw $e;
            }
        }
    };

    static::created($syncToHistory);

    static::updated(function ($purchaseRequest) use ($syncToHistory) {
        if ($purchaseRequest->isDirty('status')) {
            $syncToHistory($purchaseRequest);
        }
    });
}
}