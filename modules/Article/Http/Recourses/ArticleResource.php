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
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'images' => ['https://www.coindesk.com/resizer/c7Jzk14I7BKWigGGcVAOqgmWf90=/1248x654/filters:quality(80):format(webp)/cloudfront-us-east-1.images.arcpublishing.com/coindesk/FCFNUOOTIZAZDHLXU7Z2TDHRAI.png']//$this->resource->getMedia('*')
        ];
    }
}
