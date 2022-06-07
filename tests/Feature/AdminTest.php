<?php

namespace Tests\Feature;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Images\Models\Image;
use App\Domains\Transaction\Models\Transaction;
use App\Domains\Transaction\Models\UserBalance;
use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private string $base_route;
    private User $user;
    private User $admin;
    private Deposit $deposit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        UserBalance::factory()->noBalance()->create();
        $this->base_route = 'api/admin/deposits/';
        $this->admin = User::factory()->roleAdmin()->create();
        $this->actingAs($this->admin);

        $this->deposit = Deposit::factory()->statusPending()->create([
            'user_id' => $this->user->id,
            'image_id' => Image::factory()->create()->first()->id
        ]);
    }

    public function test_admin_can_list_pending_deposits()
    {
        $response = $this->get($this->base_route);
        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

    public function test_admin_should_see_details_of_pending_deposit()
    {
        $deposit = Deposit::where('user_id', $this->user->id)->first();
        $response = $this->get($this->base_route . $deposit->id);
        $response->assertStatus(200);
        $this->assertEquals($deposit->toArray(),$response->json());
    }

    public function test_field_accepted_is_required_on_review_deposit() : void
    {
        $mock_data = [
            "accepted" => true,
        ];
        $response = $this->patch($this->base_route. 'review', $mock_data);

        $response->assertStatus(422)->assertJson([
            'deposit_id' => ['The deposit id field is required.']
        ]);
    }

    public function test_field_deposit_id_is_required_on_review_deposit() : void
    {
        $mock_data = [
            "deposit_id" => Deposit::where('user_id', $this->user->id)->first()->id,
        ];
        $response = $this->patch($this->base_route. 'review', $mock_data);

        $response->assertStatus(422)->assertJson([
            'accepted' => ['The accepted field is required.']
        ]);
    }

    public function test_deposit_status_should_be_rejected_when_not_accept_deposit () : void
    {
        $mock_data = [
            "accepted" => false,
            "deposit_id" => $this->deposit->id,
        ];
        $response = $this->patch($this->base_route. 'review', $mock_data);
        $response->assertStatus(200)->assertJsonFragment([
            "status" => "rejected",
            "rejection_reason" => "Admin rejected deposit",
            "reviewed_by" => $this->admin->id,
        ]);
    }

    public function test_deposit_status_should_be_accepted_when_accept_deposit () : void
    {
        $mock_data = [
            "accepted" => true,
            "deposit_id" => $this->deposit->id,
        ];
        $response = $this->patch($this->base_route. 'review', $mock_data);
        $response->assertStatus(200)->assertJsonFragment([
            "status" => "confirmed",
            "rejection_reason" => "Admin confirmed deposit",
            "reviewed_by" => $this->admin->id,
        ]);
    }

    public function test_should_create_transaction_after_accept_deposit () : void
    {
        $mock_data = [
            "accepted" => true,
            "deposit_id" => $this->deposit->id,
        ];
        $response = $this->patch($this->base_route. 'review', $mock_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', [
            "user_id" => $this->deposit->user_id,
            "amount" => $this->deposit->amount,
            "type" => "income",
        ]);
    }

    public function test_should_update_user_balance_after_accept_deposit () : void
    {
        $mock_data = [
            "accepted" => true,
            "deposit_id" => $this->deposit->id,
        ];

        $response = $this->patch($this->base_route. 'review', $mock_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('user_balances',[
            "user_id" => $this->deposit->user_id,
            "current_balance" => $this->deposit->amount,
            "total_incomes" => $this->deposit->amount,
        ]);
    }
}
