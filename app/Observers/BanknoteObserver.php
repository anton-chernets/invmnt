<?php

namespace App\Observers;

use App\Events\BanknoteCreated;
use App\Events\BanknoteUpdated;
use App\Models\Banknote;
use Illuminate\Support\Facades\Event;

class BanknoteObserver
{
    public function created(Banknote $banknote): void
    {
        Event::dispatch(new BanknoteCreated($banknote->name, $banknote->count, $banknote->url));
    }

    public function updated(Banknote $banknote): void
    {
        if ($banknote->isDirty('count')) {
            $oldCount = $banknote->getOriginal('count');
            if ((is_null($oldCount) || $oldCount === 0) && $banknote->count > 1) {
                event(new BanknoteUpdated($banknote->name, $banknote->count, $oldCount, $banknote->url));
            }
        }
    }
}
