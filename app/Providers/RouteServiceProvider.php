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
        $routesPath = base_path('routes/web.php');
        if (file_exists($routesPath)) {
            // Load web routes within the 'web' middleware so session/cookie middleware runs
            Route::middleware('web')->group(function () use ($routesPath) {
                require $routesPath;
            });
        }
    }
}
