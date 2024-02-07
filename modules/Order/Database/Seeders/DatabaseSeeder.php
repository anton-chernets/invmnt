<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OrderSeeder::class);
        $this->call(OrderLineSeeder::class);
    }
}
