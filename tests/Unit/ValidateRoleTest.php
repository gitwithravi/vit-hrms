<?php

use App\Actions\Auth\ValidateRole;
use App\Models\User;

it('allows attendance and leave managers to log in without an employee record', function () {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('getAttribute')->with('is_default')->andReturnFalse();
    $user->shouldReceive('hasAnyRole')
        ->once()
        ->with(['d-f-a', 'attendance-leave-manager'])
        ->andReturnTrue();
    $user->shouldNotReceive('logout');

    (new ValidateRole)->execute($user);
});

it('treats an attendance and leave manager as staff when it also has the user role', function () {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('hasAnyRole')
        ->once()
        ->with(['d-f-a', 'attendance-leave-manager'])
        ->andReturnTrue();

    expect($user->getIsStaffAttribute())->toBeTrue();
});
