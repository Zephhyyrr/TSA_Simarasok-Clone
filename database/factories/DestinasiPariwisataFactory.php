<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use App\Faker\DestinationNameProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DestinasiPariwisata>
 */
class DestinasiPariwisataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();
        $faker->addProvider(new DestinationNameProvider($faker));

        return [
            'name' => $faker->destinationName(),  // Menggunakan custom provider
            'desc' => $faker->paragraphs(3, true),
            'harga' => rand(10, 500) * 1000,
            'notelp' => '+628' . $faker->numerify('##########'),
            'lokasi' => 'https://maps.google.com/?q=' . $faker->latitude . ',' . $faker->longitude,
            'status' => $this->faker->randomElement(['Normal','Perbaikan','Tutup']),
        ];
    }
}
