<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDishRequest;
use App\Models\Dish;
use App\Models\DishImage;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DishController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Dish::query()
            ->with(['restaurant.categories', 'images'])
            ->where('status', 'approved')
            ->withCount([
                'reviews as reviews_count',
                'reactions as likes_count' => fn ($relation) => $relation->where('type', 'like'),
            ])
            ->withAvg('reviews', 'rating');

        if ($request->filled('category')) {
            $query->whereHas('restaurant.categories', function ($relation) use ($request): void {
                $relation->where('slug', $request->string('category')->toString());
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('restaurant', function ($relation) use ($request): void {
                $relation->where('city', $request->string('city')->toString());
            });
        }

        if ($request->string('sort')->toString() === 'top-reviewed') {
            $query->orderByDesc('reviews_avg_rating');
        } else {
            $query->latest();
        }

        return response()->json($query->paginate(12));
    }

    public function store(StoreDishRequest $request): JsonResponse
    {
        $dish = DB::transaction(function () use ($request): Dish {
            $restaurantId = $request->integer('restaurant_id');
            
            // If no restaurant_id, create a new restaurant
            if (!$restaurantId && $request->filled('restaurant_name')) {
                $restaurantName = $request->string('restaurant_name')->toString();
                $city = $request->string('restaurant_city')->toString();
                $state = $request->string('restaurant_state')->toString();
                $postcode = $request->string('restaurant_postcode')->toString();
                
                // Check if restaurant already exists with same name, city, and postcode
                $existingRestaurant = Restaurant::query()
                    ->where('name', $restaurantName)
                    ->where('city', $city)
                    ->where('postcode', $postcode)
                    ->first();
                
                if ($existingRestaurant) {
                    $restaurantId = $existingRestaurant->id;
                } else {
                    // Create new restaurant (not approved until dish is approved)
                    $restaurant = Restaurant::query()->create([
                        'name' => $restaurantName,
                        'city' => $city,
                        'region' => $state,
                        'postcode' => $postcode,
                        'address' => $request->string('restaurant_address')->toString(),
                        'is_approved' => false,
                    ]);
                    $restaurantId = $restaurant->id;
                }
            }
            
            $dish = Dish::query()->create([
                'restaurant_id' => $restaurantId,
                'user_id' => $request->user()->id,
                'name' => $request->string('name')->toString(),
                'comment' => $request->string('comment')->toString(),
                'status' => 'pending',
                'meal_cost' => $request->input('meal_cost'),
                'good_date_spot' => $request->boolean('good_date_spot'),
                'website' => $request->string('website')->toString(),
            ]);

            // Update restaurant with good_date_spot if set to true
            if ($request->boolean('good_date_spot')) {
                Restaurant::query()->where('id', $restaurantId)->update([
                    'good_date_spot' => true,
                ]);
            }

            foreach ($request->file('images', []) as $index => $image) {
                DishImage::query()->create([
                    'dish_id' => $dish->id,
                    'path' => $image->store('dishes', 'public'),
                    'alt_text' => $dish->name,
                    'is_primary' => $index === 0,
                ]);
            }

            return $dish->load(['restaurant', 'images']);
        });

        return response()->json($dish, 201);
    }

    public function show(Dish $dish): JsonResponse
    {
        $dish->load([
            'restaurant.categories',
            'images',
            'reviews',
            'reactions',
        ]);

        return response()->json($dish);
    }
}
