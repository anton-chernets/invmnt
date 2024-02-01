<?php

namespace App\Services\Banknote;

use App\Repositories\BanknoteRepository;
use App\Services\ParseBaseService;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Illuminate\Support\Str;

class ParseBanknotesBankGovUaService extends ParseBaseService
{
    private string $banknotePageUrl;
    public function __construct(
        protected BanknoteRepository $banknoteRepository,
    ) {
        $this->banknotePageUrl = env('COINS_BANK_GOV_UA_DOMAIN') . env('COINS_BANK_GOV_UA_BANKNOTES_PAGE');
    }

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

            $existingBanknote = $this->banknoteRepository->getByName($banknoteName);

            $baseUrl = env('COINS_BANK_GOV_UA_DOMAIN');
            $banknotePageUrl = $baseUrl . $banknoteLink->href;
            $banknoteCount = $this->getCountElementFromPage($banknotePageUrl);

            if ($existingBanknote) {
                $this->banknoteRepository->update($existingBanknote, $banknoteCount);
            } else {
                $this->banknoteRepository->create($banknoteName, $banknoteSlug, $banknoteCount, $banknotePageUrl);
            }
        }

        $dom->clear();
        unset($dom);
    }
}
