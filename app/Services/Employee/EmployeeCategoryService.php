<?php

namespace App\Services\Employee;

use App\Actions\CreateContact;
use App\Actions\UpdateContact;
use App\Enums\Gender;
use App\Models\Contact;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeCategory;
use App\Models\Employee\Record;
use App\Support\FormatCodeNumber;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class EmployeeCategoryService
{
    use FormatCodeNumber;

    public function preRequisite(Request $request): array
    {
        $employeeCategories = [
            ['label' => trans('employee.category.employee'), 'value' => 'employee'],
            ['label' => trans('employee.category.staff'), 'value' => 'staff'],
        ];

        return compact('employeeCategories');
    }

    public function update(Request $request, Employee $employee): Employee
    {
        DB::beginTransaction();

        $data = $request->only(['category']);
        $item = EmployeeCategory::firstWhere('employee_id', $employee->id) ?? new EmployeeCategory;
        $item->fill([
            'employee_id' => $employee->id,
            ...$data,
        ]);

        $item->save();


        DB::commit();

        return $employee;
    }
}
