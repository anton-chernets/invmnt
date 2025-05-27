<?php

namespace App\DTO\Telegram;

class TelegramUserDTO
{
    public function __construct(
        public int $telegram_id,
        public string $name,
        public string $username,
        public bool $subscribed = true
    ) {}
}
