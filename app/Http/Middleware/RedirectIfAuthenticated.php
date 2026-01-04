<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to redirect authenticated users away from guest-only pages.
 *
 * This middleware prevents authenticated users from accessing pages like
 * login, register, and password reset forms by redirecting them to the
 * appropriate home page based on their authentication guard.
 *
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * The default redirect path for authenticated web users.
     */
    private const HOME_PATH = '/';

    /**
     * The admin dashboard route name.
     */
    private const ADMIN_DASHBOARD_ROUTE = 'admin.dashboard';

    /**
     * Handle an incoming request.
     *
     * Checks if the user is authenticated for any of the specified guards
     * and redirects them to the appropriate home page if so.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next  The next middleware
     * @param  string  ...$guards  Optional authentication guards to check
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response|RedirectResponse
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->redirectTo($guard);
            }
        }

        return $next($request);
    }

    /**
     * Get the redirect response for an authenticated user.
     *
     * @param  string|null  $guard  The authentication guard that matched
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectTo(?string $guard): RedirectResponse
    {
        if ($guard === 'admin') {
            return redirect()->route(self::ADMIN_DASHBOARD_ROUTE);
        }

        return redirect(self::HOME_PATH);
    }
}
