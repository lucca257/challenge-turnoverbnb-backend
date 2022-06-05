<?php

namespace App\Domains\Transaction\DTOs;

use App\Domains\Deposits\Enums\DepositStatusEnum;

class FilterTransactionDTO
{
    public function __construct(
        public int $year,
        public int $month,
        public ?DepositStatusEnum $status = null,
    ) {}
}
