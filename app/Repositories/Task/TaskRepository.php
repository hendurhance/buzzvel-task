<?php

namespace App\Repositories\Task;

use App\Contracts\TaskRepositoryInterface;
use App\Exceptions\Task\TaskDoesNotExist;
use App\Exceptions\Task\TaskNotOwnedByUser;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * Get all tasks`
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function all(array $filters): LengthAwarePaginator
    {
        $query = Task::query()->with('user');

        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['completed'])) {
            $query->where('completed', $filters['completed']);
        }

        if (isset($filters['sort'])) {
            $query->orderBy($filters['sort'], $filters['order'] ?? 'asc');
        }

        if (isset($filters['from'])) {
            $query->where('created_at', '>=', Carbon::parse($filters['from']));
        }

        if (isset($filters['to'])) {
            $query->where('created_at', '<=', Carbon::parse($filters['to']));
        }

        if (isset($filters['offset'])) {
            $query->offset($filters['offset']);
        }

        return $query->paginate($filters['limit'] ?? 10);
    }

    /**
     * Get a task by id
     *
     * @param string $int
     * @return mixed
     */
    public function findById(int $id): ?Task
    {
        return Task::findOr($id, function () {
            throw new TaskDoesNotExist();
        })->load('user');
    }

    /**
     * Create a new task
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        $user = auth()->user();
        return $user->tasks()->create(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'files' => $data['files'] ?? [],
                'completed' => $data['completed'] ?? false,
                'completed_at' => $data['completed_at'] ?? null
            ]
        );
    }

    /**
     * Update a task
     *
     * @param int $id
     * @param array $data
     * @return Task
     */
    public function update(array $data, int $id): ?Task
    {
        $task = $this->userOwnsTask($id);
        $task->update([
                'title' => $data['title'] ?? $task->title,
                'description' => $data['description'] ?? $task->description,
                'files' => $data['files'] ?? $task->files,
                'completed' => $data['completed'] ?? $task->completed,
                'completed_at' => $data['completed_at'] ?? $task->completed_at
            ]
        );

        return $task;
    }

    /**
     * Delete a task
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        $task = $this->findById($id);
        $task->destroy();
    }

    /**
     * User Owns Task
     *
     * @param int $id
     * @return Task
     */
    public function userOwnsTask(int $id): ?Task
    {
        $task = $this->findById($id);
        if($task->user_id != auth()->user()->id) {
            throw new TaskNotOwnedByUser();
        }
        return $task;
    }
}
