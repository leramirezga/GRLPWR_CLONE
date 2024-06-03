<?php

namespace App\Utils;

enum FeaturesEnum: string
{
    case SEE_PETTY_CASH  = 'SEE_PETTY_CASH';
    case SAVE_PETTY_CASH  = 'SAVE_PETTY_CASH';
    case SEE_MAYOR_CASH  = 'SEE_MAYOR_CASH';
    case SEE_USERS = 'SEE_USERS';
    case SEE_ACHIEVEMENTS_WEEKS_RANK = 'SEE_ACHIEVEMENTS_WEEKS_RANK';
    case SEE_ACCOUNTING_FLOW = 'SEE_ACCOUNTING_FLOW';
    case SEE_USERS_GENERAL_INFO = 'SEE_USERS_GENERAL_INFO';
}