<?php

namespace App\Policies\Employee;

use App\Concerns\SubordinateAccess;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeCategoryPolicy
{
    use HandlesAuthorization, SubordinateAccess;

    private function validateTeam(User $user, Employee $employee)
    {
        return $employee->team_id == $user->current_team_id;
    }

    /**
     * Determine whether the user can fetch prerequisites any models.
     */
    public function preRequisite(User $user)
    {
        return $user->canAny(['employee-category:read', 'employee-category:create', 'employee-category:edit']);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('employee-category:read');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): bool
    {
        if (! $user->can('employee-category:edit')) {
            return false;
        }

        if (! $this->validateTeam($user, $employee)) {
            return false;
        }

        if ($employee->user_id == auth()->id()) {
            return false;
        }

        return true;
    }
}
