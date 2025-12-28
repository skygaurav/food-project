<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Dish;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Get recent reviews for the home page.
     */
    public function recent(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 6);
        
        $reviews = Review::query()
            ->with(['user', 'dish'])
            ->whereHas('dish', fn ($q) => $q->where('status', 'approved'))
            ->latest()
            ->limit($limit)
            ->get();
        
        return response()->json($reviews);
    }
    
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
