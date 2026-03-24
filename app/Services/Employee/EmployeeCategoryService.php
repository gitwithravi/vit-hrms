<?php

namespace App\Services\Employee;

use App\Actions\CreateContact;
use App\Actions\UpdateContact;
use App\Enums\Gender;
use App\Models\Company\Designation;
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

        $designations = Designation::byTeam()
            ->orderBy('name')
            ->get()
            ->map(fn ($d) => ['uuid' => $d->uuid, 'name' => $d->name]);

        return compact('employeeCategories', 'designations');
    }

    public function bulkAssignByDesignation(Request $request): int
    {
        DB::beginTransaction();

        $mappings = $request->input('mappings');
        $totalUpdated = 0;

        foreach ($mappings as $mapping) {
            $designation = Designation::where('uuid', $mapping['designation'])->first();

            if (! $designation) {
                continue;
            }

            $today = today()->toDateString();

            $employeeIds = Employee::query()
                ->byTeam()
                ->whereIn('employees.id', function ($q) use ($designation, $today) {
                    $q->select('er.employee_id')
                        ->from('employee_records as er')
                        ->where('er.designation_id', $designation->id)
                        ->where('er.start_date', '<=', $today)
                        ->whereRaw('er.id = (SELECT id FROM employee_records WHERE employee_id = er.employee_id AND start_date <= ? ORDER BY start_date DESC LIMIT 1)', [$today]);
                })
                ->pluck('employees.id');

            foreach ($employeeIds as $employeeId) {
                EmployeeCategory::updateOrCreate(
                    ['employee_id' => $employeeId],
                    ['category' => $mapping['category']]
                );
                $totalUpdated++;
            }
        }

        DB::commit();

        return $totalUpdated;
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
