<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;

Route::prefix('api')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/search', [ProductController::class, 'search']);
        Route::get('/show/{id}', [ProductController::class, 'show']);
        Route::middleware(['auth:sanctum', 'admin'])->group(function () {
            Route::get('/trashed', [ProductController::class, 'trashed']);
            Route::post('/update/{id}', [ProductController::class, 'update']);
            Route::post('/store', [ProductController::class, 'store']);
            Route::delete('/remove', [ProductController::class, 'remove']);
            Route::put('/restore', [ProductController::class, 'restore']);
        });
    });
});
