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
                'product_id' => 1
            ],
            [
                'user_id' => 2,
                'product_id' => 5
            ],
            [
                'user_id' => 2,
                'product_id' => 10
            ],
            [
                'user_id' => 2,
                'product_id' => 20
            ],
            [
                'user_id' => 2,
                'product_id' => 13
            ],
            [
                'user_id' => 2,
                'product_id' => 17
            ],
        ]);
    }
}
