<?php

namespace App\Console\Commands;

use App\Jobs\ParseCoinsBankGovUaJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        if (DB::table('jobs')->where('payload', 'like', '%ParseCoinsBankGovUa",%')->count() === 0) {
            ParseCoinsBankGovUaJob::dispatch();
        }
    }
}
