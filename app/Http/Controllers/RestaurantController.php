<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->where('is_approved', true)
            ->with(['categories', 'images'])
            ->orderBy('name')
            ->get();

        return response()->json($restaurants);
    }

    /**
     * Search restaurants by name for autocomplete
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

    public function show(Restaurant $restaurant): JsonResponse
    {
        $restaurant->load([
            'categories',
            'images',
            'dishes' => fn($query) => $query->with('images')->where('status', 'approved')
        ]);

        return response()->json($restaurant);
    }
}
