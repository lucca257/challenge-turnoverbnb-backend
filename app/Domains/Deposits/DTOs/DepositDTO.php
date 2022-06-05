<?php

namespace App\Domains\Deposits\DTOs;

use Illuminate\Http\UploadedFile;

class DepositDTO
{
    public function __construct(
        public float $amount,
        public string $description,
        public UploadedFile $image,
        public int $user_id,
    ) {}
}
