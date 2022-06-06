<?php

namespace App\Domains\Purchases\Actions;

use App\Domains\Purchases\DTOs\PurchaseDTO;
use App\Domains\Purchases\Models\Purchase;
use App\Domains\Transaction\Enums\TransactionTypeEnum;
use App\Domains\Transaction\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CreatePurchaseAction
{
    public function execute(PurchaseDTO $purchaseDTO): Purchase
    {
        return DB::transaction(function () use ($purchaseDTO) {
            Transaction::create([
                'user_id' => $purchaseDTO->user_id,
                'amount' => $purchaseDTO->amount,
                'description' => $purchaseDTO->description,
                'type' => TransactionTypeEnum::EXPENSE->value
            ]);
            return Purchase::create(get_object_vars($purchaseDTO));
        });
    }
}
