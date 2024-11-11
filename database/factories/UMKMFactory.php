<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UMKM;
use Faker\Factory as FakerFactory;
use App\Faker\UMKMNameProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UMKM>
 */
class UMKMFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();
        $faker->addProvider(new UMKMNameProvider($faker));
        return [
            'name' => $faker->umkmName(),
            'owner' => fake()->name(),
            'notelp' => '+628' . fake()->numerify('##########'),
            // 'category_id' => rand(1,3),
        ];
    }
}
