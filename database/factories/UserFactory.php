<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = new User();
        $name = $this->faker->name();
        $alias = $user->getAlias($name);

        return [
            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'alias' => $alias,
            // 'roles' => $this->faker->randomElement(['admin', 'moderator', 'publisher','owner umkm']),
            // 'roles' => 'admin',
            'status' => $this->faker->randomElement(['active', 'disable']),
            // 'remember_token' => Str::random(10),
        ];
    }


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
