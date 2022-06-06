<?php

namespace App\Domains\Transaction\DTOs;

class TransactionDTO
{
    public function __construct(
        public int $user_id,
        public float $amount,
        public string $description,
        public TransactionTy $type,
    ) {}
}
