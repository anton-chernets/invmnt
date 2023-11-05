<?php

namespace App\Listeners;

use App\Events\BanknoteCreated;
use App\Events\BanknoteUpdated;
use App\Events\CoinCreated;
use App\Events\CoinUpdated;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
     * @throws \Exception
     * @throws GuzzleException
     */
    public function handle($event): void
    {
        if ($event instanceof CoinCreated) {
            $message = "Added new coin: $event->coinName";
        } elseif ($event instanceof BanknoteCreated) {
            $message = "Added new banknote: $event->banknoteName";
        } elseif ($event instanceof CoinUpdated) {
            $message = "Coin $event->coinName count $event->oldCount changed to $event->newCount";
        } elseif ($event instanceof BanknoteUpdated) {
            $message = "Banknote $event->banknoteName count $event->oldCount changed to $event->newCount";
        } else {
            throw new \Exception('unknown event type');
        }

        $telegramBotToken = config('telegram.bot_token');
        $userId = config('telegram.chat_id');

        $this->httpClient->post("https://api.telegram.org/bot$telegramBotToken/sendMessage", [
            'form_params' => [
                'chat_id' => $userId,
                'text' => $message,
            ],
        ]);
    }
}
