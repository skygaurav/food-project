<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Dish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::query()->where('username', $credentials['username'])->first();

        if (! $admin || ! Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors(['username' => 'Invalid username or password.'])->withInput();
        }

        $request->session()->put('admin_id', $admin->id);

        return redirect('/admin');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('admin_id')) {
            return redirect('/admin/login');
        }

        $categories = Category::query()->orderBy('name')->get();
        $restaurants = Restaurant::query()->with('categories')->orderBy('name')->get();
        $pendingDishes = Dish::query()->where('status', 'pending')->with('restaurant')->orderBy('created_at', 'desc')->get();

        return view('admin.grid', compact('categories', 'restaurants', 'pendingDishes'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_id');

        return redirect('/admin/login');
    }
}
