<?php

namespace App\Observers;

use App\Events\CoinUpdated;
use App\Models\Coin;

class CoinObserver
{
    /**
     * Handle the Coin "created" event.
     */
    public function created(Coin $coin): void
    {
        //
    }

    /**
     * Handle the Coin "updated" event.
     */
    public function updated(Coin $coin): void
    {
        if ($coin->count > 0 && $coin->isDirty('count')) {
            event(new CoinUpdated($coin->name, $coin->count));
        }
    }

    /**
     * Handle the Coin "deleted" event.
     */
    public function deleted(Coin $coin): void
    {
        //
    }

    /**
     * Handle the Coin "restored" event.
     */
    public function restored(Coin $coin): void
    {
        //
    }

    /**
     * Handle the Coin "force deleted" event.
     */
    public function forceDeleted(Coin $coin): void
    {
        //
    }
}
