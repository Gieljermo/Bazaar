<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Listing;

class ListingSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Listing::factory()
            ->count(30)->create();
    }
}
