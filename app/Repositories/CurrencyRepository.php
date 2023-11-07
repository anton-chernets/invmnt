<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    public static function updateOrCreate(string $slug): Currency
    {
        return Currency::updateOrCreate(['slug' => $slug]);
    }
}
