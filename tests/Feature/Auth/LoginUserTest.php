<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => bcrypt('P@ssw0rd')
        ]);
    }

    public function test_login_user_with_valid_credentials_successful()
    {
        $response = $this->postJson(route('api.v1.auth.login'), [
            'email' => $this->user->email,
            'password' => 'P@ssw0rd'
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['token']]);
    }

    public function test_login_user_returns_error_when_email_is_missing()
    {
        $response = $this->postJson(route('api.v1.auth.login'), [
            'password' => 'P@ssw0rd'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_login_user_returns_error_when_password_is_missing()
    {
        $response = $this->postJson(route('api.v1.auth.login'), [
            'email' => $this->user->email
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_login_user_returns_error_when_credentials_are_invalid()
    {
        $response = $this->postJson(route('api.v1.auth.login'), [
            'email' => $this->user->email,
            'password' => 'P@ssw0rd1'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
