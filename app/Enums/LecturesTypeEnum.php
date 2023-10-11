<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum LecturesTypeEnum: int
{
    use Options, Values, InvokableCases;

    case RECORDED = 1;
    case LIVE = 2;

}
