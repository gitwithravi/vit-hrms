<?php

namespace App\Concerns;

use App\Models\Company\Branch;
use App\Models\Company\Designation;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeCategory;
use App\Support\HasTree;
use Illuminate\Validation\ValidationException;

trait SubordinateAccess
{
    use HasTree;

    public function getAccessibleDesignationIds(string $date = null)
    {
        if (auth()->user()->is_default) {
            return;
        }

        if (auth()->user()->can('designation:admin-access')) {
            return;
        }

        $date ??= today()->toDateString();

        $employee = Employee::query()
            ->auth()
            ->withCurrentDesignationId()
            ->first();

        $designationIds = [];
        if (! $employee) {
        } else if (auth()->user()->can('designation:self-access')) {
            $designationIds[] = $employee->current_designation_id;
        } else if (auth()->user()->can('designation:subordinate-access')) {
            $designations = Designation::query()
                ->byTeam()
                ->whereNotNull('parent_id')
                ->pluck('parent_id', 'id')
                ->all();

            $childDesignationIds = $this->getChilds($designations, $employee->current_designation_id);

            $designationIds = array_merge($designationIds, $childDesignationIds);
        }

        return $designationIds;
    }

    public function getAccessibleBranchIds(string $date = null)
    {
        if (auth()->user()->is_default) {
            return;
        }

        if (auth()->user()->can('branch:admin-access')) {
            return;
        }

        $date ??= today()->toDateString();

        $employee = Employee::query()
            ->auth()
            ->withCurrentBranchId()
            ->first();

        $branchIds = [];
        if (! $employee) {
        } else if (auth()->user()->can('branch:self-access')) {
            $branchIds[] = $employee->current_branch_id;
        } else if (auth()->user()->can('branch:subordinate-access')) {
            $branches = Branch::query()
                ->byTeam()
                ->whereNotNull('parent_id')
                ->pluck('parent_id', 'id')
                ->all();

            $childBranchIds = $this->getChilds($branches, $employee->current_branch_id);

            $branchIds = array_merge($branchIds, $childBranchIds);
        }

        return $branchIds;
    }

    public function isAccessibleDesignation(Designation $designation): bool
    {
        $accessibleDesignationIds = Designation::query()
            ->byTeam()
            ->filterAccessible()
            ->pluck('designations.id')
            ->all();

        if (! in_array($designation->id, $accessibleDesignationIds)) {
            return false;
        }

        return true;
    }

    public function isAccessibleBranch(Branch $branch): bool
    {
        $accessibleBranchIds = Branch::query()
            ->byTeam()
            ->filterAccessible()
            ->pluck('branchs.id')
            ->all();

        if (! in_array($branch->id, $accessibleBranchIds)) {
            return false;
        }

        return true;
    }

    public function getAccessibleEmployeeIds(): array
    {
        if (auth()->user()->hasRole('d-f-a')) {
            return EmployeeCategory::pluck('employee_id')->all();
        }

        return Employee::query()
            ->summary()
            ->filterAccessible()
            ->pluck('employees.id')
            ->all();
    }

    public function isAccessibleEmployee(Employee $employee): bool
    {
        $accessibleEmployeeIds = $this->getAccessibleEmployeeIds();

        if (! in_array($employee->id, $accessibleEmployeeIds)) {
            return false;
        }

        return true;
    }

    public function validateEmployeeJoiningDate(Employee $employee, string $date, string $module = '', string $field = 'message'): void
    {
        if ($employee->joining_date->value > $date) {
            throw ValidationException::withMessages([$field => trans('validation.after_or_equal', ['attribute' => $module, 'date' => trans('employee.props.joining_date').' '.$employee->joining_date->formatted])]);
        }
    }

    public function validateEmployeeLeavingDate(Employee $employee, string $date, string $module = '', string $field = 'message'): void
    {
        if ($employee->leaving_date->value && $employee->leaving_date->value < $date) {
            throw ValidationException::withMessages([$field => trans('validation.before_or_equal', ['attribute' => $module, 'date' => trans('employee.props.joining_date').' '.$employee->leaving_date->value])]);
        }
    }
}
