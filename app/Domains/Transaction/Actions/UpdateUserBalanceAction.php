<?php

namespace App\Domains\Transaction\Actions;

use App\Domains\Transaction\Models\UserBalance;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            if($type === "expense"){
                if(Auth::user()->balance->current_balance <= $amount) {
                    throw new HttpResponseException(response()->json(["message" => "User dont have balance enough for it"], 422));
                }
                Auth::user()->balance()->decrement('current_balance', $amount);
                Auth::user()->balance()->increment('total_expenses', $amount);
            }

            if($type === "income"){
                Auth::user()->balance()->increment('current_balance', $amount);
                Auth::user()->balance()->increment('total_incomes', $amount);
            }
            return Auth::user()->balance;
        });

    }
}
