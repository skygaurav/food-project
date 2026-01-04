<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDishStatusRequest;
use App\Mail\DishApprovedMail;
use App\Mail\DishRejectedMail;
use App\Models\Dish;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

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
                    'slug' => $dish->slug,
                    'comment' => $dish->comment,
                    'status' => $dish->status,
                    'meal_cost' => $dish->meal_cost,
                    'good_date_spot' => $dish->good_date_spot,
                    'website' => $dish->website,
                    'phone' => $dish->phone,
                    'reservation' => $dish->reservation,
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

    /**
     * Get a single dish with all details.
     */
    public function show(Dish $dish): JsonResponse
    {
        $dish->load(['restaurant.categories', 'images', 'reviews.user', 'reactions', 'user']);
        
        return response()->json([
            'id' => $dish->id,
            'name' => $dish->name,
            'slug' => $dish->slug,
            'comment' => $dish->comment,
            'status' => $dish->status,
            'meal_cost' => $dish->meal_cost,
            'good_date_spot' => $dish->good_date_spot,
            'website' => $dish->website,
            'phone' => $dish->phone,
            'reservation' => $dish->reservation,
            'restaurant' => $dish->restaurant,
            'images' => $dish->images->map(fn($img) => [
                'id' => $img->id,
                'url' => '/storage/' . $img->path,
            ]),
            'reviews' => $dish->reviews,
            'reactions' => [
                'likes' => $dish->reactions->where('type', 'like')->count(),
                'dislikes' => $dish->reactions->where('type', 'dislike')->count(),
            ],
            'user' => $dish->user ? [
                'id' => $dish->user->id,
                'name' => $dish->user->name,
                'email' => $dish->user->email,
            ] : null,
            'created_at' => $dish->created_at,
            'updated_at' => $dish->updated_at,
        ]);
    }

    public function index(): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(function ($dish) {
                return [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'slug' => $dish->slug,
                    'comment' => $dish->comment,
                    'status' => $dish->status,
                    'meal_cost' => $dish->meal_cost,
                    'good_date_spot' => $dish->good_date_spot,
                    'website' => $dish->website,
                    'phone' => $dish->phone,
                    'reservation' => $dish->reservation,
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

        // Send email notification to user
        if ($dish->user) {
            Mail::to($dish->user->email)->send(new DishApprovedMail($dish, $dish->user));
        }

        return response()->json($dish->load(['restaurant', 'images']));
    }

    public function disapprove(Dish $dish): JsonResponse
    {
        $dish->status = 'rejected';
        $dish->save();

        // Send email notification to user
        if ($dish->user) {
            Mail::to($dish->user->email)->send(new DishRejectedMail($dish, $dish->user));
        }

        return response()->json($dish->load(['restaurant', 'images']));
    }
}
