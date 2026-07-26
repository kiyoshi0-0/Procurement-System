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
        $syncApprovedData = function ($purchaseRequest) {
            if (strtolower($purchaseRequest->status) === 'approved') {
                $poNumber = 'PO-2026-' . str_pad($purchaseRequest->id, 3, '0', STR_PAD_LEFT);

                $supplierId = Supplier::where('name', $purchaseRequest->supplier)->value('id')
                    ?? Supplier::inRandomOrder()->value('id')
                    ?? 1;

                // 1. Sync to Purchases (History) table
                if (!Purchase::where('po_number', $poNumber)->exists()) {
                    $totalPrice = ($purchaseRequest->qty ?? 0) * ($purchaseRequest->price ?? 0);

                    try {
                        Purchase::firstOrCreate(
                            ['po_number' => $poNumber],
                            [
                                'supplier_id' => $supplierId,
                                'item_name' => $purchaseRequest->item_name,
                                'quantity' => $purchaseRequest->qty ?? 1,
                                'total_price' => $totalPrice,
                                'status' => 'Completed',
                            ]
                        );
                    } catch (\Illuminate\Database\QueryException $e) {
                        if (!str_contains($e->getMessage(), 'Duplicate entry')) {
                            throw $e;
                        }
                    }
                }

                // 2. Sync to Purchase Orders table (Fixes the empty PO List)
                $statuses = ['Confirmed', 'Delivered', 'Sent'];
                $assignedStatus = $statuses[$purchaseRequest->id % count($statuses)];

                $purchaseOrder = PurchaseOrder::firstOrCreate(
                    ['po_number' => $poNumber],
                    [
                        'date' => now()->toDateString(),
                        'supplier_id' => $supplierId,
                        'status' => $assignedStatus,
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
            }
        };

        static::created($syncApprovedData);

        static::updated(function ($purchaseRequest) use ($syncApprovedData) {
            if ($purchaseRequest->isDirty('status')) {
                $syncApprovedData($purchaseRequest);
            }
        });
    }
}