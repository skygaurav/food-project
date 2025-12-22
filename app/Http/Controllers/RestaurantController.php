<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->with(['categories', 'images'])
            ->orderBy('name')
            ->get();

        return response()->json($restaurants);
    }
}
