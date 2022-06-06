<?php

namespace Database\Factories;

use App\Domains\Transaction\Models\UserBalance;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class UserBalanceFactory extends Factory
{
    protected $model = UserBalance::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => $this->faker->randomElement(User::all()),
            "current_balance" => 99999,
            "total_incomes" => 99999,
            "total_expenses" => 99999,
        ];
    }

    public function noBalance(){
        return $this->state(function (array $attributes) {
            return [
                'current_balance' => 0,
                "total_incomes" => 0,
                "total_expenses" => 0,
            ];
        });
    }
}
