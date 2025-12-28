<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionRequest;
use App\Models\Dish;
use App\Models\DishReaction;
use Illuminate\Http\JsonResponse;

class DishReactionController extends Controller
{
    public function store(StoreReactionRequest $request, Dish $dish): JsonResponse
    {
        $reaction = DishReaction::query()->updateOrCreate(
            [
                'dish_id' => $dish->id,
                'user_id' => $request->user()->id,
            ],
            [
                'type' => $request->string('type')->toString(),
            ]
        );

        return response()->json($reaction, 201);
    }
}
