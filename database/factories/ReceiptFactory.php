<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptFactory extends Factory
{
    protected $model = \App\Models\Receipt::class;

    public function definition(): array
    {
        return [
            'gr_number' => 'GR-' . $this->faker->unique()->numerify('2026-###'),
            'po_number' => 'PO-' . $this->faker->numerify('2026-###'),
            'supplier' => $this->faker->company(),
            'item_name' => $this->faker->words(3, true),
            'po_quantity' => $this->faker->numberBetween(1, 50),
            'gr_quantity' => $this->faker->numberBetween(1, 50),
            'warehouse' => 'Main Warehouse',
            'inspection_status' => 'Passed',
            'match_status' => $this->faker->randomElement(['QTY MISMATCH', 'PRICE MISMATCH', 'MATCHED']), // <-- Add this line
        ];
    }
}