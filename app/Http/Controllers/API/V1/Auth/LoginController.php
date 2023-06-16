<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Contracts\AuthRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * LoginController Constructor
     */
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    /**
     * Login a user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function login(LoginUserRequest $request)
    {
        $token = $this->authRepository->login($request->validated());
        return $this->success(['token' => $token], 'User logged in successfully');
    }
}
