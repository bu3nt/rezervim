<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
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
            'position' => fake()->jobTitle() .' @ '. fake()->company(),
            'rating' => fake()->numberBetween(4, 5),
            'message' => fake()->realText(rand(80, 100)),
            'status' => fake()->boolean()
        ];
    }
}
