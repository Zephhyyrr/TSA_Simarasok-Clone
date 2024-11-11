<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\Provider;
use Illuminate\Database\Seeder;
use App\Models\DestinasiPariwisata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buatkan per admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'pesonasimarasokbaso@gmail.com',
            'password' => bcrypt('Admin#123'),
            'alias' => 'A',
            'status' => 'active',
        ]);
        
        /* ini kalau semisal datanya dibikin default
        DestinasiPariwisata::factory()->create([
            'name' => 'Goa Ngalau Nan Panjang',
            'desc' => 'blub blub blub blub blub blub blub blub',
            'harga' => 10000,
            'notelp' => '+628' . fake()->numerify('##########'),
            'lokasi' => 'https://maps.google.com/?q=',
            'status' => 'Normal',
        ]); */

        foreach ([
            'Telkomsel',
            'XL Axiata',
            'Indosat',
            'Smartfren',
        ] as $providerName) {
            Provider::factory()->create([
                'name' => $providerName,
            ]);
        }

        foreach ([
            'Pemandian Batu Putiah' => "https://youtu.be/XoqO-ABX_VA",
            'Sungai Angek Rafting' => "https://youtu.be/ZppvbstTY3Y",
            'UMKM Simarasok : Kue Bolu' => "https://youtu.be/8UeUTG-ndqY",
            'Homestay Rumah Gadang'=> "https://youtu.be/vlz892nCSn0",
            'Petualangan di Bawah Pulai Camp' => "https://youtu.be/FKk_ZpmCRls",
        ] as $title => $url) {
            Video::factory()->create([
                'title'=>$title,
                'url'=>$url,
            ]);
        }
        Video::first()->update(['highlight'=>true]);
    }
}
