<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Cat Trees / Scratchers'],
            ['name' => 'Toys'],
            ['name' => 'Bowls'],
            ['name' => 'Clothes'],
            ['name' => 'Beds'],
        ]);
    }
}
