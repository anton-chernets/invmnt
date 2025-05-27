<?php

namespace App\Services\ThirdParty;

use GuzzleHttp\Client;

class BaseService
{
    public function __construct(protected Client $httpClient)
    {}
}
