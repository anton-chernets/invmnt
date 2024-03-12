<?php

namespace Modules\News\Services;

use App\Helpers\StringHelper;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Modules\Article\ArticleDTO;
use Modules\Article\Models\Article;

class ExtractNewsService extends BaseNewsService
{
    /**
     * @throws GuzzleException
     */
    public function extractNews(string $url): void
    {
        $this->link = env('WORLD_NEWS_API_DOMAIN') . '/extract-news?api-key='
            . env('WORLD_NEWS_API_API_KEY') . '&analyze=true&url=' . $url;
        $rawResponse = Http::get($this->link)->body();
        $this->log('translate ' . $rawResponse);
        $response = json_decode($rawResponse);
        /** @var Article $article */
        /** @var ArticleDTO $articleDTO */
        try {
            $alias = StringHelper::toSnakeRemoveSpecSim($response->title);
            if (Article::whereAlias($alias)->exists()) {
                exit;
            }

            $articleDTO = new ArticleDTO(
                $response->title,
                $response->text,
                $response->authors[0],
                $response->publish_date,
                null,
                $response->image,
            );

            $article = new Article();
            $article->alias = $alias;
            $article->author = $articleDTO->author;
            $article->publish_date = $articleDTO->publish_date;
            $article->deleted_at = $articleDTO->deleted_at;
            $article->addMediaFromUrl($articleDTO->image)->toMediaCollection('images');
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
