<?php

namespace App\Observers;

use App\Events\CoinCreated;
use App\Events\CoinUpdated;
use App\Models\Coin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class CoinObserver
{
    public function created(Coin $coin): void
    {
        $coinPageURL = Cache::get("coin_page_url_{$coin->name}");

        Event::dispatch(new CoinCreated($coin->name, $coin->count, $coinPageURL));

        Cache::forget("coin_page_url_{$coin->name}");
    }

    public function updated(Coin $coin): void
    {
        $coinPageURL = Cache::get("coin_page_url_{$coin->name}");

        if ($coin->isDirty('count')) {
            $oldCount = $coin->getOriginal('count');
            if ((is_null($oldCount) || $oldCount === 0) && $coin->count > 1) {
                event(new CoinUpdated($coin->name, $coin->count, $oldCount, $coinPageURL));
            }
        }

        Cache::forget("coin_page_url_{$coin->count}");
    }
}
