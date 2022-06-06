<?php

namespace App\Domains\Transactions\Actions;

use App\Domains\Transaction\DTOs\TransactionDTO;
use App\Domains\Transaction\Models\UserBalance;
use Illuminate\Support\Facades\Auth;

class UpdateUserBalanceAction
{
    public function execute(TransactionDTO $transactionDTO) : UserBalance
    {
        return Auth::user()->userBalance()
            ->when($transactionDTO->type == "purchase", function ($userBalance, $transactionDTO) {
                $userBalance->decrement('current_balance', $transactionDTO->amount);
                $userBalance->increment('total_expenses', $transactionDTO->amount);
            })
            ->when($transactionDTO->type == "deposit", function ($userBalance, $transactionDTO) {
                $userBalance->increment('current_balance', $transactionDTO->amount);
                $userBalance->increment('total_incomes', $transactionDTO->amount);
            });
    }
}
