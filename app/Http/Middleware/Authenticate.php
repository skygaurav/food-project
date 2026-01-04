<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Middleware to authenticate users for protected routes.
 *
 * Extends Laravel's built-in authentication middleware to provide
 * a custom redirect path for unauthenticated web requests.
 *
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * The login route path.
     */
    private const LOGIN_PATH = '/login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * Returns the login path for web requests, or null for API requests
     * (which will receive a 401 JSON response instead).
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @return string|null The redirect path or null for JSON responses
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            return self::LOGIN_PATH;
        }

        return null;
    }
}
