<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition()
{
    return [
        'name' => $this->faker->company,
        'category' => $this->faker->randomElement(['Components', 'Graphics', 'Power Supply', 'Storage', 'Cooling']),
        'sub_categories' => $this->faker->words(2, true),
        'contact_person' => $this->faker->name,
        'phone' => $this->faker->phoneNumber,
        'email' => $this->faker->unique()->safeEmail,
        'address' => $this->faker->address,
        'payment_terms' => $this->faker->randomElement(['Net 30', 'Net 60', 'COD']),
        'delivery_schedule' => $this->faker->randomElement(['Weekly', 'Bi-Weekly', 'Monthly']),
        'rating' => $this->faker->randomFloat(1, 1.0, 5.0),
    ];
}
}