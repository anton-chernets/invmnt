<?php

namespace App\Jobs\Telegram\Numerology;

use App\Services\Telegram\ProcessDispatchMessageService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\DTO\Telegram\TelegramIncomeMessageDTO;

class ResponseTelegramUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $telegramBotToken;
    private TelegramIncomeMessageDTO $dto;

    public function __construct(array $incomeData)
    {
        $this->onQueue('telegram');
        $this->dto = new TelegramIncomeMessageDTO($incomeData);
    }

    /**
     * @throws GuzzleException|\Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function handle(): void
    {
        (new ProcessDispatchMessageService($this->dto))->processing();
    }
}
