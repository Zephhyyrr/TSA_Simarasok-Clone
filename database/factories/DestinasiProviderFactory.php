<?php

namespace Database\Factories;

use App\Models\DestinasiPariwisata;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DestinasiProvider>
 */
class DestinasiProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destinasi_id' => DestinasiPariwisata::all()->random()->id,
            'provider_id' => Provider::all()->random()->id,
            'signal' => ['Very Good','Good','Normal','Fair','Bad'][rand(0, 4)],
        ];
    }
}
