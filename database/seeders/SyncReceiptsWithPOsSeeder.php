<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Receipt;
use App\Models\DeliveryIssue;

class SyncReceiptsWithPOsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all suppliers
        $suppliers = Supplier::all();
        if ($suppliers->isEmpty()) {
            $suppliers = collect([Supplier::factory()->create()]);
        }
        
        // Use existing purchase orders only; do not create new ones here.
        $purchaseOrders = PurchaseOrder::with(['items', 'supplier'])->get();
        if ($purchaseOrders->isEmpty()) {
            echo "\nNo existing purchase orders found. Receipts cannot be synced without purchase orders.\n";
            return;
        }

        echo "\nFound " . $purchaseOrders->count() . " existing Purchase Orders.\n";
        echo "\nCreating Receipts linked to Purchase Orders...\n";
        foreach ($purchaseOrders->take(30) as $i => $po) {
            $po->load('items', 'supplier');
            $item = $po->items()->first();
            
            $poQty = $item?->qty ?? rand(10, 50);
            $hasDiscrepancy = rand(1, 100) <= 20; // 20% chance
            $grQty = $hasDiscrepancy ? $poQty - rand(1, 3) : $poQty;
            $poPrice = $item?->price ?? rand(500, 5000);
            $invoicePrice = $hasDiscrepancy ? $poPrice + rand(1, 500) : $poPrice;
            
            $inspectionStatus = $hasDiscrepancy ? ['Partial', 'Failed'][rand(0, 1)] : 'Passed';
            $matchStatus = $hasDiscrepancy ? ['QTY MISMATCH', 'PRICE MISMATCH'][rand(0, 1)] : 'MATCHED';
            
            $receipt = Receipt::create([
                'gr_number' => 'GR-' . strtoupper(bin2hex(random_bytes(5))),
                'po_number' => $po->po_number,
                'purchase_order_id' => $po->id,
                'supplier' => $po->supplier?->name ?? 'Unknown',
                'item_name' => $item?->name ?? 'Item',
                'po_quantity' => $poQty,
                'gr_quantity' => $grQty,
                'po_price' => $poPrice,
                'invoice_price' => $invoicePrice,
                'warehouse' => ['Main Warehouse', 'North Depot', 'South Hub'][rand(0, 2)],
                'inspection_status' => $inspectionStatus,
                'match_status' => $matchStatus,
                'status' => 'Pending',
                'approved_at' => ($matchStatus === 'MATCHED' && $inspectionStatus === 'Passed') ? now() : null,
            ]);
            
            // Occasionally create delivery issues
            if (rand(1, 100) <= 30) {
                DeliveryIssue::create([
                    'receipt_id' => $receipt->id,
                    'receipt_number' => $receipt->gr_number,
                    'supplier' => $receipt->supplier,
                    'item_name' => $receipt->item_name,
                ]);
            }
            
            if (($i + 1) % 10 == 0) {
                echo "  Created $i Receipts...\n";
            }
        }
        echo "✓ Created " . count($purchaseOrders) . " Receipts synced with POs\n";
        echo "\n✓ Sync complete! Receipt module now displays actual procurement data.\n";
    }
}
