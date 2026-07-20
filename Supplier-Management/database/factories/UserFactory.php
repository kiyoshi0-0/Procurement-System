<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' ' . $this->faker->randomElement(['Solutions', 'Systems', 'Supplies', 'Inc.', 'Innovation']),
            'contact_person' => $this->faker->name(),
            'phone' => $this->faker->numerify('+63 9## ### ####'),
            'address' => $this->faker->address(),
            'category' => $this->faker->randomElement(['Components', 'Graphics', 'Power Supply', 'Storage', 'Cooling']),
            'payment_terms' => $this->faker->randomElement(['COD', 'Net 30', 'Net 60']),
            'delivery_schedule' => $this->faker->randomElement(['Weekly', 'Bi-Weekly', 'Monthly']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
