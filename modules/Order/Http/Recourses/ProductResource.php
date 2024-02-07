<?php

namespace Modules\Order\Http\Recourses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Models\Product;

class ProductResource extends JsonResource
{
    /** @var Product $resource */
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
            'images' => $this->resource->getMedia('*')
        ];
    }
}
