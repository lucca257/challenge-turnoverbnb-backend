<?php

namespace Database\Factories;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory
 */
class DepositFactory extends Factory
{
    protected $model = Deposit::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = Arr::random(["pending", "confirmed", "rejected"]);
        return [
            "user_id" => $this->faker->randomElement(User::all()),
//            "image_id" => $this->faker->randomElement(User::all()),
            "transaction_id" => $this->faker->randomElement(Transaction::all()),
            "status" => $status,
            "description" => $this->faker->title,
            "amount" => $this->faker->randomFloat(2, 0, 100),
//            "rejected_reason" => $this->faker->sentence,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function statusPending(): array
    {
        return $this->state(function () {
            return [
                "status" => "pending",
            ];
        });
    }

    /**
     * @return array<string, mixed>
     */
    public function statusConfirmed(): array
    {
        return $this->state(function () {
            return [
                "status" => "confirmed",
            ];
        });
    }

    /**
     * @return array<string, mixed>
     */
    public function statusRejected(): array
    {
        return $this->state(function () {
            return [
                "status" => "rejected",
            ];
        });
    }
}