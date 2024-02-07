<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Models\OrderLine;

class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;

    public function definition(): array
    {
        return [
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'price' => 10.1,
        ];
    }
}
