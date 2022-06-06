<?php

namespace App\Domains\Transaction\DTOs;


class FilterTransactionDTO
{
    public function __construct(
        public int $year,
        public int $month,
    ) {}
}
