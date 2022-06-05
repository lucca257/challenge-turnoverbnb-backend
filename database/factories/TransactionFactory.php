<?php

namespace Database\Factories;

use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;


class TransactionFactory extends Factory
{
    protected $model = Transaction::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ["income", "expense"];
        return [
            "user_id" => $this->faker->randomElement(User::all()),
            "type" => Arr::random($types),
            "description" => $this->faker->title,
            "amount" => $this->faker->randomFloat(2, 0, 100),
        ];
    }

    public function incomes()
    {
        return $this->state(function () {
            return [
                'type' => 'income',
            ];
        });
    }

    public function expenses()
    {
        return $this->state(function () {
            return [
                'type' => 'expense',
            ];
        });
    }
}
