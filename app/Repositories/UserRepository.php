<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUserTelegramIds()
    {
       return User::whereNotNull('telegram_id')->pluck('telegram_id')->toArray();
    }
}
