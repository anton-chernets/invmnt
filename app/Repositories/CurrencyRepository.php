<?php

namespace App\Repositories;

use App\Enums\CurrencySlugEnum;
use App\Models\Currency;

class CurrencyRepository
{
    public function updateOrCreateBySlug(string $slug): Currency
    {
        return Currency::updateOrCreate(['slug' => $slug]);
    }

    public function getMainCurrency(): Currency
    {
        return Currency::whereSlug(['slug' => CurrencySlugEnum::UAH])->firstOrFail();
    }
}
