<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Services\BaseService;

class CurrencyService extends BaseService
{
    /**
     * @throws \Exception
     */
    public static function handleRatesResponse(array $response): void
    {
        if ($response['success']) {
            foreach ($response['rates'] as $key => $rate) {
                $currency = CurrencyService::updateOrCreateCurrency($key);
                $currency->rates()->attach($currency->id, ['rate_value' => 1 / $rate]);
            }
        } else if (isset($response['error'])) {
            throw new \Exception($response['error']['message']);
        } else {
            throw new \Exception('unknown error');
        }
    }
    public static function updateOrCreateCurrency(string $slug): Currency//TODO to repo
    {
        return Currency::updateOrCreate(['slug' => $slug]);
    }
}
