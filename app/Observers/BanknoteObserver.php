<?php

namespace App\Observers;

use App\Events\BanknoteCreated;
use App\Events\BanknoteUpdated;
use App\Models\Banknote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class BanknoteObserver
{
    public function created(Banknote $banknote): void
    {
        $banknotePageURL = Cache::get("banknote_page_url_{$banknote->name}");

        Event::dispatch(new BanknoteCreated($banknote->name, $banknote->count, $banknotePageURL));

        Cache::forget("banknote_page_url_{$banknote->name}");
    }

    public function updated(Banknote $banknote): void
    {
        $banknotePageURL = Cache::get("banknote_page_url_{$banknote->name}");

        if ($banknote->isDirty('count')) {
            $oldCount = $banknote->getOriginal('count');
            if ((is_null($oldCount) || $oldCount === 0) && $banknote->count > 1) {
                event(new BanknoteUpdated($banknote->name, $banknote->count, $oldCount, $banknotePageURL));
            }
        }

        Cache::forget("banknote_page_url_{$banknote->name}");
    }
}
