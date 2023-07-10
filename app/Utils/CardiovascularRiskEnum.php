<?php

namespace App\Utils;

enum CardiovascularRiskEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}