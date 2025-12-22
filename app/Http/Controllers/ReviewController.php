<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Dish;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
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
