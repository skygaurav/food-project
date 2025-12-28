<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('admin_id')) {
            if ($request->expectsJson() || $request->is('admin/api/*')) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect('/admin/login');
        }

        return $next($request);
    }
}
