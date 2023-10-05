<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum GenderTypeEnum: string
{
    use Options, Values, InvokableCases;

    case MALE = 'male';
    case FEMALE = 'female';
}
