<?php

namespace App\Services\Employee;

use App\Contracts\ListGenerator;
use App\Http\Resources\Employee\CategoryListResource;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeCategoryListService extends ListGenerator
{
    protected $allowedSorts = ['name', 'code_number', 'department', 'designation'];

    protected $defaultSort = 'code_number';

    protected $defaultOrder = 'asc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'codeNumber',
                'label' => trans('employee.props.code_number'),
                'print_label' => 'code_number',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'name',
                'label' => trans('employee.props.name'),
                'print_label' => 'name',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'department',
                'label' => trans('company.department.department'),
                'print_label' => 'department',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'designation',
                'label' => trans('company.designation.designation'),
                'print_label' => 'designation',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'categoryName',
                'label' => trans('employee.category.category'),
                'print_label' => 'category',
                'sortable' => true,
                'visibility' => true,
            ],
        ];

        if (request()->ajax()) {
            $headers[] = $this->actionHeader;
        }

        return $headers;
    }

    public function filter(Request $request): Builder
    {
        $search = $request->query('search');

        return Employee::query()
            //->summary()
            ->detail()
            ->filterAccessible()
            ->when($request->query('name'), function($q, $name) {
                $q->where(\DB::raw('REGEXP_REPLACE(CONCAT_WS(" ", first_name, middle_name, third_name, last_name), "[[:space:]]+", " ")'), 'like', "%$name%");
            })
            ->when($search, function($q, $search) {
                $q->where(function($q) use ($search) {
                    $q->where(\DB::raw('REGEXP_REPLACE(CONCAT_WS(" ", first_name, middle_name, third_name, last_name), "[[:space:]]+", " ")'), 'like', "%$search%")
                    ->orWhere('employees.code_number', 'like', "%$search%");
                });
            })
            ->filter([
                'App\QueryFilters\WhereInMatch:employees.uuid,uuid',
                'App\QueryFilters\WhereInMatch:departments.uuid,department',
                'App\QueryFilters\WhereInMatch:designations.uuid,designation',
                'App\QueryFilters\WhereInMatch:employee_category.id,category',
                'App\QueryFilters\WhereInMatch:options.uuid,employment_status',
                'App\QueryFilters\ExactMatch:code_number',
                'App\QueryFilters\DateBetween:joining_start_date,joining_end_date,joining_date',
                'App\QueryFilters\DateBetween:leaving_start_date,leaving_end_date,leaving_date',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection|array
    {
        $view = $request->query('view', 'card');
        $request->merge(['view' => $view]);

        $query = $this->filter($request);

        match ($this->getSort()) {
            'code_number' => $query->orderBy('code_number', $this->getOrder()),
            'name' => $query->orderBy('full_name', $this->getOrder()),
            'department' => $query->orderBy('departments.name', $this->getOrder()),
            'designation' => $query->orderBy('designations.name', $this->getOrder()),
        };

        try {
            $data = $query->paginate($this->getPageLength(), ['*'], 'current_page');
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }

        return CategoryListResource::collection($data)
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
