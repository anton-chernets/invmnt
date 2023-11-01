<?php

namespace Database\Seeders;

use App\Enums\CurrencyTypeEnum;
use App\Helpers\CurrencyHelper;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Currency::firstOrCreate([
            'id' => 1,
        ], [
            'slug' => CurrencyHelper::MAIN_CURRENCY_SLUG,
            'type' => CurrencyTypeEnum::FIAT,
        ]);
    }
}
