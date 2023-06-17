<?php

namespace App\Repositories\Auth;

use App\Contracts\AuthRepositoryInterface;
use App\Exceptions\Auth\InvalidAuthentication;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Login a user
     *
     * @param array<string, mixed> $data
     */
    public function login(array $data)
    {
        $attempt = Auth::attempt($data);

        if ($attempt) {
            $user = Auth::user();
            return $user->createToken('auth_token')->plainTextToken;
        }

        throw new InvalidAuthentication('Invalid credentials');
    }

    /**
     * Logout a user
     */
    public function logout(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }
}
