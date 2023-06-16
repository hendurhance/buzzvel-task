<?php

namespace App\Http\Controllers\API\V1\Task;

use App\Contracts\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\GetTasksRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * TaskController Constructor
     */
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    /**
     * Display a listing of the task.
     */
    public function index(GetTasksRequest $request)
    {
        $tasks = $this->taskRepository->all($request->validated());
        return $this->success(TaskResource::collection($tasks), 'Tasks retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskRepository->create($request->validated());
        return $this->success(TaskResource::make($task), 'Task created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $task = $this->taskRepository->findById($uuid);
        return $this->success(TaskResource::make($task), 'Task retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $uuid)
    {
        $task = $this->taskRepository->update($request->validated(), $uuid);
        return $this->success(TaskResource::make($task), 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $uuid)
    {
        $this->taskRepository->delete($uuid);
        return $this->success(null, 'Task deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
