<?php

namespace Database\Factories;

use App\Models\PurchaseRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseRequest>
 */
class PurchaseRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requestor' => $this->faker->name(),
            'dept' => $this->faker->randomElement(['IT', 'HR', 'Finance', 'Operations']),
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'status' => $this->faker->randomElement(['Pending', 'approved', 'revision', 'rejected']),
            'item_name' => $this->faker->randomElement([
            'NVIDIA RTX 4080 GPU', 'Intel Core i9-14900K', 'Corsair 32GB DDR5 RAM', 
            'Samsung 990 Pro 2TB SSD', 'ASUS ROG Strix Motherboard', 'Cooler Master 850W PSU',
            'Logitech MX Master 3S Mouse', 'Keychron K2 Mechanical Keyboard', 'Dell UltraSharp 27" 4K Monitor',
            'NZXT Kraken Elite 360 Cooler', 'Fractal Design Meshify 2 Case', 'Western Digital 4TB HDD',
            'Kingston Fury 16GB DDR4 RAM', 'AMD Ryzen 7 7800X3D', 'EVGA SuperNOVA 1000W PSU',
            'Razer DeathAdder V3 Pro', 'Logitech C920 Webcam', 'Sony WH-1000XM5 Headphones',
            'TP-Link Wi-Fi 6E Router', 'HyperX Cloud II Headset', 'Samsung 980 Pro 1TB SSD',
            'Crucial MX500 2TB SATA SSD', 'MSI Ventus RTX 4060', 'Gigabyte B650 Aorus Elite',
            'Be Quiet! Dark Rock Pro 5', 'Antec Performance P20C Case', 'SteelSeries Arctis Nova 7',
            'BenQ Zowie EC2 Wireless', 'Logitech G502 Lightspeed', 'CalDigit TS4 Docking Station'
        ]),
            'supplier' => $this->faker->company(),
            'total_estimated' => $this->faker->randomFloat(2, 1000, 50000),
            'estimated_delivery' => $this->faker->date(),
            'category' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'qty' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'justification' => $this->faker->sentence(),
        ];
    }
}
