<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
use App\Models\User;
use App\Models\Item;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample Reviews for Item 1: "Item 1"
        $reviewsItem1 = [
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'item_id' => 1, // Assuming item with ID 1 exists
                'rating' => 5,
                'comment' => 'Great quality, highly recommend!'
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'item_id' => 1, // Assuming item with ID 1 exists
                'rating' => 4,
                'comment' => 'Good value for the price, but could improve on packaging.'
            ],
            [
                'user_id' => 3, // Assuming user with ID 3 exists
                'item_id' => 1, // Assuming item with ID 1 exists
                'rating' => 3,
                'comment' => 'It’s decent, but the color was slightly different from the picture.'
            ],
        ];

        // Sample Reviews for Item 2: "Item 2"
        $reviewsItem2 = [
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'item_id' => 2, // Assuming item with ID 2 exists
                'rating' => 4,
                'comment' => 'Nice product, works as expected, but a little expensive.'
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'item_id' => 2, // Assuming item with ID 2 exists
                'rating' => 5,
                'comment' => 'Amazing! Exceeded my expectations in every way.'
            ],
            [
                'user_id' => 3, // Assuming user with ID 3 exists
                'item_id' => 2, // Assuming item with ID 2 exists
                'rating' => 4,
                'comment' => 'Solid product, the material feels premium and durable.'
            ],
        ];

        // Sample Reviews for Item 3: "Item 3"
        $reviewsItem3 = [
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'item_id' => 3, // Assuming item with ID 3 exists
                'rating' => 2,
                'comment' => 'It didn’t meet my expectations, not as described.'
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'item_id' => 3, // Assuming item with ID 3 exists
                'rating' => 3,
                'comment' => 'It’s okay, but I expected better for the price.'
            ],
            [
                'user_id' => 3, // Assuming user with ID 3 exists
                'item_id' => 3, // Assuming item with ID 3 exists
                'rating' => 4,
                'comment' => 'Good overall, but it could be improved in terms of design.'
            ],
        ];
        
        // Insert reviews for Item 1
        foreach ($reviewsItem1 as $review) {
            Review::create($review);
        }

        // Insert reviews for Item 2
        foreach ($reviewsItem2 as $review) {
            Review::create($review);
        }

        // Insert reviews for Item 3
        foreach ($reviewsItem3 as $review) {
            Review::create($review);
        }
    }
}
