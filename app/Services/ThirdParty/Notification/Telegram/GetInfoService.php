<?php

namespace App\Services\ThirdParty\Notification\Telegram;

use App\DTO\Telegram\TelegramUserDTO;
use App\Models\TelegramUser;

class GetInfoService
{
    /**
     * @throws \Exception
     */
    public function subscription(array $telegramMessage): void
    {
        $userData = $telegramMessage['message']['from'] ?? null;

        if (!$userData) throw new \Exception('No user data');

        $userDTO = new TelegramUserDTO(
            $userData['id'],
            $userData['first_name'],
            $userData['username']
        );

        TelegramUser::updateOrCreate(
            [
                'telegram_id' => $userDTO->telegram_id
            ],
            [
                'name' => $userDTO->name,
                'username' => $userDTO->username,
                'subscribed' => $userDTO->subscribed,
            ]
        );
    }
}
