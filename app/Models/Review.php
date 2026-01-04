<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Review model representing user reviews for dishes.
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $dish_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\User $user
 */
class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dish_id',
        'user_id',
        'rating',
        'comment',
    ];

    /**
     * Get the dish that this review belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Dish, \App\Models\Review>
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }

    /**
     * Get the user who wrote this review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Review>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
