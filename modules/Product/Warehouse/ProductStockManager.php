<?php

namespace Modules\Product\Warehouse;

use Modules\Product\Models\Product;

class ProductStockManager
{
    public function decrement(int $idProduct, int $amount): void
    {
        Product::query()->find($idProduct)?->decrement('stock', $amount);
    }
}
