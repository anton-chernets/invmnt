<?php

namespace App\Repositories;

use App\Enums\CurrencySlugEnum;
use App\Models\Coin;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class CoinRepository
{
    public function getByName($coinName)
    {
        return Coin::where('name', $coinName)->first();
    }

    public function create($coinName, $coinSlug, $coinCount, $coinPageUrl): void
    {
        DB::transaction(function () use ($coinName, $coinSlug, $coinCount, $coinPageUrl) {
            Coin::query()->create([
                'currency_id' => Currency::firstWhere('slug', CurrencySlugEnum::UAH)->id,
                'name' => $coinName,
                'url' => $coinPageUrl,
                'slug' => $coinSlug,
                'count' => $coinCount,
            ]);
        });
    }

    public function update($existingCoin, $coinCount): void
    {
        $existingCoin->update(['count' => $coinCount]);
    }
}
