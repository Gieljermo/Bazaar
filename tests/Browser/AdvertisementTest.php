<?php

namespace Tests\Browser;

use App\Models\Listing;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdvertisementTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_user_make_advertisement_without_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click("#place_advertisement")
                ->assertPathIs("/login")
                ->assertSeeIn("h1", "INLOGGEN");
        });
    }

    public function test_user_make_advertisement_set_with_login(): void
    {
        $user = User::find(3);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->click("#place_advertisement")
                ->type('product[name]', 'Sample Product set')
                ->type('product[description]', 'This is a sample product description.')
                ->attach('listing[image]',  storage_path('img/Alaska.jpg'))
                ->select('listing[type]', 'set')
                ->type('listing[price]', '100')
                ->press('Advertentie plaatsen')
                ->assertPathIs("/listings")
                ->assertSeeIn("h1", "ADVERTENTIES")
                ->assertSee("Advertentie succesvol toegevoegd.");
        });
    }


    /*public function test_user_make_advertisement_bidding_with_login(): void
    {
        $user = User::find(3);
        $datetime = Carbon::now()->format('D-M-Y\TH:i');

        $this->browse(function (Browser $browser) use ($user, $datetime) {
            $browser->logout()->loginAs($user)
                ->click("#place_advertisement")
                ->type('product[name]', 'Sample Product bidding')
                ->type('product[description]', 'This is a sample product description.')
                ->attach('listing[image]',  storage_path('img/Alaska.jpg'))
                ->select('listing[type]', 'bidding')
                ->type('listing[bid-price]', '50')
                ->clear('input[name="listing[bid-until]"]')
                ->script("document.querySelector('input[name=\"listing[bid-until]\"]').value = '$datetime';");
            $browser
                ->pause(10000)
                ->press('Advertentie plaatsen')
                ->assertPathIs("/listings")
                ->assertSeeIn("h1", "ADVERTENTIES")
                ->assertSee("Advertentie succesvol toegevoegd.");
        });
    }*/

   public function test_user_make_advertisement_rental_with_login(): void
    {
        $user = User::find(3);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->click("#place_advertisement")
                ->type('product[name]', 'Sample Product set')
                ->type('product[description]', 'This is a sample product description.')
                ->attach('listing[image]',  storage_path('img/Alaska.jpg'))
                ->select('listing[type]', 'rental')
                ->type('listing[rent-price]', '10')
                ->press('Advertentie plaatsen')
                ->assertPathIs("/listings")
                ->assertSeeIn("h1", "ADVERTENTIES")
                ->assertSee("Advertentie succesvol toegevoegd.");
        });
    }

    public function test_user_takes_loot_at_a_advertisement(): void
    {
        $user = User::find(2);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()->loginAs($user)
                ->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->clickLink("Advertentie bekijken")
                ->assertVisible("#product-name");
        });
    }

   public function test_user_buys_the_advertisement(): void
   {
        $user = User::find(2);
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

        $this->browse(function (Browser $browser) use ($user, $product) {
            $browser->logout()->loginAs($user)
                ->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->click("#link_$product->id")
                ->assertVisible("#product-name")
                ->click("#buy-product")
                ->assertPathIs("/listings");
        });


        Listing::where("product_id", $product->id)->delete();
        Product::find($product->id)->delete();
    }

    public function test_user_takes_loot_at_a_advertisement_without_login(): void
    {

        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->clickLink("Advertentie bekijken")
                ->assertVisible("#product-name");
        });
    }

    public function test_user_buys_the_advertisement_without_login(): void
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

        $this->browse(function (Browser $browser) use ($product) {
            $browser->logout()->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->click("#link_$product->id")
                ->assertVisible("#product-name")
                ->click("#buy-product")
                ->assertPathIs("/login");
        });


        Listing::where("product_id", $product->id)->delete();
        Product::find($product->id)->delete();
    }


}
