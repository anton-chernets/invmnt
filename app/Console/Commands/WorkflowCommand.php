<?php

namespace App\Console\Commands;

use App\Services\Workflow\WorkflowService;
use Illuminate\Console\Command;

class WorkflowCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:workflow';

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
        WorkflowService::foo();
    }
}
