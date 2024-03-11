<?php

namespace Modules\News\Services;

use Modules\ChatGPT\Services\ChatGPTService;
use Modules\Translate\Service\TranslateService;

class BaseService
{
    protected string $link;
    protected TranslateService $translateService;
    protected ChatGPTService $chatGPTService;

    public function __construct() {

        $this->translateService = new TranslateService();
        $this->chatGPTService = new ChatGPTService();
    }
}
