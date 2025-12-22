<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRestaurantRequest;
use App\Http\Requests\Admin\UpdateRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->with(['categories', 'images'])
            ->orderBy('name')
            ->get();

        return response()->json($restaurants);
    }

    public function store(StoreRestaurantRequest $request): JsonResponse
    {
        $restaurant = DB::transaction(function () use ($request): Restaurant {
            $restaurant = Restaurant::query()->create($request->validated());
            $restaurant->categories()->sync($request->validated('category_ids'));

            return $restaurant->load(['categories', 'images']);
        });

        return response()->json($restaurant, 201);
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): JsonResponse
    {
        $restaurant = DB::transaction(function () use ($request, $restaurant): Restaurant {
            $restaurant->update($request->validated());
            $restaurant->categories()->sync($request->validated('category_ids'));

            return $restaurant->load(['categories', 'images']);
        });

        return response()->json($restaurant);
    }

    public function destroy(Restaurant $restaurant): JsonResponse
    {
        $restaurant->delete();

        return response()->json(null, 204);
    }
}
