<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Dish extends Model
{
    use HasFactory;

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

    protected $casts = [
        'good_date_spot' => 'boolean',
        'reservation' => 'boolean',
        'meal_cost' => 'decimal:2',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Boot the model and add event listeners.
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

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(DishImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(DishReaction::class);
    }
}
