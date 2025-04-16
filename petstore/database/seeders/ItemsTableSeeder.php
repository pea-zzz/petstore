<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Selection;
use App\Models\Image;

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

        //  Items WITHOUT selections
        $items = [
            [
                'name' => 'Yellow Flower Scratching Post', 
                'price' => 249.90, 
                'stock' => 100, 
                'category_id' => $categories['Cat Trees / Scratchers'],
                'description' => "• 2-in-1 Plush Perch and Scratching Post\n• With dangling toy\n• Helps encourage positive scratching behavior\n\nIncludes: 1 Scratching Post\n\nDimensions: 12.6 in L x 12.6 in W x 19 in H (32 x 32 x 48.2 cm)",
                'images' => ['images/cat_tree/yellow_flower_scratcher.jpg', 'images/cat_tree/yellow_flower_scratcher2.jpg' ]
            ],
            [
                'name' => 'Stairway Cat Tree', 
                'price' => 669.90, 
                'stock' => 100, 
                'category_id' => $categories['Cat Trees / Scratchers'],
                'description' => "We just know your Haiwan will have a ball of fun with this cosy cat tree, which features an astronaut bauble to peek out from! Delightfully equipped with multiple platforms to hop on, with many, many sisal posts to scratch - this may be your Haiwan's new favourite yet.\n\nThis beauty is crafted from solid rubber wood.\n\nMeasurement: 48L x 48W x 130H cm",
                'images' => ['images/cat_tree/stairway_cat_tree.jpg', 'images/cat_tree/stairway_cat_tree2.jpg']
            ],
            [
                'name' => 'Rudolph Scratching Ball', 
                'price' => 89.90, 
                'stock' => 100, 
                'category_id' => $categories['Cat Trees / Scratchers'],
                'description' => "An Xmas special: this adorable, limited edition reindeer is an absolute delight for your Haiwan's claws! A jolly good time indeed.\n\nIts body is crafted from natural sisal fibre, which is scratch and bite resistant (your Haiwan will soon figure that out for themselves, much to their surprise). The best part - now your Haiwan will focus on scratching on its giant friend, instead of your furniture!\n\nMeasurement: 30L x 30W x 42H cm.",
                'images' => ['images/cat_tree/rudolph_ball.jpg', 'images/cat_tree/rudolph_ball2.jpg']
            ],
            [
                'name' => 'Alpaca Catnip Toy', 
                'price' => 27.90, 
                'stock' => 100, 
                'category_id' => $categories['Toys'],
                'description' => "This adorable alpaca is catnip infused, so it is sure to please. Toss it around, and pique your Haiwan's interest with its little inner bell!\n\nMeasures 7 x 8 x H19 cm.",
                'images' => ['images/toys/alpaca _catnip_toy.jpg', 'images/toys/alpaca _catnip_toy2.jpg']
            ],
            [
                'name' => 'French Fries Cat Teaser with Catnip', 
                'price' => 29.90, 
                'stock' => 100, 
                'category_id' => $categories['Toys'],
                'description' => "French fries... for cats! Catnip infused shoestring for all! Features a built-in bell, and a solid wooden rod.\n\nMeasures H40 x L9 cm.",
                'images' => ['images/toys/french_fries_cat_teaser.jpg', 'images/toys/french_fries_cat_teaser2.jpg']
            ],
            [
                'name' => 'Wooden Cat Toy', 
                'price' => 32.90, 
                'stock' => 100, 
                'category_id' => $categories['Toys'],
                'description' => "Material: Wood\nBattery Properties: Without Battery\n\n• Enhance your kitten's cognitive skills with these wooden cat toys\n• Stimulate your kitten's thinking ability with interactive playtime\n• Made of high-quality wood, safe for your kitten to play with\n• Cute cat design that will keep your kitten entertained for hours\n• Perfect gift for any cat lover or new kitten owner",
                'images' => ['images/toys/wooden_cat_toy.jpg', 'images/toys/wooden_cat_toy2.jpg']
            ],
            [
                'name' => 'Pudding Feeder', 
                'price' => 34.90, 
                'stock' => 100, 
                'category_id' => $categories['Bowls'],
                'description' => "This adorable ceramic feeder boasts a 180ml volume, and is microwave safe. The angled feeder reduces strain, and helps your Haiwan's posture in the long run!\n\nWeighing 700g, this feeder is not easy to topple - perfect for rowdy Haiwans.\n\nMeasures D13.5 x H9/13 cm, with a depth of 3 cm.",
                'images' => ['images/pet_bowls/pudding_feeder.jpg', 'images/pet_bowls/pudding_feeder2.jpg', 'images/pet_bowls/pudding_feeder3.jpg']
            ],
            [
                'name' => 'Stainless Steel Bowl', 
                'price' => 39.90, 
                'stock' => 100,  
                'category_id' => $categories['Bowls'],
                'description' => "• Raised litter box: The wooden frame of the cat bowl is made durable and is made of natural bamboo. The 3 trays of the cat litter box set are made of food grade stainless steel and therefore completely safe in terms of composition. Guaranteed food safe and free from chemical or harmful substances - only the best for your pet.\n\n• Multi-purpose: the 3-piece feeder holder with 3 stainless steel bowls are ideal for cats or small dogs such as chihuahua, Prague rotler. The dog bar is suitable for water, dry and wet food. The high-quality wooden box holders have a water-repellent coating for a long service life. Simply wipe the surface of the feed frame with a damp cloth stainless steel bowl.",
                'images' => ['images/pet_bowls/stainless_steel_bowl.jpg', 'images/pet_bowls/stainless_steel_bowl2.jpg']
            ],
            [
                'name' => 'Tempura Bed', 
                'price' => 105.90, 
                'stock' => 100,  
                'category_id' => $categories['Beds'],
                'description' => "• Raised litter box: The wooden frame of the cat bowl is made durable and is made of natural bamboo. The 3 trays of the cat litter box set are made of food grade stainless steel and therefore completely safe in terms of composition. Guaranteed food safe and free from chemical or harmful substances - only the best for your pet.\n\n• Multi-purpose: the 3-piece feeder holder with 3 stainless steel bowls are ideal for cats or small dogs such as chihuahua, Prague rotler. The dog bar is suitable for water, dry and wet food. The high-quality wooden box holders have a water-repellent coating for a long service life. Simply wipe the surface of the feed frame with a damp cloth stainless steel bowl.",
                'images' => ['images\beds\tempura.jpg', 'images\beds\tempura2.jpg', 'images\beds\tempura3.jpg']
            ],
            [
                'name' => 'Fluffy Round Pet Bed', 
                'price' => 225.90, 
                'stock' => 100,  
                'category_id' => $categories['Beds'],
                'description' => "• Raised litter box: The wooden frame of the cat bowl is made durable and is made of natural bamboo. The 3 trays of the cat litter box set are made of food grade stainless steel and therefore completely safe in terms of composition. Guaranteed food safe and free from chemical or harmful substances - only the best for your pet.\n\n• Multi-purpose: the 3-piece feeder holder with 3 stainless steel bowls are ideal for cats or small dogs such as chihuahua, Prague rotler. The dog bar is suitable for water, dry and wet food. The high-quality wooden box holders have a water-repellent coating for a long service life. Simply wipe the surface of the feed frame with a damp cloth stainless steel bowl.",
                'images' => ['images\beds\fluffy_round.jpg', 'images\beds\fluffy_round2.jpg', 'images\beds\fluffy_round3.jpg']
            ],
            [
                'name' => 'Cookie Nest', 
                'price' => 34.90, 
                'stock' => 100,  
                'category_id' => $categories['Beds'],
                'description' => "• Raised litter box: The wooden frame of the cat bowl is made durable and is made of natural bamboo. The 3 trays of the cat litter box set are made of food grade stainless steel and therefore completely safe in terms of composition. Guaranteed food safe and free from chemical or harmful substances - only the best for your pet.\n\n• Multi-purpose: the 3-piece feeder holder with 3 stainless steel bowls are ideal for cats or small dogs such as chihuahua, Prague rotler. The dog bar is suitable for water, dry and wet food. The high-quality wooden box holders have a water-repellent coating for a long service life. Simply wipe the surface of the feed frame with a damp cloth stainless steel bowl.",
                'images' => ['images\beds\cookie_nest.jpg', 'images\beds\cookie_nest2.jpg', 'images\beds\cookie_nest3.jpg']
            ],
        ];

        // Insert items without selections
        foreach ($items as $itemData) {
            $images = $itemData['images'];  // Grab the images array

            // Create the item
            $item = Item::create([
                'name' => $itemData['name'],
                'price' => $itemData['price'],
                'stock' => $itemData['stock'],
                'category_id' => $itemData['category_id'],
                'description' => $itemData['description'],
                'image' => json_encode($images), // Store images as a JSON string
            ]);
        
            // Insert images
            foreach ($images as $imageUrl) {
                Image::create([
                    'url' => $imageUrl,
                    'item_id' => $item->id,
                ]);
            }
        }

        //  Items WITH selections and corresponding images for selections
        $itemsWithSelections = [
            [
                'name' => 'Ceramic bowl', 
                'price' => 44.90, 
                'stock' => 100, 
                'category_id' => $categories['Bowls'],
                'description' => "Indulge your beloved pet with our unique pet bowls, inspired by the vibrant freshness of fruit. Each bowl is not only a functional item for your pet's daily meals but also a playful accent piece that adds a cheerful vibe to your home decor. With these fruit-inspired bowls, your pet's dining area becomes a bright and happy corner, reflecting the loving care you put into every aspect of their lives.\n\n• Material: Ceramic\n• Note: Minor imperfections such as black spots, pin holes, and uneven glaze may exist after high-temperature firing, which is normal.\n• Package List: 1 Bowl",
                'images' => ['images/pet_bowls/ceramic_bowl.jpg', 'images/pet_bowls/ceramic_bowl2.jpg'],
                'selections' => [
                    ['option' => 'Dragon fruit', 'image' => 'images/pet_bowls/ceramic_bowl_dragonfruit.jpg'],
                    ['option' => 'Watermelon', 'image' => 'images/pet_bowls/ceramic_bowl_watermelon.jpg'],
                    ['option' => 'Lemon', 'image' => 'images/pet_bowls/ceramic_bowl_lemon.jpg'],
                ]
            ],
            [
                'name' => 'Polyester Woven Fabric Jacket', 
                'price' => 27.90, 
                'stock' => 100, 
                'category_id' => $categories['Clothes'],
                'description' => "• Color: Coffee color\n• Main Wearing Method: Press Buckle\n• Composition/Cover Composition: 100% Polyester\n• Weaving Method: Woven",
                'images' => ['images/clothes/woven_fabric_jacket.jpg', 'images/clothes/woven_fabric_jacket2.jpg', 'images/clothes/woven_fabric_jacket3.jpg'],
                'selections' => [
                        ['option' => 'S', 'image' => 'images/clothes/woven_fabric_jacket.jpg'],
                        ['option' => 'M', 'image' => 'images/clothes/woven_fabric_jacket2.jpg'],
                        ['option' => 'L', 'image' => 'images/clothes/woven_fabric_jacket3.jpg'],
                    ]
            ],
            [
                'name' => 'Flower Styled Cat Cone', 
                'price' => 34.90, 
                'stock' => 100, 
                'category_id' => $categories['Clothes'],
                'description' => "Features:\n• Scratch & Bite-resistant: The pet collar is designed to protect your pets from injuries, rashes, and post-surgery wounds.\n• Comfortable & Not Block Vision: Make your pet wear it comfortably and it does not block your pets' vision. They can eat, drink, play and sleep normally.\n• Cute flower shape design.\n• Easy to Use & Highly Durable: The new-style recovery collar is soft and washable.\n\nMaterial:\n• Fiber cotton, crystal litters\n\nNeck measurement:\n• 9.8cm",
                'images' => ['images/clothes/flower_cat_cone.jpg', 'images/clothes/flower_cat_cone2.jpg'],
                'selections' => [['option' => 'One size', 'image' => 'images/clothes/flower_cat_cone2.jpg']]
            ],
            [
                'name' => 'Cute Cowboy Pet Costume', 
                'price' => 29.90, 
                'stock' => 100, 
                'category_id' => $categories['Clothes'],
                'description' => "Features:\n• Theme: Cowboy\n• Material: Polyester\n• Filling Material: Polyester\n• Pattern: Cowboy\n• All-season: Summer, Spring\n• Breed Recommendation: Small, Medium\n• Operation Instruction: Machine Wash\n• Main Wearing Method: Pullover\n• Weaving Method: Woven",
                'images' => ['images/clothes/cowboy_costume.jpg', 'images/clothes/cowboy_costume2.jpg', 'images/clothes/cowboy_costume3.jpg'],
                'selections' => [
                    ['option' => 'S', 'image' => 'images/clothes/cowboy_costume2.jpg'],
                    ['option' => 'M', 'image' => 'images/clothes/cowboy_costume3.jpg'],
            ]
            ],
        ];

        // Insert items with selections and create selection records
        foreach ($itemsWithSelections as $itemData) {
            $selectionsData = $itemData['selections'];
            $images = $itemData['images'];  // Store images in a separate variable
            unset($itemData['selections']); // Remove selection before inserting item

            // Create the item
            $item = Item::create([
                'name' => $itemData['name'],
                'price' => $itemData['price'],
                'stock' => $itemData['stock'],
                'category_id' => $itemData['category_id'],
                'description' => $itemData['description'],
                'image' => json_encode($images), // Store images as a JSON string
            ]);

            // Insert images (if any)
            foreach ($images as $imageUrl) {
                Image::create([
                    'url' => $imageUrl,
                    'item_id' => $item->id,
                ]);
            }

            // Insert selections with their corresponding images
            foreach ($selectionsData as $selectionData) {
                // Create the selection
                $selection = Selection::create([
                    'option' => $selectionData['option'],
                    'item_id' => $item->id,
                    'image' => $selectionData['image']  // Store selection image URL
                ]);
            
                // Create an image for each selection
                Image::create([
                    'url' => $selectionData['image'],
                    'item_id' => $item->id,
                    'selection_id' => $selection->id  // Link image to selection
                ]);
            }
        }
    }
}




        

