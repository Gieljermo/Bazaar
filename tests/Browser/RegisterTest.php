<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_user_register_success(): void
    {
        User::where("name", "John")->delete();
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/register')
            ->type('name', 'John')
                ->type('lastname', 'Doe')
                ->type('street', '123 Main St')
                ->type('house_number', '123')
                ->type('postal_code', '12345')
                ->type('email', 'john@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->radio('type_user', 'particuliere adverteerder')
                ->press('Bevestigen')
                ->assertPathIs('/');
        });
    }

    public function test_user_email_already_exits() : void {
        $this->browse(function (Browser $browser)  {
            $browser->logout();
            $browser->visit('/register')
                ->type('name', 'John')
                ->type('lastname', 'Vaas')
                ->type('street', '124 Main St')
                ->type('house_number', '124')
                ->type('postal_code', '12344')
                ->type('email', 'john@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->radio('type_user', 'particuliere adverteerder')
                ->press('Bevestigen')
                ->assertSee('E-mail adres is al bezet.');
        });
    }


    public function test_user_register_fields_unsuccessful(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/register')
                ->press('Bevestigen')
                ->assertSee('Het voornaam veld is verplicht.') // Change the error message based on your localization
                ->assertSee('Het achternaam veld is verplicht.')
                ->assertSee('Het straat veld is verplicht.')
                ->assertSee('Het huisnummer veld is verplicht.')
                ->assertSee('Het postcode veld is verplicht.')
                ->assertSee('Het e-mail adres veld is verplicht.')
                ->assertSee('Het wachtwoord veld is verplicht.');
        });
    }

    public function test_user_password_confirmation_fail() : void {
        $this->browse(function (Browser $browser)  {
            $browser->logout();
            $browser->visit('/register')
                ->type('name', 'John')
                ->type('lastname', 'Vaas')
                ->type('street', '124 Main St')
                ->type('house_number', '124')
                ->type('postal_code', '12344')
                ->type('email', 'john@gmail.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'paswoord')
                ->radio('type_user', 'particuliere adverteerder')
                ->press('Bevestigen')
                ->assertSee('Wachtwoord bevestiging komt niet overeen.');
        });
    }

}
