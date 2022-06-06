<?php

namespace App\Domains\Transaction\Actions;

use App\Domains\Transaction\Models\UserBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateUserBalanceAction
{
    /**
     * @param float $amount
     * @param string $type
     * @return mixed
     */
    public function execute(float $amount, string $type) : mixed
    {
        return DB::transaction(function () use ($amount, $type) {
            Auth::user()->balance()
                ->when($type === "expense", function ($user_balance) use ($amount){
                    $user_balance->decrement('current_balance', $amount);
                    $user_balance->increment('total_expenses', $amount);
                })
                ->when($type === "income", function ($user_balance) use ($amount){
                    $user_balance->increment('current_balance', $amount);
                    $user_balance->increment('total_incomes', $amount);
                }
            );
        });
    }
}
