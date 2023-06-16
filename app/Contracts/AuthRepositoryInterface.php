<?php

namespace App\Contracts;

interface AuthRepositoryInterface
{
    /**
     * Login a user
     *
     * @param array<string, mixed> $data
     */
    public function login(array $data);

    /**
     * Logout a user
     */
    public function logout(): void;
}