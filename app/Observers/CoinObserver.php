<?php

namespace App\Observers;

use App\Events\CoinCreated;
use App\Events\CoinUpdated;
use App\Models\Coin;
use Illuminate\Support\Facades\Event;

class CoinObserver
{
    public function created(Coin $coin): void
    {
        Event::dispatch(new CoinCreated($coin->name));
    }
    public function updated(Coin $coin): void
    {
        if ($coin->isDirty('count')) {
            $oldCount = $coin->getOriginal('count');
            if ((is_null($oldCount) || $oldCount === 0) && $coin->count > 1) {
                event(new CoinUpdated($coin->name, $coin->count, $oldCount));
            }
        }
    }
}
