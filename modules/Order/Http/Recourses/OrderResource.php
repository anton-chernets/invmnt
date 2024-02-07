<?php

namespace Modules\Order\Http\Recourses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Models\Order;

class OrderResource extends JsonResource
{
    /** @var Order $resource */
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
            'total_price' => $this->resource->id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'line_items' => OrderLineResource::collection($this->resource->lines),
        ];
    }
}
