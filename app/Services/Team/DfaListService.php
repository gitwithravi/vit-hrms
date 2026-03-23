<?php

namespace App\Services\Team;

use App\Concerns\TeamAccessible;
use App\Contracts\ListGenerator;
use App\Http\Resources\UserSummaryResource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class DfaListService extends ListGenerator
{
    use TeamAccessible;

    protected $allowedSorts = ['email', 'name'];

    protected $defaultSort = 'name';

    protected $defaultOrder = 'asc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'name',
                'label' => trans('user.props.name'),
                'print_label' => 'label',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'email',
                'label' => trans('user.props.email'),
                'print_label' => 'email',
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
        return User::query()
            ->with('roles')
            ->whereRelation('roles', 'name', 'd-f-a')
            ->filter([
                'App\QueryFilters\LikeMatch:search,name',
                'App\QueryFilters\LikeMatch:search,username',
                'App\QueryFilters\LikeMatch:search,email',
            ]);
    }

    public function get(Request $request): AnonymousResourceCollection
    {
        try {
            $list = $this->filter($request)->orderBy($this->getSort(), $this->getOrder())->get();

            return UserSummaryResource::collection($list)->additional([
                'headers' => $this->getHeaders(),
                'meta' => [
                    'allowed_sorts' => $this->allowedSorts,
                    'default_sort' => $this->defaultSort,
                    'default_order' => $this->defaultOrder,
                ],
            ]);
        } catch (Throwable $th) {
            dd($th);
        }
    }

    public function getList(Request $request): AnonymousResourceCollection
    {
        return $this->get($request);
    }
}
