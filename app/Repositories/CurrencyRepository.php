<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    public function updateOrCreateBySlug(string $slug): Currency
    {
        return Currency::updateOrCreate(['slug' => $slug]);
    }
}
