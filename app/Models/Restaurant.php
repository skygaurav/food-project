<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'good_date_spot' => 'boolean',
        'meal_cost' => 'decimal:2',
        'is_approved' => 'boolean',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(RestaurantImage::class);
    }
}
