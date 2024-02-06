<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;

Route::prefix('api')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
});
