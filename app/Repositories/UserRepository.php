<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUserTelegramIds()
    {
       return User::whereNotNull('telegram_id')->pluck('telegram_id')->toArray();
    }

    public function getUserByTelegramId($telegramId)
    {
        return User::where('telegram_id', $telegramId)->first();
    }
}
