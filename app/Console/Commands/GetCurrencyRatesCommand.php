<?php

namespace App\Console\Commands;

use App\Helpers\CurrencyHelper;
use App\Jobs\GetCurrencyRatesJob;
use App\Services\Currency\CurrencyService;
use Illuminate\Console\Command;

class GetCurrencyRatesCommand extends Command
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
    public function handle(): void
    {
        GetCurrencyRatesJob::dispatch(
            CurrencyService::updateOrCreateCurrency(
                CurrencyHelper::MAIN_CURRENCY_SLUG
            )
        );
    }
}
