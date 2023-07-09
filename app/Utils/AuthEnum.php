<?php

namespace App\Utils;

enum AuthEnum: int
{
    case VISITOR = 0;
    case SAME_USER = 1;
}