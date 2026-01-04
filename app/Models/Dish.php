<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Dish model representing food items submitted by users.
 *
 * Dishes belong to restaurants and users, and can have images, reviews, and reactions.
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int|null $user_id
 * @property string $name
 * @property string $slug
 * @property string|null $comment
 * @property string $status
 * @property string|null $meal_cost
 * @property bool $good_date_spot
 * @property string|null $website
 * @property bool $reservation
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Restaurant $restaurant
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DishImage> $images
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DishReaction> $reactions
 */
class Dish extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'name',
        'slug',
        'comment',
        'status',
        'meal_cost',
        'good_date_spot',
        'website',
        'reservation',
        'phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'good_date_spot' => 'boolean',
        'reservation' => 'boolean',
        'meal_cost' => 'decimal:2',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Boot the model and add event listeners.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Dish $dish): void {
            if (empty($dish->slug)) {
                $dish->slug = static::generateUniqueSlug($dish->name);
            }
        });
    }

    /**
     * Generate a unique slug for the dish.
     *
     * @param  string  $name  The dish name to generate slug from
     * @return string The unique slug
     */
    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Get the restaurant that this dish belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Restaurant, \App\Models\Dish>
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the user who submitted this dish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Dish>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for this dish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\DishImage>
     */
    public function images(): HasMany
    {
        return $this->hasMany(DishImage::class);
    }

    /**
     * Get the reviews for this dish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Review>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the reactions for this dish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\DishReaction>
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(DishReaction::class);
    }
}
