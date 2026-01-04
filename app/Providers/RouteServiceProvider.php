<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Route service provider.
 *
 * Handles loading and configuring application routes.
 *
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Route bindings
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutes();
    }

    /**
     * Load application routes from route files.
     *
     * @return void
     */
    protected function loadRoutes(): void
    {
        $this->loadWebRoutes();
        $this->loadApiRoutes();
    }

    /**
     * Load web routes with web middleware.
     *
     * @return void
     */
    private function loadWebRoutes(): void
    {
        $webRoutesPath = base_path('routes/web.php');

        if (file_exists($webRoutesPath)) {
            Route::middleware('web')->group(function () use ($webRoutesPath): void {
                require $webRoutesPath;
            });
        }
    }

    /**
     * Load API routes with api prefix and web middleware.
     *
     * Uses web middleware for session-based authentication.
     *
     * @return void
     */
    private function loadApiRoutes(): void
    {
        $apiRoutesPath = base_path('routes/api.php');

        if (file_exists($apiRoutesPath)) {
            Route::prefix('api')->middleware('web')->group(function () use ($apiRoutesPath): void {
                require $apiRoutesPath;
            });
        }
    }
}
