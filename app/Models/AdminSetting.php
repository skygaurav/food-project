<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * AdminSetting model representing key-value configuration settings.
 *
 * Settings are stored as JSON-encoded values for flexibility.
 *
 * @package App\Models
 *
 * @property int $id
 * @property int|null $admin_id
 * @property string $key
 * @property mixed $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class AdminSetting extends Model
{
    use HasFactory;

    /**
     * The key used to wrap simple values in JSON storage.
     */
    private const VALUE_WRAPPER_KEY = '_value';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'key',
        'value',
    ];

    /**
     * Get the value attribute.
     *
     * Decodes the JSON-stored value and unwraps simple values.
     *
     * @param  string|null  $value  The raw JSON value from database
     * @return mixed The decoded value
     */
    public function getValueAttribute(?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true);

        // If it was a simple value wrapped, unwrap it
        if (is_array($decoded) && array_key_exists(self::VALUE_WRAPPER_KEY, $decoded)) {
            return $decoded[self::VALUE_WRAPPER_KEY];
        }

        return $decoded;
    }

    /**
     * Set the value attribute.
     *
     * Wraps non-array values for consistent JSON storage.
     *
     * @param  mixed  $value  The value to store
     * @return void
     */
    public function setValueAttribute(mixed $value): void
    {
        // If value is not already an array, wrap it for JSON storage
        if (! is_array($value)) {
            $this->attributes['value'] = json_encode([self::VALUE_WRAPPER_KEY => $value]);
        } else {
            $this->attributes['value'] = json_encode($value);
        }
    }
}
