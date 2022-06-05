<?php

namespace App\Domains\Deposits\Enums;

enum DepositStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case REJECTED = 'rejected';
}
