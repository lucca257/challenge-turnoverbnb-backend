<?php

namespace Tests\Feature;

use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private string $base_route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->base_route = 'api/auth/';
    }

    public function test_field_username_should_be_required_to_register_new_user(){
        $mock_data = [
            "email" => "mockmail@gmail.com",
            "password" => "mock_password"
        ];
        $response = $this->post($this->base_route . "register", $mock_data);
        $response->assertStatus(422)
            ->assertJson([
                "username" => ["The username field is required."]
            ]);
    }

    public function test_field_email_should_be_required_to_register_new_user(){
        $mock_data = [
            "username" => "mockusername",
            "password" => "mock_password"
        ];
        $response = $this->post($this->base_route . "register", $mock_data);
        $response->assertStatus(422)
            ->assertJson([
                "email" => ["The email field is required."]
            ]);
    }

    public function test_password_password_should_be_required_to_register_new_user(){
        $mock_data = [
            "username" => "mockusername",
            "email" => "mockmail@gmail.com"
        ];
        $response = $this->post($this->base_route . "register", $mock_data);
        $response->assertStatus(422)
            ->assertJson([
                "password" => ["The password field is required."]
            ]);
    }

    public function test_should_register_a_new_user(){
        $mock_data = [
            "username" => "mockusername",
            "email" => "mockmail@gmail.com",
            "password" => "mock_password"
        ];
        $response = $this->post($this->base_route . "register", $mock_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            "username" => "mockusername",
            "email" => "mockmail@gmail.com"
        ]);
    }

    public function test_should_login_user(){
        $mock_data = [
            "username" => "mockusername",
            "password" => Hash::make("passwordmock"),
            "email" => "mockmail@gmail.com"
        ];
        User::factory()->create($mock_data);
        $mock_data["password"] = "passwordmock";
        $response = $this->post($this->base_route . "login", $mock_data);
        $response->assertStatus(200)->assertJsonFragment(["token_type" => "Bearer"]);
    }
}
