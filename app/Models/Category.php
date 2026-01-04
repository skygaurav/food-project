<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Category model representing restaurant/dish categories.
 *
 * Categories are used to classify restaurants (e.g., Italian, Mexican, etc.).
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Restaurant> $restaurants
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the restaurants that belong to this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Restaurant>
     */
    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class)->withTimestamps();
    }
}
