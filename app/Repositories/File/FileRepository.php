<?php

namespace App\Repositories\File;

use App\Contracts\FileRepositoryInterface;
use App\Models\File;
use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class FileRepository implements FileRepositoryInterface
{
    /**
     * Upload many files.
     *
     * @param array<UploadedFile> $files
     * @param string $disk
     * @param Task $task
     * @return void
     */
    public function uploadMany(array $files, string $disk = 'public', Task $task): void
    {
        foreach ($files as $file) {
            $file->storeAs('files', $file->hashName());
            $task->files()->create([
                'name' => $file->getClientOriginalName(),
                'path' => $file->hashName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType()
            ]);
        }
    }
}