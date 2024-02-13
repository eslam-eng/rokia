<?php

namespace App\Enums;
enum UsersType: int
{
    case SUPERADMIN = 1;
    case THERAPIST = 2;
    case CLIENT = 3;

    case EMPLOYEE = 4;
}
