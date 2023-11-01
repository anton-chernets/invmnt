<?php

namespace App\Enums;

use App\Enums\Helpers\BackedEnumToArray;

enum CurrencySlugEnum: string//TODO to use
{
    use BackedEnumToArray;

    case UAH = 'UAH';
}
