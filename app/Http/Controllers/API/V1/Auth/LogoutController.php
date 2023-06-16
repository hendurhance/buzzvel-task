<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Contracts\AuthRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * LoginController Constructor
     */
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Logout a user
     */
    public function logout()
    {
        $this->authRepository->logout();
        return $this->success(null, 'User logged out successfully');
    }
}