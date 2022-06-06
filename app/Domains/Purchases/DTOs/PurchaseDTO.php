<?php

namespace App\Domains\Purchases\DTOs;

class PurchasesDTO
{
    public function __construct(
        public int $user_id,
        public int $amount,
        public string $description,
        public string $purchase_at
    ) {}
}
