<?php

namespace App\Enums;

use App\Enums\Helpers\BackedEnumToArray;

enum PermissionsEnum: string
{
    use BackedEnumToArray;

    case HORIZON_DASHBOARD = 'horizon';
}
