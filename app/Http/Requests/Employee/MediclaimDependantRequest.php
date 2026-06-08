<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee\MediclaimDependant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MediclaimDependantRequest extends FormRequest
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
            'top_up' => ['nullable', Rule::in(array_keys(MediclaimDependant::TOP_UP_OPTIONS))],
            'dependants' => 'present|array|max:5',
            'dependants.*.name' => 'nullable|string|min:2|max:100',
            'dependants.*.relationship' => ['nullable', Rule::in(array_keys(MediclaimDependant::RELATIONSHIPS))],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $hasDependants = false;

            foreach ($this->input('dependants', []) as $index => $dependant) {
                $hasData = filled($dependant['name'] ?? null)
                    || filled($dependant['relationship'] ?? null);

                if (! $hasData) {
                    continue;
                }

                $hasDependants = true;

                foreach (['name', 'relationship'] as $field) {
                    if (blank($dependant[$field] ?? null)) {
                        $validator->errors()->add(
                            "dependants.{$index}.{$field}",
                            __('validation.required', ['attribute' => $this->attributes()["dependants.*.{$field}"]])
                        );
                    }
                }
            }

            if ($hasDependants && blank($this->input('top_up'))) {
                $validator->errors()->add(
                    'top_up',
                    __('validation.required', ['attribute' => $this->attributes()['top_up']])
                );
            }
        });
    }

    public function attributes(): array
    {
        return [
            'top_up' => __('employee.mediclaim.props.top_up'),
            'dependants' => __('employee.mediclaim.dependants'),
            'dependants.*.name' => __('employee.mediclaim.props.name'),
            'dependants.*.relationship' => __('employee.mediclaim.props.relationship'),
        ];
    }
}
