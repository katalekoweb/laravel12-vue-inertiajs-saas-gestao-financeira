<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\SuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return redirect(route('admin.finances.index'));
    # return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name("admin.")->prefix("admin")->group(function () {
    Route::resource("tenants", TenantController::class)->middleware(SuperAdmin::class);
    Route::middleware(Admin::class)->group(function () {
        Route::get("settings", [TenantController::class, 'settingsView'])->name('settings');
        Route::post("settings/{tenant}", [TenantController::class, 'settingsUpdate'])->name('settings.update');
        Route::resource('users', UserController::class);
    });
    Route::resource('categories', CategoryController::class);
    Route::resource('finances', FinanceController::class);
});

require __DIR__.'/auth.php';
