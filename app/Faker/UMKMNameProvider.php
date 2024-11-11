<?php

namespace App\Faker;

use Faker\Provider\Base;

class UMKMNameProvider extends Base
{
    protected static $adjectives = [
        'Indah', 'Sejahtera', 'Maju', 'Makmur', 'Sukses', 'Jaya', 'Gemilang', 'Berjaya', 'Berhasil', 'Sentosa'
    ];

    protected static $nouns = [
        'Bakery', 'Batik', 'Kopi', 'Handicraft', 'Elektronik', 'Furniture', 'Kerajinan', 'Kuliner', 'Toko', 'Pabrik'
    ];

    public static function umkmName()
    {
        return static::randomElement(static::$adjectives) . ' ' . static::randomElement(static::$nouns);
    }
}
