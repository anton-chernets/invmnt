<?php

namespace App\Console\Commands;

use App\Jobs\ParseCoinsBankGovUaJob;
use Illuminate\Console\Command;

class ParseCoinsBankGovUaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:coins_bank_gov_ua';

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
        ParseCoinsBankGovUaJob::dispatch();
    }
}
