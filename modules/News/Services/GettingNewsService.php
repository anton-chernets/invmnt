<?php

namespace Modules\News\Services;

use App\Services\ParseBaseService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Modules\Article\ArticleDTO;
use Modules\Article\Models\Article;
use Modules\ChatGPT\Services\ChatGPTService;
use Modules\Translate\Service\TranslateService;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class GettingNewsService extends ParseBaseService
{
    private const FINANCE = 'finance';
    private const CRYPTO = 'crypto';
    private const ECONOMIC = 'economic';
    private const INVESTMENT = 'investment';
    private const DOLLAR = 'dollar';
    private const BITCOIN = 'bitcoin';

    private const CATEGORIES = [
        self::FINANCE,
        self::CRYPTO,
        self::ECONOMIC,
        self::INVESTMENT,
        self::DOLLAR,
        self::BITCOIN,
    ];

    protected string $url;
    protected TranslateService $translateService;
    protected ChatGPTService $chatGPTService;

    public function __construct() {
        $this->url = env('WORLD_NEWS_API_DOMAIN') . '/search-news?api-key='
            . env('WORLD_NEWS_API_API_KEY') . '&text=' . $this->getCategory();
        $this->translateService = new TranslateService();
        $this->chatGPTService = new ChatGPTService();
    }

    /**
     * @throws GuzzleException
     * @throws FileCannotBeAdded
     */
    public function getNews(): void
    {
        $rawResponse = Http::get($this->url)->body();
        $response = json_decode($rawResponse);
        $news = $response->news;
        /** @var Article $article */
        /** @var ArticleDTO $articleDTO */
        foreach ($news as $new) {
            try {
                $articleDTO = new ArticleDTO(
                    $new->title,
                    $new->text,
                    $new->author,
                    $new->publish_date,
                    null,
                    $new->image,
                );

                $article = new Article();
                $article->alias = $articleDTO->title;
                $article->author = $articleDTO->author;
                $article->publish_date = $articleDTO->publish_date;
                $article->deleted_at = $articleDTO->deleted_at;

                continue;
            } catch (\Exception) {
                //next new
            }
        }

        $article->title = $this->chatGPTService->rewrite(
            $this->translateService->translate($articleDTO->title)
        );
        $article->description = $this->chatGPTService->rewrite(
            $this->translateService->translate($articleDTO->description)
        );
        $article->addMediaFromUrl($articleDTO->image)->toMediaCollection('images');
        $article->save();
    }

    private function getCategory(): string
    {
        return self::CATEGORIES[array_rand(self::CATEGORIES)];
    }
}
