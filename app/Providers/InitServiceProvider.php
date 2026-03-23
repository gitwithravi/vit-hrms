<?php

namespace App\Providers;

use App\Mixins\ArrMixin;
use App\Mixins\CarbonMixin;
use App\Mixins\CollectionMixin;
use App\Mixins\QueryMixin;
use App\Mixins\RequestMixin;
use App\Mixins\ResponseMixin;
use App\Mixins\StrMixin;
use App\Mixins\ViewMixin;
use App\Support\Site;
use App\ValueObjects\Cal;
use App\ValueObjects\Country;
use App\ValueObjects\Currency;
use App\ValueObjects\Percent;
use App\ValueObjects\Price;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionException;

class InitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('site', fn () => new Site);

        $this->app->bind('price', fn () => new Price);

        $this->app->bind('currency', fn () => new Currency);

        $this->app->bind('cal', fn () => new Cal);

        $this->app->bind('percent', fn () => new Percent);

        $this->app->bind('country', fn () => new Country);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws ReflectionException
     */
    public function boot(): void
    {
        Str::mixin(new StrMixin());
        Arr::mixin(new ArrMixin());
        Response::mixin(new ResponseMixin());
        Request::mixin(new RequestMixin());
        View::mixin(new ViewMixin());
        Collection::mixin(new CollectionMixin());
        Builder::mixin(new QueryMixin());
        //Carbon::mixin(new CarbonMixin());
    }
}
