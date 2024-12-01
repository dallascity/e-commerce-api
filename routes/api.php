<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;


Route::prefix('auth')->middleware('throttle:10,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('token.check');
});

/*
|--------------------------------------------------------------------------
| Ürün İşlemleri
|--------------------------------------------------------------------------
*/

Route::prefix('products')->middleware('throttle:10,1')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store'])->middleware(['token.check', 'admin']);
    Route::put('/{id}', [ProductController::class, 'update'])->middleware(['token.check', 'admin']);
    Route::post('/{id}', [ProductController::class, 'update'])->middleware(['token.check', 'admin']);
    Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware(['token.check', 'admin']);
});

/*
|--------------------------------------------------------------------------
| Sepet İşlemleri
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->middleware(['token.check', 'throttle:10,1'])->group(function () {
    Route::get('/items', [CartController::class, 'index']);
    Route::post('/items', [CartController::class, 'store']);
    Route::put('/items/{id}', [CartController::class, 'update']);
    Route::delete('/items/{id}', [CartController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Sipariş İşlemleri
|--------------------------------------------------------------------------
*/

Route::prefix('orders')->middleware(['token.check', 'throttle:10,1'])->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
});
