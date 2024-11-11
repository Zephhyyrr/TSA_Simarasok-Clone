<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Homestay>
 */
class HomestayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->city() . ' ' . fake()->word() . ' Homestay',
            'desc' => fake()->paragraphs(3, true),
            'notelp' => '+62' . fake()->numerify('###########'),
            'harga' => rand(10, 100)*10000,
        ];
    }
}
