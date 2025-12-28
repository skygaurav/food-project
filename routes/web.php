<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPagesController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\Admin\CmsPageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::get('/dishes/{dish:slug}', function (\App\Models\Dish $dish) {
    return view('dish', ['dishSlug' => $dish->slug]);
});

// CMS pages (frontend)
Route::get('/page/{slug}', [CmsPageController::class, 'showPage']);

// User authentication routes
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Upload dish (requires authentication)
Route::get('/upload', function () {
    return view('upload');
})->middleware('auth')->name('upload');
Route::post('/api/dishes', [DishController::class, 'store'])->middleware('auth');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
Route::get('/admin', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin pages (views)
Route::get('/admin/categories', [AdminPagesController::class, 'categories']);
Route::get('/admin/restaurants', [AdminPagesController::class, 'restaurants']);
Route::get('/admin/restaurants/create', [AdminPagesController::class, 'restaurantForm']);
Route::get('/admin/restaurants/{restaurant}/edit', [AdminPagesController::class, 'restaurantForm']);
Route::get('/admin/restaurants/{restaurant}/dishes', [AdminPagesController::class, 'restaurantDishes']);
Route::get('/admin/categories/create', [AdminPagesController::class, 'categoryForm']);
Route::get('/admin/categories/{category}/edit', [AdminPagesController::class, 'categoryForm']);
Route::get('/admin/dishes', [AdminPagesController::class, 'dishes']);
Route::get('/admin/dishes/{dish:id}', [AdminPagesController::class, 'dishView']);
Route::get('/admin/disapprovals', [AdminPagesController::class, 'disapprovals']);
Route::get('/admin/settings', [AdminPagesController::class, 'settings']);
Route::get('/admin/admins', [AdminPagesController::class, 'admins']);
Route::get('/admin/admins/create', [AdminPagesController::class, 'adminForm']);
Route::get('/admin/admins/{admin}/edit', [AdminPagesController::class, 'adminForm']);
Route::get('/admin/users', [AdminPagesController::class, 'users']);
Route::get('/admin/users/create', [AdminPagesController::class, 'userForm']);
Route::get('/admin/users/{user}/edit', [AdminPagesController::class, 'userForm']);
Route::get('/admin/cms-pages', [CmsPageController::class, 'index']);
Route::get('/admin/cms-pages/create', [CmsPageController::class, 'create']);
Route::get('/admin/cms-pages/{id}/edit', [CmsPageController::class, 'edit']);

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

	// admin settings
	Route::get('settings', [\App\Http\Controllers\Admin\AdminSettingController::class, 'get']);
	Route::post('settings', [\App\Http\Controllers\Admin\AdminSettingController::class, 'save']);

	// All dishes
	Route::get('dishes', [\App\Http\Controllers\Admin\DishApprovalController::class, 'all']);
	Route::get('dishes/pending', [\App\Http\Controllers\Admin\DishApprovalController::class, 'index']);
	Route::get('dishes/{dish}', [\App\Http\Controllers\Admin\DishApprovalController::class, 'show']);
	Route::post('dishes/{dish}/approve', [\App\Http\Controllers\Admin\DishApprovalController::class, 'approve']);
	Route::post('dishes/{dish}/disapprove', [\App\Http\Controllers\Admin\DishApprovalController::class, 'disapprove']);

	// Admin user management
	Route::get('admins', [\App\Http\Controllers\Admin\AdminManagementController::class, 'index']);
	Route::get('admins/{admin}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'show']);
	Route::post('admins', [\App\Http\Controllers\Admin\AdminManagementController::class, 'store']);
	Route::put('admins/{admin}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'update']);
	Route::delete('admins/{admin}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'destroy']);

	// Website user management
	Route::get('users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index']);
	Route::get('users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'show']);
	Route::post('users', [\App\Http\Controllers\Admin\UserManagementController::class, 'store']);
	Route::put('users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'update']);
	Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy']);

	// CMS Pages management
	Route::get('cms-pages', [CmsPageController::class, 'apiIndex']);
	Route::get('cms-pages/{id}', [CmsPageController::class, 'apiShow']);
	Route::post('cms-pages', [CmsPageController::class, 'apiStore']);
	Route::put('cms-pages/{id}', [CmsPageController::class, 'apiUpdate']);
	Route::delete('cms-pages/{id}', [CmsPageController::class, 'apiDestroy']);
});

Route::get('/admin/spa', function () {
    return view('admin.spa');
})->middleware(['web', 'admin.auth']);

// Public API for frontend
Route::prefix('api')->group(function (): void {
    Route::get('dishes', [\App\Http\Controllers\DishController::class, 'index']);
    Route::get('dishes/{dish:slug}', [\App\Http\Controllers\DishController::class, 'show']);
    Route::get('restaurants', [\App\Http\Controllers\RestaurantController::class, 'index']);
    Route::get('restaurants/search', [\App\Http\Controllers\RestaurantController::class, 'search']);
    Route::get('restaurants/{restaurant}', [\App\Http\Controllers\RestaurantController::class, 'show']);
    Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('cms-pages/footer', [CmsPageController::class, 'footerPages']);
    
    // Reactions (like/dislike) - requires auth
    Route::middleware('auth')->group(function (): void {
        Route::post('dishes/{dish:slug}/reactions', [\App\Http\Controllers\DishReactionController::class, 'store']);
        Route::delete('dishes/{dish:slug}/reactions', [\App\Http\Controllers\DishReactionController::class, 'destroy']);
        Route::post('dishes/{dish:slug}/reviews', [\App\Http\Controllers\ReviewController::class, 'store']);
    });
});
