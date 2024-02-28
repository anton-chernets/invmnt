<?php

namespace Modules\Article\Jobs;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\News\Services\GettingNewsService;

class GetNewArticleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {
        $this->queue = 'news';
    }

    /**
     * Execute the job.
     * @throws Exception|GuzzleException
     */
    public function handle(GettingNewsService $gettingNewsService): void
    {
        $gettingNewsService->getNews();
    }
}
