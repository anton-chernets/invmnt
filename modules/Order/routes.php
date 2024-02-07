<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;
use Modules\Order\Http\Controllers\OrderController;

Route::prefix('api')->group(function () {
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('checkout', [CheckoutController::class, 'create']);
    });
});
