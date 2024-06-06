<?php

namespace Tests\Browser;

use App\Models\Favorite;
use App\Models\Listing;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FavoriteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_user_add_favorite_advertisement_without_login(): void
    {
        $product = Product::find(1);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->logout()->visitRoute("listings.show", $product->id)
                ->waitFor('#favorite_button_' . $product->id)
                ->click("#favorite_button_" . $product->id)
                ->pause(500)
                ->assertSee("INLOGGEN");
        });

    }


    public function test_user_add_favorite_advertisement_with_login (): void
    {
        $product = Product::find(1);
        $user = User::find(2);


        $this->browse(function (Browser $browser) use ($product, $user) {
            $browser->logout()->loginAs($user)
                ->visitRoute("listings.show", $product->id)
                ->waitFor('#favorite_button_'.$product->id)
                ->click("#favorite_button_".$product->id)
                ->assertSee($product->product_name)
                ->visitRoute("customer.favorites")
                ->pause(500);
        });


        Favorite::where([
            'user_id' => $user->id,
            "listing_id" => Listing::where("product_id", $product->id)->first()->id
        ])->delete();
    }


    public function test_user_delete_favorite_advertisement_with_login (): void
    {
        $user = User::find(2);
        $product = Product::find(1);

        Favorite::insert([
            'user_id' => $user->id,
            "listing_id" => Listing::where("product_id", $product->id)->first()->id
        ]);

       $this->browse(function (Browser $browser) use ($product, $user) {
            $browser->logout()->loginAs($user)
                ->visitRoute("listings.show", $product->id)
                ->waitFor('#favorite_button_'.$product->id)
                ->click("#favorite_button_".$product->id)
                ->assertSee($product->product_name)
                ->pause(500);;
        });
    }


    public function test_user_see_empty_favorite_advertisement_list_with_login (): void
    {
        $user = User::find(2);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()->loginAs($user)
                ->visitRoute("customer.favorites")
                ->assertSee("FAVORIETEN VAN ".(strtoupper($user->name)." ".strtoupper($user->lastname)))
                ->pause(500);;
        });

    }

    public function test_user_see_favorite_advertisement_list_with_login (): void
    {
        $user = User::find(2);
        $product = Product::find(1);

        Favorite::insert([
            'user_id' => $user->id,
            "listing_id" => Listing::where("product_id", $product->id)->first()->id
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()->loginAs($user)
                ->visitRoute("customer.favorites")
                ->assertSee("FAVORIETEN VAN ".(strtoupper($user->name)." ".strtoupper($user->lastname)))
                ->pause(1000);;
        });

        Favorite::where([
            'user_id' => $user->id,
            "listing_id" => Listing::where("product_id", $product->id)->first()->id
        ])->delete();
    }
}
