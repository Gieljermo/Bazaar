<?php

namespace Tests\Browser;

use App\Models\Listing;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */



    public function test_user_write_review_for_purchased_product(): void
    {
        $user = User::factory()->create([
            "lastname" => "test",
            "street" => "test",
            "house_number" => rand(10, 50),
            "postal_code" => "1234AB",
            "role_id" => 1
            ]);

        $purchase = Purchase::create([
                "user_id" => $user->id,
                "date" => Carbon::now()
        ]);

        $product = Product::create([
            "product_name" => "test_product",
            "description" => "dit is een test beschrijving voor dit product"
        ]);

        $listing = Listing::create([
            "product_id" => $product->id,
            "user_id" => 4,
            "type" => "set",
            "purchase_id" => $purchase->id,
            "price" => 52,
            "image" =>  storage_path('img/Alaska.jpg')
        ]);


        $this->browse(function (Browser $browser) use ($user, $listing) {
            $browser->loginAs($user)
                ->visitRoute('customer.purchases')
                ->assertSee(strtoupper($listing->product->product_name))
                ->assertSee("LAAT EEN REVIEW ACHTER VOOR DE ADVERTEERDER")
                ->click('@review-link-' . $listing->id)
                ->pause(1000)
                ->assertSee('GEEF EEN REVIEW VOOR DEZE ADVERTEERDER')
                ->script([
                    "document.querySelectorAll('.star')[3].click();",
                    "document.querySelector('input[name=\"rating\"]').value = 4;",
                    "document.querySelector('input[name=\"advertiser\"]').value = {$listing->user_id};",
                    "document.querySelector('input[name=\"listing\"]').value = {$listing->id};",
                ]);
                $browser->type('textarea[name=review]', 'dit is een test review')
                    ->press('Plaats review')
                    ->click('@review-link-' . $listing->id)
                    ->pause(1000)
                    ->assertSee('JE HEBT DE ADVERTEERDER BEORDEELD VOOR DIT PRODUCT');
        });

    }
}
