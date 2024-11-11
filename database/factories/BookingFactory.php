<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Homestay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkin = Carbon::tomorrow()->addDays(random_int(1, 7))->toDateString();
        $checkout = Carbon::createFromFormat('Y-m-d', $checkin)->addDays(random_int(1, 7))->toDateString();
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'notelp' => '+62' . fake()->numerify('###########'),
            'checkin' => $checkin,
            'checkout' => $checkout,
            'homestay_id' => Homestay::all()->random()->id,
        ];
    }
}
