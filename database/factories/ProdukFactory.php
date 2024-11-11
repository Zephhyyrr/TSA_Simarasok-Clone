<?php

namespace Database\Factories;

use App\Models\UMKM;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // untuk mengetahui harga terisi atau tidak
        $fillHarga = fake()->boolean();
        // untuk mengetahui harga terisi atau tidak


        return [
            'name' => fake()->words(2, true),
            'desc' => fake()->paragraphs(3, true),
            'harga' => $fillHarga ? rand(5, 50)*1000 : null,
            'event' => $fillHarga ? null : 'Hari ' . fake()->words(2, true),
            /* 'umkm_id' => UMKM::all()->random()->id, */
            /* 'category_id' => rand(1,5), */
        ];
    }
}
