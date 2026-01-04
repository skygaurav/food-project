<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/**
 * Application exception handler.
 *
 * Handles reporting and rendering of exceptions.
 *
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        // No custom reporting for now
    }
}
