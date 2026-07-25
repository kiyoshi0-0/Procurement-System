<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Receipt;
use App\Models\DeliveryIssue;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        SupplierSeeder::class,
        ContractSeeder::class,
        PurchaseRequestSeeder::class,

    GoodsReceiptSeeder::class,  // Sunod ang Goods Receipt para may paghugutan ito
]);

        // Get all suppliers sorted by ID
        $supplierIds = Supplier::orderBy('id')->pluck('id')->toArray();

        if (empty($supplierIds)) {
            $supplierIds = [Supplier::factory()->create()->id];
        }

        // Explicitly loop and map 1 to 1
        for ($i = 0; $i < 100; $i++) {
            $poNumber = 'PO-' . (101 + $i);
            $assignedSupplierId = $supplierIds[$i % count($supplierIds)];

            $po = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $assignedSupplierId,
                'date' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                'status' => collect(['Confirmed', 'Sent', 'Delivered', 'Cancelled'])->random(),
                'delivery_address' => "BLK 51 Lot 12A, Barangay San Andres 1, Dasmariñas, Cavite",
            ]);

            PurchaseOrderItem::factory()
                ->count(rand(1, 4))
                ->create([
                    'purchase_order_id' => $po->id
                ]);
        }
        
        Receipt::factory(100)->create()->each(function ($receipt) {
            if (fake()->boolean(30)) {
                DeliveryIssue::factory()->create([
                    'receipt_id' => $receipt->id,
                    'receipt_number' => $receipt->gr_number,
                    'supplier' => $receipt->supplier,
                    'item_name' => $receipt->item_name,
                ]);
            }
        });
    }
}
    
    
