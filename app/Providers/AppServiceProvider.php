<?php

namespace App\Providers;

use App\Models\AdminSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // app bindings
    }

    public function boot(): void
    {
        // Share default SEO settings with all views
        View::composer('*', function ($view) {
            static $seoSettings = null;
            
            if ($seoSettings === null) {
                try {
                    // Get global SEO settings (admin_id = 1 is typically the first admin)
                    $settings = AdminSetting::query()
                        ->whereIn('key', ['meta_title', 'meta_description', 'meta_keywords', 'site_name'])
                        ->get()
                        ->pluck('value', 'key')
                        ->toArray();
                    
                    $seoSettings = [
                        'site_name' => $settings['site_name'] ?? 'FOODCITA',
                        'default_meta_title' => $settings['meta_title'] ?? 'FOODCITA - Discover Delicious Dishes',
                        'default_meta_description' => $settings['meta_description'] ?? 'Share your favorite meals and explore dishes loved by food enthusiasts in your city.',
                        'default_meta_keywords' => $settings['meta_keywords'] ?? 'food, dishes, restaurants, reviews, dining',
                    ];
                } catch (\Exception $e) {
                    $seoSettings = [
                        'site_name' => 'FOODCITA',
                        'default_meta_title' => 'FOODCITA - Discover Delicious Dishes',
                        'default_meta_description' => 'Share your favorite meals and explore dishes loved by food enthusiasts in your city.',
                        'default_meta_keywords' => 'food, dishes, restaurants, reviews, dining',
                    ];
                }
            }
            
            $view->with('seoSettings', $seoSettings);
        });
    }
}
