<?php

namespace App\Http\Controllers\Team;

use App\Actions\UserSearch;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Team\DfaListService;
use Illuminate\Http\Request;

class DfaController extends Controller
{
    public function dfaList(Request $request, DfaListService $service)
    {
        return $service->getList($request);
    }

    public function dfaAssign(Request $request)
    {
        $request->validate([
            'users' => 'required|array|min:1',
            'users.*' => 'required|exists:users,uuid',
        ]);

        $users = User::whereIn('uuid', $request->users)->get();

        foreach ($users as $user) {
            if (! $user->hasRole('d-f-a')) {
                $user->assignRole('d-f-a');
            }

            if ($user->status->value !== 'activated') {
                $user->status = 'activated';
                $user->save();
            }
        }

        return response()->success(['message' => trans('global.assigned', ['attribute' => trans('team.config.dfa.role')])]);
    }

    public function dfaRevoke(string $user)
    {
        $user = User::whereUuid($user)->firstOrFail();

        $user->removeRole('d-f-a');

        return response()->success(['message' => trans('global.removed', ['attribute' => trans('team.config.dfa.role')])]);
    }

    public function searchUser(Request $request, UserSearch $action)
    {
        return UserResource::collection($action->execute($request));
    }

    public function preRequisite(Request $request, DfaListService $service)
    {
        return response()->ok([]);
    }
}
