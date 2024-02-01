<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Services\Currency\CurrencyService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetCurrencyRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Currency $currency) {}

    /**
     * Execute the job.
     * @throws GuzzleException
     * @throws \Exception
     */
    public function handle(Client $httpClient, CurrencyService $currencyService): void
    {
        $currencyExchangeApiKey = env('CURRENCY_EXCHANGE_API_KEY');
        $json = $httpClient->request(
            'GET',
            "https://api.forexrateapi.com/v1/latest?api_key=$currencyExchangeApiKey&base=" . $this->currency->slug
        )
            ->getBody()
            ->getContents();//TODO method request-or

        $result = json_decode($json, true);

        $currencyService->handleRatesResponse($result);
    }
}
