<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPasswordResetController;
use App\Http\Controllers\Admin\AdminPagesController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\DishApprovalController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishReactionController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserAuthController;
use App\Models\Dish;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

/*
|--------------------------------------------------------------------------
| Frontend Routes (with Maintenance Mode Check)
|--------------------------------------------------------------------------
*/
Route::middleware('maintenance')->group(function (): void {
    // Public pages
    Route::view('/', 'home')->name('home');
    Route::view('/popular', 'popular')->name('popular');
    Route::view('/dishes', 'dishes')->name('dishes.index');

    Route::get('/dishes/{dish:slug}', function (Dish $dish) {
        return view('dish', ['dishSlug' => $dish->slug]);
    })->name('dishes.show');

    // CMS pages
    Route::get('/page/{slug}', [CmsPageController::class, 'showPage'])->name('cms.page');

    // Guest-only routes (login, register, password reset)
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [UserAuthController::class, 'login']);
        Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [UserAuthController::class, 'register']);

        // Password reset
        Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])
            ->name('password.request');
        Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
            ->name('password.email');
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])
            ->name('password.reset');
        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
            ->name('password.update');
    });

    // Logout (accessible to authenticated users)
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    // Authenticated user routes
    Route::middleware('auth')->group(function (): void {
        Route::get('/upload', fn () => view('upload'))->name('upload');
        Route::post('/api/dishes', [DishController::class, 'store'])->name('dishes.store');
        Route::get('/my-dishes', fn () => view('my-dishes'))->name('my-dishes');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin authentication (public)
Route::prefix('admin')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin password reset
    Route::get('/forgot-password', [AdminPasswordResetController::class, 'showForgotPassword'])
        ->name('admin.password.request');
    Route::post('/forgot-password', [AdminPasswordResetController::class, 'sendResetLink'])
        ->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminPasswordResetController::class, 'showResetPassword'])
        ->name('admin.password.reset');
    Route::post('/reset-password', [AdminPasswordResetController::class, 'resetPassword'])
        ->name('admin.password.update');
});

