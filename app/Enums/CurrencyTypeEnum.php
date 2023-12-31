<?php

namespace App\Enums;

use App\Enums\Helpers\BackedEnumToArray;

enum CurrencyTypeEnum: string
{
    use BackedEnumToArray;

    case FIAT = 'fiat';
    case CRYPTO = 'crypto';
}
