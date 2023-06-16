<?php

namespace App\Contracts;

interface TaskRepositoryInterface
{
    /**
     * Get all tasks
     *
     * @return LengthAwarePaginator
     */
    public function all(array $filters);

    /**
     * Get a task by id
     *
     * @param string $uuid
     * @return mixed
     */
    public function findById(string $uuid);

    /**
     * Create a new task
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a task
     *
     * @param array $data
     * @param string $uuid
     * @return mixed
     */
    public function update(array $data, string $uuid);

    /**
     * Delete a task
     *
     * @param string $uuid
     * @return mixed
     */
    public function delete(string $uuid);
}