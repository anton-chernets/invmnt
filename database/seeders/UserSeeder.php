<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected const NAME_MAIN = 'Admin';
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::updateOrCreate([
             'name' => self::NAME_MAIN,
         ], [
             'email' => env('EMAIL_ADMIN'),
             'password' => Hash::make(env('PASSWORD_ADMIN')),
             'telegram_id' => config('telegram.chat_admin_id'),
         ]);
    }
}
