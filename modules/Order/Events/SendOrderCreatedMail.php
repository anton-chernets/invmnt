<?php

namespace Modules\Order\Events;

use Illuminate\Support\Facades\Mail;

class SendOrderCreatedMail
{
    public function handle(OrderFulfilled $event): void
    {
//        Mail::to($event->userEmail)->send();
    }
}
