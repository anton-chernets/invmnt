<?php

namespace App\Enums;

use App\Enums\Helpers\BackedEnumToArray;

enum CurrencySlugEnum: string
{
    use BackedEnumToArray;

    case UAH = 'UAH';
    case USD = 'USD';
}
