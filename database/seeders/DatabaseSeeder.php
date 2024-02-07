<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Article\Database\Seeders\DatabaseSeeder as ArticleModuleDatabaseSeeder;
use Modules\Product\Database\seeders\DatabaseSeeder as ProductModuleDatabaseSeeder;
use Modules\Order\Database\seeders\DatabaseSeeder as OrderModuleDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(CurrencySeeder::class);
//        $this->call(ArticleModuleDatabaseSeeder::class);
        $this->call(ProductModuleDatabaseSeeder::class);
//        $this->call(OrderModuleDatabaseSeeder::class);
    }
}
