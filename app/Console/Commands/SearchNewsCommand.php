<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Article\Jobs\SearchNewsJob;
use Modules\News\Services\SearchNewsService;

class SearchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command search news';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach (SearchNewsService::categories() as $category) {
            SearchNewsJob::dispatch($category);
        }
    }
}
