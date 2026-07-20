<?php

// database/factories/PurchaseOrderItemFactory.php
namespace Database\Factories;

use App\Models\PurchaseOrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderItemFactory extends Factory {
    protected $model = PurchaseOrderItem::class;

    public function definition(): array {
        $items = [
            'BUBLI-parts Main Deck', 
            'MasterPc Processing Hub', 
            'Screws & Fittings Set', 
            'Dual Layout Board System',
            'Enterprise Computer Set',
            'Solid State Core Drive'
        ];

        return [
            'name' => $this->faker->randomElement($items),
            'qty' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomElement([899, 1500, 5000, 50000]),
        ];
    }
}