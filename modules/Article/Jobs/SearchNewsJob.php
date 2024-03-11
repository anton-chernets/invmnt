<?php

namespace Modules\Article\Jobs;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\News\Services\SearchNewsService;

class SearchNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $category) {
        $this->queue = 'news';
    }

    /**
     * Execute the job.
     * @throws Exception|GuzzleException
     */
    public function handle(SearchNewsService $searchNewsService): void
    {
        $searchNewsService->getNews($this->category);
    }
}
