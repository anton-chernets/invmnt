<?php

namespace App\Helpers;

class StringHelper
{
    public static function removeSpecSim(string $str): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    }
}
