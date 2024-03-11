<?php

namespace Modules\News\Services;

use App\Helpers\StringHelper;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Modules\Article\ArticleDTO;
use Modules\Article\Models\Article;

class SearchNewsService extends BaseService
{
    private const STOP_WORDS = [
        'gambling',
        'casino',
    ];
    private const CATEGORIES = [
        'finance',
        'crypto',
        'economic',
        'investment',
        'dollar',
        'bitcoin',
    ];

    public static function categories(): array
    {
        return self::CATEGORIES;
    }

    /**
     * @throws GuzzleException
     */
    public function getNews(string $category): void
    {
        $this->link = env('WORLD_NEWS_API_DOMAIN') . '/search-news?api-key='
            . env('WORLD_NEWS_API_API_KEY') . '&text=' . $category;
        $rawResponse = Http::get($this->link)->body();
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
                $article->addMediaFromUrl($articleDTO->image)->toMediaCollection('images');
                foreach (self::STOP_WORDS as $item) {
                    if (stripos($articleDTO->description, $item)) {
                        throw new \Exception('стоп слово');
                    }
                }
                $article->title = $this->chatGPTService->rewrite(
                    $this->translateService->translate($articleDTO->title)
                );
                $article->description = $this->chatGPTService->rewrite(
                    $this->translateService->translate($articleDTO->description)
                );
                $article->save();
            } catch (\Exception $exception) {
                logs()->error($exception->getMessage());
            }
        }
    }
}
