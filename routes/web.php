<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'app');
Route::view('/dishes/{dish}', 'app');
Route::view('/upload', 'app');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
Route::get('/admin', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
