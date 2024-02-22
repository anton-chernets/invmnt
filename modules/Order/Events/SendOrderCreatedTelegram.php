<?php

namespace Modules\Order\Events;

class SendOrderCreatedTelegram
{
    public function handle(OrderFulfilled $event): void
    {
//        dd($event);
    }
}
