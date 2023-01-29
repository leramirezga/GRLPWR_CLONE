<?php

namespace App\Utils;

enum KangooStatesEnum: string
{
    case Available = 'Available';
    case InMaintenance = 'InMaintenance';
    case Damaged = 'Damaged';
    case Erased = 'Erased';
}