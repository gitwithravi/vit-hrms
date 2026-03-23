<?php

namespace App\Http\Requests\Employee;

use App\Enums\Gender;
use App\Models\Company\Branch;
use App\Models\Company\Department;
use App\Models\Company\Designation;
use App\Models\Contact;
use App\Models\Employee\Employee;
use App\Models\Option;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EmployeeCategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'category' => 'required|in:staff,employee',
        ];
    }

    public function withValidator($validator): void
    {
        if (! $validator->passes()) {
            return;
        }
    }

    /**
     * Translate fields with user-friendly name.
     */
    public function attributes(): array
    {
        return [
            'category' => __('employee.employee-category'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [];
    }
}
