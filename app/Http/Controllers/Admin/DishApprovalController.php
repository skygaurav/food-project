<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDishStatusRequest;
use App\Mail\DishApprovedMail;
use App\Mail\DishRejectedMail;
use App\Models\Dish;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;

/**
 * Controller for managing dish approvals in admin panel.
 *
 * Handles dish approval, rejection, and status management.
 *
 * @package App\Http\Controllers\Admin
 */
class DishApprovalController extends Controller
{
    /**
     * Dish status constants.
     */
    private const STATUS_APPROVED = 'approved';
    private const STATUS_REJECTED = 'rejected';
    private const STATUS_PENDING = 'pending';

    /**
     * Get all dishes for admin listing.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->latest()
            ->get()
            ->map(fn (Dish $dish) => $this->formatDishForList($dish));

        return response()->json($dishes);
    }

    /**
     * Get a single dish with all details.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Dish $dish): JsonResponse
    {
        $dish->load(['restaurant.categories', 'images', 'reviews.user', 'reactions', 'user']);

        return response()->json($this->formatDishDetails($dish));
    }

    /**
     * Get pending dishes for approval queue.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->where('status', self::STATUS_PENDING)
            ->latest()
            ->get()
            ->map(fn (Dish $dish) => $this->formatDishForList($dish));

        return response()->json($dishes);
    }

    /**
     * Update a dish's details.
     *
     * @param  \App\Http\Requests\Admin\UpdateDishStatusRequest  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDishStatusRequest $request, Dish $dish): JsonResponse
    {
        $dish->update($request->validated());

        return response()->json($dish->load(['restaurant', 'images']));
    }

    /**
     * Approve a dish and its associated restaurant.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(Dish $dish): JsonResponse
    {
        $dish->status = self::STATUS_APPROVED;
        $dish->save();

        $this->approveRestaurantIfNeeded($dish);
        $this->notifyUserOfApproval($dish);

        return response()->json($dish->load(['restaurant', 'images']));
    }

    /**
     * Reject a dish.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function disapprove(Dish $dish): JsonResponse
    {
        $dish->status = self::STATUS_REJECTED;
        $dish->save();

        $this->notifyUserOfRejection($dish);

        return response()->json($dish->load(['restaurant', 'images']));
    }

    /**
     * Format a dish for list display.
     *
     * @param  \App\Models\Dish  $dish
     * @return array<string, mixed>
     */
    private function formatDishForList(Dish $dish): array
    {
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
    }

    /**
     * Format a dish with full details.
     *
     * @param  \App\Models\Dish  $dish
     * @return array<string, mixed>
     */
    private function formatDishDetails(Dish $dish): array
    {
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
            'restaurant' => $dish->restaurant,
            'images' => $dish->images->map(fn ($img) => [
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
        ];
    }

    /**
     * Approve the restaurant if it was created with this dish.
     *
     * @param  \App\Models\Dish  $dish
     * @return void
     */
    private function approveRestaurantIfNeeded(Dish $dish): void
    {
        if ($dish->restaurant && ! $dish->restaurant->is_approved) {
            $dish->restaurant->is_approved = true;
            $dish->restaurant->save();
        }
    }

    /**
     * Send approval notification to the dish owner.
     *
     * @param  \App\Models\Dish  $dish
     * @return void
     */
    private function notifyUserOfApproval(Dish $dish): void
    {
        if ($dish->user) {
            MailService::send(new DishApprovedMail($dish, $dish->user), $dish->user->email);
        }
    }

    /**
     * Send rejection notification to the dish owner.
     *
     * @param  \App\Models\Dish  $dish
     * @return void
     */
    private function notifyUserOfRejection(Dish $dish): void
    {
        if ($dish->user) {
            MailService::send(new DishRejectedMail($dish, $dish->user), $dish->user->email);
        }
    }
}
