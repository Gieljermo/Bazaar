<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Support\Carbon;

class CustomerTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_user_sees_purchase_history(): void
    {
        $user = User::find(4);

        $listing = Listing::where('ended', 0)->where('purchase_id', null)->orderBy('id', 'desc')->first();

        $this->browse(function (Browser $browser) use ($user, $listing) {
            $browser->loginAs($user)
                ->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->click("#link_".$listing->product->id)
                ->click("#buy-product")
                ->visit('/customer/purchases')
                ->assertSee($listing->product->product_name);
        });
    }
}
