<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DishImage model representing images associated with dishes.
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $dish_id
 * @property string $path
 * @property string|null $alt_text
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Dish $dish
 */
class DishImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dish_id',
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
     * Get the dish that owns this image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Dish, \App\Models\DishImage>
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}
