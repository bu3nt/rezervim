<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
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
            'caption' => fake()->realText(rand(40, 80)),
            'description' => fake()->realText(rand(150, 200)),
            'index' => fake()->numberBetween(1, 10),
            'status' => fake()->boolean()
        ];
    }
}
