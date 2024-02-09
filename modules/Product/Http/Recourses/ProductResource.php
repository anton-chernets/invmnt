<?php

namespace Modules\Product\Http\Recourses;

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
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'price' => $this->resource->price,
            'stock' => $this->resource->stock,
            'images' =>  $this->resource->getMedia('*')
                ->pluck('original_url'),
        ];
    }
}
