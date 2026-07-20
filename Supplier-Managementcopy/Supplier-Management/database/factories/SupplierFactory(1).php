<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'address' => fake()->address(),
            'category' => fake()->randomElement(['Components', 'Storage', 'Graphics', 'Cooling']),
            'contact_person' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'payment_terms' => 'Net 30',
            'delivery_schedule' => 'Weekly',
            'rating' => fake()->randomFloat(1, 1, 5),
        ];
    }
}