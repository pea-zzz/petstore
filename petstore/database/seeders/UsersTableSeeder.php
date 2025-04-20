<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Florynn',
                'email' => 'florynn@example.com',
                'password' => Hash::make('florynn@1234'),
                'phone_number' => '0123456789',
                'address' => '123 User Street, User City',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'password' => Hash::make('JaneDoe@2024'),
                'phone_number' => '0198765432',
                'address' => '456 User Lane, Townville',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => Hash::make('JohnS!987'),
                'phone_number' => null,
                'address' => null,
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
