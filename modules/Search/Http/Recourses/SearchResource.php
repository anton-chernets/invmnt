<?php

namespace Modules\Search\Http\Recourses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\Article;
use Modules\Product\Models\Product;

class SearchResource extends JsonResource
{
    /** @var Product|Article $resource */
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
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'images' =>  $this->resource->getMedia('*')->pluck('original_url'),
            'details_uri' => lcfirst(class_basename($this->resource)) . 's/show/' . $this->resource->id,
        ];
    }
}
