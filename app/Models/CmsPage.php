<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'show_in_footer',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'show_in_footer' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Auto-generate slug from title if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Scope for active pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for footer pages
     */
    public function scopeFooter($query)
    {
        return $query->where('show_in_footer', true)->orderBy('sort_order');
    }
}
