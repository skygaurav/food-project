<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\AdminSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to check if the site is in maintenance mode.
 *
 * When maintenance mode is enabled via admin settings, this middleware
 * will display a maintenance page to all visitors except logged-in admins.
 *
 * @package App\Http\Middleware
 */
class CheckMaintenanceMode
{
    /**
     * The key used to store maintenance mode setting in admin_settings table.
     */
    private const MAINTENANCE_MODE_KEY = 'maintenance_mode';

    /**
     * Handle an incoming request.
     *
     * Checks if maintenance mode is enabled and returns a 503 maintenance page
     * for regular visitors. Admin users with active sessions can bypass this.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next  The next middleware
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isMaintenanceModeEnabled() && ! $this->isAdminUser($request)) {
            return response()->view('maintenance', [], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return $next($request);
    }

    /**
     * Check if maintenance mode is enabled in admin settings.
     *
     * @return bool True if maintenance mode is enabled, false otherwise
     */
    private function isMaintenanceModeEnabled(): bool
    {
        $setting = AdminSetting::where('key', self::MAINTENANCE_MODE_KEY)->first();

        if (! $setting) {
            return false;
        }

        $value = $setting->value;

        return $value === true
            || $value === 1
            || $value === '1'
            || $value === 'true';
    }

    /**
     * Check if the current request is from an authenticated admin user.
     *
     * Uses session-based authentication to verify admin status.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @return bool True if user is an authenticated admin, false otherwise
     */
    private function isAdminUser(Request $request): bool
    {
        return $request->session()->has('admin_id');
    }
}
