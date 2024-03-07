<?php

namespace Modules\News\Services;

use App\Helpers\StringHelper;
use App\Services\ParseBaseService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Modules\Article\ArticleDTO;
use Modules\Article\Models\Article;
use Modules\ChatGPT\Services\ChatGPTService;
use Modules\Translate\Service\TranslateService;

class GettingNewsService extends ParseBaseService
{
    private const CATEGORIES = [
        'finance',
        'crypto',
        'economic',
        'investment',
        'dollar',
        'bitcoin',
    ];

    private string $url;
    private TranslateService $translateService;
    private ChatGPTService $chatGPTService;

    public function __construct() {

        $this->translateService = new TranslateService();
        $this->chatGPTService = new ChatGPTService();
    }

    /**
     * @throws GuzzleException
     */
    public function getNews(string $category): void
    {
        $this->url = env('WORLD_NEWS_API_DOMAIN') . '/search-news?api-key='
            . env('WORLD_NEWS_API_API_KEY') . '&text=' . $category;
        $rawResponse = Http::get($this->url)->body();
        $response = json_decode($rawResponse);
        $news = $response->news;
        /** @var Article $article */
        /** @var ArticleDTO $articleDTO */
        foreach ($news as $new) {
            try {
                $alias = StringHelper::toSnakeRemoveSpecSim($new->title);
                if (Article::whereAlias($alias)->exists()) {
                    continue;
                }

                $articleDTO = new ArticleDTO(
                    $new->title,
                    $new->text,
                    $new->author,
                    $new->publish_date,
                    null,
                    $new->image,
                );

                $article = new Article();
                $article->alias = $alias;
                $article->author = $articleDTO->author;
                $article->publish_date = $articleDTO->publish_date;
                $article->deleted_at = $articleDTO->deleted_at;

                $article->title = $this->chatGPTService->rewrite(
                    $this->translateService->translate($articleDTO->title)
                );
                $article->description = $this->chatGPTService->rewrite(
                    $this->translateService->translate($articleDTO->description)
                );
                if (stripos($article->description, 'казино')) {
                    throw new \Exception('стоп слово');
                }
                $article->addMediaFromUrl($articleDTO->image)->toMediaCollection('images');
                $article->save();
            } catch (\Exception $exception) {
                logs()->error($exception->getMessage());
            }
        }
    }

    public static function categories(): array
    {
        return self::CATEGORIES;
    }
}
