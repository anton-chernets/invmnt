<?php

namespace App\Services\Currency;

use App\Repositories\CurrencyRepository;
use App\Services\BaseService;

class CurrencyService extends BaseService
{
    public function __construct(protected CurrencyRepository $currencyRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public static function handleRatesResponse(array $response): void
    {
        if ($response['success']) {
            foreach ($response['rates'] as $key => $rate) {
                $currency = CurrencyRepository::updateOrCreate($key);
                $currency->rates()->attach($currency->id, ['rate_value' => 1 / $rate]);
            }
        } else if (isset($response['error'])) {
            throw new \Exception($response['error']['message']);
        } else {
            throw new \Exception('unknown error');
        }
    }
}
