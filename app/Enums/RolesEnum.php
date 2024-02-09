<?php

namespace App\Enums;

use App\Enums\Helpers\BackedEnumToArray;

enum RolesEnum: string
{
    use BackedEnumToArray;

    case ADMIN = 'Admin';
    case CUSTOMER = 'customer';
}
