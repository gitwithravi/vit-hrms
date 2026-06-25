<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\MediclaimDependant;
use App\Services\Employee\MediclaimDependantListService;
use Illuminate\Http\Request;

class MediclaimDependantExportController extends Controller
{
    public function __invoke(Request $request, MediclaimDependantListService $service)
    {
        $this->authorize('export', MediclaimDependant::class);

        $list = $service->exportList($request);

        return $service->export($list);
    }
}
