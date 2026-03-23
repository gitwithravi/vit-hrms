<?php

namespace App\Actions\Auth;

use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ValidateRole
{
    public function execute(User $user)
    {
        $this->validateEmployee($user);
    }

    private function validateEmployee(User $user)
    {
        if ($user->is_default) {
            return;
        }

        $employee = Employee::query()
            ->select('employees.id', 'employees.contact_id', 'employees.leaving_date', 'contacts.user_id')
            ->join('contacts', 'employees.contact_id', '=', 'contacts.id')
            ->where('contacts.user_id', '=', $user->id)
            ->first();

        if (! $employee) {
            $user->logout();
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_action')]);
        }

        if ($employee->leaving_date->value && $employee->leaving_date->value < today()->toDateString()) {
            $user->logout();
            throw ValidationException::withMessages(['message' => trans('auth.login.errors.permission_disabled')]);
        }
    }
}