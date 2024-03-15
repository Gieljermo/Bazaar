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
                'bidding_id' => null,
                'price' => 1203
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'user_id' => 4,
                'type' => 'set',
                'purchase_id' => 2,
                'bidding_id' => null,
                'price' => 50
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'user_id' => 4,
                'type' => 'rental',
                'purchase_id' => 3,
                'bidding_id' => null,
                'price' => 50
            ],
            [
                'id' => 4,
                'product_id' => 4,
                'user_id' => 3,
                'type' => 'bidding',
                'purchase_id' => 4,
                'bidding_id' => null,
                'price' => 250
            ],
            [
                'id' => 5,
                'product_id' => 5,
                'user_id' => 3,
                'type' => 'bidding',
                'purchase_id' => 5,
                'bidding_id' => null,
                'price' => 400
            ],
            [
                'id' => 6,
                'product_id' => 6,
                'user_id' => 3,
                'type' => 'set',
                'purchase_id' => null,
                'bidding_id' => null,
                'price' => 320
            ],
            [
                'id' => 7,
                'product_id' => 7,
                'user_id' => 4,
                'type' => 'bidding',
                'purchase_id' => null,
                'bidding_id' => null,
                'price' => 140
            ],
            [
                'id' => 8,
                'product_id' => 8,
                'user_id' => 3,
                'type' => 'set',
                'purchase_id' => null,
                'bidding_id' => null,
                'price' => 29
            ]
        ]);

    }
}
