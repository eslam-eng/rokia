<?php

namespace App\Enums;


enum InvoiceStatus: int
{

    case PENDING = 1;
    case COMPLETED = 2;
}
