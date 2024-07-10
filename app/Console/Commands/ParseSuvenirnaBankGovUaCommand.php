<?php

namespace App\Console\Commands;

use App\Jobs\ParseSuvenirnaBankGovUaJob;
use Illuminate\Console\Command;

class ParseSuvenirnaBankGovUaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:suvenirna_bank_gov_ua';

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
        ParseSuvenirnaBankGovUaJob::dispatch();
    }
}
