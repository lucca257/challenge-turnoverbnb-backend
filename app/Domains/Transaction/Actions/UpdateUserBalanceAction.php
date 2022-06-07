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
    public function execute(string $user_id, float $amount, string $type) : mixed
    {
        return DB::transaction(function () use ($user_id,$amount, $type) {
            $user_balance = UserBalance::where('user_id', $user_id)->first();
            if($type === "expense"){
                if($user_balance->current_balance <= $amount) {
                    throw new HttpResponseException(response()->json(["message" => "User dont have balance enough for it"], 422));
                }
                $user_balance->decrement('current_balance', $amount);
                $user_balance->increment('total_expenses', $amount);
            }

            if($type === "income"){
                $user_balance->increment('current_balance', $amount);
                $user_balance->increment('total_incomes', $amount);
                //dd($amount, $user_balance->toArray());
            }
            return $user_balance;
        });
    }
}
