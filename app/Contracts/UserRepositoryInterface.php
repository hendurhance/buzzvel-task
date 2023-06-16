<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    /**
     * Create a new user
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): void;
}