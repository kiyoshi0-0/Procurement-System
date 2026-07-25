<?php

namespace Database\Factories;

use App\Models\DeliveryIssue;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryIssueFactory extends Factory
{
    protected $model = DeliveryIssue::class;

    public function definition(): array
    {
        return [
            'receipt_number' => 'GR-' . strtoupper($this->faker->bothify('#####')),
            'supplier' => $this->faker->company(),
            'item_name' => $this->faker->randomElement([
                'Kingston Fury Beast 16GB DDR4 RAM',
                'AMD Ryzen 5 5600X Processor',
                'MSI B550M PRO-VDH WIFI Motherboard',
                'Samsung 980 PRO 1TB NVMe SSD',
                'NVIDIA GeForce RTX 4060 GPU'
            ]),
            'issue_type' => $this->faker->randomElement([
                'Damaged Items', 
                'Late Deliveries', 
                'Missing Items', 
                'Wrong Items'
            ]),
            'priority' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'status' => $this->faker->randomElement(['Active', 'Pending', 'Resolved']),
            'reported_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}