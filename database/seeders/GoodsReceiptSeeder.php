<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Receipt; // Dito gagamitin natin ang Receipt model

class GoodsReceiptSeeder extends Seeder
{
    public function run(): void
    {
        $receipts = [
            [
                'gr_number' => 'GR-2026-001',
                'po_number' => 'PO-2026-001',
                'supplier' => 'Senger-Hand',
                'item_name' => 'NZXT Kraken Elite 360 Cooler',
                'po_quantity' => 10,
                'gr_quantity' => 10,
                'warehouse' => 'Main Warehouse',
                'inspection_status' => 'Passed',
                'match_status' => 'MATCHED',
                'status' => 'Approved', // Tugma sa Approved count sa controller
                'po_price' => 69991.44,
                'invoice_price' => 69991.44,
                'invoice_number' => 'INV-2026-001',
            ],
            [
                'gr_number' => 'GR-2026-002',
                'po_number' => 'PO-2026-002',
                'supplier' => 'Corsair PH',
                'item_name' => 'Cooler Master 850W PSU',
                'po_quantity' => 20,
                'gr_quantity' => 20,
                'warehouse' => 'Main Warehouse',
                'inspection_status' => 'Passed',
                'match_status' => 'MATCHED',
                'status' => 'Approved',
            ],
            [
                'gr_number' => 'GR-2026-003',
                'po_number' => 'PO-2026-003',
                'supplier' => 'ASUS Philippines',
                'item_name' => 'NVIDIA RTX 4070',
                'po_quantity' => 5,
                'gr_quantity' => 4,
                'warehouse' => 'Main Warehouse',
                'inspection_status' => 'Pending',
                'match_status' => 'QTY MISMATCH', // Tugma sa discrepancies count sa controller
                'status' => 'Pending',
                'resolution_notes' => '1 unit missing from delivery box.',
            ],
        ];

        foreach ($receipts as $receipt) {
            Receipt::create($receipt);
        }
    }
}