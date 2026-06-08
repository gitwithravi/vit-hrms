<?php

namespace App\Services\Employee;

use App\Contracts\ListGenerator;
use App\Http\Resources\Employee\MediclaimDependantResource;
use App\Models\Employee\MediclaimDependant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediclaimDependantListService extends ListGenerator
{
    protected $allowedSorts = ['created_at', 'updated_at'];

    protected $defaultSort = 'created_at';

    public function getHeaders(): array
    {
        return [
            [
                'key' => 'employeeCode',
                'label' => trans('employee.props.code_number'),
                'print_label' => 'employee.code_number',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'employeeName',
                'label' => trans('employee.props.name'),
                'print_label' => 'employee.name',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'department',
                'label' => trans('company.department.department'),
                'print_label' => 'employee.department',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'designation',
                'label' => trans('company.designation.designation'),
                'print_label' => 'employee.designation',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'name',
                'label' => trans('employee.mediclaim.props.name'),
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'relationship',
                'label' => trans('employee.mediclaim.props.relationship'),
                'print_label' => 'relationship_label',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'gender',
                'label' => trans('employee.mediclaim.props.gender'),
                'print_label' => 'gender_label',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'dob',
                'label' => trans('employee.mediclaim.props.dob'),
                'print_label' => 'dob.formatted',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'topUp',
                'label' => trans('employee.mediclaim.props.top_up'),
                'print_label' => 'top_up_label',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'createdAt',
                'label' => trans('general.created_at'),
                'print_label' => 'created_at.formatted',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'updatedAt',
                'label' => trans('general.updated_at'),
                'print_label' => 'updated_at.formatted',
                'sortable' => true,
                'visibility' => true,
            ],
        ];
    }

    public function filter(Request $request): Builder
    {
        return MediclaimDependant::query()
            ->with(['employee' => fn ($q) => $q->detail()])
            ->whereHas('employee', fn ($q) => $q->detail()->filterAccessible())
            ->filter([
                'App\QueryFilters\LikeMatch:name',
                'App\QueryFilters\ExactMatch:relationship',
                'App\QueryFilters\ExactMatch:gender',
                'App\QueryFilters\ExactMatch:top_up',
                'App\QueryFilters\DateBetween:created_at,created_at,created_at,created_at',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return MediclaimDependantResource::collection($this->filter($request)
            ->orderBy($this->getSort(), $this->getOrder())
            ->paginate((int) $this->getPageLength(), ['*'], 'current_page'))
            ->additional([
                'headers' => $this->getHeaders(),
                'meta' => [
                    'allowed_sorts' => $this->allowedSorts,
                    'default_sort' => $this->defaultSort,
                    'default_order' => $this->defaultOrder,
                ],
            ]);
    }

    public function list(Request $request): AnonymousResourceCollection
    {
        return $this->paginate($request);
    }
}
