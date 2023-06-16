<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_with_valid_data_successful()
    {
        $response = $this->postJson(route('api.v1.auth.create'), [
            'name' => 'John Doe',
            'email' => 'jane@example.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_create_user_return_error_when_name_is_missing()
    {
        $response = $this->postJson(route('api.v1.auth.create'), [
            'email' => 'john@example.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_create_user_returns_error_when_email_is_missing()
    {
        $response = $this->postJson(route('api.v1.auth.create'), [
            'name' => 'John Doe',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_create_user_returns_error_when_password_is_not_equal_to_password_confirmation()
    {
        $response = $this->postJson(route('api.v1.auth.create'), [
            'name' => 'John Doe',
            'email' => 'jane@example.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd1'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);

    }

}
