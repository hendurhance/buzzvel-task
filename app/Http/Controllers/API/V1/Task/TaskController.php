<?php

namespace App\Http\Controllers\API\V1\Task;

use App\Contracts\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\GetTasksRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * TaskController Constructor
     *
     * @return JsonResponse
     */
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    /**
     * Display a listing of the task.
     *
     * @param GetTasksRequest $request
     * @return HttpResponse
     */
    public function index(GetTasksRequest $request)
    {
        $tasks = $this->taskRepository->all($request->validated());
        return $this->success(TaskResource::collection($tasks), 'Tasks retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTaskRequest $request
     * @return HttpResponse
     */
    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskRepository->create($request->validated());
        return $this->success(TaskResource::make($task), 'Task created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return HttpResponse
     */
    public function show(int $id)
    {
        $task = $this->taskRepository->findById($id);
        return $this->success(TaskResource::make($task), 'Task retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param int $id
     * @return HttpResponse
     */
    public function update(UpdateTaskRequest $request, int $id)
    {
        $task = $this->taskRepository->update($request->validated(), $id);
        return $this->success(TaskResource::make($task), 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return HttpResponse
     */
    public function delete(int $id)
    {
        $this->taskRepository->delete($id);
        return $this->success(null, 'Task deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
