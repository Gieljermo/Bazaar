<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Listing;
use App\Models\User;
use Faker\Factory as Faker;

class ListingSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', '!=', 4)->where('role_id', '!=', 1)->get();

        foreach($users as $user){
            Listing::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);

            Listing::factory()->count(3)->bidding()->create([
                'user_id' => $user->id,
            ]);

            Listing::factory()->count(3)->rental()->create([
                'user_id' => $user->id,
            ]);

        }
    }
}
