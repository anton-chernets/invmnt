<?php

namespace App\DTO\Telegram;

class TelegramIncomeMessageDTO
{
    public int $chatId;
    public int $userId;
    public string $username;
    public string $text;

    public function __construct(array $data)
    {
        $message = $data['message'];

        $this->chatId = $message['chat']['id'];
        $this->userId = $message['from']['id'];
        $this->username = $message['from']['username'] ?? '';
        $this->text = $message['text'] ?? '';
    }
}
