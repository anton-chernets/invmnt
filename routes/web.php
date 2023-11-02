<?php

use App\Enums\CurrencySlugEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Currency;

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
            $builder = Currency::firstWhere(['slug' => CurrencySlugEnum::UAH])
                ->join('currency_currency', 'currencies.id', '=', 'currency_currency.base_currency_id')
                ->where('currency_currency.rate_currency_id',  '=', Currency::firstWhere('slug', CurrencySlugEnum::USD)->id);

            $timeFrames = $builder->pluck('currency_currency.created_at');

            $rates = $builder->pluck('currency_currency.rate_value');

            return view('rates', compact('rates','timeFrames'));
        })->name('user.rates');
    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
