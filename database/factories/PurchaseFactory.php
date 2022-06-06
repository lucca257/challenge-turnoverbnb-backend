<?php

namespace Database\Factories;

use App\Domains\Purchases\Models\Purchase;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => $this->faker->randomElement(User::all()),
            "transaction_id" => $this->faker->randomElement(Transaction::all()),
            "description" => $this->faker->title,
            "amount" => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
