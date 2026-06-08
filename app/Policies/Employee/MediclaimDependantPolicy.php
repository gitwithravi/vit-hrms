<?php

namespace App\Policies\Employee;

use App\Models\User;

class MediclaimDependantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('employee:read');
    }

    public function export(User $user): bool
    {
        return $user->can('employee:export');
    }
}
