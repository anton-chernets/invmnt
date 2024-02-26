<?php

use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\ArticleController;

Route::prefix('api')->group(function () {
    Route::prefix('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/search', [ArticleController::class, 'search']);
        Route::middleware(['auth:sanctum', 'admin'])->group(function () {
            Route::get('/trashed', [ArticleController::class, 'trashed']);
            Route::post('/store', [ArticleController::class, 'store']);
            Route::delete('/remove', [ArticleController::class, 'remove']);
            Route::put('/restore', [ArticleController::class, 'restore']);
        });
    });
});
