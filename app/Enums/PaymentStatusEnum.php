<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case FREE = 0;
    case PAID = 1;
}
