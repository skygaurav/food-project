<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DishApprovalController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishReactionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:web'])->group(function (): void {
    Route::apiResource('categories', AdminCategoryController::class)->except(['show']);
    Route::apiResource('restaurants', AdminRestaurantController::class)->except(['show']);
    Route::get('dishes/pending', [DishApprovalController::class, 'index']);
    Route::patch('dishes/{dish}', [DishApprovalController::class, 'update']);
});

Route::get('categories', [AdminCategoryController::class, 'index']);
Route::get('restaurants', [RestaurantController::class, 'index']);
Route::get('restaurants/cities', [RestaurantController::class, 'cities']);
Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show']);
Route::get('dishes', [DishController::class, 'index']);
Route::get('dishes/popular', [DishController::class, 'popular'])->name('dishes.popular');
Route::get('dishes/{dish}', [DishController::class, 'show'])->name('dishes.show');
Route::get('reviews/recent', [ReviewController::class, 'recent']);

Route::middleware(['auth:web'])->group(function (): void {
    Route::post('dishes', [DishController::class, 'store']);
    Route::post('dishes/{dish}/reviews', [ReviewController::class, 'store']);
    Route::post('dishes/{dish}/reactions', [DishReactionController::class, 'store']);
    Route::delete('dishes/{dish}/reactions', [DishReactionController::class, 'destroy']);
});
