<?php

namespace App\Concerns;

use App\Models\Team;
use Illuminate\Validation\ValidationException;

trait TeamAccessible
{
    public function canAdd(): void
    {
        if (! \Auth::user()->is_default) {
            throw ValidationException::withMessages(['message' => trans('user.errors.permission_denied')]);
        }
    }

    public function isAccessible(Team $team, $exception = true): bool
    {
        if (! in_array($team->id, config('config.teams', []))) {
            if ($exception) {
                throw ValidationException::withMessages(['message' => trans('user.errors.permission_denied')]);
            }

            return false;
        }

        return true;
    }
}
