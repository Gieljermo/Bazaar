<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_admin_filter_user(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::find(1);
        
            $browser->loginAs($admin)
                ->visit('/admin')
                ->waitFor('#role_user_customer')
                ->click('#role_user_customer');
        
            $browser->with('table tbody', function ($table) {
                $rows = $table->elements('tr');
                foreach ($rows as $row) {
                    $table->assertSeeIn('td:nth-child(5)', 'Geen adverteerder');
                }
            });
        
            $browser->click('#role_user_proprietary');
        
            // Assert each row contains 'Particulier' in the 'Gebruiker role' column
            $browser->with('table tbody', function ($table) {
                $rows = $table->elements('tr');
                foreach ($rows as $row) {
                    $table->assertSeeIn('td:nth-child(5)', 'Particulier');
                }
            });

            $browser->click('#role_user_commercial');
        
            // Assert each row contains 'Particulier' in the 'Gebruiker role' column
            $browser->with('table tbody', function ($table) {
                $rows = $table->elements('tr');
                foreach ($rows as $row) {
                    $table->assertSeeIn('td:nth-child(5)', 'Zakelijk');
                }
            });
        });
    }

    public function test_admin_contract_upload(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::find(1);
            $user = User::find(4);

            $browser->loginAs($admin)
                ->visit('/admin')
                ->waitFor('#role_user_commercial')
                ->click('#role_user_commercial')
                ->click('#profile_'.$user->id)
                ->attach('contract',  storage_path('contract/contract.pdf'))
                ->click('#upload_contract_'.$user->id)
                ->assertSee('Bestand succesvol geupload');
        });
    }

    public function test_admin_contract_upload_fails(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::find(1);
            $user = User::find(4);

            $browser->loginAs($admin)
                ->visit('/admin')
                ->waitFor('#role_user_commercial')
                ->click('#role_user_commercial')
                ->click('#profile_'.$user->id)
                ->click('#upload_contract_'.$user->id)
                ->assertVisible('#error_contract')
                ->attach('contract',  storage_path('img/alaska.jpg'))
                ->click('#upload_contract_'.$user->id)
                ->assertVisible('#error_contract');
        });
    }
}
