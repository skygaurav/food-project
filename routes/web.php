<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/dishes/{dish}', 'dish');
Route::view('/upload', 'upload');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
Route::get('/admin', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/categories', [AdminPageController::class, 'categories'])->name('admin.categories');
Route::get('/admin/restaurants', [AdminPageController::class, 'restaurants'])->name('admin.restaurants');
Route::get('/admin/dishes', [AdminPageController::class, 'dishes'])->name('admin.dishes');
