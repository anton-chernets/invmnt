<?php

namespace App\Providers;

use App\Repositories\BanknoteRepository;
use App\Repositories\CoinRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(CoinRepository::class);
        $this->app->bind(BanknoteRepository::class);
        $this->app->bind(UserRepository::class);
        $this->app->bind(CurrencyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
