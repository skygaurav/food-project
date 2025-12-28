<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\DishImage;
use App\Models\DishReaction;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Italian', 'slug' => 'italian'],
            ['name' => 'Mexican', 'slug' => 'mexican'],
            ['name' => 'Asian', 'slug' => 'asian'],
            ['name' => 'American', 'slug' => 'american'],
            ['name' => 'Seafood', 'slug' => 'seafood'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Create a sample user
        $user = User::firstOrCreate(
            ['email' => 'demo@foodcita.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        // Create sample restaurants
        $restaurants = [
            [
                'name' => 'Bella Italia',
                'city' => 'New York',
                'region' => 'New York',
                'country' => 'USA',
                'postcode' => '10001',
                'address' => '123 Main St, New York, NY 10001',
                'is_approved' => true,
                'categories' => ['italian'],
            ],
            [
                'name' => 'Taco Fiesta',
                'city' => 'Los Angeles',
                'region' => 'California',
                'country' => 'USA',
                'postcode' => '90028',
                'address' => '456 Sunset Blvd, Los Angeles, CA 90028',
                'is_approved' => true,
                'categories' => ['mexican'],
            ],
            [
                'name' => 'Tokyo Ramen',
                'city' => 'San Francisco',
                'region' => 'California',
                'country' => 'USA',
                'postcode' => '94102',
                'address' => '789 Market St, San Francisco, CA 94102',
                'is_approved' => true,
                'categories' => ['asian'],
            ],
            [
                'name' => 'The Burger Joint',
                'city' => 'Chicago',
                'region' => 'Illinois',
                'country' => 'USA',
                'postcode' => '60601',
                'address' => '321 Michigan Ave, Chicago, IL 60601',
                'is_approved' => true,
                'categories' => ['american'],
            ],
            [
                'name' => 'Ocean Fresh',
                'city' => 'Miami',
                'region' => 'Florida',
                'country' => 'USA',
                'postcode' => '33139',
                'address' => '555 Ocean Dr, Miami, FL 33139',
                'is_approved' => true,
                'categories' => ['seafood'],
            ],
        ];

        foreach ($restaurants as $restData) {
            $categoryIds = Category::whereIn('slug', $restData['categories'])->pluck('id');
            unset($restData['categories']);
            
            $restaurant = Restaurant::firstOrCreate(
                ['name' => $restData['name']],
                $restData
            );
            $restaurant->categories()->sync($categoryIds);
        }

        // Create sample dishes
        $dishes = [
            [
                'name' => 'Margherita Pizza',
                'slug' => 'margherita-pizza',
                'restaurant' => 'Bella Italia',
                'comment' => 'Classic Italian pizza with fresh mozzarella and basil',
                'meal_cost' => 18.99,
                'status' => 'approved',
                'likes' => 45,
                'reviews' => [5, 4, 5, 5, 4],
            ],
            [
                'name' => 'Spicy Tuna Roll',
                'slug' => 'spicy-tuna-roll',
                'restaurant' => 'Tokyo Ramen',
                'comment' => 'Fresh tuna with spicy mayo and avocado',
                'meal_cost' => 14.50,
                'status' => 'approved',
                'likes' => 32,
                'reviews' => [5, 5, 4],
            ],
            [
                'name' => 'Carne Asada Tacos',
                'slug' => 'carne-asada-tacos',
                'restaurant' => 'Taco Fiesta',
                'comment' => 'Grilled steak tacos with fresh salsa verde',
                'meal_cost' => 12.99,
                'status' => 'approved',
                'likes' => 58,
                'reviews' => [5, 5, 5, 4, 5, 4],
            ],
            [
                'name' => 'Classic Cheeseburger',
                'slug' => 'classic-cheeseburger',
                'restaurant' => 'The Burger Joint',
                'comment' => 'Juicy beef patty with melted cheddar',
                'meal_cost' => 15.99,
                'status' => 'approved',
                'likes' => 72,
                'reviews' => [5, 4, 5, 4, 4, 5, 5],
            ],
            [
                'name' => 'Grilled Lobster Tail',
                'slug' => 'grilled-lobster-tail',
                'restaurant' => 'Ocean Fresh',
                'comment' => 'Fresh Maine lobster with garlic butter',
                'meal_cost' => 45.00,
                'status' => 'approved',
                'likes' => 28,
                'reviews' => [5, 5, 5, 5],
            ],
            [
                'name' => 'Tonkotsu Ramen',
                'slug' => 'tonkotsu-ramen',
                'restaurant' => 'Tokyo Ramen',
                'comment' => 'Rich pork bone broth with chashu',
                'meal_cost' => 16.00,
                'status' => 'approved',
                'likes' => 41,
                'reviews' => [4, 5, 4, 5, 4],
            ],
            [
                'name' => 'Lasagna',
                'slug' => 'lasagna',
                'restaurant' => 'Bella Italia',
                'comment' => 'Layers of pasta, meat sauce, and ricotta',
                'meal_cost' => 22.00,
                'status' => 'approved',
                'likes' => 35,
                'reviews' => [4, 4, 5, 4],
            ],
            [
                'name' => 'Fish Tacos',
                'slug' => 'fish-tacos',
                'restaurant' => 'Taco Fiesta',
                'comment' => 'Beer-battered fish with chipotle crema',
                'meal_cost' => 13.50,
                'status' => 'approved',
                'likes' => 25,
                'reviews' => [4, 4, 5],
            ],
        ];

        $images = [
            'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600',
            'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=600',
            'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=600',
            'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600',
            'https://images.unsplash.com/photo-1533777324565-a040eb52facd?w=600',
            'https://images.unsplash.com/photo-1557872943-16a5ac26437e?w=600',
            'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=600',
            'https://images.unsplash.com/photo-1512838243191-e81e8f66f1fd?w=600',
        ];

        foreach ($dishes as $i => $dishData) {
            $restaurant = Restaurant::where('name', $dishData['restaurant'])->first();
            if (!$restaurant) continue;

            $likes = $dishData['likes'];
            $reviews = $dishData['reviews'];
            unset($dishData['restaurant'], $dishData['likes'], $dishData['reviews']);
            
            $dishData['restaurant_id'] = $restaurant->id;
            $dishData['user_id'] = $user->id;

            $dish = Dish::firstOrCreate(
                ['slug' => $dishData['slug']],
                $dishData
            );

            // Create dish image
            DishImage::firstOrCreate(
                ['dish_id' => $dish->id],
                [
                    'path' => $images[$i % count($images)],
                    'is_primary' => true,
                ]
            );

            // Create likes (using single user for now, just update the count logic)
            // For sample data, we'll just create one like per dish (the unique constraint prevents multiple)
            DishReaction::firstOrCreate([
                'dish_id' => $dish->id,
                'user_id' => $user->id,
            ], [
                'type' => 'like',
            ]);

            // Create reviews (using single user for now, just one review per dish)
            $avgRating = count($reviews) > 0 ? array_sum($reviews) / count($reviews) : 4;
            Review::firstOrCreate(
                [
                    'dish_id' => $dish->id,
                    'user_id' => $user->id,
                ],
                [
                    'rating' => (int) round($avgRating),
                    'comment' => 'Great dish! Highly recommend.',
                ]
            );
        }

        $this->command->info('Sample data created successfully!');
    }
}
