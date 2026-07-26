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
        $hasQtyDiscrepancy = $this->faker->boolean(25); 
        $grQty = $hasQtyDiscrepancy ? $poQty - $this->faker->numberBetween(1, 5) : $poQty;

        $poPrice = $this->faker->randomFloat(2, 1500, 25000);
        $hasPriceMismatch = $this->faker->boolean(20); 
        $invoicePrice = $hasPriceMismatch ? $poPrice + $this->faker->randomFloat(2, 150, 2500) : $poPrice;

        $matchStatus = 'MATCHED';
        if ($hasQtyDiscrepancy) {
            $matchStatus = 'QTY MISMATCH';
        } elseif ($hasPriceMismatch) {
            $matchStatus = 'PRICE MISMATCH';
        }

        $inspectionStatus = $this->faker->randomElement(['Passed', 'Failed', 'Pending']);

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
            ]),
            'po_quantity' => $poQty,
            'gr_quantity' => $grQty,
            'po_price' => $poPrice,
            'invoice_price' => $invoicePrice,
            'warehouse' => $this->faker->randomElement(['Main Warehouse', 'North Depot', 'South Hub']),

            'inspection_status' => $inspectionStatus,
            'match_status' => $matchStatus,
            'approved_at' => ($matchStatus === 'MATCHED' && $inspectionStatus === 'Passed') ? $this->faker->dateTimeBetween('-1 month', 'now') : null,

            'inspection_status' => $hasDiscrepancy ? 'Failed' : 'Passed',
            'po_price' => $poPrice,
            'invoice_price' => $invoicePrice,
            'match_status' => $hasDiscrepancy ? 'PRICE MISMATCH' : 'MATCHED',
            'approved_at' => $this->faker->dateTimeBetween('-1 month', 'now'),

        ];
    }
}