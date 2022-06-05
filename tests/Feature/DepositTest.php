<?php

namespace Tests\Feature;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
        $response = $this->post($this->base_route . "list", [
            'month' => date('m'),
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "year" => ["The year field is required."]
            ]);
    }

    public function test_field_month_should_be_required_on_list_deposits(){
        $response = $this->get($this->base_route . "list", [
            'year' => date('Y')
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "month" => ["The month field is required."]
            ]);
    }

    public function test_should_list_all_deposits(): void
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

        $response = $this->post($this->base_route . "list", [
            'year' => date('Y'),
            'month' => date('m'),
        ]);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }

    public function test_should_list_all_deposits_filtered_by_status(): void
    {
        $user = User::factory()
            ->has(Transaction::factory()->count(2))
            ->create();
        $this->actingAs($user);

        $user->transactions->each(function ($transaction) {
            Deposit::factory()->statusRejected()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id,
            ]);
        });

        Deposit::factory()->statusPending()->create([
            'user_id' => $user->transactions->first->user_id,
            'transaction_id' => $user->transactions->first->id,
        ]);

        $response = $this->post($this->base_route . "list", [
            'year' => date('Y'),
            'month' => date('m'),
            "status" => "pending"
        ]);
        $response->assertStatus(200)->assertJsonFragment([
            "status" => "pending"
        ]);
        $this->assertCount(1, $response->json());
    }

    public function test_should_detail_deposit(): void
    {
        $user = User::factory()
            ->has(Transaction::factory()->count(1))
            ->create();
        $this->actingAs($user);

        $user->transactions->each(function ($transaction) {
            Deposit::factory()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id
            ]);
        });
        $response = $this->get($this->base_route . $user->transactions->first()->id);
        $response->assertStatus(200)->assertJsonFragment($user->deposits->first()->toArray());
    }

    public function test_field_amount_is_required_on_create_deposit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post($this->base_route, [
//            "amount" => random_float(1, 99999),
            "description" => "test",
            "image" => UploadedFile::fake()->image('test.jpg')
        ]);
        $response->assertStatus(422);
    }
}
