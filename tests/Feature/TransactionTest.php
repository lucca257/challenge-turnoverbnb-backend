<?php

namespace Tests\Feature;

use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    private string $base_route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->base_route = 'api/customer/transactions/';
    }

    public function test_field_year_should_be_required_on_list(){
        $response = $this->get($this->base_route, [
            'month' => '1'
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "year" => ["The year field is required."]
            ]);
    }

    public function test_field_month_should_be_required_on_list(){
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

        $response = $this->post($this->base_route, [
            'year' => date('Y'),
            'month' => date('m'),
        ]);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }
}
