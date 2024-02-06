<?php

namespace Modules\Product;

use Modules\Product\Models\Product;

readonly class ProductDTO
{
    public function __construct(
        public int $id,
        public float $price,
        public int $unitsInStock,
    )
    {

    }

    public static function fromEloquentModel(Product $product): ProductDTO
    {
        return new ProductDTO(
            id: $product->id,
            price: $product->price,
            unitsInStock: $product->stock
        );
    }
}
