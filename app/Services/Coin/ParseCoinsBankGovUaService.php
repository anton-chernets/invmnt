<?php

namespace App\Services\Coin;

use App\Repositories\CoinRepository;
use App\Services\ParseBaseService;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Illuminate\Support\Str;

class ParseCoinsBankGovUaService extends ParseBaseService
{
    public function __construct(
        protected CoinRepository $coinRepository
    ) {
    }

    private string $coinPageUrl = 'https://coins.bank.gov.ua/pam-atni-moneti/c-422.html';

    public function parseCoinsData($startPage = 1): void
    {
        $lastPage = $this->getLastPageNumber($this->coinPageUrl);

        if ($lastPage === null) {
            return; // If the last page cannot be determined, stop parsing.
        }

        for ($page = $startPage; $page <= $lastPage; $page++) {
            $pageUrl = "{$this->coinPageUrl}?page={$page}";
            $html = file_get_contents($pageUrl);
            $this->processCoinData($html);
        }
    }

    private function processCoinData($html): void
    {
        $dom = HtmlDomParser::str_get_html($html);

        foreach ($dom->find('a.model_product') as $coinLink) {
            $coinName = trim(html_entity_decode($coinLink->plaintext, ENT_QUOTES, 'UTF-8'));
            $coinName = str_replace('"', '', $coinName);

            $coinSlug = Str::slug($coinName, '_');

            $existingCoin = $this->coinRepository->getByName($coinName);

            $baseUrl = 'https://coins.bank.gov.ua';
            $coinPageUrl = $baseUrl . $coinLink->href;
            $coinCount = $this->getCountElementFromPage($coinPageUrl);

            if ($existingCoin) {
                $this->coinRepository->update($existingCoin, $coinCount);
            } else {
                $this->coinRepository->create($coinName, $coinSlug, $coinCount, $coinPageUrl);
            }
        }

        $dom->clear();
        unset($dom);
    }
}
