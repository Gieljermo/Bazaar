<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Listing;
use App\Models\Rental;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'listing_id' => Listing::inRandomOrder()->first()->id,
            'from' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'until' => fake()->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
