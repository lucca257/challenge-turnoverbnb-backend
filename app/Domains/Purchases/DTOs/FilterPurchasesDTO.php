<?php

namespace App\Domains\Purchases\DTOs;

class FilterPurchasesDTO
{
    public function __construct(
        public int $year,
        public int $month,
    ) {}
}
