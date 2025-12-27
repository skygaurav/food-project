<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDishStatusRequest;
use App\Models\Dish;
use Illuminate\Http\JsonResponse;

class DishApprovalController extends Controller
{
    public function index(): JsonResponse
    {
        $dishes = Dish::query()
            ->with(['restaurant', 'images'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json($dishes);
    }

    public function update(UpdateDishStatusRequest $request, Dish $dish): JsonResponse
    {
        $dish->update($request->validated());

        return response()->json($dish->load(['restaurant', 'images']));
    }

    public function approve(Dish $dish): JsonResponse
    {
        $dish->status = 'approved';
        $dish->save();

        return response()->json($dish->load(['restaurant', 'images']));
    }

    public function disapprove(Dish $dish): JsonResponse
    {
        $dish->status = 'rejected';
        $dish->save();

        return response()->json($dish->load(['restaurant', 'images']));
    }
}
