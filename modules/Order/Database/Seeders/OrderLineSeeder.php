<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Order\Models\OrderLine;

class OrderLineSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        OrderLine::factory()->create();
    }
}
