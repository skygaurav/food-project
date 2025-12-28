<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id','key','value'];

    /**
     * Get the value attribute.
     */
    public function getValueAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        
        $decoded = json_decode($value, true);
        
        // If it was a simple value wrapped, unwrap it
        if (is_array($decoded) && array_key_exists('_value', $decoded)) {
            return $decoded['_value'];
        }
        
        return $decoded;
    }

    /**
     * Set the value attribute.
     */
    public function setValueAttribute($value)
    {
        // If value is not already an array, wrap it for JSON storage
        if (!is_array($value)) {
            $this->attributes['value'] = json_encode(['_value' => $value]);
        } else {
            $this->attributes['value'] = json_encode($value);
        }
    }
}
