<?php

namespace Tests\Feature;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepositTest extends TestCase
{
    use RefreshDatabase;

    private string $base_route;

    protected function setUp(): void
    {
        parent::setUp();

        $this->base_route = 'api/customer/deposits/';
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_field_year_should_be_required_on_list_deposits(){
        $response = $this->post($this->base_route, [
            'month' => date('m'),
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "year" => ["The year field is required."]
            ]);
    }

    public function test_field_month_should_be_required_on_list_deposits(){
        $response = $this->get($this->base_route, [
            'year' => date('Y')
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "month" => ["The month field is required."]
            ]);
    }

    public function test_should_list_all_transactions(): void
    {
        $user = User::factory()
            ->has(Transaction::factory()->count(2))
            ->create();
        $this->actingAs($user);

        $user->transactions->each(function ($transaction) {
           Deposit::factory()->create([
               'user_id' => $transaction->user_id,
               'transaction_id' => $transaction->id
           ]);
        });

        $response = $this->post($this->base_route, [
            'year' => date('Y'),
            'month' => date('m'),
        ]);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }
}
