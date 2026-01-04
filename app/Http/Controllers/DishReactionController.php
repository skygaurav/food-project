<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionRequest;
use App\Models\Dish;
use App\Models\DishReaction;
use Illuminate\Http\JsonResponse;

/**
 * Controller for managing dish reactions (likes/dislikes).
 *
 * Handles creating, updating, and removing user reactions on dishes.
 *
 * @package App\Http\Controllers
 */
class DishReactionController extends Controller
{
    /**
     * Reaction type constants.
     */
    private const REACTION_LIKE = 'like';
    private const REACTION_DISLIKE = 'dislike';

    /**
     * Store or toggle a reaction on a dish.
     *
     * If user has no reaction, creates one. If user has same reaction, removes it.
     * If user has different reaction, updates it.
     *
     * @param  \App\Http\Requests\StoreReactionRequest  $request
     * @param  string  $slug  The dish slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReactionRequest $request, string $slug): JsonResponse
    {
        $dish = Dish::where('slug', $slug)->firstOrFail();
        $type = $request->string('type')->toString();

        $existingReaction = $this->findUserReaction($dish, $request->user()->id);

        if ($existingReaction) {
            return $this->handleExistingReaction($existingReaction, $dish, $type);
        }

        return $this->createNewReaction($dish, $request->user()->id, $type);
    }

    /**
     * Remove user's reaction from a dish.
     *
     * @param  string  $slug  The dish slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $slug): JsonResponse
    {
        $dish = Dish::where('slug', $slug)->firstOrFail();
        
        DishReaction::query()
            ->where('dish_id', $dish->id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'message' => 'Reaction removed',
            'likes_count' => $this->getLikesCount($dish),
            'dislikes_count' => $this->getDislikesCount($dish),
        ]);
    }

    /**
     * Find the user's existing reaction on a dish.
     *
     * @param  \App\Models\Dish  $dish
     * @param  int  $userId
     * @return \App\Models\DishReaction|null
     */
    private function findUserReaction(Dish $dish, int $userId): ?DishReaction
    {
        return DishReaction::query()
            ->where('dish_id', $dish->id)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Handle updating or removing an existing reaction.
     *
     * @param  \App\Models\DishReaction  $existingReaction
     * @param  \App\Models\Dish  $dish
     * @param  string  $type
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleExistingReaction(
        DishReaction $existingReaction,
        Dish $dish,
        string $type
    ): JsonResponse {
        // If same type, remove it (toggle off)
        if ($existingReaction->type === $type) {
            $existingReaction->delete();

            return response()->json([
                'message' => 'Reaction removed',
                'reaction' => null,
                'likes_count' => $this->getLikesCount($dish),
                'dislikes_count' => $this->getDislikesCount($dish),
            ]);
        }

        // If different type, update it
        $existingReaction->update(['type' => $type]);

        return response()->json([
            'message' => 'Reaction updated',
            'reaction' => $existingReaction,
            'likes_count' => $this->getLikesCount($dish),
            'dislikes_count' => $this->getDislikesCount($dish),
        ]);
    }

    /**
     * Create a new reaction on a dish.
     *
     * @param  \App\Models\Dish  $dish
     * @param  int  $userId
     * @param  string  $type
     * @return \Illuminate\Http\JsonResponse
     */
    private function createNewReaction(Dish $dish, int $userId, string $type): JsonResponse
    {
        $reaction = DishReaction::query()->create([
            'dish_id' => $dish->id,
            'user_id' => $userId,
            'type' => $type,
        ]);

        return response()->json([
            'message' => 'Reaction added',
            'reaction' => $reaction,
            'likes_count' => $this->getLikesCount($dish),
            'dislikes_count' => $this->getDislikesCount($dish),
        ], 201);
    }

    /**
     * Get the count of likes for a dish.
     *
     * @param  \App\Models\Dish  $dish
     * @return int
     */
    private function getLikesCount(Dish $dish): int
    {
        return $dish->reactions()->where('type', self::REACTION_LIKE)->count();
    }

    /**
     * Get the count of dislikes for a dish.
     *
     * @param  \App\Models\Dish  $dish
     * @return int
     */
    private function getDislikesCount(Dish $dish): int
    {
        return $dish->reactions()->where('type', self::REACTION_DISLIKE)->count();
    }
}
