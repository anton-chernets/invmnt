<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Article\Models\Article;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory()->create();
    }
}