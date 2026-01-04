<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * CmsPage model representing content management system pages.
 *
 * CMS pages are used for static content like About, Terms, Privacy Policy, etc.
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property bool $show_in_footer
 * @property int $sort_order
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage footer()
 */
class CmsPage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'show_in_footer' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model and add event listeners.
     *
     * Auto-generates slug from title if not provided.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (CmsPage $page): void {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Scope a query to only include active pages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\App\Models\CmsPage>  $query
     * @return \Illuminate\Database\Eloquent\Builder<\App\Models\CmsPage>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include footer pages, ordered by sort_order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\App\Models\CmsPage>  $query
     * @return \Illuminate\Database\Eloquent\Builder<\App\Models\CmsPage>
     */
    public function scopeFooter(Builder $query): Builder
    {
        return $query->where('show_in_footer', true)->orderBy('sort_order');
    }
}
