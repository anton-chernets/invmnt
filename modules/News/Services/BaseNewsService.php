<?php

namespace Modules\News\Services;

use App\Services\BaseService;
use Modules\ChatGPT\Services\ChatGPTService;
use Modules\Translate\Service\TranslateService;

class BaseNewsService extends BaseService
{
    const NAME_LOG = 'news';

    protected string $link;
    protected TranslateService $translateService;
    protected ChatGPTService $chatGPTService;

    public function __construct() {

        $this->translateService = new TranslateService();
        $this->chatGPTService = new ChatGPTService();
        $this->setLogger(logs(self::NAME_LOG));
    }
}
