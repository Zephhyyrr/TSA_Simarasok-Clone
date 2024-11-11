<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Asset;
use App\Models\Produk;
use App\Models\Homestay;
use App\Models\Provider;
use Illuminate\Database\Seeder;
use App\Models\DestinasiProvider;
use App\Models\DestinasiPariwisata;
use App\Models\PostEN;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('1'),
            'alias' => 'A',
            'status' => 'active',
        ]);

        DestinasiPariwisata::factory(10)->create();
        Homestay::factory(20)->create();
        Post::factory(30)->create();
        // dummy berita bahasa lain (random)
        for ($i=1; $i <= 30; $i++) {
            if (rand(0, 1)==1) {
                PostEN::factory()->create([
                    'post_id' => $i,
                    'title' => fake()->sentence(),
                    'content' => fake()->paragraphs(5, true),
                ]);
            }
        }
        Produk::factory(30)->create();

        // gambar untuk tiap destinasi
        for ($i=1; $i <= 10; $i++) {
            Asset::factory()->create([
                'nama' => ['D1','D2','D3','D4','D5'][rand(0, 4)] . '.jpg',
                'tipe' => 'gambar',
                'jenis' => 'destinasi',
                'jenis_id' => $i,
            ]);
        }

        // gambar untuk tiap homestay
        for ($i=1; $i <= 20; $i++) {
            Asset::factory()->create([
                'nama' => ['H1','H2','H3','H4','H5'][rand(0, 4)] . '.jpg',
                'tipe' => 'gambar',
                'jenis' => 'homestay',
                'jenis_id' => $i,
            ]);
        }

        // gambar untuk tiap produk (20+10)
        for ($i=1; $i <= 30; $i++) {
            Asset::factory()->create([
                'nama' => ['K1','K2','K3','K4'][rand(0, 3)] . '.jpg',
                'tipe' => 'gambar',
                'jenis' => 'produk',
                'jenis_id' => $i,
            ]);
        }

        // gambar untuk tiap Post
        for ($i=1; $i <= 30; $i++) {
            Asset::factory()->create([
                'nama' => ['P1','P2','P3','P4'][rand(0, 3)] . '.jpg',
                'tipe' => 'gambar',
                'jenis' => 'post',
                'jenis_id' => $i,
            ]);
        }

        // Gambar lain kalau mau v:
        Asset::factory(100)->create();

        for ($i=1; $i <= 10; $i++) {
            foreach (Provider::all() as $provider) {
                DestinasiProvider::factory()->create([
                    'destinasi_id' => $i,
                    'provider_id' => $provider->id,
                    'signal' => ['Very Good','Good','Normal','Fair','Bad'][rand(0, 4)],
                ]);
            }
        }
    }
}
