<?php

namespace App\Domains\Transaction\Enums;

enum TransactionTypeEnum : string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';
}
