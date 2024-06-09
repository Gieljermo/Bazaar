<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Support\Carbon;

class CustomerTest extends DuskTestCase
{

    public function test_user_sees_purchase_history_without_purchase(): void
    {
        $user = User::find(4);
        
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/customer/purchases')
                ->assertSee('Er zijn geen bestelling gemaakt');
        });
    }

    public function test_user_sees_purchase_history(): void
    {
        $user = User::find(4);

        $listing = Listing::where('ended', 0)->where('purchase_id', null)->where('type', 'set')->orderBy('id', 'desc')->first();

        $this->browse(function (Browser $browser) use ($user, $listing) {
            $browser->loginAs($user)
                ->visitRoute("listings.index")
                ->clickLink("Advertenties")
                ->select('type', 'set')
                ->click("#link_".$listing->product->id)
                ->click("#buy-product")
                ->visit('/customer/purchases')
                ->assertSee(strtoupper($listing->product->product_name));
        });
    }
}
