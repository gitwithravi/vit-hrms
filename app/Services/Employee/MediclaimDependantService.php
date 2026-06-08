<?php

namespace App\Services\Employee;

use App\Http\Requests\Employee\MediclaimDependantRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\MediclaimDependant;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class MediclaimDependantService
{
    public function getAuthEmployee(): Employee
    {
        $employee = Employee::query()
            ->auth()
            ->first();

        if (! $employee) {
            throw ValidationException::withMessages(['message' => __('employee.no_employee_associated')]);
        }

        return $employee;
    }

    public function preRequisite(): array
    {
        return [
            'relationships' => MediclaimDependant::relationshipOptions(),
            'genders' => MediclaimDependant::genderOptions(),
            'topUpOptions' => MediclaimDependant::topUpOptions(),
            'canEdit' => (bool) config('config.system.enable_mediclaim_dependant_edit'),
        ];
    }

    public function list(Employee $employee)
    {
        return MediclaimDependant::query()
            ->whereEmployeeId($employee->id)
            ->orderBy('created_at')
            ->get();
    }

    public function getTopUp(Employee $employee): ?string
    {
        return MediclaimDependant::query()
            ->whereEmployeeId($employee->id)
            ->value('top_up');
    }

    public function replace(MediclaimDependantRequest $request, Employee $employee): void
    {
        if (! config('config.system.enable_mediclaim_dependant_edit')) {
            throw ValidationException::withMessages(['message' => __('employee.mediclaim.edit_disabled')]);
        }

        \DB::transaction(function () use ($request, $employee) {
            $topUp = $request->validated('top_up');

            MediclaimDependant::query()
                ->whereEmployeeId($employee->id)
                ->delete();

            foreach ($request->validated('dependants') as $dependant) {
                if (
                    blank(Arr::get($dependant, 'name'))
                    && blank(Arr::get($dependant, 'relationship'))
                    && blank(Arr::get($dependant, 'gender'))
                    && blank(Arr::get($dependant, 'dob'))
                ) {
                    continue;
                }

                MediclaimDependant::create([
                    'employee_id' => $employee->id,
                    'name' => Arr::get($dependant, 'name'),
                    'relationship' => Arr::get($dependant, 'relationship'),
                    'gender' => Arr::get($dependant, 'gender'),
                    'dob' => Arr::get($dependant, 'dob'),
                    'top_up' => $topUp,
                ]);
            }
        });
    }
}
