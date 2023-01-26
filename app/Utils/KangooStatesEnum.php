<?php

namespace App\Utils;

enum KangooStatesEnum: string
{
    case Available = 'Available';
    case Assigned = 'Assigned';
    case InMaintenance = 'InMaintenance';
    case Damaged = 'Damaged';
    case Erased = 'Erased';
}