<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
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
        static::whereIn('status', ['approved', 'Approved'])
            ->get()
            ->each(function (PurchaseRequest $purchaseRequest) {
                $poNumber = 'PO-2026-' . str_pad($purchaseRequest->id, 3, '0', STR_PAD_LEFT);

                if (PurchaseOrder::where('po_number', $poNumber)->exists()) {
                    return;
                }

                $supplierId = Supplier::where('name', $purchaseRequest->supplier)->value('id')
                    ?? Supplier::inRandomOrder()->value('id')
                    ?? 1;

                $purchaseOrder = PurchaseOrder::create([
                    'po_number' => $poNumber,
                    'date' => now()->toDateString(),
                    'supplier_id' => $supplierId,
                    'status' => 'Confirmed',
                    'delivery_address' => $purchaseRequest->estimated_delivery ?? 'Not specified',
                ]);

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'name' => $purchaseRequest->item_name,
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
            // Check if the status is approved (converting to lowercase to be safe)
            if (strtolower($purchaseRequest->status) === 'approved') {
                $poNumber = 'PO-2026-' . str_pad($purchaseRequest->id, 3, '0', STR_PAD_LEFT);

                // Avoid creating duplicate purchase orders for the same request
                if (PurchaseOrder::where('po_number', $poNumber)->exists()) {
                    return;
                }

                // Try to map the request supplier string to a real Supplier record
                $supplierId = Supplier::where('name', $purchaseRequest->supplier)->value('id')
                    ?? Supplier::inRandomOrder()->value('id')
                    ?? 1;

                $purchaseOrder = PurchaseOrder::create([
                    'po_number' => $poNumber,
                    'date' => now()->toDateString(),
                    'supplier_id' => $supplierId,
                    'status' => 'Confirmed',
                    'delivery_address' => $purchaseRequest->estimated_delivery ?? 'Not specified',
                ]);

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'name' => $purchaseRequest->item_name,
                    'qty' => $purchaseRequest->qty,
                    'price' => $purchaseRequest->price ?? 0,
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