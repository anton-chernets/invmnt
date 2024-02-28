<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Article\Jobs\GetNewArticleJob;

class GetNewsCoinDeskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command get news';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        GetNewArticleJob::dispatch();
    }
}
