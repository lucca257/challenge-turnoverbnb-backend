<?php

namespace App\Domains\Purchases\Actions;

use App\Domains\Purchases\DTOs\PurchaseDTO;
use App\Domains\Purchases\Models\Purchase;
use Illuminate\Support\Facades\DB;

class CreatePurchaseAction
{
    public function execute(PurchaseDTO $purchaseDTO): Purchase
    {
        return DB::transaction(function () use ($purchaseDTO) {
            return Purchase::create(get_object_vars($purchaseDTO));
        });
    }
}
