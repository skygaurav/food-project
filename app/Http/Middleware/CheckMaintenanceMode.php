<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\AdminSetting;
use Closure;
use Illuminate\Http\Request;
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
        
        // Check if maintenance mode is enabled (handle boolean, string "true", or integer 1)
        $isMaintenanceEnabled = false;
        if ($maintenanceMode) {
            $value = $maintenanceMode->value;
            $isMaintenanceEnabled = $value === true || $value === 1 || $value === '1' || $value === 'true';
        }
        
        if ($isMaintenanceEnabled) {
            // Allow admin users to bypass maintenance mode (using session-based admin auth)
            if ($request->session()->has('admin_id')) {
                return $next($request);
            }
            
            // Show maintenance page
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
