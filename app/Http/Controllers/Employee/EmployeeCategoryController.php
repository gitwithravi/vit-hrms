<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\BulkAssignCategoryRequest;
use App\Http\Requests\Employee\EmployeeCategoryRequest;
use App\Http\Resources\Employee\EmployeeResource;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeCategory;
use App\Services\Employee\EmployeeCategoryListService;
use App\Services\Employee\EmployeeCategoryService;
use Illuminate\Http\Request;

class EmployeeCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function preRequisite(Request $request, EmployeeCategoryService $service)
    {
        $this->authorize('preRequisite', EmployeeCategory::class);

        return response()->ok($service->preRequisite($request));
    }

    public function index(Request $request, EmployeeCategoryListService $service)
    {
        $this->authorize('viewAny', EmployeeCategory::class);

        return $service->paginate($request);
    }

    public function bulkAssign(BulkAssignCategoryRequest $request, EmployeeCategoryService $service)
    {
        $this->authorize('update', EmployeeCategory::class);

        $count = $service->bulkAssignByDesignation($request);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('employee.employee-category')])." ({$count} employees)",
        ]);
    }

    public function update(EmployeeCategoryRequest $request, $employee, EmployeeCategoryService $service)
    {
        try {
            $employee = Employee::where('id', $employee)->firstOrFail();
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }

        $this->authorize('update', EmployeeCategory::class);


        $employee = $service->update($request, $employee);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('employee.employee-category')]),
            'employee' => EmployeeResource::make($employee),
        ]);
    }
}
