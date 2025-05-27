<?php

namespace App\Jobs\Telegram\Numerology;

use App\Services\ThirdParty\Notification\Telegram\SendInfoService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\ChatGPT\Services\ChatGPTService;

class ResponseTelegramUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $telegramBotToken;
    private array $incomeData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $incomeData)
    {
        $this->onQueue('telegram');
        $this->telegramBotToken = config('telegram.numerologsbot_token');
        $this->incomeData = $incomeData;
    }

    /**
     * Execute the job.
     * @throws \Exception|GuzzleException
     */
    public function handle(SendInfoService $sendInfoService): void
    {
        switch ($this->incomeData['message']['text']) {
            case '/info':
                $message = '🔮 Нумерологія — це езотеричне вчення, яке вивчає вплив чисел на життя людини, її характер, долю, події, стосунки тощо; в основі нумерології лежить ідея, що кожне число має своє енергетичне значення і може впливати на наш світ.';

                $sendInfoService->send($this->incomeData['message']['from']['id'], $message, $this->telegramBotToken);

                break;
            default: logs()->info('Yeah ' . (new ChatGPTService())->numerology($this->incomeData['message']['text']));
//            default: logs()->info('Unknown command ' . $requestBody['message']['text']);
        }
    }
}
