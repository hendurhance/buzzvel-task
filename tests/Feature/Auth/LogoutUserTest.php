<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $accessToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => bcrypt('P@ssw0rd')
        ]);

        $this->accessToken = $this->user->createToken('authToken')->plainTextToken;
    }

    public function test_logout_user_successful()
    {
        $response = $this->getJson(route('api.v1.auth.logout'), [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_logout_user_returns_error_when_unauthenticated()
    {
        $response = $this->getJson(route('api.v1.auth.logout'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
