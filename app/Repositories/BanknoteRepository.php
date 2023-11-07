<?php

namespace App\Repositories;

use App\Enums\CurrencySlugEnum;
use App\Models\Banknote;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class BanknoteRepository
{
    public function getByName($banknoteName)
    {
        return Banknote::where('name', $banknoteName)->first();
    }

    public function create($banknoteName, $banknoteSlug, $banknoteCount): void
    {
        DB::transaction(function () use ($banknoteName, $banknoteSlug, $banknoteCount) {
            Banknote::query()->create([
                'currency_id' => Currency::firstWhere('slug', CurrencySlugEnum::UAH)->id,
                'name' => $banknoteName,
                'slug' => $banknoteSlug,
                'count' => $banknoteCount,
            ]);
        });
    }

    public function update($existingBanknote, $banknoteCount): void
    {
        $existingBanknote->update(['count' => $banknoteCount]);
    }
}
