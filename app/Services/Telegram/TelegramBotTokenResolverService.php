<?php

namespace App\Services\Telegram;

use App\Repositories\UserRepository;

readonly class TelegramBotTokenResolverService
{
    public function __construct(public UserRepository $userRepository) {}

    public function resolve(int $telegramUserId): string
    {
        return $this->userRepository->getUserByTelegramId($telegramUserId)
            ? config('telegram.numerologsbot_token')
            : config('telegram.numerology_official_bot_token');
    }
}

