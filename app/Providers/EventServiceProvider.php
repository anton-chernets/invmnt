<?php

namespace App\Providers;

use App\Events\CoinCreated;
use App\Events\CoinUpdated;
use App\Listeners\SendTelegramNotification;
use App\Models\Coin;
use App\Observers\CoinObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CoinCreated::class => [
            SendTelegramNotification::class,
        ],
        CoinUpdated::class => [
            SendTelegramNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Coin::observe(CoinObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
