<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Restaurant model representing dining establishments.
 *
 * Restaurants have dishes, images, and belong to multiple categories.
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $region
 * @property string|null $country
 * @property string|null $postcode
 * @property string|null $website
 * @property string|null $opening_hours
 * @property string|null $meal_cost
 * @property bool $good_date_spot
 * @property bool $is_approved
 * @property bool $reservation
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dish> $dishes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RestaurantImage> $images
 */
class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'region',
        'country',
        'postcode',
        'website',
        'opening_hours',
        'meal_cost',
        'good_date_spot',
        'is_approved',
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
        'meal_cost' => 'decimal:2',
        'is_approved' => 'boolean',
        'reservation' => 'boolean',
    ];

    /**
     * Get the categories that this restaurant belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /**
     * Get the dishes that belong to this restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Dish>
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    /**
     * Get the images for this restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\RestaurantImage>
     */
    public function images(): HasMany
    {
        return $this->hasMany(RestaurantImage::class);
    }
}
