<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPagesController extends Controller
{
    public function categories(Request $request): View
    {
        return view('admin.categories');
    }

    public function restaurants(Request $request): View
    {
        return view('admin.restaurants');
    }

    public function disapprovals(Request $request): View
    {
        return view('admin.disapprovals');
    }
}
