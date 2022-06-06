<?php

namespace Tests\Feature;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Images\Models\Image;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private string $base_route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->base_route = 'api/admin/deposits';
        $admin = User::factory()->roleAdmin()->create();
        $this->actingAs($admin);
    }

    public function test_admin_can_list_pending_deposits()
    {
        $user = User::factory()
            ->roleAdmin()
            ->has(Transaction::factory()->count(2))
            ->create();
        $user->transactions->each(function ($transaction) {
            Deposit::factory()->statusPending()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id,
                'image_id' => Image::factory()->create()->first()->id
            ]);
        });

        $response = $this->get($this->base_route);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }

    public function test_admin_should_see_details_of_pending_deposit()
    {
        $deposit_id = 0;
        $user = User::factory()
            ->roleAdmin()
            ->has(Transaction::factory()->count(1))
            ->create();
        $user->transactions->each(function ($transaction) {
            $deposit = Deposit::factory()->statusPending()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id,
                'image_id' => Image::factory()->create()->first()->id
            ]);
            $deposit_id = $deposit->id;
        });

        $response = $this->get($this->base_route. '/' . $deposit_id);
        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
    }
}
