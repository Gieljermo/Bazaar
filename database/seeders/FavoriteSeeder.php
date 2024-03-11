<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('favorites')->insert([
            [
                'user_id' => 2,
                'listing_id' => 1
            ],
            [
                'user_id' => 2,
                'listing_id' => 2
            ],
            [
                'user_id' => 2,
                'listing_id' => 3
            ],
            [
                'user_id' => 2,
                'listing_id' => 4
            ],
            [
                'user_id' => 2,
                'listing_id' => 5
            ],
            [
                'user_id' => 2,
                'listing_id' => 6
            ],
        ]);
    }
}
