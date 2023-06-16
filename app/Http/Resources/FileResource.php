<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => asset('storage/app/attachments/' . $this->path),
            'size' => round($this->size / 1024, 2) . ' KB', // round to 2 decimal places (KB
            'type' => $this->type,
        ];
    }
}
