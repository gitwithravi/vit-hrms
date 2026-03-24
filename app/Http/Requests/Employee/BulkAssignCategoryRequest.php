<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class BulkAssignCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mappings' => 'required|array|min:1',
            'mappings.*.designation' => 'required|uuid',
            'mappings.*.category' => 'required|in:staff,employee',
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
