<?php

namespace App\Services\Telegram;

use App\Repositories\UserRepository;

readonly class TelegramBotTokenResolverService
{
    public function __construct(public UserRepository $userRepository) {}

    public function token(): string
    {
        return config('telegram.numerology_official_bot_token');
    }
}

