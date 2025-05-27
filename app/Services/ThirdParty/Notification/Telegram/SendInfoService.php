<?php

namespace App\Services\ThirdParty\Notification\Telegram;

use App\Services\ThirdParty\BaseService;
use GuzzleHttp\Exception\GuzzleException;

class SendInfoService extends BaseService
{
    public function send($userTelegramId, $message, $telegramBotToken): void
    {
        $bodyRequest = [
            'form_params' => [
                'chat_id' => $userTelegramId,
                'text' => $message,
            ],
        ];

        try {
            $this->httpClient->post(
                "https://api.telegram.org/bot$telegramBotToken/sendMessage",
                $bodyRequest
            );
        } catch (\Exception|GuzzleException $e) {
            logs()->error($e->getMessage(), $bodyRequest);
        }
    }
}
