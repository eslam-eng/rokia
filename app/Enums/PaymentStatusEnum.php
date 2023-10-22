<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum PaymentStatusEnum: int
{
    use Options, Values,InvokableCases;
    case FREE = 0;
    case PAID = 1;
}
