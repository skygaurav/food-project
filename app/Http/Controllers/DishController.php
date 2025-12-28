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
    /**
     * Get all dishes for public listing (approved only).
     */
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

    /**
     * Get current user's dishes (all statuses).
     */
    public function myDishes(Request $request): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(function ($dish) {
                return [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'slug' => $dish->slug,
                    'status' => $dish->status,
                    'comment' => $dish->comment,
                    'meal_cost' => $dish->meal_cost,
                    'good_date_spot' => $dish->good_date_spot,
                    'reservation' => $dish->reservation,
                    'phone' => $dish->phone,
                    'website' => $dish->website,
                    'restaurant' => $dish->restaurant ? [
                        'id' => $dish->restaurant->id,
                        'name' => $dish->restaurant->name,
                        'city' => $dish->restaurant->city,
                    ] : null,
                    'image_url' => $dish->images->first()?->path 
                        ? '/storage/' . $dish->images->first()->path 
                        : null,
                    'created_at' => $dish->created_at,
                    'updated_at' => $dish->updated_at,
                ];
            });

        return response()->json($dishes);
    }

    /**
     * Update a dish owned by the current user (only before approval).
     */
    public function update(Request $request, Dish $dish): JsonResponse
    {
        // Only the owner can update
        if ($dish->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Can only edit pending dishes
        if ($dish->status !== 'pending') {
            return response()->json(['error' => 'Only pending dishes can be edited'], 400);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'comment' => 'nullable|string|max:1000',
            'meal_cost' => 'nullable|numeric|min:0',
            'good_date_spot' => 'nullable|boolean',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:50',
            'reservation' => 'nullable|boolean',
        ]);

        $dish->update($validated);

        return response()->json($dish->load(['restaurant', 'images']));
    }

    /**
     * Delete a dish owned by the current user (only before approval).
     */
    public function destroy(Dish $dish): JsonResponse
    {
        // Only the owner can delete
        if ($dish->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Can only delete pending dishes
        if ($dish->status !== 'pending') {
            return response()->json(['error' => 'Only pending dishes can be deleted'], 400);
        }

        $dish->delete();

        return response()->json(['success' => true]);
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
                'reservation' => $request->boolean('reservation'),
                'phone' => $request->string('phone')->toString(),
            ]);

            // Update restaurant with additional info from dish submission
            $restaurantUpdates = [];
            
            if ($request->boolean('good_date_spot')) {
                $restaurantUpdates['good_date_spot'] = true;
            }
            
            if ($request->filled('website')) {
                $restaurantUpdates['website'] = $request->string('website')->toString();
            }
            
            if ($request->boolean('reservation')) {
                $restaurantUpdates['reservation'] = true;
            }
            
            if ($request->filled('phone')) {
                $restaurantUpdates['phone'] = $request->string('phone')->toString();
            }
            
            if (!empty($restaurantUpdates)) {
                Restaurant::query()->where('id', $restaurantId)->update($restaurantUpdates);
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
        // Only approved dishes can be viewed publicly
        // Unless the user is the owner of the dish
        if ($dish->status !== 'approved') {
            $isOwner = auth()->check() && auth()->id() === $dish->user_id;
            if (!$isOwner) {
                return response()->json(['error' => 'Dish not found or not yet approved'], 404);
            }
        }
        
        $dish->load([
            'restaurant.categories',
            'images',
            'reviews',
            'reactions',
        ]);
        
        $dish->loadCount([
            'reactions as likes_count' => fn ($q) => $q->where('type', 'like'),
            'reactions as dislikes_count' => fn ($q) => $q->where('type', 'dislike'),
        ]);
        
        $dish->loadAvg('reviews', 'rating');
        
        // Add user's reaction if authenticated
        $userReaction = null;
        if (auth()->check()) {
            $userReaction = $dish->reactions()
                ->where('user_id', auth()->id())
                ->first();
        }
        
        $response = $dish->toArray();
        $response['user_reaction'] = $userReaction?->type;

        return response()->json($response);
    }
}
