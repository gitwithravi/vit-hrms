<?php

namespace App\Http\Controllers\Team;

use App\Actions\UserSearch;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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

    }
    public function dfaRevoke(Request $request)
    {

    }
    public function searchUser(Request $request, UserSearch $action)
    {
        return UserResource::collection($action->execute($request));
    }
    public function preRequisite(Request $request,  DfaListService $service)
    {
        return response()->ok([]);
    }
}
