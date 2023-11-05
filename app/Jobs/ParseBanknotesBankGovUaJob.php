<?php

namespace App\Jobs;

use App\Services\Banknote\ParseBanknotesBankGovUaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseBanknotesBankGovUaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var ParseBanknotesBankGovUaService $parser */
        $parser = app(ParseBanknotesBankGovUaService::class);
        $parser->parseBanknotesData();
    }
}
