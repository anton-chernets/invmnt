<?php

namespace Modules\Translate\Service;

use GuzzleHttp\Exception\GuzzleException;
use Modules\ChatGPT\Services\ChatGPTService;

class TranslateService
{
    /**
     * @throws GuzzleException
     */
    public function translate($string): string
    {
        return (new ChatGPTService())->translate($string);
    }
}
