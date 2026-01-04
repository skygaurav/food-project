<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRestaurantRequest;
use App\Http\Requests\Admin\UpdateRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Controller for managing restaurants in admin panel.
 *
 * Provides CRUD operations for restaurant management.
 *
 * @package App\Http\Controllers\Admin
 */
class RestaurantController extends Controller
{
    /**
     * List all restaurants with their relationships.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->with(['categories', 'images'])
            ->orderBy('name')
            ->get();

        return response()->json($restaurants);
    }

    /**
     * Create a new restaurant.
     *
     * Admin-created restaurants are automatically approved.
     *
     * @param  \App\Http\Requests\Admin\StoreRestaurantRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRestaurantRequest $request): JsonResponse
    {
        $restaurant = DB::transaction(function () use ($request): Restaurant {
            $data = $request->validated();
            $data['is_approved'] = true; // Admin-created restaurants are auto-approved

            $restaurant = Restaurant::query()->create($data);
            $restaurant->categories()->sync($request->validated('category_ids'));

            return $restaurant->load(['categories', 'images']);
        });

        return response()->json($restaurant, 201);
    }

    /**
     * Update an existing restaurant.
     *
     * @param  \App\Http\Requests\Admin\UpdateRestaurantRequest  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): JsonResponse
    {
        $restaurant = DB::transaction(function () use ($request, $restaurant): Restaurant {
            $restaurant->update($request->validated());
            $restaurant->categories()->sync($request->validated('category_ids'));

            return $restaurant->load(['categories', 'images']);
        });

        return response()->json($restaurant);
    }

    /**
     * Delete a restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Restaurant $restaurant): JsonResponse
    {
        $restaurant->delete();

        return response()->json(null, 204);
    }
}
