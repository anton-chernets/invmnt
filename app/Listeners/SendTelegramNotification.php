<?php

namespace App\Listeners;

use App\Events\CoinCreated;
use App\Events\CoinUpdated;
use GuzzleHttp\Client;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Client $httpClient)
    {
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        if ($event instanceof CoinCreated) {
            $coinName = $event->coinName;
            $message = "Added new coin: $coinName";
            logs()->debug('$message', ['$message' => $message]);
        } elseif ($event instanceof CoinUpdated) {
            $coinName = $event->coinName;
            $newCount = $event->newCount;
            $message = "Coin $coinName count 0 changed to $newCount";
            logs()->debug('$message', ['$message' => $message]);
        }

        $telegramBotToken = config('telegram.bot_token');
        $chatId = config('telegram.chat_id');

        $this->httpClient->post("https://api.telegram.org/bot$telegramBotToken/sendMessage", [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $message,
            ],
        ]);
    }
}
