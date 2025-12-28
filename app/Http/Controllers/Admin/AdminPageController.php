<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    private function ensureAuthenticated(Request $request): RedirectResponse|null
    {
        if (! $request->session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    public function categories(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->ensureAuthenticated($request)) {
            return $redirect;
        }

        return view('admin.categories');
    }

    public function restaurants(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->ensureAuthenticated($request)) {
            return $redirect;
        }

        return view('admin.restaurants');
    }

    public function dishes(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->ensureAuthenticated($request)) {
            return $redirect;
        }

        return view('admin.dishes');
    }
}
