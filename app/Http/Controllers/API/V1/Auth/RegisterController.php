<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * RegisterController Constructor
     */
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * Create a new user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function create(CreateUserRequest $request)#: JsonResponse
    {
        $this->userRepository->create($request->validated());
        return $this->success(null, 'User created successfully', Response::HTTP_CREATED);
    }
}
