<?php

namespace App\Services\Coin;

use App\Enums\CurrencySlugEnum;
use App\Events\CoinCreated;
use App\Models\Coin;
use App\Models\Currency;
use App\Services\ParseBaseService;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class ParseCoinsBankGovUaService extends ParseBaseService
{
    private string $coinPageUrl = "https://coins.bank.gov.ua/pam-atni-moneti/c-422.html";

    public function parseCoinsData($startPage = 1): void
    {
        $lastPage = $this->getLastPageNumber();

        if ($lastPage === null) {
            return; // // If the last page cannot be determined, stop parsing.
        }

        for ($page = $startPage; $page <= $lastPage; $page++) {
            $pageUrl = "{$this->coinPageUrl}?page={$page}";
            $html = file_get_contents($pageUrl);
            $this->processCoinData($html);
        }
    }

    private function getLastPageNumber(): ?int
    {
        $html = file_get_contents($this->coinPageUrl);
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

        return null;
    }

    private function processCoinData($html): void
    {
        $dom = HtmlDomParser::str_get_html($html);

        foreach ($dom->find('a.model_product') as $coinLink) {
            $coinName = trim(html_entity_decode($coinLink->plaintext, ENT_QUOTES, 'UTF-8'));
            $coinName = str_replace('"', '', $coinName);

            $coinSlug = Str::slug($coinName, '_');

            $existingCoin = Coin::where('name', $coinName)->first();

            if (!$existingCoin) {
                $this->createCoinRecord($coinName, $coinSlug);
            }
        }

        $dom->clear();
        unset($dom);
    }

    private function createCoinRecord($coinName, $coinSlug): void
    {
        DB::transaction(function () use ($coinName, $coinSlug) {
            Coin::query()->create([
                'currency_id' => Currency::firstWhere('slug', CurrencySlugEnum::UAH)->id,
                'name' => $coinName,
                'slug' => $coinSlug,
                'count' => null,
            ]);
        });

        Event::dispatch(new CoinCreated($coinName));
    }
}
