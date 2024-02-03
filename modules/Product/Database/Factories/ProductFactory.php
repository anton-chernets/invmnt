<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'price' => 10.1,
            'description' => fake()->text(),
            'category' => fake()->name(),
        ];
    }
}
