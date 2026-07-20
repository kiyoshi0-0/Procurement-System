<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Existing purchase
        \App\Models\Purchase::create([
            'supplier_id' => 1,
            'item_name' => 'Intel Core i7',
            'po_number' => 'PO-2026-001',
            'quantity' => 10,
            'total_price' => 45000.00,
            'status' => 'Completed'
        ]);

        // Add your 4 new purchases here:
        $purchases = [
            ['supplier_id' => 2, 'item_name' => 'DDR5 RAM 16GB', 'po_number' => 'PO-2026-002', 'quantity' => 20, 'total_price' => 12000.00, 'status' => 'Completed'],
            ['supplier_id' => 3, 'item_name' => 'NVIDIA RTX 4070', 'po_number' => 'PO-2026-003', 'quantity' => 5, 'total_price' => 150000.00, 'status' => 'Pending'],
            ['supplier_id' => 4, 'item_name' => 'Cooling Fan X1', 'po_number' => 'PO-2026-004', 'quantity' => 50, 'total_price' => 25000.00, 'status' => 'Completed'],
            ['supplier_id' => 5, 'item_name' => 'SSD 1TB NVMe', 'po_number' => 'PO-2026-005', 'quantity' => 15, 'total_price' => 45000.00, 'status' => 'Completed'],
            ['supplier_id' => 6, 'item_name' => 'DDR5 RAM 16GB', 'po_number' => 'PO-2026-002', 'quantity' => 20, 'total_price' => 12000.00, 'status' => 'Completed'],
            ['supplier_id' => 7, 'item_name' => 'NVIDIA RTX 4070', 'po_number' => 'PO-2026-003', 'quantity' => 5, 'total_price' => 150000.00, 'status' => 'Pending'],
            ['supplier_id' => 8, 'item_name' => 'Cooling Fan X1', 'po_number' => 'PO-2026-004', 'quantity' => 50, 'total_price' => 25000.00, 'status' => 'Completed'],
            ['supplier_id' => 9, 'item_name' => 'SSD 1TB NVMe', 'po_number' => 'PO-2026-005', 'quantity' => 15, 'total_price' => 45000.00, 'status' => 'Completed'],
        ];

        foreach ($purchases as $purchase) {
            \App\Models\Purchase::create($purchase);
        }
    }
}
