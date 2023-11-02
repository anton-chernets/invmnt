<?php

namespace App\Listeners;

use App\Events\CoinCreated;
use GuzzleHttp\Client;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Client $httpClient)
    {}

    /**
     * Handle the event.
     */
    public function handle(CoinCreated $event): void
    {
        $coinName = $event->coinName;

        $telegramBotToken = config('telegram.bot_token');
        $chatId = config('telegram.chat_id');
        $message = "Added new coin: $coinName";

        $this->httpClient->post("https://api.telegram.org/bot$telegramBotToken/sendMessage", [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $message,
            ],
        ]);
    }
}
