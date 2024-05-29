<?php

namespace Tests\Browser;

use App\Models\Listing;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FavoriteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function text_user_add_favorite_advertisement_without_login (): void
    {
        $product = Product::create([
            "product_name" => "test_product",
            "description" => "dit is een test beschrijving voor dit product"
        ]);

        Listing::create([
            "product_id" => $product->id,
            "user_id" => 4,
            "type" => "set",
            "price" => 52,
            "image" =>  storage_path('img/Alaska.jpg')
        ]);

        $this->browse(function (Browser $browser) use ($product){
             $browser->logout()->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->click("#link_$product->id")
                 ->click()
                ->assertVisible("#product-name");
        });


        Listing::where("product_id", $product->id)->delete();
        Product::find($product->id)->delete();
    }
}
