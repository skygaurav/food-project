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
        $type = $request->string('type')->toString();
        
        // Check if user already has a reaction
        $existingReaction = DishReaction::query()
            ->where('dish_id', $dish->id)
            ->where('user_id', $request->user()->id)
            ->first();
        
        if ($existingReaction) {
            // If same type, remove it (toggle off)
            if ($existingReaction->type === $type) {
                $existingReaction->delete();
                return response()->json([
                    'message' => 'Reaction removed',
                    'reaction' => null,
                    'likes_count' => $dish->reactions()->where('type', 'like')->count(),
                    'dislikes_count' => $dish->reactions()->where('type', 'dislike')->count(),
                ]);
            }
            // If different type, update it
            $existingReaction->update(['type' => $type]);
            return response()->json([
                'message' => 'Reaction updated',
                'reaction' => $existingReaction,
                'likes_count' => $dish->reactions()->where('type', 'like')->count(),
                'dislikes_count' => $dish->reactions()->where('type', 'dislike')->count(),
            ]);
        }
        
        // Create new reaction
        $reaction = DishReaction::query()->create([
            'dish_id' => $dish->id,
            'user_id' => $request->user()->id,
            'type' => $type,
        ]);

        return response()->json([
            'message' => 'Reaction added',
            'reaction' => $reaction,
            'likes_count' => $dish->reactions()->where('type', 'like')->count(),
            'dislikes_count' => $dish->reactions()->where('type', 'dislike')->count(),
        ], 201);
    }

    public function destroy(Dish $dish): JsonResponse
    {
        DishReaction::query()
            ->where('dish_id', $dish->id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'message' => 'Reaction removed',
            'likes_count' => $dish->reactions()->where('type', 'like')->count(),
            'dislikes_count' => $dish->reactions()->where('type', 'dislike')->count(),
        ]);
    }
}
