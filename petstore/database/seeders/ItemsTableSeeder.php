<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch categories by name to get their actual ID
        $categories = DB::table('categories')->pluck('id', 'name');

        DB::table('items')->insert([
            ['name' => 'Yellow flower scratching post', 'price' => 249.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Cat Trees / Scratchers']],
            ['name' => 'Stairway cat tree', 'price' => 669.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Cat Trees / Scratchers']],
            ['name' => 'Rudolph scratching ball', 'price' => 89.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Cat Trees / Scratchers']],
            ['name' => 'Alpaca catnip toy', 'price' => 27.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Toys']],
            ['name' => 'French Fries Cat Teaser with Catnip', 'price' => 29.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Toys']],
            ['name' => 'Wooden cat toy', 'price' => 32.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Toys']],
            ['name' => 'Ceramic bowl', 'price' => 44.90, 'stock' => 100, 'selection' => 'Dragon fruit', 'category_id' => $categories['Bowls']],
            ['name' => 'Ceramic bowl', 'price' => 44.90, 'stock' => 100, 'selection' => 'Watermelon', 'category_id' => $categories['Bowls']],
            ['name' => 'Ceramic bowl', 'price' => 44.90, 'stock' => 100, 'selection' => 'Lemon', 'category_id' => $categories['Bowls']],
            ['name' => 'Pudding Feeder', 'price' => 34.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Bowls']],
            ['name' => 'Stainless steel bowl', 'price' => 39.90, 'stock' => 100, 'selection' => null, 'category_id' => $categories['Bowls']],
            ['name' => 'Polyester Woven Fabric Jacket', 'price' => 27.90, 'stock' => 100, 'selection' => 'S', 'category_id' => $categories['Clothes']],
            ['name' => 'Polyester Woven Fabric Jacket', 'price' => 27.90, 'stock' => 100, 'selection' => 'M', 'category_id' => $categories['Clothes']],
            ['name' => 'Polyester Woven Fabric Jacket', 'price' => 27.90, 'stock' => 100, 'selection' => 'L', 'category_id' => $categories['Clothes']],
            ['name' => 'Flower Styled Cat Cone', 'price' => 34.90, 'stock' => 100, 'selection' => 'One size', 'category_id' => $categories['Clothes']],
            ['name' => 'Cute Cowboy Pet Costume', 'price' => 29.90, 'stock' => 100, 'selection' => 'S', 'category_id' => $categories['Clothes']],
            ['name' => 'Cute Cowboy Pet Costume', 'price' => 29.90, 'stock' => 100, 'selection' => 'M', 'category_id' => $categories['Clothes']],
        ]);
    }
}
