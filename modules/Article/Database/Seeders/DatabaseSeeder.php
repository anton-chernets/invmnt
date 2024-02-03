<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ArticlesSeeder::class);
    }
}
