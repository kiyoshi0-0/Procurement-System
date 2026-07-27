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
        
        // Seed 30 purchase orders
        echo "\nCreating Purchase Orders...\n";
        $purchaseOrders = [];
        for ($i = 0; $i < 30; $i++) {
            $supplier = $suppliers->random();
            $po = PurchaseOrder::create([
                'po_number' => 'PO-' . (101 + $i),
                'supplier_id' => $supplier->id,
                'date' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                'status' => ['Confirmed', 'Sent', 'Delivered'][rand(0, 2)],
                'delivery_address' => "BLK 51 Lot 12A, Barangay San Andres 1, Dasmariñas, Cavite",
            ]);
            
            // Create 1-2 items per PO
            for ($j = 0; $j < rand(1, 2); $j++) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'name' => ['Kingston Memory', 'Ryzen Processor', 'SSD Drive', 'Motherboard'][rand(0, 3)],
                    'qty' => rand(5, 50),
                    'price' => rand(500, 5000),
                ]);
            }
            
            $purchaseOrders[] = $po;
            if (($i + 1) % 10 == 0) {
                echo "  Created $i POs...\n";
            }
        }
        echo "✓ Created " . count($purchaseOrders) . " Purchase Orders\n";
        
        // Create 30 receipts linked to POs
        echo "\nCreating Receipts linked to Purchase Orders...\n";
        for ($i = 0; $i < count($purchaseOrders); $i++) {
            $po = $purchaseOrders[$i]->load('items', 'supplier');
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
