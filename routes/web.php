<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/form-login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',       [AuthController::class, 'login'])->name('login.post');
Route::get('/form-register',[AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');

// Đường dẫn trang admin
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/',                 [DashboardController::class, 'index'])->name('dashboard');

    // Route quản lý sản phẩm
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/',              [ProductController::class, 'index'])->name('index');
        Route::get('/{id}/show',     [ProductController::class, 'show'])->name('show');
        Route::get('/create',        [ProductController::class, 'create'])->name('create');
        Route::post('/store',        [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit',     [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',   [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',[ProductController::class, 'destroy'])->name('destroy');
    });
});
