<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Dish;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller for managing dish reviews.
 *
 * Handles fetching recent reviews and creating new reviews.
 *
 * @package App\Http\Controllers
 */
class ReviewController extends Controller
{
    /**
     * Default number of recent reviews to fetch.
     */
    private const DEFAULT_RECENT_LIMIT = 6;

    /**
     * Get recent reviews for the home page.
     *
     * Returns the most recent reviews for approved dishes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recent(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', self::DEFAULT_RECENT_LIMIT);

        $reviews = Review::query()
            ->with(['user', 'dish'])
            ->whereHas('dish', fn ($q) => $q->where('status', 'approved'))
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json($reviews);
    }

    /**
     * Store a new review for a dish.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReviewRequest $request, Dish $dish): JsonResponse
    {
        $review = Review::query()->create([
            'dish_id' => $dish->id,
            'user_id' => $request->user()->id,
            'rating' => $request->integer('rating'),
            'comment' => $request->string('comment')->toString(),
        ]);

        return response()->json($review->load('dish'), 201);
    }
}
