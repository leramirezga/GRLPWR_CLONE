<?php

namespace App\Utils;

enum KangooResistancesEnum: int
{
    case LIGHT = 1;
    case LIGHT_HARD = 2;
    case HARD_HARD = 3;
    case ULTRA_HARD = 4;

    public static function getMaxResistance() {
        return max(array_column(self::cases(), 'value'));
    }
}