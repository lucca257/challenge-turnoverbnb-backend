<?php

use App\Domains\Deposits\Enums\DepositStatusEnum;

class FilterDepositsDTO
{
    public function __construct(
        public int                $year,
        public int                $month,
        public ?DepositStatusEnum $status,
    ) {}
}
