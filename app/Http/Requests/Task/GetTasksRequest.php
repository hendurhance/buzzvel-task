<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class GetTasksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
            'sort' => 'nullable|string|in:id,title,description,created_at,updated_at,completed_at',
            'completed' => 'nullable|boolean',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
            'order' => 'nullable|string|in:asc,desc',
            'from' => 'nullable|date:Y-m-d',
            'to' => 'nullable|date:Y-m-d',
        ];
    }
}
