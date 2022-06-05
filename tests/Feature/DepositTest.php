<?php

namespace Tests\Feature;

use App\Domains\Deposits\Models\Deposit;
use App\Domains\Images\Actions\CreateImageAction;
use App\Domains\Images\Models\Image;
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

    private function mockImage(string $user_id): void
    {
        $this->mock(CreateImageAction::class, function ($mock) {
            $imageMock = Image::factory()->create();
            $mock->shouldReceive('execute')
                ->andReturn($imageMock);
        });
        app(CreateImageAction::class)->execute(UploadedFile::fake()->image('test.jpg'), $user_id);
    }

    private function mockUser(){
        $user = User::factory()
            ->has(Transaction::factory()->count(2))
            ->create();
        $this->actingAs($user);
        return $user;
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
        $user = $this->mockUser();
        $user->transactions->each(function ($transaction) {
            Deposit::factory()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id,
                'image_id' => Image::factory()->create()->first()->id
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
        $user = $this->mockUser();

        $user->transactions->each(function ($transaction) {
            Deposit::factory()->statusRejected()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id,
                'image_id' => Image::factory()->create()->first()->id
            ]);
        });

        Deposit::factory()->statusPending()->create([
            'user_id' => $user->transactions->first->user_id,
            'transaction_id' => $user->transactions->first->id,
            'image_id' => Image::factory()->create()->first()->id
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
        $user = $this->mockUser();
        $user->transactions->each(function ($transaction) {
            Deposit::factory()->create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $transaction->id,
                'image_id' => Image::factory()->create()->first()->id
            ]);
        });
        $response = $this->get($this->base_route . $user->transactions->first()->id);
        $response->assertStatus(200)->assertJsonFragment($user->deposits->first()->toArray());
    }

    public function test_field_amount_is_required_on_create_deposit()
    {
        $this->mockUser();
        $response = $this->post($this->base_route, [
            "description" => "test",
            "image" => UploadedFile::fake()->image('test.jpg')
        ]);
        $response->assertStatus(422)->assertJson([
            "amount" => ["The amount field is required."]
        ]);
    }

    public function test_field_desciption_is_required_on_create_deposit()
    {
        $this->mockUser();
        $response = $this->post($this->base_route, [
            "amount" => random_int(1, 99999),
            "image" => UploadedFile::fake()->image('test.jpg')
        ]);
        $response->assertStatus(422)->assertJson([
            "description" => ["The description field is required."]
        ]);
    }

    public function test_field_image_is_required_on_create_deposit()
    {
        $user = $this->mockUser();
        $this->mockImage($user->id);
        $response = $this->post($this->base_route, [
            "amount" => random_int(1, 99999),
            "description" => "test",
        ]);
        $response->assertStatus(422)->assertJson([
            "image" => ["The image field is required."]
        ]);
    }

    public function test_should_create_a_deposit()
    {
        $user = $this->mockUser();
        $this->mockImage($user->id);
        $mock_data = [
            "amount" => random_int(1, 99999),
            "description" => "test",
            "image" => UploadedFile::fake()->image('test.jpg')
        ];
        $response = $this->post($this->base_route, $mock_data);
        $response->assertStatus(200)->assertJsonFragment($mock_data);
    }

    public function test_on_create_a_deposit_create_image()
    {
        $user = $this->mockUser();
        $this->mockImage($user->id);
        $mock_data = [
            "amount" => random_int(1, 99999),
            "description" => "test",
            "image" => UploadedFile::fake()->image('test.jpg')
        ];
        $response = $this->post($this->base_route, $mock_data);
        $response->assertStatus(200)->assertJsonFragment($mock_data);
    }
}
