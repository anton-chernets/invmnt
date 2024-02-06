<?php

use App\Http\Controllers\Api\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('user', [UserAuthController::class, 'user']);
Route::middleware('auth:sanctum')->delete('remove', [UserAuthController::class, 'remove']);