// Admin dashboard (requires auth)
Route::get('/admin', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

// Admin pages (views - require admin auth via controller or middleware)
Route::prefix('admin')->group(function (): void {
    // Categories
    Route::get('/categories', [AdminPagesController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [AdminPagesController::class, 'categoryForm'])->name('admin.categories.create');
    Route::get('/categories/{category}/edit', [AdminPagesController::class, 'categoryForm'])->name('admin.categories.edit');

    // Restaurants
    Route::get('/restaurants', [AdminPagesController::class, 'restaurants'])->name('admin.restaurants');
    Route::get('/restaurants/create', [AdminPagesController::class, 'restaurantForm'])->name('admin.restaurants.create');
    Route::get('/restaurants/{restaurant}/edit', [AdminPagesController::class, 'restaurantForm'])->name('admin.restaurants.edit');
    Route::get('/restaurants/{restaurant}/dishes', [AdminPagesController::class, 'restaurantDishes'])->name('admin.restaurants.dishes');

    // Dishes
    Route::get('/dishes', [AdminPagesController::class, 'dishes'])->name('admin.dishes');
    Route::get('/dishes/{dish:id}', [AdminPagesController::class, 'dishView'])->name('admin.dishes.show');
    Route::get('/disapprovals', [AdminPagesController::class, 'disapprovals'])->name('admin.disapprovals');

    // Settings
    Route::get('/settings', [AdminPagesController::class, 'settings'])->name('admin.settings');

    // Admin users
    Route::get('/admins', [AdminPagesController::class, 'admins'])->name('admin.admins');
    Route::get('/admins/create', [AdminPagesController::class, 'adminForm'])->name('admin.admins.create');
    Route::get('/admins/{admin}/edit', [AdminPagesController::class, 'adminForm'])->name('admin.admins.edit');

    // Website users
    Route::get('/users', [AdminPagesController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminPagesController::class, 'userForm'])->name('admin.users.create');
    Route::get('/users/{user}/edit', [AdminPagesController::class, 'userForm'])->name('admin.users.edit');

    // CMS Pages
    Route::get('/cms-pages', [CmsPageController::class, 'index'])->name('admin.cms-pages');
    Route::get('/cms-pages/create', [CmsPageController::class, 'create'])->name('admin.cms-pages.create');
    Route::get('/cms-pages/{id}/edit', [CmsPageController::class, 'edit'])->name('admin.cms-pages.edit');

    // SPA view
    Route::get('/spa', fn () => view('admin.spa'))->middleware('admin.auth')->name('admin.spa');
});

/*
|--------------------------------------------------------------------------
| Admin API Routes (Session-based Authentication)
|--------------------------------------------------------------------------
*/
Route::prefix('admin/api')->middleware(['web', 'admin.auth'])->group(function (): void {
    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Restaurants
    Route::get('restaurants', [AdminRestaurantController::class, 'index']);
    Route::post('restaurants', [AdminRestaurantController::class, 'store']);
    Route::put('restaurants/{restaurant}', [AdminRestaurantController::class, 'update']);
    Route::delete('restaurants/{restaurant}', [AdminRestaurantController::class, 'destroy']);

    // Settings
    Route::get('settings', [AdminSettingController::class, 'get']);
    Route::post('settings', [AdminSettingController::class, 'save']);
    Route::post('settings/test-email', [AdminSettingController::class, 'testEmail']);

    // Dishes
    Route::get('dishes', [DishApprovalController::class, 'all']);
    Route::get('dishes/pending', [DishApprovalController::class, 'index']);
    Route::get('dishes/{dish:id}', [DishApprovalController::class, 'show']);
    Route::post('dishes/{dish:id}/approve', [DishApprovalController::class, 'approve']);
    Route::post('dishes/{dish:id}/disapprove', [DishApprovalController::class, 'disapprove']);
    Route::post('dishes/{dish:id}/set-pending', [DishApprovalController::class, 'setPending']);

    // Admin user management
    Route::get('admins', [AdminManagementController::class, 'index']);
    Route::get('admins/{admin}', [AdminManagementController::class, 'show']);
    Route::post('admins', [AdminManagementController::class, 'store']);
    Route::put('admins/{admin}', [AdminManagementController::class, 'update']);
    Route::delete('admins/{admin}', [AdminManagementController::class, 'destroy']);

    // Website user management
    Route::get('users', [UserManagementController::class, 'index']);
    Route::get('users/{user}', [UserManagementController::class, 'show']);
    Route::post('users', [UserManagementController::class, 'store']);
    Route::put('users/{user}', [UserManagementController::class, 'update']);
    Route::delete('users/{user}', [UserManagementController::class, 'destroy']);

    // CMS Pages
    Route::get('cms-pages', [CmsPageController::class, 'apiIndex']);
    Route::get('cms-pages/{id}', [CmsPageController::class, 'apiShow']);
    Route::post('cms-pages', [CmsPageController::class, 'apiStore']);
    Route::put('cms-pages/{id}', [CmsPageController::class, 'apiUpdate']);
    Route::delete('cms-pages/{id}', [CmsPageController::class, 'apiDestroy']);
});

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function (): void {
    // Dishes
    Route::get('dishes', [DishController::class, 'index']);
    Route::get('dishes/{dish:slug}', [DishController::class, 'show']);

    // Restaurants
    Route::get('restaurants', [RestaurantController::class, 'index']);
    Route::get('restaurants/search', [RestaurantController::class, 'search']);
    Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show']);

    // Categories
    Route::get('categories', [CategoryController::class, 'index']);

    // CMS
    Route::get('cms-pages/footer', [CmsPageController::class, 'footerPages']);

    // Authenticated user API routes
    Route::middleware('auth')->group(function (): void {
        // Reactions
        Route::post('dishes/{dish:slug}/reactions', [DishReactionController::class, 'store']);
        Route::delete('dishes/{dish:slug}/reactions', [DishReactionController::class, 'destroy']);

        // Reviews
        Route::post('dishes/{dish:slug}/reviews', [ReviewController::class, 'store']);

        // User's own dishes
        Route::get('my-dishes', [DishController::class, 'myDishes']);
        Route::put('dishes/{dish:id}', [DishController::class, 'update']);
        Route::delete('dishes/{dish:id}', [DishController::class, 'destroy']);
    });
});
