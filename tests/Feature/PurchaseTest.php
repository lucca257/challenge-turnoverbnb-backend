<?php

namespace Tests\Feature;

use App\Domains\Purchases\Models\Purchase;
use App\Domains\Transaction\Models\Transaction;
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
        $response = $this->get($this->base_route . 'list', [
            'month' => date('m')
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "year" => ["The year field is required."]
            ]);
    }

    public function test_field_month_should_be_required_on_list_purchases(){
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
        $this->actingAs($user);

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
        $this->actingAs($user);
        $response = $this->post($this->base_route,[
            //'amount' => '100',
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
        $this->actingAs($user);
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
        $this->actingAs($user);
        $response = $this->post($this->base_route,[
            'amount' => '100',
            'description' => 'Test',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "purchase_at" => ["The purchase at field is required."],
            ]);

    }
}
