<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_user_login_fail_username_and_password(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/login')
                ->assertSeeIn('h1', 'INLOGGEN')
                ->type("email", "testUser@live.nl")
                ->type("password", "falsepassword")
                ->press("login")
                ->assertSee("Deze inloggegevens komen niet overeen met onze gegevens.");
        });
    }

    public function test_user_login_success(): void
    {
        $user = User::find(2);
        $this->browse(function (Browser $browser) use ($user){
            $browser->logout();
            $browser->visit('/login')
                ->assertSeeIn('h1', 'INLOGGEN')
                ->type("email", $user->email)
                ->type("password", "password")
                ->press("login")
                ->assertPathIs("/");
        });
    }

    public function test_user_login_fields_empty(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/login')
                ->assertSeeIn('h1', 'INLOGGEN')
                ->type("email", "")
                ->type("password", "")
                ->press("login")
                ->assertSee("Het e-mail adres veld is verplicht.")
                ->assertSee("Het wachtwoord veld is verplicht.");
        });
    }
}
