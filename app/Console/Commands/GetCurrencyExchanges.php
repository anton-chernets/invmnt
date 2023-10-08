<?php

namespace App\Console\Commands;

use App\Services\Currency\CurrencyService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetCurrencyExchanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-currency-exchanges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Client $httpClient)
    {
        $this->getExchangeRates($httpClient);
    }

    private function getExchangeRates(Client $httpClient, string $baseCurrencySlug = 'UAH'): void
    {
        $json = $httpClient->request(
            'GET',
            'https://api.forexrateapi.com/v1/latest?api_key=19f9b5894c0764aef905c785b328b94e&base=' . $baseCurrencySlug
        )
            ->getBody()
            ->getContents();//TODO method

        $result = json_decode($json, true);

        if (isset($result['base']) && isset($result['rates'])) {//TODO method
            $baseCurrency = CurrencyService::updateOrCreateCurrency($result['base']);
            foreach ($result['rates'] as $key => $rate) {
                $currency = CurrencyService::updateOrCreateCurrency($key);
                $baseCurrency->rates()->attach($currency->id, ['rate_value' => $rate]);
            }
        }
    }
}
