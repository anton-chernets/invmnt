<?php

namespace Modules\Order\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\Order\Events\OrderFulfilled;
use Modules\Order\Events\SendOrderCreatedTelegram;

class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        OrderFulfilled::class => [
            SendOrderCreatedTelegram::class
        ]
    ];
}
