<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DishReaction model representing user reactions (like/dislike) to dishes.
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $dish_id
 * @property int $user_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Dish $dish
 */
class DishReaction extends Model
{
    use HasFactory;

    /**
     * Reaction type: Like.
     */
    public const TYPE_LIKE = 'like';

    /**
     * Reaction type: Dislike.
     */
    public const TYPE_DISLIKE = 'dislike';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dish_id',
        'user_id',
        'type',
    ];

    /**
     * Get the dish that this reaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Dish, \App\Models\DishReaction>
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}
