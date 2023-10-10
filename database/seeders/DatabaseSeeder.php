<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    protected const NAME_MAIN = 'Anton';
    protected const EMAIL_MAIN = 'anton.fullstack@gmail.com';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::firstOrNew([
             'name' => self::NAME_MAIN,
             'email' => self::EMAIL_MAIN,
             'password' => Hash::make('password'),
         ]);
    }
}
