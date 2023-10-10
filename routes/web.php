<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth.basic','auth'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/rates', function () {
            return view('rates');
        })->name('user.rates');
    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
