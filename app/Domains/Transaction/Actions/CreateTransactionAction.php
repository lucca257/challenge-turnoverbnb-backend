<?php

namespace App\Domains\Transaction\Actions;

use App\Domains\Transaction\DTOs\TransactionDTO;
use App\Domains\Transaction\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CreateTransactionAction
{
    public function __construct(private UpdateUserBalanceAction $updateUserBalanceAction)
    {}

    /**
     * @param float $amount
     * @param string $type
     * @return mixed
     */
    public function execute(TransactionDTO $transactionDTO) : mixed
    {
        return DB::transaction(function () use ($transactionDTO) {
            $transaction = Transaction::create([
                'user_id' => $transactionDTO->user_id,
                'amount' => $transactionDTO->amount,
                'description' => $transactionDTO->description,
                'type' => $transactionDTO->type->value,
            ]);
            $this->updateUserBalanceAction->execute($transactionDTO->user_id, $transactionDTO->amount, $transactionDTO->type->value);
            return $transaction;
        });
    }
}
