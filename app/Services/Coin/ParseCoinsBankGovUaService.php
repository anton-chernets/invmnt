<?php

namespace App\Services\Coin;

use App\Models\Coin;
use App\Services\ParseBaseService;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParseCoinsBankGovUaService extends ParseBaseService
{
    public function parseCoinsData($startPage = 1, $endPage = 1): void
    {
        for ($page = $startPage; $page <= $endPage; $page++) {
            $html = file_get_contents("https://coins.bank.gov.ua/pam-atni-moneti/c-422.html?page={$page}");
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
                'currency_id' => 1,
                'name' => $coinName,
                'slug' => $coinSlug,
                'count' => null,
            ]);
        });
    }
}
