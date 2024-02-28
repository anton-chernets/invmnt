<?php

namespace Modules\Article;

readonly class ArticleDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public ?string $author,
        public ?string $publish_date,
        public string $deleted_at,
        public string $image,
    )
    {
        //
    }
}
