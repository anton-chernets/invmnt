<?php

namespace App\Services\Telegram;

use AllowDynamicProperties;
use App\DTO\Telegram\TelegramIncomeMessageDTO;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

#[AllowDynamicProperties] class BaseService
{
    /**
     * @throws TelegramSDKException
     */
    public function __construct(TelegramIncomeMessageDTO $dto, string $botToken)
    {
        $this->dto = $dto;
        $this->telegramClient = new Api($botToken);
    }

    public function getDto(): TelegramIncomeMessageDTO
    {
        return $this->dto;
    }
}
