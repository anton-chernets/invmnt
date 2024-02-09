<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;

Route::prefix('api')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/store', [ProductController::class, 'store']);
            Route::delete('/remove', [ProductController::class, 'remove']);
        });
    });
});
