<?php

use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\ArticleController;

Route::prefix('api')->group(function () {
    Route::get('articles', [ArticleController::class, 'index']);
});
