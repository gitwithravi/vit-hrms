<?php

beforeEach(function () {
    $this->acl = json_decode(
        file_get_contents(__DIR__.'/../../resources/var/permission.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );
});

it('defines an attendance and leave manager role', function () {
    expect($this->acl['roles'])->toContain('attendance-leave-manager');
});

it('limits the role to attendance and leave operations', function () {
    $assignedPermissions = collect($this->acl['permissions'])
        ->flatMap(fn (array $permissions) => collect($permissions)
            ->filter(fn (array $roles) => in_array('attendance-leave-manager', $roles, true))
            ->keys())
        ->values()
        ->all();

    expect($assignedPermissions)
        ->toContain(
            'login:action',
            'attendance:read',
            'attendance:mark',
            'attendance:export',
            'timesheet:read',
            'timesheet:export',
            'leave-allocation:read',
            'leave-allocation:export',
            'leave-request:read',
            'leave-request:action',
            'leave-request:export',
        )
        ->not->toContain(
            'employee:read',
            'payroll:read',
            'user:read',
            'task:read',
            'finance:config',
            'designation:admin-access',
            'branch:admin-access',
        );
});
