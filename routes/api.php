<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

// Mặc định apiResource sẽ trỏ tới 5 phương thức mặc định 
// trong controller api (index, show, update, store, destroy)
// Nếu tạo thêm các phương thức mới trong controller api
// thì ta cần phải tạo thêm đường dẫn trỏ tới phương thức đó
// Bắt buộc route đó phải đặt bên trên apiResource
Route::post('products/restore', [ProductController::class, 'restore']);
Route::apiResource('products', ProductController::class)->middleware(['auth:sanctum']);

?>