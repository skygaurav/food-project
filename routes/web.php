<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPagesController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/dishes/{dish}', 'dish');
Route::view('/upload', 'upload');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
Route::get('/admin', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin pages (views)
Route::get('/admin/categories', [AdminPagesController::class, 'categories']);
Route::get('/admin/restaurants', [AdminPagesController::class, 'restaurants']);
Route::get('/admin/disapprovals', [AdminPagesController::class, 'disapprovals']);

// Admin web API (session based)
Route::prefix('admin/api')->middleware(['web','admin.auth'])->group(function (): void {
	Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
	Route::post('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store']);
	Route::put('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update']);
	Route::delete('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy']);

	Route::get('restaurants', [\App\Http\Controllers\Admin\RestaurantController::class, 'index']);
	Route::post('restaurants', [\App\Http\Controllers\Admin\RestaurantController::class, 'store']);
	Route::put('restaurants/{restaurant}', [\App\Http\Controllers\Admin\RestaurantController::class, 'update']);
	Route::delete('restaurants/{restaurant}', [\App\Http\Controllers\Admin\RestaurantController::class, 'destroy']);

	Route::get('dishes/pending', [\App\Http\Controllers\Admin\DishApprovalController::class, 'index']);
	Route::post('dishes/{dish}/approve', [\App\Http\Controllers\Admin\DishApprovalController::class, 'approve']);
	Route::post('dishes/{dish}/disapprove', [\App\Http\Controllers\Admin\DishApprovalController::class, 'disapprove']);
});
