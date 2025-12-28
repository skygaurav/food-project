<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DishReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'dish_id',
        'user_id',
        'type',
    ];

    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}
