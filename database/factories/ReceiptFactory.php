<?php

namespace Database\Factories;

use App\Models\Receipt;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptFactory extends Factory
{
    protected $model = Receipt::class;

    public function definition(): array
    {
        static $sequence = 1;
        $poNumber = 'PO-' . str_pad($sequence++, 3, '0', STR_PAD_LEFT);

        $poQty = $this->faker->numberBetween(20, 50);
        
        // Para magkaroon ng discrepancy (minsan kulang ang dine-deliver)
        $hasDiscrepancy = $this->faker->boolean(30); // 30% chance na magka-issue
        $grQty = $hasDiscrepancy ? $poQty - $this->faker->numberBetween(1, 5) : $poQty;

        $poPrice = $this->faker->randomFloat(2, 1000, 25000);
        $invoicePrice = $hasDiscrepancy ? $poPrice + $this->faker->randomFloat(2, 1, 2500) : $poPrice;

        return [
            'gr_number' => 'GR-' . strtoupper($this->faker->bothify('#####')),
            'po_number' => $poNumber,
            'supplier' => $this->faker->company(),
            'item_name' => $this->faker->randomElement([
                'Kingston Fury Beast 16GB DDR4 RAM',
                'AMD Ryzen 5 5600X Processor',
                'MSI B550M PRO-VDH WIFI Motherboard',
                'Samsung 980 PRO 1TB NVMe SSD',
                'NVIDIA GeForce RTX 4060 GPU'
            ]),
            'po_quantity' => $poQty,
            'gr_quantity' => $grQty,
            'warehouse' => $this->faker->randomElement(['Main Warehouse', 'North Depot', 'South Hub']),
            'inspection_status' => $hasDiscrepancy ? 'Failed' : 'Passed',
            'po_price' => $poPrice,
            'invoice_price' => $invoicePrice,
            'match_status' => $hasDiscrepancy ? 'PRICE MISMATCH' : 'MATCHED',
            'approved_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}