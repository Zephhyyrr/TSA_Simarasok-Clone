<?php

namespace Database\Factories;

use App\Models\DestinasiPariwisata;
use App\Models\Homestay;
use App\Models\Post;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = ['destinasi', 'homestay', 'post', 'produk'][rand(0, 3)];
        $gambar = '';
        $jenis_id = '';
        if ($jenis == 'destinasi') {
            $gambar = ['D1','D2','D3','D4','D5'][rand(0, 4)] . '.jpg';
            $jenis_id = DestinasiPariwisata::all()->random()->id;
        }elseif ($jenis == 'homestay') {
            $gambar = ['H1','H2','H3','H4','H5'][rand(0, 4)] . '.jpg';
            $jenis_id = Homestay::all()->random()->id;
        }elseif ($jenis == 'post') {
            $gambar = ['P1','P2','P3','P4'][rand(0, 3)] . '.jpg';
            $jenis_id = Post::all()->random()->id;
        }elseif ($jenis == 'produk') {
            $gambar = ['K1', 'K2', 'K3', 'K4'][rand(0, 3)] . '.jpg';
            $jenis_id = Produk::all()->random()->id;
        }

        return [
            'nama' => $gambar,
            'tipe' => 'gambar',
            'jenis' => $jenis,
            'jenis_id' => $jenis_id,
        ];
    }
}
