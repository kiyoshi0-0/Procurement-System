<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory {
    protected $model = PurchaseOrder::class;

    public function definition(): array {
        return [
            'po_number' => 'PO-' . $this->faker->unique()->numberBetween(1000, 9999),
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'supplier_id' => 1,
            'status' => 'Confirmed',
            'delivery_address' => 'Dasmariñas, Cavite',
        ];
    }
}