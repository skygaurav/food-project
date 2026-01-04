<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller for rendering admin panel pages.
 *
 * Handles view rendering for all admin panel sections.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminPagesController extends Controller
{
    /**
     * Show the categories management page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function categories(Request $request): View
    {
        return view('admin.categories');
    }

    /**
     * Show the restaurants management page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function restaurants(Request $request): View
    {
        return view('admin.restaurants');
    }

    /**
     * Show the restaurant form for creating or editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant|null  $restaurant
     * @return \Illuminate\View\View
     */
    public function restaurantForm(Request $request, ?Restaurant $restaurant = null): View
    {
        if ($restaurant === null) {
            $restaurant = new Restaurant();
            $restaurant->setRelation('categories', collect());
        } else {
            $restaurant->load('categories');
        }

        return view('admin.restaurant_form', ['restaurant' => $restaurant]);
    }

    /**
     * Show dishes for a specific restaurant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\View\View
     */
    public function restaurantDishes(Request $request, Restaurant $restaurant): View
    {
        $dishes = $restaurant->dishes()->with('images')->get();

        return view('admin.restaurant_dishes', compact('restaurant', 'dishes'));
    }

    /**
     * Show the category form for creating or editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category|null  $category
     * @return \Illuminate\View\View
     */
    public function categoryForm(Request $request, ?Category $category = null): View
    {
        return view('admin.category_form', ['category' => $category]);
    }

    /**
     * Show the dishes management page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function dishes(Request $request): View
    {
        return view('admin.dishes');
    }

    /**
     * Show a single dish with full details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\View\View
     */
    public function dishView(Request $request, Dish $dish): View
    {
        $dish->load(['restaurant.categories', 'images', 'reviews.user', 'reactions', 'user']);

        return view('admin.dish_view', ['dish' => $dish]);
    }

    /**
     * Show the disapprovals/rejections page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function disapprovals(Request $request): View
    {
        return view('admin.disapprovals');
    }

    /**
     * Show the admin settings page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function settings(Request $request): View
    {
        return view('admin.settings');
    }

    /**
     * Show the admin users management page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function admins(Request $request): View
    {
        return view('admin.admins');
    }

    /**
     * Show the admin form for creating or editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin|null  $admin
     * @return \Illuminate\View\View
     */
    public function adminForm(Request $request, ?Admin $admin = null): View
    {
        return view('admin.admin_form', ['admin' => $admin]);
    }

    /**
     * Show the users management page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function users(Request $request): View
    {
        return view('admin.users');
    }

    /**
     * Show the user form for creating or editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User|null  $user
     * @return \Illuminate\View\View
     */
    public function userForm(Request $request, ?User $user = null): View
    {
        return view('admin.user_form', ['user' => $user]);
    }
}
