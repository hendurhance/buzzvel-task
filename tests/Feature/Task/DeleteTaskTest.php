<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $accessToken;

    private $tasks;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => bcrypt('P@ssw0rd')
        ]);

        $this->tasks = Task::factory()->count(5)->create(
            [
                'user_id' => $this->user->id
            ]
        );

        $this->accessToken = $this->user->createToken('authToken')->plainTextToken;
    }

    public function test_delete_task_with_valid_id_successful()
    {
        $response = $this->deleteJson(route('api.v1.tasks.delete', $this->tasks->first->id), [], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_delete_task_returns_error_when_unauthenticated()
    {
        $response = $this->deleteJson(route('api.v1.tasks.delete', $this->tasks->first->id));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_delete_task_returns_error_with_invalid_id()
    {
        $response = $this->deleteJson(route('api.v1.tasks.delete', 9999), [], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_task_returns_error_with_user_id_not_matching_task_user_id()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('P@ssw0rd')
        ]);

        $accessToken = $user->createToken('authToken')->plainTextToken;

        $response = $this->deleteJson(route('api.v1.tasks.delete', $this->tasks->first->id), [], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
