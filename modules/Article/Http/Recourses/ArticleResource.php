<?php

namespace Modules\Article\Http\Recourses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\Article;

class ArticleResource extends JsonResource
{
    /** @var Article $resource */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'alias' => $this->resource->alias,
            'author' => $this->resource->author,
            'publish_date' => $this->resource->publish_date,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'images' => $this->resource->getMedia('*')->pluck('original_url'),
        ];
    }
}
