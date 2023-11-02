<?php

namespace Database\Seeders;

use App\Enums\CurrencySlugEnum;
use App\Enums\CurrencyTypeEnum;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        foreach ([CurrencySlugEnum::UAH, CurrencySlugEnum::USD] as $slug) {
            Currency::firstOrCreate([
                'slug' => $slug,
            ], [
                'type' => CurrencyTypeEnum::FIAT,
            ]);
        }
    }
}
