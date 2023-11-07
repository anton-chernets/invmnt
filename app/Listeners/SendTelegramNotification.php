<?php

namespace App\Listeners;

use App\Events\BanknoteCreated;
use App\Events\BanknoteUpdated;
use App\Events\CoinCreated;
use App\Events\CoinUpdated;
use App\Repositories\UserRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected Client $httpClient,
        protected UserRepository $userRepository,
    ) {
    }

    /**
     * Handle the event.
     * @throws \Exception
     * @throws GuzzleException
     */
    public function handle($event): void
    {
        if ($event instanceof CoinCreated) {
            $message = "Added new coin: '$event->coinName' \n $event->coinPageUrl";
        } elseif ($event instanceof BanknoteCreated) {
            $message = "Added new banknote: '$event->banknoteName' \n $event->banknotePageUrl";
        } elseif ($event instanceof CoinUpdated) {
            $message = "Coin '$event->coinName' count $event->oldCount changed to $event->newCount \n $event->coinPageUrl";
        } elseif ($event instanceof BanknoteUpdated) {
            $message = "Banknote '$event->banknoteName' count $event->oldCount changed to $event->newCount \n $event->banknotePageUrl";
        } else {
            throw new \Exception('unknown event type');
        }

        $telegramBotToken = config('telegram.bot_token');
        $userId = config('telegram.chat_admin_id');

        $userTelegramIds = $this->userRepository->getUserTelegramIds();
        foreach (array_merge($userTelegramIds, [$userId]) as $userTelegramId) {
            $bodyRequest = [
                'form_params' => [
                    'chat_id' => $userTelegramId,
                    'text' => $message,
                ],
            ];

            try {
                $this->httpClient->post(
                    "https://api.telegram.org/bot$telegramBotToken/sendMessage",
                    $bodyRequest
                );
            } catch (\Exception $e) {
                logs()->error($e->getMessage(), $bodyRequest);
            }
        }
    }
}
