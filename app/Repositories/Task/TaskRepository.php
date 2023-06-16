<?php

namespace App\Repositories\Task;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
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

        if (isset($filters['from']) || isset($filters['to'])) {
            $query->whereBetween('created_at', [$filters['from'], $filters['to']]);
        }

        if (isset($filters['offset'])) {
            $query->offset($filters['offset']);
        }

        return $query->paginate($filters['limit'] ?? 10);
    }

    /**
     * Get a task by id
     *
     * @param string $uuid
     * @return mixed
     */
    public function findById(string $uuid)
    {
        return Task::whereUuid($uuid)->first();
    }

    /**
     * Create a new task
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
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
     * @param string $uuid
     * @param array $data
     * @return mixed
     */
    public function update(array $data, string $uuid)
    {
        $task = $this->findById($uuid);
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
     * @param string $uuid
     * @return mixed
     */
    public function delete(string $uuid)
    {
        $task = $this->findById($uuid);
        $task->destroy();

        return $task;
    }
}
