<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Dish;

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

    public function restaurantDishes(Request $request, Restaurant $restaurant): View
    {
        $dishes = $restaurant->dishes()->with('images')->get();
        return view('admin.restaurant_dishes', compact('restaurant', 'dishes'));
    }

    public function categoryForm(Request $request, ?Category $category = null): View
    {
        return view('admin.category_form', ['category' => $category]);
    }

    public function dishes(Request $request): View
    {
        return view('admin.dishes');
    }

    public function disapprovals(Request $request): View
    {
        return view('admin.disapprovals');
    }

    public function settings(Request $request): View
    {
        return view('admin.settings');
    }
}
