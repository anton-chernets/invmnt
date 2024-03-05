<?php

namespace Modules\ChatGPT\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

class ChatGPTService
{
    const ACTION = 'chat/completions';

    const CHAT_GPT_LOG = 'chat_gpt';

    protected Client $client;
    private ?LoggerInterface $logger = null;

    public function __construct() {
        $this->client = $this->clientRequest();
        $logger = logs(self::CHAT_GPT_LOG);
        $this->setLogger($logger);
    }

    /**
     * @throws GuzzleException
     */
    public function translate(string $item): string
    {
        try {
            $response = $this->client->post(self::ACTION, $this->bodyRequest('Переведи на украінську:', $item));
            return $this->contentResponse($response);
        } catch (RequestException $e) {
            $this->log('translate ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * @throws GuzzleException
     */
    public function rewrite(string $item): string
    {
        try {
            $response = $this->client->post(self::ACTION, $this->bodyRequest('Зроби рерайт:', $item));
            return $this->contentResponse($response);
        } catch (RequestException $e) {
            logs()->error('rewrite ' . $e->getMessage());
            throw $e;
        }
    }

    private function clientRequest(): Client
    {
        return new Client([
            'base_uri' => env('CHAT_GPT_API_DOMAIN'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('CHAT_GPT_API_KEY'),
            ],
        ]);
    }

    private function bodyRequest(string $action, string $item): array
    {
        return [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $action . $item,
                    ],
                ],
            ],
        ];
    }

    private function contentResponse($response): string
    {
        $response_data = json_decode($response->getBody()->getContents(), TRUE);
        return $response_data['choices'][0]['message']['content'];
    }

    /**
     * @param LoggerInterface $logger
     * @return void
     */
    private function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param string $message
     * @return void
     */
    private function log(string $message): void
    {
        $this->logger?->info($message);
    }
}
