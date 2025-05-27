<?php

namespace App\Services\Telegram;

use AllowDynamicProperties;
use App\DTO\Telegram\TelegramIncomeMessageDTO;
use App\Services\ThirdParty\Notification\Telegram\SendInfoService;

#[AllowDynamicProperties] class BaseService
{
    public function __construct(TelegramIncomeMessageDTO $dto, string $botToken)
    {
        $this->dto = $dto;
        $this->botToken = $botToken;
        $this->sendInfoService = app(SendInfoService::class);
    }

    public function getDto(): TelegramIncomeMessageDTO
    {
        return $this->dto;
    }

    public function getBotToken(): string
    {
        return $this->botToken;
    }
}
