<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Article\Jobs\ExtractNewsJob;

class ExtractNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extract:news {urls*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command extract news';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach ($this->argument('urls') as $url) {
            ExtractNewsJob::dispatch($url);
        }
    }
}
