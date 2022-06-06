<?php

namespace App\Domains\Transaction\DTOs;

use App\Domains\Transaction\Enums\TransactionTypeEnum;

class TransactionDTO
{
    public function __construct(
        public int $user_id,
        public float $amount,
        public string $description,
        public TransactionTypeEnum $type,
    ) {}
}
