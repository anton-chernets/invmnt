<?php

namespace Modules\News\Services;

use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use GuzzleHttp\Exception\GuzzleException;

class GetNewsService extends ExtractNewsService
{
    const DOMAINS = [
        'https://www.coindesk.com/' => 'a.card-title-link',
        'https://payspacemagazine.com/' => 'h2.post-title a',
    ];

    /**
     * @throws GuzzleException
     */
    public function getNews(string $domain, string $classSelector): void
    {
        define('MAX_FILE_SIZE', 6000000);
        $html = file_get_contents($domain);
        $dom = HtmlDomParser::str_get_html($html);
        $as = $dom->find($classSelector);
        foreach ($as as $a) {
            $url = $a->href;
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $this->log($domain . ' has valid href ' . $url);
                $this->extractNews($url);
            }
        }
        $dom->clear();
        unset($dom);
    }
}
