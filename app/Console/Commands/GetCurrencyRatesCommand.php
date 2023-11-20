<?php

namespace App\Console\Commands;

use App\Jobs\GetCurrencyRatesJob;
use App\Repositories\CurrencyRepository;
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
     * @param CurrencyRepository $currencyRepository
     */
    public function handle(CurrencyRepository $currencyRepository): void
    {
        GetCurrencyRatesJob::dispatch(
            $currencyRepository->getMainCurrency(),
        );
    }
}
