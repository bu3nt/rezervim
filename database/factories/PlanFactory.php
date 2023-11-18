<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'monthly' => fake()->randomFloat(2, 10, 25),
            'yearly' => fake()->randomFloat(2, 100, 270),
            'popular' => fake()->boolean(),
            'index' => fake()->numberBetween(1, 10),
            'status' => fake()->boolean()
        ];
    }
}
