<?php

namespace Database\Factories;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Images\Models\Image;
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
            "image_id" => $this->faker->randomElement(Image::all()),
            "transaction_id" => $this->faker->randomElement(Transaction::all()),
            "status" => $status,
            "description" => $this->faker->title,
            "amount" => $this->faker->randomFloat(2, 0, 100),
            "rejection_reason" => "mock text",
            "reviewed_by" => $this->faker->randomElement(User::all()),
        ];
    }

    /**
     * @return DepositFactory
     */
    public function statusPending() : Self
    {
        return $this->state(function (array $attributes) {
            return [
                "status" => "pending",
            ];
        });
    }

    /**
     * @return DepositFactory
     */
    public function statusConfirmed() : Self
    {
        return $this->state(function (array $attributes) {
            return [
                "status" => "confirmed",
            ];
        });
    }

    /**
     * @return DepositFactory
     */
    public function statusRejected() : Self
    {
        return $this->state(function (array $attributes) {
            return [
                "status" => "rejected",
            ];
        });
    }
}
