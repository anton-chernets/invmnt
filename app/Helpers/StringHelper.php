<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StringHelper
{
    public static function removeSpecSim(string $str): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    }

    public static function toSnakeRemoveSpecSim(string $str): string
    {
        return self::removeSpecSim(
            Str::snake($str, '-')
        );
    }
}
