<?php

namespace App\Domains\Deposits\DTOs;


class ReviewDepositDTO
{
    public function __construct(
        public int $reviewed_by,
        public int $deposit_id,
        public bool $accepted
    ) {}
}
