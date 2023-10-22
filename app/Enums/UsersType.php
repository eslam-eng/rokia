<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum UsersType: int
{
    use Options, Values, InvokableCases;

    case SUPERADMIN = 1;

    case THERAPIST = 2;
    case CLIENT = 3;

    case EMPLOYEE = 4;
}
