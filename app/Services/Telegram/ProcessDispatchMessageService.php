<?php

namespace App\Services\Telegram;

use App\DTO\Telegram\TelegramIncomeMessageDTO;
use App\Enums\TelegramBotActionsEnum;
use GuzzleHttp\Exception\GuzzleException;
use Modules\ChatGPT\Services\ChatGPTService;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ProcessDispatchMessageService extends BaseService
{
    public function __construct(TelegramIncomeMessageDTO $dto)
    {
        parent::__construct(
            $dto,
            app(TelegramBotTokenResolverService::class)->token()
        );
    }

    /**
     * @throws GuzzleException
     * @throws TelegramSDKException
     */
    public function processing(): void
    {
        $this->telegramClient->sendChatAction([
            'chat_id' => $this->getDto()->userId,
            'action' => TelegramBotActionsEnum::Typing->value,
        ]);

        $message = match ($this->getDto()->text) {
            '/info' => '🔮 Нумерологія — це езотеричне вчення, яке вивчає вплив чисел на життя людини, її характер, долю, події, стосунки тощо; в основі нумерології лежить ідея, що кожне число має своє енергетичне значення і може впливати на наш світ.',
            default => (new ChatGPTService())->numerology($this->getDto()->text),
        };
        sleep(3);

        $this->telegramClient->sendMessage([
            'chat_id' => $this->getDto()->userId,
            'text' => $message,
        ]);
    }
}
