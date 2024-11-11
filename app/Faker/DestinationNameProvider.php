<?php 

namespace App\Faker;

use Faker\Provider\Base;

class DestinationNameProvider extends Base
{
    protected static $adjectives = [
        'Mystic', 'Hidden', 'Sunny', 'Tranquil', 'Golden', 'Majestic', 'Serene', 'Enchanted', 'Lush', 'Crystal'
    ];

    protected static $nouns = [
        'Beach', 'Forest', 'Mountain', 'Valley', 'Lake', 'Cove', 'River', 'Island', 'Park', 'Waterfall'
    ];

    public static function destinationName()
    {
        return static::randomElement(static::$adjectives) . ' '. fake()->word .' ' . static::randomElement(static::$nouns);
    }
}