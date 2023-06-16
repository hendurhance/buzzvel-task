<?php

namespace App\Contracts;

use App\Models\File;
use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface FileRepositoryInterface
{
    /**
     * Upload many files.
     *
     * @param array<UploadedFile> $files
     * @param string $disk
     * @param Task $task
     * @return void
     */
    public function uploadMany(array $file, Task $task): void;
}