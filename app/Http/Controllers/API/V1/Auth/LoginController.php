<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Contracts\AuthRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;

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
     * @param LoginUserRequest $request
     */
    /**
     * @OA\Post(
     *     path="auth/login",
     *     tags={"Auth"},
     *     summary="Login a user",
     *     description="Login a user",
     *    operationId="login",
     *    @OA\RequestBody(
     *       required=true,
     *      description="Pass user credentials",
     *     @OA\JsonContent(
     *       required={"email","password"},
     *      @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *     @OA\Property(property="password", type="string", format="password", example="password"),
     *    ),
     *   ),
     *  @OA\Response(
     *     response=200,
     *   description="User logged in successfully",
     * ),
     * @OA\Response(
     *  response=401,
     * description="Invalid credentials",
     * ),
     * ),
     */
    public function login(LoginUserRequest $request)
    {
        $token = $this->authRepository->login($request->validated());
        return $this->success(['token' => $token], 'User logged in successfully');
    }
}
