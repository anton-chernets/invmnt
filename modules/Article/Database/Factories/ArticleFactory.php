<?php

namespace Modules\Article\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Article\Models\Article;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(),
        ];
    }
}
