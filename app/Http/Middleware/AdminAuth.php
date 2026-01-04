<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to protect admin routes with session-based authentication.
 *
 * This middleware verifies that the user has a valid admin session before
 * allowing access to admin routes. Unauthenticated requests are redirected
 * to the admin login page or receive a 401 JSON response for API requests.
 *
 * @package App\Http\Middleware
 */
class AdminAuth
{
    /**
     * The session key used to store the admin ID.
     */
    private const ADMIN_SESSION_KEY = 'admin_id';

    /**
     * The admin login route path.
     */
    private const ADMIN_LOGIN_PATH = '/admin/login';

    /**
     * Handle an incoming request.
     *
     * Verifies admin authentication via session. Returns a 401 JSON response
     * for API requests or redirects to the admin login page for web requests.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next  The next middleware
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return $this->unauthenticatedResponse($request);
        }

        return $next($request);
    }

    /**
     * Check if the request has a valid admin session.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @return bool True if authenticated, false otherwise
     */
    private function isAuthenticated(Request $request): bool
    {
        return $request->session()->has(self::ADMIN_SESSION_KEY);
    }

    /**
     * Generate the appropriate response for unauthenticated requests.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function unauthenticatedResponse(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson() || $request->is('admin/api/*')) {
            return response()->json(
                ['message' => 'Unauthenticated.'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return redirect(self::ADMIN_LOGIN_PATH);
    }
}
