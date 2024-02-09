<?php

namespace Modules\FIle\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot(): void
    {
        $this->routes(function (){
            Route::middleware('api')
                ->group(__DIR__ . '/../routes.php');
        });
    }
}
