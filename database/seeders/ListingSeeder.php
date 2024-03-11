<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('purchases')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        DB::table('listings')->insert([
            [
                'id' => 1,
                'product_id' => 1,
                'user_id' => 3,
                'type' => 'set',
                'purchase_id' => 1,
                'bidding_id' => null
            ],
            [
                'id' => 2,
                'product_id' => 4,
                'user_id' => 4,
                'type' => 'set',
                'purchase_id' => 2,
                'bidding_id' => null
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'user_id' => 4,
                'type' => 'rental',
                'purchase_id' => 3,
                'bidding_id' => null
            ],
            [
                'id' => 4,
                'product_id' => 10,
                'user_id' => 3,
                'type' => 'bidding',
                'purchase_id' => 4,
                'bidding_id' => null
            ],
            [
                'id' => 5,
                'product_id' => 15,
                'user_id' => 3,
                'type' => 'bidding',
                'purchase_id' => 5,
                'bidding_id' => null
            ],
            [
                'id' => 6,
                'product_id' => 18,
                'user_id' => 3,
                'type' => 'set',
                'purchase_id' => null,
                'bidding_id' => null
            ],
        ]);

    }
}