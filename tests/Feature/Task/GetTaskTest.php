<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetTaskTest extends TestCase
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

        $this->tasks = Task::factory()->count(5)->create();

        $this->accessToken = $this->user->createToken('authToken')->plainTextToken;
    }

    public function test_get_tasks_successful()
    {
        $response = $this->getJson(route('api.v1.tasks.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['*' => ['id', 'title', 'description', 'created_at', 'updated_at']]]);
    }

    public function test_get_tasks_with_search_filter_successful()
    {
        $response = $this->getJson(route('api.v1.tasks.index', ['search' => $this->tasks->first()->title]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['*' => ['id', 'title', 'description', 'created_at', 'updated_at']]]);
    }

    public function test_get_tasks_with_sort_and_order_filter_successful()
    {
        $response = $this->getJson(route('api.v1.tasks.index', ['sort' => 'title', 'order' => 'desc']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['*' => ['id', 'title', 'description', 'created_at', 'updated_at']]]);
    }

    public function test_get_tasks_with_from_and_to_filter_successful()
    {
        $response = $this->getJson(route('api.v1.tasks.index', ['from' => now()->subDays(5)->format('Y-m-d'), 'to' => now()->addDays(5)->format('Y-m-d')]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['*' => ['id', 'title', 'description', 'created_at', 'updated_at']]]);
    }

    public function test_get_task_by_valid_id_successful()
    {
        $response = $this->getJson(route('api.v1.tasks.show', $this->tasks->first()->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'created_at', 'updated_at']]);
    }

    public function test_get_task_by_invalid_id_returns_error()
    {
        $response = $this->getJson(route('api.v1.tasks.show', 99999));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
