<?php

namespace Modules\ChatGPT\Services;

use App\Services\BaseService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class ChatGPTService extends BaseService
{
    const ACTION = 'chat/completions';

    const CHAT_GPT_LOG = 'chat_gpt';

    protected Client $client;

    public function __construct() {
        $this->client = $this->clientRequest();
        $this->setLogger(
            logs(self::CHAT_GPT_LOG)
        );
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
            $response = $this->client->post(self::ACTION, $this->bodyRequest('Зроби рерайт не зменшуючи обьем тексту:', $item));
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
}
