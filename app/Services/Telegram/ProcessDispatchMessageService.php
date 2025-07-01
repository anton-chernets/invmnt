<?php

namespace App\Services\Telegram;

use App\DTO\Telegram\TelegramIncomeMessageDTO;
use GuzzleHttp\Exception\GuzzleException;
use Modules\ChatGPT\Services\ChatGPTService;

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
     */
    public function processing()
    {
        switch ($this->getDto()->text) {
            case '/info':
                $message = '🔮 Нумерологія — це езотеричне вчення, яке вивчає вплив чисел на життя людини, її характер, долю, події, стосунки тощо; в основі нумерології лежить ідея, що кожне число має своє енергетичне значення і може впливати на наш світ.';
                break;
            default:
                $message = (new ChatGPTService())->numerology($this->getDto()->text);
        }
        logs()->info(__METHOD__ . ' ' . $message);
        $this->sendInfoService->send($this->getDto()->userId, $message, $this->getBotToken());
    }
}
