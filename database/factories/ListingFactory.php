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
        $minimumImages = 10;

        // Ensure the directory exists
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $images = File::files($storagePath);

        // Use existing image if there are enough, otherwise create a new one
        if (count($images) >= $minimumImages) {
            $randomImage = $images[array_rand($images)];
            $imageName = $randomImage->getFilename();

        } else {
            $imageName = fake()->image(storage_path($directory), 500, 500, null, false);
        }

        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => 'set',
            'purchase_id' => null,
            'price' => fake()->randomFloat(2, 10, 1000),
            'image' => $urlPath . $imageName,
        ];
    }

    public function bidding(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'bidding',
                'price_from' => fake()->boolean ? fake()->randomFloat(2, 0, 1000) : 0,
                'bid_until' => fake()->dateTimeBetween('-3 hours', '+5 hours'),
            ];
        });
    }

    public function rental(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'rental'
            ];
        });
    }
}
