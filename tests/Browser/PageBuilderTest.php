<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\PageSetting;
use App\Models\Listing;
use App\Models\PageComponent;

class PageBuilderTest extends DuskTestCase
{
    public function test_user_creates_landingpage(): void
    {
        $user = User::find(4);

        $listing = Listing::where('user_id', $user->id)->first();

        $this->browse(function (Browser $browser) use ($user, $listing) {
            $browser->loginAs($user)
                ->visit('/commercial/page-settings/'.$user->id)
                ->type('home_url', 'Test')
                ->click('@submit_settings')
                ->visit('/test')
                ->assertSee('PAGINA VAN '.strtoupper($user->name));

        });
    }

    public function test_user_adds_one_component(): void
    {
        $user = User::find(4);

        $listing = Listing::where('user_id', $user->id)->first();

        $this->browse(function (Browser $browser) use ($user, $listing) {
            $browser->loginAs($user)
                ->visit('/commercial/page-builder/'.$user->id)
                ->click('#addComponent')
                ->waitFor('.component-form-group')
                ->type('component[0][header]', 'Test Header')
                ->type('component[0][text]', 'Test Text')
                ->click('.listing-select')
                ->click('@option_'.$listing->id)
                ->click('@saveComponents')
                ->assertSee('Component succesvol aan webpagina toegevoegd')
                ->visit('/test')
                ->assertSee('Test Header')
                ->assertSee('Test Text')
                ->assertSee($listing->product->product_name);

        });
    }

    public function test_user_edits_one_component(): void
    {
        $user = User::find(4);

        $listing = Listing::where('user_id', $user->id)->first();
        $newListing = Listing::where('user_id', $user->id)->skip(1)->first();

        $this->browse(function (Browser $browser) use ($user, $listing, $newListing) {
            $browser->loginAs($user)
                ->visit('/commercial/page-builder/'.$user->id)
                ->type('component[0][header]', 'Test Header gewijzigd')
                ->type('component[0][text]', 'Test Text gewijzigd')
                ->click('@selected_listing_'.$listing->id)
                ->click('.listing-select')
                ->click('@option_'.$newListing->id)
                ->pause(100)
                ->click('@saveComponents')
                ->assertSee('Component succesvol aan webpagina toegevoegd')
                ->visit('/test')
                ->assertSee('Test Header gewijzigd')
                ->assertSee('Test Text gewijzigd')
                ->assertSee($newListing->product->product_name)
                ->assertDontSee($listing->product->product_name);

        });
    }

    public function test_user_removes_one_component(): void
    {
        $user = User::find(4);

        $listing = Listing::where('user_id', $user->id)->skip(1)->first();
        $component =  PageComponent::where('user_id', $user->id)->first();

        $this->browse(function (Browser $browser) use ($user, $listing, $component) {
            $browser->loginAs($user)
                ->visit('/commercial/page-builder/'.$user->id)
                ->click('@remove_'.$component->id)
                ->pause(100)
                ->assertSee('Component succesvol verwijderd')
                ->visit('/test')
                ->assertDontSee('Test Header gewijzigd')
                ->assertDontSee('Test Text gewijzigd')
                ->assertDontSee($listing->product->product_name);

        });
    }
}
