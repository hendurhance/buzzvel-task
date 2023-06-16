<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTaskTest extends TestCase
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

    public function test_create_task_with_valid_data_successful()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson(route('api.v1.tasks.store'), [
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'completed' => '0',
            'files' => [$file]
        ], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'created_at']]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task 1',
            'description' => 'Task 1 description'
        ]);
    }

    public function test_create_task_returns_error_when_unauthenticated()
    {
        $response = $this->postJson(route('api.v1.tasks.store'), [
            'title' => 'Task 1',
            'description' => 'Task 1 description'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_create_task_returns_error_when_title_is_missing()
    {
        $response = $this->postJson(route('api.v1.tasks.store'), [
            'description' => 'Task 1 description'
        ], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_create_task_returns_error_when_title_is_too_long()
    {
        $response = $this->postJson(route('api.v1.tasks.store'), [
            'title' => str_repeat('a', 256),
            'description' => 'Task 1 description'
        ], [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['title']);
    }
}
