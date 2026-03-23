<?php

namespace App\Policies\Company;

use App\Concerns\SubordinateAccess;
use App\Models\Company\Branch;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization, SubordinateAccess;

    /**
     * Determine whether the user can fetch prerequisites any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function preRequisite(User $user)
    {
        return $user->can('branch:create') || $user->can('branch:edit');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('branch:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Branch $branch)
    {
        if (! $user->can('branch:read')) {
            return false;
        }

        if ($branch->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleBranch($branch);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('branch:create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Branch $branch)
    {
        if (! $user->can('branch:edit')) {
            return false;
        }

        if ($branch->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleBranch($branch);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Branch $branch)
    {
        if (! $user->can('branch:delete')) {
            return false;
        }

        if ($branch->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleBranch($branch);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Branch $branch)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Branch $branch)
    {
        //
    }
}
