<?php

use Illuminate\Support\Facades\Route;
use Modules\File\Http\Controllers\FileController;

Route::prefix('api')->group(function () {
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/files/upload', [FileController::class, 'upload']);
    });
});
