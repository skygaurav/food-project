<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * RestaurantImage model representing images associated with restaurants.
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $path
 * @property string|null $alt_text
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Restaurant $restaurant
 */
class RestaurantImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'restaurant_id',
        'path',
        'alt_text',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the restaurant that owns this image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Restaurant, \App\Models\RestaurantImage>
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
