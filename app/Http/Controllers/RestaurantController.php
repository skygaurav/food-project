<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller for public restaurant API endpoints.
 *
 * Provides read-only access to approved restaurants for the frontend.
 *
 * @package App\Http\Controllers
 */
class RestaurantController extends Controller
{
    /**
     * Get all approved restaurants.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->where('is_approved', true)
            ->with(['categories', 'images'])
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $restaurants]);
    }

    /**
     * Get list of cities with approved restaurants.
     *
     * Used for city filter dropdowns on the frontend.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities(): JsonResponse
    {
        $cities = Restaurant::query()
            ->where('is_approved', true)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return response()->json(['data' => $cities]);
    }

    /**
     * Search restaurants by name for autocomplete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->string('q')->toString();

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $restaurants = Restaurant::query()
            ->where('is_approved', true)
            ->where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'city', 'postcode')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($restaurants);
    }

    /**
     * Get a single restaurant with its dishes.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Restaurant $restaurant): JsonResponse
    {
        $restaurant->load([
            'categories',
            'images',
            'dishes' => fn ($query) => $query->with('images')->where('status', 'approved'),
        ]);

        return response()->json($restaurant);
    }

    /**
     * Get all categories for selection.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(): JsonResponse
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($categories);
    }
}
