<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('token.check');
});

/*
|--------------------------------------------------------------------------
| Ürün İşlemleri
|--------------------------------------------------------------------------
*/

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store'])->middleware(['auth:api', 'admin']);
    Route::put('/{id}', [ProductController::class, 'update'])->middleware(['auth:api', 'admin']);
    Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware(['auth:api', 'admin']);
});

/*
|--------------------------------------------------------------------------
| Sepet İşlemleri
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->middleware('auth:api')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/items', [CartController::class, 'store']);
    Route::put('/items/{id}', [CartController::class, 'update']);
    Route::delete('/items/{id}', [CartController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Sipariş İşlemleri
|--------------------------------------------------------------------------
*/

Route::prefix('orders')->middleware('auth:api')->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
});
