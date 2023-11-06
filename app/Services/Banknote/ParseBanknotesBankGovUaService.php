<?php

namespace App\Services\Banknote;

use App\Enums\CurrencySlugEnum;
use App\Models\Banknote;
use App\Models\Currency;
use App\Services\ParseBaseService;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParseBanknotesBankGovUaService extends ParseBaseService
{
    private string $banknotePageUrl = 'https://coins.bank.gov.ua/banknoti/c-440.html';

    public function parseBanknotesData($startPage = 1): void
    {
        $lastPage = $this->getLastPageNumber($this->banknotePageUrl);

        if ($lastPage === null) {
            return; // If the last page cannot be determined, stop parsing.
        }

        for ($page = $startPage; $page <= $lastPage; $page++) {
            $pageUrl = "{$this->banknotePageUrl}?page={$page}";
            $html = file_get_contents($pageUrl);
            $this->processBanknoteData($html);
        }
    }

    private function processBanknoteData($html): void
    {
        $dom = HtmlDomParser::str_get_html($html);

        foreach ($dom->find('a.model_product') as $banknoteLink) {
            $banknoteName = trim(html_entity_decode($banknoteLink->plaintext, ENT_QUOTES, 'UTF-8'));
            $banknoteName = str_replace('"', '', $banknoteName);

            $banknoteSlug = Str::slug($banknoteName, '_');

            $existingBanknote = Banknote::where('name', $banknoteName)->first();//TODO move to repository

            $baseURL = 'https://coins.bank.gov.ua';
            $banknotePageURL = $baseURL . $banknoteLink->href;
            $banknoteCount = $this->getCountElementFromPage($banknotePageURL);

            if ($existingBanknote) {
                $this->updateBanknoteRecord($existingBanknote, $banknoteCount);
                Cache::put("banknote_page_url_{$banknoteName}", $banknotePageURL, now()->addHours(1));
            } else {
                $this->createBanknoteRecord($banknoteName, $banknoteSlug, $banknoteCount);
                Cache::put("banknote_page_url_{$banknoteName}", $banknotePageURL, now()->addHours(1));
            }
        }

        $dom->clear();
        unset($dom);
    }

    private function createBanknoteRecord($banknoteName, $banknoteSlug, $banknoteCount): void
    {
        DB::transaction(function () use ($banknoteName, $banknoteSlug, $banknoteCount) {
            Banknote::query()->create([
                'currency_id' => Currency::firstWhere('slug', CurrencySlugEnum::UAH)->id,//TODO move to repository
                'name' => $banknoteName,
                'slug' => $banknoteSlug,
                'count' => $banknoteCount,
            ]);
        });
    }

    private function updateBanknoteRecord($existingBanknote, $banknoteCount): void//TODO move to repository
    {
        $existingBanknote->update(['count' => $banknoteCount]);
    }
}
