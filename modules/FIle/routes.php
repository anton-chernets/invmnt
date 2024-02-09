<?php

use Illuminate\Support\Facades\Route;
use Modules\FIle\Http\Controllers\FileController;

Route::prefix('api')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/files/upload', [FileController::class, 'upload']);
    });
});
