<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected const NAME_MAIN = 'Admin';
    protected const EMAIL_MAIN = 'admin.admin@admin.com';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::firstOrCreate([
             'email' => self::EMAIL_MAIN,
         ], [
             'name' => self::NAME_MAIN,
             'password' => Hash::make('password'),
         ]);
    }
}
