<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Model\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'lastname' => '-',
                'street' => '-',
                'house_number' => '-',
                'postal_code' => '-',
                'email' => 'admin@live.nl',
                'password' => Hash::make('admin'),
                'role_id' => 4
            ],
            [
                'name' => 'Jan',
                'lastname' => 'Maas',
                'street' => 'Volgeslaan',
                'house_number' => '13',
                'postal_code' => '1234AB',
                'email' => 'maas@live.nl',
                'password' => Hash::make('password'),
                'role_id' => 1
            ],
            [
                'name' => 'Kira',
                'lastname' => 'Molen',
                'street' => 'Huisstraat',
                'house_number' => '11',
                'postal_code' => '1234AB',
                'email' => 'molen@live.nl',
                'password' => Hash::make('password'),
                'role_id' => 2
            ],
            [
                'name' => 'Lilian',
                'lastname' => 'Akkers',
                'street' => 'Graanlaan',
                'house_number' => '12',
                'postal_code' => '1234AB',
                'email' => 'akkers@live.nl',
                'password' => Hash::make('password'),
                'role_id' => 3
            ],
        ]);
    }
}
