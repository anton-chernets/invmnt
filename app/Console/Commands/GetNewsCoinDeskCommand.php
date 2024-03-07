<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Article\Jobs\GetNewArticleJob;
use Modules\News\Services\GettingNewsService;

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
        foreach (GettingNewsService::categories() as $category) {
            GetNewArticleJob::dispatch($category);
        }
    }
}
