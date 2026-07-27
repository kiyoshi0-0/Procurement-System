<?php

namespace Database\Factories;

use App\Models\Receipt;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptFactory extends Factory
{
    protected $model = Receipt::class;

    public function definition(): array
    {
        $poQty = $this->faker->numberBetween(10, 50);
        
        // Para magkaroon ng discrepancy (minsan kulang ang dine-deliver)
        $hasDiscrepancy = $this->faker->boolean(20); // 20% chance na magka-issue
        $grQty = $hasDiscrepancy ? $poQty - $this->faker->numberBetween(1, 3) : $poQty;

        $poPrice = $this->faker->randomFloat(2, 1000, 10000);
        $invoicePrice = $hasDiscrepancy ? $poPrice + $this->faker->randomFloat(2, 1, 500) : $poPrice;

        $inspectionStatus = $hasDiscrepancy ? $this->faker->randomElement(['Partial', 'Failed']) : 'Passed';
        $matchStatus = $hasDiscrepancy ? $this->faker->randomElement(['QTY MISMATCH', 'PRICE MISMATCH']) : 'MATCHED';

        return [
            'gr_number' => 'GR-' . strtoupper($this->faker->bothify('#####')),
            'po_number' => 'PO-' . $this->faker->numberBetween(101, 150),
            'supplier' => $this->faker->company(),
            'item_name' => $this->faker->word(),
            'po_quantity' => $poQty,
            'gr_quantity' => $grQty,
            'po_price' => $poPrice,
            'invoice_price' => $invoicePrice,
            'warehouse' => $this->faker->randomElement(['Main Warehouse', 'North Depot', 'South Hub']),
            'inspection_status' => $inspectionStatus,
            'match_status' => $matchStatus,
            'status' => 'Pending',
            'approved_at' => ($matchStatus === 'MATCHED' && $inspectionStatus === 'Passed') ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}