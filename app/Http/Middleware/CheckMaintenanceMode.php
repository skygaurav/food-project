<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\AdminSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        $maintenanceMode = AdminSetting::where('key', 'maintenance_mode')->first();
        
        if ($maintenanceMode && $maintenanceMode->value) {
            // Allow admin users to bypass maintenance mode
            if (Auth::guard('admin')->check()) {
                return $next($request);
            }
            
            // Show maintenance page
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
