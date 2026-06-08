<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\MediclaimDependantRequest;
use App\Http\Resources\Employee\MediclaimDependantResource;
use App\Models\Employee\Employee;
use App\Models\Employee\MediclaimDependant;
use App\Services\Employee\MediclaimDependantListService;
use App\Services\Employee\MediclaimDependantService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MediclaimDependantController extends Controller
{
    private function preRequisiteForEmployee(Employee $employee, MediclaimDependantService $service): array
    {
        $preRequisite = $service->preRequisite();
        $preRequisite['canEdit'] = $preRequisite['canEdit'] && $employee->user_id === auth()->id();

        return $preRequisite;
    }

    public function preRequisite(MediclaimDependantService $service)
    {
        return response()->ok($service->preRequisite());
    }

    public function showForEmployee(string $employee, MediclaimDependantService $service)
    {
        $employee = Employee::findDetailByUuidOrFail($employee);

        $this->authorize('view', $employee);

        return response()->ok([
            'dependants' => MediclaimDependantResource::collection($service->list($employee)),
            'topUp' => $service->getTopUp($employee),
            ...$this->preRequisiteForEmployee($employee, $service),
        ]);
    }

    public function storeForEmployee(string $employee, MediclaimDependantRequest $request, MediclaimDependantService $service)
    {
        $employee = Employee::findDetailByUuidOrFail($employee);

        $this->authorize('view', $employee);

        if ($employee->user_id !== auth()->id()) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_action')]);
        }

        $service->replace($request, $employee);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('employee.mediclaim.dependants')]),
            'dependants' => MediclaimDependantResource::collection($service->list($employee)),
            'topUp' => $service->getTopUp($employee),
            ...$this->preRequisiteForEmployee($employee, $service),
        ]);
    }

    public function index(Request $request, MediclaimDependantListService $service)
    {
        $this->authorize('viewAny', MediclaimDependant::class);

        return $service->paginate($request);
    }
}
