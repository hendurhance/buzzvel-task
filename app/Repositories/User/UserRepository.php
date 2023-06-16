<?php

namespace App\Repositories\User;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): void
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);
    }
}