<?php

namespace App\Domains\Purchases\DTOs;

class PurchaseDTO
{
    public function __construct(
        public int $user_id,
        public float $amount,
        public string $description,
        public string $purchase_at
    ) {}
}
