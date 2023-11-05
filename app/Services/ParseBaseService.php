<?php

namespace App\Services;

use Drnxloc\LaravelHtmlDom\HtmlDomParser;

class ParseBaseService
{
    protected function getLastPageNumber($pageUrl): ?int
    {
        $html = file_get_contents($pageUrl);
        $dom = HtmlDomParser::str_get_html($html);
        $paginationElement = $dom->find('nav ul.pagination');

        if (count($paginationElement) > 0) {
            $pageLinks = $paginationElement[0]->find('li a');
            $lastPageLink = end($pageLinks);

            if ($lastPageLink !== false) {
                $lastPageHref = $lastPageLink->href;
                preg_match('/page=(\d+)$/', $lastPageHref, $matches);

                return (int)($matches[1] ?? null);
            }
        }

        return 1;
    }

    protected function getCountElementFromPage($url): ?int
    {
        $html = file_get_contents($url);
        $dom = HtmlDomParser::str_get_html($html);
        $CountElement = $dom->find('span.pd_qty', 0);

        if ($CountElement) {
            return (int)trim($CountElement->plaintext);
        }

        return null;
    }
}
