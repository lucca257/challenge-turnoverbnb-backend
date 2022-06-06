<?php

namespace App\Domains\Transaction\Enums;

enum DepositStatusEnum: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';
}
