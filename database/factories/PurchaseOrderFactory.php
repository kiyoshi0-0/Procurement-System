<?php

// database/factories/PurchaseOrderFactory.php
namespace Database\Factories;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory {
    protected $model = PurchaseOrder::class;

    private static $poCounter = 101; // Starting PO Number sequence

    public function definition(): array {
        $suppliers = ['TicTac PC', 'MasterPc', 'Apex Components', 'Delta Micro'];
        $statuses = ['Confirmed', 'Sent', 'Delivered', 'Cancelled'];
        
        $addresses = [
            "BLK 51 Lot 12A, Barangay San Andres 1, Dasmariñas, Cavite",
            "Building 4, Industrial Zone, Calamba, Laguna",
            "4120: Maglabe drive, purok 26, Gulnhawa South"
        ];

        return [
            'po_number' => 'PO-' . self::$poCounter++,
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'supplier' => $this->faker->randomElement($suppliers),
            'status' => $this->faker->randomElement($statuses),
            'delivery_address' => $this->faker->randomElement($addresses),
        ];
    }
}
