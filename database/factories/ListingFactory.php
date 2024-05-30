<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Support\Facades\File;
use App\Models\Product;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{


    protected $model = Listing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $directory = 'app/public/listings';
        $storagePath = storage_path($directory);
        $urlPath = 'listings/';

        // Ensure the directory exists
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => 'set',
            'purchase_id' => null,
            'bidding_id' => null,
            'price' => fake()->randomFloat(2, 10, 1000),
            'image' => $urlPath.fake()->image(storage_path('app\public\listings'), 500, 500, null, false)
        ];
    }
}
