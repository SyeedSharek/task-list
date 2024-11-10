<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => rand(1,50),
            'cus_id' => rand(1,50),
            'quantity' => $this->faker->randomNumber(2),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now')
        ];
    }
}
