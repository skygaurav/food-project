<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutes();
    }

    protected function loadRoutes(): void
    {
        $webRoutesPath = base_path('routes/web.php');
        if (file_exists($webRoutesPath)) {
            // Load web routes within the 'web' middleware so session/cookie middleware runs
            Route::middleware('web')->group(function () use ($webRoutesPath) {
                require $webRoutesPath;
            });
        }
        
        $apiRoutesPath = base_path('routes/api.php');
        if (file_exists($apiRoutesPath)) {
            // Load api routes with 'api' prefix and 'web' middleware for session-based auth
            Route::prefix('api')->middleware('web')->group(function () use ($apiRoutesPath) {
                require $apiRoutesPath;
            });
        }
    }
}
