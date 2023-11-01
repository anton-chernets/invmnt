<?php

namespace App\Jobs;

use App\Services\Coin\ParseCoinsBankGovUaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseCoinsBankGovUaJob implements ShouldQueue
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
        /** @var ParseCoinsBankGovUaService $parser */
        $parser = app(ParseCoinsBankGovUaService::class);
        $parser->parseCoinsData();
    }
}
