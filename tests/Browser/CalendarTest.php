<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Listing;
use App\Models\Rental;
use Illuminate\Support\Carbon;

class CalendarTest extends DuskTestCase
{
    public function test_user_can_navigate_calendar(): void
    {
        $user = User::find(4);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/customer/calendar')
                    ->assertSee(Carbon::now()->format('F Y'))
                    ->press('>')
                    ->waitForText(Carbon::now()->addMonth()->format('F Y'))
                    ->assertSee(Carbon::now()->addMonth()->format('F Y'))
                    ->press('<')
                    ->waitForText(Carbon::now()->format('F Y'))
                    ->assertSee(Carbon::now()->format('F Y'));
        });
    }

    public function testCalendarDisplaysRentalsAndListings()
    {
        $user = User::find(4);
        $hiringUser = User::find(2);

        $rental = Rental::factory()->create([
            'user_id' => $user->id,
            'listing_id' => Listing::inRandomOrder()->where('user_id', '!=', $user->id)->first()->id,
            'from' => Carbon::now()->startOfMonth(),
            'until' => Carbon::now()->endOfMonth(),
        ]);

        $sendRental = Rental::factory()->create([
            'user_id' => $hiringUser->id,
            'listing_id' => Listing::where('user_id', $user->id)->first()->id,
            'from' => Carbon::now()->startOfMonth(),
            'until' => Carbon::now()->endOfMonth(),
        ]);



        $this->browse(function (Browser $browser) use ($user, $rental, $sendRental) {
            $browser->loginAs($user)
                    ->visit('/customer/calendar')
                    ->assertSee($rental->listing->product->product_name)
                    ->assertSee($rental->listing->user->name . ' ' . $rental->listing->user->lastname)
                    ->assertSee($sendRental->listing->product->product_name)
                    ->assertSee($sendRental->user->name . ' ' . $sendRental->user->lastname);
        });
    }

    public function testCalendarModalsForMultipleHiredProducts()
    {
        $user = User::find(4);

        $rental = Rental::factory()->create([
            'user_id' => $user->id,
            'listing_id' => Listing::inRandomOrder()->where('user_id', '!=', $user->id)->first()->id,
            'from' => Carbon::now()->startOfMonth(),
            'until' => Carbon::now()->endOfMonth(),
        ]);

        $rentals = Rental::where('user_id', $user->id)->get();

        $this->browse(function (Browser $browser) use ($user, $rentals) {
            $browser->loginAs($user)
                    ->visit('/customer/calendar')
                    ->click('.calendar-item-start p[data-bs-target="#hiredModal"]')
                    ->waitFor('#hiredModal')
                    ->assertSee($rentals->first()->listing->user->name)
                    ->assertSee($rentals->first()->listing->product->product_name)
                    ->assertSee($rentals->last()->listing->user->name)
                    ->assertSee($rentals->last()->listing->product->product_name);
        });
    }

    public function testCalendarModalsForMultipleSendProducts()
    {
        $user = User::find(4);
        $hiringUser = User::find(2);


        $sendRental = Rental::factory()->create([
            'user_id' => $hiringUser->id,
            'listing_id' => Listing::where('user_id', $user->id)->first()->id,
            'from' => Carbon::now()->startOfMonth(),
            'until' => Carbon::now()->endOfMonth(),
        ]);

        $sendRentals = Rental::where('user_id', $hiringUser->id)->get();

        $this->browse(function (Browser $browser) use ($user, $sendRentals) {
            $browser->loginAs($user)
                    ->visit('/customer/calendar')
                    ->click('.calendar-item-own-start p[data-bs-target="#rentedModal"]')
                    ->waitFor('#rentedModal')
                    ->assertSee($sendRentals->first()->user->name)
                    ->assertSee($sendRentals->first()->listing->product->product_name)
                    ->assertSee($sendRentals->last()->user->name)
                    ->assertSee($sendRentals->last()->listing->product->product_name);
        });
    }
}
