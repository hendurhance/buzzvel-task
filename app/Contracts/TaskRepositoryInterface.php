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
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

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
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id);

    /**
     * Delete a task
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}