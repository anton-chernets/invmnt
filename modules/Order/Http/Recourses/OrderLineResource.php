<?php

namespace Modules\Order\Http\Recourses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Models\OrderLine;

class OrderLineResource extends JsonResource
{
    /** @var OrderLine $resource */
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
            'price' => $this->resource->price,
            'quantity' => $this->resource->quantity,
            'product_info' => ProductResource::make($this->resource->product)
        ];
    }
}
