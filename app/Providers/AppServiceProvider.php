<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\AdminSetting;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Application service provider.
 *
 * Registers bindings and bootstraps application services,
 * including global view data like SEO settings.
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Default SEO settings when database is unavailable.
     */
    private const DEFAULT_SEO_SETTINGS = [
        'site_name' => 'FOODCITA',
        'default_meta_title' => 'FOODCITA - Discover Delicious Dishes',
        'default_meta_description' => 'Share your favorite meals and explore dishes loved by food enthusiasts in your city.',
        'default_meta_keywords' => 'food, dishes, restaurants, reviews, dining',
        'social_facebook' => null,
        'social_instagram' => null,
        'social_twitter' => null,
        'social_youtube' => null,
        'social_tiktok' => null,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // App bindings
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->shareGlobalSeoSettings();
    }

    /**
     * Share default SEO settings with all views.
     *
     * @return void
     */
    private function shareGlobalSeoSettings(): void
    {
        View::composer('*', function ($view): void {
            static $seoSettings = null;

            if ($seoSettings === null) {
                $seoSettings = $this->loadSeoSettings();
            }

            $view->with('seoSettings', $seoSettings);
        });
    }

    /**
     * Load SEO settings from database.
     *
     * @return array<string, string|null>
     */
    private function loadSeoSettings(): array
    {
        try {
            $settings = AdminSetting::query()
                ->whereIn('key', [
                    'meta_title', 'meta_description', 'meta_keywords', 'site_name', 'site_logo',
                    'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube', 'social_tiktok',
                ])
                ->get()
                ->pluck('value', 'key')
                ->toArray();

            return [
                'site_name' => $settings['site_name'] ?? self::DEFAULT_SEO_SETTINGS['site_name'],
                'site_logo' => $settings['site_logo'] ?? null,
                'default_meta_title' => $settings['meta_title'] ?? self::DEFAULT_SEO_SETTINGS['default_meta_title'],
                'default_meta_description' => $settings['meta_description'] ?? self::DEFAULT_SEO_SETTINGS['default_meta_description'],
                'default_meta_keywords' => $settings['meta_keywords'] ?? self::DEFAULT_SEO_SETTINGS['default_meta_keywords'],
                'social_facebook' => $settings['social_facebook'] ?? null,
                'social_instagram' => $settings['social_instagram'] ?? null,
                'social_twitter' => $settings['social_twitter'] ?? null,
                'social_youtube' => $settings['social_youtube'] ?? null,
                'social_tiktok' => $settings['social_tiktok'] ?? null,
            ];
        } catch (Exception $e) {
            return self::DEFAULT_SEO_SETTINGS;
        }
    }
}
