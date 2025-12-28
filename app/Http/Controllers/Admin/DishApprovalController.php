<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDishStatusRequest;
use App\Models\Dish;
use Illuminate\Http\JsonResponse;

class DishApprovalController extends Controller
{
    /**
     * Get all dishes for admin listing.
     */
    public function all(): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->latest()
            ->get()
            ->map(function ($dish) {
                return [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'comment' => $dish->comment,
                    'status' => $dish->status,
                    'meal_cost' => $dish->meal_cost,
                    'good_date_spot' => $dish->good_date_spot,
                    'website' => $dish->website,
                    'restaurant_id' => $dish->restaurant_id,
                    'restaurant_name' => $dish->restaurant?->name,
                    'image_url' => $dish->images->first()?->path 
                        ? '/storage/' . $dish->images->first()->path 
                        : null,
                    'created_at' => $dish->created_at,
                    'updated_at' => $dish->updated_at,
                ];
            });

        return response()->json($dishes);
    }

    public function index(): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json($dishes);
    }

    public function update(UpdateDishStatusRequest $request, Dish $dish): JsonResponse
    {
        $dish->update($request->validated());

        return response()->json($dish->load(['restaurant', 'images']));
    }

    public function approve(Dish $dish): JsonResponse
    {
        $dish->status = 'approved';
        $dish->save();
        
        // Also approve the restaurant if it was created with this dish
        if ($dish->restaurant && !$dish->restaurant->is_approved) {
            $dish->restaurant->is_approved = true;
            $dish->restaurant->save();
        }

        return response()->json($dish->load(['restaurant', 'images']));
    }

    public function disapprove(Dish $dish): JsonResponse
    {
        $dish->status = 'rejected';
        $dish->save();

        return response()->json($dish->load(['restaurant', 'images']));
    }
}
