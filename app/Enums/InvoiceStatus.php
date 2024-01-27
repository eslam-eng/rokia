<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum InvoiceStatus: int
{
    use Options, Values, InvokableCases;

    case PENDING = 1;
    case COMPLETED = 2;
}
