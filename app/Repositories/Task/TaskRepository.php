<?php

namespace App\Repositories\Task;

use App\Contracts\FileRepositoryInterface;
use App\Contracts\TaskRepositoryInterface;
use App\Exceptions\Task\TaskDoesNotExist;
use App\Exceptions\Task\TaskNotOwnedByUser;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    {
    }

    /**
     * Get all tasks
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function all(array $filters): LengthAwarePaginator
    {
        $query = Task::query()
            ->with('user', 'files')
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['completed']), function ($query) use ($filters) {
                $query->where('completed', $filters['completed']);
            })
            ->when(isset($filters['sort']), function ($query) use ($filters) {
                $query->orderBy($filters['sort'], $filters['order'] ?? 'asc');
            })
            ->when(isset($filters['from']), function ($query) use ($filters) {
                $query->where('created_at', '>=', Carbon::parse($filters['from']));
            })
            ->when(isset($filters['to']), function ($query) use ($filters) {
                $query->where('created_at', '<=', Carbon::parse($filters['to']));
            })
            ->when(isset($filters['offset']), function ($query) use ($filters) {
                $query->offset($filters['offset']);
            });

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
        })->load('user', 'files');
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
        $task = $user->tasks()->create(
            [
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'completed' => $data['completed'] ?? false,
                'completed_at' => isset($data['completed']) && $data['completed'] === true ? Carbon::now() : null
            ]
        );

        $this->fileRepository->uploadMany($data['files'] ?? [], $task);

        return $task->load('user', 'files');
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
            'completed' => $data['completed'] ?? $task->completed,
            'completed_at' => isset($data['completed']) && $data['completed'] === true ? Carbon::now() : null
        ]);

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
        $task = $this->userOwnsTask($id);
        $task->delete();
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
        if ($task->user_id !== auth()->user()->id) {
            throw new TaskNotOwnedByUser();
        }
        return $task;
    }
}
