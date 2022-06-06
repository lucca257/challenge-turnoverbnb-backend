<?php

namespace Tests\Feature;

use App\Domains\Purchases\Models\Purchase;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Transaction\Models\UserBalance;
use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTestTest extends TestCase
{
    use RefreshDatabase;

    private string $base_route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->base_route = 'api/customer/purchases/';
    }

    public function test_field_year_should_be_required_on_list_purchases(){
        $user = User::factory()->create();
        $this->actingAs($user,'sanctum');
        $response = $this->get($this->base_route . 'list', [
            'month' => date('m')
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "year" => ["The year field is required."]
            ]);
    }

    public function test_field_month_should_be_required_on_list_purchases(){
        $user = User::factory()->create();
        $this->actingAs($user,'sanctum');
        $response = $this->get($this->base_route . 'list', [
            'year' => date('Y')
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "month" => ["The month field is required."]
            ]);
    }

    public function test_should_list_all_purchases(): void
    {
        $user = User::factory()
            ->has(Transaction::factory()->count(2))
            ->has(Purchase::factory()->count(2))
            ->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->post($this->base_route . 'list', [
            'year' => date('Y'),
            'month' => date('m'),
        ]);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }

    public function test_field_amount_is_required_on_create_purchase(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,[
            'description' => 'Test',
            'purchase_at' => date('Y-m-d'),
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "amount" => ["The amount field is required."],
            ]);
    }

    public function test_field_desciption_is_required_on_create_purchase(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,[
            'amount' => '100',
            'purchase_at' => date('Y-m-d'),
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "description" => ["The description field is required."],
            ]);
    }

    public function test_field_purchase_at_is_required_on_create_purchase(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,[
            'amount' => '100',
            'description' => 'Test',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "purchase_at" => ["The purchase at field is required."],
            ]);
    }

    public function test_should_create_new_purchase(): void
    {
        $mock_data = [
            'amount' => '100',
            'description' => 'Test',
            'purchase_at' => date('Y-m-d'),
        ];
        $user = User::factory()->create();
        UserBalance::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,$mock_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('purchases', [
            "user_id" => $user->id,
            ...$mock_data
        ]);
    }

    public function test_should_create_new_transaction_on_post_to_create_new_purchase(): void
    {
        $mock_data = [
            'amount' => '100',
            'description' => 'Test',
            'purchase_at' => date('Y-m-d'),
        ];
        $user = User::factory()->create();
        $tt = UserBalance::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,$mock_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', [
            "user_id" => $user->id,
            'amount' => '100',
            'description' => 'Test',
        ]);
    }

    public function test_should_update_user_balance_when_create_new_purchase(): void
    {
        $mock_data = [
            'amount' => '100',
            'description' => 'Test',
            'purchase_at' => date('Y-m-d'),
        ];
        $user = User::factory()->create();
        UserBalance::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,$mock_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('user_balances', [
            "user_id" => $user->id,
            "current_balance" => 99899,
            "total_incomes" => 99999,
            "total_expenses" => 100099,
        ]);
    }

    public function test_should_not_create_new_purchase_when_user_balance_is_not_enough()
    {
        $mock_data = [
            'amount' => '100',
            'description' => 'Test',
            'purchase_at' => date('Y-m-d'),
        ];
        $user = User::factory()->create();
        UserBalance::factory()->noBalance()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post($this->base_route,$mock_data);
        $response->assertStatus(422)->assertJson([
            "message" => "User dont have balance enough for it"
        ]);
    }
}
