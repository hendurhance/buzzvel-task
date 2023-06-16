<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
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

    public function test_updated_task_with_valid_data_successful()
    {
        $response = $this->putJson(route('api.v1.tasks.update', $this->tasks->first->id), [
            'title' => 'Updated Task Title',
            'description' => 'Updated Task Description',
            'completed' => true
        ], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'created_at', 'updated_at']]);
    }

    public function test_updated_task_with_invalid_data_returns_error()
    {
        $response = $this->putJson(route('api.v1.tasks.update', $this->tasks->first->id), [
            'title' => str_repeat('a', 256),
            'description' => '',
            'completed' => 'invalid'
        ], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors' => ['title', 'completed']]);
    }
}
