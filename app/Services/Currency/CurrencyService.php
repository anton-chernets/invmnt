<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Services\BaseService;

class CurrencyService extends BaseService
{
    public static function updateOrCreateCurrency(string $slug): Currency//TODO to repo
    {
        return Currency::updateOrCreate(['slug' => $slug]);
    }
}
