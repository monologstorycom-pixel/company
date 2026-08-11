<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Modules\Frontend\Controllers\HomepageController;
use App\Modules\Frontend\Controllers\ProductsController;
use App\Modules\Frontend\Controllers\ArticlesController;
use App\Modules\Frontend\Controllers\PagesController;
use App\Modules\Chatbot\Controllers\ChatbotController;

// Frontend Routes
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticlesController::class, 'show'])->name('articles.show');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'storeContact'])->name('contact.store');
Route::get('/privacy-policy', [PagesController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-conditions', [PagesController::class, 'termsConditions'])->name('terms-conditions');

// Chatbot API route (public, but needs session for tracking)
Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage'])->name('chatbot.message');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:Super Admin|Admin|Marketing')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Products management (Super Admin, Admin)
        Route::middleware('role:Super Admin|Admin')->group(function () {
            // Export route MUST be defined BEFORE resource route to avoid conflict with {product} parameter
            Route::get('products/export', [\App\Modules\Admin\Controllers\ProductController::class, 'export'])->name('products.export');
            Route::resource('products', \App\Modules\Admin\Controllers\ProductController::class);
            Route::delete('products/{product}/images/{mediaId}', [\App\Modules\Admin\Controllers\ProductController::class, 'removeImage'])->name('products.remove-image');
        });

        // Articles management (Super Admin, Admin, Marketing)
        Route::resource('articles', \App\Modules\Admin\Controllers\ArticleController::class)->middleware('role:Super Admin|Admin|Marketing');

        // Contacts management (Super Admin, Admin)
        Route::middleware('role:Super Admin|Admin')->group(function () {
            Route::get('contacts', [\App\Modules\Admin\Controllers\ContactController::class, 'index'])->name('contacts.index');
            Route::get('contacts/{contact}', [\App\Modules\Admin\Controllers\ContactController::class, 'show'])->name('contacts.show');
            Route::put('contacts/{contact}', [\App\Modules\Admin\Controllers\ContactController::class, 'update'])->name('contacts.update');
            Route::delete('contacts/{contact}', [\App\Modules\Admin\Controllers\ContactController::class, 'destroy'])->name('contacts.destroy');
        });

        // Chatbot management (Super Admin, Admin)
        Route::middleware('role:Super Admin|Admin')->group(function () {
            Route::resource('chatbot', \App\Modules\Admin\Controllers\ChatbotController::class, ['except' => ['show']]);
        });

        // Chatbot history for all roles (Super Admin, Admin, Marketing)
        Route::get('chatbot-history', [\App\Modules\Admin\Controllers\ChatbotController::class, 'history'])->name('chatbot.history')
            ->middleware('role:Super Admin|Admin|Marketing');

        // Super Admin only routes
        Route::middleware('role:Super Admin')->group(function () {
            // User Management
            Route::resource('users', \App\Modules\Admin\Controllers\UserController::class);
            
            // Role & Permission Management
            Route::resource('roles', \App\Modules\Admin\Controllers\RoleController::class);
            
            // Settings Management
            Route::get('settings', [\App\Modules\Settings\Controllers\SettingsController::class, 'index'])->name('settings.index');
            Route::put('settings', [\App\Modules\Settings\Controllers\SettingsController::class, 'update'])->name('settings.update');
            Route::post('settings', [\App\Modules\Settings\Controllers\SettingsController::class, 'store'])->name('settings.store');
            Route::delete('settings/{setting}', [\App\Modules\Settings\Controllers\SettingsController::class, 'destroy'])->name('settings.destroy');
        });
    });
});
