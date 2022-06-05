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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_list_all_transactions()
    {
        $user = User::factory()
            ->has(Transaction::factory()->count(2))
            ->create();
        $this->actingAs($user);

        $response = $this->get($this->base_route);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }
}
