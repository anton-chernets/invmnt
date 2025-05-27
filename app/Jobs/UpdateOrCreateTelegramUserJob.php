<?php

namespace App\Jobs;

use App\Services\ThirdParty\Notification\Telegram\GetInfoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrCreateTelegramUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $incomeData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $incomeData)
    {
        $this->incomeData = $incomeData;
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(GetInfoService $getInfoService): void
    {
        $getInfoService->subscription($this->incomeData);
    }
}
