<?php

namespace App\Utils;

enum RolsEnum: int
{
    case ADMIN  = 1;
    case CLIENT  = 2;
    case TRAINER  = 3;
    case RECEPTIONIST = 4;
    case CLIENT_FOLLOWER = 5;
}